<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    public function export($html, $filename = 'document.pdf')
    {
        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Load HTML
        $dompdf->loadHtml($html);

        // Set ukuran dan orientasi kertas
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Stream PDF ke browser
        $dompdf->stream($filename, array("Attachment" => true));
    }
}
