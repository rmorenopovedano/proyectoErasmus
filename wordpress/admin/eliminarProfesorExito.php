<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 15/11/2016
 * Time: 10:22
 */
include "cabeceraAdmin.php";
?>
    <div class="row margintop30px">
        <div class="medium-6 medium-centered columns centrar padding40px">
            <span class="exito" >Profesores eliminados con éxito</span>
        </div>
    </div>
    <script>
        setTimeout(function(){
            window.location="eliminarProfesor.php";
        }, 2000);
    </script>
<?php
include "footer.php";