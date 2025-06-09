<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Auth extends Controller
{

    // Fungsi untuk menampilkan halaman login
    public function login()
    {
        return view('auth/login');
    }

    // Fungsi untuk proses login
    public function processLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'logged_in' => true,
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
                'avatar'   => $user['foto_profile'] ?? 'default-avatar.png'
            ]);

            if ($user['role'] == 'admin') {
                return redirect()->to('/dashboard/admin');
            } else {
                return redirect()->to('/dashboard/peserta');
            }
        } else {
            session()->setFlashdata('error', 'Email atau Password salah.');
            return redirect()->to('/login');
        }
    }


    // Fungsi untuk menampilkan halaman registrasi
    public function register()
    {
        return view('auth/register');
    }

public function processRegister()
{
    $rules = [
        'username' => [
            'label' => 'Username',
            'rules' => 'required|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z0-9_]+$/]',
            'errors' => [
                'required' => '{field} wajib diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 50 karakter.',
                'regex_match' => '{field} hanya boleh mengandung huruf, angka, dan underscore (_). Tidak boleh ada spasi atau karakter lain.'
            ]
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[users.email]',
            'errors' => [
                'required' => '{field} wajib diisi.',
                'valid_email' => '{field} harus berupa alamat email yang valid.',
                'is_unique' => '{field} sudah digunakan, silakan gunakan email lain.'
            ]
        ],
        'password' => [
            'label' => 'Password',
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required' => '{field} wajib diisi.',
                'min_length' => '{field} minimal 8 karakter.'
            ]
        ],
        'password_confirm' => [
            'label' => 'Konfirmasi Password',
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => '{field} wajib diisi.',
                'matches' => '{field} tidak cocok dengan password.'
            ]
        ],
        'role' => [
            'label' => 'Role',
            'rules' => 'required|in_list[admin,peserta]',
            'errors' => [
                'required' => '{field} wajib diisi.',
                'in_list' => '{field} harus diisi dengan admin atau peserta.'
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        // Redirect kembali ke form dengan input lama dan error
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $userModel = new UserModel();

    $userModel->save([
        'username' => $this->request->getPost('username'),
        'email' => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role' => $this->request->getPost('role'),
    ]);

    // Kirim email pemberitahuan pendaftaran berhasil
    $emailService = \Config\Services::email();
    $emailService->setFrom('noreply@yourapp.com', 'QUIZZY');
    $emailService->setTo($this->request->getPost('email'));
    $emailService->setSubject('Registrasi Berhasil');
    $emailService->setMailType('html');
    $emailService->setMessage("
        <html>
            <head><title>Registrasi Berhasil</title></head>
            <body>
                <h2>Halo {$this->request->getPost('username')},</h2>
                <p>Terima kasih telah mendaftar di aplikasi kami. Akun Anda telah berhasil dibuat.</p>
                <p>Silakan login dan mulai gunakan aplikasinya!</p>
                <br>
                <p>Salam,</p>
                <p><strong>Tim Kami</strong></p>
            </body>
        </html>
    ");

    if (!$emailService->send()) {
        session()->setFlashdata('warning', 'Registrasi berhasil, tapi gagal mengirim email notifikasi.');
    } else {
        session()->setFlashdata('success', 'Registrasi berhasil! Silakan cek email Anda dan login.');
    }

    return redirect()->to('/login');
}

    // Fungsi logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Fungsi untuk menampilkan halaman lupa password
    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function sendResetLink()
    {
        $email = $this->request->getPost('email');

        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            session()->setFlashdata('error', 'Email tidak valid');
            return redirect()->to('/forgot-password');
        }

        $emailService = \Config\Services::email();
        $emailService->setFrom('your-email@example.com', 'Your App');
        $emailService->setTo($email);
        $emailService->setSubject('Link Reset Password');
        $emailService->setMessage('Klik link berikut untuk mereset password Anda: ' . base_url('reset-password') . '/' . md5($email));

        if ($emailService->send()) {
            session()->setFlashdata('success', 'Link reset sudah dikirim ke email: ' . $email);
        } else {
            session()->setFlashdata('error', 'Gagal mengirim email. Coba lagi nanti.');
        }

        return redirect()->to('/login');
    }

    public function resetPassword($emailHash)
    {
        return view('auth/reset_password', ['emailHash' => $emailHash]);
    }

    public function processResetPassword()
    {
    helper(['form']);
    $emailHash = $this->request->getPost('emailHash');
    $newPassword = $this->request->getPost('password');

    if (!$emailHash || !$newPassword) {
        return redirect()->to('reset-password')->with('error', 'Data tidak lengkap');
    }

    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('MD5(email)', $emailHash)->first();

    if (!$user) {
        return redirect()->to('reset-password')->with('error', 'Link reset tidak valid');
    }

    $userModel->update($user['id'], [
        'password' => password_hash($newPassword, PASSWORD_DEFAULT)
    ]);

    return redirect()->to('/login')->with('success', 'Password berhasil direset. Silakan login.');
    }

}