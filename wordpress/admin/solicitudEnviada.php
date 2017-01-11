<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 04/11/2016
 * Time: 19:34
 */
include "cabecera.php";
?>
    <div class="row margintop30px">
        <div class="medium-6 medium-centered columns centrar padding40px">
            <span class="exito" >Su solicitud se ha <?php echo $_REQUEST['mensaje']?> con éxito</span>
        </div>
    </div>
    <script>
        setTimeout(function(){
            window.location="../";
        }, 2000);
    </script>
<?php
include "footer.php";