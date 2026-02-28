<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'id_user',
        'tanggal',
        'total',
    ];

    /**
     * Semua transaksi, diurutkan terbaru di atas
     */
    public function getAllTransaksi(): array
    {
        return $this->orderBy('id_transaksi', 'DESC')->findAll();
    }

    /**
     * Semua transaksi + nama kasir (untuk laporan)
     */
    public function getAllWithKasir(): array
    {
        return $this->db->table('transaksi t')
            ->select('t.id_transaksi, t.tanggal, t.total, u.username AS kasir')
            ->join('users u', 'u.id_user = t.id_user', 'left')
            ->orderBy('t.id_transaksi', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Satu transaksi by ID
     */
    public function getById(int $id): ?array
    {
        return $this->find($id);
    }

    /**
     * Total pendapatan dari seluruh transaksi (sum kolom 'total')
     */
    public function getTotalPendapatan(): float
    {
        $result = $this->selectSum('total')->first();
        return (float) ($result['total'] ?? 0);
    }

    /**
     * Jumlah transaksi hari ini
     */
    public function getCountHariIni(): int
    {
        return $this->where('DATE(tanggal)', date('Y-m-d'))->countAllResults();
    }

    /**
     * N transaksi terbaru HARI INI untuk widget dashboard
     * Join ke tabel users supaya bisa tampil nama kasir per transaksi
     */
    public function getRecentHariIni(int $limit = 5): array
    {
        return $this->db->table('transaksi t')
            ->select('t.id_transaksi, t.tanggal, t.total, u.username AS kasir')
            ->join('users u', 'u.id_user = t.id_user', 'left')
            ->where('DATE(t.tanggal)', date('Y-m-d'))
            ->orderBy('t.id_transaksi', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
}