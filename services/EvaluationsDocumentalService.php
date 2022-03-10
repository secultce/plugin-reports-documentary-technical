<?php
require_once PLUGINS_PATH . '/Report/database/DocumentalDB.php';

use DocumentalDB;
use MapasCulturais\App;
use MapasCulturais\i;

class EvaluationsDocumentalService
{
    public function DataOportunityReport()
    {
        $app = App::i();

        $formatFile = isset($this->data['fileFormat']) ? $this->data['fileFormat'] : 'pdf';
        date_default_timezone_set('America/Fortaleza');
        $today = date("d-m-Y H:i:s");
        $opportunityId = (int) $this->data['id'];
        $documentalDB = new DocumentalDB();
        $evaluations = $documentalDB->OpportuntyReport($opportunityId);
        $data_array_oportunity = [];
        foreach ($evaluations as $e) {
            $opportunity_name = $e['nome_da_oportunidade'];
            $registration = $e['id_inscricao'];
            $nameParcipant = $e['proponente'];
            $city = $e['municipio'];
            $evaluationData = $e['evaluation_data'];
            $data = (array)json_decode($evaluationData);
            $projectName = $e['projeto'];
            $result = (string) array_reduce($data, function ($r, $item) {
                return $item->evaluation;
            });
            $reason = (string) array_reduce($data, function ($motivos,  $item) {
                if ($item->evaluation == 'invalid') {
                    $motivos .= trim($item->obs_items);
                }
                return $motivos;
            });
            $finishResult = ($result == 'valid') ? 'HABILITADO' : 'INABILITADO';
            $categoria = $e['categoria'];

            $data_array_oportunity[] = [
                'format_file' => $formatFile,
                'data_relatorio' => $today,
                'id_oportunidade' => $opportunityId,
                'nome_da_oportunidade' => $opportunity_name,
                'n_inscricao' => $registration,
                'projeto' => $projectName,
                'proponente' => $nameParcipant,
                'categoria' => $categoria,
                'municipio' => $city,
                'resultado' => $finishResult,
                'motivo_inabilitacao' => $reason,
            ];
        }
        var_dump($data_array_oportunity);
        return $data_array_oportunity;
    }
}
