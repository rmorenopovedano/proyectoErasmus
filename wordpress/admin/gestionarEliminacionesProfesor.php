<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 15/11/2016
 * Time: 10:21
 */
session_start();
include "clases/conectaDB.php";
if(!isset($_REQUEST['submit'])){
    header("Location:eliminarProfesor.php");
}else{
    $db=new Conexion();
    $participantes=$_REQUEST['eliminados'];
    if(count($participantes)==0){
        header("Location:eliminarProfesor.php?mensaje=vacio");
    }else{
        foreach($participantes as $key){
            $consulta="DELETE FROM participantes WHERE id=:id";
            $consulta2="DELETE FROM baremacionprofesores WHERE idParticipante=:idParticipante";
            $consulta3="DELETE FROM relparticipantesidiomas WHERE idParticipante=:idParticipante";
            $consulta4="SELECT nombre from documentos where idParticipante=:id";
            $parametros=array("id"=>$key);
            $parametros2=array("idParticipante"=>$key);
            $result=$db->consulta($consulta4,$parametros);
            foreach($result as $documento){
                unlink("uploads/".$documento['nombre']);
            }
            $db->consulta($consulta,$parametros);
            $db->consulta($consulta2,$parametros2);
            $db->consulta($consulta3,$parametros2);
        }
        header("Location: eliminarProfesorExito.php");
    }
}