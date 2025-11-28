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
}
