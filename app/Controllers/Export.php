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
        $kompetisi_id = $this->request->getGet('kompetisi_id');
        $bentuk_pendidikan = $this->request->getGet('bentuk_pendidikan');
        $search = $this->request->getGet('search');

        if (!$kompetisi_id || !$bentuk_pendidikan) {
            return $this->response->setJSON(['error' => 'Data tidak lengkap'])->setStatusCode(400);
        }

        $builder = $this->db->table('peserta p')
            ->select("s.id AS sekolah_id, s.nama AS sekolah,
                    SUM(CASE WHEN p.prestasi='1' THEN 1 ELSE 0 END) AS emas,
                    SUM(CASE WHEN p.prestasi='2' THEN 1 ELSE 0 END) AS perak,
                    SUM(CASE WHEN p.prestasi='3' THEN 1 ELSE 0 END) AS perunggu,
                    SUM(CASE WHEN p.prestasi IN ('1','2','3') THEN 1 ELSE 0 END) AS total")
            ->join('atlet a', 'a.id = p.atlet_id', 'left')
            ->join('sekolah s', 's.id = a.sekolah_id', 'left')
            ->where('p.kompetisi_id', $kompetisi_id)
            ->where('s.bentuk_pendidikan', $bentuk_pendidikan)
            ->groupBy('s.id, s.nama')
            ->get()
            ->getResultArray();


        // Ranking di PHP
        usort($builder, function ($a, $b) {
            return $b['emas'] <=> $a['emas'] ?: $b['perak'] <=> $a['perak'] ?: $b['perunggu'] <=> $a['perunggu'];
        });

        foreach ($builder as $i => &$row) {
            $row['ranking'] = $i + 1;
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
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul
        $sheet->setCellValue('A1', 'JURNAL PEROLEHAN MEDALI');
        $sheet->mergeCells('A1:G1');
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

        // Data
        $rowNum = 4;
        foreach ($data as $row) {
            $sheet->setCellValue("A{$rowNum}", $row['ranking']);
            $sheet->setCellValue("B{$rowNum}", $row['sekolah']);
            $sheet->setCellValue("C{$rowNum}", $row['emas']);
            $sheet->setCellValue("D{$rowNum}", $row['perak']);
            $sheet->setCellValue("E{$rowNum}", $row['perunggu']);
            $sheet->setCellValue("F{$rowNum}", $row['total']);

            // Highlight podium
            if ($row['ranking'] == 1) {
                $sheet->getStyle("A{$rowNum}:F{$rowNum}")
                    ->getFill()->setFillType('solid')
                    ->getStartColor()->setARGB('FFFDE68A'); // emas
            } elseif ($row['ranking'] == 2) {
                $sheet->getStyle("A{$rowNum}:F{$rowNum}")
                    ->getFill()->setFillType('solid')
                    ->getStartColor()->setARGB('FFE5E7EB'); // perak
            } elseif ($row['ranking'] == 3) {
                $sheet->getStyle("A{$rowNum}:F{$rowNum}")
                    ->getFill()->setFillType('solid')
                    ->getStartColor()->setARGB('FFFED7AA'); // perunggu
            }

            $rowNum++;
        }

        // Auto width
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        /**
         * =========================
         * OUTPUT FILE
         * =========================
         */
        $filename = 'Jurnal_Medali_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
