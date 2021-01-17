<?php
require_once "common/session.php";

$annuncio["dataOraPubblicazione"] = "2021-01-07 00:00:00";
$annuncio["venditore"] = "SLNFPP98S28F205V";
$annuncio["titolo"] = "Chitarra Lidl";
$annuncio["statoAnnuncio"] = "inVendita";
$annuncio["prodotto"] = "Chitarra";
$annuncio["tempoUsura"] = intval("1");
$annuncio["prezzo"] = "100.00";
$annuncio["fotoAnnuncio"] = "lidl.jpeg";
if ($annuncio["statoAnnuncio"] == "inVendita") {
    $annuncio["scadenza"] = calcolaScadenza($annuncio["dataOraPubblicazione"], $annuncio["venditore"], $annuncio["tempoUsura"]);
    if ($annuncio["scadenza"] < 1) $annuncio["statoAnnuncio"] = "eliminato";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Annunci osservati</title>
    <?php include_once "common/common_header.php" ?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" type="text/css" href="css/watched.css">
</head>
<body>
<?php include_once "common/navbar.php" ?>

<h1 class="title-watched container">Annunci osservati</h1>

<div id="containerOsservati" class="container pb-5 mt-n2 mt-md-n3 drop-shadow altezza-minima">


<!--    --><?php
//    $item1 = "";
//    $item2 = "";
////    ciclo for che simula il numero di risultati query
//    for ($i = 0; $i < 7; $i++){
//        $token = '<div class="justify-content-between my-4 pb-4 border-bottom col-md-6" id="' . $i . '">
//            <div class="media d-block d-sm-flex text-center text-sm-left">
//                <a class="cart-item-thumb mx-auto mr-sm-4" href="' . urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']) . '" target="_blank">
//                    <img src="fotoAnnuncio/' . (is_null($annuncio['fotoAnnuncio'])?'image_not_found.png':$annuncio['fotoAnnuncio']) . '" alt="Product" id="foto' . $i . '">
//                </a>
//                <div class="media-body pt-3">
//                    <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo' . $i . '">
//                        <a href="' . urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']) . '" target="_blank">' . $annuncio['titolo'] .'</a>
//                    </h3>
//                    <div class="font-size-sm" id="prodotto' . $i . '"><span class="text-muted mr-2">Prodotto:</span>' . $annuncio['prodotto'] . '</div>
//                    <div class="font-size-sm" id="tempoUsura' . $i . '"><span class="text-muted mr-2"><b>' . array("Usato", "Nuovo")[$annuncio["tempoUsura"] == 0] . '</b></span></div>
//                    <div class="font-size-lg text-primary pt-2" id="prezzo1">€' . $annuncio['prezzo'] . '</div>
//                    <div class="non-osservare">
//                        <button type="button" class="btn btn-secondary btn-outline-danger btn-sm" data-dismiss="modal" id="rimuovi' . $i . '" onclick="rimuovi(id, \'annulla' . $i . '\')">Rimuovi</button>
//                        <button type="button" class="btn btn-secondary btn-outline-warning btn-sm" data-dismiss="modal" id="annulla' . $i . '" onclick="rimuovi(id, \'rimuovi' . $i . '\')">Annulla</button>
//                    </div>
//                </div>
//            </div>
//        </div>';
//        if ($item1 == "") $item1 = $token;
//        elseif ($item2 == "") $item2 = $token;
//        else {
//            echo '<div class="col-md-12 d-flex flex-row row">' . $item1 . $item2 . '</div>';
//            $item1 = $token;
//            $item2 = "";
//        }
//    }
//    echo '<div class="col-md-12 d-flex flex-row row">' . $item1 . $item2 . '</div>';
//    ?>



</div>

<?php include_once "common/footer.php" ?>

<?php include_once "common/common_script.php"; ?>
<script src="js/bottoni.js"></script>
<script src="js/aggiornaOsservati.js"></script>
<script>aggiornaOsservati()</script>

</body>
</html>
