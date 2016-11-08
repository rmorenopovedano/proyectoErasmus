<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 06/11/2016
 * Time: 13:58
 */
session_start();
include "clases/funcionesAdmin.php";
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
if(!isset($_REQUEST['idAlumno'])){
    header("Location: listadoAlumnos.php");
}
include "cabeceraAdmin.php";
include "cajaazul.php";
$idAlumno=$_REQUEST['idAlumno'];
$nombreAlumno=cargarNombreAlumno($idAlumno);
?>
<div class="row">
    <div class="medium-7 medium-centered columns">
        <!--Mostrar el error mediante php si el formulario no ha sido validado-->
        <?php
        if(isset($_GET['mensaje'])){
            if($_GET['mensaje']=="error"){
                echo '<div data-abide-error class="alert callout">
                          <p><i class="fi-alert"></i> Tu formulario contiene errores y no se ha podido enviar.</p>
                      </div>';
            }
        }
        ?>
        <form data-abide novalidate method="post" action="gestionarBaremacion.php">
            <fieldset>
                <legend><?php echo cargarNombreAlumno($idAlumno)?></legend>
                <div class="row">
                    <div class="medium-6 medium-text-right columns">
                        <label>Expediente Académico:</label>
                    </div>
                    <div class="medium-2 columns">
                        <select name="expediente" id="expediente">
                            <option value="0">0</option>
                            <option value="0.25">0.25</option>
                            <option value="0.5">0.5</option>
                            <option value="0.75">0.75</option>
                            <option value="1">1</option>
                            <option value="1.25">1.25</option>
                            <option value="1.5">1.5</option>
                            <option value="1.75">1.75</option>
                            <option value="2">2</option>
                            <option value="2.25">2.25</option>
                            <option value="2.5">2.5</option>
                            <option value="2.75">2.75</option>
                            <option value="3">3</option>
                            <option value="3.25">3.25</option>
                            <option value="3.5">3.5</option>
                            <option value="3.75">3.75</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="medium-4 columns">
                        <span class="baremacion">(Puntúa de 0 a 4)</span>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-6 medium-text-right columns">
                        <label>Competencia lingüística:</label>
                    </div>
                    <div class="medium-2 columns">
                        <select name="competencia" id="competencia">
                            <option value="0">0</option>
                            <option value="0.25">0.25</option>
                            <option value="0.5">0.5</option>
                            <option value="0.75">0.75</option>
                            <option value="1">1</option>
                            <option value="1.25">1.25</option>
                            <option value="1.5">1.5</option>
                            <option value="1.75">1.75</option>
                            <option value="2">2</option>
                            <option value="2.25">2.25</option>
                            <option value="2.5">2.5</option>
                            <option value="2.75">2.75</option>
                            <option value="3">3</option>
                            <option value="3.25">3.25</option>
                            <option value="3.5">3.5</option>
                            <option value="3.75">3.75</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="medium-4 columns">
                        <span class="baremacion">(Puntúa de 0 a 4)</span>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-6 medium-text-right columns">
                        <label>Carta de motivación:</label>
                    </div>
                    <div class="medium-2 columns">
                        <select name="carta" id="carta">
                            <option value="0">0</option>
                            <option value="0.25">0.25</option>
                            <option value="0.5">0.5</option>
                            <option value="0.75">0.75</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="medium-4 columns">
                        <span class="baremacion">(Puntúa de 0 a 1)</span>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-6 medium-text-right columns">
                        <label>Informe del tutor:</label>
                    </div>
                    <div class="medium-2 columns">
                        <select name="informe" id="informe">
                            <option value="0">0</option>
                            <option value="0.25">0.25</option>
                            <option value="0.5">0.5</option>
                            <option value="0.75">0.75</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="medium-4 columns">
                        <span class="baremacion">(Puntúa de 0 a 1)</span>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-6 medium-centered columns centrar">
                        <input type="hidden" name="idAlumno" id="idAlumno" value="<?php echo $idAlumno?>">
                        <input class="button" type="submit" id="submit" name="submit" value="Puntuar">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<?php
include "footer.php";