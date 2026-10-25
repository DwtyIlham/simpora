<?php

namespace App\Models;

use CodeIgniter\Model;

class CaborModel extends Model
{
    protected $table            = 'cabor';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    public function getNomorCabor()
    {
        $sql = $this->db->table('nomor_cabor')
            ->select('nomor_cabor.id, cabor_id, nomor_cabor.nama, kategori, detail, is_active, jenjang_id, jenjang.nama AS jenjang')
            ->join('jenjang', 'jenjang.id = nomor_cabor.jenjang_id')
            ->get();
        return $sql->getResultArray();
    }
    public function getNomorCaborData()
    {
        $sql = $this->db->table('nomor_cabor nc')
            ->select('nc.id, nc.cabor_id, nc.nama, j.nama jenjang, nc.kategori, nc.detail, nc.is_active, cabor.nama cabor')
            ->join('cabor', 'cabor.id = nc.cabor_id', 'left')
            ->join('jenjang j', 'j.id = nc.jenjang_id')
            ->get();
        return $sql->getResultArray();
    }

    public function getCaborForValidator($user_id)
    {
        $sql = $this->db->table('cabor c')
            ->select('c.id, c.nama')
            ->join('users_validator uv', 'uv.cabor_id = c.id')
            ->where('uv.user_id', $user_id)
            ->get();
        return $sql->getResultArray();
    }

    public function getNomorForEditAtlet($cabor_id)
    {
        return $this->db->table('nomor_cabor')->where('cabor_id', $cabor_id)->get()->getResultArray();
    }

    public function getBanyakNomorCabor($atlet_id)
    {
        return $this->db->table('cabor')->select('banyak_no_cabor')->join('atlet', 'atlet.cabor_id = cabor.id')->where('atlet.id', $atlet_id)->get()->getFirstRow('array');
    }
}
