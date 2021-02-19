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

$uniqueEmail = !(existsEmail_sql($cid, $email, $_SESSION["codiceFiscale"]));

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

$validAccountChange = ($tipoAccount != "venditore" or !(attendeRispostaARichiestaDiAcquisto_sql($cid, $_SESSION["codiceFiscale"])));
if (!$validAccountChange){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Mml=" . $email . "&Merr=TA");
    exit;
}

modificaProfilo_sql($cid, $nome, $cognome, $email, $provincia, $comune, $tipoAccount, $nuovaPassword, $_SESSION["codiceFiscale"]);

if ($tipoAccount == "venditore") smettiDiOsservare_sql($cid, "", "", $_SESSION["codiceFiscale"]);

if ($tipoAccount == "acquirente"){
    eliminaTuttiGliAnnunciDiUnVenditore_sql($cid, $_SESSION["codiceFiscale"]);
}

$_SESSION["nome"] = $nome;
$_SESSION["tipoAccount"] = $tipoAccount;

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
