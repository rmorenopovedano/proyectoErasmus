<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 15/11/2016
 * Time: 9:24
 */
session_start();
include "clases/funcionesAdmin.php";
include "cabeceraAdmin.php";
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
include "cajaazul.php";
$convocatorias=cargarConvocatoriasParaAdmin();
?>
    <div class="row subtitulo" id="tituloValidarProfesor">
        <div class="medium-12 medium-centered columns centrar">
            <h3>Validar Profesores</h3>
        </div>
    </div>
    <div class="row">
        <div class="medium-4 medium-centered columns">
            <label>Selecciona convocatoria:
                <select name="convocatoria5" id="convocatoria5">
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
<?php
if(isset($_REQUEST['mensaje'])){
    if($_REQUEST['mensaje']=="vacio"){
        echo '<div class="alert callout centrar">
              <p><i class="fi-alert"></i>No has seleccionado ningún profesor para validar.</p>
          </div>';
    }
}
?>

    <div class="row">
        <div class="medium-8 medium-centered columns" id="validacionesProfesor">
        </div>
    </div>

<?php
include "footer.php";