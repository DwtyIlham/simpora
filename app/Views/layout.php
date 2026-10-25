<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<style>
    .sidebar-logo span {
        transition: opacity 0.3s ease;
    }

    .sidebar-mini .sidebar-logo span {
        opacity: 0;
        height: 0;
        overflow: hidden;
    }

    /* Memastikan transisi rotasi halus */
    .pswp__img {
        transition: transform 0.3s ease !important;
    }

    /* Mengatur posisi ikon agar pas di tengah button toolbar */
    .pswp__button--rotate-button i {
        line-height: 40px;
        display: block;
        text-align: center;
    }

    /* Memberikan background gelap transparan pada tombol agar ikon putih selalu terlihat */
    .pswp__button {
        background-color: rgba(0, 0, 0, 0.3) !important;
        margin-left: 5px;
        border-radius: 4px;
        transition: background 0.2s ease;
    }

    /* Efek saat kursor di atas tombol */
    .pswp__button:hover {
        background-color: rgba(0, 0, 0, 0.6) !important;
    }

    /* Khusus untuk ikon Remix yang kita masukkan */
    .pswp__button i {
        color: #ffffff !important;
        text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.8);
        /* Tambahan shadow pada ikon */
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILAGAPORA - Banjarnegara</title>
    <link rel="icon" type="image/png" href="<?= base_url('public'); ?>/assets/images/logo_bna.svg" sizes="16x16">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/remixicon.css">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/bootstrap.min.css">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/apexcharts.css">
    <!-- Data Table css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.css">
    <!-- Text Editor css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/editor-katex.min.css">
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/editor.atom-one-dark.min.css">
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/editor.quill.snow.css">
    <!-- Date picker css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/flatpickr.min.css">
    <!-- Calendar css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/full-calendar.css">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/jquery-jvectormap-2.0.5.css">
    <!-- Popup css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/magnific-popup.css">
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/slick.css">
    <!-- prism css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/prism.css">
    <!-- file upload css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/file-upload.css">

    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/audioplayer.css">
    <!-- SWAL -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/sweetalert2.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/select2.min.css">
    <!-- Select2 BS 5 -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/select2-bootstrap-5-theme.min.css">
    <!-- photoswipe -->
    <link href="<?= base_url('public'); ?>/assets/css/photoswipe.css" rel="stylesheet" />

    <!-- main css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/style.css?v=3">
</head>

<body>

    <!-- Theme Customization Structure Start -->
    <div class="body-overlay"></div>
    <!-- loader -->
    <div id="loading" class="loading">
        <div class="loader--ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- end loader -->

    <!-- <button type="button"
        class="theme-customization__button w-48-px h-48-px bg-primary-600 text-white rounded-circle d-flex justify-content-center align-items-center position-fixed end-0 bottom-0 mb-40 me-40 text-2xxl bg-hover-primary-700">
        <i class="ri-settings-3-line animate-spin"></i>
    </button> -->

    <!-- <div class="theme-customization-sidebar w-100 bg-base h-100vh overflow-y-auto position-fixed end-0 top-0 shadow-lg">
        <div class="d-flex align-items-center gap-3 py-16 px-24 justify-content-between border-bottom">
            <div>
                <h6 class="text-sm dark:text-white">Theme Settings</h6>
                <p class="text-xs mb-0 text-neutral-500 dark:text-neutral-200">Customize and preview instantly</p>
            </div>
            <button data-slot="button"
                class="theme-customization-sidebar__close text-neutral-900 bg-transparent text-hover-primary-600 d-flex text-xl">
                <i class="ri-close-fill"></i>
            </button>
        </div>

        <div class="d-flex flex-column gap-48 p-24 overflow-y-auto flex-grow-1">

            <div class="theme-setting-item">
                <h6 class="fw-medium text-primary-light text-md mb-3">Theme Mode</h6>
                <div class="d-grid grid-cols-3 gap-3 dark-light-mode">
                    <button type="button"
                        class="theme-btn theme-setting-item__btn d-flex align-items-center justify-content-center h-64-px rounded-3 text-xl active"
                        data-theme="light">
                        <i class="ri-sun-line"></i>
                    </button>
                    <button type="button"
                        class="theme-btn theme-setting-item__btn d-flex align-items-center justify-content-center h-64-px rounded-3 text-xl"
                        data-theme="dark">
                        <i class="ri-moon-line"></i>
                    </button>
                    <button type="button"
                        class="theme-btn theme-setting-item__btn d-flex align-items-center justify-content-center h-64-px rounded-3 text-xl"
                        data-theme="system">
                        <i class="ri-computer-line"></i>
                    </button>
                </div>
            </div>

            <div class="theme-setting-item">
                <h6 class="fw-medium text-primary-light text-md mb-3">Page Direction</h6>
                <div class="d-grid grid-cols-2 gap-3">
                    <button type="button"
                        class="theme-setting-item__btn ltr-mode-btn d-flex align-items-center justify-content-center gap-2 h-56-px rounded-3 text-xl">
                        <span><i class="ri-align-item-left-line"></i></span>
                        <span class="h6 text-sm font-medium mb-0">LTR</span>
                    </button>

                    <button type="button"
                        class="theme-setting-item__btn rtl-mode-btn d-flex align-items-center justify-content-center gap-2 h-56-px rounded-3 text-xl">
                        <span class="h6 text-sm font-medium mb-0">RTL</span>
                        <span><i class="ri-align-item-right-line"></i></span>
                    </button>
                </div>
            </div>

            <div class="theme-setting-item">
                <h6 class="fw-medium text-primary-light text-md mb-3">Color Schema</h6>
                <div class="d-grid grid-cols-3 gap-3">
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="blue">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #2563eb;"></span>
                        <span class="fw-medium mt-1" style="color: #2563eb;">Blue</span>
                    </button>
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="red">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #dc2626;"></span>
                        <span class="fw-medium mt-1" style="color: #dc2626;">Red</span>
                    </button>
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="green">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #16a34a;"></span>
                        <span class="fw-medium mt-1" style="color: #16a34a;">Green</span>
                    </button>
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="yellow">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #ff9f29;"></span>
                        <span class="fw-medium mt-1" style="color: #ff9f29;">Yellow</span>
                    </button>
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="cyan">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #00b8f2;"></span>
                        <span class="fw-medium mt-1" style="color: #00b8f2;">Cyan</span>
                    </button>
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="violet">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #7c3aed;"></span>
                        <span class="fw-medium mt-1" style="color: #7c3aed;">Violet</span>
                    </button>
                </div>
            </div>

        </div>
    </div> -->
    <!-- Theme Customization Structure End -->

    <?php
    $user       = session('user') ?? [];
    $role_id    = (string) ($user['role_id'] ?? '');
    $role       = $role_id === '2' ? 'sekolah' : ($role_id === '4' ? 'validator' : 'admin');
    $op_nama    = $user['nama'] ?? 'Pengguna';
    $roleLabel  = $role === 'admin'
        ? 'Administrator Dinas'
        : ($role === 'validator' ? 'Validator' : 'Operator Sekolah');
    $startsWith = static function ($haystack, $needle) {
        return $needle === '' || strpos($haystack, $needle) === 0;
    };
    $dashboardUrl = base_url($role === 'admin' ? '/dashboard' : $role . '/dashboard');
    $passwordUrl  = base_url($role . '/ganti-password') . '?id=' . urlencode((string) ($user['id'] ?? ''));
    $initial      = strtoupper(substr($op_nama, 0, 1));

    $uri = trim(uri_string(), '/');
    $isDashboard  = $uri === '' || $uri === 'dashboard' || $uri === $role . '/dashboard';
    $isAtlet      = $startsWith($uri, $role . '/atlet');
    $isUsers      = $startsWith($uri, $role . '/users');
    $isValidator  = $startsWith($uri, 'admin/validator');
    $isKompetisi  = $startsWith($uri, $role . '/kompetisi') || $startsWith($uri, $role . '/cabor');
    $isKompetisiData = $uri === $role . '/kompetisi/data'
        || $startsWith($uri, $role . '/kompetisi/add')
        || $startsWith($uri, $role . '/kompetisi/edit')
        || $startsWith($uri, $role . '/kompetisi/peserta')
        || $startsWith($uri, $role . '/kompetisi/delete');
    $isPrestasi   = $startsWith($uri, $role . '/kompetisi/prestasi');
    $isCabor      = $startsWith($uri, $role . '/kompetisi/cabor') || $startsWith($uri, $role . '/cabor');
    $isNomorCabor = $startsWith($uri, $role . '/kompetisi/nomor-cabor') || $startsWith($uri, $role . '/nomorcabor');
    $isJurnal     = $startsWith($uri, 'jurnal-medali');
    $isRekap      = $uri === $role . '/rekap-data';
    $isSetting    = $startsWith($uri, 'admin/setting');
    $isPassword   = $startsWith($uri, $role . '/ganti-password');
    $activeClass  = static fn(bool $active): string => $active ? 'active-page' : '';
    $activeAria   = static fn(bool $active): string => $active ? ' aria-current="page"' : '';
    ?>

    <aside class="sidebar" id="app-sidebar">
        <button type="button" class="sidebar-close-btn" aria-label="Tutup menu">
            <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
        </button>
        <a href="<?= $dashboardUrl; ?>" class="d-flex align-items-center sidebar-logo" aria-label="Ke dashboard">
            <img src="<?= base_url('public/assets/images/logo.jpeg'); ?>"
                alt="Logo SILAGAPORA"
                class="img-fluid rounded-circle light-logo">
            <img src="<?= base_url('public/assets/images/logo.jpeg'); ?>"
                alt="Logo SILAGAPORA"
                class="img-fluid rounded-circle logo-icon">
            <span class="brand-text">
                <span class="brand-title">SILAGAPORA</span>
                <span class="brand-subtitle"><?= esc($roleLabel); ?></span>
            </span>
        </a>
        <div class="sidebar-menu-area">
            <div class="sidebar-profile" title="<?= esc($op_nama); ?>">
                <span class="sidebar-avatar"><?= esc($initial); ?></span>
                <span class="sidebar-profile-meta">
                    <span class="sidebar-profile-name"><?= esc($op_nama); ?></span>
                    <span class="sidebar-profile-role"><?= esc($roleLabel); ?></span>
                </span>
            </div>

            <ul class="sidebar-menu" id="sidebar-menu">
                <li class="sidebar-menu-group-title">Menu Utama</li>
                <li>
                    <a href="<?= $dashboardUrl; ?>" class="<?= $activeClass($isDashboard); ?>"<?= $activeAria($isDashboard); ?> title="Dashboard">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url($role . '/atlet/data'); ?>" class="<?= $activeClass($isAtlet); ?>"<?= $activeAria($isAtlet); ?> title="Data Atlet">
                        <iconify-icon icon="bi:people" class="menu-icon"></iconify-icon>
                        <span>Data Atlet</span>
                    </a>
                </li>

                <?php if ($role === 'admin' || $role === 'validator'): ?>
                    <li class="sidebar-menu-group-title">Manajemen</li>
                    <li>
                        <a href="<?= base_url($role . '/users/data'); ?>" class="<?= $activeClass($isUsers); ?>"<?= $activeAria($isUsers); ?> title="Daftar Users">
                            <iconify-icon icon="bi:person-gear" class="menu-icon"></iconify-icon>
                            <span>Daftar Users</span>
                        </a>
                    </li>
                    <?php if ($role === 'admin'): ?>
                        <li>
                            <a href="<?= base_url('admin/validator/data'); ?>" class="<?= $activeClass($isValidator); ?>"<?= $activeAria($isValidator); ?> title="Daftar Validator">
                                <iconify-icon icon="bi:person-check" class="menu-icon"></iconify-icon>
                                <span>Daftar Validator</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($role === 'admin' || $role === 'sekolah'): ?>
                    <li class="sidebar-menu-group-title">Kompetisi</li>
                    <li class="dropdown <?= $isKompetisi ? 'open' : ''; ?>">
                        <a href="javascript:void(0)" aria-expanded="<?= $isKompetisi ? 'true' : 'false'; ?>" title="Data Kompetisi">
                            <iconify-icon icon="carbon:event" class="menu-icon"></iconify-icon>
                            <span>Data Kompetisi</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="<?= base_url($role . '/kompetisi/data'); ?>" class="<?= $activeClass($isKompetisiData); ?>"<?= $activeAria($isKompetisiData); ?>>
                                    <i class="ri-circle-fill circle-icon"></i><span>Kompetisi</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url($role . '/kompetisi/prestasi'); ?>" class="<?= $activeClass($isPrestasi); ?>"<?= $activeAria($isPrestasi); ?>>
                                    <i class="ri-circle-fill circle-icon"></i><span>Prestasi</span>
                                </a>
                            </li>
                            <?php if ($role === 'admin'): ?>
                                <li>
                                    <a href="<?= base_url('admin/kompetisi/cabor'); ?>" class="<?= $activeClass($isCabor); ?>"<?= $activeAria($isCabor); ?>>
                                        <i class="ri-circle-fill circle-icon"></i><span>Cabang Olahraga</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url('admin/kompetisi/nomor-cabor'); ?>" class="<?= $activeClass($isNomorCabor); ?>"<?= $activeAria($isNomorCabor); ?>>
                                        <i class="ri-circle-fill circle-icon"></i><span>No. Cabang Olahraga</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php elseif ($role === 'validator'): ?>
                    <li class="sidebar-menu-group-title">Kompetisi</li>
                    <li>
                        <a href="<?= base_url('validator/kompetisi/prestasi'); ?>" class="<?= $activeClass($isPrestasi); ?>"<?= $activeAria($isPrestasi); ?> title="Prestasi">
                            <iconify-icon icon="lucide:medal" class="menu-icon"></iconify-icon>
                            <span>Prestasi</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($role === 'admin' || $role === 'validator'): ?>
                    <li class="sidebar-menu-group-title">Laporan</li>
                    <li>
                        <a href="<?= site_url('jurnal-medali'); ?>" class="<?= $activeClass($isJurnal); ?>"<?= $activeAria($isJurnal); ?> title="Jurnal Medali">
                            <iconify-icon icon="material-symbols:trophy-outline-rounded" class="menu-icon"></iconify-icon>
                            <span>Jurnal Medali</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url($role . '/rekap-data'); ?>" class="<?= $activeClass($isRekap); ?>"<?= $activeAria($isRekap); ?> title="Rekap Data">
                            <iconify-icon icon="material-symbols:download-for-offline-outline" class="menu-icon"></iconify-icon>
                            <span>Rekap Data</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($role === 'admin'): ?>
                    <li class="sidebar-menu-group-title">Pengaturan</li>
                    <li>
                        <a href="<?= site_url('admin/setting'); ?>" class="<?= $activeClass($isSetting); ?>"<?= $activeAria($isSetting); ?> title="Setting">
                            <iconify-icon icon="material-symbols:settings-outline" class="menu-icon"></iconify-icon>
                            <span>Setting</span>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="sidebar-menu-group-title">Akun</li>
                <li>
                    <a href="<?= $passwordUrl; ?>" class="<?= $activeClass($isPassword); ?>"<?= $activeAria($isPassword); ?> title="Ganti Password">
                        <iconify-icon icon="material-symbols:vpn-key-alert-outline" class="menu-icon"></iconify-icon>
                        <span>Ganti Password</span>
                    </a>
                </li>
                <li class="sidebar-logout">
                    <a class="text-danger-500" href="<?= base_url('logout'); ?>" title="Logout">
                        <iconify-icon icon="carbon:exit" class="menu-icon"></iconify-icon>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <main class="dashboard-main">
        <div class="navbar-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <div class="d-flex flex-wrap align-items-center gap-4">
                        <button type="button" class="sidebar-toggle" aria-controls="app-sidebar" aria-expanded="true" aria-label="Ciutkan menu">
                            <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
                            <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
                        </button>
                        <button type="button" class="sidebar-mobile-toggle" aria-controls="app-sidebar" aria-expanded="false" aria-label="Buka menu">
                            <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                        </button>
                        <span class="navbar-role-chip d-none d-lg-inline-flex">
                            <iconify-icon icon="solar:shield-user-outline"></iconify-icon>
                            <?= esc($roleLabel); ?>
                        </span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <button type="button" data-theme-toggle
                            class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>

                        <div class="dropdown">
                            <button class="navbar-avatar-btn" type="button" data-bs-toggle="dropdown" aria-label="Menu pengguna" aria-expanded="false">
                                <span class="navbar-avatar"><?= esc($initial); ?></span>
                            </button>
                            <div class="dropdown-menu to-top dropdown-menu-sm profile-dropdown">
                                <div class="profile-dropdown-header">
                                    <span class="profile-dropdown-avatar"><?= esc($initial); ?></span>
                                    <span class="profile-dropdown-meta">
                                        <strong><?= esc($op_nama); ?></strong>
                                        <small><?= esc($roleLabel); ?></small>
                                    </span>
                                </div>
                                <ul class="to-top-list">
                                    <li>
                                        <a class="dropdown-item profile-dropdown-link"
                                            href="<?= $dashboardUrl; ?>">
                                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-xl"></iconify-icon> Dashboard</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item profile-dropdown-link"
                                            href="<?= $passwordUrl; ?>">
                                            <iconify-icon icon="material-symbols:vpn-key-alert-outline" class="icon text-xl"></iconify-icon> Ganti Password</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item profile-dropdown-link text-danger-500"
                                            href="<?= base_url('logout'); ?>">
                                            <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- Profile dropdown end -->
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-main-body">
            <!-- Script -->
            <!-- jQuery library js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/jquery-3.7.1.min.js"></script>
            <!-- Bootstrap js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/bootstrap.bundle.min.js"></script>
            <?php if (in_array(uri_string(), ['dashboard', 'sekolah/dashboard', 'validator/dashboard'], true)): ?>
                <script src="<?= base_url('public/assets/js/lib/apexcharts.min.js'); ?>"></script>
            <?php endif; ?>
            <!-- Data Table js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
            <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.js"></script>
            <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.js"></script>

            <!-- Excel -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

            <!-- PDF -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
            <!-- Iconify Font js -->
            <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
            <!-- <script src="<?= base_url('public'); ?>/assets/js/lib/iconify-icon.min.js"></script> -->
            <!-- jQuery UI js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/jquery-ui.min.js" defer></script>
            <!-- Vector Map js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/jquery-jvectormap-2.0.5.min.js" defer></script>
            <script src="<?= base_url('public'); ?>/assets/js/lib/jquery-jvectormap-world-mill-en.js" defer></script>
            <!-- Popup js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/magnifc-popup.min.js" defer></script>
            <!-- Slick Slider js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/slick.min.js" defer></script>
            <!-- prism js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/prism.js" defer></script>
            <!-- file upload js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/file-upload.js" defer></script>
            <!-- audioplayer -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/audioplayer.js" defer></script>
            <!-- swal -->
            <script src="<?= base_url('public'); ?>/assets/js/sweetalert2.all.min.js"></script>
            <!-- Select2 -->
            <script src="<?= base_url('public'); ?>/assets/js/select2.full.min.js"></script>
            <!-- HTML2CANVAS-->
            <script src="<?= base_url('public'); ?>/assets/js/html2canvas.min.js" defer></script>
            <!-- lightboxes -->
            <script src="<?= base_url('public'); ?>/assets/js/photoswipe.esm.js" type="module"></script>
            <script src="<?= base_url('public'); ?>/assets/js/photoswipe-lightbox.esm.js" type="module"></script>

            <link rel="stylesheet" href="https://unpkg.com/photoswipe@5/dist/photoswipe.css">

            <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe-lightbox.umd.min.js"></script>


            <!-- main js -->
            <script src="<?= base_url('public'); ?>/assets/js/app.js?v=4"></script>

            <script>
                // init tooltips
                document.addEventListener('DOMContentLoaded', function() {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    })
                })
            </script>

            <script>
                if (typeof table !== 'undefined' && table && typeof table.on === 'function') {
                    table.on('draw.dt', function() {

                        // re-init tooltip
                        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                            new bootstrap.Tooltip(el);
                        });

                        // re-render iconify
                        if (window.Iconify) {
                            requestAnimationFrame(() => {
                                Iconify.scan(document.body);
                            });
                        }
                    });
                }
            </script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const loader = document.getElementById("loading");

                    loader.classList.add("loading--hide");

                    setTimeout(() => {
                        loader.style.display = "none";
                    }, 1500);

                    // untuk mengatasi select2 dalam modal bootstrap 5
                    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

                    $(document).ajaxStart(function() {
                        $("#loading").show().removeClass("loading--hide");
                    });

                    $(document).ajaxStop(function() {
                        $("#loading").addClass("loading--hide");
                        setTimeout(() => {
                            $("#loading").hide();
                        }, 400);
                    });

                    // select2
                    $('.select2').each(function() {
                        let parentWidth = $(this).parent().width(); // ambil lebar px
                        $(this).select2({
                            theme: "bootstrap-5",
                            width: parentWidth + 'px',
                            placeholder: $(this).data('placeholder'),
                            allowClear: true
                        });
                    });


                    if (['kompetisi/peserta', 'kompetisi/prestasi/'].some(x =>
                            window.location.pathname.includes(x)
                        )) {
                        const defaultOptions = {
                            responsive: true,
                            columnDefs: []
                        };

                        // Konfigurasi tambahan dari view
                        const viewOptions = window.dataTableOptions || {};

                        const table = new DataTable('#dataTable', {
                            ...defaultOptions,
                            ...viewOptions,

                            // Gabungkan columnDefs
                            columnDefs: [
                                ...defaultOptions.columnDefs,
                                ...(viewOptions.columnDefs || [])
                            ]
                        });

                        $('#filter_cabor, #filter_sekolah').on('change', function() {

                            let cabor = $('#filter_cabor option:selected').data('nama');
                            let sekolah = $('#filter_sekolah option:selected').data('nama');

                            table.columns().search("");

                            if (cabor) {
                                table.column('filter-cabor:name').search(cabor, true, false);
                            }

                            if (sekolah) {
                                table.column('filter-sekolah:name').search(sekolah, true, false);
                            }

                            table.draw();
                        });
                    }

                    function initPhotoSwipe() {
                        $('.my-gallery').each(function() {
                            if (!$(this).data('pswp-initialized')) {

                                const lightbox = new PhotoSwipeLightbox({
                                    gallery: this,
                                    children: '.view-img',
                                    pswpModule: PhotoSwipe,
                                    showHideAnimationType: 'fade'
                                });

                                // --- TAMBAHKAN LOGIKA ROTASI DI SINI ---
                                lightbox.on('uiRegister', function() {
                                    lightbox.pswp.ui.registerElement({
                                        name: 'rotate-button',
                                        ariaLabel: 'Rotate',
                                        order: 9, // Muncul di dekat tombol zoom/close
                                        isButton: true,
                                        html: '<i class="ri-clockwise-line" style="color:#f0f0f0; font-size: 20px;"></i>',
                                        onClick: (event, el) => {
                                            const pswp = lightbox.pswp;
                                            // Ambil container gambar aktif
                                            const img = pswp.currSlide.container.querySelector('.pswp__img');

                                            if (img) {
                                                // Ambil rotasi saat ini atau default 0
                                                let rotation = parseInt($(img).data('rotation') || 0);
                                                rotation += 90;

                                                // Terapkan rotasi via CSS
                                                $(img).css({
                                                    'transform': `rotate(${rotation}deg)`,
                                                    'transition': 'transform 0.3s ease'
                                                });

                                                // Simpan state rotasi terbaru
                                                $(img).data('rotation', rotation);
                                            }
                                        }
                                    });
                                });
                                // --- END LOGIKA ROTASI ---

                                lightbox.init();
                                $(this).data('pswp-initialized', true);
                            }
                        });
                    }

                    // Inisialisasi awal halaman
                    initPhotoSwipe();

                    // Tombol view PDF → tab baru
                    $(document).on('click', '.view-pdf', function(e) {
                        e.preventDefault();
                        window.open($(this).data('file'), '_blank');
                    });

                    // Jika ada elemen gallery baru ditambahkan setelah AJAX
                    window.reInitGallery = function() {
                        initPhotoSwipe();
                    };

                    $(window).on('resize', function() {
                        $('.select2').each(function() {
                            let parentWidth = $(this).parent().width();
                            $(this).next('.select2-container').css('width', parentWidth + 'px');
                        });
                    });

                    // swal alert
                    <?php if (session()->has('errors')): ?>
                        Swal.fire({
                            title: 'Validasi Gagal',
                            html: `
                                <ul style="text-align:left;">
                                    <?php foreach (session('errors') as $err): ?>
                                        <li><?= esc($err) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                `,
                            icon: 'error'
                        });
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')) : ?>
                        swal.fire({
                            title: "Berhasil",
                            text: "<?= session()->getFlashdata('success') ?>",
                            icon: "success",
                            button: "OK",
                        });
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')) : ?>
                        swal.fire({
                            title: "Error",
                            text: "<?= session()->getFlashdata('error') ?>",
                            icon: "error",
                            button: "OK",
                        });
                    <?php endif; ?>
                });
            </script>
            <!-- End Script -->
            <!-- Content-->
            <?= $this->renderSection('content'); ?>
            <!-- End Content-->
        </div>

        <footer class="d-footer">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <p class="mb-0">© <?= date('Y'); ?> Dinas Pendidikan Kepemudaaan dan Olahraga Kabupaten Banjarnegara</p>
                </div>
                <div class="col-auto">
                    <p class="mb-0">Made with <span class="text-primary-600"><iconify-icon icon="lucide:heart" width="24" height="24" style="color:#dc2626;"></iconify-icon></span></p>

                </div>
            </div>
        </footer>
    </main>
</body>

</html>