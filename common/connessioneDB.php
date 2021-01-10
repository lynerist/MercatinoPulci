<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'mercatinopulci';
$cid = new mysqli($hostname,$username,$password,$db);

if($cid->connect_errno) die('Errore connessione (' . $cid->connect_errno . ')' . $cid->connect_error);