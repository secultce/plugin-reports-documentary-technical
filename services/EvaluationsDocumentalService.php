<?php



use MapasCulturais\App;
use MapasCulturais\i;

class EvaluationsDocumentalService
{
    public function DataOportunityReport()
    {

        $app = App::i();
        $controllerData = App::i()->getController('reportEvaluationDocumental');
        $opportunityId = $controllerData->urlData['id'];
        $sql_query = "
            select
                r.opportunity_id as id_oportunidade,
                UPPER(op.name) as nome_da_oportunidade,
                r.id as id_inscricao,
                r.number as num_inscricao,
                rm_project_name.value as projeto,
                case
                    when upper(r.agents_data::jsonb->'owner'->>'nomeCompleto') is null then upper(am.value)
                    when upper(r.agents_data::jsonb->'owner'->>'nomeCompleto') = '' then upper(am.value) 
                    else upper(r.agents_data::jsonb->'owner'->>'nomeCompleto')
                end as proponente,
                upper(r.category) as categoria,
                upper(r.agents_data::jsonb->'owner'->>'En_Municipio') as municipio,
                re.evaluation_data as evaluation_data
            from 
                public.registration as r
                    inner join public.registration_meta as rm_project_name 
                        on rm_project_name.object_id = r.id
                        and rm_project_name.key = 'projectName'
                    left join public.registration_evaluation as re
                        on re.registration_id = r.id
                    left join public.opportunity as op
                        on op.id = r.opportunity_id
                    inner join public.agent_meta as am
                        on am.object_id = r.agent_id
                        and am.key = 'nomeCompleto'
            where 
                opportunity_id = {$opportunityId}
	            and r.status in (10,2,3,11,4, 5, 6, 12)
        ";
        $stmt = $app->em->getConnection()->prepare($sql_query);
        $stmt->execute();
        $evaluations = $stmt->fetchAll();
        $today = date("d-m-Y H:i:s");
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
                while ($item->evaluation == 'invalid') {
                    $r = $item->evaluation;
                    break;
                }
                return $r;
            });
            $reason = (string) array_reduce($data, function ($motivos,  $item) {
                if ($item->evaluation == 'invalid') {
                    $motivos .= trim($item->obs_items);
                }
                return $motivos;
            });
            $finishResult = ($result == 'invalid') ? 'INABILITADO' : 'HABILITADO';
            $categoria = $e['categoria'];

            $data_array_oportunity[] = [
                //'format_file' => $formatFile,
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
        return $data_array_oportunity;
    }
}
