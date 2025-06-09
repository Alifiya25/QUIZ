<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizUserModel extends Model
{
    protected $table      = 'quiz_user';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_user',
        'id_quiz',
        'score',
        'waktu_mulai',
        'waktu_selesai',
    ];

    protected $useTimestamps = false;

    public function hasUserJoinedQuiz($userId, $quizId)
    {
        return $this->where('id_user', $userId)
                    ->where('id_quiz', $quizId)
                    ->first();
    }

    public function saveUserQuizResult($data)
    {
        return $this->insert($data);
    }

    // Method baru untuk ambil hasil quiz sekaligus username user
   public function getResultsWithUsername()
{
    return $this->select('quiz_user.*, users.username, quiz.judul')
                ->join('users', 'users.id = quiz_user.id_user')
                ->join('quiz', 'quiz.id_quiz = quiz_user.id_quiz')
                ->orderBy('score', 'DESC')  // <-- Urutkan berdasarkan score juga
                ->findAll();
}

public function searchQuiz($keyword)
{
    return $this->select('quiz_user.*, users.username, quiz.judul')
                ->join('users', 'users.id = quiz_user.id_user')
                ->join('quiz', 'quiz.id_quiz = quiz_user.id_quiz')
                ->groupStart()
                    ->like('users.username', $keyword)
                    ->orLike('quiz.judul', $keyword)
                ->groupEnd()
                ->orderBy('score', 'DESC')  // <-- Urutkan berdasarkan score dari besar ke kecil
                ->findAll();
}
}
