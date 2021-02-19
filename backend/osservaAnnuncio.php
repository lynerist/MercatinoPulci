<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/query.php";
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'mercatinopulci';
$cid = new mysqli($hostname, $username, $password, $db);

if ($cid->connect_errno) {
    $risultato["errore"] = true;
    echo json_encode($risultato);
    exit;
}

$annuncio["dataOraPubblicazione"] = base64_decode($_GET["dop"], true);
$annuncio["venditore"] = base64_decode($_GET["v"], true);
$utente["codiceFiscale"] = isset($_SESSION["isLogged"]) ? $_SESSION["codiceFiscale"] : "";

if ($utente["codiceFiscale"] == ""){
    $osservati = array();
    if (isset($_COOKIE["annunciOsservati"])) $osservati = unserialize($_COOKIE["annunciOsservati"]);
    $nuovoOsservato = serialize(array($annuncio["dataOraPubblicazione"], $annuncio["venditore"]));
    $osservati[$nuovoOsservato] = true;

    setcookie("annunciOsservati", serialize($osservati), time() + (10 * 365 * 24 * 60 * 60), "/mercatinopulci");
}else{
    $osservatoConSuccesso = osservaAnnuncio_sql($cid, $_SESSION["codiceFiscale"], $annuncio["dataOraPubblicazione"], $annuncio["venditore"]);
    if (!$osservatoConSuccesso) {
        $risultato["errore"] = true;
        echo json_encode($risultato);
        exit;
    }
}
echo json_encode("");
