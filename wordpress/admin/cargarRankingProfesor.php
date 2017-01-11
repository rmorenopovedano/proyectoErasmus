<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 19/11/2016
 * Time: 13:38
 */
include "clases/funcionesAdmin.php";
$db = new Conexion();
$idConvocatoria=$_REQUEST['convocatoria_enviada'];
$consulta="SELECT (b.funcionario+ b.compromiso+ b.cicloFormativo+ b.programaFormativo +b.idiomas) as nota, participantes.*
          from baremacionprofesores b, participantes where participantes.id = b.idParticipante and idConvocatoria=:idConvocatoria and puntuado=1
          order by nota desc";
$parametros=array("idConvocatoria"=>$idConvocatoria);
$result=$db->consulta($consulta,$parametros);
if($result){
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
    echo '<button onclick="window.location=\'imprimirRankingProfesores.php?convocatoria_enviada='.$idConvocatoria.'\'" type="button" id="imprimir" class="button">Imprimir</button>';
}else{
    echo '<div class="alert callout centrar">
              <p><i class="fi-alert"></i>No hay profesores en esta convocatoria.</p>
          </div>';
}