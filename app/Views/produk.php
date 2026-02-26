<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<h1>Daftar Produk</h1>

<a href="/produk/tambah" class="btn">+ Tambah Produk</a>

<br><br>

<?php foreach ($daftar_produk as $produk): ?>
    <div class="card">
        <h3><?= $produk['nama']; ?></h3>
        <p>Harga: Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></p>
    </div>
<?php endforeach; ?>

<?= $this->endSection(); ?>