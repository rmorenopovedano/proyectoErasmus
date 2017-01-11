<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 18/11/2016
 * Time: 18:27
 */
include "cabeceraAdmin.php";
if(isset($_REQUEST['mensaje'])){
    if($_REQUEST['mensaje']=="new"){
        ?>
        <div class="row margintop30px">
            <div class="medium-6 medium-centered columns centrar padding40px">
                <span class="exito" >Profesor puntuado con éxito</span>
            </div>
        </div>
        <?php
    }
    if($_REQUEST['mensaje']=="actualizado"){
        ?>
        <div class="row margintop30px">
            <div class="medium-6 medium-centered columns centrar padding40px">
                <span class="exito" >Puntuación del profesor modificada con éxito</span>
            </div>
        </div>
        <?php
    }
    echo '<script>
    setTimeout(function(){
        window.location="/wordpress/admin/listadoProfesores.php";
    }, 2000);
    </script>';
}

include "footer.php";