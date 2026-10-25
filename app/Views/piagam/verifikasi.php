<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Verifikasi Piagam'); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0077B6;
            --secondary: #00A3E0;
            --accent: #8A2BE2;
            --success: #10b981;
            --danger: #ef4444;
            --bg-color: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border-top: 5px solid var(--primary);
        }

        .header {
            text-align: center;
            padding: 24px 20px 10px;
        }

        .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .logos img {
            height: 50px;
            width: auto;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .status-valid {
            background-color: #d1fae5;
            color: var(--success);
            border: 1px solid #10b981;
        }

        .status-invalid {
            background-color: #fee2e2;
            color: var(--danger);
            border: 1px solid #ef4444;
        }

        .profile-section {
            text-align: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--secondary);
            margin-bottom: 10px;
            background-color: #e2e8f0;
        }

        .profile-name {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 5px;
        }

        .data-list {
            padding: 20px;
        }

        .data-item {
            margin-bottom: 16px;
        }

        .data-item:last-child {
            margin-bottom: 0;
        }

        .data-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 4px;
        }

        .data-value {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-main);
        }

        .achievement-highlight {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-top: 20px;
        }

        .achievement-highlight .data-label {
            color: #e0f2fe;
        }

        .achievement-highlight .data-value {
            color: #ffffff;
            font-size: 18px;
            font-weight: 700;
        }

        .footer {
            text-align: center;
            padding: 15px 20px;
            background-color: #f1f5f9;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* SVG Icons */
        .icon {
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">

            <div class="header">
                <div class="logos">
                    <img src="<?= base_url('public/assets/images/logo_bna.png'); ?>" alt="Logo Banjarnegara">
                    <img src="<?= base_url('public/assets/images/logo.jpeg'); ?>" alt="Logo SILAGAPORA">
                </div>
                <h2 style="font-size: 18px; margin: 0 0 15px;">Verifikasi Sertifikat Elektronik</h2>

                <?php if (!empty($data)): ?>
                    <div class="status-badge status-valid">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        DOKUMEN VALID & SAH
                    </div>
                <?php else: ?>
                    <div class="status-badge status-invalid">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        DATA TIDAK DITEMUKAN
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($data)): ?>
                <div class="profile-section">
                    <?php
                    $foto = !empty($data['file_foto']) ? base_url('public/uploads/atlet/file_foto/' . esc($data['file_foto'])) : base_url('public/assets/images/default-avatar.png');
                    ?>
                    <img src="<?= $foto ?>" alt="Foto Atlet" class="profile-img">
                    <h3 class="profile-name"><?= esc($data['nama_atlet']); ?></h3>
                </div>

                <div class="data-list">
                    <div class="data-item">
                        <div class="data-label">Event / Kompetisi</div>
                        <div class="data-value"><?= esc($data['nama_kompetisi']); ?></div>
                    </div>

                    <div class="data-item">
                        <div class="data-label">Cabang Olahraga</div>
                        <div class="data-value"><?= esc($data['nama_cabor']); ?></div>
                    </div>

                    <div class="data-item">
                        <div class="data-label">Nomor Perlombaan</div>
                        <div class="data-value"><?= esc($data['nama_nomor']); ?></div>
                    </div>

                    <div class="achievement-highlight">
                        <div class="data-label">Pencapaian Prestasi</div>
                        <div class="data-value">Juara <?= esc($data['prestasi']); ?></div>
                    </div>
                </div>
            <?php else: ?>
                <div style="padding: 20px; text-align: center; color: var(--text-muted); font-size: 14px;">
                    <p>Mohon maaf, dokumen piagam dengan ID tersebut tidak terdaftar di dalam sistem database SILAGAPORA Banjarnegara atau telah dicabut.</p>
                </div>
            <?php endif; ?>

            <div class="footer">
                SILAGAPORA<br>
                Dinas Pendidikan, Kepemudaan dan Olahraga Kabupaten Banjarnegara &copy; <?= date('Y'); ?>
            </div>

        </div>
    </div>

</body>

</html>