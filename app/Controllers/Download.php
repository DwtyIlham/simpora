<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Download extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function formatTanggalIndo($tanggal)
    {
        if (!$tanggal) return '';

        $bulan = [
            1 => 'JANUARI',
            2 => 'FEBRUARI',
            3 => 'MARET',
            4 => 'APRIL',
            5 => 'MEI',
            6 => 'JUNI',
            7 => 'JULI',
            8 => 'AGUSTUS',
            9 => 'SEPTEMBER',
            10 => 'OKTOBER',
            11 => 'NOVEMBER',
            12 => 'DESEMBER'
        ];

        $tgl = date('d', strtotime($tanggal));
        $bln = $bulan[(int)date('m', strtotime($tanggal))];
        $thn = date('Y', strtotime($tanggal));

        return "$tgl $bln $thn";
    }

    /**
     * Cabor yang ditugaskan ke validator yang sedang login.
     * Kosong untuk admin.
     */
    private function getAssignedCaborIds(): array
    {
        $user = session()->get('user') ?? [];

        if (($user['role_id'] ?? '') !== '4' || empty($user['id'])) {
            return [];
        }

        $rows = $this->db->table('users_validator')
            ->select('cabor_id')
            ->where('user_id', $user['id'])
            ->get()
            ->getResultArray();

        return array_values(array_filter(array_column($rows, 'cabor_id')));
    }

    /**
     * Menentukan cabor yang boleh diproses.
     * - admin: kosong = semua cabor
     * - validator: kosong = semua cabor yang ditugaskan, cabor lain ditolak
     *
     * @return array{ids: array, error: string|null}
     */
    private function resolveCaborScope(?string $caborId): array
    {
        $caborId  = trim((string) $caborId);
        $user     = session()->get('user') ?? [];
        $assigned = $this->getAssignedCaborIds();
        $isValidator = ($user['role_id'] ?? '') === '4';

        if ($isValidator) {
            if (empty($assigned)) {
                return ['ids' => [], 'error' => 'Akun validator ini belum memiliki cabang olahraga.'];
            }

            if ($caborId !== '' && !in_array($caborId, $assigned, true)) {
                return ['ids' => [], 'error' => 'Anda tidak memiliki akses ke cabang olahraga tersebut.'];
            }

            return ['ids' => $caborId !== '' ? [$caborId] : $assigned, 'error' => null];
        }

        return ['ids' => $caborId !== '' ? [$caborId] : [], 'error' => null];
    }

    private function getCaborNames(array $caborIds): string
    {
        if (empty($caborIds)) {
            return 'SEMUA CABOR';
        }

        $names = $this->db->table('cabor')
            ->select('nama')
            ->whereIn('id', $caborIds)
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResultArray();

        return implode(', ', array_column($names, 'nama'));
    }

    private function getPenanggungJawab(array $caborIds): string
    {
        // Rekap semua cabor tidak perlu menampilkan seluruh nama validator.
        if (empty($caborIds)) {
            return 'PANITIA';
        }

        $builder = $this->db->table('users u')
            ->select('u.nama')
            ->distinct()
            ->join('users_validator uv', 'uv.user_id = u.id');

        if (!empty($caborIds)) {
            $builder->whereIn('uv.cabor_id', $caborIds);
        }

        $names = array_column($builder->get()->getResultArray(), 'nama');

        if (!empty($names)) {
            return implode(', ', $names);
        }

        $user = session()->get('user') ?? [];

        return $user['nama'] ?? '';
    }

    private function applyCaborScope($builder, array $caborIds, string $column = 'a.cabor_id')
    {
        if (!empty($caborIds)) {
            $builder->whereIn($column, $caborIds);
        }

        return $builder;
    }

    /**
     * Ringkasan untuk kartu statistik halaman rekap. $caborIds kosong = semua cabor.
     * Angkanya berupa jumlah BARIS rekap (satu atlet bisa 2-3 baris karena nomor cabor),
     * sama dengan isi tabel hasil rekap.
     */
    public function rekapSummary(array $caborIds = []): array
    {
        return $this->getRekapCounts($caborIds);
    }

    /**
     * Hitung jumlah baris rekap (satu atlet bisa lebih dari 1 baris karena
     * punya beberapa nomor cabor) per status verifikasi untuk kartu statistik
     * di halaman rekap. Urutan/join-nya sama dengan query preview() supaya
     * total di kartu selalu sama dengan jumlah baris tabel hasil rekap.
     */
    private function getRekapCounts(array $caborIds = []): array
    {
        $builder = $this->db->table('atlet a')
            ->select('
                a.id,
                a.nomor_cabor_1, a.nomor_cabor_2, a.nomor_cabor_3,
                s.bentuk_pendidikan,
                av.akte_status, av.foto_status, av.ijazah_status,
                av.ktp_kia_kk_status, av.nisn_status, av.suket_status
            ')
            ->join('sekolah s', 's.id = a.sekolah_id')
            ->join('atlet_validasi av', 'av.atlet_id = a.id', 'left');

        if (! empty($caborIds)) {
            $builder->whereIn('a.cabor_id', $caborIds);
        }

        // Nomor cabor harus milik cabor atlet itu sendiri (sama dengan preview()).
        $builder->join('nomor_cabor nc1', 'nc1.id = a.nomor_cabor_1 AND nc1.cabor_id = a.cabor_id', 'left')
            ->join('nomor_cabor nc2', 'nc2.id = a.nomor_cabor_2 AND nc2.cabor_id = a.cabor_id', 'left')
            ->join('nomor_cabor nc3', 'nc3.id = a.nomor_cabor_3 AND nc3.cabor_id = a.cabor_id', 'left')
            ->groupBy('a.id');

        $counts = [
            'total'       => 0,
            'lengkap'     => 0,
            'pending'     => 0,
            'invalid'     => 0,
            'belum_dicek' => 0,
        ];

        foreach ($builder->get()->getResultArray() as $row) {
            $jumlahBaris = count($this->uniqueNomorFields($row)) ?: 1;
            $status      = $this->statusFromDocs($row, (string) ($row['bentuk_pendidikan'] ?? ''));

            $counts['total'] += $jumlahBaris;

            $key = [
                'Lengkap'       => 'lengkap',
                'Belum Lengkap' => 'pending',
                'Tidak Valid'   => 'invalid',
                'Belum Dicek'   => 'belum_dicek',
            ][$status] ?? 'pending';

            $counts[$key] += $jumlahBaris;
        }

        return $counts;
    }

    /**
     * Jumlah nomor cabor valid (yang masih ada di tabel nomor_cabor dan
     * memang milik cabor atlet) untuk satu baris data atlet.
     */
    private function countValidNomor(array $row): int
    {
        return count($this->uniqueNomorFields($row));
    }

    /**
     * Ambil nomor cabor atlet tanpa duplikat.
     * Nomor yang sama bisa tersimpan di lebih dari satu kolom (mis. nomor_cabor_1
     * dan nomor_cabor_2 berisi nomor yang sama) — itu dulu membuat atlet muncul
     * dua kali di hasil rekap.
     */
    private function uniqueNomorFields(array $row): array
    {
        $unik = [];

        foreach (['nomor_cabor_1', 'nomor_cabor_2', 'nomor_cabor_3'] as $field) {
            $nilai = $row[$field] ?? null;

            if ($nilai === null) {
                continue;
            }

            $nilai = trim((string) $nilai);

            // nilai kosong / '0' berarti tidak ada nomor.
            if ($nilai === '' || $nilai === '0') {
                continue;
            }

            if (! in_array($nilai, $unik, true)) {
                $unik[] = $nilai;
            }
        }

        return $unik;
    }

    /**
     * Status verifikasi dari status dokumen (sama persis dengan preview()).
     */
    private function statusFromDocs(array $row, string $bentukPendidikan): string
    {
        $bentuk = strtoupper(trim($bentukPendidikan));

        $requiredDocs = [
            'akte_status',
            'foto_status',
            'ktp_kia_kk_status',
            'nisn_status',
            'suket_status',
        ];

        if (! in_array($bentuk, ['SD', 'MI'], true)) {
            $requiredDocs[] = 'ijazah_status';
        }

        $hasInvalid  = false;
        $hasPending  = false;
        $hasDecision = false;
        $allValid    = true;

        foreach ($requiredDocs as $doc) {
            $value = strtolower(trim((string) ($row[$doc] ?? '')));

            if ($value === 'valid' || $value === 'invalid') {
                $hasDecision = true;
            }

            if ($value === 'invalid') {
                $hasInvalid = true;
                $allValid = false;
                break;
            }

            if ($value === 'pending' || $value === '') {
                $hasPending = true;
                $allValid = false;
            }

            if (! in_array($value, ['valid', 'pending', 'invalid'], true)) {
                $allValid = false;
            }
        }

        if ($hasInvalid) {
            return 'Tidak Valid';
        }

        if ($hasPending) {
            return 'Belum Lengkap';
        }

        if ($allValid || ! $hasDecision) {
            return 'Lengkap';
        }

        return 'Belum Dicek';
    }

    /**
     * Halaman rekap hanya untuk admin dan validator.
     */
    private function guardRekapAccess(): ?\CodeIgniter\HTTP\ResponseInterface
    {
        $user   = session()->get('user') ?? [];
        $roleId = (string) ($user['role_id'] ?? '');

        if (in_array($roleId, ['1', '4'], true)) {
            return null;
        }

        return $this->response->setStatusCode(403)->setJSON([
            'status'  => 'error',
            'message' => 'Akses ditolak. Halaman rekap hanya untuk admin dan validator.',
        ]);
    }

    private function guardValidatorScope(): void
    {
        $user = session()->get('user') ?? [];

        if (($user['role_id'] ?? '') === '4' && empty($this->getAssignedCaborIds())) {
            exit('Akun validator ini belum memiliki cabang olahraga.');
        }
    }

    private function matchesStatusFilter(string $verifikasi, string $status): bool
    {
        if ($status === '') {
            return true;
        }

        $map = [
            'valid'     => 'Lengkap',
            'pending'   => 'Belum Lengkap',
            'invalid'   => 'Tidak Valid',
            'unchecked' => 'Belum Dicek',
        ];

        return isset($map[$status]) && $verifikasi === $map[$status];
    }

    /**
     * Batas jumlah baris per halaman pada hasil rekap (mencegah data terpotong oleh
     * batas waktu eksekusi PHP ketika rekap seluruh cabor di-generate sekaligus).
     */
    private const PREVIEW_PAGE_SIZE = 200;

    public function preview()
    {
        if ($guard = $this->guardRekapAccess()) {
            return $guard;
        }

        $request = service('request');

        $cabor_id   = trim((string) $request->getPost('cabor_id'));
        $jenjang_id = $request->getPost('jenjang_id');
        $status     = (string) ($request->getPost('status') ?? '');
        $searchNama = trim((string) $request->getPost('search_nama'));
        $page       = max(1, (int) ($request->getPost('page') ?? 1));

        $scope = $this->resolveCaborScope($cabor_id);

        if ($scope['error'] !== null) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $scope['error'],
            ]);
        }

        $caborIds = $scope['ids'];

        // =========================
        // QUERY
        // =========================
        $builder = $this->db->table('atlet a');

        $builder->select("
            a.*,
            s.nama AS sekolah,
            s.bentuk_pendidikan,

            av.akte_status,
            av.foto_status,
            av.ijazah_status,
            av.ktp_kia_kk_status,
            av.nisn_status,
            av.suket_status,

            c.nama AS cabor
        ");

        $builder->join('sekolah s', 's.id = a.sekolah_id');
        $builder->join('cabor c', 'c.id = a.cabor_id');
        $builder->join('atlet_validasi av', 'av.atlet_id = a.id', 'left');

        $this->applyCaborScope($builder, $caborIds);

        if ($searchNama !== '') {
            $builder->like('a.nama', $searchNama);
        }

        $builder->orderBy('a.nama ASC, sekolah ASC');

        $rows = $builder->get()->getResultArray();

        // =========================
        // MAP NOMOR
        // =========================
        $nomorList = $this->db->table('nomor_cabor nc')
            ->select('nc.id, nc.nama, nc.jenjang_id, nc.detail, nc.jenis, nc.kategori, j.nama as jenjang')
            ->join('jenjang j', 'j.id = nc.jenjang_id', 'left')
            ->get()
            ->getResultArray();

        $mapNomor = [];
        $mapJenjang = [];
        $mapJenjangId = [];
        $mapDetail = [];
        $mapJenis = [];
        $mapKategori = [];

        foreach ($nomorList as $n) {
            $mapNomor[$n['id']] = $n['nama'];
            $mapJenjang[$n['id']] = $n['jenjang'];
            $mapJenjangId[$n['id']] = $n['jenjang_id'];
            $mapDetail[$n['id']] = $n['detail'] ?? '';
            $mapJenis[$n['id']] = $n['jenis'] ?? '';
            $mapKategori[$n['id']] = $n['kategori'] ?? '';
        }

        // =========================
        // PROSES DATA
        // =========================
        $data = [];
        $no = 1;

        $total = 0;
        $lengkap = 0;
        $belum = 0;
        $tidakValid = 0;
        $belumDicek = 0;

        $jenis_dok = [
            'akte_status',
            'foto_status',
            'ktp_kia_kk_status',
            'nisn_status',
            'ijazah_status',
            'suket_status'
        ];

        foreach ($rows as $r) {

            $nomorFields = $this->uniqueNomorFields($r);

            // Atlet tanpa nomor cabor tetap ditampilkan pada rekap seluruh data.
            if (empty($nomorFields)) {
                $nomorFields = [null];
            }

            foreach ($nomorFields as $nc_id) {

                $nama_nomor = '';
                $jenjang = '';
                $jenjang_current_id = null;
                $detail = '';
                $jenis = '';
                $kategori = '';

                if (!empty($nc_id)) {
                    // Nomor cabor yang sudah dihapus tidak dihitung sebagai baris rekap.
                    if (!array_key_exists($nc_id, $mapNomor)) {
                        continue;
                    }

                    $nama_nomor = $mapNomor[$nc_id] ?? '';
                    $jenjang  = $mapJenjang[$nc_id] ?? '';
                    $jenjang_current_id = $mapJenjangId[$nc_id] ?? null;
                    $detail   = $mapDetail[$nc_id] ?? '';
                    $jenis   = $mapJenis[$nc_id] ?? '';
                    $kategori  = $mapKategori[$nc_id] ?? '';
                }

                // FILTER JENJANG
                if (!empty($jenjang_id) && $jenjang_current_id != $jenjang_id) {
                    continue;
                }

                // ======================
                // VALIDASI DOKUMEN
                // ======================

                $bentuk = strtoupper(trim($r['bentuk_pendidikan'] ?? ''));

                $isSdMi = in_array($bentuk, ['SD', 'MI']);
                $isIjazahRequired = !$isSdMi;

                $requiredDocs = [
                    'akte_status',
                    'foto_status',
                    'ktp_kia_kk_status',
                    'nisn_status',
                    'suket_status'
                ];

                // ijazah hanya untuk non SD/MI
                if ($isIjazahRequired) {
                    $requiredDocs[] = 'ijazah_status';
                }

                $hasInvalid = false;
                $hasPending = false;
                $hasDecision = false;
                $allValid = true;

                foreach ($requiredDocs as $doc) {

                    $value = strtolower(trim($r[$doc] ?? ''));

                    if ($value === 'valid' || $value === 'invalid') {
                        $hasDecision = true;
                    }

                    if ($value === 'invalid') {
                        $hasInvalid = true;
                        $allValid = false;
                        break; // langsung stop, sudah tidak perlu lanjut
                    }

                    if ($value === 'pending') {
                        $hasPending = true;
                        $allValid = false;
                    }

                    if ($value === '' || $value === null) {
                        $hasPending = true; // kosong = belum lengkap
                        $allValid = false;
                    }

                    if ($value !== 'valid' && $value !== 'pending' && $value !== 'invalid') {
                        $allValid = false;
                    }
                }

                // hasil akhir
                if ($hasInvalid) {
                    $verifikasi = 'Tidak Valid';
                } elseif ($hasPending) {
                    $verifikasi = 'Belum Lengkap';
                } elseif ($allValid || ! $hasDecision) {
                    $verifikasi = 'Lengkap';
                } else {
                    $verifikasi = 'Belum Dicek';
                }

                // FILTER STATUS (data tabel memakai filter ini, jadi hitungan pill juga)
                if (!$this->matchesStatusFilter($verifikasi, $status)) {
                    continue;
                }

                // HITUNG (hanya baris yang lolos filter, sama dengan isi tabel)
                $total++;
                if ($verifikasi === 'Lengkap') {
                    $lengkap++;
                } elseif ($verifikasi === 'Tidak Valid') {
                    $tidakValid++;
                } elseif ($verifikasi === 'Belum Dicek') {
                    $belumDicek++;
                } else {
                    $belum++;
                }

                // TTL
                $ttl = strtoupper(
                    ($r['tempat_lahir'] ?? '') . ', ' . $this->formatTanggalIndo($r['tanggal_lahir'] ?? null)
                );

                $data[] = [
                    'no'     => $no++,
                    'nama'    => $r['nama'],
                    'jk'     => $r['jenis_kelamin'],
                    'ttl'    => $ttl,
                    'sekolah'  => $r['sekolah'],
                    'cabor'   => $r['cabor'],
                    'nomor'   => $nama_nomor,
                    'detail'   => $detail,
                    'jenis'   => $jenis,
                    'kategori'  => $kategori,
                    'jenjang'  => $jenjang,
                    'verifikasi' => $verifikasi
                ];
            }
        }

        // Definisikan urutan jenjang secara manual
        $priorityJenjang = [
            'USIA DINI' => 1,
            'PRA REMAJA' => 2,
            'REMAJA'   => 3,
            'DEWASA'   => 4
        ];

        // 2. Proses SORTING
        usort($data, function ($a, $b) use ($priorityJenjang) {
            // PRIORITAS 1: Jenjang (Usia Dini -> Remaja)
            $prioA = $priorityJenjang[strtoupper($a['jenjang'])] ?? 99;
            $prioB = $priorityJenjang[strtoupper($b['jenjang'])] ?? 99;

            if ($prioA !== $prioB) {
                return $prioA <=> $prioB;
            }

            // PRIORITAS 2: Nomor (A-Z)
            $resNomor = strnatcasecmp($a['nomor'], $b['nomor']);
            if ($resNomor !== 0) {
                return $resNomor;
            }

            // PRIORITAS 3: Nama Sekolah (A-Z)
            return strnatcasecmp($a['sekolah'], $b['sekolah']);
        });

        // 3. Reset nomor urut setelah data rapi
        foreach ($data as $index => $item) {
            $data[$index]['no'] = $index + 1;
        }

        // META
        $cabor_nama = $this->getCaborNames($caborIds);
        $penanggung_jawab = $this->getPenanggungJawab($caborIds);
        $jenjang_nama = '';

        if (!empty($jenjang_id)) {
            $jenjang_nama = $this->db->table('jenjang')
                ->where('id', $jenjang_id)
                ->get()
                ->getRow('nama') ?? '';
        }

        return $this->response->setJSON([
            'status' => 'success',
            'meta' => [
                'cabor' => strtoupper($cabor_nama),
                'jenjang' => strtoupper($jenjang_nama),
                'penanggung_jawab' => strtoupper($penanggung_jawab),
                'total' => $total,
                'lengkap' => $lengkap,
                'belum' => $belum,
                'tidak_valid' => $tidakValid,
                'belum_dicek' => $belumDicek,
                'page' => $page,
                'page_size' => self::PREVIEW_PAGE_SIZE,
                'total_pages' => max(1, (int) ceil($total / self::PREVIEW_PAGE_SIZE)),
            ],
            'data' => array_slice($data, ($page - 1) * self::PREVIEW_PAGE_SIZE, self::PREVIEW_PAGE_SIZE)
        ]);
    }

    public function rekap_atlet_file()
    {
        if ($guard = $this->guardRekapAccess()) {
            return $guard;
        }

        $request = service('request');

        $cabor_id   = trim((string) $request->getPost('cabor_id'));
        $jenjang_id = $request->getPost('jenjang_id');
        $status     = (string) ($request->getPost('status') ?? '');

        // 1. TAMBAHAN TANGKAP FILTER BARU
        $search_nama = trim((string) $request->getPost('search_nama'));
        $jk          = $request->getPost('jk'); // Misal: 'L' atau 'P'

        $scope = $this->resolveCaborScope($cabor_id);

        if ($scope['error'] !== null) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $scope['error'],
            ]);
        }

        $caborIds = $scope['ids'];

        // =========================
        // QUERY BUILDER
        // =========================
        $builder = $this->db->table('atlet a');

        $builder->select("
            a.*,
            s.nama AS sekolah,
            s.bentuk_pendidikan,

            av.akte_status,
            av.foto_status,
            av.ijazah_status,
            av.ktp_kia_kk_status,
            av.nisn_status,
            av.suket_status,

            c.nama AS cabor,
            MIN(p.prestasi) AS prestasi
        ");

        $builder->join('sekolah s', 's.id = a.sekolah_id');
        $builder->join('cabor c', 'c.id = a.cabor_id');
        $builder->join('atlet_validasi av', 'av.atlet_id = a.id', 'left');

        // 2. INNER JOIN PRESTASI (Otomatis HANYA mengambil yang punya prestasi)
        $builder->join('prestasi p', 'p.atlet_id = a.id');

        $this->applyCaborScope($builder, $caborIds);
        $builder->orderBy('a.nama ASC');

        // 3. APPLY FILTER PENCARIAN & JENIS KELAMIN
        if ($search_nama !== '') {
            $builder->like('a.nama', $search_nama);
        }
        if (!empty($jk)) {
            $builder->where('a.jenis_kelamin', $jk);
        }

        // Group By untuk menghindari data atlet terduplikat jika ia menang di 2 nomor berbeda
        $builder->groupBy('a.id');

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $rows = $builder->get()->getResultArray();

        // =========================
        // MAP NOMOR
        // =========================
        $nomorList = $this->db->table('nomor_cabor nc')
            ->select('nc.id, nc.nama, nc.jenjang_id, nc.detail, nc.jenis, nc.kategori, j.nama as jenjang')
            ->join('jenjang j', 'j.id = nc.jenjang_id', 'left')
            ->get()
            ->getResultArray();

        $mapNomor = [];
        $mapJenjang = [];
        $mapJenjangId = [];
        $mapDetail = [];
        $mapJenis = [];
        $mapKategori = [];

        foreach ($nomorList as $n) {
            $mapNomor[$n['id']] = $n['nama'];
            $mapJenjang[$n['id']] = $n['jenjang'];
            $mapJenjangId[$n['id']] = $n['jenjang_id'];
            $mapDetail[$n['id']] = $n['detail'] ?? '';
            $mapJenis[$n['id']] = $n['jenis'] ?? '';
            $mapKategori[$n['id']] = $n['kategori'] ?? '';
        }

        // =========================
        // PROSES DATA
        // =========================
        $data = [];
        $no = 1;
        $total = 0;
        $lengkap = 0;
        $belum = 0;
        $tidakValid = 0;
        $belumDicek = 0;

        foreach ($rows as $r) {
            $nomorFields = $this->uniqueNomorFields($r);

            foreach ($nomorFields as $nc_id) {

                // Nomor cabor yang sudah dihapus tidak dihitung sebagai baris rekap.
                if (!array_key_exists($nc_id, $mapNomor)) continue;

                $nama_nomor = $mapNomor[$nc_id] ?? '';
                $jenjang    = $mapJenjang[$nc_id] ?? '';
                $jenjang_current_id = $mapJenjangId[$nc_id] ?? null;
                $detail     = $mapDetail[$nc_id] ?? '';
                $jenis      = $mapJenis[$nc_id] ?? '';
                $kategori   = $mapKategori[$nc_id] ?? '';

                // FILTER JENJANG
                if (!empty($jenjang_id) && $jenjang_current_id != $jenjang_id) {
                    continue;
                }

                // ======================
                // VALIDASI DOKUMEN
                // ======================
                $bentuk = strtoupper(trim($r['bentuk_pendidikan'] ?? ''));
                $isSdMi = in_array($bentuk, ['SD', 'MI']);
                $isIjazahRequired = !$isSdMi;

                $requiredDocs = [
                    'akte_status',
                    'foto_status',
                    'ktp_kia_kk_status',
                    'nisn_status',
                    'suket_status'
                ];

                if ($isIjazahRequired) {
                    $requiredDocs[] = 'ijazah_status';
                }

                $hasInvalid = false;
                $hasPending = false;
                $hasDecision = false;
                $allValid = true;

                foreach ($requiredDocs as $doc) {
                    $value = strtolower(trim($r[$doc] ?? ''));

                    if ($value === 'valid' || $value === 'invalid') {
                        $hasDecision = true;
                    }

                    if ($value === 'invalid') {
                        $hasInvalid = true;
                        $allValid = false;
                        break;
                    }
                    if ($value === 'pending' || $value === '' || $value === null) {
                        $hasPending = true;
                        $allValid = false;
                    }
                    if ($value !== 'valid' && $value !== 'pending' && $value !== 'invalid') {
                        $allValid = false;
                    }
                }

                if ($hasInvalid) {
                    $verifikasi = 'Tidak Valid';
                } elseif ($hasPending) {
                    $verifikasi = 'Belum Lengkap';
                } elseif ($allValid || ! $hasDecision) {
                    $verifikasi = 'Lengkap';
                } else {
                    $verifikasi = 'Belum Dicek';
                }

                // FILTER STATUS
                if (!$this->matchesStatusFilter($verifikasi, $status)) {
                    continue;
                }

                // TTL
                $ttl = strtoupper(
                    ($r['tempat_lahir'] ?? '') . ', ' . $this->formatTanggalIndo($r['tanggal_lahir'] ?? null)
                );

                $data[] = [
                    'id'         => $r['id'], // WAJIB untuk value checkbox ZIP
                    'prestasi'   => $r['prestasi'], // Disimpan untuk prioritas sorting
                    'no'         => $no++,
                    'nama'       => $r['nama'],
                    'jk'         => $r['jenis_kelamin'],
                    'ttl'        => $ttl,
                    'sekolah'    => $r['sekolah'],
                    'cabor'      => $r['cabor'],
                    'nomor'      => $nama_nomor,
                    'detail'     => $detail,
                    'jenis'      => $jenis,
                    'kategori'   => $kategori,
                    'jenjang'    => $jenjang,
                    'verifikasi' => $verifikasi
                ];

                $total++;
                if ($verifikasi === 'Lengkap') {
                    $lengkap++;
                } elseif ($verifikasi === 'Tidak Valid') {
                    $tidakValid++;
                } elseif ($verifikasi === 'Belum Dicek') {
                    $belumDicek++;
                } else {
                    $belum++;
                }
            }
        }

        $priorityJenjang = [
            'USIA DINI'  => 1,
            'PRA REMAJA' => 2,
            'REMAJA'     => 3,
            'DEWASA'     => 4
        ];

        // 4. Proses SORTING (Di-update dengan Prestasi)
        usort($data, function ($a, $b) use ($priorityJenjang) {
            // PRIORITAS 1: PRESTASI (Emas=1 -> Perak=2 -> Perunggu=3)
            if ($a['prestasi'] !== $b['prestasi']) {
                return $a['prestasi'] <=> $b['prestasi'];
            }

            // PRIORITAS 2: Jenjang (Usia Dini -> Remaja)
            $prioA = $priorityJenjang[strtoupper($a['jenjang'])] ?? 99;
            $prioB = $priorityJenjang[strtoupper($b['jenjang'])] ?? 99;
            if ($prioA !== $prioB) {
                return $prioA <=> $prioB;
            }

            // PRIORITAS 3: Nomor (A-Z)
            $resNomor = strnatcasecmp($a['nomor'], $b['nomor']);
            if ($resNomor !== 0) {
                return $resNomor;
            }

            // PRIORITAS 4: Nama Sekolah (A-Z)
            return strnatcasecmp($a['sekolah'], $b['sekolah']);
        });

        // Reset nomor urut setelah data rapi
        foreach ($data as $index => $item) {
            $data[$index]['no'] = $index + 1;
        }

        $cabor_nama = $this->getCaborNames($caborIds);
        $penanggung_jawab = $this->getPenanggungJawab($caborIds);
        $jenjang_nama = '';

        if (!empty($jenjang_id)) {
            $jenjang_nama = $this->db->table('jenjang')->where('id', $jenjang_id)->get()->getRow('nama') ?? '';
        }

        return $this->response->setJSON([
            'status' => 'success',
            'meta' => [
                'cabor' => strtoupper($cabor_nama),
                'jenjang' => strtoupper($jenjang_nama),
                'penanggung_jawab' => strtoupper($penanggung_jawab),
                'total' => $total,
                'lengkap' => $lengkap,
                'belum' => $belum,
                'tidak_valid' => $tidakValid,
                'belum_dicek' => $belumDicek,
            ],
            'data' => $data
        ]);
    }

    public function datadiriExcel()
    {
        if ($guard = $this->guardRekapAccess()) {
            return $guard;
        }

        $atlet_ids_str = $this->request->getPost('atlet_ids');

        if (empty($atlet_ids_str)) {
            die('Tidak ada data atlet yang dikirim.');
        }

        $atlet_ids = array_values(array_filter(array_map('trim', explode(',', (string) $atlet_ids_str))));

        $this->guardValidatorScope();

        $atlets = $this->db->table('atlet a')
            ->select('
                a.*, 
                c.nama as nama_cabor,
                s.bentuk_pendidikan
            ')
            ->join('cabor c', 'c.id = a.cabor_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->whereIn('a.id', $atlet_ids);

        $this->applyCaborScope($atlets, $this->getAssignedCaborIds());

        $atlets = $atlets->get()->getResultArray();

        if (empty($atlets)) {
            die('Tidak ada data atlet yang dapat diunduh.');
        }

        // Format nama file
        $filename = "Data_Diri_Kontingen_" . date('Ymd_His') . ".xls";

        // Memaksa browser mengunduh sebagai file Excel
        header("Content-Type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Format Output ke dalam Tabel HTML (Excel akan membacanya secara otomatis)
        // Kita gunakan styling mso-number-format:\@; pada style CSS agar kolom NIK dan NISN dibaca sebagai Text murni
        echo '<table border="1">';
        echo '<tr>
                <th style="background-color:#ffff00;">NO</th>
                <th style="background-color:#ffff00;">NIK</th>
                <th style="background-color:#ffff00;">NISN</th>
                <th style="background-color:#ffff00;">NAMA LENGKAP</th>
                <th style="background-color:#ffff00;">TINGKAT SEKOLAH</th>
                <th style="background-color:#ffff00;">JENIS KELAMIN</th>
                <th style="background-color:#ffff00;">CABANG OLAHRAGA</th>
                <th style="background-color:#ffff00;">TEMPAT LAHIR</th>
                <th style="background-color:#ffff00;">TANGGAL LAHIR</th>
                <th style="background-color:#ffff00;">ALAMAT</th>
              </tr>';

        $no = 1;
        foreach ($atlets as $row) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';

            // Format NIK & NISN agar tetap menjadi Text di Excel
            echo '<td style="mso-number-format:\'\@\';">' . ($row['nik'] ?? '') . '</td>';
            echo '<td style="mso-number-format:\'\@\';">' . ($row['nisn'] ?? '') . '</td>';

            echo '<td>' . strtoupper($row['nama'] ?? '') . '</td>';
            echo '<td>' . strtoupper($row['bentuk_pendidikan'] ?? '') . '</td>';
            echo '<td align="center">' . strtoupper($row['jenis_kelamin'] ?? '') . '</td>';
            echo '<td>' . strtoupper($row['nama_cabor'] ?? '') . '</td>';
            echo '<td>' . strtoupper($row['tempat_lahir'] ?? '') . '</td>';

            // Opsional: Jika ingin format tanggal jadi DD-MM-YYYY, kamu bisa tambahkan fungsi format tanggalmu di sini. 
            // Secara default akan mencetak format bawaan database (YYYY-MM-DD).
            echo '<td>' . ($row['tanggal_lahir'] ?? '') . '</td>';

            echo '<td>' . ($row['alamat'] ?? '') . '</td>';
            echo '</tr>';
        }
        echo '</table>';

        exit;
    }

    public function berkasZip()
    {
        if ($guard = $this->guardRekapAccess()) {
            return $guard;
        }

        // 1. Amankan memori dan waktu eksekusi agar server tidak crash
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $atlet_ids_str = $this->request->getPost('atlet_ids');

        if (empty($atlet_ids_str)) {
            die('Tidak ada atlet yang dipilih untuk diunduh.');
        }

        // Pecah string "1,2,5,10" menjadi array [1, 2, 5, 10]
        $atlet_ids = array_values(array_filter(array_map('trim', explode(',', (string) $atlet_ids_str))));

        $this->guardValidatorScope();

        // =========================
        // QUERY AMBIL DATA & NAMA FILE
        // =========================
        $builder = $this->db->table('atlet a')
            ->select("
                a.id, 
                a.nama, 
                s.nama AS sekolah,
                a.file_foto, 
                a.file_akte, 
                a.file_ktp_kia_kk, 
                a.file_ijazah, 
                a.file_nisn, 
                a.file_suket
            ")
            ->join('sekolah s', 's.id = a.sekolah_id')
            ->join('atlet_validasi av', 'av.atlet_id = a.id', 'left')
            ->whereIn('a.id', $atlet_ids);

        $this->applyCaborScope($builder, $this->getAssignedCaborIds());

        $atlets = $builder->get()->getResultArray();

        if (empty($atlets)) {
            die('Tidak ada atlet yang sesuai dengan pilihan Anda.');
        }

        // =========================
        // KONFIGURASI FILE FISIK
        // =========================
        // SESUAIKAN INI: Path ke folder tempat file asli atlet disimpan
        $uploadDir = FCPATH . 'uploads/atlet/';

        // Pemetaan: [Nama Kolom di DB] => [Nama Baru untuk ZIP]
        $fileColumns = [
            'file_foto'   => 'FOTO',
            'file_akte'   => 'AKTE',
            'file_ktp_kia_kk'     => 'KTP_KIA_KK',
            'file_ijazah' => 'IJAZAH',
            'file_nisn'   => 'NISN',
            'file_suket'  => 'SUKET'
        ];

        // =========================
        // INISIALISASI ZIP ARCHIVE
        // =========================
        $zip = new \ZipArchive();
        $zipFileName = 'Berkas_Atlet_' . date('Ymd_His') . '.zip';
        $zipFilePath = WRITEPATH . 'uploads/' . $zipFileName; // Simpan sementara di folder writable CI4

        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            die("Gagal membuat file ZIP di server.");
        }

        // =========================
        // PROSES PACKING FILE
        // =========================
        foreach ($atlets as $atlet) {
            // Bersihkan nama atlet dan sekolah dari karakter aneh (slash dll) agar tidak error saat jadi folder
            $cleanNama    = preg_replace('/[^A-Za-z0-9 \-]/', '', $atlet['nama']);
            $cleanSekolah = preg_replace('/[^A-Za-z0-9 \-]/', '', $atlet['sekolah']);

            // Buat nama folder untuk anak ini
            $folderName = strtoupper($cleanNama) . ' - ' . strtoupper($cleanSekolah);

            // Tambahkan folder kosong ke dalam ZIP
            $zip->addEmptyDir($folderName);

            // Cek dan masukkan setiap file
            foreach ($fileColumns as $columnName => $newFileName) {
                $originalFileName = $atlet[$columnName];

                if (!empty($originalFileName)) {
                    $physicalPath = $uploadDir . $columnName . '/' . $originalFileName;

                    // Pastikan file fisiknya benar-benar ada di server
                    if (file_exists($physicalPath)) {
                        // Ambil ekstensi aslinya (misal: .jpg, .pdf)
                        $ext = pathinfo($originalFileName, PATHINFO_EXTENSION);

                        // Rangkai path di dalam ZIP (Nama Folder / NAMA_BARU.ext)
                        // Contoh: "BUDI - SMAN 1 / AKTE.pdf"
                        $zipInternalPath = $folderName . '/' . $newFileName . '.' . $ext;

                        // Masukkan ke ZIP
                        $zip->addFile($physicalPath, $zipInternalPath);
                    }
                }
            }
        }

        $zip->close();

        // Pastikan tidak ada karakter tersembunyi yang merusak file ZIP
        if (ob_get_length() > 0) {
            ob_clean();
        }

        // =========================
        // PAKSA DOWNLOAD (FORCE STREAM)
        // =========================
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zipFileName);
        header('Content-Length: ' . filesize($zipFilePath));
        readfile($zipFilePath);

        // Hapus file ZIP sementara dari server setelah berhasil diunduh agar tidak menumpuk
        unlink($zipFilePath);
        exit;
    }

    public function excel()
    {
        if ($guard = $this->guardRekapAccess()) {
            return $guard;
        }

        $cabor_id  = $this->request->getGet('cabor_id');
        $jenjang_id = $this->request->getGet('jenjang_id');
        $status   = $this->request->getGet('status');
        $searchNama = $this->request->getGet('search_nama');

        // inject ke preview (biar reuse logic)
        $this->request->setGlobal('post', [
            'cabor_id' => $cabor_id,
            'jenjang_id' => $jenjang_id,
            'status' => $status,
            'search_nama' => $searchNama,
            'page' => 1,
        ]);

        $preview = json_decode($this->preview()->getBody(), true);

        if ($preview['status'] !== 'success') {
            return redirect()->back()->with('error', 'Gagal generate data');
        }

        $meta = $preview['meta'];
        $data = $preview['data'];

        // Excel harus memuat seluruh data, bukan hanya satu halaman preview.
        for ($page = 2; $page <= ($meta['total_pages'] ?? 1); $page++) {
            $this->request->setGlobal('post', [
                'cabor_id' => $cabor_id,
                'jenjang_id' => $jenjang_id,
                'status' => $status,
                'search_nama' => $searchNama,
                'page' => $page,
            ]);

            $next = json_decode($this->preview()->getBody(), true);
            if (($next['status'] ?? '') !== 'success') {
                break;
            }

            $data = array_merge($data, $next['data']);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // =========================
        // HEADER
        // =========================
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'REKAPITULASI PENDAFTARAN POPDA');

        $sheet->mergeCells('A2:H2');

        // kalau filter jenjang ada
        if (!empty($meta['jenjang']) && $meta['jenjang'] != '') {
            $sheet->setCellValue('A2', 'JENJANG ' . strtoupper($meta['jenjang']));
        } else {
            $sheet->setCellValue('A2', 'SEMUA JENJANG');
        }

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'TAHUN ' . date('Y'));

        $sheet->getStyle('A1:H3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H3')->getFont()->setBold(true)->setSize(14);

        // =========================
        // SUB HEADER
        // =========================
        $sheet->setCellValue('A5', 'Cabang Olahraga');
        $sheet->setCellValue('B5', ': ' . strtoupper($meta['cabor']));

        $sheet->setCellValue('A6', 'Penanggung Jawab');
        $sheet->setCellValue('B6', ': ' . strtoupper($meta['penanggung_jawab']));

        $sheet->setCellValue('A7', 'Total Data');
        $sheet->setCellValue('B7', ': ' . $meta['total']);

        // =========================
        // TABLE HEADER
        // =========================
        $rowStart = 9;

        $headers = [
            'NO',
            'NAMA',
            'TEMPAT, TANGGAL LAHIR',
            'ASAL SEKOLAH',
            'CABOR',
            'NOMOR PERTANDINGAN',
            'JENJANG',
            'VERIFIKASI'
        ];

        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . $rowStart, $h);
            $col++;
        }

        $sheet->getStyle("A$rowStart:H$rowStart")->getFont()->setBold(true);
        $sheet->getStyle("A$rowStart:H$rowStart")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // =========================
        // ISI DATA
        // =========================
        $row = $rowStart + 1;

        foreach ($data as $no => $d) {

            $sheet->setCellValue("A$row", $no + 1);
            $sheet->setCellValue("B$row", $d['nama']);
            $sheet->setCellValue("C$row", $d['ttl']);
            $sheet->setCellValue("D$row", $d['sekolah']);
            $sheet->setCellValue("E$row", $d['cabor']);
            $sheet->setCellValue("F$row", $d['nomor'] . ' ' . ($d['detail'] ?? '') . ' ' . ($d['jenis'] ?? '') . ' ' . ($d['kategori'] ?? '-'));
            $sheet->setCellValue("G$row", $d['jenjang']);
            $sheet->setCellValue("H$row", $d['verifikasi']);

            $row++;
        }

        $lastRow = $row - 1;

        // =========================
        // BORDER
        // =========================
        $sheet->getStyle("A$rowStart:H$lastRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        // border luar tebal
        $sheet->getStyle("A$rowStart:H$lastRow")->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM
                ]
            ]
        ]);

        // =========================
        // ALIGNMENT
        // =========================
        $sheet->getStyle("A$rowStart:H$lastRow")
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle("A$rowStart:A$lastRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("G$rowStart:G$lastRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("H$rowStart:H$lastRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("C$rowStart:C$lastRow")->getAlignment()->setWrapText(true);

        // =========================
        // AUTO WIDTH
        // =========================
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // =========================
        // OUTPUT
        // =========================
        $filename = 'Rekap_' . str_replace(' ', '_', $meta['cabor']) . '_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
