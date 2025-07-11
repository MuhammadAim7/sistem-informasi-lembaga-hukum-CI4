// app/Controllers/Klien.php
<?php namespace App\Controllers;

use App\Models\KonsultasiModel;

class Klien extends BaseController
{
    public function __construct()
    {
        $this->konsultasiModel = new KonsultasiModel();
    }

    public function dashboard()
    {
        $id_klien = session()->get('id_user');
        $data['konsultasi'] = $this->konsultasiModel->where('id_klien', $id_klien)->findAll();
        return view('klien/dashboard', $data);
    }

    public function ajukanPertanyaan()
    {
        return view('klien/form_konsultasi');
    }

    public function simpanPertanyaan()
    {
        $this->konsultasiModel->save([
            'id_klien' => session()->get('id_user'),
            'subjek_pertanyaan' => $this->request->getVar('subjek_pertanyaan'),
            'detail_pertanyaan' => $this->request->getVar('detail_pertanyaan'),
            'status' => 'diajukan'
        ]);

        return redirect()->to('/klien/dashboard')->with('success', 'Pertanyaan berhasil diajukan.');
    }
}