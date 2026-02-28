<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> — <?= esc($nama_toko) ?></title>
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
        .nav-badge { margin-left: auto; background: var(--orange); color: #fff; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 20px; min-width: 20px; text-align: center; }
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

        /* CONTENT */
        .content { padding: 24px 26px; flex: 1; }

        /* FORM CARD */
        .form-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); max-width: 620px; }
        .form-card-head { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 10px; }
        .form-card-head i { color: var(--blue); font-size: 16px; }
        .form-card-title { font-size: 15px; font-weight: 700; color: var(--text); }
        .form-body { padding: 24px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 12.5px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
        .form-label span.req { color: var(--red); margin-left: 2px; }
        .form-label span.opt { color: var(--muted); font-weight: 400; font-size: 11px; margin-left: 4px; }
        .form-control { width: 100%; padding: 10px 13px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; color: var(--text); background: var(--surface); outline: none; transition: border .15s, box-shadow .15s; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(74,144,226,0.1); }
        .form-control.is-invalid { border-color: var(--red); }
        .form-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
        .invalid-feedback { font-size: 11.5px; color: var(--red); margin-top: 4px; font-weight: 600; display: flex; align-items: center; gap: 4px; }
        .form-hint { font-size: 11px; color: var(--muted); margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        select.form-control { cursor: pointer; }
        .form-foot { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: flex-end; gap: 10px; }

        /* FOTO UPLOAD AREA */
        .foto-upload-area {
            border: 2px dashed var(--border);
            border-radius: var(--radius-sm);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            background: var(--bg);
            position: relative;
        }
        .foto-upload-area:hover { border-color: var(--blue); background: var(--blue-dim); }
        .foto-upload-area.has-file { border-color: var(--blue); border-style: solid; background: var(--blue-dim); }
        .foto-upload-area input[type="file"] {
            position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
        }
        .foto-upload-icon { font-size: 28px; color: var(--blue); opacity: .5; margin-bottom: 8px; }
        .foto-upload-text { font-size: 12.5px; font-weight: 600; color: var(--muted); }
        .foto-upload-sub { font-size: 11px; color: var(--muted); margin-top: 3px; }

        /* PREVIEW FOTO */
        .foto-preview-box {
            display: flex; align-items: center; gap: 14px;
            background: var(--bg); border: 1px solid var(--border);
            border-radius: var(--radius-sm); padding: 10px 14px;
            margin-bottom: 10px;
        }
        .foto-preview-box img {
            width: 60px; height: 60px; object-fit: cover;
            border-radius: 8px; border: 1px solid var(--border); flex-shrink: 0;
        }
        .foto-preview-info { flex: 1; }
        .foto-preview-label { font-size: 11.5px; font-weight: 700; color: var(--text); margin-bottom: 2px; }
        .foto-preview-sub { font-size: 11px; color: var(--muted); }
        .foto-remove-btn {
            background: none; border: none; color: var(--muted); cursor: pointer;
            font-size: 14px; padding: 4px; border-radius: 6px; transition: all .15s;
        }
        .foto-remove-btn:hover { background: var(--red-dim); color: var(--red); }

        /* BTNS */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; text-decoration: none; }
        .btn-blue { background: var(--blue); color: #fff; }
        .btn-blue:hover { background: var(--blue-dark); }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-dark); }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }

        /* SIDEBAR OVERLAY */
        .s-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.25); z-index: 99; }
        .s-overlay.show { display: block; }

        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: none; } .main { margin-left: 0; } .menu-toggle { display: block !important; } }
        @media (max-width: 600px) { .content { padding: 16px; } .topbar { padding: 0 16px; } .topbar-time { display: none; } .form-row { grid-template-columns: 1fr; } }
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
                <div class="breadcrumb">
                    <?= esc($nama_toko) ?> ›
                    <a href="/produk" style="color:var(--blue);text-decoration:none;">Produk</a> ›
                    <?= esc($title) ?>
                </div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="topbar-time"><i class="fas fa-clock"></i><span id="liveClock">--:--:--</span></div>
        </div>
    </header>

    <div class="content">

        <div class="form-card">
            <div class="form-card-head">
                <i class="fas fa-<?= $produk ? 'pen' : 'plus-circle' ?>"></i>
                <div class="form-card-title"><?= esc($title) ?></div>
            </div>

            <?php $actionUrl = $produk ? '/produk/update/' . $produk['id_produk'] : '/produk/store'; ?>

            <form action="<?= $actionUrl ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-body">

                    <!-- Nama Produk -->
                    <div class="form-group">
                        <label class="form-label" for="nama_produk">
                            Nama Produk <span class="req">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama_produk"
                            name="nama_produk"
                            class="form-control <?= ($validation && $validation->hasError('nama_produk')) ? 'is-invalid' : '' ?>"
                            placeholder="Contoh: Royal Canin Adult Cat"
                            value="<?= old('nama_produk', $produk['nama_produk'] ?? '') ?>"
                        >
                        <?php if ($validation && $validation->hasError('nama_produk')): ?>
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            <?= $validation->getError('nama_produk') ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Harga & Stok -->
                    <div class="form-row">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label" for="harga">
                                Harga (Rp) <span class="req">*</span>
                            </label>
                            <input
                                type="number"
                                id="harga"
                                name="harga"
                                class="form-control <?= ($validation && $validation->hasError('harga')) ? 'is-invalid' : '' ?>"
                                placeholder="Contoh: 50000"
                                min="0"
                                step="any"
                                value="<?= old('harga', $produk['harga'] ?? '') ?>"
                            >
                            <?php if ($validation && $validation->hasError('harga')): ?>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                <?= $validation->getError('harga') ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label" for="stok">
                                Stok <span class="req">*</span>
                            </label>
                            <input
                                type="number"
                                id="stok"
                                name="stok"
                                class="form-control <?= ($validation && $validation->hasError('stok')) ? 'is-invalid' : '' ?>"
                                placeholder="Contoh: 100"
                                min="0"
                                value="<?= old('stok', $produk['stok'] ?? '') ?>"
                            >
                            <?php if ($validation && $validation->hasError('stok')): ?>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                <?= $validation->getError('stok') ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="form-group" style="margin-top:18px">
                        <label class="form-label" for="id_kategori">
                            Kategori <span class="req">*</span>
                        </label>
                        <select
                            id="id_kategori"
                            name="id_kategori"
                            class="form-control <?= ($validation && $validation->hasError('id_kategori')) ? 'is-invalid' : '' ?>"
                        >
                            <option value="">— Pilih Kategori —</option>
                            <?php foreach ($kategoris as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>" <?= (old('id_kategori', $produk['id_kategori'] ?? '') == $k['id_kategori']) ? 'selected' : '' ?>>
                                <?= esc($k['nama_kategori']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($validation && $validation->hasError('id_kategori')): ?>
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            <?= $validation->getError('id_kategori') ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Supplier -->
                    <div class="form-group">
                        <label class="form-label" for="id_supplier">
                            Supplier <span class="req">*</span>
                        </label>
                        <select
                            id="id_supplier"
                            name="id_supplier"
                            class="form-control <?= ($validation && $validation->hasError('id_supplier')) ? 'is-invalid' : '' ?>"
                        >
                            <option value="">— Pilih Supplier —</option>
                            <?php foreach ($suppliers as $s): ?>
                            <option value="<?= $s['id_supplier'] ?>" <?= (old('id_supplier', $produk['id_supplier'] ?? '') == $s['id_supplier']) ? 'selected' : '' ?>>
                                <?= esc($s['nama_supplier']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($validation && $validation->hasError('id_supplier')): ?>
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            <?= $validation->getError('id_supplier') ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- ══════════════════════════════════════
                         FOTO PRODUK
                    ══════════════════════════════════════ -->
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">
                            Foto Produk
                            <span class="opt">(opsional · JPG / PNG · maks 2 MB)</span>
                        </label>

                        <?php
                        // Ambil foto saat ini dari controller (mode edit)
                        $fotoSekarang = $foto_url ?? null;
                        ?>

                        <?php if ($fotoSekarang): ?>
                        <!-- Foto yang sudah ada (mode edit) -->
                        <div class="foto-preview-box" id="fotoSaatIni">
                            <img src="<?= $fotoSekarang ?>" alt="Foto produk saat ini">
                            <div class="foto-preview-info">
                                <div class="foto-preview-label">Foto saat ini</div>
                                <div class="foto-preview-sub">Upload gambar baru untuk mengganti</div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Preview sebelum upload -->
                        <div class="foto-preview-box" id="newFotoPreview" style="display:none;">
                            <img src="" alt="Preview" id="previewImg">
                            <div class="foto-preview-info">
                                <div class="foto-preview-label" id="previewNama">—</div>
                                <div class="foto-preview-sub" id="previewUkuran">—</div>
                            </div>
                            <button type="button" class="foto-remove-btn" onclick="hapusPreview()" title="Batal pilih foto">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Drop zone -->
                        <div class="foto-upload-area" id="uploadArea">
                            <input
                                type="file"
                                id="foto_produk"
                                name="foto_produk"
                                accept="image/jpeg,image/png"
                                onchange="previewFoto(this)"
                            >
                            <div class="foto-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div class="foto-upload-text">Klik atau seret foto ke sini</div>
                            <div class="foto-upload-sub">JPG / PNG · Maks 2 MB</div>
                        </div>

                        <?php if ($validation && $validation->hasError('foto_produk')): ?>
                        <div class="invalid-feedback" style="margin-top:6px">
                            <i class="fas fa-exclamation-circle"></i>
                            <?= $validation->getError('foto_produk') ?>
                        </div>
                        <?php endif; ?>
                    </div>

                </div><!-- /form-body -->

                <div class="form-foot">
                    <a href="/produk" class="btn btn-ghost">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-orange">
                        <i class="fas fa-save"></i>
                        <?= $produk ? 'Simpan Perubahan' : 'Tambah Produk' ?>
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<script>
    // CLOCK
    function tick() {
        document.getElementById('liveClock').textContent =
            new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    tick(); setInterval(tick, 1000);

    // SIDEBAR
    function openSidebar() { document.getElementById('sidebar').classList.add('open'); document.getElementById('sOverlay').classList.add('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sOverlay').classList.remove('show'); }
    window.addEventListener('resize', () => { document.querySelector('.menu-toggle').style.display = window.innerWidth <= 900 ? 'block' : 'none'; });
    window.dispatchEvent(new Event('resize'));

    // FOTO PREVIEW
    function previewFoto(input) {
        const file    = input.files && input.files[0];
        const preview = document.getElementById('newFotoPreview');
        const img     = document.getElementById('previewImg');
        const nama    = document.getElementById('previewNama');
        const ukuran  = document.getElementById('previewUkuran');
        const area    = document.getElementById('uploadArea');

        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            img.src     = e.target.result;
            nama.textContent   = file.name;
            ukuran.textContent = (file.size / 1024).toFixed(1) + ' KB';
            preview.style.display = 'flex';
            area.classList.add('has-file');
        };
        reader.readAsDataURL(file);
    }

    function hapusPreview() {
        document.getElementById('foto_produk').value = '';
        document.getElementById('newFotoPreview').style.display = 'none';
        document.getElementById('uploadArea').classList.remove('has-file');
    }

    // Drag & drop highlight
    const area = document.getElementById('uploadArea');
    area.addEventListener('dragover',  e => { e.preventDefault(); area.style.borderColor = 'var(--blue)'; area.style.background = 'var(--blue-dim)'; });
    area.addEventListener('dragleave', () => { area.style.borderColor = ''; area.style.background = ''; });
    area.addEventListener('drop',      () => { area.style.borderColor = ''; area.style.background = ''; });
</script>
</body>
</html>