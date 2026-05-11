<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — MomoPetshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blue: #4A90E2; --blue-dark: #2563c4;
            --orange: #FFA726; --orange-dark: #cc7a00;
            --red: #ef4444; --red-dim: #fef2f2;
            --green: #22c55e; --green-dim: #f0fdf4;
            --surface: #ffffff; --border: #eaecf2;
            --text: #1a1f36; --muted: #8b93a7;
            --radius: 14px; --radius-sm: 9px;
            --shadow: 0 8px 32px rgba(74,144,226,0.12), 0 1px 4px rgba(0,0,0,0.06);
        }
        html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; }
        body {
            display: flex; align-items: center; justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #ddeeff 0%, #fff4e5 100%);
        }
        .auth-wrap { width: 100%; max-width: 420px; padding: 16px; }

        /* LOGO */
        .auth-logo { text-align: center; margin-bottom: 28px; }
        .auth-logo-svg { width: 72px; height: 72px; margin-bottom: 10px; }
        .auth-logo-text { font-size: 24px; font-weight: 800; color: var(--text); letter-spacing: -.5px; }
        .auth-logo-sub  { font-size: 13px; color: var(--muted); font-weight: 500; margin-top: 2px; }

        /* CARD */
        .auth-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); padding: 36px 32px; }
        .auth-card-title { font-size: 19px; font-weight: 800; color: var(--text); margin-bottom: 4px; }
        .auth-card-sub   { font-size: 13px; color: var(--muted); margin-bottom: 24px; }

        /* ALERTS */
        .alert { padding: 11px 14px; border-radius: var(--radius-sm); margin-bottom: 18px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: var(--green-dim); color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error   { background: var(--red-dim); color: #b91c1c; border: 1px solid #fecaca; }

        /* FORM */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 700; color: var(--text); margin-bottom: 6px; letter-spacing: .3px; text-transform: uppercase; }
        .input-wrap { position: relative; }
        .input-wrap i.prefix { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 13px; pointer-events: none; }
        .form-control { width: 100%; padding: 11px 12px 11px 38px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 14px; color: var(--text); background: #fafbfd; outline: none; transition: border .15s, box-shadow .15s; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(74,144,226,0.12); background: #fff; }
        .form-control.is-invalid { border-color: var(--red); }
        .invalid-feedback { font-size: 11.5px; color: var(--red); margin-top: 5px; font-weight: 600; display: flex; align-items: center; gap: 4px; }
        .toggle-pw { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); font-size: 13px; padding: 2px; }
        .toggle-pw:hover { color: var(--text); }

        /* SUBMIT */
        .btn-submit { width: 100%; padding: 12px; background: linear-gradient(135deg, var(--orange) 0%, #ff8f00 100%); color: #fff; border: none; border-radius: var(--radius-sm); font-family: inherit; font-size: 14px; font-weight: 800; cursor: pointer; transition: all .18s; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 10px; box-shadow: 0 4px 14px rgba(255,167,38,0.3); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255,167,38,0.42); }
        .btn-submit:active { transform: none; }

        /* FOOTER */
        .auth-footer { text-align: center; margin-top: 22px; font-size: 13px; color: var(--muted); }
        .auth-footer a { color: var(--blue); font-weight: 700; text-decoration: none; }
        .auth-footer a:hover { color: var(--blue-dark); text-decoration: underline; }
    </style>
</head>
<body>
<div class="auth-wrap">

    <div class="auth-logo">
          <div class="sidebar-logo">
        <div class="logo-mark" style="background:none; padding:0;">
            <img src="/img/logo.png" alt="MomoPetshop Logo" 
                 style="width:90px;height:90px;object-fit:contain;">
        </div>
        <div class="auth-logo-text">MomoPetshop</div>
        <div class="auth-logo-sub">Admin Panel</div>
    </div>

    <div class="auth-card">
        <div class="auth-card-title">Selamat datang! 👋</div>
        <div class="auth-card-sub">Masukkan akun kamu untuk melanjutkan</div>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= esc($error) ?></div>
        <?php endif; ?>

        <form action="/login" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label">Username</label>
                <div class="input-wrap">
                    <i class="fas fa-user prefix"></i>
                    <input type="text" id="username" name="username"
                        class="form-control <?= ($validation && $validation->hasError('username')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan username"
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
                        placeholder="Masukkan password"
                        autocomplete="current-password">
                    <button type="button" class="toggle-pw" onclick="togglePw()">
                        <i class="fas fa-eye" id="pwIcon"></i>
                    </button>
                </div>
                <?php if ($validation && $validation->hasError('password')): ?>
                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> <?= $validation->getError('password') ?></div>
                <?php endif; ?>
            </div>

            <button type="submit"  id="loginButton" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
        </form>
    </div>

    <div class="auth-footer">
        Belum punya akun? <a href="/register">Daftar sekarang</a>
    </div>
</div>

<script>
function togglePw() {
    const input = document.getElementById('pwInput');
    const icon  = document.getElementById('pwIcon');
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