<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Stok Masuk — <?= esc($nama_toko) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blue: #4A90E2; --blue-dark: #2563c4; --blue-dim: #e8f2fc;
            --orange: #FFA726; --orange-dark: #cc7a00; --orange-dim: #fff4e5;
            --red: #ef4444; --red-dim: #fee2e2;
            --green-dim: #dcfce7;
            --bg: #f5f7fc; --surface: #ffffff; --border: #eaecf2;
            --text: #1a1f36; --muted: #8b93a7;
            --sidebar-w: 230px; --topbar-h: 62px;
            --radius: 14px; --radius-sm: 9px;
            --shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 16px rgba(0,0,0,0.04);
        }
        html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); font-size: 14px; }

        /* SIDEBAR — sama persis */
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

        /* FORM CARD */
        .form-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; max-width: 680px; }
        .form-card-head { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
        .form-icon { width: 40px; height: 40px; border-radius: var(--radius-sm); background: var(--orange-dim); display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--orange-dark); }
        .form-card-title { font-size: 15px; font-weight: 700; }
        .form-card-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }
        .form-body { padding: 24px; display: flex; flex-direction: column; gap: 18px; }

        /* FORM FIELDS */
        .field-group { display: flex; flex-direction: column; gap: 6px; }
        .field-label { font-size: 12px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 6px; }
        .field-label span.req { color: var(--red); }
        .field-input, .field-select { width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 13.5px; color: var(--text); background: var(--bg); outline: none; transition: border .15s, background .15s; }
        .field-input:focus, .field-select:focus { border-color: var(--orange); background: #fff; }
        .field-input.is-invalid, .field-select.is-invalid { border-color: var(--red); background: var(--red-dim); }
        .field-hint { font-size: 11px; color: var(--muted); }
        .field-error { font-size: 11.5px; color: var(--red); font-weight: 600; display: flex; align-items: center; gap: 4px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }

        /* ALERT */
        .alert { padding: 12px 18px; border-radius: var(--radius-sm); margin-bottom: 16px; display: flex; gap: 10px; font-size: 13px; font-weight: 500; }
        .alert-error { background: var(--red-dim); color: #b91c1c; border: 1px solid #fca5a5; flex-direction: column; }
        .alert-error ul { padding-left: 18px; margin-top: 4px; }
        .alert-error li { font-size: 12.5px; }

        /* FORM FOOTER */
        .form-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: var(--bg); }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; text-decoration: none; }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-dark); }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--surface); color: var(--text); }

        /* SIDEBAR OVERLAY */
        .s-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.25); z-index: 99; }
        .s-overlay.show { display: block; }

        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: none; } .main { margin-left: 0; } .menu-toggle { display: block !important; } }
        @media (max-width: 600px) { .content { padding: 16px; } .topbar { padding: 0 16px; } .topbar-time { display: none; } .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="s-overlay" id="sOverlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
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
                <div class="page-title">Tambah Stok Masuk</div>
                <div class="breadcrumb"><?= esc($nama_toko) ?> › <a href="/stok-masuk" style="color:var(--blue);text-decoration:none">Stok Masuk</a> › Tambah</div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="topbar-time">
                <i class="fas fa-clock"></i>
                <span id="liveClock">--:--:--</span>
            </div>
            <div class="topbar-kasir">
                <div class="kasir-avatar"><?= strtoupper(substr($kasir, 0, 1)) ?></div>
                <span class="kasir-name"><?= esc($kasir) ?></span>
            </div>
        </div>
    </header>

    <div class="content">

        <!-- Validation Errors -->
        <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-error">
            <div><i class="fas fa-exclamation-triangle"></i> <strong>Terdapat kesalahan pada form:</strong></div>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="form-card">
            <div class="form-card-head">
                <div class="form-icon"><i class="fas fa-plus"></i></div>
                <div>
                    <div class="form-card-title">Tambah Stok Masuk</div>
                    <div class="form-card-sub">Isi detail penerimaan barang dari supplier</div>
                </div>
            </div>

            <form action="/stok-masuk/store" method="POST">
                <?= csrf_field() ?>
                <div class="form-body">

                    <!-- Produk -->
                    <div class="field-group">
                        <label class="field-label" for="id_produk">
                            <i class="fas fa-box" style="color:var(--orange)"></i>
                            Produk <span class="req">*</span>
                        </label>
                        <select name="id_produk" id="id_produk" class="field-select <?= (isset($errors['id_produk'])) ? 'is-invalid' : '' ?>" required>
                            <option value="">— Pilih Produk —</option>
                            <?php foreach ($produk as $p): ?>
                            <option value="<?= $p['id_produk'] ?>" <?= (old('id_produk') == $p['id_produk']) ? 'selected' : '' ?>>
                                <?= esc($p['nama_produk']) ?> (Stok: <?= $p['stok'] ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['id_produk'])): ?>
                        <div class="field-error"><i class="fas fa-circle-exclamation"></i> <?= $errors['id_produk'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Supplier -->
                    <div class="field-group">
                        <label class="field-label" for="id_supplier">
                            <i class="fas fa-truck" style="color:var(--blue)"></i>
                            Supplier <span class="req">*</span>
                        </label>
                        <select name="id_supplier" id="id_supplier" class="field-select <?= (isset($errors['id_supplier'])) ? 'is-invalid' : '' ?>" required>
                            <option value="">— Pilih Supplier —</option>
                            <?php foreach ($supplier as $s): ?>
                            <option value="<?= $s['id_supplier'] ?>" <?= (old('id_supplier') == $s['id_supplier']) ? 'selected' : '' ?>>
                                <?= esc($s['nama_supplier']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['id_supplier'])): ?>
                        <div class="field-error"><i class="fas fa-circle-exclamation"></i> <?= $errors['id_supplier'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Jumlah & Tanggal side by side -->
                    <div class="form-grid">
                        <div class="field-group">
                            <label class="field-label" for="jumlah">
                                <i class="fas fa-cubes" style="color:var(--orange)"></i>
                                Jumlah <span class="req">*</span>
                            </label>
                            <input type="number" name="jumlah" id="jumlah" min="1"
                                   class="field-input <?= (isset($errors['jumlah'])) ? 'is-invalid' : '' ?>"
                                   placeholder="Masukkan jumlah unit"
                                   value="<?= old('jumlah') ?>" required>
                            <div class="field-hint">Jumlah unit yang diterima dari supplier</div>
                            <?php if (isset($errors['jumlah'])): ?>
                            <div class="field-error"><i class="fas fa-circle-exclamation"></i> <?= $errors['jumlah'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="tanggal">
                                <i class="fas fa-calendar" style="color:var(--blue)"></i>
                                Tanggal <span class="req">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal"
                                   class="field-input <?= (isset($errors['tanggal'])) ? 'is-invalid' : '' ?>"
                                   value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                            <?php if (isset($errors['tanggal'])): ?>
                            <div class="field-error"><i class="fas fa-circle-exclamation"></i> <?= $errors['tanggal'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div><!-- /form-body -->

                <div class="form-footer">
                    <a href="/stok-masuk" class="btn btn-ghost">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-orange">
                        <i class="fas fa-save"></i> Simpan Stok Masuk
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function tick() {
        document.getElementById('liveClock').textContent =
            new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    tick(); setInterval(tick, 1000);
    function openSidebar()  { document.getElementById('sidebar').classList.add('open');  document.getElementById('sOverlay').classList.add('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sOverlay').classList.remove('show'); }
    window.addEventListener('resize', () => { document.querySelector('.menu-toggle').style.display = window.innerWidth <= 900 ? 'block' : 'none'; });
    window.dispatchEvent(new Event('resize'));
</script>
</body>
</html>
