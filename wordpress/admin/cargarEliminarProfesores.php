<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 15/11/2016
 * Time: 10:20
 */
include "clases/funcionesAdmin.php";
$db = new Conexion();
$idConvocatoria=$_REQUEST['convocatoria_enviada'];
$consulta="select * from participantes where idConvocatoria=:idConvocatoria and tipo='profesor'";
$parametros=array("idConvocatoria"=>$idConvocatoria);
$result=$db->consulta($consulta,$parametros);
if($result){
    echo '<div class="table-scroll">';
    echo '<form action="gestionarEliminacionesProfesor.php" method="post">';
    echo '<table class="hover centrar">';
    echo '<tr><th>Profesor</th><th>Ciclo</th><th>Eliminar</th></tr>';
    foreach($result as $key){
        $consultaCiclo="select nombre from ciclos where id in(select idCiclo from participantes where idCiclo=:idCiclo)";
        $parametros=array("idCiclo"=>$key['idCiclo']);
        $ciclo=$db->consulta($consultaCiclo, $parametros);
        echo "<tr><td>".$key['nombre']."</td><td>".$ciclo[0]['nombre']."</td><td class='centrar'><input name='eliminados[]' type='checkbox' value='".$key['id']."'></td></tr>";
    }
    echo '<tr><td></td><td></td><td class="centrar"><input type="submit" class="button" name="submit" value="Eliminar"></td></tr>';
    echo '</form>';
    echo '</table>';
}else{
    echo '<div class="alert callout centrar">
              <p><i class="fi-alert"></i>No hay profesores que eliminar esta convocatoria.</p>
          </div>';
}