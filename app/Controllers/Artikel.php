// app/Controllers/Artikel.php
<?php namespace App\Controllers;

use App\Models\ArtikelHukumModel;

class Artikel extends BaseController
{
    protected $artikelModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelHukumModel();
    }

    // Tampilan daftar artikel untuk publik
    public function index()
    {
        $data['artikel'] = $this->artikelModel->findAll();
        return view('artikel/index', $data);
    }
    
    // Halaman kelola artikel untuk advokat
    public function admin()
    {
        $data['artikel'] = $this->artikelModel->findAll();
        return view('artikel/admin_list', $data);
    }

    // Form membuat artikel baru
    public function create()
    {
        return view('artikel/create');
    }

    // Proses menyimpan artikel baru
    public function store()
    {
        $rules = [
            'judul' => 'required|min_length[5]',
            'isi_artikel' => 'required|min_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->artikelModel->save([
            'id_penulis' => session()->get('id_user'),
            'judul' => $this->request->getVar('judul'),
            'isi_artikel' => $this->request->getVar('isi_artikel')
        ]);

        return redirect()->to('/artikel/admin')->with('success', 'Artikel berhasil ditambahkan.');
    }
    
    // Proses menghapus artikel
    public function delete($id)
    {
        $this->artikelModel->delete($id);
        return redirect()->to('/artikel/admin')->with('success', 'Artikel berhasil dihapus.');
    }
}