<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 06/11/2016
 * Time: 17:56
 */
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
}

include "footer.php";