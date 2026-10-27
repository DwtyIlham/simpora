<?php
$flashError   = session()->getFlashdata('error');
$flashSuccess = session()->getFlashdata('success');
$flashWelcome = session()->getFlashdata('welcome');
?>
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SILAGAPORA Banjarnegara</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/assets/images/icon.png'); ?>" sizes="16x16">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/lib/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/remixicon.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/style.css'); ?>?v=3">
    <script src="<?= base_url('public/assets/js/lib/iconify-icon.min.js'); ?>"></script>
    <style>
        body { min-height: 100vh; background: #f8fafc; }

        .auth-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(320px, 1.05fr) minmax(360px, 0.95fr);
        }

        .auth-visual {
            position: relative;
            overflow: hidden;
            background: #0f172a;
        }

        .auth-visual img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.78;
        }

        .auth-visual__overlay {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            gap: 16px;
            padding: 48px;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.12) 0%, rgba(15, 23, 42, 0.82) 100%);
            color: #ffffff;
        }

        .auth-visual__brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .auth-visual__brand img {
            width: 56px;
            height: 56px;
            object-fit: contain;
            opacity: 1;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.12);
            padding: 8px;
        }

        .auth-visual__brand h1 {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            margin: 0;
        }

        .auth-visual__overlay p {
            max-width: 420px;
            font-size: 1rem;
            line-height: 1.6;
            margin: 0;
            opacity: 0.92;
        }

        .auth-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 32px;
            background: #ffffff;
        }

        .auth-box {
            width: 100%;
            max-width: 420px;
        }

        .auth-box h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .auth-box .subtitle {
            color: #64748b;
            margin-bottom: 24px;
        }

        .auth-box .form-control {
            height: 54px;
            border-radius: 12px;
            background: #f8fafc;
        }

        .auth-box .btn-submit {
            height: 54px;
            border-radius: 12px;
            font-weight: 700;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
            z-index: 5;
        }

        @media (max-width: 991.98px) {
            .auth-layout {
                grid-template-columns: 1fr;
            }

            .auth-visual {
                min-height: 220px;
            }

            .auth-visual__overlay {
                padding: 24px;
            }

            .auth-panel {
                padding: 32px 20px;
            }
        }
    </style>
</head>
<body>
    <main class="auth-layout">
        <section class="auth-visual">
            <img src="<?= base_url('public/assets/images/bg-login.jpg'); ?>" alt="SILAGAPORA">
            <div class="auth-visual__overlay">
                <div class="auth-visual__brand">
                    <img src="<?= base_url('public/assets/images/logo.jpeg'); ?>" alt="Logo SILAGAPORA">
                    <h1>SILAGAPORA</h1>
                </div>
                <p>Sistem Informasi Lomba dan Agenda Kepemudaan Olahraga Kabupaten Banjarnegara.</p>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-box">
                <h2>Masuk</h2>
                <p class="subtitle">Silakan masukkan username dan password Anda.</p>

                <?php if ($flashError): ?>
                    <div class="alert alert-danger mb-3" role="alert">
                        <i class="ri-error-warning-line me-1"></i> <?= esc($flashError); ?>
                    </div>
                <?php endif; ?>

                <?php if ($flashSuccess): ?>
                    <div class="alert alert-success mb-3" role="alert">
                        <i class="ri-checkbox-circle-line me-1"></i> <?= esc($flashSuccess); ?>
                    </div>
                <?php endif; ?>

                <?php if ($flashWelcome): ?>
                    <div class="alert alert-info mb-3" role="alert">
                        <i class="ri-information-line me-1"></i> <?= esc($flashWelcome); ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('auth/login'); ?>" method="post" id="loginForm" novalidate>
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <div class="icon-field">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="mage:user"></iconify-icon>
                            </span>
                            <input type="text"
                                   name="username"
                                   id="username"
                                   class="form-control"
                                   placeholder="Masukkan username"
                                   value="<?= esc(old('username') ?? ''); ?>"
                                   autocomplete="username"
                                   required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="position-relative">
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y">
                                    <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                </span>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control"
                                       placeholder="Masukkan password"
                                       autocomplete="current-password"
                                       required>
                            </div>
                            <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                  data-toggle="#password"
                                  aria-label="Tampilkan password"></span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-submit w-100" id="loginButton">
                        <span class="login-button__text">Masuk</span>
                        <span class="login-button__spinner d-none">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Memproses...
                        </span>
                    </button>

                    <div class="mt-4 text-center text-sm">
                        <p class="mb-0 text-secondary-light">
                            Belum punya akun?
                            <a href="<?= site_url('register'); ?>" class="text-primary-600 fw-semibold">Daftar di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script src="<?= base_url('public/assets/js/lib/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('public/assets/js/lib/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('public/assets/js/lib/iconify-icon.min.js'); ?>"></script>
    <script>
        (function () {
            const form = document.getElementById('loginForm');
            const button = document.getElementById('loginButton');
            const text = button.querySelector('.login-button__text');
            const spinner = button.querySelector('.login-button__spinner');

            document.querySelectorAll('.toggle-password').forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    const input = document.querySelector(this.getAttribute('data-toggle'));
                    if (!input) return;
                    this.classList.toggle('ri-eye-off-line');
                    input.type = input.type === 'password' ? 'text' : 'password';
                });
            });

            form.addEventListener('submit', function () {
                button.disabled = true;
                text.classList.add('d-none');
                spinner.classList.remove('d-none');
            });
        })();
    </script>
</body>
</html>
