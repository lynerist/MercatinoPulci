<?php
require_once "common/session.php";
include_once "common/connessioneDB.php";
include_once "common/query.php";

$annuncio["dataOraPubblicazione"] = base64_decode($_GET["dop"], true);
$annuncio["venditore"] = base64_decode($_GET["v"], true);
if (!($annuncio["dataOraPubblicazione"] and $annuncio["venditore"])) {
    header("location: 404.php");
}

$annuncio = trovaAnnuncio_sql($cid, $annuncio["dataOraPubblicazione"], $annuncio["venditore"], isset($_SESSION["isLogged"])?$_SESSION["codiceFiscale"]:'');
$annuncio["nOsservatori"] = contaOsservatori_sql($cid, $annuncio["dataOraPubblicazione"], $annuncio["venditore"]);
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title><?php echo utf8_encode($annuncio["titolo"]) ?></title>
    <?php include_once "common/common_header.php"?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet"  type="text/css" href="css/annuncio.css">
    <link rel="stylesheet"  type="text/css" href="css/profile.css">
</head>

<body>
<?php include_once "common/navbar.php"?>

<h1 class="title-watched container"><?php echo utf8_encode($annuncio["titolo"]) ?></h1>

<div class="container dark-grey-text mt-4 drop-shadow <?php if ($annuncio["statoAnnuncio"] == "eliminato") echo "ombra-eliminato"; elseif ($annuncio["statoAnnuncio"] == "venduto") echo "ombra-venduto"; ?> mb-5">
    <div class="row">
        <div class="col-md-5">
            <img src="fotoAnnuncio/<?php inserisciFoto($annuncio['fotoAnnuncio']);?>" class="img-fluid img-thumbnail rounded mt-3 mx-auto" alt="immagine annuncio">
        </div>
        <div class="col-md-6 mb-4 box-info">

            <?php if (isset($_SESSION['codiceFiscale']) and $_SESSION['codiceFiscale'] == $annuncio['venditore'] and ($annuncio["statoAnnuncio"] == "inVendita")){ ?>
                <div id="myAnnuncio" class="mb-5 container-fluid">
                    <!-- Button trigger modal -->
                    <button type="button" class="annuncio-edit-btn w-100" data-toggle="modal" data-target="#modalModificaAnnuncio">
                        Modifica
                    </button>
                    <!-- Modal -->
                    <div class="modal fade modal-only" id="modalModificaAnnuncio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog edit-annuncio" role="document">
                            <div class="modal-content">
                                <form id="modificaAnnuncio" onsubmit="return controllaForm(id)">
                                    <div class="modal-header arancio">
                                        <h5 class="modal-title" id="exampleModalLabel">Modifica annuncio</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container rounded bg-white mt-5">
                                            <div class="row">
                                                <div class="col-md-4 border-right">
                                                    <div class="annuncio-img">
<!--                                                        TODO gestire valore null fotoAnnuncio-->
                                                        <img id="fotoInput" src="fotoAnnuncio/<?php inserisciFoto($annuncio['fotoAnnuncio']);?>" alt="""/>
                                                        <div class="file btn btn-lg x btn-primary mt-0">
                                                            Cambia foto
                                                            <input type="file" name="file" class="w-100 h-100" onchange="loadFile(event)" accept="image/png, image/jpeg, image/jpg"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="p-3 py-5 no-padding-top form-width">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6"><label><input id="titolo" type="text" class="form-control form-custom modificaAnnuncio" placeholder="Titolo" value="<?php echo utf8_encode($annuncio['titolo']) ?>" oninput="colora(id,controllaTesto(value))" required></label></div>
                                                            <div class="col-md-6"><label><input id="prezzo" type="text" class="form-control form-custom testo-grande modificaAnnuncio" placeholder="Prezzo in €" value="<?php echo $annuncio['prezzo'] ?>"  oninput="colora(id,controllaPrezzo(value))" required></label></div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label>
                                                                    <select name="categoria" id="categoria" class="form-control modificaAnnuncio" required>
                                                                        <option value="" disabled selected hidden>Categoria</option>
                                                                        <option value="elettrodomestici">Elettrodomestici</option>
                                                                        <option value="abbigliamento">Abbigliamento</option>
                                                                        <option value="fotoEVideo">Foto e video</option>
                                                                        <option value="hobby">Hobby</option>
                                                                    </select>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>
                                                                    <select name="sottcategoria" id="sottocategoria" class="form-control modificaAnnuncio" required>
                                                                        <option value="" disabled selected hidden>Sottocategoria</option>
                                                                        <option value="altro">Altro</option>
                                                                    </select>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6"><label><input id="prodotto" type="text" class="form-control form-custom modificaAnnuncio" placeholder="Prodotto" value="<?php echo utf8_encode($annuncio['prodotto']) ?>" oninput="colora(id,controllaTesto(value))" required></label></div>
                                                            <div class="col-md-6">
                                                                <label>
                                                                    <select name="visibilita" id="visibilita" class="form-control modificaAnnuncio" onchange="visualizzaAreaVisibilita(value, 'containerAreaVisibilita')" required>
                                                                        <option value="" disabled selected hidden>Visibilità</option>
                                                                        <option value="pubblica" <?php if ($annuncio["visibilita"] == "pubblica") echo "selected"; ?>>Pubblica</option>
                                                                        <option value="ristretta" <?php if ($annuncio["visibilita"] == "ristretta") echo "selected"; ?>>Ristretta</option>
                                                                        <option value="privata" <?php if ($annuncio["visibilita"] == "privata") echo "selected"; ?>>Privata</option>
                                                                    </select>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label>
                                                                    <select name="statoUsura" id="statoUsura" class="form-control modificaAnnuncio" onchange="visualizza(id); colora('tempoUsura', controllaTempoUsura('tempoUsura', id))" required>
                                                                        <option value="" disabled selected hidden>Stato usura</option>
                                                                        <option value="nuovo" <?php if ($annuncio["tempoUsura"] == 0) echo "selected"; ?>>Nuovo</option>
                                                                        <option value="comeNuovo" <?php if ($annuncio["statoUsura"] == "comeNuovo") echo "selected"; ?>>Come nuovo</option>
                                                                        <option value="buono" <?php if ($annuncio["statoUsura"] == "buono") echo "selected"; ?>>Buono</option>
                                                                        <option value="medio" <?php if ($annuncio["statoUsura"] == "medio") echo "selected"; ?>>Medio</option>
                                                                        <option value="usurato" <?php if ($annuncio["statoUsura"] == "usurato") echo "selected"; ?>>Usurato</option>
                                                                    </select>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label id="labelTempoUsura" class="display-none">
                                                                    <input id="tempoUsura" type="text" class="form-control form-custom modificaAnnuncio" placeholder="Tempo usura in mesi" value="<?php echo $annuncio['tempoUsura'] ?>" oninput="colora(id, controllaTempoUsura(id, 'statoUsura'))">
                                                                </label>
                                                                <label id="labelScadenzaGaranzia" class="display-none">
                                                                    <!-- TODO gestire valore null di scadenza garanzia -->
                                                                    <input id="scadenzaGaranzia" type="text" class="form-control form-custom modificaAnnuncio" placeholder="Scadenza garanzia" value="<?php echo date('d/m/Y', strtotime($annuncio["scadenzaGaranzia"])); ?>" onfocus="(this.type='date')">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="mb-2">
                                                            <b>Luogo di vendita</b>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="md-form md-outline container-fluid">
                                                                <label>
                                                                    <select name="regione" id="luogoVenditaRegione" class="form-control modificaAnnuncio" required>
                                                                        <option value="" disabled selected hidden>Regione</option>
                                                                    </select>
                                                                </label>
                                                                <label>
                                                                    <select name="provincia" id="luogoVenditaProvincia" class="form-control modificaAnnuncio" required>
                                                                        <option value="" disabled selected hidden>Provincia</option>
                                                                    </select>
                                                                </label>
                                                                <label>
                                                                    <select name="comune" id="luogoVenditaComune" class="form-control modificaAnnuncio" required>
                                                                        <option value="" disabled selected hidden>Comune</option>
                                                                    </select>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div id="containerAreaVisibilita">
                                                            <div class="mb-2">
                                                                <b>Area di visibilità</b>
                                                            </div>
                                                            <div class="row">
                                                                <div class="md-form md-outline container-fluid">
                                                                    <label>
                                                                        <select name="regione" id="visibilita-regione_0" class="form-control">
                                                                            <option value="" disabled selected hidden>Regione</option>
                                                                            <option value="Lombardia">Lombardia</option>
                                                                        </select>
                                                                    </label>
                                                                    <label>
                                                                        <select name="provincia" id="visibilita-provincia_0" class="form-control">
                                                                            <option value="" disabled selected hidden>Provincia</option>
                                                                            <option value="Milano">Milano</option>
                                                                        </select>
                                                                    </label>
                                                                    <label>
                                                                        <select name="comune" id="visibilita-comune_0" class="form-control">
                                                                            <option value="" disabled selected hidden>Comune</option>
                                                                            <option value="Milano">Milano</option>
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div id="piu" class="piu" onclick="aggiungiAreaVisibilita(id)">
                                                                <i class="fas fa-plus btn btn-outline-warning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer flex-row d-flex">
                                        <a class="btn btn-secondary btn-danger" data-toggle="modal" href="#modalEliminaAnnuncio">Elimina annuncio</a>
                                        <button type="button" class="btn btn-secondary btn-outline-danger ml-auto" data-dismiss="modal">Annulla</button>
                                        <button type="submit" class="btn btn-primary btn-outline-success">Salva</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEliminaAnnuncio">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3>Sei sicuro?</h3>
                                </div>
                                <div class="modal-footer">
                                    <form>
                                        <a href="#" data-dismiss="modal" class="btn btn-outline-warning">Annulla</a>
                                        <!--TODO rimandare alla pagina di "annuncio_eliminato.php" tramite funzione di backend-->
                                        <button  type="submit" class="btn btn-danger">Conferma</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <br>
            <div class="luogo"><?php echo $annuncio["regione"] . ", " . $annuncio["provincia"] . ", " . $annuncio["comune"] ?></div>
            <div class="lead">€ <?php echo $annuncio["prezzo"] ?></div>
            <div class="lead mb-3"><?php echo utf8_encode($annuncio["prodotto"]) ?></div>
            <div class="font-weight-bold mb-3"><?php if ($annuncio["tempoUsura"] == 0) echo "Nuovo"; else echo "Usato" ?></div>
            <div class="mb-5"><?php echo $annuncio["statoUsura"] ?></div>
            <?php if ($annuncio["statoAnnuncio"] == "inVendita"){ ?>
                <div class="font-italic mt-5">Osservato da <?php if ($annuncio["nOsservatori"] == "1") echo "una persona"; else echo $annuncio["nOsservatori"] . " persone" ?></div>
            <?php } ?>

            <?php
            if (!$annuncio["venditoreEliminato"]) echo '<div class="mt-3">Venduto da: <a class="link-profile" href="' . urlCriptato($annuncio['venditore'], '') . '" target="_blank">' . $annuncio["nomeVenditore"] . " " . $annuncio["cognomeVenditore"] . '</a></div>';
            else echo '<div class="mt-3">Venduto da: <b>Utente eliminato</b></div>';
            ?>

            <?php
            if (isset($_SESSION["codiceFiscale"]) and  $_SESSION["codiceFiscale"] != $annuncio["venditore"] and $_SESSION["tipoAccount"] != 'venditore' and $annuncio["statoAnnuncio"]== "inVendita"){ ?>
                <button type="button" class="destra btn btn-secondary btn-outline-success btn-sm mt-5" data-toggle="modal" data-target="#modalconfermaAcquisto">Compra</button>
                <div class="modal fade" id="modalconfermaAcquisto">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3>Richiesta di acquisto</h3>
                            </div>
                            <div class="modal-body text-left">
                                <h5>Come vuoi effettuare il pagamento?</h5>
                                <form action="" class="myform">
                                    <div class="radiobtn">
                                        <input type="radio" class="" id="diPersona" name="metodoPagamento" value="0">
                                        <label for="diPersona" class="form-check-label"><i class="fas fa-coins"></i> Di persona</label>
                                    </div>
                                    <div class="radiobtn">
                                        <input type="radio" class="" id="cartaDiCredito" name="metodoPagamento" value="1">
                                        <label for="cartaDiCredito" class="form-check-label"><i class="fas fa-credit-card"></i> Carta di credito</label>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <a href="#" data-dismiss="modal" class="btn btn-outline-warning">Annulla</a>
                                <a href="richiestaDiAcquisto.php" class="btn btn-success">Invia</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
            if ((!isset($_SESSION["codiceFiscale"]) or $_SESSION["codiceFiscale"] != $annuncio["venditore"] and $_SESSION["tipoAccount"] != 'venditore') and $annuncio["statoAnnuncio"] == "inVendita" and !isWatched($cid, $annuncio["dataOraPubblicazione"], $annuncio["venditore"], isset($_SESSION["isLogged"])?$_SESSION["codiceFiscale"]:"", isset($_COOKIE["annunciOsservati"])?$_COOKIE["annunciOsservati"]:"")) {
                echo '<button type="button" class="destra btn btn-secondary btn-outline-primary btn-sm mt-5" data-dismiss="modal" id="osserva" onclick="rimuovi(id, \'annulla\'); osservaAnnuncioAjax(\'' . base64_encode($annuncio["dataOraPubblicazione"]) . '\', \'' . base64_encode($annuncio["venditore"]) . '\')">Osserva</button>';
                echo '<div class="destra text-primary pt-1 annulla mt-5" data-dismiss="modal" id="annulla">Osservato</div>';
            }
            ?>

        </div>
    </div>
    <hr>
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 text-center"><h4 class="my-4 h4">DETTAGLI</h4></div>
    </div>
    <div class="row info-post">
        <div class="col-md-4 mb-5">
            <div class="lead"><?php echo $annuncio["categoria"]; ?></div>
            <div><?php echo $annuncio["sottoCategoria"]; ?></div>
        </div>
        <div class="col-md-4 mb-5">
            <div>
                <i>
                    <?php
                    if ($annuncio["statoAnnuncio"] == "inVendita" and $annuncio["tempoUsura"] == 0){
                        if ($annuncio["scadenzaGaranzia"]){
                            echo 'In garanzia fino al ' . date('d/m/Y', strtotime($annuncio["scadenzaGaranzia"]));
                        }else{
                            echo "Nessuna garanzia";
                        }
                    }elseif ($annuncio["tempoUsura"] > 0){
                        echo "Usato per: " . $annuncio["tempoUsura"]; echo array(" mese", " mesi")[$annuncio["tempoUsura"] > 1];
                    }
                    ?>
                </i>
            </div>
        </div>
        <div class="col-md-4 mb-5">
            <div class="lead">
                <?php
                if ($annuncio["statoAnnuncio"] == "inVendita") echo "Scade fra " . $annuncio["scadenza"] . " giorni";
                else echo ucfirst($annuncio["statoAnnuncio"]);
                ?>
            </div>
            <div>Pubblicato il: <?php echo date('d/m/Y', strtotime($annuncio["dataOraPubblicazione"])); ?></div>
        </div>
    </div>
</div>

<?php include_once "common/footer.php"; ?>

<?php include_once "common/common_script.php"; ?>

<script src="js/bottoni.js"></script>
<script src="js/modal.js"></script>
<script>visualizza('statoUsura')</script>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        popolaRegioni('luogoVenditaRegione')
    });
    document.getElementById('luogoVenditaRegione').addEventListener('change', function () {
        popolaProvince('luogoVenditaRegione', 'luogoVenditaProvincia', 'luogoVenditaComune')
    });
    document.getElementById('luogoVenditaProvincia').addEventListener('change', function () {
        popolaComuni('luogoVenditaProvincia', 'luogoVenditaComune')
    });
</script>
</body>

</html>
