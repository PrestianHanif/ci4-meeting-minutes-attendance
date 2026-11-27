<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Kowpi.id</title>
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-kowpi.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        :root {
            --brand-500: #8c4835;
            --brand-600: #723a2a;
            --brand-700: #582a1d;
            --brand-800: #452117;
            --brand-900: #341916;
            --brand-950: #1e0e0c;
            --gold: #d4a847;
            --gold-light: #f0c96b;
            --dark-bg: #0d0a09;
            --dark-card: #1a1210;
            --dark-border: #2d1f1a;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--dark-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }
        /* Background effects */
        .bg-glow {
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 50% 30%, rgba(140, 72, 53, 0.15) 0%, transparent 70%),
                radial-gradient(ellipse 40% 40% at 80% 80%, rgba(212, 168, 71, 0.08) 0%, transparent 60%);
            pointer-events: none;
        }
        .bg-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(140, 72, 53, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(140, 72, 53, 0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
            pointer-events: none;
        }

        /* Login container */
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
        }

        /* Logo area */
        .login-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 28px;
        }
        .login-logo img {
            height: 48px;
            width: auto;
            margin-bottom: 12px;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.5));
        }
        .login-logo-sub {
            font-size: 0.76rem;
            color: var(--gold-light);
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            background: rgba(212, 168, 71, 0.12);
            border: 1px solid rgba(212, 168, 71, 0.28);
            padding: 5px 16px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Card */
        .login-card {
            background: rgba(30, 20, 17, 0.92);
            border: 1px solid rgba(212, 168, 71, 0.2);
            border-radius: 28px;
            padding: 44px 40px;
            backdrop-filter: blur(24px);
            box-shadow:
                0 30px 70px rgba(0, 0, 0, 0.6),
                0 0 40px rgba(140, 72, 53, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
            animation: cardIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
            letter-spacing: -0.3px;
            text-align: center;
        }
        .login-subtitle {
            font-size: 0.95rem;
            color: #d6c6bf;
            line-height: 1.5;
            text-align: center;
        }

        /* Alert */
        .alert-error {
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.35);
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.88rem;
            color: #fecaca;
            animation: shake 0.4s ease;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            75% { transform: translateX(6px); }
        }

        /* Form */
        .form-group { margin-bottom: 22px; }
        .form-label {
            display: block;
            font-size: 0.86rem;
            font-weight: 700;
            color: #f0e6e2;
            margin-bottom: 8px;
            letter-spacing: 0.2px;
        }
        .input-wrap {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            pointer-events: none;
            transition: color 0.3s;
            opacity: 0.9;
        }
        .form-input {
            width: 100%;
            padding: 15px 18px 15px 48px;
            background: rgba(18, 11, 9, 0.75);
            border: 1.5px solid rgba(212, 168, 71, 0.32);
            border-radius: 14px;
            color: #ffffff;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 500;
            outline: none;
            transition: all 0.3s;
        }
        .form-input::placeholder {
            color: #b5a59e;
            font-weight: 400;
        }
        .form-input:focus {
            border-color: var(--gold-light);
            background: rgba(22, 13, 11, 0.95);
            box-shadow: 0 0 0 4px rgba(212, 168, 71, 0.2);
        }
        .form-input:focus + .input-icon,
        .form-input:focus ~ .input-icon {
            color: var(--gold-light);
            opacity: 1;
        }

        /* Password toggle */
        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #d6c6bf;
            cursor: pointer;
            padding: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        .toggle-pw:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.12);
        }

        /* Submit */
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #b85438, #7a3522);
            color: #ffffff;
            font-family: inherit;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 24px rgba(184, 84, 56, 0.45);
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #cb5f40, #8c3e29);
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(184, 84, 56, 0.6);
        }
        .btn-login:active {
            transform: translateY(0);
        }

        /* Footer note */
        .login-footer {
            text-align: center;
            margin-top: 26px;
            font-size: 0.84rem;
            color: #b5a59e;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 500;
        }
        .login-footer i {
            color: var(--gold);
        }

        @media (max-width: 480px) {
            .login-card { padding: 32px 22px; border-radius: 22px; }
            .login-title { font-size: 1.6rem; }
            .login-subtitle { font-size: 0.88rem; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>
    <div class="bg-grid"></div>

    <div class="login-container">
        <div class="login-logo">
            <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="Kowpi.id">
            <div class="login-logo-sub">
                <i data-lucide="shield-check" style="width:13px;height:13px;"></i>
                <span>Admin Panel</span>
            </div>
        </div>

        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">Selamat Datang</h1>
                <p class="login-subtitle">Masuk ke dashboard admin Anda</p>
            </div>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert-error">
                    <i data-lucide="alert-circle" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/loginSubmit') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-wrap">
                        <input type="text" name="username" class="form-input" required placeholder="Masukkan username" value="<?= old('username') ?>">
                        <div class="input-icon">
                            <i data-lucide="user" style="width:18px;height:18px;"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="passwordField" class="form-input" required placeholder="Masukkan password">
                        <div class="input-icon">
                            <i data-lucide="lock" style="width:18px;height:18px;"></i>
                        </div>
                        <button type="button" class="toggle-pw" onclick="togglePassword()">
                            <i data-lucide="eye" id="eyeIcon" style="width:18px;height:18px;"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i data-lucide="log-in" style="width:20px;height:20px;"></i>
                    Masuk
                </button>
            </form>

            <div class="login-footer">
                <i data-lucide="shield-check" style="width:12px;height:12px;"></i>
                Akses terbatas hanya untuk administrator
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        function togglePassword() {
            const pw = document.getElementById('passwordField');
            const icon = document.getElementById('eyeIcon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                pw.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>
