<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Profile extends Controller
{
    public function uploadAvatar()
    {
        $session = session();
        $userModel = new UserModel();

        $avatarFile = $this->request->getFile('avatar');

        if ($avatarFile && $avatarFile->isValid() && !$avatarFile->hasMoved()) {
            // Generate nama random
            $newName = $avatarFile->getRandomName();
            // Pindahkan file ke folder uploads/avatars
            $avatarFile->move(WRITEPATH . '../public/uploads/avatars', $newName);

            // Ambil user_id dari session
            $userId = $session->get('id');


            if ($userId) {
                // Ambil nama avatar lama dari session
                $oldAvatar = $session->get('avatar');

                // Hapus file lama kalau bukan default-avatar
                if ($oldAvatar && $oldAvatar !== 'default-avatar.png') {
                    $oldAvatarPath = WRITEPATH . '../public/uploads/avatars/' . $oldAvatar;
                    if (file_exists($oldAvatarPath)) {
                        unlink($oldAvatarPath);
                    }
                }

                // Update kolom foto_profile di database
                $userModel->update($userId, ['foto_profile' => $newName]);

                // Update session avatar
                $session->set('avatar', $newName);

                // Set flashdata sukses
                $session->setFlashdata('success', 'Foto profil berhasil diupload!');
            } else {
                // Jika user_id tidak ditemukan di session
                $session->setFlashdata('error', 'User tidak ditemukan.');
            }

            // Redirect sesuai role
            return $this->redirectByRole();
        } else {
            // Jika upload gagal
            $session->setFlashdata('error', 'Gagal upload foto profil!');
            return $this->redirectByRole();
        }
    }

    private function redirectByRole()
    {
        $role = session()->get('role');

        if ($role === 'admin') {
            return redirect()->to(base_url('dashboard/admin'));
        } elseif ($role === 'peserta') {
            return redirect()->to(base_url('dashboard/peserta'));
        } else {
            return redirect()->to(base_url('/login'));
        }
    }
}
