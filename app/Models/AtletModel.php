<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Traits\UuidTrait;

class AtletModel extends Model
{
    use UuidTrait;

    protected $table            = 'atlet';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected $beforeInsert = ['insertUUID'];

    /**
     * Ringkasan rekap atlet sesuai cabor yang boleh diakses user.
     * $caborIds kosong = semua cabor (admin).
     */
    public function getRekapSummary(array $caborIds = []): array
    {
        $builder = $this->db->table('atlet a')
            ->select("
                COUNT(*) AS total,
                SUM(CASE WHEN av.status_final = 'valid' THEN 1 ELSE 0 END) AS lengkap,
                SUM(CASE WHEN av.status_final = 'pending' THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN av.status_final = 'invalid' THEN 1 ELSE 0 END) AS invalid,
                SUM(CASE WHEN av.status_final IS NULL OR av.status_final = '' THEN 1 ELSE 0 END) AS belum_dicek
            ", false)
            ->join('atlet_validasi av', 'av.atlet_id = a.id', 'left');

        if (! empty($caborIds)) {
            $builder->whereIn('a.cabor_id', $caborIds);
        }

        $row = $builder->get()->getRowArray() ?? [];

        return [
            'total'       => (int) ($row['total'] ?? 0),
            'lengkap'     => (int) ($row['lengkap'] ?? 0),
            'pending'     => (int) ($row['pending'] ?? 0),
            'invalid'     => (int) ($row['invalid'] ?? 0),
            'belum_dicek' => (int) ($row['belum_dicek'] ?? 0),
        ];
    }

    public function getAtletData()
    {
        $sql = $this->db->table('atlet a')
            ->select('a.*')
            ->select('av.kk_status')
            ->select('av.akte_status')
            ->select('av.foto_status')
            ->select('av.ijazah_status')
            ->select('av.nisn_status')
            ->select('av.ktp_kia_kk_status')
            ->select('av.suket_status')
            ->select('av.status_final')
            ->select('s.nama AS sekolah')
            ->select('s.bentuk_pendidikan')
            ->select('c.nama AS cabor')
            ->select('nc.jenis, nc.detail, nc.kategori')
            ->select('GROUP_CONCAT(DISTINCT nc.nama SEPARATOR ", ") AS nomor_cabor')
            ->select('GROUP_CONCAT(DISTINCT j.nama ORDER BY j.id ASC SEPARATOR ", ") AS jenjang')
            ->join('sekolah s', 'a.sekolah_id = s.id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = a.id', 'left')
            ->join('cabor c', 'c.id = a.cabor_id', 'left')
            ->join('nomor_cabor nc', '
            nc.id = a.nomor_cabor_1 OR
            nc.id = a.nomor_cabor_2 OR
            nc.id = a.nomor_cabor_3
        ', 'left')
            ->join('jenjang j', 'j.id = nc.jenjang_id', 'left')
            ->groupBy('a.id')
            ->orderBy('c.nama ASC, a.nama ASC');

        return $sql->get()->getResultArray();
    }

    public function getAtletDataValidator($user_id)
    {
        $sql = $this->db->table('atlet a')
            ->select('a.*')
            ->select('av.kk_status')
            ->select('av.akte_status')
            ->select('av.foto_status')
            ->select('av.ijazah_status')
            ->select('av.nisn_status')
            ->select('av.ktp_kia_kk_status')
            ->select('av.suket_status')
            ->select('av.status_final')
            ->select('s.nama AS sekolah')
            ->select('s.bentuk_pendidikan')
            ->select('c.nama AS cabor')
            ->select('nc.jenis, nc.detail, nc.kategori')
            ->select('GROUP_CONCAT(DISTINCT nc.nama SEPARATOR ", ") AS nomor_cabor')
            ->select('GROUP_CONCAT(DISTINCT j.nama ORDER BY j.id ASC SEPARATOR ", ") AS jenjang')
            ->join('sekolah s', 'a.sekolah_id = s.id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = a.id', 'left')
            ->join('cabor c', 'c.id = a.cabor_id', 'left')

            // penting: join ke users_validator
            ->join('users_validator uv', 'uv.cabor_id = a.cabor_id', 'left')

            ->join('nomor_cabor nc', '
            nc.id = a.nomor_cabor_1 OR
            nc.id = a.nomor_cabor_2 OR
            nc.id = a.nomor_cabor_3
        ', 'left')
            ->join('jenjang j', 'j.id = nc.jenjang_id', 'left')

            // filter user login
            ->where('uv.user_id', $user_id)

            ->groupBy('a.id')
            ->orderBy('c.nama ASC, a.nama ASC');

        return $sql->get()->getResultArray();
    }

    public function getAtletDataBySekolah()
    {
        $sql = $this->db->table('atlet')->select('
            atlet.*, 
            av.kk_status, av.akte_status, av.foto_status,
            av.ijazah_status, av.nisn_status, av.ktp_kia_kk_status, av.suket_status, av.status_final,
            s.nama AS sekolah, 
            c.nama AS cabor,
            GROUP_CONCAT(DISTINCT nc.nama SEPARATOR ",") AS nomor_cabor,
            nc.jenis, nc.detail, nc.kategori
        ')
            ->join('sekolah s', 'atlet.sekolah_id = s.id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = atlet.id', 'left')
            ->join('cabor c', 'c.id = atlet.cabor_id', 'left')
            ->join('nomor_cabor nc', "
            nc.id = atlet.nomor_cabor_1 OR
            nc.id = atlet.nomor_cabor_2 OR
            nc.id = atlet.nomor_cabor_3
        ", 'left')
            ->where('atlet.sekolah_id', session()->get('user')['sekolah_id'])
            ->orderBy('c.nama ASC', 'a.nama ASC')
            ->groupBy('atlet.id');

        return $sql->get()->getResultArray();
    }

    public function getAtletBlmDaftar($id_kompetisi)
    {
        return $this->select('atlet.*, p.kompetisi_id')
            ->join('peserta p', 'p.atlet_id = atlet.id and p.kompetisi_id != ' . $id_kompetisi, 'left')
            ->join('atlet_validasi av', 'av.atlet_id = atlet.id', 'left')
            ->where(['av.status_final' => 'valid'])
            ->findAll();
    }

    public function getAtletBlmDaftarBySekolah($id_kompetisi)
    {
        return $this->select('atlet.id, atlet.nama')
            ->join('peserta p', 'p.atlet_id = atlet.id AND p.kompetisi_id = ' . (int)$id_kompetisi, 'left')
            ->join('atlet_validasi av', 'av.atlet_id = atlet.id', 'left')
            ->where('av.status_final', 'valid')
            ->where('atlet.sekolah_id', session()->get('user')['sekolah_id'])
            ->where('p.atlet_id IS NULL')
            ->findAll();
    }

    public function getAtletMultiCabor($id_kompetisi)
    {
        return $this->db->table('peserta p')->select('p.id, p.atlet_id, a.nama nama_atlet, c.nama nama_cabor, nc.nama nama_nocabor')
            ->join('atlet a', 'p.atlet_id = a.id', 'left')
            ->join('cabor c', 'p.cabor_id = c.id', 'left')
            ->join('nomor_cabor nc', 'p.nomor_cabor_id = nc.id', 'left')
            ->where('p.kompetisi_id', $id_kompetisi)
            ->where('a.sekolah_id', session('user')['sekolah_id'])
            ->get()->getResultArray();
    }

    public function getAtletDetailByID($id)
    {
        $sql = $this->db->table('atlet')->select('atlet.*, av.kk_status, akte_status, av.foto_status,
                av.ijazah_status, av.nisn_status, av.ktp_kia_kk_status, s.nama sekolah, s.id sekolah_id, c.nama cabor')
            ->join('sekolah s', 'atlet.sekolah_id = s.id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = atlet.id', 'left')
            ->join('cabor c', 'c.id = atlet.cabor_id', 'left')
            ->where('atlet.id', $id);

        return $sql->get()->getRowArray();
    }

    public function totalDataKomponen()
    {
        $totalAtlet = $this->select('id')->countAllResults();
        $totalKompetisi = $this->db->table('kompetisi')->select('id')->countAllResults();
        $totalCabor = $this->db->table('cabor')->select('id')->countAllResults();
        $totalNomorCabor = $this->db->table('nomor_cabor')->select('id')->countAllResults();
        $totalSekolahAtlet = $this->db->table('atlet')->select('id')->groupBy('sekolah_id')->countAllResults();

        return [
            'total_atlet'   => $totalAtlet,
            'total_kompetisi'   => $totalKompetisi,
            'total_cabor'   => $totalCabor,
            'total_nomor_cabor'   => $totalNomorCabor,
            'total_sekolah_atlet'   => $totalSekolahAtlet
        ];
    }

    /**
     * Data ringkas dashboard sesuai hak akses.
     * - admin    : seluruh data
     * - validator: hanya cabor yang ditugaskan (users_validator)
     * - sekolah  : hanya atlet sekolah tersebut
     */
    public function getDashboardData(string $role = 'admin', ?string $sekolah_id = null, ?string $user_id = null): array
    {
        $db = $this->db;

        $atletBase = function () use ($db, $role, $sekolah_id, $user_id) {
            $builder = $db->table('atlet a')
                ->join('atlet_validasi av', 'av.atlet_id = a.id', 'left');

            if ($role === 'sekolah') {
                if ($sekolah_id) {
                    $builder->where('a.sekolah_id', $sekolah_id);
                } else {
                    // Jangan pernah menampilkan data global untuk akun sekolah tanpa sekolah_id.
                    $builder->where('1 = 0', null, false);
                }
            }

            if ($role === 'validator') {
                if ($user_id) {
                    $builder->join('users_validator uv', 'uv.cabor_id = a.cabor_id', 'inner')
                        ->where('uv.user_id', $user_id);
                } else {
                    $builder->where('1 = 0', null, false);
                }
            }

            return $builder;
        };

        // Ambil atlet beserta status dokumen. Status dihitung dengan aturan yang
        // sama seperti tabel Data Atlet agar angka dashboard tidak berbeda.
        $selectAtlet = 'a.id, a.nama, a.nisn, a.created_at, a.jenis_kelamin,
            a.cabor_id, a.sekolah_id,
            c.nama AS cabor, s.nama AS sekolah, s.bentuk_pendidikan,
            av.akte_status, av.foto_status, av.ktp_kia_kk_status,
            av.nisn_status, av.ijazah_status, av.suket_status';

        $atletRows = $atletBase()
            ->distinct()
            ->select($selectAtlet)
            ->join('cabor c', 'c.id = a.cabor_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->orderBy('a.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $totalAtlet = 0;
        $totalValid = 0;
        $totalPending = 0;
        $totalInvalid = 0;
        $caborCounts = [];
        $caborIds = [];
        $sekolahIds = [];
        $uniqueAtlet = [];
        $perluTindakan = [];
        $seenAtlet = [];

        foreach ($atletRows as $row) {
            $atletId = $row['id'];

            // Hindari duplikasi bila ada lebih dari satu baris validasi.
            if (isset($seenAtlet[$atletId])) {
                continue;
            }
            $seenAtlet[$atletId] = true;

            $row['status_calc'] = $this->getValidationStatusFromRow($row);
            $uniqueAtlet[] = $row;
            $totalAtlet++;

            if ($row['status_calc'] === 'invalid') {
                $totalInvalid++;
            } elseif ($row['status_calc'] === 'pending') {
                $totalPending++;
            } else {
                $totalValid++;
            }

            $caborName = $row['cabor'] ?: 'Tanpa Cabor';
            $caborCounts[$caborName] = ($caborCounts[$caborName] ?? 0) + 1;

            if (!empty($row['cabor_id'])) {
                $caborIds[$row['cabor_id']] = true;
            }
            if (!empty($row['sekolah_id'])) {
                $sekolahIds[$row['sekolah_id']] = true;
            }

            $butuhTindakan = $role === 'sekolah'
                ? $row['status_calc'] === 'invalid'
                : $row['status_calc'] === 'pending';

            if ($butuhTindakan) {
                $perluTindakan[] = $row;
            }
        }

        arsort($caborCounts);
        $caborChart = [];
        foreach (array_slice($caborCounts, 0, 6, true) as $nama => $total) {
            $caborChart[] = ['nama' => $nama, 'total' => $total];
        }

        if ($role === 'admin') {
            $totalCabor = (int) $db->table('cabor')->countAllResults();
        } elseif ($role === 'validator' && $user_id) {
            $row = $db->table('users_validator')
                ->select('COUNT(DISTINCT cabor_id) AS total', false)
                ->where('user_id', $user_id)
                ->get()
                ->getRowArray();
            $totalCabor = (int) ($row['total'] ?? 0);
        } else {
            $totalCabor = count($caborIds);
        }

        $totalKompetisi = (int) $db->table('kompetisi')->countAllResults();
        $totalSekolah = count($sekolahIds);

        // Rekap medali (dibatasi sesuai role).
        $medaliBase = function () use ($db, $role, $sekolah_id, $user_id) {
            $builder = $db->table('prestasi p')
                ->join('atlet a', 'a.id = p.atlet_id', 'left');

            if ($role === 'sekolah') {
                if ($sekolah_id) {
                    $builder->where('a.sekolah_id', $sekolah_id);
                } else {
                    $builder->where('1 = 0', null, false);
                }
            }

            if ($role === 'validator') {
                if ($user_id) {
                    $builder->join('users_validator uv', 'uv.cabor_id = p.cabor_id', 'inner')
                        ->where('uv.user_id', $user_id);
                } else {
                    $builder->where('1 = 0', null, false);
                }
            }

            return $builder;
        };

        $medali = $medaliBase()
            ->select("
                COUNT(DISTINCT CASE WHEN p.prestasi = '1' THEN p.id END) AS emas,
                COUNT(DISTINCT CASE WHEN p.prestasi = '2' THEN p.id END) AS perak,
                COUNT(DISTINCT CASE WHEN p.prestasi = '3' THEN p.id END) AS perunggu,
                COUNT(DISTINCT p.id) AS total
            ", false)
            ->get()
            ->getRowArray() ?: ['emas' => 0, 'perak' => 0, 'perunggu' => 0, 'total' => 0];

        $medaliCabor = $medaliBase()
            ->select("
                c.nama AS nama,
                COUNT(DISTINCT p.id) AS total,
                COUNT(DISTINCT CASE WHEN p.prestasi = '1' THEN p.id END) AS emas,
                COUNT(DISTINCT CASE WHEN p.prestasi = '2' THEN p.id END) AS perak,
                COUNT(DISTINCT CASE WHEN p.prestasi = '3' THEN p.id END) AS perunggu
            ", false)
            ->join('cabor c', 'c.id = p.cabor_id', 'left')
            ->groupBy(['p.cabor_id', 'c.nama'])
            ->orderBy('total', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();

        // Kompetisi terbaru.
        $kompetisiTerbaru = $db->table('kompetisi')
            ->orderBy('tgl_start', 'DESC')
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Atlet terbaru (data sudah urut created_at DESC).
        $atletTerbaru = array_slice($uniqueAtlet, 0, 5);

        // Daftar yang butuh tindakan: sekolah melihat yang perlu perbaikan,
        // admin/validator melihat yang menunggu validasi.
        usort($perluTindakan, static function ($a, $b) {
            return strcasecmp((string) $a['nama'], (string) $b['nama']);
        });
        $perluTindakan = array_slice($perluTindakan, 0, 5);

        return [
            'total_atlet'      => $totalAtlet,
            'total_valid'      => $totalValid,
            'total_pending'    => $totalPending,
            'total_invalid'    => $totalInvalid,
            'total_cabor'      => $totalCabor,
            'total_kompetisi'  => $totalKompetisi,
            'total_sekolah'    => $totalSekolah,
            'cabor_chart'      => $caborChart,
            'medali'           => $medali,
            'medali_cabor'     => $medaliCabor,
            'kompetisi_terbaru' => $kompetisiTerbaru,
            'atlet_terbaru'    => $atletTerbaru,
            'perlu_tindakan'   => $perluTindakan,
        ];
    }

    /**
     * Sinkronkan status_final satu atlet dengan status dokumennya.
     */
    public function syncStatusFinal(string $atletId): ?string
    {
        $row = $this->db->table('atlet a')
            ->select('a.id, s.bentuk_pendidikan,
                av.akte_status, av.foto_status, av.ktp_kia_kk_status,
                av.nisn_status, av.ijazah_status, av.suket_status')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = a.id', 'left')
            ->where('a.id', $atletId)
            ->get()
            ->getRowArray();

        if (!$row) {
            return null;
        }

        $status = $this->getValidationStatusFromRow($row);
        $exists = $this->db->table('atlet_validasi')
            ->where('atlet_id', $atletId)
            ->countAllResults() > 0;

        if ($exists) {
            $this->db->table('atlet_validasi')
                ->where('atlet_id', $atletId)
                ->update(['status_final' => $status]);
        } else {
            $this->db->table('atlet_validasi')->insert([
                'atlet_id' => $atletId,
                'status_final' => $status,
            ]);
        }

        return $status;
    }

    /**
     * Hitung status validasi dari status dokumen, sama seperti tabel Data Atlet.
     * Dokumen yang dihitung: akte, foto, KTP/KIA/KK, NISN, suket, dan ijazah
     * (ijazah hanya wajib untuk selain SD/MI).
     */
    private function getValidationStatusFromRow(array $row): string
    {
        $bentuk = $row['bentuk_pendidikan'] ?? '';
        $fields = ['akte_status', 'foto_status', 'ktp_kia_kk_status', 'nisn_status', 'suket_status'];

        if (!in_array($bentuk, ['SD', 'MI'], true)) {
            $fields[] = 'ijazah_status';
        }

        $hasPending = false;

        foreach ($fields as $field) {
            $status = $row[$field] ?? null;

            if ($status === 'invalid') {
                return 'invalid';
            }

            if ($status !== 'valid') {
                $hasPending = true;
            }
        }

        return $hasPending ? 'pending' : 'valid';
    }
}
