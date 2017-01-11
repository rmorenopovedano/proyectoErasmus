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

//comprobar si el usuario ha sido ya puntuado
function comprobarExiste($idAlumno){
    $db=new Conexion();
    $consulta="select puntuado from participantes where id =:idParticipante and puntuado=1";
    $parametros=array("idParticipante"=>$idAlumno);
    $existe=$db->consulta($consulta,$parametros);
    if($existe){
        return true;
    }else
        return false;
}

//funcion para devolver los usuarios no validados
function validarUsuarios(){
    $db=new Conexion();
    $consulta="select * from participantes where validado=0";
    $result=$db->consulta($consulta);
    if($result){
        return $result;
    }else{
        header("Location: validarAlumno.php?mensaje=vacio");
    }
}
function cargarNotasAlumno($id){
    $db=new Conexion();
    $consulta="select * from notas where idParticipante=:idParticipante";
    $parametros=array("idParticipante"=>$id);
    $result=$db->consulta($consulta,$parametros);
    if($result){
        return $result;
    }
}

function cargarNotasProfesor($id){
    $db=new Conexion();
    $consulta="select * from baremacionprofesores where idParticipante=:idParticipante";
    $parametros=array("idParticipante"=>$id);
    $result=$db->consulta($consulta,$parametros);
    if($result){
        return $result;
    }
}

//funcion para mostrar los idiomas que tiene el profesor
function cargarIdiomasProfesor($id){
    $db=new Conexion();
    $consulta="SELECT r.certificado, i.idioma FROM relparticipantesidiomas r, idiomas i WHERE r.idIdioma = i.id
                AND r.idParticipante =:idParticipante";
    $parametros=array("idParticipante"=>$id);
    $result=$db->consulta($consulta,$parametros);
    if($result){
        return $result;
    }
}

//funcion para mostrar los documentos de un alumano
function cargarDocumentos($id){
    $db=new Conexion();
    $consuta="SELECT * FROM documentos WHERE idParticipante IN (SELECT id FROM participantes WHERE id =:id)";
    $parametros=array("id"=>$id);
    $result=$db->consulta($consuta,$parametros);
    if($result){
        return $result;
    }
}
