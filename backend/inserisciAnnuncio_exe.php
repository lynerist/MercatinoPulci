<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$venditore = $_SESSION["codiceFiscale"];
$titolo = mysqli_real_escape_string($cid, $_POST["titolo"]);
$prezzo = mysqli_real_escape_string($cid, $_POST["prezzo"]);
$categoria = $_POST["categoria"];
$sottocategoria = $_POST["sottocategoria"];
$prodotto = mysqli_real_escape_string($cid, $_POST["prodotto"]);
$visibilita = $_POST["visibilita"];
$statoUsura = $_POST["statoUsura"];
$tempoUsura = mysqli_real_escape_string($cid, $_POST["tempoUsura"]);
$scadenzaGaranzia = mysqli_real_escape_string($cid, $_POST["scadenzaGaranzia"]);
$luogoVenditaRegione = mysqli_real_escape_string($cid, $_POST["luogoVenditaRegione"]);
$luogoVenditaProvincia = mysqli_real_escape_string($cid, $_POST["luogoVenditaProvincia"]);
$luogoVenditaComune = mysqli_real_escape_string($cid, $_POST["luogoVenditaComune"]);

$regioneVisibilita = array();
$provinciaVisibilita = array();
$comuneVisibilita = array();

$iterator = 0;
while (isset($_POST["regione_" . $iterator])) {
    $regioneVisibilita[] = mysqli_real_escape_string($cid, $_POST["regione_" . $iterator]);
    $provinciaVisibilita[] = mysqli_real_escape_string($cid, $_POST["provincia_" . $iterator]);
    $comuneVisibilita[] = mysqli_real_escape_string($cid, $_POST["comune_" . $iterator]);
    $iterator++;
}

if ($statoUsura == "nuovo") $tempoUsura = 0;
if ($scadenzaGaranzia == "") $scadenzaGaranzia = 'NULL';

$parametri = "Nt=$titolo&Nct=$categoria&Nsc=$sottocategoria&Npd=$prodotto&Nv=$visibilita&Nsu=$statoUsura&Nr=$luogoVenditaRegione&Np=$luogoVenditaProvincia&Nc=$luogoVenditaComune";

$validPrice = preg_match("/^[1-9][0-9]{0,3}((.|,)[0-9]{1,2})?$/", $prezzo);
$validTempoUsura = ($statoUsura == "nuovo" or $statoUsura != "nuovo" and $tempoUsura > 0);
$validScadenzaGaranzia = ($statoUsura != "nuovo" or strtotime($scadenzaGaranzia) > time() or $scadenzaGaranzia == "NULL");

if ($scadenzaGaranzia != "NULL") $scadenzaGaranzia = "'" . $scadenzaGaranzia . "'";



if (!($validPrice or $validTempoUsura or $validScadenzaGaranzia)){
    header("location: ../index.php?" . $parametri . "&Nerr=PTG");
    exit;
}elseif (!($validPrice or $validTempoUsura)){
    header("location: ../index.php?" . $parametri . "&Nsg=" . $scadenzaGaranzia . "&Nerr=PT");
    exit;
}elseif (!($validPrice or $validScadenzaGaranzia)){
    header("location: ../index.php?" . $parametri . "&Ntu=" . $tempoUsura . "&Nerr=PG");
    exit;
}elseif (!($validTempoUsura or $validScadenzaGaranzia)){
    header("location: ../index.php?" . $parametri . "&Npz=" . $prezzo . "&Nerr=TG");
    exit;
}elseif (!$validPrice){
    header("location: ../index.php?" . $parametri . "&Ntu=" . $tempoUsura . "&Nsg=" . $scadenzaGaranzia . "&Nerr=P");
    exit;
}elseif (!$validTempoUsura){
    header("location: ../index.php?" . $parametri . "&Npz=" . $prezzo . "&Nsg=" . $scadenzaGaranzia . "&Nerr=T");
    exit;
}elseif (!$validScadenzaGaranzia){
    header("location: ../index.php?" . $parametri . "&Npz=" . $prezzo .  "&Ntu=" . $tempoUsura . "&Nerr=G");
    exit;
}

if ($statoUsura == "nuovo"){
    $statoUsura = "NULL";
}else{
    $scadenzaGaranzia = "NULL";
    $statoUsura = "'" . $statoUsura . "'";
}


inserisciAnnuncio_sql($cid, $venditore, $titolo, $prodotto, $categoria, $sottocategoria, $prezzo, $statoUsura, $tempoUsura, $scadenzaGaranzia, $visibilita, $luogoVenditaComune, $luogoVenditaProvincia);

$dataOraPubblicazione = ricavaDataOraPubblicazione($cid, $venditore);

for ($i=0; $i<$iterator; $i++) {
    inserisciAreaVisibilita($cid, $dataOraPubblicazione, $venditore, $regioneVisibilita[$i], $provinciaVisibilita[$i], $comuneVisibilita[$i]);
}

//Gestione foto
$currentDirectory = substr(getcwd(), 0, -7);
$uploadDirectory = "fotoAnnuncio/";

$fileName = $_FILES['foto']['name'];
$fileTmpName  = $_FILES['foto']['tmp_name'];
$fileExtension = strtolower(explode('.', $fileName)[1]);

if ($fileName != ""){
    $uploadPath = $currentDirectory . $uploadDirectory . modificaFotoAnnuncio_sql($cid, $dataOraPubblicazione, $venditore, $fileExtension);
    move_uploaded_file($fileTmpName, $uploadPath);
}

header("location: ../" . urlCriptato($venditore, $dataOraPubblicazione));
