<?php
session_start();
session_destroy();

if (!isset($_SESSION["isLogged"]) or !$_SESSION["isLogged"]){
session_destroy();
}