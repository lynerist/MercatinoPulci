<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$dataOraPubblicazione = $_GET["dop"];
$venditore = $_SESSION["codiceFiscale"];
$titolo = mysqli_real_escape_string($cid, $_POST["titolo"]);
$prezzo = mysqli_real_escape_string($cid, $_POST["prezzo"]);
$categoria = $_POST["categoria"];
$sottocategoria = $_POST["sottocategoria"];
$prodotto = mysqli_real_escape_string($cid, $_POST["prodotto"]);
$visibilita = $_POST["visibilita"];
$statoUsura = $_POST["statoUsura"];
$tempoUsura = mysqli_real_escape_string($cid, $_POST["tempoUsura"]);
$scadenzaGaranzia = mysqli_real_escape_string($cid, date('Y-m-d', strtotime(str_replace("/", "-", $_POST["scadenzaGaranzia"]))));
$luogoVenditaRegione = mysqli_real_escape_string($cid, $_POST["luogoVenditaRegione"]);
$luogoVenditaProvincia = mysqli_real_escape_string($cid, $_POST["luogoVenditaProvincia"]);
$luogoVenditaComune = mysqli_real_escape_string($cid, $_POST["luogoVenditaComune"]);

$regioneVisibilita = array();
$provinciaVisibilita = array();
$comuneVisibilita = array();

$iterator = 0;
while (isset($_POST["regione_" . $iterator])){
    $regioneVisibilita[] = mysqli_real_escape_string($cid, $_POST["regione_" . $iterator]);
    $provinciaVisibilita[] = mysqli_real_escape_string($cid, $_POST["provincia_" . $iterator]);
    $comuneVisibilita[] = mysqli_real_escape_string($cid, $_POST["comune_" . $iterator]);
    $iterator++;
}

if ($statoUsura == "nuovo") $tempoUsura = 0;
if ($_POST["scadenzaGaranzia"] == "") $scadenzaGaranzia = 'NULL';

$parametri = "&Mt=$titolo&Mct=$categoria&Msc=$sottocategoria&Mpd=$prodotto&Mv=$visibilita&Msu=$statoUsura&Mr=$luogoVenditaRegione&Mp=$luogoVenditaProvincia&Mc=$luogoVenditaComune";

$validPrice = preg_match("/^[1-9][0-9]{0,3}((.|,)[0-9]{1,2})?$/", $prezzo);
$validTempoUsura = ($statoUsura == "nuovo" or $statoUsura != "nuovo" and $tempoUsura > 0);
$validScadenzaGaranzia = ($statoUsura != "nuovo" or strtotime($scadenzaGaranzia) > time() or $scadenzaGaranzia == "NULL");

if ($scadenzaGaranzia != "NULL") $scadenzaGaranzia = "'" . $scadenzaGaranzia . "'";

$_SERVER["HTTP_REFERER"] = "../" . urlCriptato($venditore, $dataOraPubblicazione);
if (!($validPrice or $validTempoUsura or $validScadenzaGaranzia)){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Merr=PTG");
    exit;
}elseif (!($validPrice or $validTempoUsura)){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Msg=" . $scadenzaGaranzia . "&Merr=PT");
    exit;
}elseif (!($validPrice or $validScadenzaGaranzia)){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Mtu=" . $tempoUsura . "&Merr=PG");
    exit;
}elseif (!($validTempoUsura or $validScadenzaGaranzia)){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Mpz=" . $prezzo . "&Merr=TG");
    exit;
}elseif (!$validPrice){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Mtu=" . $tempoUsura . "&Msg=" . $scadenzaGaranzia . "&Merr=P");
    exit;
}elseif (!$validTempoUsura){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Mpz=" . $prezzo . "&Msg=" . $scadenzaGaranzia . "&Merr=T");
    exit;
}elseif (!$validScadenzaGaranzia){
    header("location: " . $_SERVER["HTTP_REFERER"] . $parametri . "&Mpz=" . $prezzo .  "&Mtu=" . $tempoUsura . "&Merr=G");
    exit;
}

if ($statoUsura == "nuovo"){
    $statoUsura = "NULL";
}else{
    $scadenzaGaranzia = "NULL";
    $statoUsura = "'" . $statoUsura . "'";
}

modificaAnnuncio_sql($cid, $titolo, $prodotto, $categoria, $sottocategoria, $prezzo, $statoUsura, $tempoUsura, $scadenzaGaranzia, $visibilita, $luogoVenditaProvincia, $luogoVenditaComune, $dataOraPubblicazione, $venditore);

//svuota areavisibilita prima di riempirlo per evitare chiavi duplicate
svuotaAreaVisibilita_sql($cid, $venditore, $dataOraPubblicazione);

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

header('Location: ' . $_SERVER["HTTP_REFERER"]);
