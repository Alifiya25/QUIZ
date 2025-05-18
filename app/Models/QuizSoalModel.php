<?php
namespace App\Models;

use CodeIgniter\Model;

class QuizSoalModel extends Model
{
    protected $table = 'quiz_soal';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_quiz', 'id_soal'];
}
