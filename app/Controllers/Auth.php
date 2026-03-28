<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    protected $db;
    protected $m_users;

    public function __construct()
    {
        $this->m_users = new \App\Models\UsersModel();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        if ($username && $password) {
            $user = $this->m_users->getUserByUsername($username);
            $errors = [
                '1' => 'Username atau Password Salah. Silahkan Coba Lagi.',
                '2' => 'Akun Tidak Aktif. Silahkan Hubungi Administrator',
            ];
            if ($user) {
                if ($user['isActive'] == '1' && password_verify($password, $user['password'])) {
                    if ($user['role_id'] == '2') {
                        $this->session->set('isLoggedIn', true);
                        $this->session->set('user', [
                            'id' => $user['id'],
                            'nama' => $user['nama'],
                            'username' => $user['username'],
                            'role_id' => $user['role_id'],
                            'sekolah_id' => $user['sekolah_id'],
                        ]);
                        $this->session->setFlashdata('welcome', 'Selamat Datang ' . $user['nama']);
                        return redirect()->to('sekolah/dashboard');
                    } else {
                        $this->session->set('isLoggedIn', true);
                        $this->session->set('user', [
                            'id' => $user['id'],
                            'nama' => $user['nama'],
                            'username' => $user['username'],
                            'role_id' => $user['role_id'],
                            'sekolah_id' => $user['sekolah_id'],
                        ]);
                        $this->session->setFlashdata('welcome', 'Selamat Datang ' . $user['nama']);
                        return redirect()->to('/dashboard');
                    }
                } else {
                    if ($user['isActive'] != '1') {
                        $this->session->setFlashdata('error', $errors[2]);
                    } else {
                        $this->session->setFlashdata('error', $errors[1]);
                    }
                    return redirect()->to('/');
                }
            } else {
                $this->session->setFlashdata('error', $errors[1]);
                return redirect()->to('/');
            }
        } else {
            $this->session->setFlashdata('error', 'Username dan Password harus diisi.');
            return redirect()->to('/');
        }
    }

    public function register()
    {
        $data = [
            // 'sekolah' => $this->db->table('sekolah')->get()->getResultArray(),
            'sekolah' => $this->m_users->getSekolahNotRegistered()
        ];
        return view('auth/register', $data);
    }

    public function register_attempt()
    {
        helper(['form']);

        $ip = $this->request->getIPAddress();

        $cache = cache();
        $key = 'register_' . $ip;

        $count = $cache->get($key) ?? 0;

        if ($count >= 5) {

            $this->session->setFlashdata('error', 'Terlalu banyak percobaan registrasi.');
            return redirect()->to('/register');
        }

        $cache->save($key, $count + 1, 300); // 5 menit

        $rules = [
            'nama' => [
                'rules' => 'required|alpha_numeric_space|min_length[3]|max_length[100]'
            ],
            'username' => [
                'rules' => 'required|alpha_numeric|min_length[4]|max_length[20]'
            ],
            'password' => [
                'rules' => 'required|min_length[6]|max_length[50]'
            ],
            'no_wa' => [
                'rules' => 'required|numeric|min_length[10]|max_length[15]'
            ],
            'role' => [
                'rules' => 'required|numeric'
            ],
            'sekolah' => [
                'rules' => 'required'
            ]
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', 'Data tidak valid.');
            return redirect()->to('/register')->withInput();
        }

        // ambil data setelah validasi
        $data = [

            'nama'       => $this->request->getPost('nama'),
            'role_id'    => $this->request->getPost('role'),
            'username'   => $this->request->getPost('username'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'sekolah_id' => $this->request->getPost('sekolah'),
            'no_wa'      => $this->request->getPost('no_wa'),

        ];

        $data = array_map('trim', $data);

        // cek username
        $existingUser = $this->m_users->getUserByUsername($data['username']);

        if ($existingUser) {

            $this->session->setFlashdata('error', 'Username sudah terpakai.');
            return redirect()->to('/register')->withInput();
        }

        if ($this->m_users->register($data)) {

            $this->session->setFlashdata('success', 'Registrasi berhasil. Silahkan login.');
            return redirect()->to('/');
        } else {

            $this->session->setFlashdata('error', 'Registrasi gagal.');
            return redirect()->to('/register')->withInput();
        }
    }

    public function ganti_password($id)
    {
        $data = [
            'title' => 'Ganti Password',
            'user' => $this->m_users->getUserById($id)
        ];

        return view('auth/ganti_password', $data);
    }

    public function logout(): ResponseInterface
    {
        $this->session->destroy();
        return redirect()->to('/');
    }
}
