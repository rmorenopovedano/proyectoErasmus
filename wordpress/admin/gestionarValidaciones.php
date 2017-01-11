<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 10/11/2016
 * Time: 0:14
 */
session_start();
include "clases/conectaDB.php";
if(!isset($_REQUEST['submit'])){
    header("Location:validarAlumno.php");
}else{
    $db=new Conexion();
    $participantes=$_REQUEST['validados'];
    if(count($participantes)==0){
        header("Location:validarAlumno.php?mensaje=vacio");
    }else{
        foreach($participantes as $key){
            $consulta="UPDATE participantes SET validado=1 WHERE dni=:dni";
            $parametros=array("dni"=>$key);
            $db->consulta($consulta,$parametros);
        }
    header("Location: validarUsuariosExito.php");
    }
}