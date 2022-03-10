<?php

require __DIR__ . './../vendor/autoload.php';


use Dompdf\Dompdf;

class DomPdfLib
{
    public function GenerationPDF()
    {
        $dompdf = new Dompdf(["enable_remote" => true]);

        $dompdf->loadHtml("<h1>Olá mundo</h1>");

        ob_start();
        require __DIR__ . './../contents/DocumentalPDF.php';
        $dompdf->loadHtml(ob_get_clean());

        $dompdf->setPaper("A3", 'ladscape');

        $dompdf->render();

        $dompdf->stream("file.pdf");
    }
}
