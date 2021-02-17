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

function calcolaScadenza($cid, $dop, $v, $tempoUsura): int{
    $etaAnnuncio = (new DateTime('now')) -> diff(new DateTime(date('Y-m-d', strtotime($dop))));
    $vitaAnnuncio = array(3, 10)[$tempoUsura == 0];
    $giorniScadenza = $vitaAnnuncio - $etaAnnuncio -> days;
    if ($giorniScadenza <= 0){
        eliminaAnnuncio_sql($cid, $dop, $v);
    }
    return $giorniScadenza;
}

function inserisciFoto($foto){
    echo is_null($foto)?"image_not_found.png":$foto;
}

function inserisciFotoAjax($foto){
    return is_null($foto)?"image_not_found.png":$foto;
}

function indiciCategorie(){
    return array('elettrodomestici', 'aspirapolveri', 'caffettiere', 'tostapane', 'frullatori', 'altro', 'fotoEVideo', 'macchineFotografiche', 'accessori', 'telecamere', 'microfoni', 'altro', 'abbigliamento', 'vestiti', 'borse', 'scarpe', 'accessori', 'altro', 'hobby', 'giocattoli', 'filmEDVD', 'musica', 'libriERiviste', 'altro');
}

function isWatched($cid, $dop, $v, $cfSessione, $cookie){
    if ($cfSessione != ""){
        return isWatched_sql($cid, $dop, $v, $cfSessione);
    }
    if ($cookie != ""){
        return array_key_exists(serialize(array($dop, $v)), unserialize($cookie));
    }
    return false;
}

function gestisciValoreOgniProvincia($regione, $provincia){
    if ($provincia == "Ogni provincia"){
        return $provincia . ":::::" . $regione;
    }
    return $provincia;
}

function console($arg){
    echo " <script>console.log('$arg')</script> ";
    exit;
}