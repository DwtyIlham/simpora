<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">


<!-- Mirrored from wowdash.wowtheme7.com/demo/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Nov 2025 07:07:33 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPORA - KAB. BANJARNEGARA</title>
    <link rel="icon" type="image/png" href="assets/images/icon.png" sizes="16x16">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="assets/css/remixicon.css">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="assets/css/lib/bootstrap.min.css">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="assets/css/lib/apexcharts.css">
    <!-- Data Table css -->
    <link rel="stylesheet" href="assets/css/lib/dataTables.min.css">
    <!-- Text Editor css -->
    <link rel="stylesheet" href="assets/css/lib/editor-katex.min.css">
    <link rel="stylesheet" href="assets/css/lib/editor.atom-one-dark.min.css">
    <link rel="stylesheet" href="assets/css/lib/editor.quill.snow.css">
    <!-- Date picker css -->
    <link rel="stylesheet" href="assets/css/lib/flatpickr.min.css">
    <!-- Calendar css -->
    <link rel="stylesheet" href="assets/css/lib/full-calendar.css">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="assets/css/lib/jquery-jvectormap-2.0.5.css">
    <!-- Popup css -->
    <link rel="stylesheet" href="assets/css/lib/magnific-popup.css">
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="assets/css/lib/slick.css">
    <!-- prism css -->
    <link rel="stylesheet" href="assets/css/lib/prism.css">
    <!-- file upload css -->
    <link rel="stylesheet" href="assets/css/lib/file-upload.css">

    <link rel="stylesheet" href="assets/css/lib/audioplayer.css">
    <!-- SWAL -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/sweetalert2.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/select2.min.css">
    <!-- Select2 BS 5 -->
    <link rel="stylesheet" href="<?= base_url('public'); ?>/assets/css/select2-bootstrap-5-theme.min.css">
    <!-- main css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Theme Customization Structure Start -->
    <div class="body-overlay"></div>

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

    <section class="auth bg-base d-flex flex-wrap">
        <div class="auth-left d-lg-block d-none">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center">
                <!-- <img src="assets/images/auth/auth-img.png" alt="Image"> -->
                <img src="assets/images/login-image.jpg" alt="Image">
            </div>
        </div>
        <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <!-- <?php
                        $success = session()->getFlashdata('success');
                        $error   = session()->getFlashdata('error');

                        if ($success || $error): ?>
                    <div class="p-16 radius-8 border-start-width-3-px border-top-0 border-end-0 border-bottom-0 <?= $success ? 'bg-success-50 border-success-main' : 'bg-danger-50 border-danger-main'; ?>">

                        <?php if ($success): ?>
                            <h6 class="text-success text-md mb-8"><?= esc($success); ?></h6>
                            <span class="text-success mb-0">- Berhasil</span>

                        <?php else: ?>
                            <h6 class="text-danger text-md mb-8"><?= esc($error); ?></h6>
                            <span class="text-danger mb-0">- Gagal</span>

                        <?php endif; ?>
                    </div>
                <?php endif; ?> -->
                <div>
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-3 p-3">

                        <!-- Logo -->
                        <div class="text-center" style="max-width: 15%;">
                            <img src="<?= base_url('public/assets/images/logo_bna.svg'); ?>"
                                alt="Logo BNA"
                                class="img-fluid">
                        </div>

                        <!-- Text -->
                        <div class="text-center align-self-center">
                            <h1 class="mb-0"><img src="assets/images/icon.png" alt="Logo-Simpora" class="img-fluid" style="max-width: 10%;"> SIMPORA</h1>
                            <small class="mb-0">Sistem Informasi Manajemen Pembinaan Olahraga</small>
                        </div>

                    </div>

                </div>
                <form action="auth/login" method="post">
                    <div class="icon-field mb-16">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:user"></iconify-icon>
                        </span>
                        <input type="text" name="username" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Username">
                    </div>
                    <div class="position-relative mb-20">
                        <div class="icon-field">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                            </span>
                            <input type="password" name="password" class="form-control h-56-px bg-neutral-50 radius-12" id="your-password" placeholder="Password" autocomplete="off">
                        </div>
                        <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                    </div>
                    <div class="">
                        <div class="d-flex justify-content-between gap-2">
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input border border-neutral-300" type="checkbox" value="" id="remeber">
                                <label class="form-check-label" for="remeber">Remember me </label>
                            </div>
                            <a href="javascript:void(0)" class="text-primary-600 fw-medium">Forgot Password?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">Log In</button>

                    <div class="mt-32 text-center text-sm">
                        <p class="mb-0">Belum punya akun ? Silahkan registrasi <a href="<?= base_url('register'); ?>" class="text-primary-600 fw-semibold text-primary-main bg-info-focus px-4">disini <i class="ri-arrow-right-line"></i>.</a></p>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <!-- jQuery library js -->
    <script src="assets/js/lib/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap js -->
    <script src="assets/js/lib/bootstrap.bundle.min.js"></script>
    <!-- Apex Chart js -->
    <script src="assets/js/lib/apexcharts.min.js"></script>
    <!-- Data Table js -->
    <script src="assets/js/lib/dataTables.min.js"></script>
    <!-- Iconify Font js -->
    <script src="assets/js/lib/iconify-icon.min.js"></script>
    <!-- jQuery UI js -->
    <script src="assets/js/lib/jquery-ui.min.js"></script>
    <!-- Vector Map js -->
    <script src="assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
    <script src="assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
    <!-- Popup js -->
    <script src="assets/js/lib/magnifc-popup.min.js"></script>
    <!-- Slick Slider js -->
    <script src="assets/js/lib/slick.min.js"></script>
    <!-- prism js -->
    <script src="assets/js/lib/prism.js"></script>
    <!-- file upload js -->
    <script src="assets/js/lib/file-upload.js"></script>
    <!-- audioplayer -->
    <script src="assets/js/lib/audioplayer.js"></script>

    <!-- swal -->
    <script src="<?= base_url('public'); ?>/assets/js/sweetalert2.all.min.js"></script>
    <!-- Select2 -->
    <script src="<?= base_url('public'); ?>/assets/js/select2.full.min.js"></script>

    <!-- main js -->
    <script src="assets/js/app.js"></script>

    <script>
        window.onload = function() {
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

            $(window).on('resize', function() {
                $('.select2').each(function() {
                    let parentWidth = $(this).parent().width();
                    $(this).next('.select2-container').css('width', parentWidth + 'px');
                });
            });


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
        // ================== Password Show Hide Js Start ==========
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on('click', function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }
        // Call the function
        initializePasswordToggle('.toggle-password');
        // ========================= Password Show Hide Js End ===========================
    </script>

</body>

<!-- Mirrored from wowdash.wowtheme7.com/demo/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Nov 2025 07:07:33 GMT -->

</html>