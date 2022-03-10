<?php

namespace Report\Controllers;

require __DIR__ . './../vendor/autoload.php';




require_once PLUGINS_PATH . '/Report/lib/DomPdfLib.php';

use Dompdf\Dompdf;
use DomPdfLib;
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
        $dom = new DomPdfLib();
        return $dom->GenerationPDF();
    }
}
