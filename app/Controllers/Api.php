<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AtletModel;
use App\Models\CaborModel;
use App\Models\PesertaModel;
use App\Models\PrestasiModel;
use App\Models\UsersModel;
use SebastianBergmann\CodeCoverage\Driver\Selector;

class Api extends BaseController
{
    protected $db;
    protected $m_atlet;
    protected $m_cabor;
    protected $m_users;
    protected $m_peserta;
    protected $m_prestasi;

    public function __construct()
    {
        helper('form');
        $this->db = \Config\Database::connect();
        $this->m_atlet = new AtletModel();
        $this->m_cabor = new CaborModel();
        $this->m_users = new UsersModel();
        $this->m_peserta = new PesertaModel();
        $this->m_prestasi = new PrestasiModel();
    }

    public function getDataAtletKabv2()
    {
        $request = \Config\Services::request();
        $db      = \Config\Database::connect();

        // 1. Ambil parameter pagination & keyword search global dari DataTables
        $start  = $request->getGet('start') ?? 0;
        $length = $request->getGet('length') ?? 10;
        $search = $request->getGet('search')['value'] ?? '';

        // 2. Ambil parameter filter khusus
        $filterSekolah = $request->getGet('filter_sekolah');
        $filterCabor   = $request->getGet('filter_cabor');
        $filterStatus  = $request->getGet('filter_status');

        // 3. Bangun Query Builder Utama (Menggunakan skema join kompleks Anda)
        $builder = $db->table('atlet a')
            ->select('a.*')
            ->select('av.kk_status, av.akte_status, av.foto_status, av.ijazah_status, av.nisn_status, av.ktp_kia_kk_status, av.suket_status, av.status_final')
            ->select('s.nama AS sekolah, s.bentuk_pendidikan')
            ->select('c.nama AS cabor')
            ->select('nc.jenis, nc.detail, nc.kategori')
            ->select('GROUP_CONCAT(DISTINCT nc.nama SEPARATOR ", ") AS nomor_cabor')
            ->select('GROUP_CONCAT(DISTINCT j.nama ORDER BY j.id ASC SEPARATOR ", ") AS jenjang')
            ->join('sekolah s', 'a.sekolah_id = s.id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = a.id', 'left')
            ->join('cabor c', 'c.id = a.cabor_id', 'left')
            ->join('nomor_cabor nc', '(nc.id = a.nomor_cabor_1 OR nc.id = a.nomor_cabor_2 OR nc.id = a.nomor_cabor_3)', 'left')
            ->join('jenjang j', 'j.id = nc.jenjang_id', 'left');

        // 4. Kondisi Penyaringan Filter Kustom Dropdown
        if (!empty($filterSekolah)) {
            $builder->where('a.sekolah_id', $filterSekolah);
        }
        if (!empty($filterCabor)) {
            $builder->where('a.cabor_id', $filterCabor);
        }
        if (!empty($filterStatus)) {
            // Samakan dengan status yang dihitung pada baris tabel:
            // ijazah hanya wajib untuk selain SD/MI dan kolom kk_status tidak dipakai.
            $invalidSql = "(
                COALESCE(av.akte_status, '') = 'invalid'
                OR COALESCE(av.foto_status, '') = 'invalid'
                OR COALESCE(av.ktp_kia_kk_status, '') = 'invalid'
                OR COALESCE(av.nisn_status, '') = 'invalid'
                OR COALESCE(av.suket_status, '') = 'invalid'
                OR (
                    (s.bentuk_pendidikan IS NULL OR s.bentuk_pendidikan NOT IN ('SD', 'MI'))
                    AND COALESCE(av.ijazah_status, '') = 'invalid'
                )
            )";

            $pendingSql = "(
                COALESCE(av.akte_status, '') <> 'valid'
                OR COALESCE(av.foto_status, '') <> 'valid'
                OR COALESCE(av.ktp_kia_kk_status, '') <> 'valid'
                OR COALESCE(av.nisn_status, '') <> 'valid'
                OR COALESCE(av.suket_status, '') <> 'valid'
                OR (
                    (s.bentuk_pendidikan IS NULL OR s.bentuk_pendidikan NOT IN ('SD', 'MI'))
                    AND COALESCE(av.ijazah_status, '') <> 'valid'
                )
            )";

            if ($filterStatus === 'sudah') {
                $builder->where('NOT ' . $invalidSql, null, false)
                    ->where('NOT ' . $pendingSql, null, false);
            } elseif ($filterStatus === 'perbaikan') {
                $builder->where($invalidSql, null, false);
            } elseif ($filterStatus === 'belum') {
                $builder->where('NOT ' . $invalidSql, null, false)
                    ->where($pendingSql, null, false);
            }
        }

        // Hitung total record awal sebelum filter pencarian kata kunci
        $totalData = $db->table('atlet')->countAllResults();

        // 5. Kondisi Pencarian Global (Input Search Box DataTables)
        if (!empty($search)) {
            $builder->groupStart()
                ->like('a.nama', $search)
                ->orLike('s.nama', $search)
                ->orLike('c.nama', $search)
                ->groupEnd();
        }

        // Eksekusi pengelompokan baris data
        $builder->groupBy('a.id')->orderBy('c.nama ASC, a.nama ASC');

        // Hitung total record setelah difilter (Menggunakan teknik subquery agar aman dari dampak Group By)
        $builderFiltered = clone $builder;
        $totalFiltered   = $db->newQuery()->select('COUNT(*) as total')
            ->fromSubquery($builderFiltered, 'sub')
            ->get()->getRow()->total ?? 0;

        // 6. Ambil potongan data sesuai limit halaman (Pagination)
        $atlet = $builder->limit($length, $start)->get()->getResultArray();

        $data = [];
        $no = $start + 1;
        $isAdminStatus = isAdmin(); // Deteksi role login session operator/admin Anda

        // 7. Looping data untuk menyusun baris HTML JSON
        foreach ($atlet as $a) {

            // Logika Pengecekan Keperluan Ijazah (Pindahan asli dari view Anda)
            $bentuk           = $a['bentuk_pendidikan'] ?? '';
            $isIjazahRequired = !in_array($bentuk, ['SD', 'MI']);

            $jenis_dok = ['akte_status', 'foto_status', 'ktp_kia_kk_status', 'nisn_status', 'ijazah_status', 'suket_status'];
            $hasInvalid = false;
            $hasPending = false;

            foreach ($jenis_dok as $jd) {
                if ($jd === 'ijazah_status' && !$isIjazahRequired) {
                    continue;
                }
                $status = $a[$jd] ?? null;
                if ($status === 'invalid') {
                    $hasInvalid = true;
                } elseif (in_array($status, ['pending', 'belum dicek']) || empty($status)) {
                    $hasPending = true;
                }
            }

            $isNotValid = $hasInvalid ? 'Perlu Perbaikan' : ($hasPending ? 'Belum' : 'Sudah');
            $badgeClass = $isNotValid === 'Belum' ? 'bg-warning text-dark' : ($isNotValid === 'Sudah' ? 'bg-success text-light' : 'bg-danger text-light');

            // Merender isi kolom baris demi baris
            $row = [];
            $row[] = $no++;

            // Render Kolom Aksi
            $actionButtons = '';
            if ($isAdminStatus) {
                $actionButtons .= '
                <a href="javascript:void(0)" data-id="' . $a['id'] . '" data-bs-toggle="tooltip" data-bs-title="Detail dan Validasi" class="view-atlet w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center me-1">
                    <iconify-icon icon="hugeicons:validation-approval"></iconify-icon>
                </a>';
            }
            $actionButtons .= '
            <a href="' . site_url('admin/atlet/edit/') . $a['id'] . '" data-bs-toggle="tooltip" data-bs-title="Edit Data" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center me-1">
                <iconify-icon icon="lucide:edit"></iconify-icon>
            </a>
            <a id="' . $a['id'] . '" data-bs-toggle="tooltip" data-bs-title="Hapus" class="delete-atlet w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
            </a>';
            $row[] = $actionButtons;

            // Render Kolom Badge Status Validasi
            $row[] = '<span class="badge badge-status-depan ' . $badgeClass . '" data-id="' . $a['id'] . '">' . $isNotValid . '</span>';

            // Render Kolom Nama & Foto Profil
            $fotoUrl = base_url('public/uploads/atlet/file_foto/' . (!empty($a['file_foto']) ? $a['file_foto'] : 'default.png'));
            $row[] = '
            <div class="d-flex align-items-center">
                <img src="' . $fotoUrl . '" class="w-40-px h-40-px rounded-circle me-12">
                <span>' . htmlspecialchars($a['nama'] ?? '-', ENT_QUOTES, 'UTF-8') . '</span>
            </div>';

            // Render Kolom Informasi Umum Tekstual
            $row[] = htmlspecialchars($a['sekolah'] ?? '-', ENT_QUOTES, 'UTF-8');
            $row[] = htmlspecialchars($a['jenis_kelamin'] ?? '-', ENT_QUOTES, 'UTF-8');
            $row[] = htmlspecialchars($a['cabor'] ?? '-', ENT_QUOTES, 'UTF-8');

            // Penggabungan deskripsi lengkap nomor lomba atlet
            $nomorLombaTeks = ($a['nomor_cabor'] ?? '') . ' ' . ($a['jenis'] ?? '') . ' ' . ($a['detail'] ?? '') . ' ' . ($a['kategori'] ?? '');
            $row[] = htmlspecialchars(trim($nomorLombaTeks), ENT_QUOTES, 'UTF-8');

            $row[] = htmlspecialchars($a['jenjang'] ?? '-', ENT_QUOTES, 'UTF-8');

            $data[] = $row;
        }

        // 8. Kembalikan paket data terenkapsulasi JSON ke DataTables
        return $this->response->setJSON([
            "draw"            => intval($request->getGet('draw')),
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data,
        ]);
    }

    public function getDataAtletKab()
    {
        $request = service('request');

        $cabor_id   = $request->getGet('cabor_id');
        $sekolah_id = $request->getGet('sekolah_id');

        $draw   = $request->getGet('draw');
        $start  = $request->getGet('start');
        $length = $request->getGet('length');
        $search = $request->getGet('search')['value'];
        $order_col = $request->getGet('order')[0]['column'];
        $order_dir = $request->getGet('order')[0]['dir'];

        $columns = [
            'nama',
            'jk',
            'tanggal_lahir',
            'cabor',
            'sekolah'
        ];

        $builder = $this->db->table('atlet')
            ->select('atlet.*, s.nama sekolah, c.nama cabor')
            ->join('sekolah s', 'atlet.sekolah_id = s.id', 'left')
            ->join('cabor c', 'c.id = atlet.cabor_id', 'left');

        // FILTER
        if ($cabor_id) {
            $builder->where('cabor_id', $cabor_id);
        }

        if ($sekolah_id) {
            $builder->where('sekolah_id', $sekolah_id);
        }

        // SEARCH
        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->orLike('cabor', $search)
                ->orLike('sekolah', $search)
                ->groupEnd();
        }

        // TOTAL DATA SEBELUM FILTER
        $totalData = $this->db->table('atlet')->countAllResults(false);

        // CLONE untuk counting
        $builderCount = clone $builder;
        $filteredData = $builderCount->countAllResults(false);

        // ORDER + LIMIT
        $builder->orderBy($columns[$order_col], $order_dir);
        $builder->limit($length, $start);

        // GET RESULT
        $data = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'draw'            => intval($draw),
            'recordsTotal'    => $totalData,
            'recordsFiltered' => $filteredData,
            'data'            => $data
        ]);
    }

    public function getDetailAtlet()
    {
        $atletID = $this->request->getGet('id');

        // Ambil data atlet + sekolah + cabor + nama nomor cabor 1-3 + jenjang masing-masing
        $data = $this->m_atlet
            ->select([
                'atlet.*',
                's.nama AS sekolah',
                's.bentuk_pendidikan',
                'c.nama AS cabor',
                'nc1.detail',
                'nc1.jenis',
                'nc1.kategori',
                'nc1.nama AS nomor_cabor_1_nama',
                'j1.nama AS jenjang_1',
                'nc2.nama AS nomor_cabor_2_nama',
                'j2.nama AS jenjang_2',
                'nc3.nama AS nomor_cabor_3_nama',
                'j3.nama AS jenjang_3',
            ])
            ->join('cabor c', 'c.id = atlet.cabor_id', 'left')
            ->join('nomor_cabor nc1', 'nc1.id = atlet.nomor_cabor_1', 'left')
            ->join('jenjang j1', 'j1.id = nc1.jenjang_id', 'left')
            ->join('nomor_cabor nc2', 'nc2.id = atlet.nomor_cabor_2', 'left')
            ->join('jenjang j2', 'j2.id = nc2.jenjang_id', 'left')
            ->join('nomor_cabor nc3', 'nc3.id = atlet.nomor_cabor_3', 'left')
            ->join('jenjang j3', 'j3.id = nc3.jenjang_id', 'left')
            ->join('sekolah s', 's.id = atlet.sekolah_id', 'left')
            ->where('atlet.id', $atletID)
            ->first();

        if (!$data) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Atlet tidak ditemukan'
            ]);
        }

        // Gabungkan nama nomor cabor dan jenjang menjadi string
        $data['nomor_cabor'] = implode(', ', array_filter([
            $data['nomor_cabor_1_nama'] ?? null,
            $data['nomor_cabor_2_nama'] ?? null,
            $data['nomor_cabor_3_nama'] ?? null
        ]));

        $data['jenjang'] = implode(', ', array_filter([
            $data['jenjang_1'] ?? null,
            $data['jenjang_2'] ?? null,
            $data['jenjang_3'] ?? null
        ]));

        // Ambil validasi
        $validasi = $this->db->table('atlet_validasi')
            ->where('atlet_id', $atletID)
            ->get()
            ->getFirstRow('array');

        return $this->response->setJSON([
            'status' => 'ok',
            'data' => $data,
            'validasi' => $validasi
        ]);
    }

    public function init_atlet_validasi()
    {
        $atletID = $this->request->getPost('atlet_id');

        $isExist = $this->db->table('atlet_validasi')->where('atlet_id', $atletID)->countAllResults() > 0;

        if (!$isExist) {
            $this->db->table('atlet_validasi')->insert(['atlet_id' => $atletID]);
            return $this->response->setJSON([
                'status' => 'success'
            ]);
        }
        return $this->response->setJSON([
            'status' => 'exist'
        ]);
    }


    private function getValidasiRow(string $atletId): ?array
    {
        return $this->db->table('atlet_validasi')
            ->select('kk_status, akte_status, foto_status, ijazah_status, nisn_status, ktp_kia_kk_status, suket_status, status_final')
            ->where('atlet_id', $atletId)
            ->get()
            ->getRowArray();
    }

    private function ensureValidasiRow(string $atletId): void
    {
        $exists = $this->db->table('atlet_validasi')
            ->where('atlet_id', $atletId)
            ->countAllResults() > 0;

        if (!$exists) {
            $this->db->table('atlet_validasi')->insert(['atlet_id' => $atletId]);
        }
    }

    private function requiredValidationDocs(string $atletId): array
    {
        $row = $this->db->table('atlet a')
            ->select('s.bentuk_pendidikan')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->where('a.id', $atletId)
            ->get()
            ->getRowArray();

        $bentuk = strtoupper((string) ($row['bentuk_pendidikan'] ?? ''));
        $docs = [
            'akte_status',
            'foto_status',
            'ktp_kia_kk_status',
            'nisn_status',
            'suket_status',
        ];

        if (!in_array($bentuk, ['SD', 'MI'], true)) {
            $docs[] = 'ijazah_status';
        }

        return $docs;
    }

    public function validasi_dokumen()
    {
        $atlet_id = (string) ($this->request->getGet('atletID') ?? '');
        $dok      = $this->request->getGet('dok');
        $status   = $this->request->getGet('status');

        $allowedDocs = [
            'kk_status',
            'akte_status',
            'foto_status',
            'ijazah_status',
            'nisn_status',
            'ktp_kia_kk_status',
            'suket_status',
        ];
        $allowedStatus = ['pending', 'valid', 'invalid'];

        // Cegah update kolom/status sembarangan (mis. status_final lewat endpoint ini).
        if (!in_array($dok, $allowedDocs, true) || !in_array($status, $allowedStatus, true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Parameter validasi tidak valid.',
            ]);
        }

        $atletExists = $this->db->table('atlet')->where('id', $atlet_id)->countAllResults() > 0;
        if (!$atletExists) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Atlet tidak ditemukan.',
            ]);
        }

        // Pastikan baris validasi tersedia (data atlet lama bisa belum memilikinya).
        $this->ensureValidasiRow($atlet_id);

        $sql = $this->db->table('atlet_validasi')->update([$dok => $status], ['atlet_id' => $atlet_id]);

        // Pastikan status_final langsung mengikuti kondisi seluruh dokumen.
        $statusFinal = $this->m_atlet->syncStatusFinal($atlet_id);

        return $this->response->setJSON([
            'status' => $sql,
            'status_final' => $statusFinal,
            'validasi' => $this->getValidasiRow($atlet_id),
        ]);
    }

    /**
     * Validasi seluruh dokumen wajib dalam satu request.
     * Dipakai tombol "Validasi Semua" agar tidak mengirim 5 request berurutan.
     */
    public function validasi_semua()
    {
        $atlet_id = (string) ($this->request->getGet('atletID') ?? $this->request->getPost('atletID') ?? '');

        if ($atlet_id === '') {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Atlet tidak valid.',
            ]);
        }

        $atletExists = $this->db->table('atlet')->where('id', $atlet_id)->countAllResults() > 0;
        if (!$atletExists) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Atlet tidak ditemukan.',
            ]);
        }

        $this->ensureValidasiRow($atlet_id);

        $data = [];
        foreach ($this->requiredValidationDocs($atlet_id) as $dok) {
            $data[$dok] = 'valid';
        }

        $this->db->table('atlet_validasi')->where('atlet_id', $atlet_id)->update($data);
        $statusFinal = $this->m_atlet->syncStatusFinal($atlet_id);

        return $this->response->setJSON([
            'status' => 'success',
            'status_final' => $statusFinal,
            'validasi' => $this->getValidasiRow($atlet_id),
        ]);
    }

    public function validasi_atlet()
    {
        $atlet_id = $this->request->getGet('atletID');
        $sql = $this->db->table('atlet_validasi')->select('kk_status, nisn_status, ktp_kia_kk_status, foto_status, ijazah_status,
        akte_status, suket_status, sekolah.bentuk_pendidikan')
            ->join('atlet', 'atlet.id = atlet_validasi.atlet_id', 'left')
            ->join('cabor c', 'c.id = atlet.cabor_id', 'left')
            ->join('sekolah', 'sekolah.id = atlet.sekolah_id', 'left')
            ->where('atlet_id', $atlet_id)->get()->getFirstRow('array');
        return $this->response->setJSON($sql);
    }

    public function set_atlet_valid()
    {
        $id_atlet = $this->request->getPost('atletID');
        $status   = $this->request->getPost('status');

        if (!in_array($status, ['pending', 'valid', 'invalid'], true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Status validasi tidak valid.',
            ]);
        }

        // Status akhir selalu dihitung ulang dari dokumen, bukan dari input client.
        $statusFinal = $this->m_atlet->syncStatusFinal($id_atlet);

        if ($statusFinal !== null) {
            return $this->response->setJSON([
                'status' => 'success',
                'status_final' => $statusFinal,
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal update status validasi.']);
    }

    private function allowedCatatanColumns(): array
    {
        return [
            'kk_catatan',
            'akte_catatan',
            'foto_catatan',
            'ijazah_catatan',
            'ktp_kia_kk_catatan',
            'nisn_catatan',
            'suket_catatan',
        ];
    }

    public function simpan_catatan()
    {
        $dok = $this->request->getPost('dok_catatan');
        if (!in_array($dok, $this->allowedCatatanColumns(), true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Kolom catatan tidak valid.',
            ]);
        }

        $atletId = (string) ($this->request->getPost('atlet_id') ?? '');
        if ($atletId === '') {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Atlet tidak valid.',
            ]);
        }

        $this->ensureValidasiRow($atletId);

        $data = [
            $dok => $this->request->getPost('note_value')
        ];

        if ($this->db->table('atlet_validasi')->update($data, ['atlet_id' => $atletId])) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Catatan ' . $dok . ' berhasil disimpan.']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal Meyimpan Catatan.']);
    }

    public function get_catatan()
    {
        $dok = $this->request->getPost('dok_catatan');
        if (!in_array($dok, $this->allowedCatatanColumns(), true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Kolom catatan tidak valid.',
            ]);
        }

        $result = $this->db->table('atlet_validasi')->select($dok)
            ->where('atlet_id', $this->request->getPost('atlet_id'))->get()->getFirstRow('array');
        return $this->response->setJSON($result);
    }

    public function getDataPesertaIDCard()
    {
        $id_peserta = $this->request->getPost('id');
        return $this->response->setJSON($this->m_peserta->getDataPesertaIDCard($id_peserta));
    }

    public function getDataAtletIDCard()
    {
        $id_atlet = $this->request->getPost('id');
        return $this->response->setJSON($this->m_peserta->getDataAtletIDCard($id_atlet));
    }

    public function getPesertaKompetisiCaborSekolah($nomor_lomba, $sekolah_id)
    {
        $result = $this->m_peserta->getPesertaKompetisiCaborSekolah($nomor_lomba, $sekolah_id);
        return $this->response->setJSON($result);
    }

    public function get_status_user()
    {
        $userID = $this->request->getPost('userID');
        $sql = $this->m_users->find($userID);
        return $this->response->setJSON($sql);
    }

    public function toggle_status_user()
    {
        $userID = $this->request->getPost('userID');
        $status = $this->request->getPost('status');
        $sql = $this->m_users->update($userID, ['isActive' => $status]);
        return $this->response->setJSON($sql);
    }

    public function toggle_status_nocabor()
    {
        $nomorCaborID = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $sql = $this->db->table('nomor_cabor')->update(['is_active' => $status], ['id' => $nomorCaborID]);
        return $this->response->setJSON($sql);
    }

    public function getCabor()
    {
        $sql = $this->db->table('cabor')->get()->getResultArray();
        return $this->response->setJSON($sql);
    }

    public function getValidatorCabor()
    {
        $sql = $this->m_cabor->getCaborForValidator($this->request->getPost('user_id'));
        return $this->response->setJSON($sql);
    }

    public function addValidatorCabor()
    {
        $data = [
            'user_id' => $this->request->getPost('user_id'),
            'cabor_id' => $this->request->getPost('cabor_id')
        ];
        return $this->db->table('users_validator')->insert($data);
    }


    public function deleteValidatorCabor()
    {
        $data = [
            'user_id' => $this->request->getPost('user_id'),
            'cabor_id' => $this->request->getPost('cabor_id')
        ];
        return $this->db->table('users_validator')->delete($data);
    }

    public function getNomorCabor()
    {
        $cabor_id = $this->request->getPost('cabor_id');
        $sql = $this->db->table('nomor_cabor')->where(['cabor_id' => $cabor_id, 'is_active' => '1'])->get()->getResultArray();
        return $this->response->setJSON($sql);
    }

    public function getNomorCaborPiagam()
    {
        $cabor_id = $this->request->getPost('cabor_id');
        $sql = $this->db->table('nomor_cabor')->where(['cabor_id' => $cabor_id])->get()->getResultArray();
        return $this->response->setJSON($sql);
    }

    public function getBanyakNomorCabor()
    {
        $cabor_id = $this->request->getPost('cabor_id');
        $sql = $this->db->table('cabor')->where(['id' => $cabor_id])->get()->getFirstRow('array');
        return $this->response->setJSON($sql['banyak_no_cabor']);
    }

    public function getNomorLombaSekolah($cabor_id, $sekolah_id)
    {
        $sql = $this->db->table('nomor_cabor nc')->select('nc.id, nc.nama')->join('cabor c', 'c.id = nc.cabor_id')->join('atlet a', 'a.cabor_id = nc.cabor_id')
            ->where(['nc.cabor_id' => $cabor_id, 'a.sekolah_id' => $sekolah_id])
            ->groupBy('nc.id')
            ->get()->getResultArray('array');
        return $this->response->setJSON($sql);
    }

    public function toggleStatusNomorCaborPerItem()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $sql = $this->db->table('nomor_cabor')->update(['is_active' => $status], ['id' => $id]);
        return $this->response->setJSON($sql);
    }

    public function toggleStatusNomorCaborPerJenjang()
    {
        $jenjang_id = $this->request->getPost('jenjang_id');
        $status = $this->request->getPost('status');
        $sql = $this->db->table('nomor_cabor')->update(['is_active' => $status], ['jenjang_id' => $jenjang_id]);
        return $this->response->setJSON($sql);
    }

    // Jurnal Medali
    public function jurnal_medali_kab()
    {
        $kompetisi_id = $this->request->getPost('kompetisi_id');
        $jenjang_id = $this->request->getPost('jenjang_id');
        $search = $this->request->getPost('search');

        if (!$kompetisi_id || !$jenjang_id) {
            return $this->response
                ->setJSON(['error' => 'Data tidak lengkap'])
                ->setStatusCode(400);
        }

        $builder = $this->db->table('atlet a')
            ->select("
        s.id AS sekolah_id,
        s.nama AS sekolah,
        COUNT(DISTINCT CASE WHEN p.prestasi='1' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) AS emas,
        COUNT(DISTINCT CASE WHEN p.prestasi='2' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) AS perak,
        COUNT(DISTINCT CASE WHEN p.prestasi='3' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) AS perunggu,
        (
            COUNT(DISTINCT CASE WHEN p.prestasi='1' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) +
            COUNT(DISTINCT CASE WHEN p.prestasi='2' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) +
            COUNT(DISTINCT CASE WHEN p.prestasi='3' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END)
        ) AS total
    ")
            ->join('sekolah s', 's.id = a.sekolah_id')
            ->join('prestasi p', 'p.atlet_id = a.id AND p.kompetisi_id = ' . $this->db->escape($kompetisi_id), 'left')
            // JOIN ke tabel nomor_cabor khusus untuk mengecek status is_team dari prestasi yg diraih
            ->join('nomor_cabor nc_p', 'nc_p.id = p.nomor_cabor_id', 'left')
            ->join('nomor_cabor nc1', 'nc1.id = a.nomor_cabor_1', 'left')
            ->join('nomor_cabor nc2', 'nc2.id = a.nomor_cabor_2', 'left')
            ->join('nomor_cabor nc3', 'nc3.id = a.nomor_cabor_3', 'left')
            ->groupStart()
            ->where('nc1.jenjang_id', $jenjang_id)
            ->orWhere('nc2.jenjang_id', $jenjang_id)
            ->orWhere('nc3.jenjang_id', $jenjang_id)
            ->groupEnd()
            ->where('s.nama IS NOT NULL')
            ->groupBy('s.id, s.nama')
            ->get()
            ->getResultArray();

        // Lakukan sorting berdasarkan medali
        usort($builder, function ($a, $b) {
            return $b['emas'] <=> $a['emas']
                ?: $b['perak'] <=> $a['perak']
                ?: $b['perunggu'] <=> $a['perunggu'];
        });

        // PERBAIKAN 3: Beri ranking HANYA jika total medalinya > 0
        $rank = 1;
        foreach ($builder as $i => &$row) {
            if ($row['total'] > 0) {
                $row['ranking'] = $rank;
                $rank++; // Nomor ranking hanya bertambah kalau punya medali
            } else {
                $row['ranking'] = '-'; // Tampilkan strip (-) untuk sekolah tanpa medali
            }
        }

        if ($search) {
            $builder = array_values(array_filter($builder, function ($row) use ($search) {
                return stripos($row['sekolah'], $search) !== false;
            }));
        }

        return $this->response->setJSON($builder);
    }

    public function cekRegAtletMultiCabor()
    {
        $atletIds     = $this->request->getPost('atlet_ids');
        $caborId      = $this->request->getPost('cabor_id');
        $nomorCaborId = $this->request->getPost('nomor_cabor_id');

        // cabor yang boleh multi nomor
        $multiEventCabor = ['ATLETIK', 'RENANG'];

        foreach ($atletIds as $atletId) {

            $history = $this->m_atlet->where('id', $atletId)->findAll();

            // 1️⃣ Sudah terdaftar di cabor lain
            foreach ($history as $row) {
                if ($row['cabor_id'] != $caborId) {
                    return $this->response->setJSON([
                        'status'  => false,
                        'icon'    => 'error',
                        'title'   => 'Pendaftaran Gagal',
                        'message' => 'Atlet sudah terdaftar di cabor lain.',
                    ]);
                }
            }
            // 2️⃣ Sudah di cabor yang sama
            $sameCabor = array_filter($history, fn($r) => $r['cabor_id'] == $caborId);

            if ($sameCabor) {

                // nomor lomba sama
                foreach ($sameCabor as $row) {
                    if ($row['nomor_cabor_id'] == $nomorCaborId) {
                        return $this->response->setJSON([
                            'status'  => false,
                            'icon'    => 'warning',
                            'title'   => 'Nomor Sudah Diambil',
                            'message' => 'Atlet sudah terdaftar di nomor lomba tersebut.'
                        ]);
                    }
                }
                // cabor tidak boleh multi nomor
                if (!in_array($caborId, $multiEventCabor)) {
                    return $this->response->setJSON([
                        'status'  => false,
                        'icon'    => 'error',
                        'title'   => 'Batasan Cabor',
                        'message' => 'Cabor ini tidak mengizinkan lebih dari satu nomor lomba.',
                    ]);
                }
            }
        }

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function getDataPesertaAddCaborByID()
    {
        $peserta_id = $this->request->getPost('peserta_id');
        $data = $this->m_peserta->getDataPesertaAddNomorCabor($peserta_id);
        return $this->response->setJSON($data);
    }

    public function toggle_admin_setting()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        $update = $this->db->table('admin_setting')->where('id', $id)->update(['status' => $status]);

        echo json_encode([
            'status'    => $status,
            'success' => $update ? true : false
        ]);
    }

    public function cekNik()
    {
        $nik = $this->request->getPost('nik');

        $exists = $this->db->table('atlet')
            ->where('nik', $nik)
            ->countAllResults() > 0;

        return $this->response->setJSON(['exists' => $exists]);
    }

    public function cekNisn()
    {
        $nisn = $this->request->getPost('nisn');

        $exists = $this->db->table('atlet')
            ->where('nisn', $nisn)
            ->countAllResults() > 0;

        return $this->response->setJSON(['exists' => $exists]);
    }

    public function validasi_piagam($id_prestasi)
    {
        $data = [
            'title' => 'Verifikasi Kebenaran Piagam',
            'data'  => $this->m_prestasi->getDataValidasiPiagam($id_prestasi)
        ];

        return view('piagam/verifikasi', $data);
    }
}
