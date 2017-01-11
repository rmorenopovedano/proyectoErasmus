<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 10/11/2016
 * Time: 0:26
 */
session_start();
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
include "cabeceraAdmin.php";
?>
    <div class="row margintop30px">
        <div class="medium-6 medium-centered columns centrar padding40px">
            <span class="exito" >Usuarios validados con éxito</span>
        </div>
    </div>
    <script>
        setTimeout(function(){
            window.location="validarAlumno.php";
        }, 2000);
    </script>
<?php
include "footer.php";