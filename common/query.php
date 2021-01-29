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

function trovaAnnunciAcquistati_sql($cid, $cf, $cfSessione, $offset){
    $limit = 3;
    $offset = intval($offset)*$limit;
    $res = $cid -> query("select annuncio.venditore, annuncio.dataOraPubblicazione, titolo, prodotto, tempoUsura, prezzo, foto as fotoAnnuncio from annuncio join acquista a on annuncio.dataOraPubblicazione = a.dataOraPubblicazione and annuncio.venditore = a.venditore where a.acquirente = '$cf' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ") LIMIT " . $limit . " OFFSET " . $offset);
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function nAnnunciAcquistati_sql($cid, $cf){
    $res = $cid -> query("select count(*) from annuncio join acquista a on annuncio.dataOraPubblicazione = a.dataOraPubblicazione and annuncio.venditore = a.venditore where a.acquirente = '$cf'");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    $nAnnunci = $res -> fetch_row();
    return $nAnnunci[0];
}

function nAnnunciAcquistatiVisibili_sql($cid, $cf, $cfSessione){
    $res = $cid -> query("select count(*) from annuncio join acquista a on annuncio.dataOraPubblicazione = a.dataOraPubblicazione and annuncio.venditore = a.venditore where a.acquirente = '$cf' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ")");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    $nAnnunci = $res -> fetch_row();
    return $nAnnunci[0];
}

function trovaAnnunciVenduti_sql($cid, $cf, $cfSessione, $offset){
    $limit = 3;
    $offset = intval($offset)*$limit;
    $res = $cid -> query("select annuncio.venditore, annuncio.dataOraPubblicazione, titolo, prodotto, tempoUsura, prezzo, foto as fotoAnnuncio from annuncio join acquista a on annuncio.dataOraPubblicazione = a.dataOraPubblicazione and annuncio.venditore = a.venditore where a.venditore = '$cf' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ") LIMIT " . $limit . " OFFSET " . $offset);
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function nAnnunciVenduti_sql($cid, $cf){
    $res = $cid -> query("select count(*) from annuncio join acquista a on annuncio.dataOraPubblicazione = a.dataOraPubblicazione and annuncio.venditore = a.venditore where a.venditore = '$cf'");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    $nAnnunci = $res -> fetch_row();
    return $nAnnunci[0];
}

function nAnnunciVendutiVisibili_sql($cid, $cf, $cfSessione){
    $res = $cid -> query("select count(*) from annuncio join acquista a on annuncio.dataOraPubblicazione = a.dataOraPubblicazione and annuncio.venditore = a.venditore where a.venditore = '$cf' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ")");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    $nAnnunci = $res -> fetch_row();
    return $nAnnunci[0];
}

function trovaAnnunciInVendita_sql($cid, $cf, $cfSessione, $offset){
    $limit = 3;
    $offset = intval($offset)*$limit;
    $res = $cid -> query("select annuncio.venditore, annuncio.dataOraPubblicazione, titolo, prodotto, tempoUsura, prezzo, foto as fotoAnnuncio from annuncio where venditore = '$cf' and statoAnnuncio = 'inVendita' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ") LIMIT " . $limit . " OFFSET " . $offset);
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function nAnnunciInVenditaVisibili_sql($cid, $cf, $cfSessione){
    $res = $cid -> query("select count(*) from annuncio where venditore = '$cf' and statoAnnuncio = 'inVendita' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ")");
    if ($res==null){
        header("location: erroreConnessione.php");
        exit;
    }
    $nAnnunci = $res -> fetch_row();
    return $nAnnunci[0];
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
    if ($annuncio["categoria"] == "fotoEVideo") $annuncio["categoria"] = "Foto e video";
    if ($annuncio["sottoCategoria"] == "macchineFotografiche") $annuncio["sottoCategoria"] = "Macchine fotografiche";
    if ($annuncio["sottoCategoria"] == "filmEDVD") $annuncio["sottoCategoria"] = "Film e DVD";
    if ($annuncio["sottoCategoria"] == "libriERiviste") $annuncio["sottoCategoria"] = "Libri e riviste";
    $annuncio["tempoUsura"] = intval($annuncio["tempoUsura"]);
    //controllo scadenza annuncio
    if ($annuncio["statoAnnuncio"] == "inVendita") {
        $annuncio["scadenza"] = calcolaScadenza($annuncio["dataOraPubblicazione"], $annuncio["venditore"], $annuncio["tempoUsura"]);
        if ($annuncio["scadenza"] < 1) $annuncio["statoAnnuncio"] = "eliminato";
    }
    return $annuncio;
}

function trovaRisultati_sql($cid, $parametri, $cfSessione, $offset){
    $filtri = "";
    foreach ($parametri as $key => $parametro){
        $parametro = mysqli_real_escape_string($cid, $parametro);
        switch ($key){
            case "regione":
                $filtri .= ($parametro != 'Tutta Italia')?"and a.regione='$parametro' ":"";
                break;
            case "provincia":
                $filtri .= ($parametro != "Ogni provincia")?"and a.provincia='$parametro' ":"";
                break;
            case "testoRicerca":
                $matchTesto = "";
                foreach (explode(" ", $parametro) as &$parola){
                    $matchTesto .= "annuncio.titolo LIKE '%$parola%' OR annuncio.prodotto LIKE '%$parola%' OR ";
                }
                $filtri .= "and (" . substr($matchTesto, 0, -3) . ") ";
                break;
            case "sc":
                $categorie = indiciCategorie();
                $filtri .= ($parametro % 6 == 0)?"and annuncio.categoria='$categorie[$parametro]' ":"and annuncio.categoria='" . $categorie[floor($parametro/6)*6] . "' and annuncio.sottocategoria='$categorie[$parametro]' ";
                break;
            case "p":
                $scale = (log(3000)-log(1)) / (1000);
                $prezzo = ceil(exp(log(1) + $scale*(intval($parametro))));
                $filtri .= "and annuncio.prezzo<='$prezzo' ";
                break;
            case "c":
                if ($parametro == '1'){
                    $filtri .= "and annuncio.tempoUsura=0 ";
                }elseif (intval($parametro) > 1){
                    $filtri .= "and annuncio.statoUsura='" . array("comeNuovo", "buono", "medio", "usurato")[$parametro-2] . "' ";
                }
                break;
        }
    }

    $limit = 9;
    $offset = ($offset-1)*$limit;
    $res = $cid->query("select *, foto as fotoAnnuncio from annuncio join areageografica a on annuncio.comune = a.comune and annuncio.provincia = a.provincia where statoAnnuncio = 'inVendita' " . $filtri . " and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ") LIMIT " . $limit . " OFFSET " . $offset);
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function nRisultati_sql($cid, $parametri, $cfSessione){
    $filtri = "";
    foreach ($parametri as $key => $parametro){
        $parametro = mysqli_real_escape_string($cid, $parametro);
        switch ($key){
            case "regione":
                $filtri .= ($parametro != 'Tutta Italia')?"and a.regione='$parametro' ":"";
                break;
            case "provincia":
                $filtri .= ($parametro != "Ogni provincia")?"and a.provincia='$parametro' ":"";
                break;
            case "testoRicerca":
                $matchTesto = "";
                foreach (explode(" ", $parametro) as &$parola){
                    $matchTesto .= "annuncio.titolo LIKE '%$parola%' OR annuncio.prodotto LIKE '%$parola%' OR ";
                }
                $filtri .= "and (" . substr($matchTesto, 0, -3) . ") ";
                break;
            case "sc":
                $categorie = indiciCategorie();
                $filtri .= ($parametro % 6 == 0)?"and annuncio.categoria='$categorie[$parametro]' ":"and annuncio.categoria='" . $categorie[floor($parametro/6)*6] . "' and annuncio.sottocategoria='$categorie[$parametro]' ";
                break;
            case "p":
                $scale = (log(3000)-log(1)) / (1000);
                $prezzo = ceil(exp(log(1) + $scale*(intval($parametro))));
                $filtri .= "and annuncio.prezzo<='$prezzo' ";
                break;
            case "c":
                if ($parametro == '1'){
                    $filtri .= "and annuncio.tempoUsura=0 ";
                }elseif (intval($parametro) > 1){
                    $filtri .= "and annuncio.statoUsura='" . array("comeNuovo", "buono", "medio", "usurato")[$parametro-2] . "' ";
                }
                break;
        }
    }

    $res = $cid->query("select count(*) from annuncio join areageografica a on annuncio.comune = a.comune and annuncio.provincia = a.provincia where statoAnnuncio = 'inVendita' " . $filtri . " and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ")");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    $numero=$res->fetch_row();
    return $numero[0];
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

function annunciTop_sql($cid, $cfSessione){
    $res = $cid->query("select dataOraPubblicazione, venditore, titolo, prezzo, tempoUsura, foto as fotoAnnuncio, count(acquirente) as nOsservatori, statoAnnuncio
from annuncio natural left outer join osserva as o
where statoAnnuncio = 'inVendita' and (annuncio.dataOraPubblicazione, annuncio.venditore) in (" . controllaVisibilita($cfSessione) . ")
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

function trovaDaApprovare_sql($cid, $sessioneCf){
    $res = $cid->query("select a.dataOraPubblicazione,
       a.venditore,
       a.foto              as fotoAnnuncio,
       titolo,
       prodotto,
       tempoUsura,
       prezzo,
       immagine            as fotoProfilo,
       codiceFiscale       as acquirente,
       nome,
       cognome,
       richiestaDiAcquisto as pagamento
from osserva
         join annuncio a on a.dataOraPubblicazione = osserva.dataOraPubblicazione and a.venditore = osserva.venditore
         join utente u on u.codiceFiscale = osserva.acquirente
where richiestaDiAcquisto is not null
  and a.venditore = '$sessioneCf'
order by a.dataOraPubblicazione");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function trovaEffettuate_sql($cid, $sessioneCf){
    $res = $cid->query("select a.dataOraPubblicazione,
       a.venditore,
       a.foto              as fotoAnnuncio,
       titolo,
       prodotto,
       tempoUsura,
       prezzo,
       immagine            as fotoProfilo,
       codiceFiscale       as venditore,
       nome,
       cognome,
       richiestaDiAcquisto as pagamento
from osserva
         join annuncio a on a.dataOraPubblicazione = osserva.dataOraPubblicazione and a.venditore = osserva.venditore
         join utente u on u.codiceFiscale = osserva.venditore
where richiestaDiAcquisto is not null
  and osserva.acquirente = '$sessioneCf'
order by a.dataOraPubblicazione");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function trovaVersoAcquirente_sql($cid, $sessioneCf){
    $res = $cid->query("select a.dataOraPubblicazione,
       a.venditore,
       a.foto        as fotoAnnuncio,
       titolo,
       prodotto,
       tempoUsura,
       prezzo,
       immagine      as fotoProfilo,
       codiceFiscale as acquirente,
       nome,
       cognome
from acquista
         join annuncio a on a.dataOraPubblicazione = acquista.dataOraPubblicazione and a.venditore = acquista.venditore
         join utente u on u.codiceFiscale = acquista.acquirente
where acquista.valutazioneSuAcquirente is null
  and a.venditore = '$sessioneCf'
order by a.dataOraPubblicazione");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function trovaVersoVenditore_sql($cid, $sessioneCf){
    $res = $cid->query("select a.dataOraPubblicazione,
       a.venditore,
       a.foto        as fotoAnnuncio,
       titolo,
       prodotto,
       tempoUsura,
       prezzo,
       immagine      as fotoProfilo,
       codiceFiscale as acquirente,
       nome,
       cognome
from acquista
         join annuncio a on a.dataOraPubblicazione = acquista.dataOraPubblicazione and a.venditore = acquista.venditore
         join utente u on u.codiceFiscale = acquista.venditore
where a.valutazioneSuVenditore is null
  and acquista.acquirente = '$sessioneCf'
order by a.dataOraPubblicazione");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}