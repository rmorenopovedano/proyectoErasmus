<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 06/11/2016
 * Time: 17:56
 */
session_start();
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
include "cabeceraAdmin.php";
if(isset($_REQUEST['mensaje'])){
    if($_REQUEST['mensaje']=="new"){
        ?>
        <div class="row margintop30px">
            <div class="medium-6 medium-centered columns centrar padding40px">
                <span class="exito" >Alumno puntuado con éxito</span>
            </div>
        </div>
        <?php
    }
    if($_REQUEST['mensaje']=="actualizado"){
        ?>
        <div class="row margintop30px">
            <div class="medium-6 medium-centered columns centrar padding40px">
                <span class="exito" >Puntuación del alumno modificada con éxito</span>
            </div>
        </div>
        <?php
    }
    echo '<script>
    setTimeout(function(){
        window.location="/wordpress/admin/listadoAlumnos.php";
    }, 2000);
    </script>';
}else{
    header("Location: index.php");
}

include "footer.php";