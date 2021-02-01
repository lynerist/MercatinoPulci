<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$dataOraPubblicazione = base64_decode($_GET["dop"]);
$venditore = base64_decode($_GET["v"]);
$richiestaDiAcquisto = $_POST["metodoPagamento"];

smettiDiOsservare_sql($cid, $_SESSION["codiceFiscale"], $dataOraPubblicazione, $venditore);
$cid -> query("INSERT INTO osserva (acquirente, dataOraPubblicazione, venditore, richiestaDiAcquisto) VALUES ('" . $_SESSION["codiceFiscale"] . "', '$dataOraPubblicazione', '$venditore', '$richiestaDiAcquisto')");

header("location: ../richiestaDiAcquisto.php");
