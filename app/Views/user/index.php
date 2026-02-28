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
        .nav-icon { width: 18px; text-align: center; font-size: 14px; color: var(--muted); flex-shrink: 0; }
        .nav-item.active .nav-icon { color: var(--blue); }
        .nav-badge { margin-left: auto; background: var(--orange); color: #fff; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 20px; }
        .sidebar-bottom { padding: 12px 10px; border-top: 1px solid var(--border); }
        .logout-btn { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--radius-sm); color: var(--muted); font-size: 13px; font-weight: 600; cursor: pointer; width: 100%; background: none; border: none; transition: all .15s; text-decoration: none; }
        .logout-btn:hover { background: #fff0f0; color: #e53e3e; }

        /* MAIN */
        .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { position: sticky; top: 0; z-index: 90; height: var(--topbar-h); background: rgba(245,247,252,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 26px; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .menu-toggle { display: none; background: none; border: none; cursor: pointer; color: var(--muted); font-size: 18px; }
        .page-title { font-size: 16px; font-weight: 700; }
        .breadcrumb { font-size: 11px; color: var(--muted); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .topbar-time { font-size: 12px; font-weight: 600; color: var(--muted); background: var(--surface); padding: 5px 13px; border-radius: 20px; border: 1px solid var(--border); display: flex; align-items: center; gap: 6px; }
        .topbar-time i { color: var(--blue); font-size: 11px; }
        .topbar-kasir { display: flex; align-items: center; gap: 8px; background: var(--surface); padding: 5px 13px 5px 6px; border-radius: 20px; border: 1px solid var(--border); }
        .kasir-avatar { width: 26px; height: 26px; border-radius: 50%; background: linear-gradient(135deg, var(--blue), var(--orange)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 11px; font-weight: 700; }
        .kasir-name { font-size: 12px; font-weight: 600; color: var(--text); }
        .content { padding: 24px 26px; flex: 1; }

        /* SUMMARY */
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
        .sum-card { background: var(--surface); border-radius: var(--radius); padding: 18px 20px; border: 1px solid var(--border); box-shadow: var(--shadow); display: flex; align-items: center; gap: 14px; }
        .sum-icon { width: 42px; height: 42px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; }
        .sum-icon.blue { background: var(--blue-dim); color: var(--blue); }
        .sum-icon.orange { background: var(--orange-dim); color: var(--orange-dark); }
        .sum-val { font-size: 20px; font-weight: 800; letter-spacing: -.5px; line-height: 1; }
        .sum-label { font-size: 11.5px; color: var(--muted); font-weight: 500; margin-top: 3px; }

        /* TOOLBAR */
        .toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .search-wrap { position: relative; }
        .search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 12px; pointer-events: none; }
        .search-wrap input { padding-left: 34px; width: 220px; }
        .form-control { width: 100%; padding: 9px 12px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; color: var(--text); background: var(--surface); outline: none; transition: border .15s, box-shadow .15s; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(74,144,226,0.1); }

        /* BTNS */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; text-decoration: none; }
        .btn-blue { background: var(--blue); color: #fff; }
        .btn-blue:hover { background: var(--blue-dark); }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-dark); }
        .btn-red { background: var(--red); color: #fff; }
        .btn-red:hover { background: #dc2626; }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }
        .btn-sm { padding: 5px 11px; font-size: 12px; }

        /* CARD TABLE */
        .card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
        .card-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
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

        /* ALERT */
        .alert { padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 18px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: var(--green-dim); color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error   { background: var(--red-dim); color: #b91c1c; border: 1px solid #fecaca; }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 52px 24px; color: var(--muted); }
        .empty-state i { font-size: 44px; color: var(--blue-dim); margin-bottom: 12px; display: block; }
        .empty-state p { font-weight: 600; font-size: 14px; }

        /* MODAL */
        .modal-overlay { position: fixed; inset: 0; background: rgba(15,20,40,0.45); backdrop-filter: blur(3px); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 16px; }
        .modal-overlay.show { display: flex; }
        .modal { background: var(--surface); border-radius: var(--radius); width: 100%; max-width: 400px; box-shadow: 0 24px 64px rgba(0,0,0,0.15); animation: mIn .2s ease; }
        @keyframes mIn { from { opacity:0; transform: translateY(-12px) scale(0.98); } to { opacity:1; transform: none; } }
        .modal-head { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .modal-title { font-size: 15px; font-weight: 700; display: flex; align-items: center; gap: 9px; }
        .modal-title i { color: var(--red); }
        .modal-close { background: none; border: none; cursor: pointer; color: var(--muted); font-size: 16px; }
        .modal-body { padding: 20px 22px; color: var(--muted); font-size: 13.5px; line-height: 1.6; }
        .modal-foot { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 8px; }

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
                <div class="breadcrumb">MomoPetshop › User</div>
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

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Summary Cards -->
        <div class="summary-grid">
            <div class="sum-card">
                <div class="sum-icon blue"><i class="fas fa-users"></i></div>
                <div>
                    <div class="sum-val" style="color:var(--blue)"><?= count($users) ?></div>
                    <div class="sum-label">Total User</div>
                </div>
            </div>
            <div class="sum-card">
                <div class="sum-icon orange"><i class="fas fa-user-check"></i></div>
                <div>
                    <div class="sum-val" style="color:var(--orange-dark)"><?= count($users) ?></div>
                    <div class="sum-label">User Aktif</div>
                </div>
            </div>
            <div class="sum-card">
                <div class="sum-icon blue"><i class="fas fa-calendar-day"></i></div>
                <div>
                    <div class="sum-val" style="color:var(--blue)"><?= date('d/m/Y') ?></div>
                    <div class="sum-label">Tanggal Hari Ini</div>
                </div>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="toolbar">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" id="searchInput" placeholder="Cari username..." oninput="filterUser()">
            </div>
            <a href="/user/create" class="btn btn-orange"><i class="fas fa-plus"></i> Tambah User</a>
        </div>

        <!-- Table Card -->
        <div class="card">
            <div class="card-head">
                <div class="card-title"><i class="fas fa-users"></i> Data User</div>
                <span class="badge b-blue"><?= count($users) ?> data</span>
            </div>
            <div class="tw">
                <table id="userTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID User</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                        <?php $no = 1; foreach ($users as $u): ?>
                        <tr data-username="<?= strtolower(esc($u['username'])) ?>">
                            <td style="color:var(--muted);font-size:12px"><?= $no++ ?></td>
                            <td><span class="badge b-muted">#<?= esc($u['id_user']) ?></span></td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:34px;height:34px;border-radius:50%;background:var(--blue-dim);display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--blue);font-size:13px;flex-shrink:0;">
                                        <?= strtoupper(substr($u['username'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div style="font-weight:700"><?= esc($u['username']) ?></div>
                                        <div style="font-size:11px;color:var(--muted)">Administrator</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-red btn-sm" onclick="konfirmasiHapus(<?= $u['id_user'] ?>, '<?= esc($u['username']) ?>')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <p>Belum ada data user</p>
                                    <a href="/user/create" class="btn btn-orange" style="margin-top:14px"><i class="fas fa-plus"></i> Tambah User</a>
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

<!-- MODAL KONFIRMASI HAPUS -->
<div class="modal-overlay" id="modalHapus">
    <div class="modal">
        <div class="modal-head">
            <div class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</div>
            <button class="modal-close" onclick="tutupModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            Apakah kamu yakin ingin menghapus user <strong id="namaUser"></strong>? Tindakan ini tidak dapat dibatalkan.
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="tutupModal()">Batal</button>
            <a href="#" id="linkHapus" class="btn btn-red"><i class="fas fa-trash"></i> Hapus</a>
        </div>
    </div>
</div>

<script>
    // CLOCK
    function tick() {
        const now  = new Date();
        const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('liveClock').textContent = time;
    }
    tick(); setInterval(tick, 1000);

    // SIDEBAR
    function openSidebar()  { document.getElementById('sidebar').classList.add('open');    document.getElementById('sOverlay').classList.add('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sOverlay').classList.remove('show'); }
    window.addEventListener('resize', () => { document.querySelector('.menu-toggle').style.display = window.innerWidth <= 900 ? 'block' : 'none'; });
    window.dispatchEvent(new Event('resize'));

    // SEARCH
    function filterUser() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('#userTable tbody tr[data-username]').forEach(r => {
            r.style.display = r.dataset.username.includes(q) ? '' : 'none';
        });
    }

    // MODAL HAPUS
    function konfirmasiHapus(id, nama) {
        document.getElementById('namaUser').textContent = nama;
        document.getElementById('linkHapus').href = '/user/delete/' + id;
        document.getElementById('modalHapus').classList.add('show');
    }
    function tutupModal() { document.getElementById('modalHapus').classList.remove('show'); }
    window.addEventListener('click', e => { if (e.target.classList.contains('modal-overlay')) e.target.classList.remove('show'); });
</script>
</body>
</html>