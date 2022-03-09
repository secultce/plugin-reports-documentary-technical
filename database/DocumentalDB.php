<?php

use MapasCulturais\App;
use MapasCulturais\i;

class DocumentalDB
{
    public function OpportuntyReport($opportunity_id)
    {
        $app = App::i();

        $sql_query = "
        select
            r.opportunity_id as id_oportunidade,
            op.name as nome_da_oportunidade,
            r.id as id_inscricao,
            r.number as num_inscricao,
            rm_project_name.value as projeto,
            upper(r.agents_data::jsonb->'owner'->>'nomeCompleto') as proponente,
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
        where 
            opportunity_id = {$opportunity_id}
            and number in ('on-357038849','on-2092146441')
    
        ";
        $stmt = $app->em->getConnection()->prepare($sql_query);
        $stmt->execute();
        $query = $stmt->fetchAll();
        return $query;
    }
}
