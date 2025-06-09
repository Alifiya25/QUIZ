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
            $newName = $avatarFile->getRandomName();
            $avatarFile->move(FCPATH . 'uploads/avatars', $newName);

            $userId = $session->get('id');

            if ($userId) {
                $oldAvatar = $session->get('avatar');

                if ($oldAvatar && $oldAvatar !== 'default-avatar.png') {
                    $oldAvatarPath = WRITEPATH . '../public/uploads/avatars/' . $oldAvatar;
                    if (file_exists($oldAvatarPath)) {
                        unlink($oldAvatarPath);
                    }
                }

                $userModel->update($userId, ['foto_profile' => $newName]);
                $session->set('avatar', $newName);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Foto profil berhasil diupload!',
                    'avatar' => base_url('uploads/avatars/' . $newName)
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan.'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal upload foto profil!'
            ]);
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
