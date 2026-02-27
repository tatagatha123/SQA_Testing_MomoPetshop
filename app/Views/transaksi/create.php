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
        .back-link { display: inline-flex; align-items: center; gap: 7px; color: var(--muted); font-size: 13px; font-weight: 600; text-decoration: none; margin-bottom: 18px; transition: color .15s; }
        .back-link:hover { color: var(--blue); }

        /* ── FORM LAYOUT ── */
        .form-layout { display: grid; grid-template-columns: 1fr 360px; gap: 20px; align-items: start; }

        /* ── FORM CARD ── */
        .form-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); }
        .form-card-head { padding: 18px 22px; border-bottom: 1px solid var(--border); }
        .form-card-title { font-size: 14px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 9px; }
        .form-card-title i { color: var(--orange); }
        .form-card-sub { font-size: 12px; color: var(--muted); margin-top: 3px; }
        .form-card-body { padding: 22px; }
        .form-card-foot { padding: 14px 22px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 8px; background: var(--bg); border-radius: 0 0 var(--radius) var(--radius); }

        /* ── FORM ELEMENTS ── */
        .form-group { margin-bottom: 16px; }
        .form-group:last-child { margin-bottom: 0; }
        .form-label { display: block; font-size: 11px; font-weight: 700; color: var(--muted); margin-bottom: 6px; letter-spacing: .4px; text-transform: uppercase; }
        .form-label span { color: var(--orange-dark); }
        .form-control { width: 100%; padding: 10px 13px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 13.5px; color: var(--text); background: var(--surface); outline: none; transition: border .15s, box-shadow .15s; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(74,144,226,0.1); }
        .form-control[readonly] { background: var(--bg); color: var(--muted); cursor: not-allowed; }
        .input-prefix { position: relative; }
        .input-prefix span { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 13px; font-weight: 600; pointer-events: none; }
        .input-prefix .form-control { padding-left: 32px; }

        /* ── ITEM ROWS ── */
        .item-row { display: grid; grid-template-columns: 1fr 70px 110px 28px; gap: 8px; align-items: end; margin-bottom: 10px; }
        .item-row:first-child .form-label { display: block; }
        .add-item-btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: var(--radius-sm); font-family: inherit; font-size: 12.5px; font-weight: 600; cursor: pointer; border: 1.5px dashed var(--border); background: transparent; color: var(--muted); transition: all .15s; margin-top: 4px; }
        .add-item-btn:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-dim); }
        .del-btn { width: 28px; height: 38px; border-radius: var(--radius-sm); background: transparent; border: 1.5px solid var(--border); color: var(--muted); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .15s; font-size: 13px; flex-shrink: 0; }
        .del-btn:hover { background: var(--orange-dim); border-color: var(--orange); color: var(--orange-dark); }

        /* ── SUMMARY CARD ── */
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
        .btn-ghost { background: transparent; color: var(--muted); border: 1.5px solid var(--border); margin-top: 8px; }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }

        /* ── SIDEBAR OVERLAY ── */
        .s-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.25); z-index: 99; }
        .s-overlay.show { display: block; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: none; } .main { margin-left: 0; } .menu-toggle { display: block !important; } .form-layout { grid-template-columns: 1fr; } .summary-card { position: static; } }
        @media (max-width: 600px) { .content { padding: 16px; } .topbar { padding: 0 16px; } .topbar-time { display: none; } .item-row { grid-template-columns: 1fr 60px 28px; } }
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
                <div class="page-title"><?= esc($title) ?></div>
                <div class="breadcrumb">MomoPetshop › Transaksi › Baru</div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="topbar-time"><i class="fas fa-clock"></i><span id="liveClock">--:--:--</span></div>
        </div>
    </header>

    <div class="content">
        <a href="/transaksi" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Transaksi</a>

        <form action="/transaksi/simpan" method="post" id="formTrx">
            <?= csrf_field() ?>
            <div class="form-layout">

                <!-- ── FORM KIRI ── -->
                <div>
                    <!-- Info Transaksi -->
                    <div class="form-card" style="margin-bottom:16px;">
                        <div class="form-card-head">
                            <div class="form-card-title"><i class="fas fa-file-invoice"></i> Info Transaksi</div>
                            <div class="form-card-sub">Data dasar transaksi</div>
                        </div>
                        <div class="form-card-body">
                            <div class="form-group">
                                <label class="form-label">Kode Transaksi <span>*</span></label>
                                <input type="text" name="kode" id="kodeInput" class="form-control" placeholder="Contoh: TRX004" value="TRX<?= date('ymd') . rand(10,99) ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal <span>*</span></label>
                                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Item Produk -->
                    <div class="form-card">
                        <div class="form-card-head">
                            <div class="form-card-title"><i class="fas fa-box"></i> Item Produk</div>
                            <div class="form-card-sub">Tambah produk yang dibeli — nanti pilih dari dropdown saat model terhubung</div>
                        </div>
                        <div class="form-card-body">

                            <!-- Header label (hanya tampil sekali) -->
                            <div class="item-row" style="margin-bottom:4px;">
                                <div style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px">Nama Produk</div>
                                <div style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px">Qty</div>
                                <div style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px">Harga (Rp)</div>
                                <div></div>
                            </div>

                            <div id="itemsContainer">
                                <!-- Item pertama -->
                                <div class="item-row">
                                    <!-- 🔥 Nanti ganti <input> ini dengan <select> dari $daftar_produk -->
                                    <input type="text" name="produk[]" class="form-control" placeholder="Nama produk..." required>
                                    <input type="number" name="qty[]" class="form-control qty-input" placeholder="1" min="1" value="1" oninput="hitungTotal()" required>
                                    <input type="number" name="harga[]" class="form-control harga-input" placeholder="0" min="0" oninput="hitungTotal()" required>
                                    <button type="button" class="del-btn" onclick="hapusItem(this)" title="Hapus"><i class="fas fa-times"></i></button>
                                </div>
                            </div>

                            <button type="button" class="add-item-btn" onclick="tambahItem()">
                                <i class="fas fa-plus"></i> Tambah Item
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ── RINGKASAN KANAN ── -->
                <div>
                    <div class="summary-card">
                        <div class="summary-card-head">
                            <div class="summary-card-title"><i class="fas fa-calculator"></i> Ringkasan</div>
                        </div>
                        <div class="summary-card-body">
                            <div class="summary-row">
                                <span class="label">Tanggal</span>
                                <span class="val"><?= date('d M Y') ?></span>
                            </div>
                            <div class="summary-row">
                                <span class="label">Jumlah Item</span>
                                <span class="val" id="sumItems">1</span>
                            </div>
                            <div class="summary-row">
                                <span class="label">Total Qty</span>
                                <span class="val" id="sumQty">0</span>
                            </div>

                            <div class="summary-total">
                                <span class="t-label">Total Bayar</span>
                                <span class="t-val" id="sumTotal">Rp 0</span>
                            </div>

                            <!-- Total hidden field -->
                            <input type="hidden" name="total" id="totalInput" value="0">

                            <button type="submit" class="btn btn-orange" style="margin-top:16px">
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

    // ── TAMBAH ITEM ──
    function tambahItem() {
        const container = document.getElementById('itemsContainer');
        const div = document.createElement('div');
        div.className = 'item-row';
        div.innerHTML = `
            <input type="text" name="produk[]" class="form-control" placeholder="Nama produk..." required>
            <input type="number" name="qty[]" class="form-control qty-input" placeholder="1" min="1" value="1" oninput="hitungTotal()" required>
            <input type="number" name="harga[]" class="form-control harga-input" placeholder="0" min="0" oninput="hitungTotal()" required>
            <button type="button" class="del-btn" onclick="hapusItem(this)"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(div);
        hitungTotal();
    }

    // ── HAPUS ITEM ──
    function hapusItem(btn) {
        const rows = document.querySelectorAll('#itemsContainer .item-row');
        if (rows.length <= 1) return; // minimal 1 item
        btn.closest('.item-row').remove();
        hitungTotal();
    }

    // ── HITUNG TOTAL ──
    function hitungTotal() {
        const rows  = document.querySelectorAll('#itemsContainer .item-row');
        let total   = 0;
        let totalQty = 0;
        rows.forEach(r => {
            const qty   = parseInt(r.querySelector('.qty-input').value)   || 0;
            const harga = parseFloat(r.querySelector('.harga-input').value) || 0;
            total    += qty * harga;
            totalQty += qty;
        });
        document.getElementById('sumItems').textContent = rows.length;
        document.getElementById('sumQty').textContent   = totalQty;
        document.getElementById('sumTotal').textContent  = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('totalInput').value      = total;
    }

    hitungTotal();
</script>
</body>
</html>
