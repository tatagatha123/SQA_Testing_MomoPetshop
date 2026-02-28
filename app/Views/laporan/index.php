<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan — MomoPetshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blue: #4A90E2; --blue-dark: #2563c4; --blue-dim: #e8f2fc;
            --orange: #FFA726; --orange-dark: #cc7a00; --orange-dim: #fff4e5;
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
        .sidebar-bottom { padding: 12px 10px; border-top: 1px solid var(--border); }
        .logout-btn { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--radius-sm); color: var(--muted); font-size: 13px; font-weight: 600; cursor: pointer; width: 100%; background: none; border: none; transition: all .15s; text-decoration: none; }
        .logout-btn:hover { background: #fff0f0; color: #e53e3e; }

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

        /* STAT CARDS */
        .stat-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-bottom: 24px; }
        .stat-card { background: var(--surface); border-radius: var(--radius); padding: 20px; border: 1px solid var(--border); box-shadow: var(--shadow); display: flex; align-items: center; gap: 14px; }
        .stat-icon { width: 46px; height: 46px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .stat-icon.blue { background: var(--blue-dim); color: var(--blue); }
        .stat-icon.green { background: #e6f9f0; color: #27ae60; }
        .stat-val { font-size: 22px; font-weight: 800; letter-spacing: -.5px; line-height: 1; }
        .stat-label { font-size: 12px; color: var(--muted); font-weight: 500; margin-top: 3px; }

        /* PAGE HEADER */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .page-header h1 { font-size: 20px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 10px; }
        .page-header h1 i { color: var(--blue); }

        /* CARD */
        .card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
        .card-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: 13.5px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px; }
        .card-title i { color: var(--blue); font-size: 13px; }

        /* TABLE */
        .tw { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { border-bottom: 1px solid var(--border); }
        th { padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--muted); text-align: left; white-space: nowrap; }
        td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 13px; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: var(--bg); }

        /* BADGE */
        .badge { padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; }
        .b-blue { background: var(--blue-dim); color: var(--blue-dark); }
        .b-green { background: #e6f9f0; color: #27ae60; }

        /* EMPTY */
        .empty-state { text-align: center; padding: 40px; color: var(--muted); }
        .empty-state i { display: block; font-size: 32px; margin-bottom: 10px; opacity: .4; }

        /* PRINT BTN */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: var(--radius-sm); font-family: inherit; font-size: 12.5px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; text-decoration: none; }
        .btn-blue { background: var(--blue); color: #fff; }
        .btn-blue:hover { background: var(--blue-dark); }

        /* SIDEBAR OVERLAY */
        .s-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.25); z-index: 99; }
        .s-overlay.show { display: block; }

        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: none; } .main { margin-left: 0; } .menu-toggle { display: block !important; } }
        @media (max-width: 600px) { .stat-grid { grid-template-columns: 1fr; } .content { padding: 16px; } .topbar { padding: 0 16px; } .topbar-time { display: none; } }
        @media print { .sidebar, .topbar, .btn, .s-overlay { display: none !important; } .main { margin-left: 0; } }
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
                <div class="page-title">Laporan Penjualan</div>
                <div class="breadcrumb">MomoPetshop › Laporan</div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="topbar-time">
                <i class="fas fa-clock"></i>
                <span id="liveClock">--:--:--</span>
            </div>
            <div class="topbar-kasir">
                <div class="kasir-avatar"><?= strtoupper(substr(session()->get('username') ?? 'A', 0, 1)) ?></div>
                <span class="kasir-name"><?= esc(session()->get('username') ?? 'Admin') ?></span>
            </div>
        </div>
    </header>

    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="fas fa-chart-bar"></i> Laporan Penjualan</h1>
            <button class="btn btn-blue" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
        </div>

        <!-- Stat Cards -->
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-receipt"></i></div>
                <div>
                    <div class="stat-val" style="color:var(--blue)"><?= $totalTransaksi ?></div>
                    <div class="stat-label">Total Transaksi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-wallet"></i></div>
                <div>
                    <div class="stat-val" style="color:#27ae60;font-size:18px">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></div>
                    <div class="stat-label">Total Pendapatan</div>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="card">
            <div class="card-head">
                <div class="card-title"><i class="fas fa-table"></i> Semua Transaksi</div>
            </div>
            <div class="tw">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Kasir</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaksi)): ?>
                            <?php foreach ($transaksi as $trx): ?>
                                <tr>
                                    <td><span class="badge b-blue">#<?= esc($trx['id_transaksi']) ?></span></td>
                                    <td><?= date('d M Y', strtotime($trx['tanggal'])) ?></td>
                                    <td style="color:var(--muted)"><?= date('H:i', strtotime($trx['tanggal'])) ?></td>
                                    <td><?= esc($trx['kasir'] ?? '-') ?></td>
                                    <td><strong style="color:#27ae60">Rp <?= number_format($trx['total'], 0, ',', '.') ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-receipt"></i>
                                        Belum ada data transaksi
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- /content -->
</div><!-- /main -->

<script>
    function tick() {
        const now  = new Date();
        const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('liveClock').textContent = time;
    }
    tick(); setInterval(tick, 1000);

    function openSidebar()  { document.getElementById('sidebar').classList.add('open');    document.getElementById('sOverlay').classList.add('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sOverlay').classList.remove('show'); }

    window.addEventListener('resize', () => {
        document.querySelector('.menu-toggle').style.display = window.innerWidth <= 900 ? 'block' : 'none';
    });
    window.dispatchEvent(new Event('resize'));
</script>
</body>
</html>