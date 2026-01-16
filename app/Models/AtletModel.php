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

    public function getAtletData()
    {
        $sql = $this->db->table('atlet')->select('atlet.*, av.kk_status, akte_status, av.foto_status,
                av.ijazah_status, av.nisn_status, av.ktp_kia_status, s.nama sekolah, c.nama cabor')
            ->join('sekolah s', 'atlet.sekolah_id = s.id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = atlet.id', 'left')
            ->join('cabor c', 'c.id = atlet.cabor_id', 'left');

        return $sql->get()->getResultArray();
    }

    public function getAtletDataBySekolah()
    {
        $sql = $this->db->table('atlet')->select('atlet.*, av.kk_status, akte_status, av.foto_status,
                av.ijazah_status, av.nisn_status, av.ktp_kia_status, s.nama sekolah, c.nama cabor')
            ->join('sekolah s', 'atlet.sekolah_id = s.id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = atlet.id', 'left')
            ->join('cabor c', 'c.id = atlet.cabor_id', 'left')
            ->where('atlet.sekolah_id', session()->get('user')['sekolah_id']);

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

    public function getAtletDetailByID($id)
    {
        $sql = $this->db->table('atlet')->select('atlet.*, av.kk_status, akte_status, av.foto_status,
                av.ijazah_status, av.nisn_status, av.ktp_kia_status, s.nama sekolah, s.id sekolah_id, c.nama cabor')
            ->join('sekolah s', 'atlet.sekolah_id = s.id', 'left')
            ->join('atlet_validasi av', 'av.atlet_id = atlet.id', 'left')
            ->join('cabor c', 'c.id = atlet.cabor_id', 'left')
            ->where('atlet.id', $id);

        return $sql->get()->getRowArray();
    }
}
