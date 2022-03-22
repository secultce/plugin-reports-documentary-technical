<?php

require __DIR__ . './../vendor/autoload.php';


use Dompdf\Dompdf;

class DomPdfLib
{
    public function GenerationPDF($reportName)
    {
        $dompdf = new Dompdf(["enable_remote" => true]);

        $dompdf->loadHtml("<h1>Olá mundo</h1>");

        ob_start();
        require __DIR__ . './../layouts/parts/contents/DocumentalPDF.php';
        //require __DIR__ . '../layouts/parts/contents/DocumentalPDF.php';
        $dompdf->loadHtml(ob_get_clean());

        $dompdf->setPaper("A2", 'ladscape');

        $dompdf->render();

        $dompdf->stream($reportName);
    }
}
