<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id_produk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'nama_produk',
        'harga',
        'stok',
        'id_kategori',
        'id_supplier',
    ];

    protected $validationRules = [
        'nama_produk' => 'required|max_length[255]',
        'harga'       => 'required|decimal',
        'stok'        => 'required|integer',
        'id_kategori' => 'required|integer',
        'id_supplier' => 'required|integer',
    ];

    protected $validationMessages = [
        'nama_produk' => [
            'required'   => 'Nama produk wajib diisi.',
            'max_length' => 'Nama produk maksimal 255 karakter.',
        ],
        'harga' => [
            'required' => 'Harga wajib diisi.',
            'decimal'  => 'Harga harus berupa angka desimal.',
        ],
        'stok' => [
            'required' => 'Stok wajib diisi.',
            'integer'  => 'Stok harus berupa angka.',
        ],
        'id_kategori' => [
            'required' => 'Kategori wajib dipilih.',
            'integer'  => 'Kategori tidak valid.',
        ],
        'id_supplier' => [
            'required' => 'Supplier wajib dipilih.',
            'integer'  => 'Supplier tidak valid.',
        ],
    ];

    // ── Semua produk + join kategori & supplier ──
    public function getAllWithRelasi()
    {
        return $this->db->table('produk p')
            ->select('p.*, k.nama_kategori, s.nama_supplier')
            ->join('kategori k', 'k.id_kategori = p.id_kategori', 'left')
            ->join('supplier s', 's.id_supplier = p.id_supplier', 'left')
            ->orderBy('p.id_produk', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ── Satu produk + join ──
    public function getByIdWithRelasi(int $id_produk)
    {
        return $this->db->table('produk p')
            ->select('p.*, k.nama_kategori, s.nama_supplier')
            ->join('kategori k', 'k.id_kategori = p.id_kategori', 'left')
            ->join('supplier s', 's.id_supplier = p.id_supplier', 'left')
            ->where('p.id_produk', $id_produk)
            ->get()
            ->getRowArray();
    }

    // ── Produk dengan stok menipis ──
    public function getProdukStokRendah(int $minStok = 5)
    {
        return $this->where('stok <=', $minStok)
            ->orderBy('stok', 'ASC')
            ->findAll();
    }

    public function getTotalProduk(): int
    {
        return $this->countAll();
    }
}
