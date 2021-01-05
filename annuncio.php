<?php
require_once "common/session.php";
//url = ?dop=MjAyMS0wMS0wMSAwMDowMDowMA==&v=U0xORlBQOThTMjhGMjA1Vg==
//dop criptato -> dop=MjAyMS0wMS0wMSAwMDowMDowMA==
$annuncio["dataOraPubblicazione"] = base64_decode($_GET["dop"], true);
//v criptato -> v=U0xORlBQOThTMjhGMjA1Vg==
$annuncio["venditore"] = base64_decode($_GET["v"], true);
$annuncio["venditore"] = "asd";
if (!($annuncio["dataOraPubblicazione"] and $annuncio["venditore"])){
    header("location: 404.php");
}

$annuncio["statoAnnuncio"] = "inVendita";

?>
<!DOCTYPE html>
<html lang="it">

<head>
<!--    TODO titolo pagina parametrico-->
    <title>Titolo annuncio</title>
    <?php include_once "common/common_header.php"?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet"  type="text/css" href="css/annuncio.css">
    <link rel="stylesheet"  type="text/css" href="css/profile.css">
</head>

<body>
<?php include_once "common/navbar.php"?>

<h1 class="title-watched container">Chitarra Lidl</h1>

<div class="container dark-grey-text mt-4 drop-shadow mb-5"> <!--personalizzare il colore dell'ombra in base allo stato annuncio con php-->
    <div class="row">
        <div class="col-md-5">
            <img src="img/lidl.jpeg" class="img-fluid img-thumbnail rounded mt-3 mx-auto" alt="immagine annuncio">
        </div>
        <div class="col-md-6 mb-4 box-info">

            <?php if (isset($_SESSION['codiceFiscale']) and $_SESSION['codiceFiscale'] == $annuncio['venditore']){ ?>
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
                                                        <img src="img/image_not_found.png" alt=""/>
                                                        <div class="file btn btn-lg x btn-primary mt-0">
                                                            Cambia foto
                                                            <input type="file" name="file" class="w-100 h-100"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="p-3 py-5 no-padding-top form-width">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6"><label><input id="titolo" type="text" class="form-control form-custom modificaAnnuncio" placeholder="Titolo" value="" oninput="colora(id,controllaTesto(value))" required></label></div>
                                                            <div class="col-md-6"><label><input id="prezzo"  type="text" class="form-control form-custom testo-grande modificaAnnuncio" placeholder="Prezzo in €" value=""  oninput="colora(id,controllaPrezzo(value))" required></label></div>
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
                                                            <div class="col-md-6"><label><input id="prodotto" type="text" class="form-control form-custom modificaAnnuncio" placeholder="Prodotto" value="" oninput="colora(id,controllaTesto(value))" required></label></div>
                                                            <div class="col-md-6">
                                                                <label>
                                                                    <select name="visibilita" id="visibilita" class="form-control modificaAnnuncio" onchange="visualizzaAreaVisibilita(value, 'containerAreaVisibilita')" required>
                                                                        <option value="" disabled selected hidden>Visibilità</option>
                                                                        <option value="pubblica">Pubblica</option>
                                                                        <option value="ristretta">Ristretta</option>
                                                                        <option value="privata">Privata</option>
                                                                    </select>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label>
                                                                    <select name="statoUsura" id="statoUsura" class="form-control modificaAnnuncio" onchange="visualizza(id); colora('tempoUsura', controllaTempoUsura('tempoUsura', id))" required>
                                                                        <option value="" disabled selected hidden>Stato usura</option>
                                                                        <option value="nuovo">Nuovo</option>
                                                                        <option value="comeNuovo">Come nuovo</option>
                                                                        <option value="buono">Buono</option>
                                                                        <option value="medio">Medio</option>
                                                                        <option value="usurato">Usurato</option>
                                                                    </select>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label id="labelTempoUsura" class="display-none">
                                                                    <input id="tempoUsura" type="text" class="form-control form-custom modificaAnnuncio" placeholder="Tempo usura in mesi" value="" oninput="colora(id, controllaTempoUsura(id, 'statoUsura'))">
                                                                </label>
                                                                <label id="labelScadenzaGaranzia" class="display-none">
                                                                    <input id="scadenzaGaranzia" type="text" class="form-control form-custom modificaAnnuncio" placeholder="Scadenza garanzia" onfocus="(this.type='date')">
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
                                                                        <option value="Lombardia">Lombardia</option>
                                                                    </select>
                                                                </label>
                                                                <label>
                                                                    <select name="provincia" id="luogoVenditaProvincia" class="form-control modificaAnnuncio" required>
                                                                        <option value="" disabled selected hidden>Provincia</option>
                                                                        <option value="Milano">Milano</option>
                                                                    </select>
                                                                </label>
                                                                <label>
                                                                    <select name="comune" id="luogoVenditaComune" class="form-control modificaAnnuncio" required>
                                                                        <option value="" disabled selected hidden>Comune</option>
                                                                        <option value="Milano">Milano</option>
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
                                        <!--TODO rimandare alla pagina di "annuncio_eliminato.html" tramite funzione di backend-->
                                        <button  type="submit" class="btn btn-danger">Conferma</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <br>
            <div class="luogo">Lombardia, Brescia, Brescia</div>
            <div class="lead">$100</div>
            <div class="lead mb-3">Prodotto</div>
            <div class="font-weight-bold mb-3">Nuovo</div>
            <div class="mb-5">Ottime condizioni</div>
            <div class="font-italic mt-5">osservato da 9 persone</div>
            <div class="mt-3">Venduto da: <a class="link-profile" href="profile.html" target="_blank">Elena Crosten</a></div>

            <?php
            if (isset($_SESSION["codiceFiscale"]) and  $_SESSION["codiceFiscale"] != $annuncio["venditore"] and $_SESSION["tipoAccount"] != 'venditore'){ ?>
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
                                <a href="richiestaDiAcquisto.html" class="btn btn-success">Invia</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
            if (!isset($_SESSION["codiceFiscale"]) or $_SESSION["codiceFiscale"] != $annuncio["venditore"] and $_SESSION["tipoAccount"] != 'venditore'){
                echo '<button type="button" class="destra btn btn-secondary btn-outline-primary btn-sm mt-5" data-dismiss="modal" id="osserva" onclick="rimuovi(id, \'annulla\')">Osserva</button>';
                echo '<button type="button" class="destra btn btn-secondary btn-outline-warning btn-sm annulla mt-5" data-dismiss="modal" id="annulla" onclick="rimuovi(id, \'osserva\')">Annulla</button>';
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
            <div class="lead">Hobby</div>
            <div>altro</div>
        </div>
        <div class="col-md-4 mb-5">
            <div><i>In garanzia fino al 5/5/22</i></div>
        </div>
        <div class="col-md-4 mb-5">
            <div class="lead">Scade fra 3 giorni</div>
            <div>Pubblicato il: 10/6/2020 ore 15:28</div>
        </div>
    </div>
</div>

<?php include_once "common/footer.php"; ?>

<?php include_once "common/common_script.php"; ?>

<script src="js/bottoni.js"></script>
<script src="js/style.js"></script>
</body>

</html>
