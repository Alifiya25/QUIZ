<?php

namespace App\Controllers;

use App\Models\BuatQuizModel;
use CodeIgniter\Controller;

class BuatQuiz extends Controller
{
    public function index()
    {
        return view('buat_quiz');
    }

    public function create()
    {
        // Ambil data dari form
        $data = [
            'judul'        => $this->request->getPost('judul'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'mode'         => $this->request->getPost('mode'),
            'timer'        => $this->request->getPost('timer'),
            'kode_akses'   => strtoupper(bin2hex(random_bytes(6))), // Membuat kode akses unik
            'tanggal_dibuat' => date('Y-m-d H:i:s'),
        ];

        // Validasi data
        $quizModel = new BuatQuizModel();
        if (!$quizModel->save($data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan quiz.',
            ]);
        }

        // Ambil kode akses yang baru dibuat
        $kodeAkses = $data['kode_akses'];

        // Respons sukses dengan kode akses
        return $this->response->setJSON([
            'success' => true,
            'kode_akses' => $kodeAkses,
        ]);
    }
}
