<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 01/11/2016
 * Time: 12:00
 */
include "clases/conectaDB.php";
//función para cargar los paises en el select
function cargarPais(){
    $db=new Conexion();
    $consulta="SELECT codigo, nombre from paises";
    $result=$db->consulta($consulta);
    if($result){
        return $result;
    }
}

//funcion para cargar los ciclos formativos en el select
function cargarCiclos(){
    $db=new Conexion();
    $consulta="SELECT id, nombre from ciclos";
    $result=$db->consulta($consulta);
    if($result){
        return $result;
    }
}

//funcion para cargar los tutores en el select
function cargarTutores(){
    $db=new Conexion();
    $consulta="SELECT id, nombre, idDepartamento from tutores";
    $result=$db->consulta($consulta);
    if($result){
        return $result;
    }
}

//funcion para cargar las convocatorias en el select
function cargarConvocatorias(){
    $db=new Conexion();
    $consulta="SELECT id, anno from convocatorias";
    $result=$db->consulta($consulta);
    if($result){
        return $result;
    }
}
//funcion para cargar los idiomas
function cargarIdiomas(){
    $db=new Conexion();
    $consulta="select idioma,id from idiomas";
    $result=$db->consulta($consulta);
    if($result){
        return $result;
    }
}
