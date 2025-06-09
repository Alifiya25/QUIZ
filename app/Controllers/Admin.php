<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\QuizUserModel;

class Admin extends BaseController
{
    protected $adminModel;
    protected $quizUserModel;
    public function __construct()
    {
        $this->adminModel = new UserModel();
        $this->quizUserModel = new QuizUserModel();
    }

    public function daftar_peserta()
    {
        $sort = $this->request->getGet('sort');
        $search = $this->request->getGet('search');

        $order = ($sort === 'desc') ? 'DESC' : 'ASC';

        $builder = $this->adminModel->where('role', 'peserta');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('username', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        $peserta = $builder->orderBy('username', $order)->findAll();

        $data = [
            'title' => 'Daftar peserta',
            'peserta' => $peserta,
        ];

        return view('admin/daftar_peserta', $data);
    }



    public function daftar_admin()
    {
        $sort = $this->request->getGet('sort');
        $search = $this->request->getGet('search');

        $order = ($sort === 'desc') ? 'DESC' : 'ASC';

        $builder = $this->adminModel->where('role', 'admin');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('username', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        $admin = $builder->orderBy('username', $order)->findAll();

        $data = [
            'title' => 'Daftar admin',
            'admin' => $admin,
        ];

        return view('admin/daftar_admin', $data);
    }

    public function delete_Peserta($id = null)
    {
        // Cek apakah user masih digunakan di tabel quiz_user
        $relasiAda = $this->quizUserModel->where('id_user', $id)->countAllResults();

        if ($relasiAda > 0) {
            // Tidak boleh dihapus, tampilkan pesan
            session()->setFlashdata('error', 'User tidak bisa dihapus karena masih memiliki data quiz.');
            return redirect()->to('/admin/daftar_peserta');
        }

        // Jika tidak digunakan, baru hapus
        if ($this->adminModel->delete($id)) {
            session()->setFlashdata('message', 'User berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'User gagal dihapus.');
        }

        return redirect()->to('/admin/daftar_peserta');
    }


    public function delete_Admin($id = null)
    {
        // Cek apakah user masih digunakan di tabel quiz_user
        $relasiAda = $this->quizUserModel->where('id_user', $id)->countAllResults();

        if ($relasiAda > 0) {
            // Tidak boleh dihapus, tampilkan pesan
            session()->setFlashdata('error', 'User tidak bisa dihapus karena masih memiliki data quiz.');
            return redirect()->to('/admin/daftar_admin');
        }

        // Jika tidak digunakan, baru hapus
        if ($this->adminModel->delete($id)) {
            session()->setFlashdata('message', 'User berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'User gagal dihapus.');
        }

        return redirect()->to('/admin/daftar_admin');
    }

    public function create_admin()
    {
        session();
        return view('admin/form_tambah_admin', [
            'title' => 'Tambah Admin ',
            'validation' => session('validation') ?? \Config\Services::validation()
        ]);
    }


    public function save()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Username harus diisi.',
                    'min_length' => 'Username minimal 3 karakter.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Email tidak valid.',
                    'is_unique' => 'Email sudah terdaftar.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role harus dipilih.'
                ]
            ]
        ])) {
            return redirect()->to('/admin/form_tambah_admin')->withInput()->with('validation', \Config\Services::validation());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role')
        ];

        $this->adminModel->insert($data);
        return redirect()->to('/admin/daftar_admin')->with('message', 'Data berhasil ditambahkan!');
    }


    public function edit_admin($id)
    {
        $admin = $this->adminModel->find($id);
        if (!$admin) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Admin tidak ditemukan');
        }

        return view('admin/form_edit_admin', [
            'title' => 'Edit Admin',
            'user' => $admin
        ]);
    }

    public function update_admin($id)
    {
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'role'     => $this->request->getPost('role')
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->adminModel->update($id, $data);
        return redirect()->to('/admin/daftar_admin')->with('message', 'Data berhasil diperbarui!');
    }

    public function edit_peserta($id)
    {
        $peserta = $this->adminModel->find($id);
        if (!$peserta) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Peserta tidak ditemukan');
        }

        return view('admin/form_edit_peserta', [
            'title' => 'Edit Peserta',
            'user' => $peserta
        ]);
    }

    public function update_peserta($id)
    {
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'role'     => $this->request->getPost('role')
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->adminModel->update($id, $data);
        return redirect()->to('/admin/daftar_peserta')->with('message', 'Data berhasil diperbarui!');
    }

    public function about_us()
    {
        return view('admin/about_us', [
            'title' => 'About Us',
            'role' => session()->get('role')
        ]);
    }
}
