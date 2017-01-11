<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 29/10/2016
 * Time: 12:05
 */
include "clases/conectaDB.php";
require_once "tipos.php";
if(!isset($_REQUEST['submit'])){
    header("Location: formularioAlumnos.php");
}else {

//patrones de validación
    $patronPalabras= "/^([a-zA-ZÑÁÉÍÓÚáéíóú,.\/º][a-zA-Zñáéíóú,.\/º ]{1,})$/";
    $patronDni = "/^(\d{8}[a-zA-Z]{1})$/";
    $patronEmail = "/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/";
    $patronNumero = "/^(\s)*[-+]?\d*(?:[\.\,]\d+)?$/";
//cargar las variables;
    $nombre = $_REQUEST['nombre'];
    $dni = $_REQUEST['dni'];
    $fechaNac = $_REQUEST['fechaNac'];
    $email = $_REQUEST['email'];
    $nacionalidad = $_REQUEST['nacionalidad'];
    $cp = $_REQUEST['cp'];
    $direccion = $_REQUEST['direccion'];
    $poblacion= $_REQUEST['poblacion'];
    $telefono = $_REQUEST['telefono'];
    $otroTelefono = $_REQUEST['otro_telefono'];
    $idCiclo = $_REQUEST['ciclo'];
    $idTutor = $_REQUEST['tutor'];
    $pais1 = $_REQUEST['pais1'];
    if(isset($_REQUEST['pais2'])){
        $pais2 = $_REQUEST['pais2'];
    }else{
        $pais2="";
    }
    if(isset($_REQUEST['pais3'])){
        $pais3 = $_REQUEST['pais3'];
    }else{
        $pais3="";
    }
    $experiencia = $_REQUEST['experiencia_laboral'];
    $otrosEstudios = $_REQUEST['otros_estudios'];
    $archivoDni = $_FILES['archivoDni'];
    $archivoCarta = $_FILES['archivoCarta'];
    $archivoPass = $_FILES['archivoPasaporte'];
    $archivoCv = $_FILES['archivoCv'];
    $idConvocatoria = $_REQUEST['convocatoria'];

    //funciones de validacion
    function validarInput($campo, $patron){
        if(!preg_match($patron, $campo)){
            echo 'mal';
            return false;
        }else return true;
    }

    function validarCampoVacio($campo){
        if(empty($campo) || trim($campo)==null){
            return false;
        }
        else return true;
    }

    function subirArchivos($archivo, $tipo, $idParticipante, $db){
        if(isset($archivo['tmp_name'])){
            $extension=pathinfo($archivo['name'],PATHINFO_EXTENSION);
            $carpeta="./uploads/";
            $nombreArchivo=$idParticipante."-".$tipo.".".$extension;
            $resultado=move_uploaded_file($archivo['tmp_name'],$carpeta.$nombreArchivo);
            if($resultado){
                $consulta="select id from documentos where idParticipante=:idParticipante and tipo=:tipo";
                $parametros=array("idParticipante"=>$idParticipante,"tipo"=>$tipo);
                $result=$db->consulta($consulta, $parametros);
                if($result){
                    $consultaUpdate="UPDATE documentos set nombre=:nombre where idParticipante=:idParticipante and tipo=:tipo";
                    $parametros=array("idParticipante"=>$idParticipante,"nombre"=>$nombreArchivo, "tipo"=>$tipo);
                    $db->consulta($consultaUpdate,$parametros);
                }else{
                    $consultaInsert="INSERT INTO documentos(nombre, tipo, idParticipante)
                                    values(:nombre,:tipo,:idParticipante)";
                    $parametros=array("nombre"=>$nombreArchivo,"tipo"=>$tipo,"idParticipante"=>$idParticipante);
                    $db->consulta($consultaInsert,$parametros);
                }
            }
        }

    }

    function insertarPaisesParticipantes($pais1, $pais2, $pais3, $idParticipante, $db){
        $consultaDelete="DELETE from relparticipantespaises where idParticipante=:idParticipante";
        $parametros=array("idParticipante"=>$idParticipante);
        $db->consulta($consultaDelete,$parametros);
        $consultaInsert="INSERT INTO relparticipantespaises(idPais, idParticipante,prioridad)
                          values(:idPais1,:idParticipante,1)";
        $parametros=array("idPais1"=>$pais1,"idParticipante"=>$idParticipante);
        $db->consulta($consultaInsert,$parametros);
        if($pais2>0){
            $consultaInsert="INSERT INTO relparticipantespaises(idPais, idParticipante,prioridad)
                          values(:idPais2,:idParticipante,2)";
            $parametros=array("idPais2"=>$pais2,"idParticipante"=>$idParticipante);
            $db->consulta($consultaInsert,$parametros);
        }
        if($pais3>0){
            $consultaInsert="INSERT INTO relparticipantespaises(idPais, idParticipante,prioridad)
                          values(:idPais3,:idParticipante,3)";
            $parametros=array("idPais3"=>$pais3,"idParticipante"=>$idParticipante);
            $db->consulta($consultaInsert,$parametros);
        }
    }

    //bandera
    $formularioOK = false;

    //Realizar comprobación para la inserción en la BD
    if(validarInput($dni,$patronDni)
        and validarInput($email,$patronEmail)
        and validarInput($nacionalidad,$patronPalabras)
        and validarInput($cp,$patronNumero)
        and validarCampoVacio($direccion)
        and validarInput($telefono,$patronNumero)
        and validarInput($poblacion,$patronPalabras)){
        $formularioOK=true;
    }
    else{
        $formularioOK=false;
    }

//Si el formulario está OK realizamos la inserción en la BD
    if($formularioOK) {
        $db=new Conexion();
        $mensaje="";
        //comprobamos si el usuario ya ha enviado el formulario y está en la BD registrado
        $consultaDni="SELECT id FROM participantes where dni=:dni and tipo='estudiante'";
        $parametrosDni=array("dni"=>$dni);
        $resultDni=$db->consulta($consultaDni,$parametrosDni);
            //si existe el dni, haremos un update de los datos del participante
        $idParticipante=($resultDni)?$resultDni[0]['id']:false;
        if($idParticipante){
            $consultaUpdate="UPDATE participantes SET nombre=:nombre, dni=:dni, fechaNac=:fechaNac,email=:email,nacionalidad=:nacionalidad,
                            direccion=:direccion, poblacion=:poblacion, codigoPostal=:codigoPostal, telefono=:telefono, telefono2=:telefono2,
                            experienciaLaboral=:experienciaLaboral, otrosEstudios=:otrosEstudios, idCiclo=:idCiclo, idConvocatoria=:idConvocatoria,
                            idTutor=:idTutor, validado=0, tipo='estudiante' WHERE id=:id";
            $parametrosUpdate=array("nombre"=>$nombre,"dni"=>$dni,"fechaNac"=>$fechaNac,"email"=>$email,"nacionalidad"=>$nacionalidad,
                "direccion"=>$direccion,"poblacion"=>$poblacion,"codigoPostal"=>$cp,"telefono"=>$telefono,
                "telefono2"=>$otroTelefono,"experienciaLaboral"=>$experiencia,"otrosEstudios"=>$otrosEstudios,
                "idCiclo"=>$idCiclo,"idConvocatoria"=>$idConvocatoria,"idTutor"=>$idTutor, "id"=>$idParticipante);
            $db->consulta($consultaUpdate,$parametrosUpdate);
            $mensaje="mensaje=modificado";

        }else{
            //si no existe el dni porque nunca ha enviado sus datos, insertamos en la BD sobre participantes
            $consulta="insert into participantes(nombre, dni,fechaNac,email,nacionalidad,direccion,
                    poblacion,codigoPostal,telefono,telefono2, experienciaLaboral, otrosEstudios,
                    idCiclo,idConvocatoria,idTutor,validado, tipo) values(:nombre,:dni,:fechaNac,:email,:nacionalidad,:direccion,
                    :poblacion,:codigoPostal,:telefono,:telefono2,:experienciaLaboral,:otrosEstudios,:idCiclo,
                    :idConvocatoria,:idTutor,0,'estudiante')";
            $parametrosInsert=array("nombre"=>$nombre,"dni"=>$dni,"fechaNac"=>$fechaNac,"email"=>$email,"nacionalidad"=>$nacionalidad,
                "direccion"=>$direccion,"poblacion"=>$poblacion,"codigoPostal"=>$cp,"telefono"=>$telefono,
                "telefono2"=>$otroTelefono,"experienciaLaboral"=>$experiencia,"otrosEstudios"=>$otrosEstudios,
                "idCiclo"=>$idCiclo,"idConvocatoria"=>$idConvocatoria,"idTutor"=>$idTutor);
            $db->consulta($consulta,$parametrosInsert);
            $idParticipante=$db->last_id();
            $mensaje="mensaje=registrado";
        }
        subirArchivos($archivoCarta,TIPO_CARTA,$idParticipante,$db);
        subirArchivos($archivoCv,TIPO_CV,$idParticipante,$db);
        subirArchivos($archivoDni,TIPO_DNI,$idParticipante,$db);
        subirArchivos($archivoPass,TIPO_PASAPORTE,$idParticipante,$db);

        //insertamos sobre la tabla relaciónpaisparticipante
        insertarPaisesParticipantes($pais1,$pais2,$pais3,$idParticipante,$db);
        header("Location: ../admin/solicitudEnviada.php?$mensaje");
    }
//si el formulario no está OK volvemos al form con un mensaje de error
    else{
        header("Location: formularioAlumnos.php?mensaje=error");
    }
}

