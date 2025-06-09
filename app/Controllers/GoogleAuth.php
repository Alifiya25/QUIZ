<?php

namespace App\Controllers;

use Google_Client;
use Google_Service_Oauth2;
use App\Models\UserModel;

class GoogleAuth extends BaseController
{
    public function redirect()
{
    $client = new Google_Client();
    $client->setClientId(getenv('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(getenv('GOOGLE_REDIRECT_URI'));
    $client->addScope('email');
    $client->addScope('profile');

    // Tambahkan prompt=select_account supaya muncul pilihan akun Google
    $client->setPrompt('select_account');

    $authUrl = $client->createAuthUrl();
    return redirect()->to($authUrl);
}

    public function callback()
    {
        $client = new Google_Client();
        $client->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(getenv('GOOGLE_REDIRECT_URI'));

        $code = $this->request->getGet('code');
        if (!$code) {
            return redirect()->to('/login')->with('error', 'Kode otorisasi tidak ditemukan.');
        }

        $token = $client->fetchAccessTokenWithAuthCode($code);
        if (isset($token['error'])) {
            return redirect()->to('/login')->with('error', 'Gagal mendapatkan token dari Google.');
        }

        $client->setAccessToken($token);
        $oauth2 = new Google_Service_Oauth2($client);
        $userInfo = $oauth2->userinfo->get();

        $userModel = new UserModel();
        $user = $userModel->where('email', $userInfo->email)->first();

        // Jika user tidak ditemukan, simpan sebagai akun Google
        if (!$user) {
            $userData = [
                'email'             => $userInfo->email,
                'username'          => $userInfo->name ?? 'user_' . uniqid(),
                'password'          => password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT),
                'role'              => 'peserta',
                'is_google_account' => true
            ];
            $userModel->save($userData);
            $user = $userModel->where('email', $userInfo->email)->first();
        }

        // Jika masih Google account → minta atur password
        if ($user['is_google_account']) {
            session()->set('atur_password_user_id', $user['id']);
            return redirect()->to('/atur-password');
        }

        // Kalau sudah pernah atur password → login biasa
        session()->set([
            'user_id' => $user['id'],
            'role'    => $user['role'],
            'user'    => $user,
        ]);

        return redirect()->to('/dashboard/' . $user['role']);
    }

    public function aturPassword()
    {
        $userId = session()->get('atur_password_user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid.');
        }

        return view('auth/atur_password');
    }

    public function simpanPassword()
    {
        $userId = session()->get('atur_password_user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid.');
        }

        $password   = $this->request->getPost('password');
        $konfirmasi = $this->request->getPost('konfirmasi');

        if ($password !== $konfirmasi) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        $userModel = new UserModel();
        $userModel->update($userId, [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'is_google_account' => false
        ]);

        session()->remove('atur_password_user_id');

        return redirect()->to('/login')->with('success', 'Password berhasil disetel. Silakan login.');
    }
}
