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
                <h4 class="letra_blanca padding40px">Solicitud</h4>
            </div>
        </div>
        <!--Formulario-->
        <div class="row margintop30px">
            <div class="large-centered large-6 columns">
                <form data-abide novalidate method="post" action="annadirEstudiante.php" enctype="multipart/form-data">
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
                    <div id="dni_error" class="alert callout" style="display: none">
                        <p class="centrar"><i class="fi-alert"></i>La solicitud Erasmus no está disponible para este usuario.</p>
                    </div>
                    <div class="medium-centered medium-6 columns">
                        <fieldset>
                            <legend>Introduce tu DNI</legend>
                            <label>DNI
                                <input type="text" id="dni" name="dni" placeholder="Ej:00000000X" aria-describedby="exampleHelpText" required pattern="dni">
                                <button type="button" class="button" id="comprobar">Comprobar</button>
                            <span class="form-error">
                              DNI inválido.
                            </span>
                            </label>
                        </fieldset>
                    </div>
                    <!--Resto del formulario que aparece oculto hasta que no exista un DNI correcto en la BD-->
                    <div id="formulario_oculto">
                        <div class="row">
                            <div class="medium-12 medium-centered columns">
                                <span id="aviso">Rellena los campos que faltan</span>
                            </div>
                        </div>
                        <fieldset>
                            <legend>Datos personales</legend>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">
                                    <label>Nombre(*)
                                        <input type="text" placeholder="Nombre" id="nombre" name="nombre" aria-describedby="exampleHelpText" required>
                             <span class="form-error">
                              Campo inválido.
                            </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-6 columns">
                                    <label>Fecha de Nacimiento(*)
                                        <input type="text" placeholder="dd/mm/aaaa" id="fechaNac" name="fechaNac" aria-describedby="exampleHelpText" required>
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                                <div class="medium-6 columns">
                                    <label>Email(*)
                                        <input type="email" placeholder="example@example.com" id="email" name="email" aria-describedby="exampleHelpText" required pattern="email">
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-6 columns">
                                    <label>Nacionalidad(*)
                                        <input type="text" id="nacionalidad" name="nacionalidad" aria-describedby="exampleHelpText" required pattern="palabras">
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                                <div class="medium-6 columns">
                                    <label>C.P.(*)
                                        <input type="text" placeholder="CP" id="cp" name="cp" aria-describedby="exampleHelpText" required pattern="number">
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-6  columns">
                                    <label>Dirección(*)
                                        <input type="text" id="direccion" name="direccion" aria-describedby="exampleHelpText" required>
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                                <div class="medium-6 columns">
                                    <label>Población(*)
                                        <input type="text" id="poblacion" name="poblacion" aria-describedby="exampleHelpText" required pattern="palabras">
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-6 columns">
                                    <label>Telefóno(*)
                                        <input type="text" id="telefono" name="telefono" aria-describedby="exampleHelpText" required pattern="number">
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                                <div class="medium-6 columns">
                                    <label>Otro teléfono
                                        <input type="text" id="otro_telefono" name="otro_telefono" aria-describedby="exampleHelpText" pattern="number">
                        <span class="form-error">
                          Campo inválido.
                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-6 columns">
                                    <label>Ciclo Formativo de grado superior(*)
                                        <select id="ciclo" name="ciclo" required>
                                            <?php
                                            $ciclos=cargarCiclos();
                                            foreach($ciclos as $key){
                                                echo '<option value="'.$key['id'].'">'.$key['nombre'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>
                                <div class="medium-6 columns">
                                    <label>Tutor/a(*)
                                        <select id="tutor" name="tutor" required>
                                            <?php
                                            $tutores=cargarTutores();
                                            foreach($tutores as $key){
                                                echo '<option value="'.$key['id'].'">'.$key['nombre'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">
                                    <label>Experiencia laboral anterior:
                                        <label>
                                            <textarea name="experiencia_laboral" id="experiencia_laboral"></textarea>
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">
                                    <label>Otros estudios:
                                        <label>
                                            <textarea name="otros_estudios" id="otros_estudios"></textarea>
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-6 columns medium-centered">
                                    <label>Convocatoria(*)
                                        <select name="convocatoria" id="convocatoria" required>
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
                        </fieldset>


                        <fieldset>
                            <legend>País de preferencia para realizar la FCT:</legend>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">

                                    <label class="centrar">
                                        <label>Primera opción:(*)
                                            <select id="pais1" name="pais1" required>
                                                <option value="">--Elegir país--</option>
                                                <?php
                                                $paises= cargarPais();
                                                foreach($paises as $key){
                                                    echo '<option value="'.$key['codigo'].'">'.$key['nombre'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </label>
                                        <label>Segunda opción:
                                            <select id="pais2" name="pais2" disabled>
                                                <option value="">--Elegir país--</option>
                                                <?php
                                                foreach($paises as $key){
                                                    echo '<option value="'.$key['codigo'].'">'.$key['nombre'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </label>
                                        <label>Tercera opción:
                                            <select id="pais3" name="pais3" disabled>
                                                <option value="">--Elegir país--</option>
                                                <?php
                                                foreach($paises as $key){
                                                    echo '<option value="'.$key['codigo'].'">'.$key['nombre'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </label>
                                    </label>

                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Subida de archivos</legend>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">
                                    <label>Subir CV(*)
                                        <input type="file" multiple aria-describedby="exampleHelpText" name="archivoCv">
                                        <a id="archivoCv" target="_blank" class="boton"><img src="img/icono_upload.png"></a>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">
                                    <label>Subir Pasaporte de Lenguas(*)
                                        <input type="file" multiple aria-describedby="exampleHelpText" name="archivoPasaporte">
                                        <a id="archivoPass" target="_blank" class="boton"><img src="img/icono_upload.png"></a>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">
                                    <label>Subir Carta(*)
                                        <input type="file" multiple aria-describedby="exampleHelpText" name="archivoCarta">
                                        <a id="archivoCarta" target="_blank" class="boton"><img src="img/icono_upload.png"></a>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-8 columns medium-centered">
                                    <label>Subir DNI(*)
                                        <input type="file" multiple aria-describedby="exampleHelpText" name="archivoDni">
                                        <a id="archivoDni" target="_blank" class="boton"><img src="img/icono_upload.png"></a>
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
