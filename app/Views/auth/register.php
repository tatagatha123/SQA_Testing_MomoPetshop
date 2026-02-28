<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun — MomoPetshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blue: #4A90E2; --blue-dark: #2563c4;
            --orange: #FFA726;
            --red: #ef4444; --red-dim: #fef2f2;
            --green: #22c55e; --green-dim: #f0fdf4;
            --surface: #ffffff; --border: #eaecf2;
            --text: #1a1f36; --muted: #8b93a7;
            --radius: 14px; --radius-sm: 9px;
            --shadow: 0 8px 32px rgba(74,144,226,0.12), 0 1px 4px rgba(0,0,0,0.06);
        }
        html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; }
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background: linear-gradient(135deg, #ddeeff 0%, #fff4e5 100%); }
        .auth-wrap { width: 100%; max-width: 420px; padding: 16px; }
        .auth-logo { text-align: center; margin-bottom: 28px; }
        .auth-logo-svg { width: 72px; height: 72px; margin-bottom: 10px; }
        .auth-logo-text { font-size: 24px; font-weight: 800; color: var(--text); letter-spacing: -.5px; }
        .auth-logo-sub  { font-size: 13px; color: var(--muted); font-weight: 500; margin-top: 2px; }
        .auth-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); padding: 36px 32px; }
        .auth-card-title { font-size: 19px; font-weight: 800; color: var(--text); margin-bottom: 4px; }
        .auth-card-sub   { font-size: 13px; color: var(--muted); margin-bottom: 24px; }
        .alert { padding: 11px 14px; border-radius: var(--radius-sm); margin-bottom: 18px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: var(--green-dim); color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error   { background: var(--red-dim); color: #b91c1c; border: 1px solid #fecaca; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 700; color: var(--text); margin-bottom: 6px; letter-spacing: .3px; text-transform: uppercase; }
        .input-wrap { position: relative; }
        .input-wrap i.prefix { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 13px; pointer-events: none; }
        .form-control { width: 100%; padding: 11px 12px 11px 38px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 14px; color: var(--text); background: #fafbfd; outline: none; transition: border .15s, box-shadow .15s; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(74,144,226,0.12); background: #fff; }
        .form-control.is-invalid { border-color: var(--red); }
        .invalid-feedback { font-size: 11.5px; color: var(--red); margin-top: 5px; font-weight: 600; display: flex; align-items: center; gap: 4px; }
        .form-hint { font-size: 11px; color: var(--muted); margin-top: 4px; }
        .toggle-pw { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); font-size: 13px; }
        .toggle-pw:hover { color: var(--text); }
        .btn-submit { width: 100%; padding: 12px; background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%); color: #fff; border: none; border-radius: var(--radius-sm); font-family: inherit; font-size: 14px; font-weight: 800; cursor: pointer; transition: all .18s; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 10px; box-shadow: 0 4px 14px rgba(74,144,226,0.3); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(74,144,226,0.4); }
        .btn-submit:active { transform: none; }
        .auth-footer { text-align: center; margin-top: 22px; font-size: 13px; color: var(--muted); }
        .auth-footer a { color: var(--blue); font-weight: 700; text-decoration: none; }
        .auth-footer a:hover { color: var(--blue-dark); text-decoration: underline; }
    </style>
</head>
<body>
<div class="auth-wrap">

    <div class="auth-logo">
        <svg class="auth-logo-svg" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="8" y="22" width="40" height="12" rx="4" fill="#4A90E2"/>
            <rect x="22" y="8" width="12" height="40" rx="4" fill="#4A90E2"/>
            <g transform="translate(28, 14)">
                <polygon points="6,0 2,10 10,10" fill="#FFA726"/>
                <polygon points="22,0 18,10 26,10" fill="#FFA726"/>
                <ellipse cx="16" cy="16" rx="12" ry="11" fill="#FFA726"/>
                <ellipse cx="16" cy="36" rx="10" ry="13" fill="#FFA726"/>
                <path d="M26 44 Q38 38 36 28 Q34 22 30 24" stroke="#FFA726" stroke-width="3.5" fill="none" stroke-linecap="round"/>
                <ellipse cx="11" cy="15" rx="2" ry="2.5" fill="#1a1f36"/>
                <ellipse cx="21" cy="15" rx="2" ry="2.5" fill="#1a1f36"/>
                <ellipse cx="16" cy="20" rx="1.5" ry="1" fill="#ff8f00"/>
            </g>
        </svg>
        <div class="auth-logo-text">MomoPetshop</div>
        <div class="auth-logo-sub">Admin Panel</div>
    </div>

    <div class="auth-card">
        <div class="auth-card-title">Buat Akun Baru ✨</div>
        <div class="auth-card-sub">Isi data di bawah untuk mendaftar</div>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="/register" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label">Username</label>
                <div class="input-wrap">
                    <i class="fas fa-user prefix"></i>
                    <input type="text" name="username"
                        class="form-control <?= ($validation && $validation->hasError('username')) ? 'is-invalid' : '' ?>"
                        placeholder="Minimal 3 karakter"
                        value="<?= old('username') ?>"
                        autocomplete="username">
                </div>
                <?php if ($validation && $validation->hasError('username')): ?>
                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> <?= $validation->getError('username') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock prefix"></i>
                    <input type="password" name="password" id="pwInput"
                        class="form-control <?= ($validation && $validation->hasError('password')) ? 'is-invalid' : '' ?>"
                        placeholder="Minimal 6 karakter"
                        autocomplete="new-password">
                    <button type="button" class="toggle-pw" onclick="togglePw('pwInput','pwIcon')">
                        <i class="fas fa-eye" id="pwIcon"></i>
                    </button>
                </div>
                <?php if ($validation && $validation->hasError('password')): ?>
                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> <?= $validation->getError('password') ?></div>
                <?php endif; ?>
                <div class="form-hint">Minimal 6 karakter</div>
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock prefix"></i>
                    <input type="password" name="konfirmasi_password" id="pw2Input"
                        class="form-control <?= ($validation && $validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>"
                        placeholder="Ulangi password"
                        autocomplete="new-password">
                    <button type="button" class="toggle-pw" onclick="togglePw('pw2Input','pw2Icon')">
                        <i class="fas fa-eye" id="pw2Icon"></i>
                    </button>
                </div>
                <?php if ($validation && $validation->hasError('konfirmasi_password')): ?>
                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> <?= $validation->getError('konfirmasi_password') ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-user-plus"></i> Buat Akun
            </button>
        </form>
    </div>

    <div class="auth-footer">
        Sudah punya akun? <a href="/login">Login di sini</a>
    </div>
</div>

<script>
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>