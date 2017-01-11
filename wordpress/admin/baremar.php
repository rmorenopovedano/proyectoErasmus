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
$notasAlumno=cargarNotasAlumno($idAlumno);
$documentosAlumno=cargarDocumentos($idAlumno);
echo '<div class="row subtitulo">
        <div class="medium-12 medium-centered columns centrar">
            <h3>Puntuar Alumno</h3>
        </div>
    </div>';
echo'
<div class="row">
    <div class="medium-7 medium-centered columns">
        <!--Mostrar el error mediante php si el formulario no ha sido validado-->';

        if(isset($_GET['mensaje'])){
            if($_GET['mensaje']=="error"){
                echo '<div data-abide-error class="alert callout">
                          <p><i class="fi-alert"></i>Formulario no válido. Debe utilizar el (.) como separador decimal y solo valores númericos.</p>
                      </div>';
            }
        }
        $action="?action=new";
        if(isset($_REQUEST['action'])) {
            if ($_REQUEST['action'] == "edit") {
                $action="?action=edit";
                $expediente=$notasAlumno[0]['expAcademic'];
                $competencia=$notasAlumno[0]['compLing'];
                $carta=$notasAlumno[0]['cartaMotiv'];
                $informe=$notasAlumno[0]['informe'];

            }else{
                $action="?action=new";
                $expediente="";
                $competencia="";
                $carta="";
                $informe="";
            }
        }
        echo'
        <form data-abide novalidate method="post" action="gestionarBaremacion.php'.$action.'">
            <fieldset>
                <legend>'.$nombreAlumno.'</legend>
                <div class="row padding40px">
                    <div class="medium-10 medium-centered columns">
                    <label class="centrar padding10px">Documentos</label>';

                    foreach($documentosAlumno as $documento){
                     echo'<a target="_blank" class="boton centrar" href="uploads/'.$documento['nombre'].'">'.$documento['tipo'].'</a>';
                    }
                 echo'</div>
                </div>
                <div class="row">
                    <div class="medium-6 medium-text-right columns">
                        <label>Expediente Académico:</label>
                    </div>
                    <div class="medium-2 columns">
                        <input type="text" name="expediente" required pattern="expediente" id="expediente" value="'.$expediente.'">
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
                        <input type="text" name="competencia" id="competencia" required pattern="expediente" value="'.$competencia.'">
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
                        <input type="text" name="carta" id="carta" required pattern="carta" value="'.$carta.'">
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
                        <input type="text" id="informe" name="informe" required pattern="carta" value="'.$informe.'">
                    </div>
                    <div class="medium-4 columns">
                        <span class="baremacion">(Puntúa de 0 a 1)</span>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-6 medium-centered columns centrar">
                        <input type="hidden" name="idAlumno" id="idAlumno" value="'.$idAlumno.'">
                        <input class="button" type="submit" id="submit" name="submit" value="Puntuar">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>';
include "footer.php";