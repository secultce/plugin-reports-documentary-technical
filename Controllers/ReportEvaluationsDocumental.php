<?php

namespace Report\Controllers;

require __DIR__ . './../vendor/autoload.php';
require_once PLUGINS_PATH . '/Report/lib/DomPdfLib.php';
require_once PLUGINS_PATH . '/Report/lib/PhpSpreadsheetLib.php';

use DomPdfLib;
use PhpSpreadsheetLib;
use MapasCulturais\App;
use MapasCulturais\i;

class ReportEvaluationsDocumental extends \MapasCulturais\Controller
{
    function _construct()
    {
        parent::_construct();
    }
    public function ALL_reportDocumental()
    {

        $app = App::i();
        $opportunityId = $this->data['id'];
        $fileFormat = isset($this->data['fileFormat']) ? $this->data['fileFormat'] : 'pdf';
        $reportName = "resultado-documental-oportunidade-$opportunityId";
        $excel = new PhpSpreadsheetLib();
        $dom = new DomPdfLib();
        if ($fileFormat == 'xls') {
            return $excel->GenerationExcel($reportName);
        }
        if ($fileFormat == 'pdf') {
            return  $dom->GenerationPDF($reportName);
        }
    }
}
