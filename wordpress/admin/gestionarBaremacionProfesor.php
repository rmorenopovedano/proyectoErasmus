<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 18/11/2016
 * Time: 18:21
 */
session_start();
include "clases/conectaDB.php";
if(!isset($_REQUEST['submit'])){
    header("Location:listadoProfesores.php");
}else{
    if(isset($_REQUEST['action'])) {
        //cargamos las variables que recibimos del formulario
        $idiomas=$_REQUEST['idiomas'];
        $programaFormativo=$_REQUEST['programaFormativo'];
        $idParticipante=$_REQUEST['idProfesor'];
        print_r($_REQUEST);
        $db = new Conexion();
            $consulta = "UPDATE baremacionprofesores SET programaFormativo=:programaFormativo,idiomas=:idiomas WHERE idParticipante=:idParticipante";
            $consulta2="UPDATE participantes SET puntuado=1";
            $parametros = array("programaFormativo" => $programaFormativo, "idiomas" => $idiomas, "idParticipante" => $idParticipante);
            if(!is_numeric($idiomas) or !is_numeric($programaFormativo) or $programaFormativo<0 or $programaFormativo>1.5)
                header("Location: baremarProfesor.php?mensaje=error&idProfesor=".$idParticipante."&action=edit");
            else{
                $db->consulta($consulta, $parametros);
                $db->consulta($consulta2);
                header("Location: puntuacionEnviadaProfesor.php?mensaje=actualizado");
            }
    }
}


