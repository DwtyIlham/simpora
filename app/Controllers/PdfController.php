<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PesertaModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends BaseController
{

    protected $m_peserta;

    public function __construct()
    {
        $this->m_peserta = new PesertaModel();
    }

    private function getNamaPeserta($id_peserta)
    {
        return $this->m_peserta->getDataPeserta($id_peserta);
    }

    public function generate_pdf($id_peserta)
    {
        $decoded_id_peserta = decode_id($id_peserta);
        $nama_peserta = $this->getNamaPeserta($decoded_id_peserta)['atlet_nama'];
        $url_verifikasi = site_url('api/verifikasi-piagam/' . $id_peserta);
        // Ambil data peserta
        $data = [
            'data'  => $this->m_peserta->getDataPeserta($decoded_id_peserta),
            'qrUrl' => 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode($url_verifikasi)
        ];

        // Opsi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

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
}
