<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    // Halaman Dashboard Admin
    public function admin()
    {
        // Cek apakah user sudah login dan memiliki role 'admin'
        if (!session()->get('logged_in') || session()->get('role') != 'admin') {
            return redirect()->to('/login'); // Jika tidak, redirect ke halaman login
        }

        // Tampilkan halaman dashboard admin
        return view('dashboard/admin');
    }

    // Halaman Dashboard Peserta (jika perlu, bisa diimplementasikan)
    public function peserta()
    {
        // Cek apakah user sudah login dan memiliki role 'peserta'
        if (!session()->get('logged_in') || session()->get('role') != 'peserta') {
            return redirect()->to('/login'); // Jika tidak, redirect ke halaman login
        }

        // Tampilkan halaman dashboard peserta
        return view('dashboard/peserta');
    }

    public function leaderboard(){
        return view('soal/leaderboard');
    }
}
