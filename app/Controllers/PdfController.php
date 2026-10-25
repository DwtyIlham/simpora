<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PesertaModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends BaseController
{

    protected $m_peserta;
    protected $db;

    public function __construct()
    {
        $this->m_peserta = new PesertaModel();
        $this->db = db_connect();
    }

    private function getNamaPeserta($id_prestasi)
    {
        return $this->m_peserta->getDataPeserta($id_prestasi);
    }

    public function generate_pdf($id_prestasi)
    {
        $decoded_id_prestasi = decode_id($id_prestasi);
        $nama_peserta = $this->getNamaPeserta($decoded_id_prestasi)['atlet_nama'];
        $url_verifikasi = site_url('api/verifikasi-piagam/' . $id_prestasi);
        // Ambil data peserta
        $data = [
            'data'  => $this->m_peserta->getDataPeserta($decoded_id_prestasi),
            'qrUrl' => 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode($url_verifikasi)
        ];

        // Opsi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        // $options->set('chroot', FCPATH);

        $dompdf = new Dompdf($options);

        // Render HTML dari view (kembalikan sebagai string)
        $html = view('piagam/piagam', $data);

        // Load HTML
        $dompdf->loadHtml($html);

        // Atur ukuran dan orientasi
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF
        $dompdf->render();

        // Ambil output PDF
        $output = $dompdf->output();

        // Return sebagai response CI4
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader(
                'Content-Disposition',
                'inline; filename="Piagam Peserta POPDA 2026 - ' . $nama_peserta . '.pdf"'
            )
            ->setBody($output);
    }

    public function piagam_batch($nomor_cabor_id)
    {
        $url_verifikasi = site_url('api/verifikasi-piagam/' . $nomor_cabor_id);
        // Ambil data peserta
        $data = [
            'data'  => $this->m_peserta->getDataPesertaBatch($nomor_cabor_id),
            'qrUrl' => 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode($url_verifikasi)
        ];

        $nama_nomor_cabor = $data['data'][0]['cabor_nama'] . ' ' . $data['data'][0]['nomor_lomba'];

        // Opsi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // Render HTML dari view (kembalikan sebagai string)
        $html = view('piagam/piagam-batch', $data);

        // Load HTML
        $dompdf->loadHtml($html);

        // Atur ukuran dan orientasi
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF
        $dompdf->render();

        // Ambil output PDF
        $output = $dompdf->output();

        // Return sebagai response CI4
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader(
                'Content-Disposition',
                'attachment; filename="Piagam Peserta POPDA 2026 - ' . $nama_nomor_cabor . '.pdf"'
            )
            ->setBody($output);
    }
}
