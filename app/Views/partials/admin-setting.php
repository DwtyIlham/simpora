<?php
/**
 * Partial: Halaman Setting Admin
 * Digunakan oleh admin dan validator.
 *
 * Variabel yang diharapkan:
 *   $title   -> Judul halaman
 *   $setting -> Array data setting (id, nama, status)
 *   $toggleUrl -> URL endpoint toggle status (POST)
 */

?>
<style>
    .custom-switch {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .custom-switch input {
        position: relative;
        width: 50px;
        height: 26px;
        -webkit-appearance: none;
        background-color: #ccc;
        outline: none;
        border-radius: 50px;
        transition: background-color 0.3s;
        cursor: pointer;
    }

    .custom-switch input::before {
        content: '';
        position: absolute;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        background-color: #fff;
        transition: transform 0.3s;
    }

    .custom-switch input:checked {
        background-color: #198754;
    }

    .custom-switch input:checked::before {
        transform: translateX(24px);
    }

    .custom-switch label {
        cursor: pointer;
        user-select: none;
        color: #212529;
    }
</style>

<?php
$_settingRoleId = (string) (session('user')['role_id'] ?? '');
$_settingDashboard = $_settingRoleId === '1' ? base_url('/dashboard') : ($_settingRoleId === '4' ? base_url('validator/dashboard') : base_url('sekolah/dashboard'));
?>
<?= $this->include('partials/page-header', [
    'pageTitle' => $title ?? 'Setting Sistem',
    'breadcrumb' => [
        ['label' => 'Dashboard', 'href' => $_settingDashboard, 'icon' => 'solar:home-smile-angle-outline'],
        ['label' => esc($title ?? 'Setting'), 'href' => null, 'icon' => 'material-symbols:settings-outline'],
    ],
    'actions' => [],
]); ?>

<div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
    <div id="settingToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">Notifikasi</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><?= esc($title ?? 'Setting Sistem'); ?></h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table bordered-table mb-0" id="settingTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">No.</th>
                            <th class="text-center" scope="col">Nama</th>
                            <th class="text-center" scope="col">Status</th>
                            <th class="text-center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($setting ?? [] as $s): ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td><?= esc($s['nama']); ?></td>
                                <td class="text-center align-middle">
                                    <div class="custom-switch text-center">
                                        <input
                                            type="checkbox"
                                            id="status-<?= esc($s['id']); ?>"
                                            class="toggle-status mx-auto"
                                            data-id="<?= esc($s['id']); ?>"
                                            <?= $s['status'] == '1' ? 'checked' : ''; ?>>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </td>
                            </tr>
                            <?php $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        let table = new DataTable('#settingTable', { responsive: true });

        function updateLabel(checkbox) {
            if (checkbox.is(':checked')) {
                checkbox.next('.form-check-label').text('Aktif').removeClass('text-danger').addClass('text-success');
            } else {
                checkbox.next('.form-check-label').text('Tidak Aktif').removeClass('text-success').addClass('text-danger');
            }
        }

        function showToast(message, type = 'success') {
            const toastEl = document.getElementById('settingToast');
            toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning');
            toastEl.classList.add(type === 'success' ? 'bg-success' : (type === 'error' ? 'bg-danger' : 'bg-warning'));
            toastEl.querySelector('.toast-body').textContent = message;
            new bootstrap.Toast(toastEl, { delay: 3000 }).show();
        }

        $(document).on('change', '.toggle-status', function() {
            const checkbox = $(this);
            const id = checkbox.data('id');
            const originalState = !checkbox.is(':checked');

            updateLabel(checkbox);

            $.ajax({
                url: '<?= esc($toggleUrl ?? site_url('api/toggle_admin_setting')); ?>',
                type: 'POST',
                data: { id: id, status: checkbox.is(':checked') ? '1' : '0' },
                success: function(response) {
                    let res;
                    try { res = typeof response === 'string' ? JSON.parse(response) : response; } catch (e) { res = {}; }
                    if (res?.success) {
                        updateLabel(checkbox);
                        showToast('Status berhasil diupdate', 'success');
                    } else {
                        checkbox.prop('checked', originalState);
                        updateLabel(checkbox);
                        showToast('Gagal update status', 'error');
                    }
                },
                error: function() {
                    checkbox.prop('checked', originalState);
                    updateLabel(checkbox);
                    showToast('Terjadi kesalahan server', 'error');
                }
            });
        });
    });
</script>
