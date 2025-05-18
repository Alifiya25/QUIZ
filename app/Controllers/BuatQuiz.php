<?php

namespace App\Controllers;

use App\Models\SoalModel;
use App\Models\BuatQuizModel;
use App\Models\QuizSoalModel;
use CodeIgniter\Controller;

class BuatQuiz extends Controller
{
    protected $soalModel;
    protected $quizModel;
    protected $quizSoalModel;

    public function __construct()
    {
        $this->soalModel = new SoalModel();
        $this->quizModel = new BuatQuizModel();
        $this->quizSoalModel = new QuizSoalModel();
    }

    // Ambil semua soal dalam format JSON
    public function getSoal()
    {
        $soal = $this->soalModel->findAll();
        return $this->response->setJSON($soal);
    }

    // Tampilkan daftar quiz (view)
    public function list()
    {
        $data['quiz'] = $this->quizModel->findAll();
        return view('Soal/list_quiz', $data);
    }

    // Proses buat quiz
    public function create()
    {
        $request = service('request');

        $judul = $request->getPost('judul');
        $deskripsi = $request->getPost('deskripsi');
        $mode = $request->getPost('mode');
        $timer = $request->getPost('timer');
        $idSoalList = explode(',', $request->getPost('id_soal'));

        // Validasi sederhana
        if (empty($judul) || empty($mode) || empty($idSoalList)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap.'
            ]);
        }

        // Buat kode akses unik
        $kodeAkses = strtoupper(uniqid('QUIZ'));

        // Simpan quiz
        $quizId = $this->quizModel->insert([
            'judul'          => $judul,
            'deskripsi'      => $deskripsi,
            'mode'           => $mode,
            'timer'          => $mode === 'time' ? $timer : null,
            'kode_akses'     => $kodeAkses,
            'tanggal_dibuat' => date('Y-m-d H:i:s')
        ]);

        if (!$quizId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan quiz.'
            ]);
        }

        // Simpan relasi ke tabel quiz_soal
        foreach ($idSoalList as $idSoal) {
            $this->quizSoalModel->insert([
                'id_quiz' => $quizId,
                'id_soal' => $idSoal
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'kode_akses' => $kodeAkses
        ]);
    }
    
}
