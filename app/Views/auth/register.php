<?php
$flashError   = session()->getFlashdata('error');
$flashSuccess = session()->getFlashdata('success');
$errors       = session()->getFlashdata('errors') ?? [];
?>
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - SILAGAPORA Banjarnegara</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/assets/images/icon.png'); ?>" sizes="16x16">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/lib/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/remixicon.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/select2-bootstrap-5-theme.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/style.css'); ?>?v=3">
    <script src="<?= base_url('public/assets/js/lib/iconify-icon.min.js'); ?>"></script>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 48%, #ecfdf5 100%);
        }

        .register-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(280px, 0.9fr) minmax(360px, 1.1fr);
        }

        .register-visual {
            position: relative;
            overflow: hidden;
            background: #0f172a;
            color: #ffffff;
            padding: 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .register-visual img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.34;
        }

        .register-visual__content {
            position: relative;
            z-index: 2;
        }

        .register-visual__brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .register-visual__brand img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.12);
            padding: 6px;
        }

        .register-visual h1 {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1.1;
            margin: 0 0 10px;
        }

        .register-visual p {
            font-size: 0.95rem;
            line-height: 1.6;
            opacity: 0.9;
            margin: 0;
            max-width: 360px;
        }

        .register-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .register-card {
            width: 100%;
            max-width: 520px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.1);
            padding: 24px;
        }

        .register-card h2 {
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .register-card .subtitle {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 16px;
        }

        .register-card .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .register-card .form-control,
        .register-card .form-select {
            min-height: 42px;
            border-radius: 10px;
            background: #f8fafc;
            font-size: 0.95rem;
        }

        .select2-container .select2-selection--single {
            min-height: 42px !important;
            border-radius: 10px !important;
            background: #f8fafc !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            line-height: 40px !important;
            font-size: 0.95rem;
        }

        .register-card .btn-submit {
            height: 44px;
            border-radius: 10px;
            font-weight: 700;
        }

        .register-card .invalid-feedback {
            display: block;
            font-size: 0.8rem;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
            z-index: 5;
        }

        @media (max-width: 991.98px) {
            .register-layout {
                grid-template-columns: 1fr;
            }

            .register-visual {
                min-height: 120px;
                padding: 16px;
            }

            .register-visual h1 {
                font-size: 1.3rem;
                margin-bottom: 4px;
            }

            .register-visual p {
                font-size: 0.82rem;
                margin-bottom: 0;
            }

            .register-visual__brand {
                margin-bottom: 10px;
            }

            .register-panel {
                padding: 16px 12px;
            }

            .register-card {
                padding: 16px;
            }

            .register-card .mb-2 {
                margin-bottom: 0.5rem !important;
            }

            .register-card .mb-3 {
                margin-bottom: 0.6rem !important;
            }
        }
    </style>
</head>
<body>
    <main class="register-layout">
        <section class="register-visual">
            <img src="<?= base_url('public/assets/images/bg-login.jpg'); ?>" alt="SILAGAPORA">
            <div class="register-visual__content">
                <div class="register-visual__brand">
                    <img src="<?= base_url('public/assets/images/logo.jpeg'); ?>" alt="Logo SILAGAPORA">
                    <div>
                        <div class="fw-bold">SILAGAPORA</div>
                        <div class="small opacity-75">Kabupaten Banjarnegara</div>
                    </div>
                </div>
                <h1>Buat Akun Operator Sekolah</h1>
                <p>Daftarkan sekolah Anda untuk mengelola data atlet, kompetisi, dan prestasi secara digital.</p>
            </div>
        </section>

        <section class="register-panel">
            <div class="register-card">
                <h2>Registrasi</h2>
                <p class="subtitle">Lengkapi data berikut untuk membuat akun baru.</p>

                <?php if ($flashError): ?>
                    <div class="alert alert-danger py-2 mb-3" role="alert">
                        <i class="ri-error-warning-line me-1"></i> <?= esc($flashError); ?>
                    </div>
                <?php endif; ?>

                <?php if ($flashSuccess): ?>
                    <div class="alert alert-success py-2 mb-3" role="alert">
                        <i class="ri-checkbox-circle-line me-1"></i> <?= esc($flashSuccess); ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('auth/register-attempt'); ?>" method="post" id="registerForm" novalidate>
                    <?= csrf_field(); ?>
                    <input type="hidden" name="role" value="2">

                    <div class="mb-2">
                        <label for="sekolah" class="form-label">Sekolah</label>
                        <select name="sekolah" id="sekolah" class="form-select select2" data-placeholder="Pilih Sekolah" required>
                            <option value=""></option>
                            <?php foreach ($sekolah as $s): ?>
                                <option value="<?= $s['id']; ?>" <?= (string) old('sekolah') === (string) $s['id'] ? 'selected' : ''; ?>>
                                    <?= esc($s['nama']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['sekolah'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['sekolah']); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y">
                                    <iconify-icon icon="mage:user"></iconify-icon>
                                </span>
                                <input type="text"
                                       name="nama"
                                       id="nama"
                                       class="form-control"
                                       placeholder="Nama lengkap"
                                       value="<?= esc(old('nama') ?? ''); ?>"
                                       autocomplete="name"
                                       required>
                            </div>
                            <?php if (isset($errors['nama'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['nama']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y">
                                    <iconify-icon icon="mage:user"></iconify-icon>
                                </span>
                                <input type="text"
                                       name="username"
                                       id="username"
                                       class="form-control"
                                       placeholder="Username"
                                       value="<?= esc(old('username') ?? ''); ?>"
                                       autocomplete="username"
                                       required>
                            </div>
                            <?php if (isset($errors['username'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['username']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="no_wa" class="form-label">Nomor WhatsApp</label>
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y">
                                    <iconify-icon icon="mage:whatsapp"></iconify-icon>
                                </span>
                                <input type="text"
                                       name="no_wa"
                                       id="no_wa"
                                       class="form-control"
                                       placeholder="08xxxxxxxxxx"
                                       value="<?= esc(old('no_wa') ?? ''); ?>"
                                       autocomplete="tel"
                                       required>
                            </div>
                            <?php if (isset($errors['no_wa'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['no_wa']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <div class="position-relative">
                                <div class="icon-field">
                                    <span class="icon top-50 translate-middle-y">
                                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                    </span>
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control"
                                           placeholder="Minimal 6 karakter"
                                           autocomplete="new-password"
                                           required>
                                </div>
                                <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-12 text-secondary-light"
                                      data-toggle="#password"
                                      aria-label="Tampilkan password"></span>
                            </div>
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['password']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-submit w-100" id="registerButton">
                        <span class="register-button__text">Daftar</span>
                        <span class="register-button__spinner d-none">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Memproses...
                        </span>
                    </button>

                    <div class="mt-3 text-center text-sm">
                        <p class="mb-0 text-secondary-light">
                            Sudah punya akun?
                            <a href="<?= site_url('/'); ?>" class="text-primary-600 fw-semibold">Masuk di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script src="<?= base_url('public/assets/js/lib/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('public/assets/js/lib/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('public/assets/js/select2.full.min.js'); ?>"></script>
    <script src="<?= base_url('public/assets/js/lib/iconify-icon.min.js'); ?>"></script>
    <script>
        (function () {
            const form = document.getElementById('registerForm');
            const button = document.getElementById('registerButton');
            const text = button.querySelector('.register-button__text');
            const spinner = button.querySelector('.register-button__spinner');

            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: function () {
                    return $(this).data('placeholder');
                },
                allowClear: true
            });

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
