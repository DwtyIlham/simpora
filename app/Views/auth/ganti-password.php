<?php

use CodeIgniter\Database\BaseUtils;

use function App\Controllers\isAdmin;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0"><?= $title; ?></h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="javascript:void()" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                <?= $title; ?>
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium"><?= APP_NAME; ?></li>
    </ul>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0"><?= $title; ?></h5>
        </div>
        <form id="form_change_pw" method="post">
            <div class="card-body">
                <div class="row gy-3">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                    <div class="col-4">
                        <label class="form-label">Password Saat Ini</label>
                        <div class="position-relative mb-20">
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y">
                                    <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                </span>
                                <input type="password" name="current_password" class="form-control h-56-px bg-neutral-50 radius-12" id="c-password" placeholder="Password Lama" required>
                            </div>
                            <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#c-password"></span>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Password Baru</label>
                        <div class="position-relative mb-20">
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y">
                                    <iconify-icon icon="solar:lock-password-line-duotone"></iconify-icon>
                                </span>
                                <input type="password" name="new_password" class="form-control h-56-px bg-neutral-50 radius-12" id="n1-password" placeholder="Password Baru" required>
                            </div>
                            <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#n1-password"></span>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="position-relative mb-20">
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y">
                                    <iconify-icon icon="solar:lock-password-line-duotone"></iconify-icon>
                                </span>
                                <input type="password" name="confirm_password" class="form-control h-56-px bg-neutral-50 radius-12" id="n2-password" placeholder="Konfirmasi Password Baru" required>
                            </div>
                            <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#n2-password"></span>
                        </div>
                    </div>
                </div>

                <div class="mt-12">
                    <button type="submit" class="btn btn-warning-600"><i class="ri ri-save-line"></i> Ganti Password</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Form Submit Handler
    $('#form_change_pw').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: "POST",
            url: "<?= site_url('admin/ganti-password-attempt'); ?>",
            data: form.serialize(),
            dataType: "json",
            beforeSend: function() {
                form.find('button[type="submit"]').prop('disabled', true).html('<i class="ri ri-loader-4-line ri-spin-line"></i> Processing...');
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
                });
            },
            complete: function() {
                form.find('button[type="submit"]').prop('disabled', false).html('<i class="ri ri-save-line"></i> Ganti Password');
            }
        });
    });

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

</script>

<?= $this->endSection(); ?>