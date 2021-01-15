<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'mercatinopulci';
$cid = new mysqli($hostname,$username,$password,$db);

if($cid->connect_errno){
  header("location: erroreConnessione.php");
  exit;
}