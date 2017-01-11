<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 07/11/2016
 * Time: 18:02
 */
session_start();
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
include "clases/funcionesAdmin.php";
include "cabeceraAdmin.php";
include "cajaazul.php";
$convocatorias=cargarConvocatoriasParaAdmin();
?>
    <div class="row subtitulo" id="tituloRanking">
        <div class="medium-12 medium-centered columns centrar">
            <h3>Ranking Alumnos</h3>
        </div>
    </div>
    <div class="row">
        <div class="medium-4 medium-centered columns">
            <label>Selecciona convocatoria:
                <select name="convocatoria2" id="convocatoria2">
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
        <div class="medium-12 medium-centered columns" id="ranking">
        </div>
    </div>

<?php
include "footer.php";