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
    if(isset($_REQUEST['action'])) {
        //cargamos las variables que recibimos del formulario
        $expediente = $_REQUEST['expediente'];
        $carta = $_REQUEST['carta'];
        $competencia = $_REQUEST['competencia'];
        $informe = $_REQUEST['informe'];
        $idAlumno = $_REQUEST['idAlumno'];
        print_r($_REQUEST);
            $db = new Conexion();
            //si el alumno ya ha sido puntuado previamente se modifica su nota con un update.
            if ($_REQUEST['action'] == "edit") {
                $consulta = "UPDATE notas SET expAcademic=:expAcademic,compLing=:compLing,cartaMotiv=:cartaMotiv,informe=:informe WHERE idParticipante=:idParticipante";
                $parametros = array("expAcademic" => $expediente, "compLing" => $competencia, "cartaMotiv" => $carta, "informe" => $informe, "idParticipante" => $idAlumno);
                if(!is_numeric($expediente) or !is_numeric($carta) or !is_numeric($competencia) or !is_numeric($informe) or $carta<0 or $carta>1 or $informe<0 or $informe>1)
                    header("Location: baremar.php?mensaje=error&idAlumno=".$idAlumno."&action=edit");
                else{
                    $db->consulta($consulta, $parametros);
                    header("Location: puntuacionEnviada.php?mensaje=actualizado");
                }
            } else {
                //si no se ha puntuado aún se puntúa por primera vez.
                $consulta = "INSERT INTO notas(expAcademic, compLing, cartaMotiv, informe, idParticipante)
                values(:expAcademic,:compLing,:cartaMotiv,:informe,:idParticipante)";
                $consulta2="UPDATE participantes SET puntuado=1";
                $parametros = array("expAcademic" => $expediente, "compLing" => $competencia, "cartaMotiv" => $carta, "informe" => $informe, "idParticipante" => $idAlumno);
                if(!is_numeric($expediente) or !is_numeric($carta) or !is_numeric($competencia) or !is_numeric($informe) or $carta<0 or $carta>1 or $informe<0 or $informe>1){
                    header("Location: baremar.php?mensaje=error&idAlumno=".$idAlumno."&action=new");
                }
                else{
                    $db->consulta($consulta, $parametros);
                    $db->consulta($consulta2);
                    header("Location: puntuacionEnviada.php?mensaje=new");
                }
            }
    }
}


