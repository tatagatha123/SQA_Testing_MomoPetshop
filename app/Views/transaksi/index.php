<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Transaksi</h2>
<a href="/transaksi/tambah" class="btn btn-primary">
    <i class="fa fa-plus"></i> + Transaksi Baru
</a>
<br><br>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($transaksi as $trx) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $trx['kode']; ?></td>
                    <td><?= $trx['tanggal']; ?></td>
                    <td>Rp <?= number_format($trx['total'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>