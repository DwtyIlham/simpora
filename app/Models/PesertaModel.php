<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaModel extends Model
{
    protected $table            = 'peserta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;

    public function getDataPesertaKompetisi($id_kompetisi)
    {
        $sql = $this->db->table('kompetisi k')
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
                av.status_final
            ')
            ->join('peserta p', 'p.kompetisi_id = k.id', 'left')
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = p.atlet_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')
            ->where('p.kompetisi_id', $id_kompetisi)
            ->where('av.status_final', 'valid');

        return $sql->get()->getResultArray();
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
}
