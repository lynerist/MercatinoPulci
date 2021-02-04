<?php
session_start();
include_once "../common/funzioni.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$titolo = $_POST["titolo"];
$prezzo = $_POST["prezzo"];
$categoria = $_POST["categoria"];
$sottocategoria = $_POST["sottocategoria"];
$prodotto = $_POST["prodotto"];
$visibilita = $_POST["visibilita"];
$statoUsura = $_POST["statoUsura"];
$tempoUsura = $_POST["tempoUsura"];
$scadenzaGaranzia = $_POST["scadenzaGaranzia"];
$luogoVenditaRegione = $_POST["luogoVenditaRegione"];
$luogoVenditaProvincia = $_POST["luogoVenditaProvincia"];
$luogoVenditaComune = $_POST["luogoVenditaComune"];

$regioneVisibilita = array();
$provinciaVisibilita = array();
$comuneVisibilita = array();

$iterator = 0;
while (isset($_POST["regione_" . $iterator])){
    $regioneVisibilita[] = $_POST["regione_" . $iterator];
    $provinciaVisibilita[] = $_POST["provincia_" . $iterator];
    $comuneVisibilita[] = $_POST["comune_" . $iterator];
}







//Gestione foto
$currentDirectory = substr(getcwd(), 0, -7);
$uploadDirectory = "fotoAnnuncio/";

$fileName = $_FILES['foto']['name'];
$fileTmpName  = $_FILES['foto']['tmp_name'];
$fileExtension = strtolower(explode('.', $fileName)[1]);

if ($fileName != ""){
    $uploadPath = $currentDirectory . $uploadDirectory . modificaFotoAnnuncio_sql($cid, $_GET["dop"], $_SESSION["codiceFiscale"], $fileExtension);
    move_uploaded_file($fileTmpName, $uploadPath);
}

header('Location: ' . $_SERVER["HTTP_REFERER"]);
