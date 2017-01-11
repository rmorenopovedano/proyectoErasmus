<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 09/11/2016
 * Time: 22:50
 */
session_start();
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
include "clases/funcionesAdmin.php";
include "cabeceraAdmin.php";
include "cajaazul.php";
$convocatorias=cargarConvocatoriasParaAdmin();
?>
    <div class="row subtitulo" id="tituloValidar">
        <div class="medium-12 medium-centered columns centrar">
            <h3>Validar Alumnos</h3>
        </div>
    </div>
    <div class="row">
        <div class="medium-4 medium-centered columns">
            <label>Selecciona convocatoria:
                <select name="convocatoria3" id="convocatoria3">
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
              <p><i class="fi-alert"></i>No has seleccionado ningún alumno para validar.</p>
          </div>';
    }
}
?>
    <div class="row">
        <div class="medium-8 medium-centered columns" id="validaciones">
        </div>
    </div>

<?php
include "footer.php";