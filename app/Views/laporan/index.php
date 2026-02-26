<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h2>Laporan Penjualan</h2>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Total Transaksi</h5>
                <h3><?= $totalTransaksi; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Total Pendapatan</h5>
                <h3>Rp <?= number_format($totalPendapatan, 0, ',', '.'); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $trx): ?>
                <tr>
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