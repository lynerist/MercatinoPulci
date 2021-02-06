<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$verifyPassword = verifyPassword_sql($cid, $_SESSION["codiceFiscale"], $_POST["passwordEliminaProfilo"]);

$_SERVER["HTTP_REFERER"] = "../" . urlCriptato($_SESSION["codiceFiscale"], "");
if (!$verifyPassword){
    header("location: " . $_SERVER["HTTP_REFERER"] . "&Mep=ko");
    exit;
}

$cid -> query("UPDATE utente SET eliminato = '1' WHERE codiceFiscale = '" . $_SESSION["codiceFiscale"] . "'");
$cid -> query("UPDATE annuncio SET statoAnnuncio = 'eliminato' WHERE statoAnnuncio = 'inVendita' and venditore = '" . $_SESSION["codiceFiscale"] . "'");
smettiDiOsservare_sql($cid, "", $_SESSION["codiceFiscale"], $_SESSION["codiceFiscale"]);
rimuoviVisibilitaAnnuncio_sql($cid, "", $_SESSION["codiceFiscale"]);

header("location: ../profilo_eliminato.php?status=eliminato");
