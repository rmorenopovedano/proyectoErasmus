<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 19/11/2016
 * Time: 13:34
 */
session_start();
include "clases/funcionesAdmin.php";
include "cabeceraAdmin.php";
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
include "cajaazul.php";
$convocatorias=cargarConvocatoriasParaAdmin();
?>
    <div class="row subtitulo" id="tituloRankingProfesor">
        <div class="medium-12 medium-centered columns centrar">
            <h3>Ranking Profesores</h3>
        </div>
    </div>
    <div class="row">
        <div class="medium-4 medium-centered columns">
            <label>Selecciona convocatoria:
                <select name="convocatoria8" id="convocatoria8">
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
        <div class="medium-12 medium-centered columns" id="rankingProfesor">
        </div>
    </div>

<?php
include "footer.php";