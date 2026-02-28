<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table            = 'supplier';
    protected $primaryKey       = 'id_supplier';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'nama_supplier',
        'no_telp',
    ];

    protected $validationRules = [
        'nama_supplier' => 'required|max_length[255]',
        'no_telp'       => 'required|max_length[255]',
    ];

    protected $validationMessages = [
        'nama_supplier' => [
            'required'   => 'Nama supplier wajib diisi.',
            'max_length' => 'Nama supplier maksimal 255 karakter.',
        ],
        'no_telp' => [
            'required'   => 'Nomor telepon wajib diisi.',
            'max_length' => 'Nomor telepon maksimal 255 karakter.',
        ],
    ];
}
