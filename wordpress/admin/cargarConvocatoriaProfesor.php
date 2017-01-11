<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 18/11/2016
 * Time: 17:45
 */
include "clases/funcionesAdmin.php";
$db = new Conexion();
$idConvocatoria=$_REQUEST['convocatoria_enviada'];
$consulta="select * from participantes where idConvocatoria=:idConvocatoria and tipo='profesor'";
$parametros=array("idConvocatoria"=>$idConvocatoria);
$result=$db->consulta($consulta,$parametros);
if($result){
    echo '<div class="table-scroll">';
    echo '<table class="hover">';
    echo '<tr><th>Nombre</th><th>Dni</th><th>Ciclo</th><th>Email</th><th>Teléfono</th><th>Baremar</th><th>Editar Nota</th></tr>';
    foreach($result as $key){
        $consultaCiclo="select nombre from ciclos where id in(select idCiclo from participantes where idCiclo=:idCiclo)";
        $parametros=array("idCiclo"=>$key['idCiclo']);
        $ciclo=$db->consulta($consultaCiclo, $parametros);
        echo '<tr><td class="centrar">'.$key['nombre'].'</td><td class="centrar">'.$key['dni'].'</td><td class="centrar">'.$ciclo[0]['nombre'].'</td><td class="centrar">'.$key['email'].'</td><td class="centrar">'.$key['telefono'].'</td><td class="centrar">';
        //comprobar si el usuario está ya puntuado o no para quitar el enlace a baremar.
        if(comprobarExiste($key['id'])) {
            echo '<img src="img/puntuado.png"></td><td class="centrar"><a href="baremarProfesor.php?idProfesor='.$key['id'].'&action=edit"><img src="img/editar.png"></a></td></tr>';
        }else
            echo '<a href="baremarProfesor.php?idProfesor='.$key['id'].'&action=new"><img src="img/edit.png"></a></td><td></td></tr>';
    }
    echo '</table>';
    echo '</div>';
}else{
    echo '<div class="alert callout centrar">
              <p><i class="fi-alert"></i>No hay profesores en esta convocatoria.</p>
          </div>';
}