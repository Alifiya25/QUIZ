<?php

namespace App\Controllers;

use App\Models\SoalModel;
use CodeIgniter\Controller;

class Soal extends BaseController
{
    protected $soalModel;

    public function __construct()
    {
        $this->soalModel = new SoalModel();
    }

    public function index()
    {
        $data['soal'] = $this->soalModel->findAll();
        return view('Soal/index', $data);
    }

    public function tambah()
{
    // Ambil data dari request
    $data = $this->request->getPost();

    // Atur aturan validasi untuk form
    $rules = [
        'soal'       => 'required',
        'pilihan_a'  => 'required',
        'pilihan_b'  => 'required',
        'pilihan_c'  => 'required',
        'pilihan_d'  => 'required',
        'jawaban_benar' => 'required|in_list[A,B,C,D]',  // Validasi jawaban benar
    ];

    // Cek apakah data valid
    if (!$this->validate($rules)) {
        // Jika tidak valid, kembali ke halaman dengan pesan error
        return redirect()->back()->with('error', 'Data tidak lengkap atau tidak valid.');
    }

    // Menyaring data yang akan dimasukkan ke dalam database
    $insertData = [
        'soal' => $data['soal'],
        'pilihan_a' => $data['pilihan_a'],
        'pilihan_b' => $data['pilihan_b'],
        'pilihan_c' => $data['pilihan_c'],
        'pilihan_d' => $data['pilihan_d'],
        'jawaban_benar' => $data['jawaban_benar'],
    ];

    // Insert data ke database menggunakan model
    $this->soalModel->insert($insertData);

    // Redirect ke halaman soal dengan pesan sukses
    return redirect()->to('/soal')->with('success', 'Soal berhasil ditambahkan.');
}

    public function update($id)
    {
        $data = $this->request->getPost();

        $rules = [
            'soal'       => 'required',
            'pilihan_a'  => 'required',
            'pilihan_b'  => 'required',
            'pilihan_c'  => 'required',
            'pilihan_d'  => 'required',
            'jawaban_benar' => 'required|in_list[A,B,C,D]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Data tidak valid.');
        }

        $this->soalModel->update($id, $data);
        return redirect()->to('/soal')->with('success', 'Soal berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $this->soalModel->delete($id);
        return redirect()->to('/soal')->with('success', 'Soal berhasil dihapus.');
    }
}
