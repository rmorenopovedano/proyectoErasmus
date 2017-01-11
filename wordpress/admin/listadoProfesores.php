<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 18/11/2016
 * Time: 17:37
 */
session_start();
include "clases/funcionesAdmin.php";
include "cabeceraAdmin.php";
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
include "cajaazul.php";
$convocatorias=cargarConvocatoriasParaAdmin();
?>
    <div class="row subtitulo" id="tituloListadoProfesores">
        <div class="medium-12 medium-centered columns centrar">
            <h3>Profesores a baremar</h3>
        </div>
    </div>
    <div class="row">
        <div class="medium-4 medium-centered columns">
            <label>Selecciona convocatoria:
                <select name="convocatoria7" id="convocatoria7">
                    <option value="">--Elegir convocatoria--</option>
                    <?php
                    foreach($convocatorias as $key){
                        echo '<option value="'.$key['id'].'">'.$key['anno'].'</option>';
                    }
                    ?>
                </select>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="medium-12 medium-centered columns" id="listadoProfesores">
        </div>
    </div>

<?php
include "footer.php";