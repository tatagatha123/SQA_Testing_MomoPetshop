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
        .content { padding: 24px 26px; flex: 1; }

        /* FORM CARD */
        .form-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); max-width: 540px; }
        .form-card-head { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 10px; }
        .form-card-head i { color: var(--blue); font-size: 15px; }
        .form-card-head span { font-size: 14px; font-weight: 700; }
        .form-body { padding: 24px; display: flex; flex-direction: column; gap: 18px; }
        .form-foot { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 8px; }

        /* FORM FIELDS */
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-label { font-size: 12px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 5px; }
        .form-label .req { color: var(--red); }
        .form-hint { font-size: 11px; color: var(--muted); }
        .form-control { width: 100%; padding: 10px 13px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; color: var(--text); background: var(--surface); outline: none; transition: border .15s, box-shadow .15s; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(74,144,226,0.1); }
        .form-control.is-invalid { border-color: var(--red); box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
        .invalid-feedback { font-size: 11.5px; color: var(--red); font-weight: 600; }
        .input-wrap { position: relative; }
        .input-wrap .toggle-pw { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); font-size: 13px; }
        .input-wrap .toggle-pw:hover { color: var(--text); }

        /* BTNS */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; text-decoration: none; }
        .btn-blue { background: var(--blue); color: #fff; }
        .btn-blue:hover { background: var(--blue-dark); }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-dark); }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }

        /* AVATAR PREVIEW */
        .avatar-preview { width: 60px; height: 60px; border-radius: 50%; background: var(--blue-dim); display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--blue); font-size: 22px; margin-bottom: 4px; }

        /* SIDEBAR OVERLAY */
        .s-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.25); z-index: 99; }
        .s-overlay.show { display: block; }

        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: none; } .main { margin-left: 0; } .menu-toggle { display: block !important; } }
        @media (max-width: 600px) { .content { padding: 16px; } .topbar { padding: 0 16px; } .topbar-time { display: none; } }
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
                <div class="page-title"><?= esc($title) ?></div>
                <div class="breadcrumb">MomoPetshop › <a href="/user" style="color:var(--blue);text-decoration:none">User</a> › <?= $user ? 'Edit' : 'Tambah' ?></div>
            </div>
        </div>
    </header>

    <div class="content">

        <div class="form-card">
            <div class="form-card-head">
                <i class="fas fa-<?= $user ? 'user-edit' : 'user-plus' ?>"></i>
                <span><?= $user ? 'Edit User' : 'Tambah User Baru' ?></span>
            </div>

            <form action="<?= $user ? '/user/update/' . $user['id_user'] : '/user/store' ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-body">

                    <!-- Avatar Preview -->
                    <div style="display:flex;flex-direction:column;align-items:center;gap:4px;padding:10px 0;">
                        <div class="avatar-preview" id="avatarPreview">
                            <?= $user ? strtoupper(substr($user['username'], 0, 1)) : '?' ?>
                        </div>
                        <div style="font-size:11px;color:var(--muted)">Inisial Username</div>
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-at" style="color:var(--blue)"></i>
                            Username <span class="req">*</span>
                        </label>
                        <input
                            type="text"
                            name="username"
                            class="form-control <?= ($validation && $validation->hasError('username')) ? 'is-invalid' : '' ?>"
                            placeholder="Masukkan username..."
                            value="<?= old('username', $user['username'] ?? '') ?>"
                            oninput="updateAvatar(this.value)"
                            required
                        >
                        <?php if ($validation && $validation->hasError('username')): ?>
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> <?= $validation->getError('username') ?></div>
                        <?php endif; ?>
                        <div class="form-hint">Minimal 3 karakter, harus unik.</div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock" style="color:var(--blue)"></i>
                            Password <?php if (!$user): ?><span class="req">*</span><?php endif; ?>
                        </label>
                        <div class="input-wrap">
                            <input
                                type="password"
                                name="password"
                                id="inputPassword"
                                class="form-control <?= ($validation && $validation->hasError('password')) ? 'is-invalid' : '' ?>"
                                placeholder="<?= $user ? 'Kosongkan jika tidak ingin ganti password' : 'Masukkan password...' ?>"
                                <?= !$user ? 'required' : '' ?>
                            >
                            <button type="button" class="toggle-pw" onclick="togglePw('inputPassword', this)"><i class="fas fa-eye"></i></button>
                        </div>
                        <?php if ($validation && $validation->hasError('password')): ?>
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> <?= $validation->getError('password') ?></div>
                        <?php endif; ?>
                        <div class="form-hint">Minimal 6 karakter.</div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock" style="color:var(--blue)"></i>
                            Konfirmasi Password <?php if (!$user): ?><span class="req">*</span><?php endif; ?>
                        </label>
                        <div class="input-wrap">
                            <input
                                type="password"
                                name="konfirmasi_password"
                                id="inputKonfirmasi"
                                class="form-control <?= ($validation && $validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>"
                                placeholder="Ulangi password..."
                                <?= !$user ? 'required' : '' ?>
                            >
                            <button type="button" class="toggle-pw" onclick="togglePw('inputKonfirmasi', this)"><i class="fas fa-eye"></i></button>
                        </div>
                        <?php if ($validation && $validation->hasError('konfirmasi_password')): ?>
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> <?= $validation->getError('konfirmasi_password') ?></div>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="form-foot">
                    <a href="/user" class="btn btn-ghost"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-orange">
                        <i class="fas fa-<?= $user ? 'save' : 'plus' ?>"></i>
                        <?= $user ? 'Simpan Perubahan' : 'Tambah User' ?>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
   

    // SIDEBAR
    function openSidebar() { document.getElementById('sidebar').classList.add('open'); document.getElementById('sOverlay').classList.add('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sOverlay').classList.remove('show'); }
    window.addEventListener('resize', () => { document.querySelector('.menu-toggle').style.display = window.innerWidth <= 900 ? 'block' : 'none'; });
    window.dispatchEvent(new Event('resize'));

    // AVATAR PREVIEW
    function updateAvatar(val) {
        const av = document.getElementById('avatarPreview');
        av.textContent = val ? val.charAt(0).toUpperCase() : '?';
    }

    // TOGGLE PASSWORD
    function togglePw(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }
</script>
</body>
</html>
