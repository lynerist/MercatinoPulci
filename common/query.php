<?php
function controllaVisibilita($cf){
    return "SELECT dataOraPubblicazione, venditore
FROM annuncio
WHERE visibilita = 'pubblica'
   OR (dataOraPubblicazione, venditore) IN (SELECT AV.dataOraPubblicazione, AV.venditore
                                            FROM areavisibilita AS AV
                                            WHERE (AV.provincia, AV.comune) = (SELECT provincia, comune
                                                                               FROM utente
                                                                               WHERE codiceFiscale = '$cf'))
   OR venditore = '$cf'";
}

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
    $res = $cid -> query("select count(*) as nValutazioniVenditore, avg(valutazioneSuVenditore) as mediaVenditore from utente join annuncio a on utente.codiceFiscale = a.venditore where codiceFiscale = '$cf' and a.valutazioneSuVenditore is not null;");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    $valutazioni = $res -> fetch_assoc();
    $res = $cid -> query("select count(*) as nValutazioniAcquirente, avg(valutazioneSuAcquirente) as mediaAcquirente from utente join acquista a on utente.codiceFiscale = a.acquirente where codiceFiscale = '$cf' and a.valutazioneSuAcquirente is not null;");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    $valutazioni += $res -> fetch_assoc();
    return $valutazioni;
}

function trovaAnnunciAcquistati_sql($cid, $cf, $cfSessione){
    $res = $cid -> query("select annuncio.venditore, annuncio.dataOraPubblicazione, titolo, prodotto, tempoUsura, prezzo, foto as fotoAnnuncio from annuncio join acquista a on annuncio.dataOraPubblicazione = a.dataOraPubblicazione and annuncio.venditore = a.venditore where a.acquirente = '$cf' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ");");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function trovaAnnunciVenduti_sql($cid, $cf, $cfSessione){
    $res = $cid -> query("select annuncio.venditore, annuncio.dataOraPubblicazione, titolo, prodotto, tempoUsura, prezzo, foto as fotoAnnuncio from annuncio join acquista a on annuncio.dataOraPubblicazione = a.dataOraPubblicazione and annuncio.venditore = a.venditore where a.venditore = '$cf' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ");");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function trovaAnnunciInVendita_sql($cid, $cf, $cfSessione){
    $res = $cid -> query("select annuncio.venditore, annuncio.dataOraPubblicazione, titolo, prodotto, tempoUsura, prezzo, foto as fotoAnnuncio from annuncio where venditore = '$cf' and statoAnnuncio = 'inVendita' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ");");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function trovaAnnuncio_sql($cid, $dop, $v, $cfSessione){
    $res = $cid -> query("select *, foto as fotoAnnuncio, u.nome as nomeVenditore, u.cognome as cognomeVenditore, u.eliminato as venditoreEliminato from annuncio join utente u on u.codiceFiscale = annuncio.venditore join areageografica a on a.comune = annuncio.comune and a.provincia = annuncio.provincia where dataOraPubblicazione = '$dop' and venditore = '$v' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ");");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    if ($res->num_rows==0){
        header("location: 404.php");
        exit;
    }
    $annuncio = $res -> fetch_assoc();
    if ($annuncio["statoUsura"] == "comeNuovo") $annuncio["statoUsura"] = "Come nuovo";
    $annuncio["tempoUsura"] = intval($annuncio["tempoUsura"]);
    //controllo scadenza annuncio
    if ($annuncio["statoAnnuncio"] == "inVendita") {
        $annuncio["scadenza"] = calcolaScadenza($annuncio["dataOraPubblicazione"], $annuncio["venditore"], $annuncio["tempoUsura"]);
        if ($annuncio["scadenza"] < 1) $annuncio["statoAnnuncio"] = "eliminato";
    }
    return $annuncio;
}

function trovaRisultati_sql($cid, $parametri, $cfSessione){
    $filtri = "";
    foreach ($parametri as $key => $parametro){
        switch ($key){
            case "regione":
                $filtri .= ($parametro != '0')?"and a.regione='$parametro' ":"";
                break;
            case "provincia":
                $filtri .= ($parametro != '0')?"and a.provincia='$parametro' ":"";
                break;
            case "testoRicerca":
                $matchTesto = "";
                foreach (explode(" ", $parametro) as &$parola){
                    $matchTesto .= "annuncio.titolo LIKE '%$parola%' OR annuncio.prodotto LIKE '%$parola%' OR ";
                }
                $filtri .= "and (" . substr($matchTesto, 0, -3) . ") ";
        }
    }

    $res = $cid->query("select *, foto as fotoAnnuncio from annuncio join areageografica a on annuncio.comune = a.comune and annuncio.provincia = a.provincia where statoAnnuncio = 'inVendita' " . $filtri . " and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ");");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function isWatched_sql($cid, $dop, $v, $cf){
    $res = $cid->query("select * from osserva where acquirente = '$cf' and dataOraPubblicazione = '$dop' and venditore = '$v';");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return ($res -> num_rows);
}

function contaOsservatori_sql($cid, $dop, $v){
    $res = $cid->query("select * from osserva where venditore = '$v' and  dataOraPubblicazione = '$dop';");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return ($res -> num_rows);
}

function annunciTop_sql($cid){
    $res = $cid->query("select dataOraPubblicazione, venditore, titolo, prezzo, tempoUsura, foto as fotoAnnuncio, count(acquirente) as nOsservatori, statoAnnuncio
from annuncio natural left outer join osserva as o
where statoAnnuncio = 'inVendita'
group by venditore, dataOraPubblicazione
order by nOsservatori desc,(select avg(an.valutazioneSuVenditore) from annuncio as an where an.venditore = an.venditore) desc
limit 12");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function venditoriTop_sql($cid){
    $res = $cid->query("select codiceFiscale, nome, cognome, immagine as fotoProfilo, avg(valutazioneSuVenditore), count(*)
from utente join annuncio a on utente.codiceFiscale = a.venditore
where statoAnnuncio = 'venduto' and eliminato <> 0 and (dataOraPubblicazione between subdate(curdate(), interval 1 month ) and now())
group by codiceFiscale
having avg(valutazioneSuVenditore) >= 2.5
order by count(*) desc , avg(valutazioneSuVenditore) desc
limit 12");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}