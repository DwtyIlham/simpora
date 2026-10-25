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

    public function getUserById($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function getUserByUsername($username)
    {
        return $this->where(['username' => $username], ['isActive' => '1'])->first();
    }

    public function getUserValidatorByUsername($username)
    {
        return $this->where(['username' => $username], ['role_id' => 4], ['isActive' => '1'])->first();
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
        $data['id'] = $this->generateUUID();
        return $this->insert($data);
    }

    public function getDataOperator()
    {
        $sql = $this->db->table('users u')->select('u.*, s.nama sekolah, s.kecamatan, s.bentuk_pendidikan')
            ->join('sekolah s', 'u.sekolah_id = s.id', 'left')
            ->where(['u.isActive' => '1'])
            ->orderBy('u.nama', 'ASC')
            ->get()->getResultArray();

        return $sql;
    }

    public function getDataValidator()
    {
        $sql = $this->db->table('users u')
            ->select('u.*')
            ->select('GROUP_CONCAT(DISTINCT c.nama ORDER BY c.nama ASC SEPARATOR ", ") AS cabor')
            ->select('GROUP_CONCAT(DISTINCT uv.cabor_id SEPARATOR ", ") AS cabor_id')
            ->join('users_validator uv', 'uv.user_id = u.id')
            ->join('cabor c', 'c.id = uv.cabor_id', 'left')

            ->where('u.isActive', '1')
            ->groupBy('uv.user_id')
            ->orderBy('u.nama', 'ASC')
            ->get()
            ->getResultArray();

        return $sql;
    }
}
