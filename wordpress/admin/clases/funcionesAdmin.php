<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 05/11/2016
 * Time: 17:37
 */
include "funciones.php";
function cargarConvocatoriasParaAdmin(){
    return cargarConvocatorias();
}
function cargarNombreAlumno($id){
    $db=new Conexion();
    $consulta="select nombre from participantes where id=:id";
    $parametros=array("id"=>$id);
    $result=$db->consulta($consulta,$parametros);
    return $result[0]['nombre'];
}
function comprobarExisteAlumno($idAlumno){
    //comprobar si el alumno ha sido ya puntuado
    $db=new Conexion();
    $consulta="select count(idParticipante) as existeParticipante from notas where idParticipante =:idParticipante";
    $parametros=array("idParticipante"=>$idAlumno);
    $result=$db->consulta($consulta,$parametros);
    $existe=$result[0]['existeParticipante'];
    if($existe>0){
        return true;
    }else
        return false;
}