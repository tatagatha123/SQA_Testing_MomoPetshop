<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h2>Tambah Transaksi</h2>

<div class="card">
    <div class="card-body">
        <form action="/transaksi/simpan" method="post">

            <div class="mb-3">
                <label class="form-label">Kode Transaksi</label>
                <input type="text" name="kode" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Total</label>
                <input type="number" name="total" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">
                Simpan
            </button>

            <a href="/transaksi" class="btn btn-secondary">
                Kembali
            </a>

        </form>
    </div>
</div>

<?= $this->endSection(); ?>