<?php
session_start();
include_once "../../common/funzioni.php";
include_once "../../common/query.php";
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
$offset = isset($_GET["offset"])?$_GET["offset"]:'0';

$utente["annunciAcquistati"] = trovaAnnunciAcquistati_sql($cid, $utente["codiceFiscale"], isset($_SESSION["isLogged"]) ? $_SESSION["codiceFiscale"] : '', $offset);

if ($utente["annunciAcquistati"] == null) {
    $risultato["errore"] = true;
}

$risultato["html"] = '<div class="container pb-5 mt-n2 mt-md-n3">
            <div class="row">
                <div class="col-md-12">';

$haAcquisti = nAnnunciAcquistatiVisibili_sql($cid, $utente["codiceFiscale"], isset($_SESSION["isLogged"]) ? $_SESSION["codiceFiscale"] : '');
    $maxPagina = intval(($haAcquisti-1)/3);
if (!$haAcquisti) {
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
                                    <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo1"><a href="' . urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']) . '" target="_blank">' . $annuncio["titolo"] . '</a></h3>
                                    <div class="font-size-sm" id="prodotto1"><span class="text-muted mr-2">Prodotto:</span>' . $annuncio["prodotto"] . '</div>
                                    <div class="font-size-sm" id="tempoUsura1"><span class="text-muted mr-2"><b>' . $annuncio["statoUsura"] . '</b></span></div>
                                    <div class="font-size-lg text-primary pt-2" id="prezzo1">€' . $annuncio["prezzo"] . '</div>
                                </div>
                            </div>
                        </div>';
}

$risultato["html"] .= '</div>
            </div>
        </div>';

if ($haAcquisti) {
    $risultato["html"] .= '<nav class="pagination-wrapper pagination-box d-flex justify-content-between" aria-label="Esempio di navigazione con jump to page">
            <ul class="pagination">
            <li class="page-item">
                    <button class="page-link '. ($offset==0?'text-secondary':'') . '" onclick="popolaAnnunciAcquistati(\'' . base64_encode($utente["codiceFiscale"]) . '\', 0)" ' . ($offset==0?'disabled':'') . '>
                        <i class="fas fa-angle-double-left"></i>   
                    </button>
                </li>
                <li class="page-item">
                    <button class="page-link '. ($offset==0?'text-secondary':'') . '" onclick="popolaAnnunciAcquistati(\'' . base64_encode($utente["codiceFiscale"]) . '\', ' . (($offset-1)>=0?($offset-1):0) . ')" ' . ($offset==0?'disabled':'') . '>
                        <i class="fas fa-angle-left"></i>
                    </button>
                </li>
                <li class="page-item active">
                    <button class="page-link" aria-current="page">' . ($offset+1) . '</button>
                </li>
                <li class="page-item">
                    <button class="page-link '. ($offset==$maxPagina?'text-secondary':'') . '" onclick="popolaAnnunciAcquistati(\'' . base64_encode($utente["codiceFiscale"]) . '\', ' . (($offset+1)<=$maxPagina?($offset+1):$maxPagina) . ')" ' . ($offset==$maxPagina?'disabled':'') . '>
                        <i class="fas fa-angle-right"></i>
                    </button>
                </li>
                <li class="page-item">
                    <button class="page-link '. ($offset==$maxPagina?'text-secondary':'') . '" onclick="popolaAnnunciAcquistati(\'' . base64_encode($utente["codiceFiscale"]) . '\', ' . $maxPagina . ')" ' . ($offset==$maxPagina?'disabled':'') . '>
                        <i class="fas fa-angle-double-right"></i>   
                    </button>
                </li>
            </ul>
            <div class="form-group page-box">
                <label for="jumpToPageAnnunciAcquistati">
                    <input type="text" class="form-control" id="jumpToPageAnnunciAcquistati" maxlength="2" placeholder="/' . ($maxPagina + 1) . '" onchange="popolaAnnunciAcquistati(\'' . base64_encode($utente["codiceFiscale"]) . '\', controllaVaia(value, ' . ($maxPagina+1) . ')-1)">
                    Vai a ...
                </label>
            </div>
        </nav>';
}

echo json_encode($risultato);