<?php

namespace App\Controllers;

use Config\Database;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function jurnalMedaliExcel()
    {
        // 1. PERBAIKAN: Ubah bentuk_pendidikan menjadi jenjang_id sesuai dengan frontend
        $kompetisi_id = $this->request->getGet('kompetisi_id');
        $jenjang_id = $this->request->getGet('jenjang_id');
        $search = $this->request->getGet('search');

        if (!$kompetisi_id || !$jenjang_id) {
            // Tampilkan error jika dibuka langsung di browser tanpa parameter
            die('Data tidak lengkap. Silakan lakukan export melalui halaman Jurnal Medali.');
        }

        // 2. PERBAIKAN: Samakan Query Builder dengan fungsi jurnal_medali_kab
        $builder = $this->db->table('atlet a')
            ->select("
                s.id AS sekolah_id,
                s.nama AS sekolah,
                COUNT(DISTINCT CASE WHEN p.prestasi='1' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) AS emas,
                COUNT(DISTINCT CASE WHEN p.prestasi='2' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) AS perak,
                COUNT(DISTINCT CASE WHEN p.prestasi='3' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) AS perunggu,
                (
                    COUNT(DISTINCT CASE WHEN p.prestasi='1' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) +
                    COUNT(DISTINCT CASE WHEN p.prestasi='2' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) +
                    COUNT(DISTINCT CASE WHEN p.prestasi='3' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END)
                ) AS total
            ")
            ->join('sekolah s', 's.id = a.sekolah_id')
            ->join('prestasi p', 'p.atlet_id = a.id AND p.kompetisi_id = ' . $this->db->escape($kompetisi_id), 'left')
            // JOIN ke tabel nomor_cabor khusus untuk mengecek status is_team dari prestasi yg diraih
            ->join('nomor_cabor nc_p', 'nc_p.id = p.nomor_cabor_id', 'left')
            ->join('nomor_cabor nc1', 'nc1.id = a.nomor_cabor_1', 'left')
            ->join('nomor_cabor nc2', 'nc2.id = a.nomor_cabor_2', 'left')
            ->join('nomor_cabor nc3', 'nc3.id = a.nomor_cabor_3', 'left')
            ->groupStart()
            ->where('nc1.jenjang_id', $jenjang_id)
            ->orWhere('nc2.jenjang_id', $jenjang_id)
            ->orWhere('nc3.jenjang_id', $jenjang_id)
            ->groupEnd()
            ->where('s.nama IS NOT NULL')
            ->groupBy('s.id, s.nama')
            ->get()
            ->getResultArray();

        // 3. Logika Sorting
        usort($builder, function ($a, $b) {
            return $b['emas'] <=> $a['emas']
                ?: $b['perak'] <=> $a['perak']
                ?: $b['perunggu'] <=> $a['perunggu'];
        });

        // 4. PERBAIKAN: Logika Ranking (Samakan dengan view, yang 0 dapat '-')
        $rank = 1;
        foreach ($builder as &$row) {
            if ($row['total'] > 0) {
                $row['ranking'] = $rank;
                $rank++;
            } else {
                $row['ranking'] = '-';
            }
        }
        unset($row);

        $data = $builder;

        if ($search) {
            $data = array_values(array_filter($data, function ($row) use ($search) {
                return stripos($row['sekolah'], $search) !== false;
            }));
        }

        /**
         * =========================
         * GENERATE EXCEL
         * =========================
         */
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul
        $sheet->setCellValue('A1', 'JURNAL PEROLEHAN MEDALI');
        $sheet->mergeCells('A1:F1'); // Ubah G1 jadi F1 karena total kolom cuma A-F
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Header
        $sheet->fromArray([
            'Peringkat',
            'Sekolah',
            'Emas',
            'Perak',
            'Perunggu',
            'Total',
        ], null, 'A3');

        $sheet->getStyle('A3:F3')->getFont()->setBold(true);
        // Tambahkan background untuk header
        $sheet->getStyle('A3:F3')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFD3D3D3');

        // Data
        $rowNum = 4;
        foreach ($data as $row) {
            $sheet->setCellValue("A{$rowNum}", $row['ranking']);
            $sheet->setCellValue("B{$rowNum}", $row['sekolah']);
            $sheet->setCellValue("C{$rowNum}", $row['emas']);
            $sheet->setCellValue("D{$rowNum}", $row['perak']);
            $sheet->setCellValue("E{$rowNum}", $row['perunggu']);
            $sheet->setCellValue("F{$rowNum}", $row['total']);

            // Perataan teks di tengah untuk kolom angka
            $sheet->getStyle("A{$rowNum}")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("C{$rowNum}:F{$rowNum}")->getAlignment()->setHorizontal('center');

            // Highlight podium HANYA jika rankingnya angka (1, 2, 3)
            if ($row['ranking'] === 1) {
                $sheet->getStyle("A{$rowNum}:F{$rowNum}")->getFill()->setFillType('solid')->getStartColor()->setARGB('FFFDE68A'); // emas
            } elseif ($row['ranking'] === 2) {
                $sheet->getStyle("A{$rowNum}:F{$rowNum}")->getFill()->setFillType('solid')->getStartColor()->setARGB('FFE5E7EB'); // perak
            } elseif ($row['ranking'] === 3) {
                $sheet->getStyle("A{$rowNum}:F{$rowNum}")->getFill()->setFillType('solid')->getStartColor()->setARGB('FFFED7AA'); // perunggu
            }

            $rowNum++;
        }

        // Auto width
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border untuk tabel
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle("A3:F" . ($rowNum - 1))->applyFromArray($styleArray);

        /**
         * =========================
         * OUTPUT FILE
         * =========================
         */
        $filename = 'Jurnal_Medali_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function jurnalMedaliPdf()
    {
        $kompetisi_id = $this->request->getGet('kompetisi_id');
        $jenjang_id   = $this->request->getGet('jenjang_id');
        $search       = $this->request->getGet('search');

        if (!$kompetisi_id || !$jenjang_id) {
            die('Data tidak lengkap.');
        }

        // =========================
        // QUERY
        // =========================
        // 2. PERBAIKAN: Samakan Query Builder dengan fungsi jurnal_medali_kab
        $builder = $this->db->table('atlet a')
            ->select("
                s.id AS sekolah_id,
                s.nama AS sekolah,
                COUNT(DISTINCT CASE WHEN p.prestasi='1' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) AS emas,
                COUNT(DISTINCT CASE WHEN p.prestasi='2' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) AS perak,
                COUNT(DISTINCT CASE WHEN p.prestasi='3' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) AS perunggu,
                (
                    COUNT(DISTINCT CASE WHEN p.prestasi='1' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) +
                    COUNT(DISTINCT CASE WHEN p.prestasi='2' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END) +
                    COUNT(DISTINCT CASE WHEN p.prestasi='3' THEN IF(nc_p.is_team = '1', p.nomor_cabor_id, p.id) END)
                ) AS total
            ")
            ->join('sekolah s', 's.id = a.sekolah_id')
            ->join('prestasi p', 'p.atlet_id = a.id AND p.kompetisi_id = ' . $this->db->escape($kompetisi_id), 'left')
            // JOIN ke tabel nomor_cabor khusus untuk mengecek status is_team dari prestasi yg diraih
            ->join('nomor_cabor nc_p', 'nc_p.id = p.nomor_cabor_id', 'left')
            ->join('nomor_cabor nc1', 'nc1.id = a.nomor_cabor_1', 'left')
            ->join('nomor_cabor nc2', 'nc2.id = a.nomor_cabor_2', 'left')
            ->join('nomor_cabor nc3', 'nc3.id = a.nomor_cabor_3', 'left')
            ->groupStart()
            ->where('nc1.jenjang_id', $jenjang_id)
            ->orWhere('nc2.jenjang_id', $jenjang_id)
            ->orWhere('nc3.jenjang_id', $jenjang_id)
            ->groupEnd()
            ->where('s.nama IS NOT NULL')
            ->groupBy('s.id, s.nama')
            ->get()
            ->getResultArray();

        // 3. Logika Sorting
        usort($builder, function ($a, $b) {
            return $b['emas'] <=> $a['emas']
                ?: $b['perak'] <=> $a['perak']
                ?: $b['perunggu'] <=> $a['perunggu'];
        });

        // 4. PERBAIKAN: Logika Ranking (Samakan dengan view, yang 0 dapat '-')
        $rank = 1;
        foreach ($builder as &$row) {
            if ($row['total'] > 0) {
                $row['ranking'] = $rank;
                $rank++;
            } else {
                $row['ranking'] = '-';
            }
        }
        unset($row);

        $data = $builder;

        if ($search) {
            $data = array_values(array_filter($data, function ($row) use ($search) {
                return stripos($row['sekolah'], $search) !== false;
            }));
        }

        // =========================
        // HTML PDF
        // =========================
        $html = '
        <h2 style="text-align:center">JURNAL PEROLEHAN MEDALI</h2>

        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <thead>
                <tr style="background:#ddd;font-weight:bold;">
                    <th>Peringkat</th>
                    <th>Sekolah</th>
                    <th>Emas</th>
                    <th>Perak</th>
                    <th>Perunggu</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($data as $row) {

            $bg = '';

            if ($row['ranking'] == 1) {
                $bg = 'background:#fde68a;';
            } elseif ($row['ranking'] == 2) {
                $bg = 'background:#e5e7eb;';
            } elseif ($row['ranking'] == 3) {
                $bg = 'background:#fed7aa;';
            }

            $html .= '
            <tr style="' . $bg . '">
                <td align="center">' . $row['ranking'] . '</td>
                <td>' . $row['sekolah'] . '</td>
                <td align="center">' . $row['emas'] . '</td>
                <td align="center">' . $row['perak'] . '</td>
                <td align="center">' . $row['perunggu'] . '</td>
                <td align="center">' . $row['total'] . '</td>
            </tr>';
        }

        $html .= '
            </tbody>
        </table>';

        // =========================
        // DOMPDF
        // =========================
        $dompdf = new \Dompdf\Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Tambahkan ini sebelum melakukan stream/download
        if (ob_get_length() > 0) {
            ob_clean();
        }

        $dompdf->stream(
            'Jurnal_Medali_' . date('Ymd_His') . '.pdf',
            ['Attachment' => true]
        );
        exit;
    }
}
