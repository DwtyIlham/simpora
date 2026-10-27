<?php
$flashError   = session()->getFlashdata('error');
$flashSuccess = session()->getFlashdata('success');
$flashWelcome = session()->getFlashdata('welcome');
$openLoginModal = ! empty($flashError);
?>
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILAGAPORA - Pemerintah Kabupaten Banjarnegara</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/assets/images/icon.png'); ?>" sizes="16x16">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/lib/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/remixicon.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/style.css'); ?>?v=3">
    <script src="<?= base_url('public/assets/js/lib/iconify-icon.min.js'); ?>"></script>
    <style>
        :root {
            --landing-primary: #1d4ed8;
            --landing-secondary: #0f766e;
            --landing-accent: #f59e0b;
            --landing-dark: #0f172a;
            --landing-muted: #475569;
        }

        html, body {
            overflow-x: hidden;
        }

        body {
            background: #f8fafc;
            color: var(--landing-dark);
        }

        .landing-page {
            overflow-x: hidden;
        }

        .landing-nav {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: rgba(255, 255, 255, 0.86);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.9);
        }

        .landing-nav__brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .landing-nav__brand img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .landing-nav__brand strong {
            display: block;
            font-size: 1rem;
            line-height: 1.1;
            color: var(--landing-dark);
        }

        .landing-nav__brand span {
            display: block;
            font-size: 0.75rem;
            color: var(--landing-muted);
        }

        .landing-hero {
            position: relative;
            padding: 88px 0 72px;
            background:
                radial-gradient(circle at 15% 20%, rgba(29, 78, 216, 0.18), transparent 34%),
                radial-gradient(circle at 85% 10%, rgba(15, 118, 110, 0.16), transparent 30%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        }

        .landing-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.55), transparent 88%);
            pointer-events: none;
        }

        .landing-hero__content {
            position: relative;
            z-index: 2;
        }

        .landing-hero h1 {
            font-size: clamp(2.35rem, 5vw, 4.25rem);
            font-weight: 800;
            line-height: 1.02;
            letter-spacing: -0.03em;
            margin-bottom: 20px;
        }

        .landing-hero p {
            font-size: 1.08rem;
            line-height: 1.75;
            color: var(--landing-muted);
            max-width: 620px;
        }

        .landing-hero__panel {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 30px;
            padding: 34px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            backdrop-filter: blur(16px);
        }

        .landing-hero__panel img {
            width: 112px;
            height: 112px;
            object-fit: contain;
            margin-bottom: 18px;
        }

        .landing-hero__panel h3 {
            font-size: 1.35rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .landing-hero__panel p {
            color: var(--landing-muted);
            margin-bottom: 22px;
        }

        .landing-hero__stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .landing-hero__stats div {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 14px;
            text-align: center;
        }

        .landing-hero__stats strong {
            display: block;
            font-size: 1.25rem;
            color: var(--landing-primary);
        }

        .landing-hero__stats span {
            font-size: 0.8rem;
            color: var(--landing-muted);
        }

        .section-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(29, 78, 216, 0.08);
            color: var(--landing-primary);
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .feature-card {
            height: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 22px;
            background: #ffffff;
            padding: 28px;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.1);
        }

        .feature-card__icon {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.55rem;
            margin-bottom: 18px;
        }

        .feature-card h5 {
            font-weight: 800;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: var(--landing-muted);
            margin-bottom: 0;
            line-height: 1.65;
        }

        .info-panel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 34px;
            box-shadow: 0 16px 38px rgba(15, 23, 42, 0.06);
        }

        .step-item {
            display: grid;
            grid-template-columns: 44px 1fr;
            gap: 16px;
            align-items: start;
            padding: 18px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .step-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .step-item__number {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--landing-primary);
            color: #ffffff;
            font-weight: 800;
        }

        .step-item h6 {
            font-weight: 800;
            margin-bottom: 4px;
        }

        .step-item p {
            color: var(--landing-muted);
            margin-bottom: 0;
            line-height: 1.6;
        }

        .cta-box {
            background: linear-gradient(135deg, var(--landing-primary) 0%, var(--landing-secondary) 100%);
            color: #ffffff;
            border-radius: 28px;
            padding: 40px;
            box-shadow: 0 22px 50px rgba(29, 78, 216, 0.22);
        }

        .cta-box p {
            color: rgba(255, 255, 255, 0.86);
            max-width: 620px;
        }

        .landing-footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 34px 0;
        }

        .landing-footer strong {
            color: #ffffff;
        }

        .login-modal .form-control {
            height: 50px;
            border-radius: 12px;
            background: #f8fafc;
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
            .landing-hero {
                padding: 56px 0 48px;
            }

            .landing-hero__panel {
                margin-top: 24px;
            }

            .info-panel,
            .cta-box {
                padding: 28px;
            }
        }
    </style>
</head>
<body class="landing-page">
    <nav class="landing-nav">
        <div class="container py-3 d-flex align-items-center justify-content-between gap-3">
            <a href="<?= site_url('/'); ?>" class="landing-nav__brand">
                <img src="<?= base_url('public/assets/images/logo.jpeg'); ?>" alt="Logo SILAGAPORA" width="40" height="40" class="rounded">
                <img src="<?= base_url('public/assets/images/logo_bna.png'); ?>" alt="Logo Kabupaten Banjarnegara" width="40" height="40" style="object-fit: contain;">
                <div>
                    <strong>SILAGAPORA</strong>
                    <span>Pemerintah Kabupaten Banjarnegara</span>
                </div>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="<?= site_url('register'); ?>" class="btn btn-outline-primary radius-8">Daftar</a>
                <button type="button" class="btn btn-primary radius-8" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="ri-login-box-line me-1"></i> Masuk
                </button>
            </div>
        </div>
    </nav>

    <section class="landing-hero">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7">
                    <div class="landing-hero__content">
                        <span class="section-kicker">
                            <iconify-icon icon="solar:shield-check-bold"></iconify-icon>
                            Sistem Informasi Lomba dan Agenda Kepemudaan Olahraga Banjarnegara
                        </span>
                        <h1>SILAGAPORA Banjarnegara</h1>
                        <p>
                            Sistem Informasi Lomba dan Agenda Kepemudaan Olahraga Kabupaten Banjarnegara.
                            Kelola data atlet, kompetisi, prestasi, piagam, dan laporan dalam satu platform yang rapi,
                            mudah dipantau, dan dapat diakses sesuai peran pengguna.
                        </p>
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <button type="button" class="btn btn-primary btn-lg radius-8" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="ri-login-box-line me-1"></i> Masuk ke Sistem
                            </button>
                            <a href="<?= site_url('register'); ?>" class="btn btn-light btn-lg radius-8 border">
                                <i class="ri-user-add-line me-1"></i> Daftar Operator Sekolah
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="landing-hero__panel">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="<?= base_url('public/assets/images/logo.jpeg'); ?>" alt="Logo SILAGAPORA" width="72" height="72" style="object-fit: contain; border-radius: 16px; background: rgba(255,255,255,.12); padding: 8px;">
                            <img src="<?= base_url('public/assets/images/logo_bna.png'); ?>" alt="Logo Kabupaten Banjarnegara" width="72" height="72" style="object-fit: contain;">
                        </div>
                        <h3>Pemerintah Kabupaten Banjarnegara</h3>
                        <p>
                            Platform digital untuk mendukung pengelolaan data keolahragaan daerah secara tertib,
                            cepat, dan transparan.
                        </p>
                        <div class="landing-hero__stats">
                            <div>
                                <strong>Atlet</strong>
                                <span>Data terpusat</span>
                            </div>
                            <div>
                                <strong>Kompetisi</strong>
                                <span>Terjadwal</span>
                            </div>
                            <div>
                                <strong>Prestasi</strong>
                                <span>Piagam digital</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-kicker">
                    <iconify-icon icon="solar:info-circle-bold"></iconify-icon>
                    Informasi untuk Masyarakat
                </span>
                <h2 class="fw-bold mb-2">Apa itu SILAGAPORA?</h2>
                <p class="text-secondary-light mb-0">SILAGAPORA membantu pengelolaan lomba, agenda, dan prestasi olahraga di Kabupaten Banjarnegara.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-card__icon bg-primary-50 text-primary-600">
                            <iconify-icon icon="solar:users-group-rounded-bold"></iconify-icon>
                        </div>
                        <h5>Data Atlet</h5>
                        <p>Pendataan atlet pelajar, sekolah, cabang olahraga, dan nomor lomba dalam satu sistem.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-card__icon bg-success-50 text-success-600">
                            <iconify-icon icon="solar:cup-bold"></iconify-icon>
                        </div>
                        <h5>Kompetisi</h5>
                        <p>Pengelolaan kompetisi, peserta, jadwal, dan hasil perlombaan secara terstruktur.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-card__icon bg-warning-50 text-warning-600">
                            <iconify-icon icon="solar:medal-star-bold"></iconify-icon>
                        </div>
                        <h5>Prestasi</h5>
                        <p>Pencatatan prestasi atlet dan pengelolaan piagam digital dengan lebih mudah.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-card__icon bg-info-50 text-info-600">
                            <iconify-icon icon="solar:chart-2-bold"></iconify-icon>
                        </div>
                        <h5>Laporan</h5>
                        <p>Rekap data dan jurnal medali untuk monitoring kegiatan olahraga daerah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-6">
                    <div class="info-panel h-100">
                        <span class="section-kicker">
                            <iconify-icon icon="solar:buildings-2-bold"></iconify-icon>
                            Tentang Sistem
                        </span>
                        <h2 class="fw-bold mb-3">Mendukung pengelolaan keolahragaan daerah</h2>
                        <p class="text-secondary-light mb-3">
                            SILAGAPORA digunakan oleh dinas, validator, dan operator sekolah untuk mengelola data atlet,
                            kompetisi, prestasi, serta piagam. Sistem ini membantu proses verifikasi dokumen dan
                            pelaporan kegiatan olahraga secara lebih tertib.
                        </p>
                        <p class="text-secondary-light mb-0">
                            Masyarakat dapat memperoleh informasi umum terkait kegiatan olahraga, sedangkan pengelolaan
                            data detail dilakukan oleh pengguna yang memiliki akses.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-panel h-100">
                        <h3 class="fw-bold mb-3">Alur Penggunaan</h3>
                        <div class="step-item">
                            <div class="step-item__number">1</div>
                            <div>
                                <h6>Operator sekolah mendaftar</h6>
                                <p>Operator sekolah membuat akun melalui halaman registrasi.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-item__number">2</div>
                            <div>
                                <h6>Lengkapi data atlet</h6>
                                <p>Unggah berkas atlet dan validasi dokumen yang diperlukan.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-item__number">3</div>
                            <div>
                                <h6>Kelola kompetisi dan prestasi</h6>
                                <p>Daftarkan peserta, catat hasil, dan unduh piagam.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="cta-box d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h3 class="fw-bold mb-2">Butuh akses ke sistem?</h3>
                    <p class="mb-0">Masuk menggunakan akun yang telah diberikan atau daftar sebagai operator sekolah.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-light btn-lg radius-8" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="ri-login-box-line me-1"></i> Masuk
                    </button>
                    <a href="<?= site_url('register'); ?>" class="btn btn-outline-light btn-lg radius-8">
                        <i class="ri-user-add-line me-1"></i> Daftar
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="landing-footer">
        <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <img src="<?= base_url('public/assets/images/logo.jpeg'); ?>" alt="Logo SILAGAPORA" width="40" height="40" style="object-fit: contain; border-radius: 10px;">
                <img src="<?= base_url('public/assets/images/logo_bna.png'); ?>" alt="Logo Kabupaten Banjarnegara" width="40" height="40" style="object-fit: contain;">
                <div>
                    <strong>SILAGAPORA</strong>
                    <div class="small">Pemerintah Kabupaten Banjarnegara</div>
                </div>
            </div>
            <div class="small">© <?= date('Y'); ?> Sistem Informasi Lomba dan Agenda Kepemudaan Olahraga</div>
        </div>
    </footer>

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="loginModalLabel">Masuk ke SILAGAPORA</h5>
                        <small class="text-muted">Gunakan akun yang telah terdaftar.</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-3">
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

                        <button type="submit" class="btn btn-primary w-100" id="loginButton" style="height: 52px; border-radius: 12px; font-weight: 700;">
                            <span class="login-button__text">Masuk</span>
                            <span class="login-button__spinner d-none">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Memproses...
                            </span>
                        </button>

                        <div class="mt-3 text-center text-sm">
                            <p class="mb-0 text-secondary-light">
                                Belum punya akun?
                                <a href="<?= site_url('register'); ?>" class="text-primary-600 fw-semibold">Daftar di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

            <?php if ($openLoginModal): ?>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = new bootstrap.Modal(document.getElementById('loginModal'));
                modal.show();
            });
            <?php endif; ?>
        })();
    </script>
</body>
</html>
