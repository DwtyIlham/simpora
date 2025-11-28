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
                <li class="sidebar-menu-group-title">Menu Admin</li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <i class="ri-pie-chart-box-line"></i>
                        <span>Data Keolahragaan</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="<?= base_url('admin/atlet/data'); ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Data Atlet</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="ri-circle-fill circle-icon text-success-600 w-auto"></i> Data Pelatih</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="ri-circle-fill circle-icon text-warning-600 w-auto"></i> Data Cabor</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?= base_url('admin/users/data'); ?>">
                        <iconify-icon icon="bi:person-gear" class="menu-icon"></iconify-icon>
                        <span>Daftar Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/kompetisi/data'); ?>">
                        <iconify-icon icon="carbon:event" class="menu-icon"></iconify-icon>
                        <span>Kompetisi</span>
                    </a>
                </li>
                <li>
                    <a href="calendar-main.html">
                        <iconify-icon icon="solar:calendar-outline" class="menu-icon"></iconify-icon>
                        <span>Calendar</span>
                    </a>
                </li>
                <li>
                    <a href="kanban.html">
                        <iconify-icon icon="material-symbols:map-outline" class="menu-icon"></iconify-icon>
                        <span>Kanban</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                        <span>Invoice</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="invoice-list.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                        </li>
                        <li>
                            <a href="invoice-preview.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                Preview</a>
                        </li>
                        <li>
                            <a href="invoice-add.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add new</a>
                        </li>
                        <li>
                            <a href="invoice-edit.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Edit</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <i class="ri-robot-2-line text-xl me-14 d-flex w-auto"></i>
                        <span>Ai Application</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="text-generator.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Text
                                Generator</a>
                        </li>
                        <li>
                            <a href="code-generator.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Code
                                Generator</a>
                        </li>
                        <li>
                            <a href="image-generator.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Image
                                Generator</a>
                        </li>
                        <li>
                            <a href="voice-generator.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Voice
                                Generator</a>
                        </li>
                        <li>
                            <a href="video-generator.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Video
                                Generator</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <i class="ri-btc-line text-xl me-14 d-flex w-auto"></i>
                        <span>Crypto Currency</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="wallet.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Wallet</a>
                        </li>
                        <li>
                            <a href="marketplace.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                Marketplace</a>
                        </li>
                        <li>
                            <a href="marketplace-details.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                Marketplace Details</a>
                        </li>
                        <li>
                            <a href="portfolio.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Portfolios</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-menu-group-title">UI Elements</li>

                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                        <span>Components</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="typography.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Typography</a>
                        </li>
                        <li>
                            <a href="colors.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Colors</a>
                        </li>
                        <li>
                            <a href="button.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Button</a>
                        </li>
                        <li>
                            <a href="dropdown.html"><i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i> Dropdown</a>
                        </li>
                        <li>
                        </li>
                        <li>
                            <a href="card.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Card</a>
                        </li>
                        <li>
                            <a href="carousel.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Carousel</a>
                        </li>
                        <li>
                            <a href="avatar.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Avatars</a>
                        </li>
                        <li>
                            <a href="progress.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Progress bar</a>
                        </li>
                        <li>
                            <a href="tabs.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Tab & Accordion</a>
                        </li>
                        <li>
                            <a href="pagination.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Pagination</a>
                        </li>
                        <li>
                            <a href="badges.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Badges</a>
                        </li>
                        <li>
                            <a href="tooltip.html"><i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i> Tooltip &
                                Popover</a>
                        </li>
                        <li>
                            <a href="videos.html"><i class="ri-circle-fill circle-icon text-cyan w-auto"></i> Videos</a>
                        </li>
                        <li>
                            <a href="star-rating.html"><i class="ri-circle-fill circle-icon text-indigo w-auto"></i> Star Ratings</a>
                        </li>
                        <li>
                            <a href="tags.html"><i class="ri-circle-fill circle-icon text-purple w-auto"></i> Tags</a>
                        </li>
                        <li>
                            <a href="list.html"><i class="ri-circle-fill circle-icon text-red w-auto"></i> List</a>
                        </li>
                        <li>
                            <a href="calendar.html"><i class="ri-circle-fill circle-icon text-yellow w-auto"></i> Calendar</a>
                        </li>
                        <li>
                            <a href="radio.html"><i class="ri-circle-fill circle-icon text-orange w-auto"></i> Radio</a>
                        </li>
                        <li>
                            <a href="switch.html"><i class="ri-circle-fill circle-icon text-pink w-auto"></i> Switch</a>
                        </li>
                        <li>
                            <a href="image-upload.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Upload</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                        <span>Forms</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="form.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Input Forms</a>
                        </li>
                        <li>
                            <a href="form-layout.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Input
                                Layout</a>
                        </li>
                        <li>
                            <a href="form-validation.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Form
                                Validation</a>
                        </li>
                        <li>
                            <a href="wizard.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Form Wizard</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="mingcute:storage-line" class="menu-icon"></iconify-icon>
                        <span>Table</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="table-basic.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Basic
                                Table</a>
                        </li>
                        <li>
                            <a href="table-data.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Data Table</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="solar:pie-chart-outline" class="menu-icon"></iconify-icon>
                        <span>Chart</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="line-chart.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Line Chart</a>
                        </li>
                        <li>
                            <a href="column-chart.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Column
                                Chart</a>
                        </li>
                        <li>
                            <a href="pie-chart.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Pie Chart</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="widgets.html">
                        <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                        <span>Widgets</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                        <span>Users</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="users-list.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Users List</a>
                        </li>
                        <li>
                            <a href="users-grid.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Users Grid</a>
                        </li>
                        <li>
                            <a href="add-user.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add User</a>
                        </li>
                        <li>
                            <a href="view-profile.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> View
                                Profile</a>
                        </li>
                        <li>
                            <a href="users-role-permission.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> User
                                Role & Permission</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <i class="ri-user-settings-line text-xl me-14 d-flex w-auto"></i>
                        <span>Role & Access</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="role-access.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Role &
                                Access</a>
                        </li>
                        <li>
                            <a href="assign-role.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Assign
                                Role</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-menu-group-title">Application</li>

                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="simple-line-icons:vector" class="menu-icon"></iconify-icon>
                        <span>Authentication</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="sign-in.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Sign In</a>
                        </li>
                        <li>
                            <a href="sign-up.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Sign Up</a>
                        </li>
                        <li>
                            <a href="forgot-password.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Forgot
                                Password</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="solar:gallery-wide-linear" class="menu-icon"></iconify-icon>
                        <span>Gallery</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="gallery-grid.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Gallery
                                Grid</a>
                        </li>
                        <li>
                            <a href="gallery.html"><i class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Gallery Grid
                                Desc</a>
                        </li>
                        <li>
                            <a href="gallery-masonry.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Gallery
                                Masonry</a>
                        </li>
                        <li>
                            <a href="gallery-hover.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Gallery Hover
                                Effect</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="pricing.html">
                        <iconify-icon icon="hugeicons:money-send-square" class="menu-icon"></iconify-icon>
                        <span>Pricing</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <i class="ri-news-line text-xl me-14 d-flex w-auto"></i>
                        <span>Blog</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="blog.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Blog</a>
                        </li>
                        <li>
                            <a href="blog-details.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Blog
                                Details</a>
                        </li>
                        <li>
                            <a href="add-blog.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add Blog</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="testimonials.html">
                        <i class="ri-star-line text-xl me-14 d-flex w-auto"></i>
                        <span>Testimonial</span>
                    </a>
                </li>
                <li>
                    <a href="faq.html">
                        <iconify-icon icon="mage:message-question-mark-round" class="menu-icon"></iconify-icon>
                        <span>FAQs</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="streamline:straight-face" class="menu-icon"></iconify-icon>
                        <span>Error Pages</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="bad-request.html"><i class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Bad Request</a>
                        </li>
                        <li>
                            <a href="forbidden.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Forbidden</a>
                        </li>
                        <li>
                            <a href="error.html"><i class="ri-circle-fill circle-icon text-warning-600 w-auto"></i> 404 Page</a>
                        </li>
                        <li>
                            <a href="internal-server.html"><i class="ri-circle-fill circle-icon text-primary-main w-auto"></i> Internal
                                Server</a>
                        </li>
                        <li>
                            <a href="service-unavailable.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                                Service Unavailable</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="terms-condition.html">
                        <iconify-icon icon="octicon:info-24" class="menu-icon"></iconify-icon>
                        <span>Terms & Conditions</span>
                    </a>
                </li>
                <li>
                    <a href="coming-soon.html">
                        <i class="ri-rocket-line text-xl me-14 d-flex w-auto"></i>
                        <span>Coming Soon</span>
                    </a>
                </li>
                <li>
                    <a href="access-denied.html">
                        <i class="ri-folder-lock-line text-xl me-14 d-flex w-auto"></i>
                        <span>Access Denied</span>
                    </a>
                </li>
                <li>
                    <a href="maintenance.html">
                        <i class="ri-hammer-line text-xl me-14 d-flex w-auto"></i>
                        <span>Maintenance</span>
                    </a>
                </li>
                <li>
                    <a href="blank-page.html">
                        <i class="ri-checkbox-multiple-blank-line text-xl me-14 d-flex w-auto"></i>
                        <span>Blank Page</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                        <span>Settings</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="company.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Company</a>
                        </li>
                        <li>
                            <a href="notification.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                Notification</a>
                        </li>
                        <li>
                            Notification Alert</a>
                        </li>
                        <li>
                            <a href="theme.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Theme</a>
                        </li>
                        <li>
                            <a href="currencies.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Currencies</a>
                        </li>
                        <li>
                            <a href="language.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Languages</a>
                        </li>
                        <li>
                            <a href="payment-gateway.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Payment
                                Gateway</a>
                        </li>
                    </ul>
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
                            <button
                                class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"
                                type="button" data-bs-toggle="dropdown">
                                <iconify-icon icon="iconoir:bell" class="text-primary-light text-xl"></iconify-icon>
                            </button>
                            <div class="dropdown-menu to-top dropdown-menu-lg p-0">
                                <div
                                    class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                                    <div>
                                        <h6 class="text-lg text-primary-light fw-semibold mb-0">Notifications</h6>
                                    </div>
                                    <span
                                        class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center align-items-center">05</span>
                                </div>

                                <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
                                    <a href="javascript:void(0)"
                                        class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
                                        <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                                            <span
                                                class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                                <iconify-icon icon="bitcoin-icons:verify-outline" class="icon text-xxl"></iconify-icon>
                                            </span>
                                            <div>
                                                <h6 class="text-md fw-semibold mb-4">Congratulations</h6>
                                                <p class="mb-0 text-sm text-secondary-light text-w-200-px">Your profile has been Verified. Your
                                                    profile has been Verified</p>
                                            </div>
                                        </div>
                                        <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
                                    </a>

                                    <a href="javascript:void(0)"
                                        class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between bg-neutral-50">
                                        <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                                            <span
                                                class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                                <img src="<?= base_url('public'); ?>/assets/images/notification/profile-1.png" alt="Image">
                                            </span>
                                            <div>
                                                <h6 class="text-md fw-semibold mb-4">Ronald Richards</h6>
                                                <p class="mb-0 text-sm text-secondary-light text-w-200-px">You can stitch between artboards</p>
                                            </div>
                                        </div>
                                        <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
                                    </a>

                                    <a href="javascript:void(0)"
                                        class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
                                        <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                                            <span
                                                class="w-44-px h-44-px bg-info-subtle text-info-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                                AM
                                            </span>
                                            <div>
                                                <h6 class="text-md fw-semibold mb-4">Arlene McCoy</h6>
                                                <p class="mb-0 text-sm text-secondary-light text-w-200-px">Invite you to prototyping</p>
                                            </div>
                                        </div>
                                        <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
                                    </a>

                                    <a href="javascript:void(0)"
                                        class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between bg-neutral-50">
                                        <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                                            <span
                                                class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                                <img src="<?= base_url('public'); ?>/assets/images/notification/profile-2.png" alt="Image">
                                            </span>
                                            <div>
                                                <h6 class="text-md fw-semibold mb-4">Robiul Hasan</h6>
                                                <p class="mb-0 text-sm text-secondary-light text-w-200-px">Invite you to prototyping</p>
                                            </div>
                                        </div>
                                        <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
                                    </a>

                                    <a href="javascript:void(0)"
                                        class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
                                        <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                                            <span
                                                class="w-44-px h-44-px bg-info-subtle text-info-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                                DR
                                            </span>
                                            <div>
                                                <h6 class="text-md fw-semibold mb-4">Darlene Robertson</h6>
                                                <p class="mb-0 text-sm text-secondary-light text-w-200-px">Invite you to prototyping</p>
                                            </div>
                                        </div>
                                        <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
                                    </a>
                                </div>

                                <div class="text-center py-12 px-16">
                                    <a href="javascript:void(0)" class="text-primary-600 fw-semibold text-md">See All Notification</a>
                                </div>

                            </div>
                        </div><!-- Notification dropdown end -->

                        <div class="dropdown">
                            <button class="d-flex justify-content-center align-items-center rounded-circle" type="button"
                                data-bs-toggle="dropdown">
                                <img src="<?= base_url('public'); ?>/assets/images/user.png" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">
                            </button>
                            <div class="dropdown-menu to-top dropdown-menu-sm">
                                <div
                                    class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                                    <div>
                                        <h6 class="text-lg text-primary-light fw-semibold mb-2">Robiul Hasan</h6>
                                        <span class="text-secondary-light fw-medium text-sm">Admin</span>
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
            <!-- lightboxes -->
            <script src="<?= base_url('public'); ?>/assets/js/photoswipe.esm.js" type="module"></script>
            <script src="<?= base_url('public'); ?>/assets/js/photoswipe-lightbox.esm.js" type="module"></script>

            <link rel="stylesheet" href="https://unpkg.com/photoswipe@5/dist/photoswipe.css">

            <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe-lightbox.umd.min.js"></script>


            <!-- main js -->
            <script src="<?= base_url('public'); ?>/assets/js/app.js"></script>

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