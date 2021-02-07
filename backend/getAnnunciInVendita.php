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
$offset = isset($_GET["offset"])?$_GET["offset"]:'0';


$utente["annunciInVendita"] = trovaAnnunciInVendita_sql($cid, $utente["codiceFiscale"], isset($_SESSION["isLogged"]) ? $_SESSION["codiceFiscale"] : '', $offset);

if ($utente["annunciInVendita"] == null) {
    $risultato["errore"] = true;
}

$risultato["html"] = '<div class="container pb-5 mt-n2 mt-md-n3">
                            <div class="row">
                                <div class="col-md-12">';

$haAnnunciInVendita = nAnnunciInVenditaVisibili_sql($cid, $utente["codiceFiscale"], isset($_SESSION["isLogged"]) ? $_SESSION["codiceFiscale"] : '');
$maxPagina = intval(($haAnnunciInVendita-1)/3);
if (!$haAnnunciInVendita) {
    $risultato["html"] .= '<div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                                                <h2 class="container">Ancora nessuna vendita</h2>
                                                </div>';
}
while ($annuncio = $utente["annunciInVendita"]->fetch_assoc()) {
    $annuncio["statoUsura"] = array("Usato", "Nuovo")[0 == $annuncio["tempoUsura"]];
    $annuncio["scadenza"] = calcolaScadenza($cid, $annuncio["dataOraPubblicazione"], $annuncio["venditore"], $annuncio["tempoUsura"]);
    if ($annuncio["scadenza"] < 1) {
        $annuncio["statoAnnuncio"] = "eliminato";
        continue;
    }

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

if ($haAnnunciInVendita) {

    /*'<nav class="pagination-wrapper pagination-box nav-padding" aria-label="Esempio di navigazione con jump to page">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="fas fa-angle-left"></i>
                                        <span class="sr-only">Pagina precedente</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><span class="page-link">...</span></li>
                                <li class="page-item sparisci-2"><a class="page-link sparisci-2" href="#">7</a></li>
                                <li class="page-item sparisci"><a class="page-link sparisci" href="#">8</a></li>
                                <li class="page-item active">
                                    <a class="page-link" href="#" aria-current="page">9</a>
                                </li>
                                <li class="page-item sparisci"><a class="page-link sparisci" href="#">10</a></li>
                                <li class="page-item sparisci-2"><a class="page-link sparisci-2" href="#">11</a></li>
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
                                <label for="jumpToPageAnnunciInVendita">
                                    <span aria-hidden="true"></span>
                                    <input type="text" class="form-control" id="jumpToPageAnnunciInVendita" maxlength="3">
                                    Vai a ...<span class="sr-only">Indica la pagina desiderata</span>
                                </label>
                            </div>
                        </nav>';*/


    $risultato["html"] .= '<nav class="pagination-wrapper pagination-box d-flex justify-content-between" aria-label="Esempio di navigazione con jump to page">
            <ul class="pagination">
            <li class="page-item">
                    <button class="page-link '. ($offset==0?'text-secondary':'') . '" onclick="popolaAnnunciInVendita(\'' . base64_encode($utente["codiceFiscale"]) . '\', 0)" ' . ($offset==0?'disabled':'') . '>
                        <i class="fas fa-angle-double-left"></i>   
                    </button>
                </li>
                <li class="page-item">
                    <button class="page-link '. ($offset==0?'text-secondary':'') . '" onclick="popolaAnnunciInVendita(\'' . base64_encode($utente["codiceFiscale"]) . '\', ' . (($offset-1)>=0?($offset-1):0) . ')" ' . ($offset==0?'disabled':'') . '>
                        <i class="fas fa-angle-left"></i>
                    </button>
                </li>
                <li class="page-item active">
                    <button class="page-link" aria-current="page">' . ($offset+1) . '</button>
                </li>
                <li class="page-item">
                    <button class="page-link '. ($offset==$maxPagina?'text-secondary':'') . '" onclick="popolaAnnunciInVendita(\'' . base64_encode($utente["codiceFiscale"]) . '\', ' . (($offset+1)<=$maxPagina?($offset+1):$maxPagina) . ')" ' . ($offset==$maxPagina?'disabled':'') . '>
                        <i class="fas fa-angle-right"></i>
                    </button>
                </li>
                <li class="page-item">
                    <button class="page-link '. ($offset==$maxPagina?'text-secondary':'') . '" onclick="popolaAnnunciInVendita(\'' . base64_encode($utente["codiceFiscale"]) . '\', ' . $maxPagina . ')" ' . ($offset==$maxPagina?'disabled':'') . '>
                        <i class="fas fa-angle-double-right"></i>   
                    </button>
                </li>
            </ul>
            <div class="form-group page-box">
                <label for="jumpToPageAnnunciInVendita">
                    <input type="text" class="form-control" id="jumpToPageAnnunciInVendita" maxlength="2" placeholder="/' . ($maxPagina + 1) . '" onchange="popolaAnnunciInVendita(\'' . base64_encode($utente["codiceFiscale"]) . '\', controllaVaia(value, ' . ($maxPagina+1) . ')-1)">
                    Vai a ...
                </label>
            </div> 
        </nav>';

}

echo json_encode($risultato);