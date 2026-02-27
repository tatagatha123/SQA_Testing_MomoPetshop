<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk — <?= esc($nama_toko) ?></title>
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

        /* ── SIDEBAR ── */
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

        /* ── TOPBAR ── */
        .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { position: sticky; top: 0; z-index: 90; height: var(--topbar-h); background: rgba(245,247,252,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 26px; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .menu-toggle { display: none; background: none; border: none; cursor: pointer; color: var(--muted); font-size: 18px; padding: 4px; }
        .page-title { font-size: 16px; font-weight: 700; color: var(--text); }
        .breadcrumb { font-size: 11px; color: var(--muted); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .topbar-time { font-size: 12px; font-weight: 600; color: var(--muted); background: var(--surface); padding: 5px 13px; border-radius: 20px; border: 1px solid var(--border); display: flex; align-items: center; gap: 6px; }
        .topbar-time i { color: var(--blue); font-size: 11px; }

        /* ── CONTENT ── */
        .content { padding: 24px 26px; flex: 1; }

        /* ── TOOLBAR ── */
        .toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .toolbar-left { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .search-wrap { position: relative; }
        .search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 12px; pointer-events: none; }
        .search-wrap input { padding-left: 34px; width: 220px; }

        /* ── FORM CONTROLS ── */
        .form-control { width: 100%; padding: 9px 12px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; color: var(--text); background: var(--surface); outline: none; transition: border .15s, box-shadow .15s; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(74,144,226,0.1); }

        /* ── BTNS ── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; text-decoration: none; }
        .btn-blue { background: var(--blue); color: #fff; }
        .btn-blue:hover { background: var(--blue-dark); }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-dark); }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }
        .btn-sm { padding: 5px 11px; font-size: 12px; }
        .btn-danger { background: transparent; color: var(--orange-dark); border: 1px solid var(--orange-dim); }
        .btn-danger:hover { background: var(--orange-dim); }

        /* ── VIEW TOGGLE ── */
        .view-toggle { display: flex; gap: 4px; background: var(--bg); padding: 3px; border-radius: var(--radius-sm); border: 1px solid var(--border); }
        .view-btn { padding: 5px 10px; border-radius: 6px; background: none; border: none; cursor: pointer; color: var(--muted); font-size: 13px; transition: all .15s; }
        .view-btn.active { background: var(--surface); color: var(--blue); box-shadow: 0 1px 4px rgba(0,0,0,0.08); }

        /* ── PRODUCT GRID ── */
        .prod-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(195px, 1fr)); gap: 16px; }
        .prod-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; transition: transform .15s, box-shadow .15s; }
        .prod-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(74,144,226,0.13); }
        .prod-img { height: 135px; background: var(--bg); display: flex; align-items: center; justify-content: center; font-size: 48px; border-bottom: 1px solid var(--border); }
        .prod-body { padding: 14px; }
        .prod-name { font-size: 13.5px; font-weight: 700; margin-bottom: 5px; color: var(--text); }
        .prod-price { font-size: 15px; font-weight: 800; color: var(--orange-dark); margin-top: 8px; }
        .prod-actions { display: flex; gap: 6px; margin-top: 10px; }

        /* ── PRODUCT TABLE ── */
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

        /* ── EMPTY STATE ── */
        .empty-state { text-align: center; padding: 56px 24px; color: var(--muted); }
        .empty-state i { font-size: 48px; color: var(--blue-dim); margin-bottom: 12px; display: block; }
        .empty-state p { font-weight: 600; font-size: 14px; }

        /* ── MODAL ── */
        .modal-overlay { position: fixed; inset: 0; background: rgba(15,20,40,0.45); backdrop-filter: blur(3px); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 16px; }
        .modal-overlay.show { display: flex; }
        .modal { background: var(--surface); border-radius: var(--radius); width: 100%; max-width: 380px; box-shadow: 0 24px 64px rgba(0,0,0,0.15); animation: mIn .2s ease; }
        @keyframes mIn { from { opacity:0; transform: translateY(-12px) scale(0.98); } to { opacity:1; transform: none; } }
        .modal-head { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .modal-title { font-size: 15px; font-weight: 700; color: var(--text); }
        .modal-close { background: none; border: none; cursor: pointer; color: var(--muted); font-size: 16px; transition: color .15s; }
        .modal-close:hover { color: var(--text); }
        .modal-body { padding: 24px 22px; text-align: center; }
        .modal-foot { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 8px; }

        /* ── SIDEBAR OVERLAY ── */
        .s-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.25); z-index: 99; }
        .s-overlay.show { display: block; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: none; } .main { margin-left: 0; } .menu-toggle { display: block !important; } }
        @media (max-width: 600px) { .content { padding: 16px; } .topbar { padding: 0 16px; } .topbar-time { display: none; } .search-wrap input { width: 150px; } }
    </style>
</head>
<body>

<div class="s-overlay" id="sOverlay" onclick="closeSidebar()"></div>

<!-- ═══ SIDEBAR ═══ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="logo-mark">🐾</div>
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
        <a href="/auth/logout" class="logout-btn">
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
                <div class="page-title">Manajemen Produk</div>
                <div class="breadcrumb"><?= esc($nama_toko) ?> › Produk</div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="topbar-time"><i class="fas fa-clock"></i><span id="liveClock">--:--:--</span></div>
        </div>
    </header>

    <div class="content">

        <!-- Toolbar -->
        <div class="toolbar">
            <div class="toolbar-left">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari produk..." oninput="filterProd()">
                </div>
            </div>
            <div style="display:flex;gap:8px;align-items:center;">
                <div class="view-toggle">
                    <button class="view-btn active" id="btnGrid" onclick="setView('grid')" title="Grid"><i class="fas fa-th-large"></i></button>
                    <button class="view-btn" id="btnList" onclick="setView('list')" title="List"><i class="fas fa-list"></i></button>
                </div>
                <a href="/produk/tambah" class="btn btn-orange"><i class="fas fa-plus"></i> Tambah Produk</a>
            </div>
        </div>

        <!-- ── GRID VIEW ── -->
        <div id="viewGrid">
            <?php if (!empty($daftar_produk)): ?>
            <div class="prod-grid" id="prodGrid">
                <?php
                // Emoji mapping berdasarkan nama produk
                $emojis = ['kucing'=>'','anjing'=>'','shampoo'=>'','vitamin'=>'','kandang'=>'','mainan'=>'','makanan'=>'','snack'=>''];
                foreach ($daftar_produk as $p):
                    $emoji = '🐾';
                    foreach ($emojis as $k => $e) {
                        if (stripos($p['nama'], $k) !== false) { $emoji = $e; break; }
                    }
                ?>
                <div class="prod-card" data-nama="<?= strtolower(esc($p['nama'])) ?>">
                    <div class="prod-img"><?= $emoji ?></div>
                    <div class="prod-body">
                        <div class="prod-name"><?= esc($p['nama']) ?></div>
                        <div style="font-size:11.5px;color:var(--muted);display:flex;align-items:center;gap:4px;">
                            <i class="fas fa-tag" style="color:var(--blue);font-size:10px"></i> Produk
                        </div>
                        <div class="prod-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></div>
                        <div class="prod-actions">
                            <a href="/produk/edit/<?= $loop ?? 0 ?>" class="btn btn-blue btn-sm" style="flex:1"><i class="fas fa-pen"></i> Edit</a>
                            <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('<?= esc($p['nama']) ?>')"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>Belum ada produk</p>
                <a href="/produk/tambah" class="btn btn-orange" style="margin-top:14px"><i class="fas fa-plus"></i> Tambah Produk</a>
            </div>
            <?php endif; ?>
        </div>

        <!-- ── LIST VIEW ── -->
        <div id="viewList" style="display:none;">
            <div class="card">
                <div class="card-head">
                    <div class="card-title"><i class="fas fa-box"></i> Daftar Produk</div>
                    <span class="badge b-blue"><?= count($daftar_produk) ?> produk</span>
                </div>
                <div class="tw">
                    <table id="prodTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($daftar_produk)): ?>
                            <?php foreach ($daftar_produk as $i => $p): ?>
                            <tr data-nama="<?= strtolower(esc($p['nama'])) ?>">
                                <td style="color:var(--muted);font-size:12px"><?= $i + 1 ?></td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div style="width:36px;height:36px;background:var(--bg);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;border:1px solid var(--border)">🐾</div>
                                        <strong><?= esc($p['nama']) ?></strong>
                                    </div>
                                </td>
                                <td style="font-weight:700;color:var(--orange-dark)">Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                                <td>
                                    <div style="display:flex;gap:6px;">
                                        <a href="/produk/edit/<?= $i ?>" class="btn btn-blue btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                        <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('<?= esc($p['nama']) ?>')"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr><td colspan="4" class="empty-state" style="padding:40px">
                                <i class="fas fa-box-open" style="font-size:36px;color:var(--blue-dim);display:block;margin-bottom:8px"></i>
                                Belum ada produk
                            </td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Hapus -->
<div class="modal-overlay" id="modalHapus">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Hapus Produk</span>
            <button class="modal-close" onclick="tutupModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div style="width:54px;height:54px;background:var(--orange-dim);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:22px;color:var(--orange-dark)">
                <i class="fas fa-trash"></i>
            </div>
            <p style="font-weight:700;font-size:15px;margin-bottom:6px">Hapus produk ini?</p>
            <p style="color:var(--muted);font-size:13px" id="hapusNama"></p>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="tutupModal()">Batal</button>
            <button class="btn btn-orange" id="hapusBtn"><i class="fas fa-trash"></i> Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    // ── CLOCK ──
    function tick() {
        document.getElementById('liveClock').textContent =
            new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    tick(); setInterval(tick, 1000);

    // ── SIDEBAR ──
    function openSidebar() { document.getElementById('sidebar').classList.add('open'); document.getElementById('sOverlay').classList.add('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sOverlay').classList.remove('show'); }
    window.addEventListener('resize', () => { document.querySelector('.menu-toggle').style.display = window.innerWidth <= 900 ? 'block' : 'none'; });
    window.dispatchEvent(new Event('resize'));

    // ── VIEW TOGGLE ──
    function setView(v) {
        document.getElementById('viewGrid').style.display = v === 'grid' ? 'block' : 'none';
        document.getElementById('viewList').style.display = v === 'list' ? 'block' : 'none';
        document.getElementById('btnGrid').classList.toggle('active', v === 'grid');
        document.getElementById('btnList').classList.toggle('active', v === 'list');
    }

    // ── SEARCH / FILTER ──
    function filterProd() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.prod-card').forEach(c => {
            c.style.display = (c.dataset.nama || '').includes(q) ? '' : 'none';
        });
        document.querySelectorAll('#prodTable tbody tr[data-nama]').forEach(r => {
            r.style.display = (r.dataset.nama || '').includes(q) ? '' : 'none';
        });
    }

    // ── MODAL HAPUS ──
    function konfirmasiHapus(nama) {
        document.getElementById('hapusNama').textContent = '"' + nama + '" akan dihapus permanen.';
        document.getElementById('modalHapus').classList.add('show');
    }
    function tutupModal() { document.getElementById('modalHapus').classList.remove('show'); }
    window.addEventListener('click', e => { if (e.target.classList.contains('modal-overlay')) e.target.classList.remove('show'); });
</script>
</body>
</html>
