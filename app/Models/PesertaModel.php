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
        $sql = $this->db->table('peserta p')
            ->select([
                'p.id',
                'p.kompetisi_id',
                'p.atlet_id',
                'p.cabor_id',
                'a.nama AS atlet_nama',
                'a.sekolah_id',
                's.nama AS sekolah_nama',
                'c.nama AS cabor_nama',
                'GROUP_CONCAT(
                CONCAT(nc.nama, " ", nc.jenjang, " ", nc.kategori, " ", nc.detail)
                SEPARATOR "||"
            ) AS nomor_cabor'
            ])
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')
            ->join('nomor_cabor nc', 'nc.id IN (p.nomor_cabor_id, p.nomor_cabor_id_2)', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->where('a.sekolah_id', $sekolah_id)
            ->groupBy([
                'p.id',
                'p.kompetisi_id',
                'p.atlet_id',
                'a.nama',
                'a.sekolah_id',
                's.nama',
                'c.nama'
            ])
            ->get();

        return $sql->getResultArray();
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
                'p.nomor_cabor_id',

                'a.nama AS atlet_nama',
                'a.nik',
                'a.jenis_kelamin',
                'a.tanggal_lahir',

                's.nama AS sekolah_nama',
                'c.nama AS cabor_nama',
                'nc.nama AS nomor_cabor',

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
            ->join('nomor_cabor nc', 'nc.id = p.nomor_cabor_id', 'left')
            ->where('p.kompetisi_id', $id_kompetisi);

        return $sql->get()->getResultArray();
    }

    public function getDataPesertaPrestasi($id_kompetisi)
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
            ->where(['p.kompetisi_id' => $id_kompetisi, 'p.prestasi IS NOT NULL' => null, 'av.status_final' => 'valid']);

        return $sql->get()->getResultArray();
    }

    public function getPesertaKompetisiCaborSekolah($cabor_id, $sekolah_id)
    {
        $query = $this->setTable('peserta p')->select('p.*, a.nama, c.nama cabor')
            ->join('cabor c', 'c.id = p.cabor_id')
            ->join('atlet a', 'a.id = p.atlet_id')
            ->join('sekolah s', 'a.sekolah_id = s.id')
            ->where(['p.cabor_id' => $cabor_id, 'sekolah_id' => $sekolah_id])
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

    public function getDataPeserta($id_peserta)
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
                p.atlet_id,
                p.prestasi
            ')
            ->join('kompetisi k', 'k.id = p.kompetisi_id', 'left')
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')
            ->where('p.id', $id_peserta);

        return $sql->get()->getFirstRow('array');
    }
}
