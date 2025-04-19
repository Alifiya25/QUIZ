<?php

namespace App\Models;

use CodeIgniter\Model;

class BuatQuizModel extends Model
{
    // Nama tabel untuk quiz
    protected $table = 'quiz';  
    // Kolom primary key
    protected $primaryKey = 'id_quiz';  

    // Kolom-kolom yang bisa diisi
    protected $allowedFields = [
        'judul', 
        'deskripsi', 
        'mode', 
        'timer', 
        'kode_akses', 
        'tanggal_dibuat'
    ];

    // Menentukan apakah model menggunakan timestamp otomatis
    protected $useTimestamps = false;  // Karena tanggal_buat dan update sudah otomatis diatur oleh MySQL

    // Menentukan format waktu timestamp (default: 'datetime')
    protected $dateFormat = 'datetime';

    // Aturan validasi
    protected $validationRules = [
        'judul'        => 'required|string|max_length[255]',      // Judul quiz harus ada, berupa string, max 255 karakter
        'deskripsi'    => 'permit_empty|string',                   // Deskripsi boleh kosong, berupa string
        'mode'         => 'required|in_list[time,practice]',       // Mode harus time atau practice
        'timer'        => 'permit_empty|is_natural_no_zero',       // Timer boleh kosong, jika ada harus angka positif
        'kode_akses'   => 'required|string|max_length[100]',       // Kode akses harus ada, berupa string, max 100 karakter
        'tanggal_dibuat' => 'required|valid_date',                   // Tanggal buat harus ada dan valid
    ];

    // Pesan validasi yang akan ditampilkan jika validasi gagal
    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul quiz harus diisi.',
            'string'   => 'Judul quiz harus berupa teks.',
            'max_length' => 'Judul quiz tidak boleh lebih dari 255 karakter.',
        ],
        'deskripsi' => [
            'string' => 'Deskripsi harus berupa teks.',
        ],
        'mode' => [
            'required' => 'Mode quiz harus dipilih.',
            'in_list'  => 'Mode quiz harus berupa "time" atau "practice".',
        ],
        'timer' => [
            'is_natural_no_zero' => 'Timer harus berupa angka positif.',
        ],
        'kode_akses' => [
            'required' => 'Kode akses harus diisi.',
            'string'   => 'Kode akses harus berupa teks.',
            'max_length' => 'Kode akses tidak boleh lebih dari 100 karakter.',
        ],
        'tanggal_dibuat' => [
            'valid_date' => 'Tanggal buat harus valid.',
        ],
    ];

    // Konfigurasi untuk operasi terkait dengan 'created_at' dan 'updated_at' jika dibutuhkan
    protected $createdField  = 'tanggal_dibuat';  // Nama kolom untuk waktu pembuatan
    protected $updatedField  = 'updated_at';    // Nama kolom untuk waktu pembaruan
}
