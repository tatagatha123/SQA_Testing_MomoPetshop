<?php

namespace App\Models;

use CodeIgniter\Model;

class StokMasukModel extends Model
{
    protected $table            = 'stok_masuk';
    protected $primaryKey       = 'id_stok';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'id_produk',
        'id_supplier',
        'jumlah',
        'tanggal',
    ];

    // ── Semua data + join produk & supplier ──
    public function getAllWithRelasi()
    {
        return $this->db->table('stok_masuk sm')
            ->select('sm.id_stok, sm.jumlah, sm.tanggal, sm.id_produk, sm.id_supplier, p.nama_produk, s.nama_supplier')
            ->join('produk p', 'p.id_produk = sm.id_produk', 'left')
            ->join('supplier s', 's.id_supplier = sm.id_supplier', 'left')
            ->orderBy('sm.tanggal', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ── Satu baris + join ──
    public function getByIdWithRelasi(int $id_stok)
    {
        return $this->db->table('stok_masuk sm')
            ->select('sm.id_stok, sm.jumlah, sm.tanggal, sm.id_produk, sm.id_supplier, p.nama_produk, s.nama_supplier')
            ->join('produk p', 'p.id_produk = sm.id_produk', 'left')
            ->join('supplier s', 's.id_supplier = sm.id_supplier', 'left')
            ->where('sm.id_stok', $id_stok)
            ->get()
            ->getRowArray();
    }

    // ── Widget dashboard: 5 terbaru semua waktu ──
    public function getRecentStok(int $limit = 5)
    {
        return $this->db->table('stok_masuk sm')
            ->select('sm.id_stok, sm.jumlah, sm.tanggal, p.nama_produk, s.nama_supplier')
            ->join('produk p', 'p.id_produk = sm.id_produk', 'left')
            ->join('supplier s', 's.id_supplier = sm.id_supplier', 'left')
            ->orderBy('sm.tanggal', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    // ── Widget dashboard: N terbaru HARI INI ──
    public function getRecentHariIni(int $limit = 5): array
    {
        return $this->db->table('stok_masuk sm')
            ->select('sm.id_stok, sm.jumlah, sm.tanggal, p.nama_produk, s.nama_supplier')
            ->join('produk p', 'p.id_produk = sm.id_produk', 'left')
            ->join('supplier s', 's.id_supplier = sm.id_supplier', 'left')
            ->where('DATE(sm.tanggal)', date('Y-m-d'))
            ->orderBy('sm.id_stok', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function getTotalStokMasuk(): int
    {
        return $this->countAll();
    }
}