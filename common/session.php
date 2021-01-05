<?php
session_start();

if (!isset($_SESSION["isLogged"]) or !$_SESSION["isLogged"]){
session_destroy();
}