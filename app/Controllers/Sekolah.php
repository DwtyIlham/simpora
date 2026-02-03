<?php

namespace App\Controllers;

use App\Models\AtletModel;
use App\Models\CaborModel;
use App\Models\UsersModel;
use App\Models\KompModel;
use App\Models\PesertaModel;
use Config\Encryption;
use Config\Services;
use Ramsey\Uuid\Uuid;


class Sekolah extends BaseController
{
    protected $db;
    protected $m_atlet;
    protected $m_cabor;
    protected $m_users;
    protected $m_komp;
    protected $m_peserta;
    protected $sekolah_id;

    public function __construct()
    {
        helper('form');
        $this->db = \Config\Database::connect();
        $this->m_atlet = new AtletModel();
        $this->m_cabor = new CaborModel();
        $this->m_users = new UsersModel();
        $this->m_komp = new KompModel();
        $this->m_peserta = new PesertaModel();
        $this->sekolah_id = session()->get('user')['sekolah_id'];
    }

    public function index(): string
    {
        return view('auth/login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    // Area Atlet
    public function dataAtlet()
    {
        $data = [
            'atlet'     => $this->m_atlet->getAtletDataBySekolah(),
            'cabor'    => $this->m_cabor->findAll(),
            'sekolah'   => $this->db->table('sekolah')->get()->getResultArray(),
        ];
        // dd($data['atlet']);
        return view('sekolah/atlet-data', $data);
    }

    public function addDataAtlet($id = null)
    {
        $data = [
            'sekolah' => $this->db->table('sekolah')->where('id', $this->sekolah_id)->get()->getFirstRow('array'),
            'cabor' => $this->m_cabor->findAll()
        ];

        if (!empty($id)) {
            $data['id'] = $id;
            $data['atlet'] = $this->m_atlet->where('id', $id)->first();
        }

        return view('sekolah/atlet-add', $data);
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
                        'max_size' => 'Ukuran maksimal 2MB.',
                        'mime_in'  => 'Format tidak valid (hanya jpg, jpeg, png, webp).'
                    ]
                ];
            } else {

                // Untuk file selain ijazah tetap wajib
                $validationRules[$file] = [
                    'rules' => "uploaded[$file]|max_size[$file,2048]|is_image[$file]|mime_in[$file,image/jpg,image/jpeg,image/png,image/webp]",
                    'errors' => [
                        'uploaded' => strtoupper(str_replace('_', ' ', $file)) . ' wajib diunggah.',
                        'max_size' => 'Ukuran maksimal 2MB.',
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
            return redirect()->to('/sekolah/atlet/add')->withInput();
        } elseif (empty($nik) || strlen($nik) != 16) {
            $this->session->setFlashdata('error', 'NIK harus diisi dan terdiri dari 16 digit angka.');
            return redirect()->to('/sekolah/atlet/add')->withInput();
        }

        // Validasi NISN
        $nisnExists = $this->m_atlet->where('nisn', $nisn)->first();
        if ($nisnExists) {
            $this->session->setFlashdata('error', 'NISN sudah terdaftar. Silahkan periksa kembali.');
            return redirect()->to('/sekolah/atlet/add')->withInput();
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
            return redirect()->to('/sekolah/atlet/add')->withInput();
        }

        return redirect()->to('/sekolah/atlet/data');
    }

    public function editDataAtlet($id)
    {
        $data = [
            'atlet' => $this->m_atlet->getAtletDetailByID($id),
            'cabor'    => $this->m_cabor->findAll(),
            'sekolah'   => $this->db->table('sekolah')->get()->getResultArray(),
        ];

        return view('sekolah/atlet-edit', $data);
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

        return redirect()->to('/sekolah/atlet/data');
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
        return redirect()->to('/sekolah/atlet/data');
    }
    // End Area Atlet

    // Area Users
    public function dataUsers()
    {
        $data = [
            'users'     => $this->db->table('users')->get()->getResultArray(),
        ];
        return view('sekolah/users-data', $data);
    }

    public function addDataUsers()
    {
        $data = [
            'users'     => $this->db->table('users')->get()->getResultArray(),
            'sekolah'   => $this->m_users->getSekolahNotRegistered()
        ];
        return view('sekolah/users-add', $data);
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
                return redirect()->to('/sekolah/users/add');
            }
            // hash password sebelum disimpan
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            // logika penyimpanan data registrasi ke database atau proses lainnya
            if ($this->m_users->register($data)) {
                // jika berhasil
                $this->session->setFlashdata('success', 'Registrasi berhasil. Silahkan login.');
                return redirect()->to('/sekolah/users/add');
            } else {
                // jika gagal
                $this->session->setFlashdata('error', 'Registrasi gagal. Silahkan coba lagi.');
                return redirect()->to('/sekolah/users/add');
            }
            return redirect()->to('sekolah/users/add');
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
                return redirect()->to('/sekolah/users/data');
            };

        endif;
    }

    public function deleteUser($id)
    {
        $this->m_users->delete($id);
        $this->session->setFlashdata('success', 'User berhasil dihapus.');
        return redirect()->to('/sekolah/users/data');
    }
    // End Area Users

    // Area Kompetisi

    public function dataKompetisi()
    {
        $data = [
            'title'     => 'Data Kompetisi',
            'kompetisi' => $this->m_komp->findAll()
        ];
        return view('sekolah/kompetisi-data', $data);
    }

    public function addDataKompetisi($id = '')
    {
        $data = [
            'title'     => 'Tambah Kompetisi'
        ];

        if ($id) {
            $data['kompetisi'] = $this->m_komp->where('id', $id)->first();
        }

        return view('sekolah/kompetisi-add', $data);
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

            return redirect()->to('/sekolah/kompetisi/add');
        }

        // Jika $id ada → Update
        if ($this->m_komp->update($id, $data)) {
            session()->setFlashdata('success', 'Data Kompetisi Berhasil Diubah.');
        } else {
            session()->setFlashdata('error', 'Data Kompetisi Gagal Diubah.');
        }

        return redirect()->to('/sekolah/kompetisi/data');
    }

    public function peserta($id_kompetisi)
    {
        $sekolah_id = session()->get('user')['sekolah_id'];
        $kompetisi = $this->m_komp->find($id_kompetisi)['nama'];
        $data = [
            'title'     => 'DATA PESERTA KOMPETISI ' . $kompetisi,
            'peserta'   => $this->m_peserta->getPesertaBySekolah($sekolah_id),
            'cabor'     => $this->m_cabor->findAll(),
            'sekolah'     => $this->db->table('sekolah')->get()->getResultArray(),
            'id_kompetisi'  => $id_kompetisi
        ];

        return view('sekolah/peserta-data', $data);
    }

    public function addDataPeserta($id_kompetisi)
    {
        $data = [
            'title'     => 'Tambah Kompetisi',
            'kompetisi' => $this->m_komp->find($id_kompetisi)['nama'],
            'atlet'     => $this->m_atlet->getAtletBlmDaftarBySekolah($id_kompetisi),
            'cabor'     => $this->m_cabor->findAll(),
            'id_kompetisi'  => $id_kompetisi
        ];

        return view('sekolah/peserta-add', $data);
    }

    public function addDataPeserta_attempt()
    {
        $atlet = $this->request->getPost('atlet');
        $kompetisi_id = $this->request->getPost('kompetisi');
        $cabor_id = $this->request->getPost('cabor');
        $nomor_cabor_id = $this->request->getPost('nomor_cabor');
        $error = 0;
        for ($i = 0; $i < sizeof($atlet); $i++):
            $data = [
                'id' => Uuid::uuid4()->toString(),
                'atlet_id'  => $atlet[$i],
                'kompetisi_id'  => $kompetisi_id,
                'cabor_id'  => $cabor_id,
                'nomor_cabor_id' => $nomor_cabor_id
            ];
            if ($this->m_peserta->insert($data)) {
                session()->setFlashdata('success', 'Data Peserta Berhasil Disimpan.');
            } else {
                $error += 1;
            };
        endfor;
        if ($error > 0) {
            session()->setFlashdata('error', 'Data Peserta Gagal Disimpan');
        }
        return redirect()->to('sekolah/kompetisi/peserta/' . $kompetisi_id);
    }

    public function addPesertaMultiCabor()
    {
        $peserta_id = $this->request->getPost('peserta_id');
        $nocaborBaru = $this->request->getPost('nocabor_baru');

        // Validasi sederhana
        if (empty($peserta_id) || empty($nocaborBaru)) {
            session()->setFlashdata('error', 'Data tidak lengkap.');
            return redirect()->back();
        }

        $data = [
            'nomor_cabor_id_2' => $nocaborBaru
        ];

        if ($this->m_peserta->update($peserta_id, $data)) {
            session()->setFlashdata('success', 'Data Peserta Berhasil Disimpan.');
        } else {
            session()->setFlashdata('error', 'Data Peserta Gagal Disimpan.');
        }

        return redirect()->back();
    }


    public function deletePeserta($id, $kompetisi_id)
    {
        if ($this->m_peserta->where('kompetisi_id', $kompetisi_id)->delete($id)) {
            $this->session->setFlashdata('success', 'Data Peserta berhasil dihapus.');
        } else {
            $this->session->setFlashdata('error', 'Data Peserta gagal dihapus.');
        }
        return redirect()->to('/sekolah/kompetisi/peserta/' . $kompetisi_id);
    }

    public function dataKompetisiPrestasi()
    {
        $data = [
            'title'     => 'Data Prestasi',
            'kompetisi' => $this->m_komp->findAll()
        ];
        return view('sekolah/prestasi-kompetisi', $data);
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

        return view('sekolah/prestasi-peserta', $data);
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
        return view('sekolah/prestasi-add', $data);
    }

    public function addDataPrestasi_attempt()
    {
        $id = $this->request->getPost('peserta_id');
        $kompetisi_id = $this->request->getPost('kompetisi_id');
        $prestasi_id = $this->request->getPost('prestasi_id');
        $data = ['prestasi' => $prestasi_id];
        if ($this->m_peserta->update($id, $data)) {
            session()->setFlashdata('success', 'Data Peserta Berhasil Disimpan.');
        } else {
            session()->setFlashdata('error', 'Data Peserta Gagal Disimpan');
        }
        return redirect()->to('sekolah/kompetisi/prestasi/' . encode_id($kompetisi_id));
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
        return view('sekolah/preview-idcard', $data);
    }
    // End Area Kompetisi
}
