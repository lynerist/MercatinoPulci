<?php
session_start();
include_once "../common/funzioni.php";
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'mercatinopulci';
$cid = new mysqli($hostname,$username,$password,$db);

if($cid->connect_errno){
    $risultato["errore"] = true;
    echo json_encode($risultato);
    exit;
}

if (isset($_SESSION["codiceFiscale"])){
    $sql = "SELECT a.dataOraPubblicazione, a.venditore, a.titolo, a.prodotto, a.tempoUsura, a.prezzo, a.foto as fotoAnnuncio
from osserva
         join annuncio a on a.dataOraPubblicazione = osserva.dataOraPubblicazione and a.venditore = osserva.venditore
where osserva.acquirente = '" . $_SESSION['codiceFiscale'] . "' and richiestaDiAcquisto is null";
}else{

}

$res = $cid->query($sql);
if ($res == null) {
    $risultato["errore"] = true;
}

$risultato["html"] = "";
$item1 = "";
$item2 = "";
$i = 0;
while ($annuncio = $res->fetch_assoc()) {
    $token = '<div class="justify-content-between my-4 pb-4 border-bottom col-md-6" id="' . $i . '">
            <div class="media d-block d-sm-flex text-center text-sm-left">
                <a class="cart-item-thumb mx-auto mr-sm-4" href="' . urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']) . '" target="_blank">
                    <img src="fotoAnnuncio/' . (is_null($annuncio['fotoAnnuncio'])?'image_not_found.png':$annuncio['fotoAnnuncio']) . '" alt="Product" id="foto' . $i . '">
                </a>
                <div class="media-body pt-3">
                    <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo' . $i . '">
                        <a href="' . urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']) . '" target="_blank">' . $annuncio['titolo'] .'</a>
                    </h3>
                    <div class="font-size-sm" id="prodotto' . $i . '"><span class="text-muted mr-2">Prodotto:</span>' . $annuncio['prodotto'] . '</div>
                    <div class="font-size-sm" id="tempoUsura' . $i . '"><span class="text-muted mr-2"><b>' . array("Usato", "Nuovo")[$annuncio["tempoUsura"] == 0] . '</b></span></div>
                    <div class="font-size-lg text-primary pt-2" id="prezzo1">€' . $annuncio['prezzo'] . '</div>
                    <div class="non-osservare">
                        <button type="button" class="btn btn-secondary btn-outline-danger btn-sm" data-dismiss="modal" id="rimuovi' . $i . '" onclick="rimuovi(id, \'annulla' . $i . '\')">Rimuovi</button>
                    </div>
                </div>
            </div>
        </div>';
    if ($item1 == "") $item1 = $token;
    elseif ($item2 == "") $item2 = $token;
    else {
        $risultato["html"] .= '<div class="col-md-12 d-flex flex-row row">' . $item1 . $item2 . '</div>';
        $item1 = $token;
        $item2 = "";
    }
    $i++;
}

$risultato["html"] .= '<div class="col-md-12 d-flex flex-row row">' . $item1 . $item2 . '</div>';


echo json_encode($risultato);
