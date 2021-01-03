<?php
session_start();
if (true){
    $_SESSION["isLogged"] = true;
    header("Location: ../index.php");
}