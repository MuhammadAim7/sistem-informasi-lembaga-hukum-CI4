<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = 'Beranda'; // Mengirimkan judul ke view
        return view('home', $data);
    }
}