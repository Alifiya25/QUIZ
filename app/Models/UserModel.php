<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['username', 'email', 'password', 'role', 'google_id', 'password_reset_token', 'password_reset_expires', 'is_google_account'];

    // Secara default CodeIgniter akan otomatis menggunakan created_at dan updated_at jika kolom tersebut ada.
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    public function getUserById($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
    }

    public function getUsersByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }
}
