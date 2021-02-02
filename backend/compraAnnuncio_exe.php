<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$dataOraPubblicazione = base64_decode($_GET["dop"]);
$venditore = base64_decode($_GET["v"]);
$richiestaDiAcquisto = $_POST["metodoPagamento"];

smettiDiOsservare_sql($cid, $dataOraPubblicazione, $venditore, $_SESSION["codiceFiscale"]);
acquista_sql($cid, $dataOraPubblicazione, $venditore, $_SESSION["codiceFiscale"], $richiestaDiAcquisto);

header("location: ../richiestaDiAcquisto.php?");
