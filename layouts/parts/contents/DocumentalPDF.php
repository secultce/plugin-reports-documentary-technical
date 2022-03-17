<?php

require_once PLUGINS_PATH . '/Report/services/EvaluationsDocumentalService.php';

use EvaluationsDocumentalService as DocumentalService;
use MapasCulturais\App;
use MapasCulturais\i;

$evaluationsDocumentalService = new DocumentalService();
$evaluationsData = $evaluationsDocumentalService->DataOportunityReport();
?>
<html>

<head>
    <style>
        #customers {
            font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #245e55;
            color: white;
        }

        td {
            word-wrap: break-word;
            FONT-SIZE: 12PX;
        }

        #cabecalho {
            text-align: center;
        }

        #cabecalho h5 {
            font: -webkit-control;
            font-size: inherit;
            font-weight: revert;
            font-size: 15px;
        }

        img.img-responsive {
            margin-left: 80%;
            margin-top: -153px;
        }
    </style>
</head>

<body>
    <div id="cabecalho">
        <p>Impresso em: <?php echo $evaluationsData[0]['data_relatorio'] ?></p>
        <h5 style="margin: 10px">
            RESULTADO PRELIMINAR DA HABILITAÇÃO DA INSCRIÇÃO
        </h5>
        <h5 style="margin: 10px"><?php echo $evaluationsData[0]['nome_da_oportunidade'] ?></h5>
        <h5 style="margin: 10px">LISTA DE HABILITADOS E NÃO HABILITADOS</h5>
        <!-- <img class="img-responsive" alt="" src="https://mapacultural.secult.ce.gov.br/files/secult.png" /> -->
    </div>
    <div>

        <table id="customers">
            <thead>
                <tr>
                    <!-- <th>Nº</th> -->
                    <th>Nº de Inscrição</th>
                    <th>Projeto</th>
                    <th>Proponente</th>
                    <th>Categoria</th>
                    <th>Município</th>
                    <th>Resultado</th>
                    <th>Motivo da Inabilitação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($evaluationsData as $r) :
                    $n_inscricao = $r['n_inscricao'];
                    $projeto = $r['projeto'];
                    $proponente = $r['proponente'];
                    $categoria = $r['categoria'];
                    $municipio = $r['municipio'];
                    $resultado = $r['resultado'];
                    $motivo_inabilitacao = $r['motivo_inabilitacao'];
                ?>
                    <tr>

                        <!-- <td>1</td> -->
                        <td>
                            <?php echo $n_inscricao ?>
                        </td>
                        <td><?php echo $projeto ?></td>
                        <td><?php echo $proponente ?></td>
                        <td><?php echo $categoria ?></td>
                        <td><?php echo $municipio ?></td>
                        <td><?php echo $resultado ?></td>
                        <td>
                            <?php echo $motivo_inabilitacao ?>
                        </td>

                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </div>
</body>

</html>