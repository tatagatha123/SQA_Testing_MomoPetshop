<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Masuk — <?= esc($nama_toko) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blue: #4A90E2; --blue-dark: #2563c4; --blue-dim: #e8f2fc;
            --orange: #FFA726; --orange-dark: #cc7a00; --orange-dim: #fff4e5;
            --green: #22c55e; --green-dim: #dcfce7;
            --red: #ef4444;   --red-dim: #fee2e2;
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

        /* PAGE HEADER */
        .page-header { background: linear-gradient(120deg, #1a3a6b 0%, var(--blue) 55%, var(--orange) 100%); border-radius: var(--radius); padding: 24px 28px; margin-bottom: 20px; color: #fff; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: hidden; }
        .page-header::after { content: '📦'; position: absolute; right: 24px; top: 50%; transform: translateY(-50%); font-size: 80px; opacity: 0.1; pointer-events: none; }
        .page-header h2 { font-size: 20px; font-weight: 800; margin-bottom: 5px; letter-spacing: -.3px; }
        .page-header p { font-size: 13px; opacity: .82; }
        .stat-mini { background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.22); border-radius: 12px; padding: 14px 22px; text-align: center; flex-shrink: 0; min-width: 140px; }
        .stat-mini-val { font-size: 28px; font-weight: 800; }
        .stat-mini-label { font-size: 11px; opacity: .78; margin-top: 3px; }

        /* ALERT */
        .alert { padding: 12px 18px; border-radius: var(--radius-sm); margin-bottom: 16px; display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 500; }
        .alert-success { background: var(--green-dim); color: #15803d; border: 1px solid #86efac; }
        .alert-error   { background: var(--red-dim);   color: #b91c1c; border: 1px solid #fca5a5; }
        .alert i { font-size: 15px; }

        /* CARD */
        .card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
        .card-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
        .card-title { font-size: 13.5px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px; }
        .card-title i { color: var(--orange); }
        .card-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

        /* SEARCH */
        .search-wrap { position: relative; }
        .search-wrap input { padding: 7px 12px 7px 34px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--bg); font-family: inherit; font-size: 12.5px; color: var(--text); outline: none; width: 210px; transition: border .15s; }
        .search-wrap input:focus { border-color: var(--blue); background: #fff; }
        .search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 12px; pointer-events: none; }

        /* TABLE */
        .tw { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { border-bottom: 2px solid var(--border); background: var(--bg); }
        th { padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--muted); text-align: left; white-space: nowrap; }
        td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 13px; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #fafbff; }
        .no-row td { background: none !important; }

        /* BADGES */
        .badge { padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; }
        .b-blue   { background: var(--blue-dim);   color: var(--blue-dark); }
        .b-orange { background: var(--orange-dim); color: var(--orange-dark); }
        .b-green  { background: var(--green-dim);  color: #15803d; }

        /* BTN */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: var(--radius-sm); font-family: inherit; font-size: 12.5px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; text-decoration: none; }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-dark); }
        .btn-ghost  { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }
        .btn-red    { background: var(--red-dim); color: var(--red); border: 1px solid #fca5a5; }
        .btn-red:hover { background: var(--red); color: #fff; }
        .btn-sm { padding: 5px 10px; font-size: 11.5px; }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 52px 20px; color: var(--muted); }
        .empty-state i { font-size: 42px; color: #fde68a; margin-bottom: 12px; display: block; }
        .empty-state strong { display: block; font-size: 14px; color: var(--text); margin-bottom: 4px; }
        .empty-state p { font-size: 12.5px; }

        /* MODAL HAPUS */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.35); z-index: 200; align-items: center; justify-content: center; }
        .modal-overlay.show { display: flex; }
        .modal { background: var(--surface); border-radius: var(--radius); padding: 28px; width: 90%; max-width: 440px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); position: relative; animation: fadeUp .2s ease; }
        @keyframes fadeUp { from { transform: translateY(16px); opacity: 0; } to { transform: none; opacity: 1; } }
        .modal-icon { width: 52px; height: 52px; border-radius: 50%; background: var(--red-dim); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .modal-icon i { font-size: 22px; color: var(--red); }
        .modal-title { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
        .modal-desc { font-size: 13px; color: var(--muted); margin-bottom: 22px; line-height: 1.6; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
        .modal-close { position: absolute; top: 14px; right: 14px; background: none; border: none; cursor: pointer; color: var(--muted); font-size: 16px; }
        .modal-close:hover { color: var(--text); }

        /* OVERLAY SIDEBAR */
        .s-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.25); z-index: 99; }
        .s-overlay.show { display: block; }

        /* RESPONSIVE */
        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: none; } .main { margin-left: 0; } .menu-toggle { display: block !important; } }
        @media (max-width: 600px) { .content { padding: 16px; } .topbar { padding: 0 16px; } .topbar-time { display: none; } .page-header { flex-direction: column; gap: 14px; } .stat-mini { width: 100%; } .search-wrap input { width: 100%; } }
    </style>
</head>
<body>

<div class="s-overlay" id="sOverlay" onclick="closeSidebar()"></div>

<!-- ═══ SIDEBAR ═══ -->
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

<!-- ═══ MAIN ═══ -->
<div class="main">
    <header class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" style="display:none" onclick="openSidebar()"><i class="fas fa-bars"></i></button>
            <div>
                <div class="page-title">Stok Masuk</div>
                <div class="breadcrumb"><?= esc($nama_toko) ?> › Stok Masuk</div>
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

        <!-- Header Banner -->
        <div class="page-header">
            <div>
                <h2>📦 Manajemen Stok Masuk</h2>
                <p><?= esc($nama_toko) ?> — Kelola penerimaan barang dari supplier</p>
                <p style="margin-top:7px;font-size:12px;opacity:.7">
                    <i class="fas fa-info-circle" style="margin-right:5px"></i>
                    Setiap penambahan stok akan otomatis memperbarui stok produk
                </p>
            </div>
            <div class="stat-mini">
                <div class="stat-mini-val"><?= $total_stok ?></div>
                <div class="stat-mini-label">Total Entri Stok</div>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <!-- Table Card -->
        <div class="card">
            <div class="card-head">
                <div class="card-title">
                    <i class="fas fa-truck-loading"></i> Daftar Stok Masuk
                </div>
                <div class="card-actions">
                    <div class="search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Cari produk / supplier…" oninput="filterTable()">
                    </div>
                    <a href="/stok-masuk/create" class="btn btn-orange">
                        <i class="fas fa-plus"></i> Tambah Stok
                    </a>
                </div>
            </div>

            <div class="tw">
                <table id="stokTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Supplier</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th style="text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($stok_masuk)): ?>
                            <?php foreach ($stok_masuk as $i => $s): ?>
                            <tr>
                                <td style="color:var(--muted);font-weight:600;width:40px"><?= $i + 1 ?></td>
                                <td>
                                    <div style="font-weight:600"><?= esc($s['nama_produk'] ?? '—') ?></div>
                                    <div style="font-size:11px;color:var(--muted)">ID Produk: <?= $s['id_produk'] ?></div>
                                </td>
                                <td>
                                    <span class="badge b-blue">
                                        <i class="fas fa-truck" style="font-size:9px"></i>
                                        <?= esc($s['nama_supplier'] ?? 'Tanpa Supplier') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge b-orange">
                                        <i class="fas fa-plus" style="font-size:9px"></i>
                                        <?= number_format($s['jumlah'], 0, ',', '.') ?> unit
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight:600"><?= date('d M Y', strtotime($s['tanggal'])) ?></div>
                                    <div style="font-size:11px;color:var(--muted)"><?= date('l', strtotime($s['tanggal'])) ?></div>
                                </td>
                                <td style="text-align:center;white-space:nowrap">
                                    <a href="/stok-masuk/edit/<?= $s['id_stok'] ?>" class="btn btn-ghost btn-sm">
                                        <i class="fas fa-pen"></i> Edit
                                    </a>
                                    <button class="btn btn-red btn-sm" onclick="confirmDelete(<?= $s['id_stok'] ?>, '<?= esc($s['nama_produk']) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="no-row">
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-box-open"></i>
                                        <strong>Belum ada data stok masuk</strong>
                                        <p>Klik <strong>Tambah Stok</strong> untuk menambahkan penerimaan barang pertama</p>
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

<!-- ═══ MODAL KONFIRMASI HAPUS ═══ -->
<div class="modal-overlay" id="modalHapus">
    <div class="modal">
        <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
        <div class="modal-icon"><i class="fas fa-trash"></i></div>
        <div class="modal-title">Hapus Stok Masuk?</div>
        <div class="modal-desc" id="modalDesc">
            Stok produk juga akan dikurangi secara otomatis. Tindakan ini tidak dapat dibatalkan.
        </div>
        <div class="modal-actions">
            <button class="btn btn-ghost" onclick="closeModal()">Batal</button>
            <a href="#" class="btn btn-red" id="btnHapus">
                <i class="fas fa-trash"></i> Ya, Hapus
            </a>
        </div>
    </div>
</div>

<script>
    // ── CLOCK ──
    function tick() {
        const now  = new Date();
        const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('liveClock').textContent = time;
    }
    tick(); setInterval(tick, 1000);

    // ── SEARCH FILTER ──
    function filterTable() {
        const q    = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#stokTable tbody tr:not(.no-row)');
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    }

    // ── MODAL HAPUS ──
    function confirmDelete(id, nama) {
        document.getElementById('modalDesc').innerHTML =
            `Anda akan menghapus stok masuk untuk produk <strong>${nama}</strong>.<br>Stok produk juga akan dikurangi. Tindakan ini tidak dapat dibatalkan.`;
        document.getElementById('btnHapus').href = '/stok-masuk/delete/' + id;
        document.getElementById('modalHapus').classList.add('show');
    }
    function closeModal() {
        document.getElementById('modalHapus').classList.remove('show');
    }
    document.getElementById('modalHapus').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    // ── SIDEBAR ──
    function openSidebar()  { document.getElementById('sidebar').classList.add('open');  document.getElementById('sOverlay').classList.add('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sOverlay').classList.remove('show'); }
    window.addEventListener('resize', () => {
        document.querySelector('.menu-toggle').style.display = window.innerWidth <= 900 ? 'block' : 'none';
    });
    window.dispatchEvent(new Event('resize'));
</script>
</body>
</html>
