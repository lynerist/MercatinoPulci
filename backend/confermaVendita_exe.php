<?php 
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$venditore 	= 	base64_decode($_GET["v"]);
$acquirente = 	base64_decode($_GET["a"]);
$dop 		=	base64_decode($_GET["dop"]);

confermaVendita_sql($cid, $dop, $venditore, $acquirente);
smettiDiOsservare_sql($cid, $dop, $venditore, "");

header('Location: ' . $_SERVER["HTTP_REFERER"]);
