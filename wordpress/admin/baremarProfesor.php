<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 18/11/2016
 * Time: 17:58
 */
session_start();
include "clases/funcionesAdmin.php";
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
if(!isset($_REQUEST['idProfesor'])){
    header("Location: listadoProfesores.php");
}
include "cabeceraAdmin.php";
include "cajaazul.php";
$idParticipante=$_REQUEST['idProfesor'];
$nombreProfesor=cargarNombreAlumno($idParticipante);
$notasProfesor=cargarNotasProfesor($idParticipante);
$idiomasProfesor=cargarIdiomasProfesor($idParticipante);
$documentosProfesor=cargarDocumentos($idParticipante);
echo '<div class="row subtitulo">
        <div class="medium-12 medium-centered columns centrar">
            <h3>Puntuar Profesor</h3>
        </div>
    </div>';
echo'
<div class="row">
    <div class="medium-7 medium-centered columns">
        <!--Mostrar el error mediante php si el formulario no ha sido validado-->';

if(isset($_GET['mensaje'])){
    if($_GET['mensaje']=="error"){
        echo '<div data-abide-error class="alert callout">
                          <p><i class="fi-alert"></i>Puntuación no válida. Ajústese a los valores dados y utilice el (.) como separador decimal</p>
                      </div>';
    }
}
$action="?action=new";
if(isset($_REQUEST['action'])) {
    if ($_REQUEST['action'] == "edit") {
        $action="?action=edit";
        $programaFormativo=$notasProfesor[0]['programaFormativo'];
        $cicloFormativo=$notasProfesor[0]['cicloFormativo'];
        $idiomas=$notasProfesor[0]['idiomas'];
        $funcionario=$notasProfesor[0]['funcionario'];
        $compromiso=$notasProfesor[0]['compromiso'];

    }else{
        $action="?action=new";
        $programaFormativo="";
        $cicloFormativo="";
        $idiomas="";
        $funcionario="";
        $compromiso="";
    }
}
echo'<form data-abide novalidate method="post" action="gestionarBaremacionProfesor.php'.$action.'">
           <fieldset>
                <legend>'.$nombreProfesor.'</legend>
                 <div class="row padding40px">
                    <div class="medium-10 medium-centered columns padding10px">
                    <label class="centrar padding10px">Documentos</label>';
                    foreach($documentosProfesor as $documento){
                     echo '<a target="_blank" class="boton centrar" href="uploads/'.$documento['nombre'].'">'.$documento['tipo'].'</a>';
                    }
                 echo'</div>
                <div class="row">
                    <div class="medium-5 centrar columns nota">';
                        echo '<label style="text-decoration: underline; font-weight: bold">Idioma / Certificado</label>';
                        foreach($idiomasProfesor as $key){
                            echo '<label class="idiomas">'.$key['idioma'].':'.$key['certificado'].'</label>';
                        }
                    echo'</div>
                    <div class="medium-7 columns nota centrar">
                            <label style="text-decoration: underline; font-weight: bold">Notas calculadas automáticamente</label>
                            <label class="idiomas">Funcionario: '.$notasProfesor[0]['funcionario'].' pto</label>
                            <label class="idiomas">Compromiso: '.$notasProfesor[0]['compromiso'].' pto</label>
                            <label class="idiomas">Ciclo Formativo: '.$notasProfesor[0]['cicloFormativo'].' pto</label>
                            <label class="idiomas"><br></label>
                    </div>
                </div>
                <div class="row margintop30px">
                    <div class="medium-6 medium-text-right columns">
                        <label>Titulación Idiomas:</label>
                    </div>
                    <div class="medium-2 columns">
                        <input type="text" name="idiomas" id="idiomas" required pattern="expediente" value="'.$idiomas.'">
                    </div>
                    <div class="medium-4 columns">
                        <span class="baremacion">(Puntúa de 0 a 4)</span>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-6 medium-text-right columns">
                        <label>Programa Formativo:</label>
                    </div>
                    <div class="medium-2 columns">
                        <input type="text" id="programaFormativo" name="programaFormativo" required pattern="programaFormativo" value="'.$programaFormativo.'">
                    </div>
                    <div class="medium-4 columns">
                        <span class="baremacion">(Puntúa de 0 a 1.5)</span>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-6 medium-centered columns centrar">
                        <input type="hidden" name="idProfesor" id="idProfesor" value="'.$idParticipante.'">
                        <input class="button" type="submit" id="submit" name="submit" value="Puntuar">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>';
include "footer.php";