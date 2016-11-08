<?php
/**
 * Created by PhpStorm.
 * User: sempe
 * Date: 05/11/2016
 * Time: 17:56
 */
session_start();
unset($_SESSION);
session_destroy();
header("Location:index.php");