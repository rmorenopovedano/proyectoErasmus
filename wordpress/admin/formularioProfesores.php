<?php
include "clases/funciones.php";
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Erasmus IES Gran Capitán</title>
    <link rel="stylesheet" href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css">
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<!--Contenedor principal-->
<div class="row">
    <div class="medium-centered medium-12 margintop30px fondo_blanco columns border">
        <!--Header-->
        <div class="row margin30px">
            <div class="medium-centered medium-12 columns">
                <div class="medium-4 columns">
                    <img src="img/logo.png">
                </div>
                <div class="medium-2 columns letra_azul">
                    <h3>ERASMUS</h3>
                    <h6>IES Gran Capitán</h6>
                </div>
                <div class="medium-6 columns margintop30px">
                    <ul class="menu">
                        <li><a class="letra_gris" href="../">Erasmus+</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--Caja azul-->
        <div class="row">
            <div class="medium-centered medium-12 columns fondo_azul">
                <h4 class="letra_blanca padding40px">Solicitud para Profesores</h4>
            </div>
        </div>
        <!--Formulario-->
        <div class="row margintop30px">
            <div class="large-centered large-6 columns">
                <form data-abide novalidate method="post" action="annadirProfesor.php" enctype="multipart/form-data">
                    <!--Mostrar el error mediante php si el formulario no ha sido validado-->
                    <?php
                    if(isset($_GET['mensaje'])){
                        if($_GET['mensaje']=="error"){
                            echo '<div data-abide-error class="alert callout">
                            <p class="centrar"><i class="fi-alert"></i> Tu formulario contiene errores y no se ha podido enviar.</p>
                             </div>';
                        }
                    }
                    ?>
                    <div id="dni_error2" class="alert callout" style="display: none">
                        <p class="centrar"><i class="fi-alert"></i>La solicitud Erasmus no está disponible para este usuario.</p>
                    </div>
                    <div class="medium-centered medium-6 columns">
                        <fieldset>
                            <legend>Introduce tu DNI</legend>
                            <label>DNI
                                <input type="text" id="dni2" name="dni2" placeholder="Ej:00000000X" aria-describedby="exampleHelpText" required pattern="dni">
                                <button type="button" class="button" id="comprobar">Comprobar</button>
                            <span class="form-error">
                              DNI inválido.
                            </span>
                            </label>
                        </fieldset>
                    </div>
                    <!--Resto del formulario que aparece oculto hasta que no exista un DNI correcto en la BD-->
                    <div id="formulario_oculto2">
                        <div class="row">
                            <div class="medium-12 medium-centered columns">
                                <span id="aviso2">Rellena los campos que faltan</span>
                            </div>
                        </div>
                        <fieldset>
                            <legend>Datos personales</legend>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">
                                    <label>Nombre(*)
                                        <input type="text" placeholder="Nombre" id="nombre2" name="nombre2" aria-describedby="exampleHelpText" required>
                             <span class="form-error">
                              Campo inválido.
                            </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-6 columns">
                                    <label>Fecha de Nacimiento(*)
                                        <input type="text" placeholder="dd/mm/aaaa" id="fechaNac2" name="fechaNac2" aria-describedby="exampleHelpText" required>
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                                <div class="medium-6 columns">
                                    <label>Email
                                        <input type="email" placeholder="example@example.com" id="email2" name="email2" aria-describedby="exampleHelpText" required pattern="email">
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-6 columns">
                                    <label>Nacionalidad(*)
                                        <input type="text" id="nacionalidad2" name="nacionalidad2" aria-describedby="exampleHelpText" required pattern="palabras">
                                        <span class="form-error">
                                          Campo inválido.
                                        </span>
                                    </label>
                                </div>
                                <div class="medium-6 columns">
                                    <label>Años trabajados(*)
                                        <input type="text" id="annosTrabajados" name="annosTrabajados" aria-describedby="exampleHelpText" required pattern="number">
                                        <span class="form-error">
                                          Campo inválido.
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-6 columns">
                                    <label>Telefóno(*)
                                        <input type="text" id="telefono2" name="telefono2" aria-describedby="exampleHelpText" required pattern="number">
                                        <span class="form-error">
                                          Campo inválido.
                                        </span>
                                    </label>
                                </div>
                                <div class="medium-6 columns">
                                    <label>Otro teléfono
                                        <input type="text" id="otro_telefono2" name="otro_telefono2" aria-describedby="exampleHelpText" pattern="number">
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-6 columns">
                                    <label>Ciclo Formativo de grado superior(*)
                                        <select id="ciclo2" name="ciclo2" required>
                                            <?php
                                            $ciclos=cargarCiclos();
                                            foreach($ciclos as $key){
                                                echo '<option value="'.$key['id'].'">'.$key['nombre'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>
                                <div class="medium-6 columns medium-centered">
                                    <label>Convocatoria(*)
                                        <select name="convocatoria2" id="convocatoria2" required>
                                            <?php
                                            $convocatorias=cargarConvocatorias();
                                            foreach($convocatorias as $key){
                                                echo '<option value="'.$key['id'].'">'.$key['anno'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    <span class="form-error">
                                      Campo inválido.
                                    </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-centered medium-6 columns">
                                    <label>Funcionario(*)
                                        Sí<input type="radio" name="funcionario" id="funcionario" value="1" checked>
                                        No<input type="radio" name="funcionario" id="funcionario" value="0">
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-centered medium-10 columns">
                                    <label>
                                        Idiomas:
                                    </label>
                                    <?php
                                    $idiomas=cargarIdiomas();
                                    foreach($idiomas as $key){
                                        echo "<div class='row'>";
                                        echo "<div class='medium-centered medium-2 columns'>";
                                            echo "<label class='centrar'>";
                                            echo "<b>".$key['idioma'].':</b>';
                                            echo "</label>";
                                        echo "</div>";
                                        echo "<div class='medium-12 medium-centered columns centrar'>
                                        <table>
                                            <tr><th>Ninguno</th><th>A1</th><th>A2</th><th>B1</th><th>B2</th><th>C1</th><th>C2</th></tr>
                                             <tr><td><input type='radio' id='idioma".$key['id']."' name='idiomas[".$key['idioma']."]' value='Ninguno' checked></td>
                                             <td><input type='radio' id='idioma".$key['id']."' name='idiomas[".$key['idioma']."]' value='A1'></td>
                                             <td><input type='radio' id='idioma".$key['id']."' name='idiomas[".$key['idioma']."]' value='A2'></td>
                                             <td><input type='radio' id='idioma".$key['id']."' name='idiomas[".$key['idioma']."]' value='B1'></td>
                                             <td><input type='radio' id='idioma".$key['id']."' name='idiomas[".$key['idioma']."]' value='B2'></td>
                                             <td><input type='radio' id='idioma".$key['id']."' name='idiomas[".$key['idioma']."]' value='C1'></td>
                                             <td><input type='radio' id='idioma".$key['id']."' name='idiomas[".$key['idioma']."]' value='C2'></td>
                                             </tr>
                                         </table>
                                        </div>
                                        </div>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-centered medium-10 columns">
                                    <label class="centrar">Compromiso(*)
                                        Sí<input type="radio" name="compromiso" id="compromiso" value="1" checked>
                                        No<input type="radio" name="compromiso" id="compromiso" value="0">
                                    </label>
                                    <label>
                                        (*)Compromiso por parte del participante:
                                    </label>
                                    <label>
                                        - La aplicación en el aula de los conocimientos adquiridos
                                    </label>
                                    <label>
                                        - Difusión
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Subida de archivos</legend>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">
                                    <label>Subir Programa Formativo
                                        <input type="file" multiple aria-describedby="exampleHelpText" name="archivoPrograma">
                                        <a id="archivoPrograma" target="_blank" class="boton"><img src="img/icono_upload.png"></a>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">
                                    <label>Subir Informe Empresa de acogida
                                        <input type="file" multiple aria-describedby="exampleHelpText" name="archivoInforme">
                                        <a id="archivoInforme" target="_blank" class="boton"><img src="img/icono_upload.png"></a>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row margintop30px">
                            <div class="medium-6 medium-centered columns">
                                <label class="centrar">
                                    <button type="submit" class="button" id="submit" name="submit">Enviar</button>
                                </label>
                            </div>
                            <div data-abide-error class="alert callout" style="display: none;">
                                <p class="centrar"><i class="fi-alert"></i> Hay errores en tu formulario. Comprueba los campos</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--Footer-->
        <div class="row margintop30px">
            <div class="medium-12 columns fondo_footer">
                <div class="medium-3 columns margin30px letra_contacto">
                    <h5 class="widget-title">Contacto</h5>
                    <p class="letra_footer">Código: 14700079<br />
                        Calle: Arcos de la frontera s/n<br />
                        CP: 14014 Córdoba<br />
                        Teléfono: 957379710<br />
                        Fax: 957436311<br />
                        email: erasmus@iesgrancapitan.org</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/vendor/jquery.js"></script>
<script src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="js/vendor/what-input.js"></script>
<script src="js/vendor/foundation.js"></script>
<script src="js/app.js"></script>

</body>
</html>
