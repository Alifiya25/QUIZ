<?php

namespace App\Models;
use CodeIgniter\Model;

class SoalModel extends Model
{
    protected $table = 'soal';
    protected $primaryKey = 'id_soal';
    protected $allowedFields = ['id_quiz','soal', 'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d', 'jawaban_benar'];


    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
