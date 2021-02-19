<?php
function controllaVisibilita($cf){
    return "SELECT dataOraPubblicazione, venditore
FROM annuncio
WHERE visibilita = 'pubblica'
   OR (dataOraPubblicazione, venditore) IN (SELECT AV.dataOraPubblicazione, AV.venditore
                                            FROM areavisibilita AS AV
                                            WHERE (AV.provincia, AV.comune) = (SELECT provincia, comune
                                                                               FROM utente
                                                                               WHERE codiceFiscale = '$cf')
                                            OR AV.comune LIKE 'Ogni comune' AND AV.provincia LIKE (SELECT CONCAT('%', (SELECT regione
                                                                                                                       FROM utente JOIN areageografica a ON utente.comune = a.comune
                                                                                                                       WHERE codiceFiscale = '$cf')))
                                            OR AV.comune LIKE 'Ogni comune' AND AV.provincia LIKE (SELECT provincia
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
        $annuncio["scadenza"] = calcolaScadenza($cid, $annuncio["dataOraPubblicazione"], $annuncio["venditore"], $annuncio["tempoUsura"]);
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
    $res = $cid->query("select codiceFiscale, nome, cognome, immagine as fotoProfilo
                        from utente join annuncio a on utente.codiceFiscale = a.venditore
                        where statoAnnuncio = 'venduto'
                          and eliminato != '1'
                          and (dataOraPubblicazione between subdate(curdate(), interval 1 month) and now())
                        group by codiceFiscale
                        having avg(valutazioneSuVenditore) >= 2.5
                        order by count(*) desc, avg(valutazioneSuVenditore) desc
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
       richiestaDiAcquisto as pagamento,
       daNotificare
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
  and u.eliminato = '0'
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
       cognome,
       daNotificare
from acquista
         join annuncio a on a.dataOraPubblicazione = acquista.dataOraPubblicazione and a.venditore = acquista.venditore
         join utente u on u.codiceFiscale = acquista.venditore
where a.valutazioneSuVenditore is null
  and acquista.acquirente = '$sessioneCf'
  and u.eliminato = '0'
order by a.dataOraPubblicazione");
    if ($res == null) {
        header("location: erroreConnessione.php");
        exit;
    }
    return $res;
}

function verifyPassword_sql($cid, $cfSessione, $password){
    $res = $cid -> query("SELECT password FROM utente WHERE codiceFiscale = '$cfSessione'");
    $row = $res -> fetch_row();
    return (md5($password) == $row[0]);
}

function modificaFotoProfilo_sql($cid, $cfSessione, $estensione){
    $foto = md5($cfSessione) . "." . $estensione;
    $cid -> query("UPDATE utente SET immagine = '$foto' WHERE codiceFiscale = '$cfSessione'");
    return $foto;
}

function modificaFotoAnnuncio_sql($cid, $dop, $v, $estensione){
    $res = $cid -> query("SELECT COUNT(*) FROM annuncio WHERE venditore = '$v' and dataOraPubblicazione < '$dop'");
    $nAnnunciPrecedenti = ($res -> fetch_row())[0];
    $foto = md5($v . $nAnnunciPrecedenti) . "." . $estensione;
    $cid -> query("UPDATE annuncio SET foto = '$foto' WHERE venditore = '$v' and dataOraPubblicazione = '$dop'");
    return $foto;
}

function richiestaDiAcquistoEffettuata_sql($cid, $cfSessione, $dop, $v){
    $res = $cid -> query("SELECT richiestaDiAcquisto FROM osserva WHERE acquirente = '$cfSessione' and venditore = '$v' and dataOraPubblicazione = '$dop' and richiestaDiAcquisto is not null");
    return ($res -> num_rows);
}

function smettiDiOsservare_sql($cid, $dop, $venditore, $acquirente){
    //tutti gli annunci di una persona da venditore
    if ($dop == "" and $acquirente == "") return $cid -> query("DELETE FROM osserva WHERE venditore = '$venditore'");
    //tutti gli annunci di una persona da acquirente
    if ($dop == "" and $venditore == "") return $cid -> query("DELETE FROM osserva WHERE acquirente = '$acquirente'");
    //tutti gli annunci di una persona da acquirente e da venditore
    if ($dop == "") return $cid -> query("DELETE FROM osserva WHERE acquirente = '$acquirente' or venditore = '$venditore'");
    //tutte le persone di un annuncio
    if ($acquirente == "") return $cid -> query("DELETE FROM osserva WHERE dataOraPubblicazione = '$dop' and venditore = '$venditore'"); 
    //un annuncio di una persona
    return $cid -> query("DELETE FROM osserva WHERE acquirente = '$acquirente' and dataOraPubblicazione = '$dop' and venditore = '$venditore'");
}

function confermaVendita_sql($cid, $dop, $venditore, $acquirente){
    $cid->query("INSERT INTO acquista (dataOraPubblicazione, venditore, acquirente, valutazioneSuAcquirente) VALUES ('$dop', '$venditore', '$acquirente', null)");
}

function acquista_sql($cid, $dop, $venditore, $acquirente, $richiestaDiAcquisto){
    $cid->query("INSERT INTO osserva (acquirente, dataOraPubblicazione, venditore, richiestaDiAcquisto, daNotificare) VALUES ('$acquirente', '$dop', '$venditore', '$richiestaDiAcquisto', '1')");
}

function inserisciValutazione_sql($cid, $dop, $venditore, $acquirente, $valutazione, $verso){
    if ($verso == "acquirente") $cid->query("UPDATE acquista SET valutazioneSuAcquirente = '$valutazione' WHERE dataOraPubblicazione = '$dop' and venditore = '$venditore' and acquirente = '$acquirente'");
    else $cid->query("UPDATE annuncio SET valutazioneSuVenditore = '$valutazione' WHERE dataOraPubblicazione = '$dop' and venditore = '$venditore'");
}

function rimuoviVisibilitaAnnuncio_sql($cid, $dop, $v){
    if ($dop == "") $cid->query("DELETE FROM areavisibilita WHERE venditore = '$v'");
    else $cid->query("DELETE FROM areavisibilita WHERE venditore = '$v' and dataOraPubblicazione = '$dop'");
}

function trovaAreeVisibilita_sql($cid, $dop, $v){
    return $cid->query("SELECT regione, a.provincia, a.comune FROM areavisibilita join areageografica a on a.comune = areavisibilita.comune and a.provincia = areavisibilita.provincia WHERE dataOraPubblicazione = '$dop' and venditore='$v' ORDER BY regione, provincia, comune");
}

function eliminaAnnuncio_sql($cid, $dop, $v){
    $cid -> query("UPDATE annuncio SET statoAnnuncio = 'eliminato' WHERE venditore = '$v' and dataOraPubblicazione = '$dop'");
    smettiDiOsservare_sql($cid, $dop, $v, "");
    rimuoviVisibilitaAnnuncio_sql($cid, $dop, $v);
}

function nNotificheRichiesteRicevute_sql($cid, $cfSessione){
    $res = $cid -> query("SELECT count(*) from osserva where venditore = '$cfSessione' and daNotificare = '1'");
    return $res -> fetch_row()[0];
}

function nNotificheValutazioniSuVenditore_sql($cid, $cfSessione){
    $res = $cid -> query("SELECT count(*) from acquista where acquirente = '$cfSessione' and daNotificare = '1'");
    return $res -> fetch_row()[0];
}

function svuotaNotifiche_sql($cid, $cfSessione){
    $cid -> query("UPDATE osserva SET daNotificare = '0' where venditore = '$cfSessione'");
    $cid -> query("UPDATE acquista SET daNotificare = '0' where acquirente = '$cfSessione'");
}

function existsEmail_sql($cid, $email, $daIgnorare){
    $res = $cid -> query("SELECT count(*) FROM utente WHERE email = '$email' and codiceFiscale != '$daIgnorare'");
    return ($res -> fetch_row()[0]) > 0;
}

function existsCodiceFiscale_sql($cid, $cf){
    $res = $cid -> query("SELECT count(*) FROM utente WHERE codiceFiscale = '$cf';");
    return ($res -> fetch_row()[0]) > 0;
}

function registraUtente_sql($cid, $codiceFiscale, $tipoAccount, $nome, $cognome, $email, $password, $comune, $provincia){
    $cid->query("INSERT INTO utente (codiceFiscale, tipoAccount, nome, cognome, email, password, immagine, comune, provincia, eliminato) VALUES ('" . $codiceFiscale . "', '" . $tipoAccount . "', '" . $nome . "', '" . $cognome . "', '" . $email . "', '" . $password . "', null, '" . $comune . "', '" . $provincia . "', '0')");
}

function osservaAnnuncio_sql($cid, $cfSessione, $dop, $v){
    return $cid -> query("INSERT INTO osserva (acquirente, dataOraPubblicazione, venditore, richiestaDiAcquisto) VALUES ('$cfSessione', '$dop', '$v', null)");
}

function attendeRispostaARichiestaDiAcquisto_sql($cid, $cfSessione){
    $res = $cid -> query("SELECT count(*) FROM osserva WHERE acquirente = '$cfSessione' and richiestaDiAcquisto IS NOT NULL");
    return ($res -> fetch_row()[0]) > 0;
}

function modificaProfilo_sql($cid, $nome, $cognome, $email, $provincia, $comune, $tipoAccount, $nuovaPassword, $cfSessione){
    $modificaProfilo = "UPDATE utente SET nome = '$nome', cognome = '$cognome', email = '$email', provincia = '$provincia', comune = '$comune', tipoAccount = '$tipoAccount', password = '$nuovaPassword' WHERE codiceFiscale = '$cfSessione'";
    if ($nuovaPassword == "d41d8cd98f00b204e9800998ecf8427e"){
        $modificaProfilo = "UPDATE utente SET nome = '$nome', cognome = '$cognome', email = '$email', provincia = '$provincia', comune = '$comune', tipoAccount = '$tipoAccount' WHERE codiceFiscale = '$cfSessione'";
    }
    $cid->query($modificaProfilo);
}

function eliminaTuttiGliAnnunciDiUnVenditore_sql($cid, $cfSessione){
    $cid -> query("UPDATE annuncio SET statoAnnuncio = 'eliminato' WHERE statoAnnuncio = 'inVendita' and venditore = '$cfSessione'");
    smettiDiOsservare_sql($cid, "", $cfSessione, "");
}

function modificaAnnuncio_Sql($cid, $titolo, $prodotto, $categoria, $sottocategoria, $prezzo, $statoUsura, $tempoUsura, $scadenzaGaranzia, $visibilita, $luogoVenditaProvincia, $luogoVenditaComune, $dataOraPubblicazione, $venditore){
    $cid -> query("UPDATE annuncio SET titolo = '$titolo', prodotto = '$prodotto', categoria = '$categoria',
                    sottoCategoria = '$sottocategoria', prezzo = '$prezzo', statoUsura = " . $statoUsura . ", 
                    tempoUsura = '$tempoUsura', scadenzaGaranzia = " . $scadenzaGaranzia . ", visibilita = '$visibilita',
                    provincia = '$luogoVenditaProvincia', comune = '$luogoVenditaComune'
                    WHERE dataOraPubblicazione = '$dataOraPubblicazione' and venditore = '$venditore'");
}

function svuotaAreaVisibilita_sql($cid, $venditore, $dataOraPubblicazione){
    $cid->query("DELETE FROM areavisibilita WHERE venditore = '$venditore' and dataOraPubblicazione = '$dataOraPubblicazione'");
}

function inserisciAreaVisibilita($cid, $dataOraPubblicazione, $venditore, $regioneVisibilita, $provinciaVisibilita, $comuneVisibilita){
    if ($regioneVisibilita == "Tutta Italia") return;
    $provincia = gestisciValoreOgniProvincia($regioneVisibilita, $provinciaVisibilita);
    $cid->query("INSERT INTO areavisibilita (dataOraPubblicazione, venditore, comune, provincia) VALUES ('$dataOraPubblicazione', '$venditore', '$comuneVisibilita', '$provincia')");
}

function login_sql($cid, $email){
    return $cid -> query("SELECT codiceFiscale, nome, tipoAccount, password FROM utente WHERE email = '$email' and eliminato = '0'");
}

function inserisciAnnuncio_sql($cid, $venditore, $titolo, $prodotto, $categoria, $sottocategoria, $prezzo, $statoUsura, $tempoUsura, $scadenzaGaranzia, $visibilita, $luogoVenditaComune, $luogoVenditaProvincia){
    $cid -> query("insert into annuncio (venditore, titolo, prodotto, categoria, sottoCategoria, prezzo, statoUsura, tempoUsura,
                      scadenzaGaranzia, foto, valutazioneSuVenditore, visibilita, comune, provincia) 
                      values ('$venditore', '$titolo', '$prodotto', '$categoria', '$sottocategoria', '$prezzo', " . $statoUsura . ", 
                      '$tempoUsura', " . $scadenzaGaranzia . ", NULL, NULL, '$visibilita', '$luogoVenditaComune', '$luogoVenditaProvincia')");
}

function ricavaDataOraPubblicazione($cid, $venditore){
    $res = $cid -> query("SELECT dataOraPubblicazione FROM annuncio WHERE venditore = '$venditore' ORDER BY dataOraPubblicazione DESC LIMIT 1");
    return $res -> fetch_row()[0];
}