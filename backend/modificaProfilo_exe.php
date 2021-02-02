<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$nome = mysqli_real_escape_string($cid, $_POST["modificaNome"]);
$cognome = mysqli_real_escape_string($cid, $_POST["modificaCognome"]);
$email = mysqli_real_escape_string($cid, $_POST["modificaEmail"]);
$regione = mysqli_real_escape_string($cid, $_POST["modificaRegione"]);
$provincia = mysqli_real_escape_string($cid, $_POST["modificaProvincia"]);
$comune = mysqli_real_escape_string($cid, $_POST["modificaComune"]);
$tipoAccount = $_POST["modificaTipoAccount"];
$nuovaPassword = md5($_POST["nuovaPassword"]);
$passwordRipetuta = md5($_POST["ripetiNuovaPassword"]);
$passwordCorrente = md5($_POST["passwordCorrente"]);

$parametri = "&Mnm=$nome&Mcg=$cognome&Mrg=$regione&Mpr=$provincia&Mcm=$comune&Mtp=$tipoAccount";

$res = $cid -> query("SELECT * FROM utente WHERE email = '$email' and codiceFiscale != '". $_SESSION["codiceFiscale"] ."'");
$uniqueEmail = !($res -> num_rows);

$validPassword = ($nuovaPassword == $passwordRipetuta and (preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $_POST["nuovaPassword"]) or $_POST["nuovaPassword"] == ""));

$verifyPassword = verifyPassword_sql($cid, $_SESSION["codiceFiscale"], $_POST["passwordCorrente"]);

$_SERVER["HTTP_REFERER"] = "../" . urlCriptato($_SESSION["codiceFiscale"], "");
if (!($verifyPassword or $uniqueEmail or $validPassword)){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Merr=PENp");
    exit;
}elseif (!($verifyPassword or $uniqueEmail)){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Merr=PE");
    exit;
}elseif (!($verifyPassword or $validPassword)){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Mml=" . $email . "&Merr=PNp");
    exit;
}elseif (!($uniqueEmail or $validPassword)){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Merr=ENp");
    exit;
}elseif (!$verifyPassword){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Mml=" . $email . "&Merr=P");
    exit;
}elseif (!$uniqueEmail){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Merr=E");
    exit;
}elseif (!$validPassword){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Mml=" . $email . "&Merr=Np");
    exit;
}

$res = $cid -> query("SELECT * FROM osserva WHERE acquirente = '". $_SESSION["codiceFiscale"] . "' and richiestaDiAcquisto IS NOT NULL");
$validAccountChange = ($tipoAccount != "venditore" or !($res -> num_rows));
if (!$validAccountChange){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Mml=" . $email . "&Merr=TA");
    exit;
}

$modificaProfilo = "UPDATE utente SET nome = '$nome', cognome = '$cognome', email = '$email', provincia = '$provincia', comune = '$comune', tipoAccount = '$tipoAccount', password = '$nuovaPassword' WHERE codiceFiscale = '". $_SESSION["codiceFiscale"] . "'";
if ($_POST["nuovaPassword"] == ""){
    $modificaProfilo = "UPDATE utente SET nome = '$nome', cognome = '$cognome', email = '$email', provincia = '$provincia', comune = '$comune', tipoAccount = '$tipoAccount' WHERE codiceFiscale = '" . $_SESSION["codiceFiscale"] . "'";
}
$cid->query($modificaProfilo);

if ($tipoAccount == "venditore") $res = $cid -> query("DELETE FROM osserva WHERE acquirente = '". $_SESSION["codiceFiscale"] ."'");

if ($tipoAccount == "acquirente"){
    $cid -> query("UPDATE annuncio SET statoAnnuncio = 'eliminato' WHERE statoAnnuncio = 'inVendita' and venditore = '" . $_SESSION["codiceFiscale"] . "'");
    $cid -> query("DELETE FROM osserva WHERE venditore = '". $_SESSION["codiceFiscale"] ."'");
}

//Gestione foto
$currentDirectory = substr(getcwd(), 0, -7);
$uploadDirectory = "fotoProfilo/";

$fileName = $_FILES['foto']['name'];
$fileTmpName  = $_FILES['foto']['tmp_name'];
$fileExtension = strtolower(explode('.', $fileName)[1]);

if ($fileName != ""){
    $uploadPath = $currentDirectory . $uploadDirectory . modificaFotoProfilo_sql($cid, $_SESSION["codiceFiscale"], $fileExtension);
    move_uploaded_file($fileTmpName, $uploadPath);
}

header('Location: ' . $_SERVER["HTTP_REFERER"]);