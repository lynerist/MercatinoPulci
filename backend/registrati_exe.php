<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$nome = mysqli_real_escape_string($cid, $_POST["regNome"]);
$cognome = mysqli_real_escape_string($cid, $_POST["regCognome"]);
$codiceFiscale = mysqli_real_escape_string($cid, $_POST["regCodiceFiscale"]);
$regione = mysqli_real_escape_string($cid, $_POST["regRegione"]);
$provincia = mysqli_real_escape_string($cid, $_POST["regProvincia"]);
$comune = mysqli_real_escape_string($cid, $_POST["regComune"]);
$email = mysqli_real_escape_string($cid, $_POST["regEmail"]);
$password = md5($_POST["regPassword"]);
$passwordRipetuta = md5($_POST["regPasswordRipetizione"]);
$tipoAccount = $_POST["regTipoAccount"];
$newsletter = isset($_POST["regNewsletter"]) and $_POST["regNewsletter"] == "on";

$notUnique = "&nm=$nome&cg=$cognome&rg=$regione&pr=$provincia&cm=$comune&tp=$tipoAccount&nw=$newsletter";

$res = $cid -> query("SELECT * FROM utente WHERE email = '$email';");
$uniqueEmail = !($res -> num_rows);

$res = $cid -> query("SELECT * FROM utente WHERE codiceFiscale = '$codiceFiscale';");
$uniqueCodiceFiscale = !($res -> num_rows);

$link = explode('?', $_SERVER['HTTP_REFERER']);
$_SERVER["HTTP_REFERER"] = $link[0];

if (!$uniqueCodiceFiscale and !$uniqueEmail){
    header("location: " . $_SERVER["HTTP_REFERER"] . (parse_url($_SERVER["HTTP_REFERER"], PHP_URL_QUERY) ? '&' : '?') . "dberr=CfE" . $notUnique);
    exit;
} elseif (!$uniqueCodiceFiscale){
    header("location: " . $_SERVER["HTTP_REFERER"] . (parse_url($_SERVER["HTTP_REFERER"], PHP_URL_QUERY) ? '&' : '?') . "dberr=Cf&E=". $email . $notUnique);
    exit;
}elseif (!$uniqueEmail){
    header("location: " . $_SERVER["HTTP_REFERER"] . (parse_url($_SERVER["HTTP_REFERER"], PHP_URL_QUERY) ? '&' : '?') . "dberr=E&Cf=". $codiceFiscale . $notUnique);
    exit;
}

$registrati = "INSERT INTO utente (codiceFiscale, tipoAccount, nome, cognome, email, password, immagine, comune, provincia, eliminato) VALUES ('" . $codiceFiscale . "', '" . $tipoAccount . "', '" . $nome . "', '" . $cognome . "', '" . $email . "', '" . $password . "', null, '" . $comune . "', '" . $provincia . "', '0')";
$res = $cid->query($registrati);

session_start();
$_SESSION["isLogged"] = true;
$_SESSION["codiceFiscale"] = $codiceFiscale;
$_SESSION["tipoAccount"] = $tipoAccount;
$_SESSION["nome"] = $nome;

header('Location: ' . $_SERVER["HTTP_REFERER"]);