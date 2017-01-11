<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 12/11/2016
 * Time: 12:51
 */
include "cabeceraAdmin.php";
?>
    <div class="row margintop30px">
        <div class="medium-6 medium-centered columns centrar padding40px">
            <span class="exito" >Usuarios eliminados con éxito</span>
        </div>
    </div>
    <script>
        setTimeout(function(){
            window.location="eliminarAlumno.php";
        }, 2000);
    </script>
<?php
include "footer.php";