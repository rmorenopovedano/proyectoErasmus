<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 19/11/2016
 * Time: 14:22
 */
session_start();
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
if(!isset($_REQUEST['convocatoria_enviada'])){
    header("Location: index.php");
}
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
        $consultaConvocatoria="select anno from convocatorias where id=:id";
        $parametros=array("id"=>$idConvocatoria);
        $resultConvocatoria=$db->consulta($consultaConvocatoria, $parametros);
        $annoConvocatoria=$resultConvocatoria[0]['anno'];
        $consulta="SELECT (b.funcionario+ b.compromiso+ b.cicloFormativo+ b.programaFormativo +b.idiomas) as nota, participantes.*
          from baremacionprofesores b, participantes where participantes.id = b.idParticipante and idConvocatoria=:idConvocatoria and puntuado=1
          order by nota desc";
        $parametros=array("idConvocatoria"=>$idConvocatoria);
        $result=$db->consulta($consulta,$parametros);
        if($result){
            echo '<div class="row">';
            echo '<div class="medium-6 medium-centered columns">
                            <h3 class="centrar">Ranking de Profesores '.$annoConvocatoria.'</h3>
                        </div>';
            echo '</div>';
            echo '<div class="table-scroll">';
            echo '<table class="hover centrar">';
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
            echo '<a style="float:right;" type="button" id="cancelar" class="button hide-for-print" href="rankingProfesores.php">Cancelar</a>';
        }else{
            echo '<div class="alert callout centrar">
              <p><i class="fi-alert"></i>No hay profesores en esta convocatoria.</p>
          </div>';
        }
        ?>
    </div>
</div>
</body>
</html>

