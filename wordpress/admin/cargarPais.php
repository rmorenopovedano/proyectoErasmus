<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 04/11/2016
 * Time: 17:58
 */
include "clases/conectaDB.php";
$db = new Conexion();
if(isset($_REQUEST['pais_enviado2'])){
    $pais=$_REQUEST['pais_enviado'];
    $pais2=$_REQUEST['pais_enviado2'];
    $consulta="SELECT codigo, nombre from paises WHERE codigo<>".$pais." and codigo<>".$pais2;
    $result=$db->consulta($consulta);
    if($result){
        echo '<option value="">--Elegir país--</option>';
        foreach($result as $key){
            echo '<option value="'.$key['codigo'].'">'.$key['nombre'].'</option>';
        }
    }
}else{
    $pais=$_REQUEST['pais_enviado'];
    $consulta="SELECT codigo, nombre from paises WHERE codigo<>".$pais;
    $result=$db->consulta($consulta);
    if($result){
        echo '<option value="">--Elegir país--</option>';
        foreach($result as $key){
            echo '<option value="'.$key['codigo'].'">'.$key['nombre'].'</option>';
        }
    }
}
