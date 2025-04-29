<?php

namespace App\Models;

use CodeIgniter\Model;

class BuatQuizModel extends Model
{
    // Nama tabel untuk quiz
    protected $table = 'quiz';
    protected $primaryKey = 'id_quiz';

    protected $allowedFields = [
        'judul',
        'deskripsi',
        'mode',
        'timer',
        'kode_akses',
        'tanggal_dibuat'
    ];

    protected $useTimestamps = false; // Tidak pakai timestamps otomatis
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'judul'          => 'required|max_length[255]',
        'deskripsi'      => 'permit_empty|max_length[1000]',
        'mode'           => 'required|in_list[time,practice]',
        'timer'          => 'permit_empty|integer',
        'kode_akses'     => 'required|max_length[100]',
        'tanggal_dibuat' => 'required|valid_date[Y-m-d H:i:s]',
    ];

    protected $validationMessages = [
        'judul' => [
            'required'    => 'Judul quiz harus diisi.',
            'max_length'  => 'Judul quiz tidak boleh lebih dari 255 karakter.',
        ],
        'deskripsi' => [
            'max_length' => 'Deskripsi tidak boleh lebih dari 1000 karakter.',
        ],
        'mode' => [
            'required' => 'Mode quiz harus dipilih.',
            'in_list'  => 'Mode quiz harus berupa "time" atau "practice".',
        ],
        'timer' => [
            'integer' => 'Timer harus berupa angka.',
        ],
        'kode_akses' => [
            'required'   => 'Kode akses harus diisi.',
            'max_length' => 'Kode akses tidak boleh lebih dari 100 karakter.',
        ],
        'tanggal_dibuat' => [
            'required'    => 'Tanggal buat harus diisi.',
            'valid_date'  => 'Tanggal buat harus format tanggal yang valid (Y-m-d H:i:s).',
        ],
    ];

    protected $createdField = 'tanggal_dibuat';
    protected $updatedField = 'updated_at'; // Ini cuma placeholder kalau kamu mau pakai nanti
}
