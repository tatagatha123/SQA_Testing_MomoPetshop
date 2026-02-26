<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<h1><?= $nama_toko; ?></h1>
<p><strong>Kasir aktif:</strong> <?= $kasir; ?></p>

<div class="card">
    <h3>Total Produk</h3>
    <p><?= $total_produk; ?> Produk</p>
</div>

<div class="card">
    <h3>Total Transaksi Hari Ini</h3>
    <p><?= $total_transaksi; ?> Transaksi</p>
</div>

<div class="card">
    <h3>Total Pendapatan</h3>
    <p>Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></p>
</div>

<?= $this->endSection(); ?>