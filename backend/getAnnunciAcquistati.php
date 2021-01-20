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

$utente["codiceFiscale"] = base64_decode($_GET["cf"], true);
$utente["annunciAcquistati"] = trovaAnnunciAcquistati_sql($cid, $utente["codiceFiscale"], isset($_SESSION["isLogged"]) ? $_SESSION["codiceFiscale"] : '');

if ($utente["annunciAcquistati"] == null) {
    $risultato["errore"] = true;
}

$risultato["html"] = '<div class="container pb-5 mt-n2 mt-md-n3">
            <div class="row">
                <div class="col-md-12">';

if (!($utente["annunciAcquistati"]->num_rows)) {
    $risultato["html"] .= '<div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                                                <h2 class="container">Ancora nessun acquisto</h2>
                                                </div>';
}

while ($annuncio = $utente["annunciAcquistati"]->fetch_assoc()) {
    $annuncio["statoUsura"] = array("Usato", "Nuovo")[0 == $annuncio["tempoUsura"]];

    $risultato["html"] .= '<div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom">
                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                <a class="cart-item-thumb mx-auto mr-sm-4" href="' . urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']) . '" target="_blank"><img src="fotoAnnuncio/' . inserisciFotoAjax($annuncio['fotoAnnuncio']) . '" alt="Product" id="foto1"></a>
                                <div class="media-body pt-3">
                                    <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo1"><a href="' . urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']) . '" target="_blank">' . utf8_encode($annuncio["titolo"]) . '</a></h3>
                                    <div class="font-size-sm" id="prodotto1"><span class="text-muted mr-2">Prodotto:</span>' . utf8_encode($annuncio["prodotto"]) . '</div>
                                    <div class="font-size-sm" id="tempoUsura1"><span class="text-muted mr-2"><b>' . $annuncio["statoUsura"] . '</b></span></div>
                                    <div class="font-size-lg text-primary pt-2" id="prezzo1">€' . $annuncio["prezzo"] . '</div>
                                </div>
                            </div>
                        </div>';
}

$risultato["html"] .= '</div>
            </div>
        </div>
        <nav class="pagination-wrapper pagination-box" aria-label="Esempio di navigazione con jump to page">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="fas fa-angle-left"></i>
                        <span class="sr-only">Pagina precedente</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><span class="page-link">...</span></li>
                <li class="page-item sparisci-2"><a class="page-link sparisci-2" href="#">24</a></li>
                <li class="page-item sparisci"><a class="page-link sparisci" href="#">25</a></li>
                <li class="page-item active">
                    <a class="page-link" href="#" aria-current="page">26</a>
                </li>
                <li class="page-item sparisci"><a class="page-link sparisci" href="#">27</a></li>
                <li class="page-item sparisci-2"><a class="page-link sparisci-2" href="#">28</a></li>
                <li class="page-item"><span class="page-link">...</span></li>
                <li class="page-item"><a class="page-link" href="#">50</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        <span class="sr-only">Pagina successiva</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                </li>
            </ul>
            <div class="form-group page-box">
                <label for="jumpToPageAnnunciAcquistati">
                    <span aria-hidden="true"></span>
                    <input type="text" class="form-control" id="jumpToPageAnnunciAcquistati" maxlength="3">
                    Vai a ...<span class="sr-only">Indica la pagina desiderata</span>
                </label>
            </div>
        </nav>';


echo json_encode($risultato);