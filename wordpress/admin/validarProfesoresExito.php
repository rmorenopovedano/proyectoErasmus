<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 15/11/2016
 * Time: 9:31
 */
session_start();
include "cabeceraAdmin.php";
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");

?>
    <div class="row margintop30px">
        <div class="medium-6 medium-centered columns centrar padding40px">
            <span class="exito" >Profesores validados con éxito</span>
        </div>
    </div>
    <script>
        setTimeout(function(){
            window.location="validarProfesor.php";
        }, 2000);
    </script>
<?php
include "footer.php";