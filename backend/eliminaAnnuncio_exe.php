<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$cid -> query("UPDATE annuncio SET statoAnnuncio = 'eliminato' WHERE venditore = '" . $_GET["v"] . "' and dataOraPubblicazione = '" . $_GET["dop"] . "'");
smettiDiOsservare_sql($cid, $_GET["dop"], $_GET["v"], "");
rimuoviVisibilitaAnnuncio_sql($cid, $_GET["dop"], $_GET["v"]);

header("location: ../annuncio_eliminato.php");
