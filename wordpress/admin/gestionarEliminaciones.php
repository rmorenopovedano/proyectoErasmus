<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 12/11/2016
 * Time: 12:42
 */
session_start();
include "clases/conectaDB.php";
if(!isset($_REQUEST['submit'])){
    header("Location:eliminarAlumno.php");
}else{
    $db=new Conexion();
    $participantes=$_REQUEST['eliminados'];
    if(count($participantes)==0){
        header("Location:eliminarAlumno.php?mensaje=vacio");
    }else{
        foreach($participantes as $id){
            $consulta="DELETE FROM participantes WHERE id=:id";
            $consulta2="DELETE FROM notas WHERE idParticipante=:idParticipante";
            $consulta3="DELETE FROM documentos WHERE idParticipante=:idParticipante";
            $consulta4="SELECT nombre from documentos where idParticipante=:id";

            $parametros=array("id"=>$id);
            $parametros2=array("idParticipante"=>$id);
            $result=$db->consulta($consulta4,$parametros);
            print_r($result);
            foreach($result as $documento){
                unlink("uploads/".$documento['nombre']);
            }
            $db->consulta($consulta,$parametros);
            $db->consulta($consulta2,$parametros2);
            $db->consulta($consulta3,$parametros2);
        }
        header("Location: eliminarAlumnoExito.php");
    }
}