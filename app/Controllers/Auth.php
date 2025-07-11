<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->session = \Config\Services::session();
    }

    // Metode untuk memproses registrasi
    public function register()
    {
        // Pastikan ini adalah permintaan POST
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setJSON(['status' => 'error', 'message' => 'Method Not Allowed']);
        }

        // Aturan validasi (tambahan untuk konfirmasi password)
        $rules = [
            'full_name'         => 'required|min_length[3]|max_length[255]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'username'          => 'required|alpha_dash|min_length[3]|max_length[100]|is_unique[users.username]',
            'password'          => 'required|min_length[8]',
            'confirm_password'  => 'required|matches[password]',
        ];

        $messages = [
            'confirm_password' => [
                'matches' => 'Konfirmasi password tidak cocok dengan password.',
            ],
            'email' => [
                'is_unique' => 'Email ini sudah terdaftar. Gunakan email lain.',
            ],
            'username' => [
                'is_unique' => 'Username ini sudah digunakan. Gunakan username lain.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Ambil role_id untuk 'user'
        $userRole = $this->roleModel->where('name', 'user')->first();
        if (!$userRole) {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Role "user" tidak ditemukan.']);
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'username'  => $this->request->getPost('username'),
            'password'  => $this->request->getPost('password'), // Password akan di-hash oleh beforeInsert hook di model
            'role_id'   => $userRole['id'], // Default role adalah 'user'
        ];

        if ($this->userModel->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Registrasi berhasil. Silakan login.']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Gagal melakukan registrasi.']);
        }
    }

    // Metode untuk memproses login
    public function login()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setJSON(['status' => 'error', 'message' => 'Method Not Allowed']);
        }

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        $messages = [
            'email' => [
                'required'    => 'Email harus diisi.',
                'valid_email' => 'Email tidak valid.',
            ],
            'password' => [
                'required' => 'Password harus diisi.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email atau password salah.']);
        }

        // Login berhasil, simpan data user ke session
        $role = $this->roleModel->find($user['role_id']);
        $userData = [
            'user_id'   => $user['id'],
            'full_name' => $user['full_name'],
            'email'     => $user['email'],
            'username'  => $user['username'],
            'role_id'   => $user['role_id'],
            'role_name' => $role['name'], // Simpan nama role juga
            'isLoggedIn' => true,
        ];
        $this->session->set($userData);

        // Tentukan redirect berdasarkan role
        $redirectUrl = base_url(); // Default ke halaman home

        switch ($role['name']) {
            case 'admin':
                $redirectUrl = base_url('admin/dashboard');
                break;
            case 'advocate':
                $redirectUrl = base_url('advocate/dashboard');
                break;
            case 'user':
                $redirectUrl = base_url('user/dashboard');
                break;
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Login berhasil!', 'redirect' => $redirectUrl]);
    }

    // Metode untuk logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url()); // Redirect ke halaman utama setelah logout
    }
}