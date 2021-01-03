<?php
session_start();
if (true){
    $_SESSION["isLogged"] = true;
    $_SESSION["codiceFiscale"] = 'SLNFPP98S28F205V';
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}