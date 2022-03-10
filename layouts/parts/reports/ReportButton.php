<?php

use MapasCulturais\App;
use MapasCulturais\i;

$route = App::i()->createUrl('reportEvaluationDocumental', 'reportDocumental', [$entity->id]);

?>

<!--botão de imprimir-->
<a class="btn btn-default download" ng-click="editbox.open('report-evaluation-documental-options', $event)" rel="noopener noreferrer">Imprimir Resultado Documental</a>

<!-- Formulário -->
<edit-box id="report-evaluation-documental-options" position="top" title="<?php i::esc_attr_e('Imprimir Result') ?>" cancel-label="Cancelar" close-on-cancel="true">
    <form class="form-report-evaluation-documental-options" action="<?= $route ?>" method="POST">
        <label for="from">Formato</label>
        <select name="fileFormat" id="fileFormat">
            <option value="pdf" selected>PDF</option>
            <!-- <option value="xls">XLS</option> -->
            <!-- <option value="docx">DOC</option> -->
        </select>
        <button class="btn btn-primary download" type="submit">Imprimir Resultado</button>
    </form>
</edit-box>