<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 05/11/2016
 * Time: 17:14
 */
session_start();
include "cabeceraAdmin.php";
if($_SESSION['perfil']!='administrador' and $_SESSION['perfil']!='colaborador')
    header("Location: login.php");
include "cajaazul.php";
include "info.php";
include "footer.php";