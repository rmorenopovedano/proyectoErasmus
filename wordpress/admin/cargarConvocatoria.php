<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 06/11/2016
 * Time: 11:32
 */
include "clases/funcionesAdmin.php";
$db = new Conexion();
$idConvocatoria=$_REQUEST['convocatoria_enviada'];
$consulta="select * from participantes where idConvocatoria=:idConvocatoria";
$parametros=array("idConvocatoria"=>$idConvocatoria);
$result=$db->consulta($consulta,$parametros);
if($result){
    echo '<div class="table-scroll">';
        echo '<table class="hover">';
        echo '<tr><th>Nombre</th><th>Dni</th><th>Ciclo</th><th>Email</th><th>Teléfono</th><th>Baremar</th></tr>';
        foreach($result as $key){
            $consultaCiclo="select nombre from ciclos where id in(select idCiclo from participantes where idCiclo=:idCiclo)";
            $parametros=array("idCiclo"=>$key['idCiclo']);
            $ciclo=$db->consulta($consultaCiclo, $parametros);
            echo '<tr><td>'.$key['nombre'].'</td><td>'.$key['dni'].'</td><td>'.$ciclo[0]['nombre'].'</td><td>'.$key['email'].'</td><td>'.$key['telefono'].'</td><td class="centrar">';
            //comprobar si el usuario está ya puntuado o no para quitar el enlace a baremar.
            if(comprobarExisteAlumno($key['id'])) {
                echo "<img src='img/puntuado.png'>";
            }else
                echo '<a href="baremar.php?idAlumno='.$key['id'].'"><img src="img/edit.png"></a></td></tr>';
        }
        echo '</table>';
    echo '</div>';
}else{
    echo '<div class="alert callout centrar">
              <p><i class="fi-alert"></i>No hay alumnos en esta convocatoria.</p>
          </div>';
}