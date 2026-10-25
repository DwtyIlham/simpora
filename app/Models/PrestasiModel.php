<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;
use Override;

use function App\Controllers\decode_id;

class PrestasiModel extends Model
{
    protected $db;
    protected $table            = 'prestasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getDataValidasiPiagam($id_prestasi)
    {
        $id_prestasi = decode_id($id_prestasi);
        $data = $this->db->table($this->table . ' p')->select('p.prestasi, a.nama AS nama_atlet, a.file_foto, k.nama AS nama_kompetisi, c.nama AS nama_cabor, nc.nama AS nama_nomor')
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('kompetisi k', 'k.id = p.kompetisi_id', 'left')
            ->join('cabor c', 'c.id = p.cabor_id', 'left')
            ->join('nomor_cabor nc', 'nc.id = p.nomor_cabor_id', 'left')
            ->where('p.id', $id_prestasi)
            ->get()->getFirstRow('array');

        return $data;
    }
}
