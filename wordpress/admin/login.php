<?php
include "cabecera.php";
?>
    <!--Caja azul-->
    <div class="row">
        <div class="medium-centered medium-12 columns fondo_azul">
            <h4 class="letra_blanca padding40px">Login</h4>
        </div>
    </div>
    <div class="row margintop30px">
        <div class="medium-6 medium-centered large-4 large-centered columns">
            <form data-abide novalidate method="post" action="gestionarLogin.php">
                <!--Mostrar el error mediante php si el formulario no ha sido validado-->
                <?php
                if(isset($_GET['mensaje'])){
                    if($_GET['mensaje']=="notfound"){
                        echo '<div data-abide-error class="alert callout">
                            <p><i class="fi-alert"></i> Usuario no encontrado</p>
                             </div>';
                    }if($_GET['mensaje']=="error"){
                        echo '<div data-abide-error class="alert callout">
                            <p><i class="fi-alert"></i>El formulario contiene errores</p>
                             </div>';
                    }
                }
                ?>
                <div class="row">
                    <div class="small-12 columns">
                        <label>Usuario
                            <input type="text" id="user" name="user" aria-describedby="exampleHelpText" required pattern="alpha_numeric">
                                <span class="form-error">
                                  Campo inválido.
                                </span>
                        </label>
                    </div>
                    <div class="small-12 columns">
                        <label>Password
                            <input type="password" id="password" name="password" aria-describedby="exampleHelpText" required pattern="alpha_numeric">
                                <span class="form-error">
                                  Campo inválido
                                </span>
                        </label>
                    </div>
                <div class="row centrar">
                        <button class="button" type="submit" name="submit" value="Submit">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>