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

    public function generate_pdf($id_peserta)
    {
        $decoded_id_peserta = decode_id($id_peserta);
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
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Tampilkan PDF
        return $dompdf->stream("peserta_$id_peserta.pdf", ["Attachment" => false]);
    }
}
