<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 07/11/2016
 * Time: 19:55
 */
?>
    <!doctype html>
    <html class="no-js" lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erasmus IES Gran Capitán</title>
        <link rel="stylesheet" href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="css/foundation.css">
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body>
    <div class="row">
        <div class="medium-centered medium-12 margintop30px fondo_blanco columns border">
            <?php
            include "clases/funcionesAdmin.php";
            $db = new Conexion();
            $idConvocatoria=$_REQUEST['convocatoria_enviada'];
            $consulta="SELECT (notas.expAcademic+ notas.compLing+notas.cartaMotiv+ notas.informe) as nota, participantes.*
          from notas, participantes where participantes.id = notas.idParticipante and idConvocatoria=:idConvocatoria
          order by nota desc";
            $parametros=array("idConvocatoria"=>$idConvocatoria);
            $result=$db->consulta($consulta,$parametros);
            if($result){
                echo '<div class="table-scroll">';
                echo '<table class="hover">';
                echo '<tr><th></th><th>Nombre</th><th>Dni</th><th>Ciclo</th><th>Nota Final</th></tr>';
                $orden=1;
                foreach($result as $key){
                    $consultaCiclo="select nombre from ciclos where id in(select idCiclo from participantes where idCiclo=:idCiclo)";
                    $parametros=array("idCiclo"=>$key['idCiclo']);
                    $ciclo=$db->consulta($consultaCiclo, $parametros);
                    echo "<tr><td>".$orden."</td><td>".$key['nombre']."</td><td>".$key['dni']."</td><td>".$ciclo[0]['nombre']."</td><td class='centrar'>".$key['nota']."</td></tr>";
                    $orden++;
                }
                echo '</table>';
                echo '</div>';
                echo '<button onclick="window.print()" type="button" id="imprimir" class="button hide-for-print">Imprimir</button>';
            }else{
                echo '<div class="alert callout centrar">
              <p><i class="fi-alert"></i>No hay alumnos en esta convocatoria.</p>
          </div>';
            }
            ?>
        </div>
    </div>
    </body>
</html>

