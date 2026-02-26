<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<h1>Tambah Produk </h1>

<form>
    <div class="card">
        <label>Nama Produk:</label><br>
        <input type="text" name="nama" style="width:100%; padding:5px;">
        <br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" style="width:100%; padding:5px;">
        <br><br>

        <button type="submit" class="btn">Simpan</button>
    </div>
</form>

<?= $this->endSection(); ?>