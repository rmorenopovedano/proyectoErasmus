<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 28/10/2016
 * Time: 18:24
 */
include "clases/conectaDB.php";
$db = new Conexion();
//parámetro enviado por ajax
$dni=$_REQUEST['dni_enviado'];
$parametros=array("dni"=>$dni);
$data=[];
$data['errorDni']=false;
$consultaParticipantes="SELECT validado, nombre, email, direccion, codigoPostal, fechaNac, telefono, telefono2, nacionalidad, poblacion, idTutor, idConvocatoria, idCiclo from participantes where dni=:dni and tipo='estudiante'";
$consultaEstudiantes="SELECT nombre, email, direccion, codigoPostal, telefono, nacionalidad from estudiantes where dni=:dni";

$result=$db->consulta($consultaParticipantes,$parametros);
//si ya está el alumno registrado, devuelve los datos de la tabla participantes
if($result){
    $result=$result[0];
    foreach($result as $key=>$value){
        $data[$key]=$value;
    }
    //cargar los paises en los select
    $consultaRellenarPais="SELECT idPais, idParticipante, prioridad from relparticipantespaises where idParticipante
                            in (Select id from participantes where dni=:dni)";
    $result=$db->consulta($consultaRellenarPais,$parametros);
    if($result){
        foreach($result as $key){
            $data['pais'.$key['prioridad']]=$key['idPais'];
        }
    }
    if($data['validado']==1){
        $data['errorDni']=true;
    }
    //si no existe en participantes lo busco en la tabla estudiantes
}else{
    $result=$db->consulta($consultaEstudiantes,$parametros);
    if($result){
        $result=$result[0];
        foreach($result as $key=>$value){
            $data[$key]=$value;
        }
    }
    else{
        $data['errorDni']=true;
    }
}
//enviar los documentos por ajax al formulario
$consulta="SELECT d.nombre nombre, d.tipo tipo FROM documentos d INNER JOIN participantes p ON p.id = d.idParticipante
          INNER JOIN estudiantes e ON e.dni = p.dni WHERE p.dni =:dni";
$parametros=array("dni"=>$dni);
$result=$db->consulta($consulta,$parametros);
if($result){
    foreach($result as $row){
        $data[$row['tipo']]=$row['nombre'];
    }
}
echo json_encode($data);