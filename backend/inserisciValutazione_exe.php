<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$venditore 	    = 	base64_decode($_GET["v"]);
$acquirente     = 	base64_decode($_GET["a"]);
$dop 		    =	base64_decode($_GET["dop"]);
$verso          =   $_GET["verso"];
$valutazione    =   intval(($_POST["ratingS"] + $_POST["ratingP"])/2+0.5);


inserisciValutazione_sql($cid, $dop, $venditore, $acquirente, $valutazione, $verso);

header('Location: ' . $_SERVER["HTTP_REFERER"]);
