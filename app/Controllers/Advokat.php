// app/Controllers/Advokat.php
<?php 
namespace App\Controllers;

use App\Models\KonsultasiModel;

class Advokat extends BaseController
{
    public function __construct()
    {
        $this->konsultasiModel = new KonsultasiModel();
    }

    public function dashboard()
    {
        // Ambil pertanyaan yang belum dijawab
        $data['pertanyaan_masuk'] = $this->konsultasiModel->where('status', 'diajukan')->findAll();
        return view('advokat/dashboard', $data);
    }

    public function jawab($id_konsultasi)
    {
        $data['konsultasi'] = $this->konsultasiModel->find($id_konsultasi);
        return view('advokat/form_jawaban', $data);
    }

  public function simpanJawaban()
{
    $id_konsultasi = $this->request->getVar('id_konsultasi');
    $jawaban = $this->request->getVar('jawaban_konsultasi');

    // Update database
    $this->konsultasiModel->update($id_konsultasi, [
        'id_advokat' => session()->get('id_user'),
        'jawaban_konsultasi' => $jawaban,
        'status' => 'dijawab',
        'tanggal_dijawab' => date('Y-m-d H:i:s')
    ]);

    // Kirim notifikasi email
    $this->kirimNotifikasiEmail($id_konsultasi);

    return redirect()->to('/advokat/dashboard')->with('success', 'Jawaban berhasil dikirim.');
}

private function kirimNotifikasiEmail($id_konsultasi)
{
    $konsultasi = $this->konsultasiModel->find($id_konsultasi);
    $userModel = new UserModel();
    $klien = $userModel->find($konsultasi['id_klien']);

    if (!$klien) {
        return false; // Klien tidak ditemukan
    }
    
    $email = \Config\Services::email();

    $email->setTo($klien['email']);
    $email->setSubject('Jawaban untuk Konsultasi Hukum Anda: ' . $konsultasi['subjek_pertanyaan']);
    
    $message = "
        <h1>Jawaban Konsultasi Telah Tiba</h1>
        <p>Halo " . esc($klien['nama_lengkap']) . ",</p>
        <p>Pertanyaan konsultasi Anda dengan subjek '<strong>" . esc($konsultasi['subjek_pertanyaan']) . "</strong>' telah dijawab oleh salah satu advokat kami.</p>
        <p>Silakan login ke akun Anda untuk melihat jawaban lengkapnya.</p>
        <br>
        <a href='" . site_url('klien/dashboard') . "' style='padding:10px 15px; background-color:#007bff; color:white; text-decoration:none; border-radius:5px;'>Login Sekarang</a>
        <br><br>
        <p>Terima kasih,<br>Fagustifa Law Firm</p>
    ";
    
    $email->setMessage($message);
    
    if (!$email->send()) {
        // Gagal kirim email, bisa ditambahkan log error
        log_message('error', 'Gagal mengirim email notifikasi ke ' . $klien['email'] . ': ' . $email->printDebugger(['headers']));
    }
}
}