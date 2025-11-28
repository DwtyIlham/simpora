<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AtletModel;
use App\Models\CaborModel;
use App\Models\UsersModel;
use SebastianBergmann\CodeCoverage\Driver\Selector;

class Api extends BaseController
{
    protected $db;
    protected $m_atlet;
    protected $m_cabor;
    protected $m_users;

    public function __construct()
    {
        helper('form');
        $this->db = \Config\Database::connect();
        $this->m_atlet = new AtletModel();
        $this->m_cabor = new CaborModel();
        $this->m_users = new UsersModel();
    }

    public function getDataAtletKab()
    {
        $request = service('request');

        $cabor_id   = $request->getGet('cabor_id');
        $sekolah_id = $request->getGet('sekolah_id');

        $draw   = $request->getGet('draw');
        $start  = $request->getGet('start');
        $length = $request->getGet('length');
        $search = $request->getGet('search')['value'];
        $order_col = $request->getGet('order')[0]['column'];
        $order_dir = $request->getGet('order')[0]['dir'];

        $columns = [
            'nama',
            'jk',
            'tanggal_lahir',
            'cabor',
            'sekolah'
        ];

        $builder = $this->db->table('atlet')
            ->select('atlet.*, s.nama sekolah, c.nama cabor')
            ->join('sekolah s', 'atlet.sekolah_id = s.id', 'left')
            ->join('cabor c', 'c.id = atlet.cabor_id', 'left');

        // FILTER
        if ($cabor_id) {
            $builder->where('cabor_id', $cabor_id);
        }

        if ($sekolah_id) {
            $builder->where('sekolah_id', $sekolah_id);
        }

        // SEARCH
        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->orLike('cabor', $search)
                ->orLike('sekolah', $search)
                ->groupEnd();
        }

        // TOTAL DATA SEBELUM FILTER
        $totalData = $this->db->table('atlet')->countAllResults(false);

        // CLONE untuk counting
        $builderCount = clone $builder;
        $filteredData = $builderCount->countAllResults(false);

        // ORDER + LIMIT
        $builder->orderBy($columns[$order_col], $order_dir);
        $builder->limit($length, $start);

        // GET RESULT
        $data = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'draw'            => intval($draw),
            'recordsTotal'    => $totalData,
            'recordsFiltered' => $filteredData,
            'data'            => $data
        ]);
    }

    public function getDetailAtlet()
    {
        $atletID = $this->request->getGet('id');
        $data = $this->m_atlet->select('atlet.*, s.nama sekolah, c.nama cabor')
            ->join('cabor c', 'c.id = atlet.cabor_id')
            ->join('sekolah s', 's.id = atlet.sekolah_id')
            ->where('atlet.id', $atletID)
            ->first($atletID);
        $validasi = $this->db->table('atlet_validasi')->where('atlet_id', $atletID)->get()->getFirstRow('array');

        return $this->response->setJSON(['data' => $data, 'validasi' => $validasi]);
    }

    public function init_atlet_validasi()
    {
        $atletID = $this->request->getPost('atlet_id');

        $isExist = $this->db->table('atlet_validasi')->where('atlet_id', $atletID)->countAllResults() > 0;

        if (!$isExist) {
            $this->db->table('atlet_validasi')->insert(['atlet_id' => $atletID]);
            return $this->response->setJSON([
                'status' => 'success'
            ]);
        }
        return $this->response->setJSON([
            'status' => 'exist'
        ]);
    }


    public function validasi_dokumen()
    {
        $atlet_id = $this->request->getGet('atletID');
        $data = [
            $this->request->getGet('dok') => $this->request->getGet('status')
        ];

        $sql = $this->db->table('atlet_validasi')->update($data, ['atlet_id' => $atlet_id]);
        return $this->response->setJSON($sql);
    }

    public function validasi_atlet()
    {
        $atlet_id = $this->request->getGet('atletID');
        $sql = $this->db->table('atlet_validasi')->select('kk_status, nisn_status, ktp_kia_status, foto_status, ijazah_status, akte_status')
            ->where('atlet_id', $atlet_id)->get()->getFirstRow('array');
        return $this->response->setJSON($sql);
    }
}
