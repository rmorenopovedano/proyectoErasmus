<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 06/11/2016
 * Time: 17:10
 */
session_start();
include "clases/conectaDB.php";
if(!isset($_REQUEST['submit'])){
    header("Location:listadoAlumnos.php");
}else{
    //cargamos las variables que recibimos del formulario
    $formularioOk="false";
    $expediente=$_REQUEST['expediente'];
    $carta=$_REQUEST['carta'];
    $competencia=$_REQUEST['competencia'];
    $informe=$_REQUEST['informe'];
    $idAlumno=$_REQUEST['idAlumno'];
    $db=new Conexion();
    $consulta="INSERT INTO notas(expAcademic, compLing, cartaMotiv, informe, idParticipante)
              values(:expAcademic,:compLing,:cartaMotiv,:informe,:idParticipante)";
    $parametros=array("expAcademic"=>$expediente,"compLing"=>$competencia,"cartaMotiv"=>$carta,"informe"=>$informe,"idParticipante"=>$idAlumno);
    $db->consulta($consulta,$parametros);
    header("Location: puntuacionEnviada.php?mensaje=new");
}

