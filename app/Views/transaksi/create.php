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
        .sidebar { position: fixed; left: 0; top: 0; width: var(--sidebar-w); height: 100vh; background: var(--surface); border-right: 1px solid var(--border); display: flex; flex-direction: column; z-index: 100; transition: transform .25s ease; }
        .sidebar-logo { padding: 22px 20px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 11px; }
        .logo-mark { width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0; background: linear-gradient(135deg, var(--blue), var(--orange)); display: flex; align-items: center; justify-content: center; font-size: 17px; }
        .logo-text { font-size: 14px; font-weight: 800; color: var(--text); }
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
        .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { position: sticky; top: 0; z-index: 90; height: var(--topbar-h); background: rgba(245,247,252,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 26px; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .menu-toggle { display: none; background: none; border: none; cursor: pointer; color: var(--muted); font-size: 18px; padding: 4px; }
        .page-title { font-size: 16px; font-weight: 700; color: var(--text); }
        .breadcrumb { font-size: 11px; color: var(--muted); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .topbar-time { font-size: 12px; font-weight: 600; color: var(--muted); background: var(--surface); padding: 5px 13px; border-radius: 20px; border: 1px solid var(--border); display: flex; align-items: center; gap: 6px; }
        .topbar-time i { color: var(--blue); font-size: 11px; }
        .content { padding: 24px 26px; flex: 1; }
        .back-link { display: inline-flex; align-items: center; gap: 7px; color: var(--muted); font-size: 13px; font-weight: 600; text-decoration: none; margin-bottom: 18px; transition: color .15s; }
        .back-link:hover { color: var(--blue); }
        .form-layout { display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start; }
        .form-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); margin-bottom: 16px; }
        .form-card:last-child { margin-bottom: 0; }
        .form-card-head { padding: 16px 22px; border-bottom: 1px solid var(--border); }
        .form-card-title { font-size: 13.5px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 9px; }
        .form-card-title i { color: var(--orange); }
        .form-card-sub { font-size: 11.5px; color: var(--muted); margin-top: 2px; }
        .form-card-body { padding: 20px 22px; }
        .form-group { margin-bottom: 14px; }
        .form-group:last-child { margin-bottom: 0; }
        .form-label { display: block; font-size: 11px; font-weight: 700; color: var(--muted); margin-bottom: 5px; letter-spacing: .4px; text-transform: uppercase; }
        .form-label span { color: var(--orange-dark); }
        .form-control { width: 100%; padding: 9px 12px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; color: var(--text); background: var(--surface); outline: none; transition: border .15s, box-shadow .15s; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(74,144,226,0.1); }
        .form-control.is-error { border-color: var(--red) !important; box-shadow: 0 0 0 3px rgba(239,68,68,0.12) !important; }
        select.form-control { cursor: pointer; }
        .items-header { display: grid; grid-template-columns: 1fr 90px 110px 32px; gap: 8px; margin-bottom: 6px; }
        .items-header span { font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; }
        .item-row { display: grid; grid-template-columns: 1fr 90px 110px 32px; gap: 8px; align-items: center; margin-bottom: 4px; }
        .item-meta { grid-column: 1 / -1; display: flex; gap: 10px; align-items: center; margin-bottom: 8px; padding: 0 2px; }
        .stok-badge { font-size: 11px; font-weight: 600; color: var(--muted); background: var(--bg); border: 1px solid var(--border); padding: 2px 9px; border-radius: 20px; }
        .stok-badge.low  { color: var(--orange-dark); background: var(--orange-dim); border-color: var(--orange); }
        .stok-badge.empty { color: var(--red); background: var(--red-dim); border-color: var(--red); }
        .qty-err { font-size: 11px; color: var(--red); font-weight: 600; display: none; }
        .qty-err.show { display: block; }
        .del-btn { width: 32px; height: 36px; border-radius: var(--radius-sm); background: transparent; border: 1.5px solid var(--border); color: var(--muted); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .15s; font-size: 12px; flex-shrink: 0; }
        .del-btn:hover { background: var(--red-dim); border-color: var(--red); color: var(--red); }
        .add-item-btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: var(--radius-sm); font-family: inherit; font-size: 12.5px; font-weight: 600; cursor: pointer; border: 1.5px dashed var(--border); background: transparent; color: var(--muted); transition: all .15s; margin-top: 4px; }
        .add-item-btn:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-dim); }
        .summary-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); position: sticky; top: calc(var(--topbar-h) + 16px); }
        .summary-card-head { padding: 16px 20px; border-bottom: 1px solid var(--border); }
        .summary-card-title { font-size: 13.5px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px; }
        .summary-card-title i { color: var(--blue); }
        .summary-card-body { padding: 18px 20px; }
        .summary-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--border); font-size: 13px; }
        .summary-row:last-child { border-bottom: none; }
        .summary-row .label { color: var(--muted); font-weight: 500; }
        .summary-row .val { font-weight: 700; color: var(--text); }
        .summary-total { background: var(--orange-dim); border-radius: var(--radius-sm); padding: 14px 16px; margin-top: 14px; display: flex; justify-content: space-between; align-items: center; }
        .summary-total .t-label { font-weight: 700; font-size: 13px; }
        .summary-total .t-val { font-weight: 800; font-size: 20px; color: var(--orange-dark); }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; text-decoration: none; width: 100%; justify-content: center; }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-dark); }
        .btn-orange:disabled { background: #ccc; cursor: not-allowed; }
        .btn-ghost { background: transparent; color: var(--muted); border: 1.5px solid var(--border); margin-top: 8px; }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }
        .s-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.25); z-index: 99; }
        .s-overlay.show { display: block; }
        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: none; } .main { margin-left: 0; } .menu-toggle { display: block !important; } .form-layout { grid-template-columns: 1fr; } .summary-card { position: static; } }
        @media (max-width: 600px) { .content { padding: 16px; } .topbar { padding: 0 16px; } .topbar-time { display: none; } .item-row, .items-header { grid-template-columns: 1fr 70px 32px; } .item-row .harga-col, .items-header .harga-head { display: none; } }
    </style>
</head>
<body>

<?php
// Encode produk ke JSON — SERTAKAN stok untuk validasi JS
$produkJson = json_encode(array_map(fn($p) => [
    'id'    => (int)$p['id_produk'],
    'nama'  => $p['nama_produk'],
    'harga' => (float)$p['harga'],
    'stok'  => (int)$p['stok'],
], $daftar_produk));
?>

<div class="s-overlay" id="sOverlay" onclick="closeSidebar()"></div>

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

<div class="main">
    <header class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" style="display:none" onclick="openSidebar()"><i class="fas fa-bars"></i></button>
            <div>
                <div class="page-title"><?= esc($title) ?></div>
                <div class="breadcrumb">
                    MomoPetshop ›
                    <a href="/transaksi" style="color:var(--blue);text-decoration:none;">Transaksi</a> › Baru
                </div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="topbar-time"><i class="fas fa-clock"></i><span id="liveClock">--:--:--</span></div>
        </div>
    </header>

    <div class="content">
        <a href="/transaksi" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Transaksi</a>

        <form action="/transaksi/simpan" method="post" id="formTrx" onsubmit="return validasiForm()">
            <?= csrf_field() ?>
            <div class="form-layout">

                <!-- KIRI -->
                <div>
                    <!-- Info Tanggal -->
                    <div class="form-card">
                        <div class="form-card-head">
                            <div class="form-card-title"><i class="fas fa-file-invoice"></i> Info Transaksi</div>
                            <div class="form-card-sub">Tanggal transaksi</div>
                        </div>
                        <div class="form-card-body">
                            <div class="form-group">
                                <label class="form-label">Tanggal <span>*</span></label>
                                <input type="datetime-local" name="tanggal" class="form-control"
                                    value="<?= date('Y-m-d\TH:i') ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Item Produk -->
                    <div class="form-card">
                        <div class="form-card-head">
                            <div class="form-card-title"><i class="fas fa-box"></i> Item Produk</div>
                            <div class="form-card-sub">Pilih produk dari database, harga & stok otomatis terisi</div>
                        </div>
                        <div class="form-card-body">

                            <div class="items-header">
                                <span>Produk</span>
                                <span>Qty</span>
                                <span class="harga-head">Harga (Rp)</span>
                                <span></span>
                            </div>

                            <div id="itemsContainer">
                                <!-- Row pertama -->
                                <div class="item-row" id="row-0">
                                    <select name="id_produk[]" class="form-control produk-select"
                                            onchange="isiHarga(this)" required>
                                        <option value="">— Pilih Produk —</option>
                                        <?php foreach ($daftar_produk as $p): ?>
                                        <option value="<?= $p['id_produk'] ?>"
                                                data-harga="<?= $p['harga'] ?>"
                                                data-stok="<?= $p['stok'] ?>">
                                            <?= esc($p['nama_produk']) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="number" name="qty[]" class="form-control qty-input"
                                           placeholder="1" min="1" value="1"
                                           oninput="validasiQty(this); hitungTotal()" required>
                                    <input type="number" name="harga[]" class="form-control harga-input harga-col"
                                           placeholder="0" readonly
                                           style="background:var(--bg);color:var(--muted);cursor:not-allowed;">
                                    <button type="button" class="del-btn" onclick="hapusItem(this)" title="Hapus">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <!-- Meta baris pertama: info stok + pesan error qty -->
                                <div class="item-meta" id="meta-0">
                                    <span class="stok-badge" id="stok-info-0">Pilih produk dahulu</span>
                                    <span class="qty-err" id="qty-err-0"><i class="fas fa-exclamation-triangle"></i> <span class="qty-err-msg"></span></span>
                                </div>
                            </div>

                            <button type="button" class="add-item-btn" onclick="tambahItem()">
                                <i class="fas fa-plus"></i> Tambah Item
                            </button>
                        </div>
                    </div>
                </div>

                <!-- KANAN -->
                <div>
                    <div class="summary-card">
                        <div class="summary-card-head">
                            <div class="summary-card-title"><i class="fas fa-calculator"></i> Ringkasan</div>
                        </div>
                        <div class="summary-card-body">
                            <div class="summary-row">
                                <span class="label">Jumlah Item</span>
                                <span class="val" id="sumItems">1</span>
                            </div>
                            <div class="summary-row">
                                <span class="label">Total Qty</span>
                                <span class="val" id="sumQty">1</span>
                            </div>
                            <div class="summary-total">
                                <span class="t-label">Total Bayar</span>
                                <span class="t-val" id="sumTotal">Rp 0</span>
                            </div>
                            <input type="hidden" name="total" id="totalInput" value="0">
                            <button type="submit" class="btn btn-orange" id="btnSimpan" style="margin-top:16px">
                                <i class="fas fa-save"></i> Simpan Transaksi
                            </button>
                            <a href="/transaksi" class="btn btn-ghost">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    // ── Data produk dari PHP ──
    const produkData = <?= $produkJson ?>;
    const produkMap  = {};
    produkData.forEach(p => produkMap[p.id] = p);

    let rowCounter = 1; // ID unik untuk row baru

    // CLOCK
    function tick() {
        document.getElementById('liveClock').textContent =
            new Date().toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit', second:'2-digit' });
    }
    tick(); setInterval(tick, 1000);

    // SIDEBAR
    function openSidebar()  { document.getElementById('sidebar').classList.add('open');    document.getElementById('sOverlay').classList.add('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sOverlay').classList.remove('show'); }
    window.addEventListener('resize', () => {
        document.querySelector('.menu-toggle').style.display = window.innerWidth <= 900 ? 'block' : 'none';
    });
    window.dispatchEvent(new Event('resize'));

    // ── Isi harga + update info stok ──
    function isiHarga(selectEl) {
        const selected = selectEl.options[selectEl.selectedIndex];
        const produkId = parseInt(selected.value);
        const row      = selectEl.closest('.item-row');
        const rowId    = row.id.replace('row-', '');

        if (!produkId) {
            row.querySelector('.harga-input').value = '';
            updateStokBadge(rowId, null);
            return;
        }

        const produk = produkMap[produkId];
        row.querySelector('.harga-input').value = produk.harga;

        // Set batas maksimum qty sesuai stok
        const qtyInput = row.querySelector('.qty-input');
        qtyInput.max   = produk.stok;

        updateStokBadge(rowId, produk.stok);
        validasiQty(qtyInput);
        hitungTotal();
    }

    function updateStokBadge(rowId, stok) {
        const badge = document.getElementById('stok-info-' + rowId);
        if (!badge) return;
        if (stok === null) {
            badge.textContent = 'Pilih produk dahulu';
            badge.className   = 'stok-badge';
        } else if (stok === 0) {
            badge.textContent = '⚠️ Stok habis!';
            badge.className   = 'stok-badge empty';
        } else if (stok <= 5) {
            badge.textContent = `Stok tersisa: ${stok} unit (menipis)`;
            badge.className   = 'stok-badge low';
        } else {
            badge.textContent = `Stok tersedia: ${stok} unit`;
            badge.className   = 'stok-badge';
        }
    }

    // ── Validasi qty ──
    function validasiQty(qtyInput) {
        const row      = qtyInput.closest('.item-row');
        const rowId    = row.id.replace('row-', '');
        const select   = row.querySelector('.produk-select');
        const produkId = parseInt(select.value);
        const qty      = parseInt(qtyInput.value) || 0;
        const errEl    = document.getElementById('qty-err-' + rowId);
        const errMsg   = errEl ? errEl.querySelector('.qty-err-msg') : null;

        if (!produkId) return; // belum pilih produk, skip

        const produk = produkMap[produkId];
        const stok   = produk ? produk.stok : 0;

        // Reset dulu
        qtyInput.classList.remove('is-error');
        if (errEl) errEl.classList.remove('show');

        if (stok === 0) {
            qtyInput.classList.add('is-error');
            if (errEl && errMsg) {
                errMsg.textContent = 'Stok produk ini habis, tidak dapat memesan.';
                errEl.classList.add('show');
            }
        } else if (qty > stok) {
            qtyInput.classList.add('is-error');
            if (errEl && errMsg) {
                errMsg.textContent = `Melebihi stok! Maksimal ${stok} unit.`;
                errEl.classList.add('show');
            }
        } else if (qty < 1) {
            qtyInput.classList.add('is-error');
            if (errEl && errMsg) {
                errMsg.textContent = 'Qty minimal 1.';
                errEl.classList.add('show');
            }
        }

        cekTombolSimpan();
        hitungTotal();
    }

    // ── Cek apakah ada error sebelum submit ──
    function cekTombolSimpan() {
        const adaError = document.querySelectorAll('.qty-err.show').length > 0;
        document.getElementById('btnSimpan').disabled = adaError;
    }

    // ── Validasi form saat submit ──
    function validasiForm() {
        const rows = document.querySelectorAll('#itemsContainer .item-row');
        let valid  = true;

        rows.forEach(row => {
            const select   = row.querySelector('.produk-select');
            const produkId = parseInt(select.value);
            const qtyInput = row.querySelector('.qty-input');
            const qty      = parseInt(qtyInput.value) || 0;

            if (!produkId) return; // akan ditolak oleh `required` browser

            const produk = produkMap[produkId];
            if (!produk) return;

            if (produk.stok === 0 || qty > produk.stok || qty < 1) {
                valid = false;
                validasiQty(qtyInput); // tampilkan error
            }
        });

        if (!valid) {
            alert('Ada item dengan qty melebihi stok atau stok habis. Silakan perbaiki sebelum menyimpan.');
        }
        return valid;
    }

    // ── Tambah item row baru ──
    function tambahItem() {
        const container = document.getElementById('itemsContainer');
        const id        = rowCounter++;

        let opts = '<option value="">— Pilih Produk —</option>';
        produkData.forEach(p => {
            opts += `<option value="${p.id}" data-harga="${p.harga}" data-stok="${p.stok}">${p.nama}</option>`;
        });

        // Row
        const rowDiv = document.createElement('div');
        rowDiv.className = 'item-row';
        rowDiv.id = 'row-' + id;
        rowDiv.innerHTML = `
            <select name="id_produk[]" class="form-control produk-select" onchange="isiHarga(this)" required>
                ${opts}
            </select>
            <input type="number" name="qty[]" class="form-control qty-input"
                   placeholder="1" min="1" value="1"
                   oninput="validasiQty(this); hitungTotal()" required>
            <input type="number" name="harga[]" class="form-control harga-input harga-col"
                   placeholder="0" readonly
                   style="background:var(--bg);color:var(--muted);cursor:not-allowed;">
            <button type="button" class="del-btn" onclick="hapusItem(this)" title="Hapus">
                <i class="fas fa-times"></i>
            </button>`;

        // Meta (stok info + error)
        const metaDiv = document.createElement('div');
        metaDiv.className = 'item-meta';
        metaDiv.id = 'meta-' + id;
        metaDiv.innerHTML = `
            <span class="stok-badge" id="stok-info-${id}">Pilih produk dahulu</span>
            <span class="qty-err" id="qty-err-${id}"><i class="fas fa-exclamation-triangle"></i> <span class="qty-err-msg"></span></span>`;

        container.appendChild(rowDiv);
        container.appendChild(metaDiv);
        hitungTotal();
    }

    // ── Hapus item row ──
    function hapusItem(btn) {
        const rows = document.querySelectorAll('#itemsContainer .item-row');
        if (rows.length <= 1) return; // minimal 1 item

        const row   = btn.closest('.item-row');
        const rowId = row.id.replace('row-', '');
        const meta  = document.getElementById('meta-' + rowId);

        row.remove();
        if (meta) meta.remove();

        cekTombolSimpan();
        hitungTotal();
    }

    // ── Hitung total ──
    function hitungTotal() {
        const rows = document.querySelectorAll('#itemsContainer .item-row');
        let total = 0, totalQty = 0;

        rows.forEach(r => {
            const qty   = parseInt(r.querySelector('.qty-input').value)     || 0;
            const harga = parseFloat(r.querySelector('.harga-input').value) || 0;
            total    += qty * harga;
            totalQty += qty;
        });

        document.getElementById('sumItems').textContent  = rows.length;
        document.getElementById('sumQty').textContent    = totalQty;
        document.getElementById('sumTotal').textContent  = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('totalInput').value      = total;
    }

    hitungTotal();
</script>
</body>
</html>