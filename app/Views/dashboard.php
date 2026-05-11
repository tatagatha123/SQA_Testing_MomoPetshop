<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — <?= esc($nama_toko) ?></title>
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

        .sidebar { position: fixed; left: 0; top: 0; width: var(--sidebar-w); height: 100vh; background: var(--surface); border-right: 1px solid var(--border); display: flex; flex-direction: column; z-index: 100; transition: transform .25s ease; }

        /* ===== LOGO SIDEBAR */
        .sidebar-logo {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 11px;
            flex-shrink: 0;
        }
        .logo-mark {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .logo-mark img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }
        .logo-text { font-size: 14px; font-weight: 800; color: var(--text); letter-spacing: -.3px; line-height: 1.2; }
        .logo-sub { font-size: 10px; color: var(--muted); font-weight: 500; margin-top: 2px; }
        /* ===================================== */

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

        .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { position: sticky; top: 0; z-index: 90; height: var(--topbar-h); background: rgba(245,247,252,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 26px; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .menu-toggle { display: none; background: none; border: none; cursor: pointer; color: var(--muted); font-size: 18px; padding: 4px; }
        .page-title { font-size: 16px; font-weight: 700; color: var(--text); }
        .breadcrumb { font-size: 11px; color: var(--muted); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .topbar-kasir { display: flex; align-items: center; gap: 8px; background: var(--surface); padding: 5px 13px 5px 6px; border-radius: 20px; border: 1px solid var(--border); }
        .kasir-avatar { width: 26px; height: 26px; border-radius: 50%; background: linear-gradient(135deg, var(--blue), var(--orange)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 11px; font-weight: 700; }
        .kasir-name { font-size: 12px; font-weight: 600; color: var(--text); }

        .content { padding: 24px 26px; flex: 1; }

        .welcome { background: linear-gradient(120deg, #1a3a6b 0%, var(--blue) 55%, var(--orange) 100%); border-radius: var(--radius); padding: 24px 28px; margin-bottom: 20px; color: #fff; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: hidden; }
        .welcome::after { content: '🐾'; position: absolute; right: 24px; top: 50%; transform: translateY(-50%); font-size: 80px; opacity: 0.1; pointer-events: none; }
        .welcome h2 { font-size: 20px; font-weight: 800; margin-bottom: 5px; letter-spacing: -.3px; }
        .welcome p { font-size: 13px; opacity: .82; }
        .welcome-ops { background: rgba(255,255,255,0.15); border-radius: 12px; padding: 14px 20px; text-align: center; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.22); min-width: 165px; }
        .clock-big { font-size: 26px; font-weight: 800; letter-spacing: 1px; font-variant-numeric: tabular-nums; }
        .clock-date { font-size: 11px; opacity: .78; margin-top: 3px; }
        .ops-tag { margin-top: 8px; font-size: 10px; background: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 20px; display: inline-block; }

        .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
        .stat-card { background: var(--surface); border-radius: var(--radius); padding: 20px; border: 1px solid var(--border); box-shadow: var(--shadow); display: flex; align-items: center; gap: 14px; }
        .stat-icon { width: 46px; height: 46px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .stat-icon.blue { background: var(--blue-dim); color: var(--blue); }
        .stat-icon.orange { background: var(--orange-dim); color: var(--orange-dark); }
        .stat-val { font-size: 22px; font-weight: 800; letter-spacing: -.5px; line-height: 1; }
        .stat-label { font-size: 12px; color: var(--muted); font-weight: 500; margin-top: 3px; }
        .stat-trend { font-size: 11px; font-weight: 600; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
        .stat-trend.blue { color: var(--blue); }
        .stat-trend.orange { color: var(--orange-dark); }

        .card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 16px; }
        .card-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: 13.5px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px; }
        .card-title i { color: var(--blue); font-size: 13px; }
        .tw { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { border-bottom: 1px solid var(--border); }
        th { padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--muted); text-align: left; white-space: nowrap; }
        td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 13px; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: var(--bg); }

        .badge { padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; }
        .b-blue { background: var(--blue-dim); color: var(--blue-dark); }
        .b-orange { background: var(--orange-dim); color: var(--orange-dark); }

        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: var(--radius-sm); font-family: inherit; font-size: 12.5px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; text-decoration: none; }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }
        .btn-sm { padding: 5px 11px; font-size: 12px; }

        .stok-alert { background: linear-gradient(90deg, var(--orange-dim), #fff); border: 1px solid #ffd18040; border-radius: var(--radius); padding: 14px 18px; margin-bottom: 16px; display: flex; align-items: center; gap: 12px; font-size: 13px; }
        .stok-alert i { color: var(--orange-dark); font-size: 16px; }

        .info-boxes { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px; }
        .info-box { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); padding: 16px 20px; box-shadow: var(--shadow); }
        .info-box-label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
        .info-box-val { font-size: 15px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px; }

        .recent-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .empty-state { text-align: center; padding: 28px; color: var(--muted); }
        .empty-state i { display: block; font-size: 28px; margin-bottom: 8px; }

        .s-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.25); z-index: 99; }
        .s-overlay.show { display: block; }

        @media (max-width: 1000px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } .recent-grid { grid-template-columns: 1fr; } .info-boxes { grid-template-columns: 1fr; } }
        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: none; } .main { margin-left: 0; } .menu-toggle { display: block !important; } }
        @media (max-width: 600px) { .stat-grid { grid-template-columns: 1fr; } .content { padding: 16px; } .topbar { padding: 0 16px; } .welcome { flex-direction: column; gap: 14px; } .welcome-ops { width: 100%; } }
    </style>
</head>
<body>

<div class="s-overlay" id="sOverlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <!-- ===== LOGO SIDEBAR (DIPERBAIKI) ===== -->
    <div class="sidebar-logo">
        <div class="logo-mark">
            <img src="/img/logo.png" alt="MomoPetshop Logo">
        </div>
        <div>
            <div class="logo-text">MomoPetshop</div>
            <div class="logo-sub">Admin Panel</div>
        </div>
    </div>
    <!-- ====================================== -->

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

<div class="main">
    <header class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" style="display:none" onclick="openSidebar()"><i class="fas fa-bars"></i></button>
            <div>
                <div class="page-title">Dashboard</div>
                <div class="breadcrumb"><?= esc($nama_toko) ?> › Dashboard</div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="topbar-kasir">
                <div class="kasir-avatar"><?= strtoupper(substr($kasir, 0, 1)) ?></div>
                <span class="kasir-name"><?= esc($kasir) ?></span>
            </div>
        </div>
    </header>

    <div class="content">

        <div class="welcome">
            <div>
                <h2 id="greeting">Selamat Datang, <?= esc($kasir) ?>! 👋</h2>
                <p><?= esc($nama_toko) ?> — Sistem Kasir &amp; Administrasi</p>
                <p style="margin-top:7px;font-size:12px;opacity:.7;">
                    <i class="fas fa-store" style="margin-right:5px"></i>
                    Jam Operasional: <strong>08.00 – 20.00 WIB</strong>
                </p>
            </div>
            <div class="welcome-ops">
                <div class="clock-big" id="bigClock">--:--:--</div>
                <div class="clock-date" id="bigDate">--</div>
                <div class="ops-tag">🟢 Sedang Buka</div>
            </div>
        </div>

        <div class="info-boxes">
            <div class="info-box">
                <div class="info-box-label">Nama Toko</div>
                <div class="info-box-val"><span style="font-size:20px">🏪</span><?= esc($nama_toko) ?></div>
            </div>
            <div class="info-box">
                <div class="info-box-label">Kasir Bertugas</div>
                <div class="info-box-val">
                    <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,var(--blue),var(--orange));display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700">
                        <?= strtoupper(substr($kasir, 0, 1)) ?>
                    </div>
                    <?= esc($kasir) ?>
                </div>
            </div>
        </div>

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-box"></i></div>
                <div>
                    <div class="stat-val" style="color:var(--blue)"><?= $total_produk ?></div>
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-trend blue"><i class="fas fa-database" style="font-size:9px"></i> Tersedia di toko</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-receipt"></i></div>
                <div>
                    <div class="stat-val" style="color:var(--orange-dark)"><?= $total_transaksi ?></div>
                    <div class="stat-label">Total Transaksi</div>
                    <?php if ($notif_transaksi > 0): ?>
                        <div class="stat-trend orange"><i class="fas fa-bell" style="font-size:9px"></i> <?= $notif_transaksi ?> baru hari ini</div>
                    <?php else: ?>
                        <div class="stat-trend orange"><i class="fas fa-clock" style="font-size:9px"></i> Belum ada transaksi hari ini</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-wallet"></i></div>
                <div>
                    <div class="stat-val" style="color:var(--orange-dark);font-size:17px">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-trend orange"><i class="fas fa-arrow-trend-up" style="font-size:9px"></i> Dari seluruh transaksi</div>
                </div>
            </div>
        </div>

        <!-- <div class="stok-alert">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Perhatian stok!</strong>
                <span style="color:var(--muted);margin-left:6px">Beberapa produk stoknya menipis.
                    <a href="/produk" style="color:var(--orange-dark);font-weight:700">Cek sekarang →</a>
                </span>
            </div>
        </div> -->

        <div class="recent-grid">
            <div class="card">
                <div class="card-head">
                    <div class="card-title"><i class="fas fa-receipt"></i> Transaksi Hari Ini</div>
                    <a href="/transaksi" class="btn btn-ghost btn-sm">Lihat semua</a>
                </div>
                <div class="tw">
                    <table>
                        <thead>
                            <tr><th>#</th><th>Waktu</th><th>Kasir</th><th>Total</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_transaksi)): ?>
                                <?php foreach ($recent_transaksi as $trx): ?>
                                    <tr>
                                        <td><span class="badge b-blue">#<?= esc($trx['id_transaksi']) ?></span></td>
                                        <td><?= date('H:i', strtotime($trx['tanggal'])) ?></td>
                                        <td><?= esc($trx['kasir'] ?? '-') ?></td>
                                        <td><strong>Rp <?= number_format($trx['total'], 0, ',', '.') ?></strong></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-clock" style="color:var(--blue-dim)"></i>
                                        Belum ada transaksi hari ini
                                    </div>
                                </td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <div class="card-title">
                        <i class="fas fa-truck-loading" style="color:var(--orange)"></i> Stok Masuk Hari Ini
                    </div>
                    <a href="/stok-masuk" class="btn btn-ghost btn-sm">Lihat semua</a>
                </div>
                <div class="tw">
                    <table>
                        <thead>
                            <tr><th>Produk</th><th>Supplier</th><th>Jumlah</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_stok)): ?>
                                <?php foreach ($recent_stok as $stok): ?>
                                    <tr>
                                        <td><?= esc($stok['nama_produk'] ?? '-') ?></td>
                                        <td style="color:var(--muted);font-size:12px"><?= esc($stok['nama_supplier'] ?? '-') ?></td>
                                        <td><span class="badge b-orange"><?= esc($stok['jumlah']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3">
                                    <div class="empty-state">
                                        <i class="fas fa-box-open" style="color:var(--orange-dim)"></i>
                                        Belum ada stok masuk hari ini
                                    </div>
                                </td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function tick() {
        const now  = new Date();
        const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        const date = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('bigClock').textContent = time;
        document.getElementById('bigDate').textContent  = date;

        const h    = now.getHours();
        const name = '<?= esc($kasir) ?>';
        const g    = h < 12 ? 'Selamat Pagi' : h < 15 ? 'Selamat Siang' : h < 18 ? 'Selamat Sore' : 'Selamat Malam';
        document.getElementById('greeting').textContent = g + ', ' + name + '! 👋';
    }
    tick();
    setInterval(tick, 1000);

    function openSidebar()  { document.getElementById('sidebar').classList.add('open');    document.getElementById('sOverlay').classList.add('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sOverlay').classList.remove('show'); }
    window.addEventListener('resize', () => { document.querySelector('.menu-toggle').style.display = window.innerWidth <= 900 ? 'block' : 'none'; });
    window.dispatchEvent(new Event('resize'));
</script>
</body>
</html>