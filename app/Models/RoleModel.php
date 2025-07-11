<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array'; // Bisa 'array' atau 'object'
    protected $useSoftDeletes = false; // Jika tidak ingin menggunakan soft delete
    protected $allowedFields  = ['name'];

    // Dates
    protected $useTimestamps = true; // Mengaktifkan created_at dan updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Hanya jika useSoftDeletes true

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}