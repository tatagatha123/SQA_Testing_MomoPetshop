<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table            = 'detail_transaksi';
    protected $primaryKey       = 'id_detail';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'id_transaksi',
        'id_produk',
        'qty',
        'harga',
        'subtotal',
    ];

    /**
     * Ambil detail transaksi beserta nama produk, berdasarkan id_transaksi
     */
    public function getByTransaksi(int $id_transaksi): array
    {
        return $this->db->table('detail_transaksi dt')
            ->select('dt.*, p.nama_produk')
            ->join('produk p', 'p.id_produk = dt.id_produk', 'left')
            ->where('dt.id_transaksi', $id_transaksi)
            ->get()
            ->getResultArray();
    }

    /**
     * Insert banyak detail sekaligus
     */
    public function simpanBatch(array $data): bool
    {
        return parent::insertBatch($data) !== false;
    }
}