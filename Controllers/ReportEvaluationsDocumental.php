<?php

namespace Report\Controllers;

require_once PLUGINS_PATH . '/Report/services/ReportLib.php';
require_once PLUGINS_PATH . '/Report/services/GenerationJSONFile.php';
require_once PLUGINS_PATH . '/Report/database/DocumentalDB.php';

use MapasCulturais\App;
use MapasCulturais\i;
use ReportLib;
use GenerationJSONFile;
use DocumentalDB;

class ReportEvaluationsDocumental extends \MapasCulturais\Controller
{
    function _construct()
    {
        parent::_construct();
    }
    public function ALL_reportDocumental()
    {


        $app = App::i();

        $opportunityId = (int) $this->data['id'];
        $format = isset($this->data['fileFormat']) ? $this->data['fileFormat'] : 'pdf';
        $date = isset($this->data['publishDate']) ? $this->data['publishDate'] : date("d/m/Y");
        $datePublish = date("d/m/Y", strtotime($date));
        $opportunity =  $app->repo("Opportunity")->find($opportunityId);

        $doc = new DocumentalDB();

        $evaluations = $doc->OpportuntyReport(32123);

        $json_array = [];
        foreach ($evaluations as $e) {

            $registration = $e['id_inscricao'];
            $evaluationData = $e['evaluation_data'];
            $resultado = (array)json_decode($evaluationData);
            $projectName = $e['projeto'];
            $descumprimentoDosItens = (string) array_reduce($resultado, function ($motivos, $item) {
                if ($item->evaluation == 'invalid') {
                    $motivos .= trim($item->obs_items);
                }

                return $motivos;
            });

            $categoria = $registration->category;
            $agentRelations = $app->repo('RegistrationAgentRelation')->findBy(['owner' => $registration]);
            $coletivo = null;
            if ($agentRelations) {
                $coletivo = $agentRelations[0]->agent->nomeCompleto;
            }
            $proponente = $registration->owner->nomeCompleto;
            if (strpos($categoria, 'JURÍDICA') && $coletivo !== null) {
                $proponente = $coletivo;
            }
            $json_array[] = [
                'n_inscricao' => $registration->number,
                'projeto' => $projectName,
                'proponente' => trim($proponente),
                'categoria' => $categoria,
                'municipio' => trim($registration->owner->En_Municipio),
                //'resultado' => ($result == 'Válida') ? 'HABILITADO' : 'INABILITADO',
                'motivo_inabilitacao' => $descumprimentoDosItens,
            ];
        }

        $publish = (array)$app->repo("Opportunity")->findOpportunitiesWithDateByIds($opportunityId);
        $driver = 'json';
        $data_divulgacao = $datePublish;
        $nome_edital = $publish[0]['name'];
        $query = null;
        $params = [
            "data_divulgacao" => $data_divulgacao,
            "nome_edital" => $nome_edital,
        ];
    }
}
