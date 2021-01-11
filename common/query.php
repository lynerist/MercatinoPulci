<?php
function trovaUtente_sql($cid, $cf){
    $res = $cid -> query("SELECT *, immagine as fotoProfilo FROM utente join areageografica a on utente.comune = a.comune and utente.provincia = a.provincia WHERE codiceFiscale = '$cf';");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    $utente = $res -> fetch_assoc();
    if ($res->num_rows==0 or $utente["eliminato"]){
        header("location: 404.php");
        exit;
    }
    return $utente;
}

function valutazioni_sql($cid, $cf){
    $res = $cid -> query("select count(*) as nValutazioniVenditore, avg(valutazioneSuVenditore) as mediaVenditore from utente join annuncio a on utente.codiceFiscale = a.venditore where codiceFiscale = '$cf';");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    $valutazioni = $res -> fetch_assoc();
    $res = $cid -> query("select count(*) as nValutazioniAcquirente, avg(valutazioneSuAcquirente) as mediaAcquirente from utente join acquista a on utente.codiceFiscale = a.acquirente where codiceFiscale = '$cf';");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    $valutazioni += $res -> fetch_assoc();
    return $valutazioni;
}

function trovaAnnunciAcquistati_sql($cid, $cf){
    $res = $cid -> query("select ");
}
