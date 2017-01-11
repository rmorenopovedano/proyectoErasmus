<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 09/11/2016
 * Time: 23:53
 */
include "clases/funcionesAdmin.php";
$db = new Conexion();
$idConvocatoria=$_REQUEST['convocatoria_enviada'];
$consulta="select * from participantes where idConvocatoria=:idConvocatoria and validado=0 and tipo='estudiante'";
$parametros=array("idConvocatoria"=>$idConvocatoria);
$result=$db->consulta($consulta,$parametros);
if($result){
    echo '<div class="table-scroll">';
    echo '<form action="gestionarValidaciones.php" method="post">';
    echo '<table class="hover centrar">';
    echo '<tr><th>Alumno</th><th>Ciclo</th><th>Validar</th></tr>';
    foreach($result as $key){
        $consultaCiclo="select nombre from ciclos where id in(select idCiclo from participantes where idCiclo=:idCiclo)";
        $parametros=array("idCiclo"=>$key['idCiclo']);
        $ciclo=$db->consulta($consultaCiclo, $parametros);
        echo "<tr><td>".$key['nombre']."</td><td>".$ciclo[0]['nombre']."</td><td class='centrar'><input name='validados[]' type='checkbox' value='".$key['dni']."'></td></tr>";
    }
    echo '<tr><td></td><td></td><td class="centrar"><input type="submit" class="button" name="submit" value="Validar"></td></tr>';
    echo '</form>';
    echo '</table>';
}else{
    echo '<div class="alert callout centrar">
              <p><i class="fi-alert"></i>No hay alumnos que validar esta convocatoria.</p>
          </div>';
}