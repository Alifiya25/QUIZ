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
    return $this->select('quiz_user.*, users.username')
                ->join('users', 'users.id = quiz_user.id_user')  // sesuaikan kolom primary key user di sini
                ->orderBy('waktu_selesai', 'DESC')
                ->findAll();
}

}
