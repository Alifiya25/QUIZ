<?php

namespace App\Controllers;

use App\Models\BuatQuizModel;

class QuizController extends BaseController
{
    public function joinQuiz()
{
    $kode = $this->request->getPost('kode_akses');
    $model = new BuatQuizModel();
    $quizUserModel = new \App\Models\QuizUserModel();

    $quiz = $model->where('kode_akses', $kode)->first();

    if (!$quiz) {
        return redirect()->back()->with('error', 'Kode akses tidak ditemukan.');
    }

    $userId = session()->get('id');
    if (!$userId) {
        return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Cek apakah user sudah pernah mengikuti quiz ini
    $hasJoined = $quizUserModel->where('id_user', $userId)
                              ->where('id_quiz', $quiz['id_quiz'])
                              ->first();

    if ($hasJoined) {
        return redirect()->back()->with('error', 'Anda sudah pernah mengikuti quiz ini.');
    }

    // Simpan ke tabel quiz_user
        $quizUserModel->insert([
        'id_user' => $userId,
        'id_quiz' => $quiz['id_quiz'],
        'waktu_mulai' => date('Y-m-d H:i:s'),
    ]);

    // Jika belum pernah ikut, set session dan redirect ke halaman siap quiz
    session()->set('quiz_id', $quiz['id_quiz']);
    session()->set('quiz_title', $quiz['judul']);
    session()->set('soal_index', 0);
    session()->remove('answers');
    session()->remove('quiz_start_time');

    return redirect()->to('/quiz-ready');
}


    public function quizReady()
    {
        // Tampilkan info quiz dan tombol mulai quiz
        return view('quiz/quiz_ready');
    }

    public function quizShow($quizId = null, $nomor = 1)
    {
        if (!$quizId) {
            return redirect()->to('/')->with('error', 'Quiz tidak ditemukan.');
        }

        $db = \Config\Database::connect();

        $quiz = $db->table('quiz')->where('id_quiz', $quizId)->get()->getRowArray();
        if (!$quiz) {
            return redirect()->to('/')->with('error', 'Quiz tidak ditemukan.');
        }

        $builder = $db->table('quiz_soal');
        $builder->select('soal.id_soal, soal.soal, soal.pilihan_a, soal.pilihan_b, soal.pilihan_c, soal.pilihan_d, soal.jawaban_benar');
        $builder->join('soal', 'soal.id_soal = quiz_soal.id_soal');
        $builder->where('quiz_soal.id_quiz', $quizId);
        $builder->orderBy('quiz_soal.id', 'ASC');
        $soal = $builder->get()->getResultArray();

        if (empty($soal)) {
            return "Quiz tidak ditemukan atau soal kosong.";
        }

        if ($nomor < 1 || $nomor > count($soal)) {
            return "Nomor soal tidak valid.";
        }

        $currentSoal = $soal[$nomor - 1];

        if (!session()->has('quiz_start_time')) {
            session()->set('quiz_start_time', time());
        }

        $timer = (int)$quiz['timer'];

        $data = [
            'quizId' => $quizId,
            'nomor' => $nomor,
            'totalSoal' => count($soal),
            'soal' => $currentSoal,
            'timer' => $timer,
            'quiz_start_time' => session()->get('quiz_start_time'),
        ];

        return view('quiz/quiz_show', $data);
    }

    public function submitAnswer()
    {
        $jawaban = $this->request->getPost('jawaban') ?? null;
        $quizId = session()->get('quiz_id');
        $index = session()->get('soal_index');

        if (!$quizId) {
            return redirect()->to('/dashboard/peserta')->with('error', 'Silakan join quiz terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('quiz_soal');
        $builder->select('soal.*');
        $builder->join('soal', 'soal.id_soal = quiz_soal.id_soal');
        $builder->where('quiz_soal.id_quiz', $quizId);
        $soal = $builder->get()->getResultArray();

        // Jika sudah melewati jumlah soal, langsung redirect selesai
        if ($index >= count($soal)) {
            return redirect()->to('/quiz-selesai');
        }

        $answers = session()->get('answers') ?? [];
        $currentSoal = $soal[$index];

        // Simpan jawaban walaupun kosong (null)
        $answers[$currentSoal['id_soal']] = $jawaban;
        session()->set('answers', $answers);

        // Update index soal
        session()->set('soal_index', $index + 1);

        // Jika sudah soal terakhir, langsung ke halaman selesai
        if ($index + 1 >= count($soal)) {
            return redirect()->to('/quiz-selesai');
        }

        return redirect()->to('/quiz-show/' . $quizId . '/' . ($index + 2));
    }

    public function quizSelesai()
{
    $userId = session()->get('id');
    $quizId = session()->get('quiz_id');
    $answers = session()->get('answers') ?? [];

    if (!$userId || !$quizId) {
        return redirect()->to('/dashboard/peserta')->with('error', 'Quiz Telah Selesai');
    }

    $db = \Config\Database::connect();

    // Ambil soal dan jawaban benar
    $builder = $db->table('quiz_soal');
    $builder->select('soal.jawaban_benar, soal.id_soal');
    $builder->join('soal', 'soal.id_soal = quiz_soal.id_soal');
    $builder->where('quiz_soal.id_quiz', $quizId);
    $soal = $builder->get()->getResultArray();

    // Hitung skor berdasarkan jawaban user
    $score = 0;
    foreach ($soal as $s) {
        $idSoal = $s['id_soal'];
        if (isset($answers[$idSoal])) {
            $userAnswer = trim(strtoupper($answers[$idSoal]));
            $correctAnswer = trim(strtoupper($s['jawaban_benar']));
            if ($userAnswer === $correctAnswer) {
                $score++;
            }
        }
    }

    // Waktu selesai dan mulai
    $waktuSelesai = date('Y-m-d H:i:s');
    $waktuMulai = session()->get('quiz_start_time');

    // Simpan ke leaderboard
    $leaderboardTable = $db->table('leaderboard');
    $existingLeaderboard = $leaderboardTable->where('user_id', $userId)
                                            ->where('id_quiz', $quizId)
                                            ->get()
                                            ->getRowArray();

    if ($existingLeaderboard) {
        if ($score > $existingLeaderboard['score']) {
            $leaderboardTable->where('id', $existingLeaderboard['id'])->update([
                'score' => $score,
            ]);
        }
    } else {
        $leaderboardTable->insert([
            'user_id' => $userId,
            'id_quiz' => $quizId,
            'score' => $score,
            'waktu_selesai' => $waktuSelesai,
        ]);
    }

    // Simpan juga ke tabel quiz_user
    $quizUserModel = new \App\Models\QuizUserModel();
    $existingQuizUser = $quizUserModel->where('id_user', $userId)
                                      ->where('id_quiz', $quizId)
                                      ->first();

    $dataQuizUser = [
        'id_user' => $userId,
        'id_quiz' => $quizId,
        'score' => $score,
        'waktu_selesai' => $waktuSelesai,
        'waktu_mulai' => $waktuMulai // pastikan kolom ini ada di database
    ];

    if ($existingQuizUser) {
        $quizUserModel->update($existingQuizUser['id'], $dataQuizUser);
    } else {
        $quizUserModel->insert($dataQuizUser);
    }

    // Hapus sesi quiz
    session()->remove(['quiz_id', 'quiz_title', 'soal_index', 'answers', 'quiz_start_time']);

    // Ambil Top 3 peserta
    $topThree = $leaderboardTable
        ->select('leaderboard.score, users.username, leaderboard.user_id')
        ->join('users', 'leaderboard.user_id = users.id')
        ->where('leaderboard.id_quiz', $quizId)
        ->orderBy('leaderboard.score', 'DESC')
        ->limit(3)
        ->get()
        ->getResultArray();

    // Ambil peserta lain di luar Top 3
    $topUserIds = array_column($topThree, 'user_id');
    $othersQuery = $leaderboardTable
        ->select('leaderboard.score, users.username, leaderboard.user_id')
        ->join('users', 'leaderboard.user_id = users.id')
        ->where('leaderboard.id_quiz', $quizId);

    if (!empty($topUserIds)) {
        $othersQuery->whereNotIn('leaderboard.user_id', $topUserIds);
    }

    $others = $othersQuery->orderBy('leaderboard.score', 'DESC')->get()->getResultArray();

    // Tampilkan hasil
    return view('quiz/quiz_selesai', [
        'topThree' => $topThree,
        'others'   => $others,
        'score'    => $score,
    ]);
}


    public function hasilquiz()
{
    $model = new \App\Models\QuizUserModel();
    $data['hasil'] = $model->getResultsWithUsername();

    return view('quiz/hasil_quiz', $data);
}

}