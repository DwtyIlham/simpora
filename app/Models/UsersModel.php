<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Traits\UuidTrait;

class UsersModel extends Model
{
    use UuidTrait;

    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;

    protected $beforeInsert = ['insertUUID'];

    public function getUserByUsername($username)
    {
        return $this->where(['username' => $username], ['isActive' => '1'])->first();
    }

    public function getSekolahNotRegistered()
    {
        $result = $this->db->table('sekolah s')
            ->select('s.*, u.nama nama_lengkap, u.username')
            ->join('users u', 's.id = u.sekolah_id', 'left')
            ->where('u.username IS NULL')->get()->getResultArray();
        return $result;
    }

    public function register($data)
    {
        return $this->insert($data);
    }

    public function getDataOperator()
    {
        $sql = $this->db->table('users u')->select('u.id, u.nama, u.no_wa, u.isActive, s.nama sekolah, s.kecamatan, s.bentuk_pendidikan')
            ->join('sekolah s', 'u.sekolah_id = s.id')->where(['u.role_id' => '2'])
            ->get()->getResultArray();

        return $sql;
    }
}
