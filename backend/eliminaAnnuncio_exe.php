<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

eliminaAnnuncio_sql($cid, $_GET["dop"], $_GET["v"]);
smettiDiOsservare_sql($cid, $_GET["dop"], $_GET["v"], "");
rimuoviVisibilitaAnnuncio_sql($cid, $_GET["dop"], $_GET["v"]);

header("location: ../annuncio_eliminato.php");
