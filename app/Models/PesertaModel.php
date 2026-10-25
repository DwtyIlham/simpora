<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaModel extends Model
{
    protected $table            = 'peserta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;

    public function getPesertaBySekolah($sekolah_id)
    {
        return $this->db->table('peserta p')
            ->select([
                'p.id',
                'p.kompetisi_id',
                'p.atlet_id',
                'p.cabor_id',
                'a.nama AS atlet_nama',
                'a.sekolah_id',
                's.nama AS sekolah_nama',
                'c.nama AS cabor_nama',
                'c.banyak_no_cabor',

                // Gabungkan semua nomor cabor
                "CONCAT_WS(', ',
            NULLIF(CONCAT_WS(' ', nc1.nama, j.nama, nc1.kategori, nc1.detail), ''),
            NULLIF(CONCAT_WS(' ', nc2.nama, j.nama, nc2.kategori, nc2.detail), ''),
            NULLIF(CONCAT_WS(' ', nc3.nama, j.nama, nc3.kategori, nc3.detail), '')
        ) AS nomor_cabor"
            ])
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')

            // JOIN 4x (AMAN & JELAS)
            ->join('nomor_cabor nc1', 'nc1.id = a.nomor_cabor_1', 'left')
            ->join('nomor_cabor nc2', 'nc2.id = a.nomor_cabor_2', 'left')
            ->join('nomor_cabor nc3', 'nc3.id = a.nomor_cabor_3', 'left')
            ->join('jenjang j', 'j.id = nc1.jenjang_id', 'left')

            ->where('a.sekolah_id', $sekolah_id)
            ->get()
            ->getResultArray();
    }

    public function getDataPesertaKompetisi($id_kompetisi)
    {
        $sql = $this->db->table('kompetisi k')
            ->select([
                'k.nama AS kompetisi_nama',
                'k.deskripsi',

                'p.id',
                'p.kompetisi_id',
                'p.atlet_id',
                'p.cabor_id',

                'a.nama AS atlet_nama',
                'a.nik',
                'a.jenis_kelamin',
                'a.tanggal_lahir',

                's.nama AS sekolah_nama',
                'c.nama AS cabor_nama',

                // gabung nomor cabor
                "GROUP_CONCAT(DISTINCT nc.nama SEPARATOR ', ') AS nomor_cabor",

                'av.status_final'
            ])
            ->join('peserta p', 'p.kompetisi_id = k.id', 'left')
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join(
                'atlet_validasi av',
                "av.atlet_id = p.atlet_id AND av.status_final = 'valid'",
                'inner'
            )
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')

            // FIX DI SINI (pakai OR, bukan IN)
            ->join('nomor_cabor nc', "
            nc.id = p.nomor_cabor_id_1 OR
            nc.id = p.nomor_cabor_id_2 OR
            nc.id = p.nomor_cabor_id_3 OR
            nc.id = p.nomor_cabor_id_4
        ", 'left')

            ->where('p.kompetisi_id', $id_kompetisi)
            ->groupBy('p.id');

        return $sql->get()->getResultArray();
    }

    public function getDataPesertaPrestasi($id_kompetisi)
    {
        $sql = $this->db->table('kompetisi k')
            ->select('
                k.nama AS kompetisi_nama,k.deskripsi,a.*,a.nama AS atlet_nama,s.nama AS sekolah_nama,
                c.nama AS cabor_nama,p.id,p.kompetisi_id,p.atlet_id,p.prestasi,av.status_final
            ')
            ->join('prestasi p', 'p.kompetisi_id = k.id', 'left')
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = p.atlet_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')
            ->where(['p.kompetisi_id' => $id_kompetisi, 'p.prestasi IS NOT NULL' => null, 'av.status_final' => 'valid']);

        return $sql->get()->getResultArray();
    }

    public function getDataPesertaPrestasiSekolah($id_kompetisi)
    {
        $sql = $this->db->table('kompetisi k')
            ->select('
                k.nama AS kompetisi_nama,k.deskripsi,a.*,a.nama AS atlet_nama,s.nama AS sekolah_nama,
                c.nama AS cabor_nama,p.id,p.kompetisi_id,p.atlet_id,p.prestasi,av.status_final
            ')
            ->join('peserta p', 'p.kompetisi_id = k.id', 'left')
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = p.atlet_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')
            ->where(['p.kompetisi_id' => $id_kompetisi, 'p.prestasi IS NOT NULL' => null, 'av.status_final' => 'valid', 'a.sekolah_id' => session()->get('user')['sekolah_id']]);

        return $sql->get()->getResultArray();
    }

    public function getPesertaKompetisiCaborSekolah($nomor_lomba, $sekolah_id)
    {
        $query = $this->setTable('atlet a')
            ->select('a.id, a.nama, c.nama cabor')
            ->join('cabor c', 'c.id = a.cabor_id')
            ->join('sekolah s', 'a.sekolah_id = s.id')
            ->where('a.sekolah_id', $sekolah_id)
            ->groupStart()
            ->where('a.nomor_cabor_1', $nomor_lomba)
            ->orWhere('a.nomor_cabor_2', $nomor_lomba)
            ->orWhere('a.nomor_cabor_3', $nomor_lomba)
            ->groupEnd()
            ->findAll();

        return $query;
    }

    public function getDataPesertaIDCard($id_peserta)
    {
        $sql = $this->db->table('peserta p')
            ->select('
                k.nama AS kompetisi_nama,
                k.deskripsi,
                a.*,
                a.nama AS atlet_nama,
                s.nama AS sekolah_nama,
                c.nama AS cabor_nama,
                p.id,
                p.kompetisi_id,
                p.atlet_id
            ')
            ->join('kompetisi k', 'k.id = p.kompetisi_id', 'left')
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')
            ->where('p.id', $id_peserta);

        return $sql->get()->getFirstRow('array');
    }

    public function getDataAtletIDCard($id_atlet)
    {
        $sql = $this->db->table('atlet a')
            ->select("
            k.nama AS kompetisi_nama,
            k.deskripsi,

            a.id,
            a.nama AS atlet_nama,
            a.file_foto,

            s.nama AS sekolah_nama,
            c.nama AS cabor_nama,

            nc1.nama AS nomor_cabor_1_nama,
            nc2.nama AS nomor_cabor_2_nama,
            nc3.nama AS nomor_cabor_3_nama
        ")

            ->join('kompetisi k', 'k.id = 1', 'left')

            ->join('sekolah s', 's.id = a.sekolah_id', 'left')

            ->join('cabor c', 'c.id = a.cabor_id', 'left')

            // JOIN NOMOR CABOR
            ->join('nomor_cabor nc1', 'nc1.id = a.nomor_cabor_1', 'left')
            ->join('nomor_cabor nc2', 'nc2.id = a.nomor_cabor_2', 'left')
            ->join('nomor_cabor nc3', 'nc3.id = a.nomor_cabor_3', 'left')

            ->where('a.id', $id_atlet);

        $data = $sql->get()->getFirstRow('array');

        // GABUNGKAN NOMOR CABOR
        $nomor = [];

        if (!empty($data['nomor_cabor_1_nama'])) {
            $nomor[] = $data['nomor_cabor_1_nama'];
        }

        if (!empty($data['nomor_cabor_2_nama'])) {
            $nomor[] = $data['nomor_cabor_2_nama'];
        }

        if (!empty($data['nomor_cabor_3_nama'])) {
            $nomor[] = $data['nomor_cabor_3_nama'];
        }

        $data['nomor_lomba'] = implode(', ', $nomor);

        return $data;
    }

    public function getDataPeserta($id_prestasi)
    {
        $sql = $this->db->table('prestasi p')
            ->select('
                k.nama AS kompetisi_nama,
                k.deskripsi,
                k.tgl_start,
                k.tgl_end,
                a.*,
                a.nama AS atlet_nama,
                s.nama AS sekolah_nama,
                c.nama AS cabor_nama,
                nc.nama AS nomor_lomba,
                p.id,
                p.kompetisi_id,
                p.atlet_id,
                p.prestasi
            ')
            ->join('kompetisi k', 'k.id = p.kompetisi_id', 'left')
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id OR s.npsn = a.npsn', 'left')
            ->join('nomor_cabor nc', 'nc.id = p.nomor_cabor_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')
            ->where('p.id', $id_prestasi);

        return $sql->get()->getFirstRow('array');
    }

    public function getDataPesertaBatch($nomor_cabor_id)
    {
        $sql = $this->db->table('prestasi p')
            ->select('
                k.nama AS kompetisi_nama,
                k.deskripsi,
                k.tgl_start,
                k.tgl_end,
                a.*,
                a.nama AS atlet_nama,
                s.nama AS sekolah_nama,
                c.nama AS cabor_nama,
                nc.nama AS nomor_lomba,
                p.id,
                p.kompetisi_id,
                p.atlet_id,
                p.prestasi
            ')
            ->join('kompetisi k', 'k.id = p.kompetisi_id', 'left')
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id OR s.npsn = a.npsn', 'left')
            ->join('nomor_cabor nc', 'nc.id = p.nomor_cabor_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')
            ->where('p.nomor_cabor_id', $nomor_cabor_id);

        return $sql->get()->getResultArray();
    }

    public function getDataPesertaAddNomorCabor($id_peserta)
    {
        // 1. Ambil data utama
        $row = $this->db->table('peserta p')
            ->select('
            p.id,
            p.cabor_id,
            a.nama AS atlet_nama,
            c.nama AS cabor_nama,
            c.banyak_no_cabor AS banyak_nomor_cabor,

            p.nomor_cabor_id_1,
            p.nomor_cabor_id_2,
            p.nomor_cabor_id_3,
            p.nomor_cabor_id_4
        ')
            ->join('atlet a', 'a.id = p.atlet_id')
            ->join('cabor c', 'c.id = p.cabor_id')
            ->where('p.id', $id_peserta)
            ->get()
            ->getFirstRow('array');

        if (!$row) return null;

        // 2. Ambil ID nomor cabor sesuai urutan
        $ids = [
            $row['nomor_cabor_id_1'],
            $row['nomor_cabor_id_2'],
            $row['nomor_cabor_id_3'],
            $row['nomor_cabor_id_4'],
        ];

        // Buang null / kosong
        $idsFiltered = array_values(array_filter($ids));

        if (empty($idsFiltered)) {
            $row['nomor_cabor'] = [];
            return $row;
        }

        // 3. Ambil data nomor cabor
        $nomorCabor = $this->db->table('nomor_cabor')
            ->select('id, nama')
            ->whereIn('id', $idsFiltered)
            ->get()
            ->getResultArray();

        // 4. Mapping id → data
        $map = [];
        foreach ($nomorCabor as $nc) {
            $map[$nc['id']] = $nc;
        }

        // 5. Susun ulang SESUAI URUTAN FIELD
        $result = [];
        foreach ($ids as $id) {
            if ($id && isset($map[$id])) {
                $result[] = [
                    'id' => $map[$id]['id'],
                    'nama' => $map[$id]['nama'],
                ];
            }
        }

        // 6. Set ke response
        $row['nomor_cabor'] = $result;

        return $row;
    }
}
