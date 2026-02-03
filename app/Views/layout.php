<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPORA - Banjarnegara</title>
    <link rel="icon" type="image/png" href="<?= base_url('public'); ?>/assets/images/icon.png" sizes="16x16">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/remixicon.css">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/bootstrap.min.css">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/apexcharts.css">
    <!-- Data Table css -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/lib/dataTables.min.css">
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
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/style.css">
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

    <button type="button"
        class="theme-customization__button w-48-px h-48-px bg-primary-600 text-white rounded-circle d-flex justify-content-center align-items-center position-fixed end-0 bottom-0 mb-40 me-40 text-2xxl bg-hover-primary-700">
        <i class="ri-settings-3-line animate-spin"></i>
    </button>

    <div class="theme-customization-sidebar w-100 bg-base h-100vh overflow-y-auto position-fixed end-0 top-0 shadow-lg">
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
    </div>
    <!-- Theme Customization Structure End -->

    <?php

    use function App\Controllers\isAdmin;

    $role = session()->get('user')['role_id'] == '1' ? 'admin' : 'sekolah';
    $op_nama = session('user')['nama'];
    ?>

    <aside class="sidebar">
        <button type="button" class="sidebar-close-btn">
            <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
        </button>
        <div>
            <a href="<?= base_url('/dashboard'); ?>" class="d-flex align-items-center gap-2 sidebar-logo">
                <img src="<?= base_url('public'); ?>/assets/images/icon.png" alt="site logo" class="light-logo">
                <span class="fs-2">SIMPORA</span>
            </a>
        </div>
        <div class="sidebar-menu-area">
            <ul class="sidebar-menu" id="sidebar-menu">
                <li>
                    <a href="<?= base_url('/dashboard'); ?>">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-menu-group-title">Menu <?= ucfirst($role); ?></li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="bi:pie-chart" class="menu-icon"></iconify-icon>
                        <span>Data Keolahragaan</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="<?= base_url($role . '/atlet/data'); ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Data Atlet</a>
                        </li>
                    </ul>
                </li>
                <?php if (isAdmin()): ?>
                    <li>
                        <a href="<?= base_url($role . '/users/data'); ?>">
                            <iconify-icon icon="bi:person-gear" class="menu-icon"></iconify-icon>
                            <span>Daftar Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url($role . '/operator/data'); ?>">
                            <iconify-icon icon="streamline-freehand:meeting-co-working-2" class="menu-icon"></iconify-icon>
                            <span>Daftar Operator</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="carbon:event" class="menu-icon"></iconify-icon>
                        <span>Data Kompetisi</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="<?= base_url($role . '/kompetisi/data'); ?>"><iconify-icon icon="lucide:circle-star" class="menu-icon"></iconify-icon><span>Kompetisi</span></a></li>
                        <li><a href="<?= base_url($role . '/kompetisi/prestasi'); ?>"> <iconify-icon icon="lucide:medal" class="menu-icon"></iconify-icon><span>Prestasi</span></a></li>
                        <?php if (isAdmin()): ?>
                            <li><a href="<?= base_url($role . '/kompetisi/cabor'); ?>"> <iconify-icon icon="material-symbols:run-circle-rounded" class="menu-icon"></iconify-icon><span>Cabang Olahraga</span></a></li>
                            <li><a href="<?= base_url($role . '/kompetisi/nomor-cabor'); ?>"> <iconify-icon icon="lucide:medal" class="menu-icon"></iconify-icon><span>No. Cabang Olahraga</span></a></li>
                        <?php endif; ?>
                    </ul>
                <li>
                    <a href="<?= site_url('jurnal-medali'); ?>">
                        <iconify-icon icon="material-symbols:trophy-outline-rounded" class="menu-icon"></iconify-icon>
                        <span>Jurnal Medali</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('admin/ganti-password?id=' . session('user')['id']); ?>">
                        <iconify-icon icon="material-symbols:vpn-key-alert-outline" class="menu-icon"></iconify-icon>
                        <span>Ganti Password</span>
                    </a>
                </li>
                <li><a class="text-danger-500" href="<?= base_url('logout'); ?>"> <iconify-icon icon="carbon:exit" class="menu-icon"></iconify-icon></iconify-icon><span>Logout</span></a></li>
                </li>
            </ul>
        </div>
    </aside>

    <main class="dashboard-main">
        <div class="navbar-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <div class="d-flex flex-wrap align-items-center gap-4">
                        <button type="button" class="sidebar-toggle">
                            <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
                            <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
                        </button>
                        <button type="button" class="sidebar-mobile-toggle">
                            <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                        </button>
                        <form class="navbar-search">
                            <input type="text" name="search" placeholder="Search">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </form>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <button type="button" data-theme-toggle
                            class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>

                        <div class="dropdown">
                            <button class="d-flex justify-content-center align-items-center rounded-circle" type="button"
                                data-bs-toggle="dropdown">
                                <img src="<?= base_url('public'); ?>/assets/images/user.png" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">
                            </button>
                            <div class="dropdown-menu to-top dropdown-menu-sm">
                                <div
                                    class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                                    <div>
                                        <h6 class="text-lg text-primary-light fw-semibold mb-2"><?= $op_nama; ?></h6>
                                        <span class="text-secondary-light fw-medium text-sm"><?= ucfirst($role); ?></span>
                                    </div>
                                    <button type="button" class="hover-text-danger">
                                        <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                                    </button>
                                </div>
                                <ul class="to-top-list">
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                            href="view-profile.html">
                                            <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> My Profile</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                            href="email.html">
                                            <iconify-icon icon="tabler:message-check" class="icon text-xl"></iconify-icon> Inbox</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                            href="company.html">
                                            <iconify-icon icon="icon-park-outline:setting-two" class="icon text-xl"></iconify-icon> Setting</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3"
                                            href="<?= base_url('logout'); ?>">
                                            <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log Out</a>
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
            <!-- Apex Chart js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/apexcharts.min.js"></script>
            <!-- Data Table js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/dataTables.min.js"></script>
            <!-- Iconify Font js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/iconify-icon.min.js"></script>
            <!-- jQuery UI js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/jquery-ui.min.js"></script>
            <!-- Vector Map js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
            <script src="<?= base_url('public'); ?>/assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
            <!-- Popup js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/magnifc-popup.min.js"></script>
            <!-- Slick Slider js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/slick.min.js"></script>
            <!-- prism js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/prism.js"></script>
            <!-- file upload js -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/file-upload.js"></script>
            <!-- audioplayer -->
            <script src="<?= base_url('public'); ?>/assets/js/lib/audioplayer.js"></script>
            <!-- swal -->
            <script src="<?= base_url('public'); ?>/assets/js/sweetalert2.all.min.js"></script>
            <!-- Select2 -->
            <script src="<?= base_url('public'); ?>/assets/js/select2.full.min.js"></script>
            <!-- HTML2CANVAS-->
            <script src="<?= base_url('public'); ?>/assets/js/html2canvas.min.js"></script>
            <!-- lightboxes -->
            <script src="<?= base_url('public'); ?>/assets/js/photoswipe.esm.js" type="module"></script>
            <script src="<?= base_url('public'); ?>/assets/js/photoswipe-lightbox.esm.js" type="module"></script>

            <link rel="stylesheet" href="https://unpkg.com/photoswipe@5/dist/photoswipe.css">

            <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe-lightbox.umd.min.js"></script>


            <!-- main js -->
            <script src="<?= base_url('public'); ?>/assets/js/app.js"></script>

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
                window.onload = function() {
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
                        let table = new DataTable('#dataTable', {
                            responsive: true,
                            columnDefs: [{
                                    targets: 2,
                                    name: 'filter-sekolah'
                                },
                                {
                                    targets: 3,
                                    name: 'filter-cabor'
                                }
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
                };
            </script>
            <!-- End Script -->
            <!-- Content-->
            <?= $this->renderSection('content'); ?>
            <!-- End Content-->
        </div>

        <footer class="d-footer">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <p class="mb-0">© <?= date('Y'); ?> Dinas Pendidikan Pemuda dan Olahraga Kabupaten Banjarnegara</p>
                </div>
                <div class="col-auto">
                    <p class="mb-0">Made with <span class="text-primary-600"><iconify-icon icon="lucide:heart" width="24" height="24" style="color:#dc2626;"></iconify-icon></span></p>

                </div>
            </div>
        </footer>
    </main>
</body>

</html>