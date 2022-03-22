<?php

require __DIR__ . './../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Html;

class PhpSpreadsheetLib
{
    public function GenerationExcel($reportName)
    {
        $spreadsheet = new Spreadsheet();
        $reader = new Html();
        ob_start();
        require __DIR__ . './../layouts/parts/contents/DocumentalPDF.php';
        $spreadsheet = $reader->loadFromString(ob_get_clean());
        $filename = $reportName . ".xls";
        $filePath = fopen(__DIR__ . DIRECTORY_SEPARATOR . $filename, 'w');
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save($filePath);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        unlink($filePath);
    }
}
