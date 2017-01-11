<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 13/11/2016
 * Time: 11:39
 */
include "clases/conectaDB.php";
$db = new Conexion();
//parámetro enviado por ajax
$dni=$_REQUEST['dni_enviado'];
$parametros=array("dni"=>$dni);
$data=[];
$data['errorDni']=false;
$consultaParticipantes="SELECT validado, fechaNac, nombre, email, telefono, telefono2,annosTrabajados, nacionalidad, idConvocatoria, idCiclo, funcionario, compromiso from participantes where dni=:dni and tipo='profesor'";
$consultaProfesores="SELECT nombre from profesores where dni=:dni";

$result=$db->consulta($consultaParticipantes,$parametros);
//si ya está el alumno registrado, devuelve los datos de la tabla participantes
if($result){
    $result=$result[0];
    foreach($result as $key=>$value){
        $data[$key]=$value;
    }
   //si el profesor ha sido validado no puedo volver a rellenar el formulario
    if($data['validado']==1){
        $data['errorDni']=true;
    }
    //si no existe en participantes lo busco en la tabla profesores
}else{
    $result=$db->consulta($consultaProfesores,$parametros);
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
          INNER JOIN profesores e ON e.dni = p.dni WHERE p.dni =:dni";
$parametros=array("dni"=>$dni);
$result=$db->consulta($consulta,$parametros);
if($result){
    foreach($result as $row){
        $data[$row['tipo']]=$row['nombre'];
    }
}

//enviar los idiomas por ajax al formulario
$consulta="SELECT r.idIdioma idIdioma, r.certificado certificado FROM relparticipantesidiomas r INNER JOIN participantes p ON p.id = r.idParticipante
          INNER JOIN profesores e ON e.dni = p.dni WHERE p.dni =:dni";
$parametros=array("dni"=>$dni);
$result=$db->consulta($consulta,$parametros);
if($result){
    foreach($result as $row){
        $data['idiomas'][$row['idIdioma']]=$row['certificado'];
    }
}
echo json_encode($data);