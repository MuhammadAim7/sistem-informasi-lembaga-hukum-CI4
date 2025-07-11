<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ['role_id', 'username', 'email', 'password', 'full_name', 'phone', 'address'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'username'      => 'required|alpha_dash|min_length[3]|max_length[100]|is_unique[users.username]',
        'email'         => 'required|valid_email|is_unique[users.email]',
        'password'      => 'required|min_length[8]',
        'full_name'     => 'required|min_length[3]|max_length[255]',
        'role_id'       => 'required|is_natural_no_zero', // role_id harus angka positif
    ];

    protected $validationMessages = [
        'username' => [
            'required'    => 'Username harus diisi.',
            'alpha_dash'  => 'Username hanya boleh berisi huruf, angka, garis bawah, dan tanda hubung.',
            'min_length'  => 'Username minimal 3 karakter.',
            'max_length'  => 'Username maksimal 100 karakter.',
            'is_unique'   => 'Username ini sudah digunakan.',
        ],
        'email' => [
            'required'    => 'Email harus diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique'   => 'Email ini sudah terdaftar.',
        ],
        'password' => [
            'required'    => 'Password harus diisi.',
            'min_length'  => 'Password minimal 8 karakter.',
        ],
        'full_name' => [
            'required'    => 'Nama lengkap harus diisi.',
            'min_length'  => 'Nama lengkap minimal 3 karakter.',
        ],
        'role_id' => [
            'required'          => 'Role harus dipilih.',
            'is_natural_no_zero'=> 'Role ID tidak valid.'
        ]
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword']; // Bisa juga digunakan untuk update password

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}