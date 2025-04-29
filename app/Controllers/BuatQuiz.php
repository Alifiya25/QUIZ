<?php

namespace App\Controllers;

use App\Models\BuatQuizModel;
use CodeIgniter\Controller;

class BuatQuiz extends Controller
{
    public function index()
    {
        return view('soal/index');
    }

    public function create()
    {
        // Ambil data dari form
        $data = [
            'judul'          => $this->request->getPost('judul'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'mode'           => $this->request->getPost('mode'),
            'timer'          => $this->request->getPost('timer') * 60, // menit dikali 60
            'kode_akses'     => strtoupper(bin2hex(random_bytes(6))),
            'tanggal_dibuat' => date('Y-m-d H:i:s'),
        ];

        // Validasi dan simpan
        $quizModel = new BuatQuizModel();
        if (!$quizModel->save($data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan quiz.',
            ]);
        }

        // Ambil kode akses yang baru dibuat
        $kodeAkses = $data['kode_akses'];

        // Respons sukses
        return $this->response->setJSON([
            'success' => true,
            'kode_akses' => $kodeAkses,
        ]);
    }

    public function list()
    {
        // Ambil data quiz dari model
        $buatQuizModel = new BuatQuizModel(); 
        $data['quiz'] = $buatQuizModel->findAll(); 

        // Kirim data ke view
        return view('soal/list_quiz', $data);
    }
}
