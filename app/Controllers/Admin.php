<?php

namespace App\Controllers;

use App\Models\AtletModel;
use App\Models\CaborModel;
use App\Models\UsersModel;
use App\Models\KompModel;
use App\Models\PesertaModel;
use App\Models\Traits\UuidTrait;
use Config\Encryption;
use Config\Services;
use Ramsey\Uuid\Uuid;

class Admin extends BaseController
{
    protected $db;
    protected $m_atlet;
    protected $m_cabor;
    protected $m_users;
    protected $m_komp;
    protected $m_peserta;

    public function __construct()
    {
        helper('form');
        $this->db = \Config\Database::connect();
        $this->m_atlet = new AtletModel();
        $this->m_cabor = new CaborModel();
        $this->m_users = new UsersModel();
        $this->m_komp = new KompModel();
        $this->m_peserta = new PesertaModel();
    }


    public function api()
    {
        $client = Services::curlrequest();
        $results = [];

        for ($i = 51; $i <= 100; $i++) {

            $username = '198503122025211' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $url = 'https://asndigital.bkn.go.id/api/forget-password?username=' . $username . '&token=$2b$10$zrhSYpWUPLyGhEHcxaAoj.QbpmKJTFkkP0E9AuCGQp5lmJ6x4Y0cq&captcha=tU8C';

            // Send the GET request
            $response = $client->get($url);

            // Capture details
            $results[] = [
                'username' => $username,
                'url'      => $url,
                'response' => $response->getBody(), // raw response
                // 'json'   => json_decode($response->getBody(), true), // use if JSON
            ];
        }

        return $this->response->setJSON($results);
    }



    public function index(): string
    {
        return view('auth/login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    // Area Operator
    public function dataOperator()
    {
        $data = [
            'title'     => 'Data Operator Sekolah',
            'data'      =>  $this->m_users->getDataOperator()
        ];

        return view('admin/operator-data', $data);
    }

    public function addOperator()
    {
        $data = [
            'title'     => 'Tambah Operator Sekolah',
            'sekolah'   => $this->m_users->getSekolahNotRegistered()
        ];

        return view('admin/operator-add', $data);
    }

    public function addOperator_attempt()
    {
        // mencoba mengambil data dari form registrasi
        $data = [
            'nama'          => $this->request->getPost('nama_lengkap'),
            'role_id'       => $this->request->getPost('role'),
            'username'      => $this->request->getPost('username'),
            'password'      => $this->request->getPost('password'),
            'sekolah_id'    => $this->request->getPost('sekolah_id'),
            'no_wa'         => $this->request->getPost('no_wa'),
        ];

        // cek apakah username sudah ada
        $existingUser = $this->m_users->getUserByUsername($data['username']);
        if ($existingUser) {
            $this->session->setFlashdata('error', 'Username sudah terpakai. Silahkan gunakan username lain.');
            return redirect()->to('/register');
        }
        // hash password sebelum disimpan
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        // logika penyimpanan data registrasi ke database atau proses lainnya
        if ($this->m_users->register($data)) {
            // jika berhasil
            $this->session->setFlashdata('success', 'Data operatorberhasil disimpan. Silahkan login.');
        } else {
            // jika gagal
            $this->session->setFlashdata('error', 'Data operator gagal disimpan. Silahkan coba lagi.');
            return redirect()->back();
        }
        return redirect()->to('admin/operator/data');
    }

    public function deleteOperator($id)
    {
        $this->m_users->delete($id);
        $this->session->setFlashdata('success', 'Operator berhasil dihapus.');
        return redirect()->to('/admin/operator/data');
    }
    // End Area Operator

    // Area Atlet
    public function dataAtlet()
    {
        $data = [
            'atlet'     => $this->m_atlet->getAtletData(),
            'cabor'    => $this->m_cabor->findAll(),
            'sekolah'   => $this->db->table('sekolah')->get()->getResultArray(),
        ];
        return view('admin/atlet-data', $data);
    }

    public function addDataAtlet($id = null)
    {
        $data = [
            'sekolah' => $this->db->table('sekolah')->get()->getResultArray(),
            'cabor' => $this->m_cabor->findAll()
        ];

        if (!empty($id)) {
            $data['id'] = $id;
            $data['atlet'] = $this->m_atlet->where('id', $id)->first();
        }

        return view('admin/atlet-add', $data);
    }

    public function addDataAtlet_attempt()
    {
        // Menyiapkan data dasar dari POST request
        $data = [
            'sekolah_id'    => $this->request->getPost('sekolah'),
            'cabor_id'      => $this->request->getPost('cabor'),
            'nik'           => $this->request->getPost('nik'),
            'nisn'          => $this->request->getPost('nisn'),
            'nama'          => $this->request->getPost('nama'),
            'alamat'        => $this->request->getPost('alamat'),
            'jenis_kelamin' => $this->request->getPost('jk'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'tempat_lahir'  => $this->request->getPost('tempat_lahir'),
        ];

        // Daftar file yang akan di-upload
        $files = ['file_kk', 'file_akte', 'file_nisn', 'file_foto', 'file_ktp_kia', 'file_ijazah'];

        // Validasi file upload
        $validationRules = [];

        foreach ($files as $file) {

            // Jika file ijazah, jadikan opsional (tanpa 'uploaded')
            if ($file === 'file_ijazah') {

                $validationRules[$file] = [
                    'rules' => "permit_empty|max_size[$file,2048]|mime_in[$file,image/jpg,image/jpeg,image/png,image/webp]",
                    'errors' => [
                        'max_size' => 'Ukuran {field} maksimal 2MB.',
                        'is_image' => 'File {field} harus berupa gambar.',
                        'mime_in'  => 'Format tidak valid (hanya jpg, jpeg, png, webp).'
                    ]
                ];
            } else {

                // Untuk file selain ijazah tetap wajib
                $validationRules[$file] = [
                    'rules' => "uploaded[$file]|max_size[$file,2048]|is_image[$file]|mime_in[$file,image/jpg,image/jpeg,image/png,image/webp]",
                    'errors' => [
                        'uploaded' => strtoupper(str_replace('_', ' ', $file)) . ' wajib diunggah.',
                        'is_image' => 'File {field} harus berupa gambar.',
                        'max_size' => 'Ukuran {field} maksimal 2MB.'
                    ]
                ];
            }
        }


        // Validasi data
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Proses upload file
        foreach ($files as $fileKey) {
            $file = $this->request->getFile($fileKey);

            // Hanya cek ukuran file minimal jika file diupload
            if ($file->getError() !== 4 && $file->getSize() < 99 * 1024) {
                return redirect()->back()->withInput()->with('error', $fileKey . ' minimal berukuran 100KB.');
            }

            // Jika ada file yang diupload
            if ($file && $file->getError() !== 4) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $path = FCPATH . '/uploads/atlet/' . $fileKey;

                    // Pastikan folder tujuan ada, jika tidak ada buat
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    // Pindahkan file
                    if ($file->move($path, $newName)) {
                        $data[$fileKey] = $newName;  // Simpan nama file di data
                    }
                }
            }
        }

        // Validasi NIK dan NISN (duplikasi dan format)
        $nik  = $this->request->getPost('nik');
        $nisn = $this->request->getPost('nisn');

        // Validasi NIK
        $nikExists = $this->m_atlet->where('nik', $nik)->first();
        if ($nikExists) {
            $this->session->setFlashdata('error', 'NIK sudah terdaftar. Silahkan periksa kembali.');
            return redirect()->to('/admin/atlet/add')->withInput();
        } elseif (empty($nik) || strlen($nik) != 16) {
            $this->session->setFlashdata('error', 'NIK harus diisi dan terdiri dari 16 digit angka.');
            return redirect()->to('/admin/atlet/add')->withInput();
        }

        // Validasi NISN
        $nisnExists = $this->m_atlet->where('nisn', $nisn)->first();
        if ($nisnExists) {
            $this->session->setFlashdata('error', 'NISN sudah terdaftar. Silahkan periksa kembali.');
            return redirect()->to('/admin/atlet/add')->withInput();
        }

        // Insert data atlet baru
        if ($this->m_atlet->insert($data)) {
            $atlet = $this->m_atlet->select('id')->where('nisn', $nisn)->first();
            if ($atlet) {
                $this->db->table('atlet_validasi')->insert(['atlet_id' => $atlet['id']]);
            }
            $this->session->setFlashdata('success', 'Data Atlet Berhasil Ditambahkan.');
        } else {
            $this->session->setFlashdata('error', 'Data Atlet Gagal Ditambahkan. Silahkan Coba Lagi.');
            return redirect()->to('/admin/atlet/add')->withInput();
        }

        return redirect()->to('/admin/atlet/data');
    }

    public function editDataAtlet($id)
    {
        $data = [
            'atlet' => $this->m_atlet->find($id),
            'sekolah' => $this->db->table('sekolah')->get()->getResultArray(),
            'cabor' => $this->m_cabor->findAll()
        ];

        return view('admin/atlet-edit', $data);
    }

    public function editDataAtlet_attempt($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'ID Atlet tidak valid.');
        }

        // Data dasar
        $data = [
            'sekolah_id'    => $this->request->getPost('sekolah'),
            'cabor_id'      => $this->request->getPost('cabor'),
            'nik'           => $this->request->getPost('nik'),
            'nisn'          => $this->request->getPost('nisn'),
            'nama'          => $this->request->getPost('nama'),
            'alamat'        => $this->request->getPost('alamat'),
            'jenis_kelamin' => $this->request->getPost('jk'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'tempat_lahir'  => $this->request->getPost('tempat_lahir'),
        ];


        // File yang digunakan
        $files = ['file_kk', 'file_akte', 'file_nisn', 'file_foto', 'file_ktp_kia', 'file_ijazah'];

        // --- VALIDASI FILE EDIT (opsional) ---
        $validationRules = [];
        foreach ($files as $file) {
            $validationRules[$file] = [
                'rules' => "max_size[$file,2048]|is_image[$file]|mime_in[$file,image/jpg,image/jpeg,image/png,image/webp]",
                'errors' => [
                    'max_size' => 'Ukuran maksimal 2MB.',
                    'is_image'  => 'Hanya File Tipe Gambar JPG/JPEG/PNG Yang Diizinkan.'
                ]
            ];
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data lama
        $oldData = $this->m_atlet->where('id', $id)->first();
        if (!$oldData) {
            return redirect()->back()->with('error', 'Data Atlet tidak ditemukan.');
        }

        // ---- PROSES UPLOAD FILE JIKA ADA ----
        foreach ($files as $fileKey) {

            $file = $this->request->getFile($fileKey);

            // Hanya jika ada file baru
            if ($file && $file->getError() !== 4) {

                // Cek minimal 100KB
                if ($file->getSize() < 100 * 1024) {
                    return redirect()->back()->withInput()->with('error', $fileKey . ' minimal berukuran 100KB.');
                }

                if ($file->isValid() && !$file->hasMoved()) {

                    $newName = $file->getRandomName();
                    $path = FCPATH . 'uploads/atlet/' . $fileKey;

                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    // Upload file baru
                    if ($file->move($path, $newName)) {
                        $data[$fileKey] = $newName;

                        // Hapus file lama jika ada
                        $oldFilePath = FCPATH . 'uploads/atlet/' . $fileKey . '/' . $oldData[$fileKey];
                        if ($oldData[$fileKey] && file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }

                        // Set status validasi → pending
                        $this->db->table('atlet_validasi')->update(
                            [str_replace('file_', '', $fileKey) . '_status' => 'pending'],
                            ['atlet_id' => $id]
                        );
                    }
                }
            }
        }

        // ---- VALIDASI NIK & NISN (tidak boleh bentrok dengan atlet lain) ----
        $nik = $this->request->getPost('nik');
        $nisn = $this->request->getPost('nisn');

        // Cek NIK
        $cekNik = $this->m_atlet->where('nik', $nik)->where('id !=', $id)->first();
        if ($cekNik) {
            return redirect()->back()->withInput()->with('error', 'NIK sudah dipakai atlet lain.');
        }

        // Cek NISN
        $cekNisn = $this->m_atlet->where('nisn', $nisn)->where('id !=', $id)->first();
        if ($cekNisn) {
            return redirect()->back()->withInput()->with('error', 'NISN sudah dipakai atlet lain.');
        }

        // ---- UPDATE DATA ----
        if ($this->m_atlet->update($id, $data)) {
            $this->session->setFlashdata('success', 'Data Atlet berhasil diperbarui.');
        } else {
            $this->session->setFlashdata('error', 'Gagal mengubah data atlet.');
        }

        return redirect()->to('/admin/atlet/data');
    }

    public function deleteAtlet($id)
    {
        $files = ['file_kk', 'file_akte', 'file_nisn', 'file_foto', 'file_ktp_kia', 'file_ijazah'];
        $oldFile = $this->m_atlet->find($id);
        if ($this->m_atlet->delete($id)) {
            foreach ($files as $file) {
                if (file_exists($oldFile[$file])) {
                    unlink($oldFile[$file]);
                }
            }
            $this->session->setFlashdata('success', 'Data Atlet berhasil dihapus.');
        } else {
            $this->session->setFlashdata('error', 'Data Atlet gagal dihapus.');
        }
        return redirect()->to('/admin/atlet/data');
    }
    // End Area Atlet

    // Area Users
    public function dataUsers()
    {
        $data = [
            'users'     => $this->db->table('users')->get()->getResultArray(),
        ];
        return view('admin/users-data', $data);
    }

    public function addDataUsers()
    {
        $data = [
            'users'     => $this->db->table('users')->get()->getResultArray(),
            'sekolah'   => $this->m_users->getSekolahNotRegistered()
        ];
        return view('admin/users-add', $data);
    }

    public function addDataUsers_attempt()
    {
        $id = $this->request->getPost('id') ?? null;
        if (empty($id)):
            // mencoba mengambil data dari form registrasi
            $data = [
                'nama'          => $this->request->getPost('nama'),
                'role_id'       => $this->request->getPost('role'),
                'username'      => $this->request->getPost('username'),
                'password'      => $this->request->getPost('password'),
                'sekolah_id'    => $this->request->getPost('sekolah'),
                'no_wa'         => $this->request->getPost('no_wa'),
            ];

            // cek apakah username sudah ada
            $existingUser = $this->m_users->getUserByUsername($data['username']);
            if ($existingUser) {
                $this->session->setFlashdata('error', 'Username sudah terpakai. Silahkan gunakan username lain.');
                return redirect()->to('/admin/users/add');
            }
            // hash password sebelum disimpan
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            // logika penyimpanan data registrasi ke database atau proses lainnya
            if ($this->m_users->register($data)) {
                // jika berhasil
                $this->session->setFlashdata('success', 'Registrasi berhasil. Silahkan login.');
                return redirect()->to('/admin/users/add');
            } else {
                // jika gagal
                $this->session->setFlashdata('error', 'Registrasi gagal. Silahkan coba lagi.');
                return redirect()->to('/admin/users/add');
            }
            return redirect()->to('admin/users/add');
        else:

            $data = [
                'nama'          => $this->request->getPost('nama'),
                'role_id'       => $this->request->getPost('role_id'),
                'username'      => $this->request->getPost('username'),
                'sekolah_id'    => $this->request->getPost('sekolah'),
                'no_wa'         => $this->request->getPost('no_wa'),
                'isActive'         => $this->request->getPost('isActive')
            ];

            if ($this->m_users->update($id, $data)) {
                $this->session->setFlashdata('success', 'User berhasil diperbarui.');
                return redirect()->to('/admin/users/data');
            };

        endif;
    }

    public function deleteUser($id)
    {
        $this->m_users->delete($id);
        $this->session->setFlashdata('success', 'User berhasil dihapus.');
        return redirect()->to('/admin/users/data');
    }
    // End Area Users

    // Area Kompetisi

    public function dataKompetisi()
    {
        $data = [
            'title'     => 'Data Kompetisi',
            'kompetisi' => $this->m_komp->findAll()
        ];
        return view('admin/kompetisi-data', $data);
    }

    public function addDataKompetisi($id = '')
    {
        $data = [
            'title'     => 'Tambah Kompetisi'
        ];

        if ($id) {
            $data['kompetisi'] = $this->m_komp->where('id', $id)->first();
        }

        return view('admin/kompetisi-add', $data);
    }

    public function addDataKompetisi_attempt($id = null)
    {
        // Ambil input
        $data = [
            'nama'          => $this->request->getPost('nama'),
            'tingkat'       => $this->request->getPost('tingkat'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'lokasi'        => $this->request->getPost('lokasi'),
            'tgl_start'     => $this->request->getPost('tgl_start'),
            'tgl_end'       => $this->request->getPost('tgl_end'),
            'tgl_reg_end'   => $this->request->getPost('tgl_reg_end')
        ];

        // Jika $id kosong → Insert
        if (empty($id)) {
            if ($this->m_komp->insert($data)) {
                session()->setFlashdata('success', 'Data Kompetisi Berhasil Disimpan.');
            } else {
                session()->setFlashdata('error', 'Data Kompetisi Gagal Disimpan.');
            }

            return redirect()->to('/admin/kompetisi/add');
        }

        // Jika $id ada → Update
        if ($this->m_komp->update($id, $data)) {
            session()->setFlashdata('success', 'Data Kompetisi Berhasil Diubah.');
        } else {
            session()->setFlashdata('error', 'Data Kompetisi Gagal Diubah.');
        }

        return redirect()->to('/admin/kompetisi/data');
    }

    public function peserta($id_kompetisi)
    {
        $kompetisi = $this->m_komp->find($id_kompetisi)['nama'];
        $data = [
            'title'     => 'DATA PESERTA KOMPETISI ' . $kompetisi,
            'peserta'   => $this->m_peserta->getDataPesertaKompetisi($id_kompetisi),
            'cabor'     => $this->m_cabor->findAll(),
            'sekolah'     => $this->db->table('sekolah')->get()->getResultArray(),
            'id_kompetisi'  => $id_kompetisi
        ];

        return view('admin/peserta-data', $data);
    }

    public function addDataPeserta($id_kompetisi)
    {
        $data = [
            'title'     => 'Tambah Kompetisi',
            'kompetisi' => $this->m_komp->find($id_kompetisi)['nama'],
            'atlet'     => $this->m_atlet->getAtletBlmDaftar($id_kompetisi),
            'cabor'     => $this->m_cabor->findAll(),
            'id_kompetisi'  => $id_kompetisi
        ];

        return view('admin/peserta-add', $data);
    }

    public function addDataPeserta_attempt()
    {
        $atlet = $this->request->getPost('atlet');
        $kompetisi_id = $this->request->getPost('kompetisi');
        $cabor_id = $this->request->getPost('cabor');
        $nomor_cabor_id = $this->request->getPost('nomor_cabor');

        for ($i = 0; $i < sizeof($atlet); $i++) {
            $data = [
                'id' => Uuid::uuid4()->toString(),
                'atlet_id' => $atlet[$i],
                'kompetisi_id' => $kompetisi_id,
                'cabor_id' => $cabor_id,
                'nomor_cabor_id' => $nomor_cabor_id
            ];

            if (!$this->m_peserta->insert($data)) {
                session()->setFlashdata('error', 'Data Peserta Gagal Disimpan');
                return redirect()->back();
            }
        }

        session()->setFlashdata('success', 'Data Peserta Berhasil Disimpan.');
        return redirect()->to('admin/kompetisi/peserta/' . $kompetisi_id);
    }


    public function deletePeserta($id, $kompetisi_id)
    {
        if ($this->m_peserta->where('kompetisi_id', $kompetisi_id)->delete($id)) {
            $this->session->setFlashdata('success', 'Data Peserta berhasil dihapus.');
        } else {
            $this->session->setFlashdata('error', 'Data Peserta gagal dihapus.');
        }
        return redirect()->to('/admin/kompetisi/peserta/' . $kompetisi_id);
    }

    public function dataKompetisiPrestasi()
    {
        $data = [
            'title'     => 'Data Prestasi',
            'kompetisi' => $this->m_komp->findAll()
        ];
        return view('admin/prestasi-kompetisi', $data);
    }

    public function dataKompetisiPrestasiPeserta($id_kompetisi)
    {
        $id_kompetisi = decode_id($id_kompetisi);
        $kompetisi = $this->m_komp->first($id_kompetisi)['nama'];
        $data = [
            'title'     => 'Data Prestasi ' . $kompetisi,
            'peserta'   => $this->m_peserta->getDataPesertaPrestasi($id_kompetisi),
            'cabor'     => $this->m_cabor->findAll(),
            'sekolah'   => $this->db->table('sekolah')->get()->getResultArray(),
            'id_kompetisi'  => $id_kompetisi
        ];

        return view('admin/prestasi-peserta', $data);
    }

    public function addDataPrestasi($id_kompetisi)
    {
        $id_kompetisi = decode_id($id_kompetisi);
        $kompetisi = $this->m_komp->first($id_kompetisi)['nama'];
        $data = [
            'title'         => 'Tambah Atlet Prestasi ' . $kompetisi,
            'sekolah'       => $this->db->table('sekolah')->get()->getResultArray(),
            'cabor'         => $this->m_cabor->findAll(),
            'kompetisi'     => $kompetisi,
            'id_kompetisi'  => $id_kompetisi
        ];
        return view('admin/prestasi-add', $data);
    }

    public function addDataPrestasi_attempt()
    {
        $id = $this->request->getPost('peserta_id');
        $kompetisi_id = $this->request->getPost('kompetisi_id');
        $prestasi_id = $this->request->getPost('prestasi_id');
        $data = ['prestasi' => $prestasi_id];
        if ($this->m_peserta->where('kompetisi_id', $kompetisi_id)->update($id, $data)) {
            session()->setFlashdata('success', 'Data Peserta Berhasil Disimpan.');
        } else {
            session()->setFlashdata('error', 'Data Peserta Gagal Disimpan');
        }
        return redirect()->to('admin/kompetisi/prestasi/' . encode_id($kompetisi_id));
    }

    public function editPrestasi_attempt()
    {
        $id = $this->request->getPost('peserta_id');
        $kompetisi_id = $this->request->getPost('kompetisi_id');
        $prestasi_id = $this->request->getPost('prestasi_id');
        $data = ['prestasi' => $prestasi_id];
        $rules = [
            'peserta_id' => 'required|is_natural_no_zero',
            'prestasi_id' => 'required|is_natural_no_zero'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid');
        }

        if ($this->m_peserta->update($id, $data)) {
            session()->setFlashdata('success', 'Data Peserta Berhasil Diperbarui.');
        } else {
            session()->setFlashdata('error', 'Data Peserta Gagal Diperbarui');
        }
        return redirect()->to('admin/kompetisi/prestasi/' . encode_id($kompetisi_id));
    }

    public function view_piagam($id_peserta)
    {
        $data = [
            'data'  => $this->m_peserta->getDataPeserta($id_peserta)
        ];

        return view('piagam/piagam', $data);
    }

    public function view_idcard_peserta($id_peserta)
    {
        $data = [
            'title'     => 'Unduh ID Card Peserta',
            'peserta'   => $this->m_peserta->getDataPesertaIDCard($id_peserta)
        ];
        return view('admin/preview-idcard', $data);
    }
    // End Area Kompetisi

    // Area Cabang Olahraga
    public function dataCabor()
    {
        $data = [
            'title' => 'Data Cabang Olahraga',
            'cabor' => $this->m_cabor->orderBy('nama')->findAll(),
            'nomcab'    => $this->m_cabor->getNomorCabor()
        ];
        return view('admin/cabor-data', $data);
    }

    public function addCabor()
    {
        $nama = $this->request->getPost('nama_cabor');
        $data = ['nama' => $nama];
        if ($this->m_cabor->insert($data)) {
            session()->setFlashdata('success', 'Data Cabor Berhasil Disimpan.');
        } else {
            session()->setFlashdata('error', 'Data Cabor Gagal Disimpan.');
        }
        return redirect()->to('admin/kompetisi/cabor');
    }

    public function editCabor()
    {
        $nama = $this->request->getPost('cabor_baru');
        $id = $this->request->getPost('id');
        $data = ['nama' => $nama];
        if ($this->m_cabor->update($id, $data)) {
            session()->setFlashdata('success', 'Data Cabor Berhasil Diubah.');
        } else {
            session()->setFlashdata('error', 'Data Cabor Gagal Diubah.');
        }
        return redirect()->to('admin/kompetisi/cabor');
    }

    public function deleteCabor($id)
    {
        if ($this->m_cabor->delete($id)) {
            session()->setFlashdata('success', 'Data Cabor Berhasil Dihapus.');
        } else {
            session()->setFlashdata('danger', 'Data Cabor Gagal Dihapus.');
        }
        return redirect()->to('admin/kompetisi/cabor');
    }

    public function dataNomorCabor()
    {
        $data = [
            'title' => 'Data Nomor Cabang Olahraga',
            'nomcab'    => $this->m_cabor->getNomorCaborData(),
            'cabor' => $this->m_cabor->orderBy('nama')->findAll()
        ];

        return view('admin/nomorcabor-data', $data);
    }

    public function addNomorCabor()
    {
        $cabor_id = $this->request->getPost('cabor_id');
        $nama = $this->request->getPost('nama');
        $jenjang = $this->request->getPost('jenjang');
        $kategori = $this->request->getPost('kategori');
        $detail = $this->request->getPost('detail');
        $data = [
            'cabor_id'  => $cabor_id,
            'nama'      => $nama,
            'jenjang'   => $jenjang,
            'kategori'  => $kategori,
            'detail'    => $detail
        ];

        if ($this->db->table('nomor_cabor')->insert($data)) {
            session()->setFlashdata('success', 'Data Nomor Cabor Berhasil Disimpan.');
        } else {
            session()->setFlashdata('success', 'Data Nomor Cabor Gagal Disimpan.');
        }
        return redirect()->to('admin/kompetisi/nomor-cabor');
    }

    public function editNomorCabor()
    {
        $id = $this->request->getPost('id');
        $cabor_id = $this->request->getPost('cabor_id');
        $nama = $this->request->getPost('nama');
        $jenjang = $this->request->getPost('jenjang');
        $kategori = $this->request->getPost('kategori');
        $detail = $this->request->getPost('detail');
        $data = [
            'cabor_id'  => $cabor_id,
            'nama'      => $nama,
            'jenjang'   => $jenjang,
            'kategori'  => $kategori,
            'detail'    => $detail
        ];

        if ($this->db->table('nomor_cabor')->update($data, ['id' => $id])) {
            session()->setFlashdata('success', 'Data Nomor Cabor Berhasil Diubah.');
        } else {
            session()->setFlashdata('success', 'Data Nomor Cabor Gagal Diubah.');
        }
        return redirect()->to('admin/kompetisi/nomor-cabor');
    }
    // End of Cabor

    // Area Jurnal Perolehan Medali
    public function jurnal_medali()
    {
        $data = [
            'title'     => 'Jurnal Perolehan Medali',
            'kompetisi' => $this->m_komp->findAll()
        ];

        return view('jurnal-medali', $data);
    }

    public function jurnal_medali_kab($id_kompetisi)
    {
        $kompetisi = $this->m_komp->find($id_kompetisi)['nama'];

        $data = [
            'title'     => 'JURNAL PEROLEHAN MEDALI ' . $kompetisi,
            'prestasi'   => $this->m_peserta->getDataPesertaPrestasi($id_kompetisi)
        ];


        return view('jurnal-medali-kab', $data);
    }

    // End of Medali

    // Area Validasi Peserta
    public function validasi_peserta($id)
    {
        $peserta = $this->m_peserta
            ->from('peserta p')
            ->select('p.*, a.file_foto, a.nama, s.nama sekolah, c.nama cabor, CONCAT(nc.nama, " ", nc.jenjang, " ", nc.kategori, " ", IFNULL(nc.detail, "")) AS nomor_cabor, k.nama kompetisi, k.deskripsi')
            ->join('atlet a', 'a.id = p.atlet_id')
            ->join('sekolah s', 's.id = a.sekolah_id')
            ->join('cabor c', 'c.id = p.cabor_id')
            ->join('nomor_cabor nc', 'nc.id = p.nomor_cabor_id')
            ->join('kompetisi k', 'k.id = p.kompetisi_id')
            ->where('p.id', $id)
            ->first();


        if (!$peserta) {
            return view('verifikasi_invalid');
        }

        return view('verifikasi_valid', [
            'peserta' => $peserta
        ]);
    }

    // Reset Password

    public function ganti_password()
    {
        $user_id = $this->request->getGet('id');
        $data = [
            'title' => 'Ganti Password',
            'user' => $this->m_users->getUserById($user_id),
            'user_id'   => $user_id
        ];

        return view('auth/ganti-password', $data);
    }

    public function ganti_password_attempt()
    {
        $user_id          = $this->request->getPost('user_id');
        $currentPassword  = $this->request->getPost('current_password');
        $newPassword      = $this->request->getPost('new_password');
        $confirmPassword  = $this->request->getPost('confirm_password');

        // Ambil data user
        $user = $this->m_users->find($user_id);

        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan.'
            ]);
        }

        // Cek password lama
        if (!password_verify($currentPassword, $user['password'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Password saat ini salah.'
            ]);
        }

        // Cek konfirmasi password
        if ($newPassword !== $confirmPassword) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Konfirmasi password tidak cocok.'
            ]);
        }

        // Hash password baru
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update
        $update = $this->m_users->update($user_id, [
            'password' => $hashedPassword
        ]);

        if ($update) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Password berhasil diganti.'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengganti password.'
        ]);
    }
}
