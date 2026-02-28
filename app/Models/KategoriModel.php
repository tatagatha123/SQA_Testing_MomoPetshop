<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'nama_kategori',
    ];

    // Validation
    protected $validationRules = [
        'nama_kategori' => 'required|min_length[2]|max_length[255]',
    ];

    protected $validationMessages = [
        'nama_kategori' => [
            'required'   => 'Nama kategori wajib diisi.',
            'min_length' => 'Nama kategori minimal 2 karakter.',
            'max_length' => 'Nama kategori maksimal 255 karakter.',
        ],
    ];

    /**
     * Ambil semua kategori untuk dropdown/select
     */
    public function getForDropdown(): array
    {
        return $this->orderBy('nama_kategori', 'ASC')->findAll();
    }
}