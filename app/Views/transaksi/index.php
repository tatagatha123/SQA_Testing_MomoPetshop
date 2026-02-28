<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> — MomoPetshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blue: #4A90E2; --blue-dark: #2563c4; --blue-dim: #e8f2fc;
            --orange: #FFA726; --orange-dark: #cc7a00; --orange-dim: #fff4e5;
            --red: #ef4444; --red-dim: #fef2f2;
            --green: #22c55e; --green-dim: #f0fdf4;
            --bg: #f5f7fc; --surface: #ffffff; --border: #eaecf2;
            --text: #1a1f36; --muted: #8b93a7;
            --sidebar-w: 230px; --topbar-h: 62px;
            --radius: 14px; --radius-sm: 9px;
            --shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 16px rgba(0,0,0,0.04);
        }
        html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); font-size: 14px; }

        /* SIDEBAR */
        .sidebar { position: fixed; left: 0; top: 0; width: var(--sidebar-w); height: 100vh; background: var(--surface); border-right: 1px solid var(--border); display: flex; flex-direction: column; z-index: 100; transition: transform .25s ease; }
        .sidebar-logo { padding: 22px 20px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 11px; }
        .logo-mark { width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0; background: linear-gradient(135deg, var(--blue), var(--orange)); display: flex; align-items: center; justify-content: center; font-size: 17px; }
        .logo-text { font-size: 14px; font-weight: 800; color: var(--text); letter-spacing: -.3px; line-height: 1.2; }
        .logo-sub { font-size: 10px; color: var(--muted); font-weight: 500; }
        .nav-wrap { flex: 1; overflow-y: auto; padding: 12px 10px; }
        .nav-label { font-size: 10px; font-weight: 700; color: var(--muted); letter-spacing: 1.2px; text-transform: uppercase; padding: 10px 10px 5px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--radius-sm); color: var(--muted); font-size: 13.5px; font-weight: 600; text-decoration: none; transition: all .15s; margin-bottom: 2px; }
        .nav-item:hover { background: var(--bg); color: var(--text); }
        .nav-item.active { background: var(--blue-dim); color: var(--blue); font-weight: 700; }
        .nav-item.active .nav-icon { color: var(--blue); }
        .nav-icon { width: 18px; text-align: center; font-size: 14px; color: var(--muted); flex-shrink: 0; }
        .nav-badge { margin-left: auto; background: var(--orange); color: #fff; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 20px; min-width: 20px; text-align: center; }
        .nav-item.active .nav-badge { background: var(--blue); }
        .sidebar-bottom { padding: 12px 10px; border-top: 1px solid var(--border); }
        .logout-btn { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--radius-sm); color: var(--muted); font-size: 13px; font-weight: 600; cursor: pointer; width: 100%; background: none; border: none; transition: all .15s; text-decoration: none; }
        .logout-btn:hover { background: #fff0f0; color: #e53e3e; }
        .logout-btn:hover .nav-icon { color: #e53e3e; }

        /* TOPBAR */
        .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { position: sticky; top: 0; z-index: 90; height: var(--topbar-h); background: rgba(245,247,252,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 26px; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .menu-toggle { display: none; background: none; border: none; cursor: pointer; color: var(--muted); font-size: 18px; padding: 4px; }
        .page-title { font-size: 16px; font-weight: 700; color: var(--text); }
        .breadcrumb { font-size: 11px; color: var(--muted); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .topbar-time { font-size: 12px; font-weight: 600; color: var(--muted); background: var(--surface); padding: 5px 13px; border-radius: 20px; border: 1px solid var(--border); display: flex; align-items: center; gap: 6px; }
        .topbar-time i { color: var(--blue); font-size: 11px; }
        .topbar-kasir { display: flex; align-items: center; gap: 8px; background: var(--surface); padding: 5px 13px 5px 6px; border-radius: 20px; border: 1px solid var(--border); }
        .kasir-avatar { width: 26px; height: 26px; border-radius: 50%; background: linear-gradient(135deg, var(--blue), var(--orange)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 11px; font-weight: 700; }
        .kasir-name { font-size: 12px; font-weight: 600; color: var(--text); }

        /* CONTENT */
        .content { padding: 24px 26px; flex: 1; }

        /* ALERT */
        .alert { padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 18px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; animation: slideDown .3s ease; }
        .alert-success { background: var(--green-dim); color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error   { background: var(--red-dim); color: #b91c1c; border: 1px solid #fecaca; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: none; } }

        /* SUMMARY CARDS */
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
        .sum-card { background: var(--surface); border-radius: var(--radius); padding: 18px 20px; border: 1px solid var(--border); box-shadow: var(--shadow); display: flex; align-items: center; gap: 14px; }
        .sum-icon { width: 42px; height: 42px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; }
        .sum-icon.blue { background: var(--blue-dim); color: var(--blue); }
        .sum-icon.orange { background: var(--orange-dim); color: var(--orange-dark); }
        .sum-icon.green { background: var(--green-dim); color: #15803d; }
        .sum-val { font-size: 20px; font-weight: 800; letter-spacing: -.5px; line-height: 1; }
        .sum-label { font-size: 11.5px; color: var(--muted); font-weight: 500; margin-top: 3px; }

        /* TOOLBAR */
        .toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .search-wrap { position: relative; }
        .search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 12px; pointer-events: none; }
        .search-wrap input { padding-left: 34px; width: 220px; }
        .form-control { width: 100%; padding: 9px 12px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; color: var(--text); background: var(--surface); outline: none; transition: border .15s; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(74,144,226,0.1); }

        /* BTNS */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; text-decoration: none; }
        .btn-blue { background: var(--blue); color: #fff; }
        .btn-blue:hover { background: var(--blue-dark); }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-dark); }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }
        .btn-sm { padding: 5px 11px; font-size: 12px; }

        /* CARD TABLE */
        .card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
        .card-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: 13.5px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px; }
        .card-title i { color: var(--blue); }
        .tw { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { border-bottom: 1px solid var(--border); }
        th { padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--muted); text-align: left; white-space: nowrap; }
        td { padding: 13px 16px; border-bottom: 1px solid var(--border); font-size: 13px; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: var(--bg); }
        .badge { padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; }
        .b-blue { background: var(--blue-dim); color: var(--blue-dark); }
        .b-orange { background: var(--orange-dim); color: var(--orange-dark); }
        .b-muted { background: var(--bg); color: var(--muted); border: 1px solid var(--border); }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 52px 24px; color: var(--muted); }
        .empty-state i { font-size: 44px; color: var(--blue-dim); margin-bottom: 12px; display: block; }
        .empty-state p { font-weight: 600; font-size: 14px; }

        /* MODAL */
        .modal-overlay { position: fixed; inset: 0; background: rgba(15,20,40,0.45); backdrop-filter: blur(3px); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 16px; }
        .modal-overlay.show { display: flex; }
        .modal { background: var(--surface); border-radius: var(--radius); width: 100%; max-width: 540px; max-height: 90vh; overflow-y: auto; box-shadow: 0 24px 64px rgba(0,0,0,0.15); animation: mIn .2s ease; }
        @keyframes mIn { from { opacity:0; transform: translateY(-12px) scale(0.98); } to { opacity:1; transform: none; } }
        .modal-head { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; background: var(--surface); z-index: 1; }
        .modal-title { font-size: 15px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 9px; }
        .modal-title i { color: var(--blue); }
        .modal-close { background: none; border: none; cursor: pointer; color: var(--muted); font-size: 16px; }
        .modal-close:hover { color: var(--text); }
        .modal-body { padding: 22px; }
        .modal-foot { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; }

        /* DETAIL MODAL */
        .detail-header { background: var(--bg); border-radius: var(--radius-sm); padding: 14px 16px; margin-bottom: 16px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .detail-info-label { font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; }
        .detail-info-val { font-size: 13px; font-weight: 700; color: var(--text); margin-top: 3px; }
        .detail-total-bar { background: var(--orange-dim); border-radius: var(--radius-sm); padding: 14px 16px; display: flex; justify-content: space-between; align-items: center; margin-top: 14px; }
        .loading-spinner { text-align: center; padding: 30px; color: var(--muted); }
        .loading-spinner i { font-size: 24px; color: var(--blue-dim); animation: spin 1s linear infinite; display: block; margin-bottom: 8px; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        /* SIDEBAR OVERLAY */
        .s-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.25); z-index: 99; }
        .s-overlay.show { display: block; }

        @media (max-width: 1000px) { .summary-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: none; } .main { margin-left: 0; } .menu-toggle { display: block !important; } }
        @media (max-width: 600px) { .content { padding: 16px; } .topbar { padding: 0 16px; } .topbar-time { display: none; } .summary-grid { grid-template-columns: 1fr; } .search-wrap input { width: 160px; } }
    </style>
</head>
<body>

<div class="s-overlay" id="sOverlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="logo-mark" style="background:none; padding:0;">
            <img src="/img/logo.png" alt="MomoPetshop Logo"
                 style="width:36px;height:36px;object-fit:contain;">
        </div>
        <div>
            <div class="logo-text">MomoPetshop</div>
            <div class="logo-sub">Admin Panel</div>
        </div>
    </div>
    <nav class="nav-wrap">
        <div class="nav-label">Menu Utama</div>
        <a href="/dashboard" class="nav-item <?= ($menu === 'dashboard') ? 'active' : '' ?>">
            <span class="nav-icon"><i class="fas fa-home"></i></span> Dashboard
        </a>
        <a href="/produk" class="nav-item <?= ($menu === 'produk') ? 'active' : '' ?>">
            <span class="nav-icon"><i class="fas fa-box"></i></span> Produk
        </a>
        <a href="/transaksi" class="nav-item <?= ($menu === 'transaksi') ? 'active' : '' ?>">
            <span class="nav-icon"><i class="fas fa-receipt"></i></span> Transaksi
            <?php if (!empty($notif_transaksi) && $notif_transaksi > 0): ?>
            <span class="nav-badge"><?= $notif_transaksi ?></span>
            <?php endif; ?>
        </a>
        <a href="/stok-masuk" class="nav-item <?= ($menu === 'stok_masuk') ? 'active' : '' ?>">
            <span class="nav-icon"><i class="fas fa-truck-loading"></i></span> Stok Masuk
        </a>
        <div class="nav-label">Manajemen</div>
        <a href="/user" class="nav-item <?= ($menu === 'user') ? 'active' : '' ?>">
            <span class="nav-icon"><i class="fas fa-user"></i></span> User
        </a>
        <a href="/laporan" class="nav-item <?= ($menu === 'laporan') ? 'active' : '' ?>">
            <span class="nav-icon"><i class="fas fa-chart-bar"></i></span> Laporan
        </a>
    </nav>
    <div class="sidebar-bottom">
        <a href="/logout" class="logout-btn">
            <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span> Logout
        </a>
    </div>
</aside>

<!-- MAIN -->
<div class="main">
    <header class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" style="display:none" onclick="openSidebar()"><i class="fas fa-bars"></i></button>
            <div>
                <div class="page-title"><?= esc($title) ?></div>
                <div class="breadcrumb">MomoPetshop › Transaksi</div>
            </div>
        </div>
        <!-- ✅ FIX: jam & kasir sama-sama di dalam topbar-right -->
        <div class="topbar-right">
            <div class="topbar-time"><i class="fas fa-clock"></i><span id="liveClock">--:--:--</span></div>
            <div class="topbar-kasir">
                <div class="kasir-avatar"><?= strtoupper(substr(session()->get('username') ?? 'A', 0, 1)) ?></div>
                <span class="kasir-name"><?= esc(session()->get('username') ?? 'Admin') ?></span>
            </div>
        </div>
    </header>

    <div class="content">

        <!-- Flash -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" id="flashAlert"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error" id="flashAlert"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Summary Cards -->
        <div class="summary-grid">
            <div class="sum-card">
                <div class="sum-icon blue"><i class="fas fa-receipt"></i></div>
                <div>
                    <div class="sum-val" style="color:var(--blue)"><?= count($transaksi) ?></div>
                    <div class="sum-label">Total Transaksi</div>
                </div>
            </div>
            <div class="sum-card">
                <div class="sum-icon orange"><i class="fas fa-wallet"></i></div>
                <div>
                    <div class="sum-val" style="color:var(--orange-dark);font-size:15px">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
                    <div class="sum-label">Total Pendapatan</div>
                </div>
            </div>
            <div class="sum-card">
                <div class="sum-icon green"><i class="fas fa-calendar-day"></i></div>
                <div>
                    <div class="sum-val" style="color:#15803d"><?= $count_hari_ini ?></div>
                    <div class="sum-label">Transaksi Hari Ini</div>
                </div>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="toolbar">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" id="searchInput" placeholder="Cari tanggal/ID..." oninput="filterTrx()">
            </div>
            <a href="/transaksi/tambah" class="btn btn-orange"><i class="fas fa-plus"></i> Transaksi Baru</a>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-head">
                <div class="card-title"><i class="fas fa-receipt"></i> Data Transaksi</div>
                <span class="badge b-blue"><?= count($transaksi) ?> data</span>
            </div>
            <div class="tw">
                <table id="trxTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaksi)): ?>
                        <?php $no = 1; foreach ($transaksi as $trx): ?>
                        <tr data-search="<?= esc($trx['id_transaksi']) ?> <?= esc($trx['tanggal']) ?>">
                            <td style="color:var(--muted);font-size:12px"><?= $no++ ?></td>
                            <td><span class="badge b-blue">#<?= $trx['id_transaksi'] ?></span></td>
                            <td>
                                <div style="font-weight:600"><?= date('d M Y', strtotime($trx['tanggal'])) ?></div>
                                <div style="font-size:11px;color:var(--muted)"><?= date('H:i', strtotime($trx['tanggal'])) ?></div>
                            </td>
                            <td><span style="font-weight:700;color:var(--orange-dark)">Rp <?= number_format($trx['total'], 0, ',', '.') ?></span></td>
                            <td>
                                <button class="btn btn-blue btn-sm" onclick="lihatDetail(<?= $trx['id_transaksi'] ?>)">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-receipt"></i>
                                    <p>Belum ada data transaksi</p>
                                    <a href="/transaksi/tambah" class="btn btn-orange" style="margin-top:14px"><i class="fas fa-plus"></i> Buat Transaksi</a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal-overlay" id="modalDetail">
    <div class="modal">
        <div class="modal-head">
            <div class="modal-title"><i class="fas fa-receipt"></i> Detail Transaksi</div>
            <button class="modal-close" onclick="tutupModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" id="modalBodyContent">
            <div class="loading-spinner">
                <i class="fas fa-circle-notch"></i>
                Memuat data...
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="tutupModal()">Tutup</button>
        </div>
    </div>
</div>

<script>
    function tick() {
        document.getElementById('liveClock').textContent =
            new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    tick(); setInterval(tick, 1000);

    const flashAlert = document.getElementById('flashAlert');
    if (flashAlert) {
        setTimeout(() => {
            flashAlert.style.transition = 'opacity .5s';
            flashAlert.style.opacity = '0';
            setTimeout(() => flashAlert.remove(), 500);
        }, 4000);
    }

    function openSidebar() { document.getElementById('sidebar').classList.add('open'); document.getElementById('sOverlay').classList.add('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sOverlay').classList.remove('show'); }
    window.addEventListener('resize', () => { document.querySelector('.menu-toggle').style.display = window.innerWidth <= 900 ? 'block' : 'none'; });
    window.dispatchEvent(new Event('resize'));

    function filterTrx() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('#trxTable tbody tr[data-search]').forEach(r => {
            r.style.display = r.dataset.search.toLowerCase().includes(q) ? '' : 'none';
        });
    }

    function lihatDetail(id) {
        document.getElementById('modalBodyContent').innerHTML = `
            <div class="loading-spinner">
                <i class="fas fa-circle-notch"></i>
                Memuat data...
            </div>`;
        document.getElementById('modalDetail').classList.add('show');

        fetch('/transaksi/detail/' + id)
            .then(r => r.json())
            .then(data => {
                const trx    = data.transaksi;
                const detail = data.detail;
                let itemsHtml = '';
                if (detail && detail.length > 0) {
                    detail.forEach(d => {
                        itemsHtml += `
                            <tr>
                                <td>${d.nama_produk || '-'}</td>
                                <td style="text-align:center">${d.qty}</td>
                                <td>Rp ${parseInt(d.harga).toLocaleString('id-ID')}</td>
                                <td style="font-weight:700;color:var(--orange-dark)">Rp ${parseInt(d.subtotal).toLocaleString('id-ID')}</td>
                            </tr>`;
                    });
                } else {
                    itemsHtml = `<tr><td colspan="4" style="text-align:center;padding:20px;color:var(--muted)">Tidak ada item</td></tr>`;
                }

                document.getElementById('modalBodyContent').innerHTML = `
                    <div class="detail-header">
                        <div>
                            <div class="detail-info-label">ID Transaksi</div>
                            <div class="detail-info-val">#${trx.id_transaksi}</div>
                        </div>
                        <div>
                            <div class="detail-info-label">Tanggal</div>
                            <div class="detail-info-val">${new Date(trx.tanggal).toLocaleDateString('id-ID', {day:'2-digit',month:'long',year:'numeric'})}</div>
                        </div>
                    </div>
                    <table style="font-size:12.5px;width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="border-bottom:1px solid var(--border)">
                                <th style="padding:8px 10px;text-align:left;font-size:10px;color:var(--muted);text-transform:uppercase">Produk</th>
                                <th style="padding:8px 10px;text-align:center;font-size:10px;color:var(--muted);text-transform:uppercase">Qty</th>
                                <th style="padding:8px 10px;text-align:left;font-size:10px;color:var(--muted);text-transform:uppercase">Harga</th>
                                <th style="padding:8px 10px;text-align:left;font-size:10px;color:var(--muted);text-transform:uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>${itemsHtml}</tbody>
                    </table>
                    <div class="detail-total-bar">
                        <span style="font-weight:700;font-size:13px">Grand Total</span>
                        <span style="font-weight:800;font-size:17px;color:var(--orange-dark)">Rp ${parseInt(trx.total).toLocaleString('id-ID')}</span>
                    </div>`;
            })
            .catch(() => {
                document.getElementById('modalBodyContent').innerHTML = `
                    <div style="text-align:center;padding:30px;color:var(--red)">
                        <i class="fas fa-exclamation-circle" style="font-size:28px;display:block;margin-bottom:8px"></i>
                        Gagal memuat detail transaksi
                    </div>`;
            });
    }

    function tutupModal() { document.getElementById('modalDetail').classList.remove('show'); }
    window.addEventListener('click', e => { if (e.target.classList.contains('modal-overlay')) e.target.classList.remove('show'); });
</script>
</body>
</html>