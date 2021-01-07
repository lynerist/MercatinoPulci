<?php
function urlCriptato($cf, $dop): string{
    $cf = base64_encode($cf);
    $dop = base64_encode($dop);
    if ($dop == "") {
        return "profile.php?cf=" . $cf;
    } else {
        return "annuncio.php?dop=" . $dop . "&v=" . $cf;
    }
}

function arrotondaValutazione($valutazione): float{
    $parteDecimale = (floatval($valutazione) * 10) % 10;
    $valutazione = floatval(intval($valutazione));
    $valutazione += 0.5 * ($parteDecimale > 3);
    $valutazione += 0.5 * ($parteDecimale > 6);
    return $valutazione;
}

function calcolaScadenza($dop, $v, $tempoUsura): int{
    $etaAnnuncio = (new DateTime('now')) -> diff(new DateTime(date('Y-m-d', strtotime($dop))));
    $vitaAnnuncio = array(3, 10)[$tempoUsura == 0];
    $giorniScadenza = $vitaAnnuncio - $etaAnnuncio -> days;
    if ($giorniScadenza <= 0){
//    TODO elimina questo annuncio tramite query
    }
    return $giorniScadenza;
}