<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 05/11/2016
 * Time: 16:51
 */
session_start();
include "clases/conectaDB.php";
if(!isset($_REQUEST['submit'])){
    header("Location:login.php");
}
$formularioOk=false;
$user=$_REQUEST['user'];
$pass=$_REQUEST['password'];
if(!empty($user) and !empty($pass)){
    $formularioOk=true;
}
if($formularioOk){
    $db=new Conexion();
    $consulta="select perfil from usuarios where user=:user and pass=:pass";
    $parametros=array("user"=>$user,"pass"=>$pass);
    $result=$db->consulta($consulta,$parametros);
    $perfil=$result[0]['perfil'];
    //si el perfil del usuario logueado es administrador
    if($perfil=='administrador'){
        $_SESSION['perfil']=$perfil;
        header("Location: index.php?");
    }
    //en el caso de que el usuario sea colaborador
    else if($perfil=='colaborador'){
        $_SESSION['perfil']=$perfil;
        header("Location: index.php");
        //en el caso de que el usuario no se encuentre en la BD
    }else{
        header("Location: login.php?mensaje=notfound");
    }

}else{
    header("Location: login.php?mensaje=error");
}