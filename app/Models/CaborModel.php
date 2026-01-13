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
        $sql = $this->db->table('nomor_cabor')->select('id, cabor_id, nama, jenjang, kategori, detail, is_active')->get();
        return $sql->getResultArray();
    }
    public function getNomorCaborData()
    {
        $sql = $this->db->table('nomor_cabor nc')->select('nc.id, nc.cabor_id, nc.nama, nc.jenjang, nc.kategori, nc.detail, nc.is_active, cabor.nama cabor')
            ->join('cabor', 'cabor.id = nc.cabor_id', 'left')
            ->get();
        return $sql->getResultArray();
    }
}
