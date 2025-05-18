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

    // Tampilkan semua data soal
    public function index()
    {
        $data['soal'] = $this->soalModel->findAll();
        return view('Soal/index', $data);
    }

    // Tambah soal baru
    public function tambah()
    {
        $data = $this->request->getPost();

        $rules = [
            'soal'           => 'required',
            'pilihan_a'      => 'required',
            'pilihan_b'      => 'required',
            'pilihan_c'      => 'required',
            'pilihan_d'      => 'required',
            'jawaban_benar'  => 'required|in_list[A,B,C,D]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data tidak lengkap atau tidak valid.');
        }

        $insertData = [
            'soal'           => $data['soal'],
            'pilihan_a'      => $data['pilihan_a'],
            'pilihan_b'      => $data['pilihan_b'],
            'pilihan_c'      => $data['pilihan_c'],
            'pilihan_d'      => $data['pilihan_d'],
            'jawaban_benar'  => $data['jawaban_benar'],
        ];

        $this->soalModel->insert($insertData);

        return redirect()->to('/soal')->with('success', 'Soal berhasil ditambahkan.');
    }

    // Update soal
    public function update($id_soal)
    {
        $data = $this->request->getPost();

        $rules = [
            'soal'           => 'required',
            'pilihan_a'      => 'required',
            'pilihan_b'      => 'required',
            'pilihan_c'      => 'required',
            'pilihan_d'      => 'required',
            'jawaban_benar'  => 'required|in_list[A,B,C,D]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid.');
        }

        $soal = $this->soalModel->find($id_soal);
        if (!$soal) {
            return redirect()->to('/soal')->with('error', 'Soal tidak ditemukan.');
        }

        $updateData = [
            'soal'           => $data['soal'],
            'pilihan_a'      => $data['pilihan_a'],
            'pilihan_b'      => $data['pilihan_b'],
            'pilihan_c'      => $data['pilihan_c'],
            'pilihan_d'      => $data['pilihan_d'],
            'jawaban_benar'  => $data['jawaban_benar'],
        ];

        $this->soalModel->update($id_soal, $updateData);

        return redirect()->to('/soal')->with('success', 'Soal berhasil diperbarui.');
    }

    // Hapus soal
    public function hapus($id_soal)
    {
        $soal = $this->soalModel->find($id_soal);
        if (!$soal) {
            return redirect()->to('/soal')->with('error', 'Soal tidak ditemukan.');
        }

        $this->soalModel->delete($id_soal);

        return redirect()->to('/soal')->with('success', 'Soal berhasil dihapus.');
    }
    
}
