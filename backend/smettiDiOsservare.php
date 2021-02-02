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
    $osservati = unserialize($_COOKIE["annunciOsservati"]);
    $daRimuovere = serialize(array($annuncio["dataOraPubblicazione"], $annuncio["venditore"]));
    unset($osservati["$daRimuovere"]);
    setcookie("annunciOsservati", serialize($osservati), time() + (10 * 365 * 24 * 60 * 60), "/mercatinopulci");
}else{
    $res = smettiDiOsservare_sql($cid, $annuncio["dataOraPubblicazione"], $annuncio["venditore"], $_SESSION["codiceFiscale"]);
    if (!$res) {
        $risultato["errore"] = true;
        echo json_encode($risultato);
        exit;
    }
}

echo json_encode("");