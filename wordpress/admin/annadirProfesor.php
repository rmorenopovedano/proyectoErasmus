<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 13/11/2016
 * Time: 12:00
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
    $nombre = $_REQUEST['nombre2'];
    $dni = $_REQUEST['dni2'];
    $fechaNac = $_REQUEST['fechaNac2'];
    $email = $_REQUEST['email2'];
    $nacionalidad = $_REQUEST['nacionalidad2'];
    $telefono = $_REQUEST['telefono2'];
    $otroTelefono = $_REQUEST['otro_telefono2'];
    $annosTrabajados = $_REQUEST['annosTrabajados'];
    $idCiclo = $_REQUEST['ciclo2'];
    $archivoInforme= $_FILES['archivoInforme'];
    $archivoPrograma = $_FILES['archivoPrograma'];
    $idConvocatoria = $_REQUEST['convocatoria2'];
    $funcionario=$_REQUEST['funcionario'];
    $compromiso=$_REQUEST['compromiso'];
    $idiomas=$_REQUEST['idiomas'];
    print_r($_REQUEST);
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
    function insertarParticipantesIdiomas($idiomas, $idParticipante, $db){
        $consultaDelete="DELETE from relparticipantesidiomas where idParticipante=:idParticipante";
        $parametros=array("idParticipante"=>$idParticipante);
        $db->consulta($consultaDelete,$parametros);
        foreach($idiomas as $idioma=>$valor){
            $consulta="select id from idiomas where idioma=:idioma";
            $parametros=array("idioma"=>$idioma);
            $result=$db->consulta($consulta,$parametros);
            $idIdioma=$result[0]['id'];
            if($result){
                $consultaInsert="INSERT INTO relparticipantesidiomas (idIdioma,idParticipante,certificado)
                                    values (:idIdioma,:idParticipante,:certificado)";
                $parametros=array("idIdioma"=>$idIdioma,"idParticipante"=>$idParticipante,"certificado"=>$valor);
                $db->consulta($consultaInsert,$parametros);
            }
        }

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

    //bandera
    $formularioOK = false;

    //Realizar comprobación para la inserción en la BD
    if(validarInput($dni,$patronDni)
        and validarInput($email,$patronEmail)
        and validarInput($nacionalidad,$patronPalabras)
        and validarInput($telefono,$patronNumero)){
        $formularioOK=true;
        echo "ok";
    }
    else{
        $formularioOK=false;
    }

//Si el formulario está OK realizamos la inserción en la BD
    if($formularioOK) {
        $db=new Conexion();
        $mensaje="";
        //comprobamos si el usuario ya ha enviado el formulario y está en la BD registrado
        $consultaDni="SELECT id FROM participantes where dni=:dni and tipo='profesor'";
        $parametrosDni=array("dni"=>$dni);
        $resultDni=$db->consulta($consultaDni,$parametrosDni);
        //si existe el dni, haremos un update de los datos del participante
        $idParticipante=($resultDni)?$resultDni[0]['id']:false;
        if($idParticipante){
            $consultaUpdate="UPDATE participantes SET nombre=:nombre, dni=:dni, fechaNac=:fechaNac,email=:email,nacionalidad=:nacionalidad,
                             telefono=:telefono, telefono2=:telefono2, annosTrabajados=:annosTrabajados, funcionario=:funcionario, compromiso=:compromiso,idCiclo=:idCiclo, idConvocatoria=:idConvocatoria,
                             validado=0, tipo='profesor' WHERE id=:id";
            $parametrosUpdate=array("nombre"=>$nombre,"dni"=>$dni,"fechaNac"=>$fechaNac,"email"=>$email,"nacionalidad"=>$nacionalidad,
                "telefono"=>$telefono,"telefono2"=>$otroTelefono,"idCiclo"=>$idCiclo,"idConvocatoria"=>$idConvocatoria,
                "annosTrabajados"=>$annosTrabajados,"funcionario"=>$funcionario,"compromiso"=>$compromiso,"id"=>$idParticipante);
            $db->consulta($consultaUpdate,$parametrosUpdate);
            $consultaValorCiclo="SELECT valor from ciclos where id=:idCiclo";
            $parametros=array("idCiclo"=>$idCiclo);
            $result=$db->consulta($consultaValorCiclo,$parametros);
            if($result){
                $consultaUpdateNotas="update baremacionprofesores set compromiso=:compromiso, funcionario=:funcionario,
                                      cicloFormativo=:cicloFormativo where idParticipante=:idParticipante";

                $parametros=array("compromiso"=>$compromiso,"funcionario"=>$funcionario,"cicloFormativo"=>$result[0]['valor'],"idParticipante"=>$idParticipante);
                $db->consulta($consultaUpdateNotas,$parametros);
            }
            $mensaje="mensaje=modificado";

        }else{
            //si no existe el dni porque nunca ha enviado sus datos, insertamos en la BD sobre participantes
            $consulta="insert into participantes(nombre, dni,fechaNac,email,nacionalidad, telefono,telefono2,annosTrabajados, funcionario, compromiso,
                    idCiclo,idConvocatoria,validado, tipo) values(:nombre,:dni,:fechaNac,:email,:nacionalidad,:telefono,:telefono2,
                    :annosTrabajados, :funcionario, :compromiso,:idCiclo, :idConvocatoria,0,'profesor')";
            $parametrosInsert=array("nombre"=>$nombre,"dni"=>$dni,"fechaNac"=>$fechaNac,"email"=>$email,"nacionalidad"=>$nacionalidad,
                "telefono"=>$telefono, "telefono2"=>$otroTelefono,"annosTrabajados"=>$annosTrabajados,"funcionario"=>$funcionario,"compromiso"=>$compromiso,"idCiclo"=>$idCiclo,
                "idConvocatoria"=>$idConvocatoria);
            $db->consulta($consulta,$parametrosInsert);
            $idParticipante=$db->last_id();
            echo "aki";
            $consultaValorCiclo="SELECT valor from ciclos where id=:idCiclo";
            $parametros=array("idCiclo"=>$idCiclo);
            $result=$db->consulta($consultaValorCiclo,$parametros);
            if($result){
                echo "alla";
                $consultaInsertNotas="insert into baremacionprofesores(compromiso,funcionario, cicloFormativo, idParticipante)
                                       values(:compromiso,:funcionario,:cicloFormativo,:idParticipante)";
                $parametros=array("compromiso"=>$compromiso,"funcionario"=>$funcionario,"cicloFormativo"=>$result[0]['valor'],"idParticipante"=>$idParticipante);
                $db->consulta($consultaInsertNotas,$parametros);
            }

            $mensaje="mensaje=registrado";
        }
        subirArchivos($archivoInforme,TIPO_INFORME_EMPRESA,$idParticipante,$db);
        subirArchivos($archivoPrograma,TIPO_PROGRAMA_FORMATIVO,$idParticipante,$db);
        insertarParticipantesIdiomas($idiomas,$idParticipante,$db);
        echo "todo bien";
        echo $mensaje;
        header("Location: ../admin/solicitudEnviada.php?$mensaje");
    }
//si el formulario no está OK volvemos al form con un mensaje de error
    else{
        header("Location: formularioProfesores.php?mensaje=error");
    }
}

