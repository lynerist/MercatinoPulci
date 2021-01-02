<?php
    session_start()
?>





<!DOCTYPE html>
<html lang="it">

<head>
    <title>bee-market</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.html"><img src="img/bee.svg" class="icon-bee" alt="bee"><span>Be</span><span>e-Market</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <form class="form-inline my-2 my-lg-0 nav-form">
            <label>
                <select class="form-control form-custom white-inputs" name="regione" id="regione">
                    <option value="0">Tutta Italia</option>
                    <option value="1">Lombardia</option>
                    <option value="2">Sardegna</option>
                </select>
            </label>
            <label>
                <select class="form-control form-custom white-inputs" name="provincia" id="provincia">
                    <option value="0">Ogni provincia</option>
                    <option value="1">Ogni provincia</option>
                    <option value="1">Lecco</option>
                    <option value="2">Ogni provincia</option>
                    <option value="2">Olbia</option>
                </select>
            </label>
            <div class="nav-newline"></div>
            <input class="form-control form-custom mr-sm-2 white-inputs nav-search" type="search" placeholder="Cerca" aria-label="Search" required>
            <!--            TODO rimandare alla pagina "risultati.html" da funzione di backend-->
            <button class="btn btn-outline-success btn-custom my-2 my-sm-0" type="submit">Cerca</button>
        </form>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="watched.html">
                    <img src="img/binocolo.svg" class="nav-icon" alt="Annunci osservati">
                    <p class="nav-icon-text nav-link">Annunci osservati</p>
                </a>
            </li>
            <li class="nav-item pt-3px">
                <a class="nav-link pt" href="#0" onclick="accediRegistrati('tabAccedi')">Accedi</a>
                <!-- Modal -->
                <div class="modal fade show" id="modalLoginRegister" tabindex="-1" role="dialog" aria-modal="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">

                                <!-- Pills -->
                                <ul class="nav nav-justified container">
                                    <li class="nav-item mr-1">
                                        <a id="tabAccedi" class="nav-link border border-warning border-rounded bg-warning" data-toggle="tab"
                                           href="#modalLoginRegister-login" role="tab" aria-selected="true">Accedi</a>
                                    </li>
                                    <li class="nav-item pt-0">
                                        <a id="tabRegistrati" class="nav-link border border-warning border-rounded bg-warning" data-toggle="tab"
                                           href="#modalLoginRegister-register" role="tab" aria-selected="false">Registrati</a>
                                    </li>
                                </ul>
                                <!-- Pills -->

                                <!-- Content -->
                                <div class="tab-content">

                                    <!-- First panel -->
                                    <div class="tab-pane fade in show active" id="modalLoginRegister-login" role="tabpanel">

                                        <!-- Login form -->
                                        <form id="formLoginRegister-login" class="container pt-2 needs-validation" method="post" onsubmit="return controllaForm(id)">

                                            <div class="md-form md-outline">
                                                <i class="fas fa-envelope prefix"></i>
                                                <input type="email" id="formLoginRegister-email" class="form-control formLoginRegister-login" placeholder="E-mail" oninput="colora(id,controllaEmail(value))" required>
                                                <label data-error="wrong" data-success="right" for="formLoginRegister-email"></label>
                                            </div>
                                            <div class="md-form md-outline">
                                                <i class="fas fa-lock prefix"></i>
                                                <input type="password" id="formLoginRegister-password" class="form-control formLoginRegister-login" placeholder="Password" required>
                                                <label data-error="wrong" data-success="right" for="formLoginRegister-password"></label>
                                            </div>

                                            <div class="text-center mt-4 pt-3">
                                                <button type="submit" class="btn btn-warning mb-2" >Accedi</button>
                                            </div>

                                        </form>
                                        <!-- Login form -->

                                    </div>
                                    <!-- First panel -->

                                    <!-- Second panel -->
                                    <div class="tab-pane fade" id="modalLoginRegister-register" role="tabpanel">

                                        <!-- Register form -->
                                        <form id="formLoginRegister-register" class="container pt-2 needs-validation" action="" method="post" onsubmit="return controllaForm(id)">

                                            <div class="md-form md-outline">
                                                <i class="fas fa-user prefix"></i>
                                                <input type="text" id="formLoginRegister-name" class="form-control formLoginRegister-register" placeholder="Nome" oninput="colora(id,controllaTesto(value))" required>
                                                <label data-error="wrong" data-success="right" for="formLoginRegister-name"></label>
                                            </div>
                                            <div class="md-form md-outline">
                                                <i class="fas fa-user-tie    prefix"></i>
                                                <input type="text" id="formLoginRegister-surname" class="form-control formLoginRegister-register" placeholder="Cognome" oninput="colora(id,controllaTesto(value))" required>
                                                <label data-error="wrong" data-success="right" for="formLoginRegister-surname"></label>
                                            </div>
                                            <div class="md-form md-outline">
                                                <i class="fas fa-id-card prefix"></i>
                                                <input type="text" id="formLoginRegister-codiceFiscale" class="form-control formLoginRegister-register" placeholder="Codice Fiscale" required oninput="colora(id,controllaCodiceFiscale(value))">
                                                <label data-error="wrong" data-success="right" for="formLoginRegister-codiceFiscale"></label>
                                            </div>
                                            <div class="md-form md-outline">
                                                <i class="fas fa-map-marked-alt prefix"></i>
                                                <label>
                                                    <select name="regione" id="register-regione" class="form-control formLoginRegister-register" required>
                                                        <option value="" disabled selected hidden>Regione</option>
                                                        <option value="Lombardia">Lombardia</option>
                                                    </select>
                                                </label>
                                                <label>
                                                    <select name="provincia" id="register-provincia" class="form-control formLoginRegister-register" required>
                                                        <option value="" disabled selected hidden>Provincia</option>
                                                        <option value="Milano">Milano</option>
                                                    </select>
                                                </label>
                                                <label>
                                                    <select name="comune" id="register-comune" class="form-control formLoginRegister-register" required>
                                                        <option value="" disabled selected hidden>Comune</option>
                                                        <option value="Milano">Milano</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="md-form md-outline">
                                                <i class="fas fa-envelope prefix"></i>
                                                <input type="email" id="emailRegistrazione" name="emailRegistrazione" class="form-control formLoginRegister-register" placeholder="E-mail" oninput="colora(id,controllaEmail(value))" required>
                                                <label data-error="wrong" data-success="right" for="emailRegistrazione"></label>
                                            </div>
                                            <div class="md-form md-outline">
                                                <i class="fas fa-lock prefix"></i>
                                                <input type="password" id="passwordRegistrazione" name="passwordRegistrazione" class="form-control formLoginRegister-register" placeholder="Password" oninput="colora(id,controllaPassword(value)); colora('passwordRipetizioneRegistrazione',controllaRipetizionePassword('passwordRipetizioneRegistrazione',value))" required>
                                                <label data-error="wrong" data-success="right" for="passwordRegistrazione"></label>
                                                <div class="invalid-feedback ml-1">Minimo 8 caratteri, almeno un numero ed una maiuscola.</div>
                                            </div>
                                            <div class="md-form md-outline">
                                                <i class="fas fa-key prefix"></i>
                                                <input type="password" id="passwordRipetizioneRegistrazione" name="passwordRipetizioneRegistrazione" class="form-control formLoginRegister-register" placeholder="Ripeti Password" oninput="colora(id,controllaRipetizionePassword('passwordRegistrazione',value))" required>
                                                <label data-error="wrong" data-success="right" for="passwordRipetizioneRegistrazione"></label>
                                                <div class="invalid-feedback ml-1">Le due password non corrispondono.</div>
                                            </div>
                                            <div class="md-form md-outline">
                                                <i class="fas fa-user-tag prefix"></i>
                                                <label>
                                                    <select name="tipoAccount" id="tipoAccount" class="form-control formLoginRegister-register" required>
                                                        <option value="" disabled selected hidden>Tipologia</option>
                                                        <option value="acquirente">Acquirente</option>
                                                        <option value="venditore">Venditore</option>
                                                        <option value="venditoreAcquirente">Acquirente e venditore</option>
                                                    </select>
                                                </label>
                                            </div>

                                            <div class="form-check mt-4 mb-3 pl-0 text-left d-inline">
                                                <input type="checkbox" class="form-check-input filled-in" id="formLoginRegister-newsletter"
                                                       name="newsletter">
                                                <label class="form-check-label small grey-text" for="formLoginRegister-newsletter">
                                                    Confermo la mia iscrizione alla newsletter
                                                </label>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-warning my-2">Registrati</button>
                                            </div>

                                        </form>
                                        <!-- Register form -->
                                    </div>
                                    <!-- Second panel -->
                                </div>
                                <!-- Content -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-warning waves-effect waves-light"
                                        data-dismiss="modal">Chiudi</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
            </li>
            <li class="nav-item pt-3px">
                <a class="nav-link pt" href="#0" onclick="accediRegistrati('tabRegistrati')">Registrati</a>
            </li>
        </ul>
    </div>
</nav>


<div class="banner jumbotron jumbotron-fluid">
    <h1 class="display-4">Benvenuto!</h1>
    <h1 class="lead">Vuoi vendere qualcosa? Posta un nuovo annuncio e scopri chi vorrebbe comprare!</h1>


    <a class="banner-button" href="#modalNuovoAnnuncio" data-toggle="modal">Nuovo Annuncio</a>
    <div class="modal fade modal-only" id="modalNuovoAnnuncio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog edit-profile" role="document">
            <div class="modal-content">
                <form id="nuovoAnnuncio" onsubmit="return controllaForm(id)">
                    <div class="modal-header arancio">
                        <h5 class="modal-title" id="exampleModalLabel">Nuovo annuncio</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container rounded bg-white mt-5">
                            <div class="row">
                                <div class="col-md-4 border-right">
                                    <div class="profile-img">
                                        <img src="img/image_not_found.png" alt=""/>
                                        <div class="file btn btn-lg x btn-primary mt-0">
                                            Inserisci foto
                                            <input type="file" name="file" class="w-100 h-100"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="p-3 py-5 no-padding-top form-width">
                                        <div class="row mt-2">
                                            <div class="col-md-6"><label><input id="titolo" type="text" class="form-control form-custom nuovoAnnuncio" placeholder="Titolo" value="" oninput="colora(id,controllaTesto(value))" required></label></div>
                                            <div class="col-md-6"><label><input id="prezzo"  type="text" class="form-control form-custom testo-grande nuovoAnnuncio" placeholder="Prezzo in €" value=""  oninput="colora(id,controllaPrezzo(value))" required></label></div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label>
                                                    <select name="categoria" id="categoria" class="form-control nuovoAnnuncio" required>
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
                                                    <select name="sottcategoria" id="sottocategoria" class="form-control nuovoAnnuncio" required>
                                                        <option value="" disabled selected hidden>Sottocategoria</option>
                                                        <option value="altro">Altro</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6"><label><input id="prodotto" type="text" class="form-control form-custom nuovoAnnuncio" placeholder="Prodotto" value="" oninput="colora(id,controllaTesto(value))" required></label></div>
                                            <div class="col-md-6">
                                                <label>
                                                    <select name="visibilita" id="visibilita" class="form-control nuovoAnnuncio" onchange="visualizzaAreaVisibilita(value, 'containerAreaVisibilita')" required>
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
                                                    <select name="statoUsura" id="statoUsura" class="form-control nuovoAnnuncio" onchange="visualizza(id); colora('tempoUsura', controllaTempoUsura('tempoUsura', id))" required>
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
                                                    <input id="tempoUsura" type="text" class="form-control form-custom nuovoAnnuncio" placeholder="Tempo usura in mesi" value="" oninput="colora(id, controllaTempoUsura(id, 'statoUsura'))">
                                                </label>
                                                <label id="labelScadenzaGaranzia" class="display-none">
                                                    <input id="scadenzaGaranzia" type="text" class="form-control form-custom nuovoAnnuncio" placeholder="Scadenza garanzia" onfocus="(this.type='date')">
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
                                                    <select name="luogoVenditaRegione" id="luogoVenditaRegione" class="form-control nuovoAnnuncio" required>
                                                        <option value="" disabled selected hidden>Regione</option>
                                                        <option value="Lombardia">Lombardia</option>
                                                    </select>
                                                </label>
                                                <label>
                                                    <select name="luogoVenditaProvincia" id="luogoVenditaProvincia" class="form-control nuovoAnnuncio" required>
                                                        <option value="" disabled selected hidden>Provincia</option>
                                                        <option value="Milano">Milano</option>
                                                    </select>
                                                </label>
                                                <label>
                                                    <select name="luogoVenditaComune" id="luogoVenditaComune" class="form-control nuovoAnnuncio" required>
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
                                                        <select name="visibilita-regione_0" id="visibilita-regione_0" class="form-control">
                                                            <option value="" disabled selected hidden>Regione</option>
                                                            <option value="Lombardia">Lombardia</option>
                                                        </select>
                                                    </label>
                                                    <label>
                                                        <select name="visibilita-provincia_0" id="visibilita-provincia_0" class="form-control">
                                                            <option value="" disabled selected hidden>Provincia</option>
                                                            <option value="Milano">Milano</option>
                                                        </select>
                                                    </label>
                                                    <label>
                                                        <select name="visibilita-comune_0" id="visibilita-comune_0" class="form-control">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-outline-danger" data-dismiss="modal">Annulla</button>
                        <button class="btn btn-primary btn-outline-success" type="submit">Pubblica</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="row modal-container col-md-12">

    <!-- Button trigger modal -->
    <div class="modal-menu col-md-2 giallo">
        <p>ELETTRODOMESTICI</p>
        <img src="img/elettrodomestici.svg" alt="Elettrodomestici">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#elettrodomestici">
            Cerca
            <span>in elettrodomestici</span>
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="elettrodomestici" tabindex="-1" role="dialog" aria-labelledby="elettrodomesticiLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header giallo">
                    <h5 class="modal-title" id="elettrodomesticiLabel">Elettrodomestici</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form my-2 my-lg-0 nav-form">
                        <p>Cosa cerchi?</p>
                        <input class="form-control form-custom mr-sm-2 popup" type="search"
                               placeholder="Frullatore, Smart Tv, Aspirapolvere" aria-label="Search">
                        <p>Dove lo cerchi?</p>
                        <label class="popup">
                            <select class="form-control form-custom" name="regione1" id="regione1">
                                <option value="0">Tutta Italia</option>
                                <option value="1">Lombardia</option>
                                <option value="2">Sardegna</option>
                            </select>
                        </label>
                        <label class="popup">
                            <select class="form-control form-custom" name="provincia1" id="provincia1">
                                <option value="0">Ogni provincia</option>
                                <option value="1">Ogni provincia</option>
                                <option value="1">Lecco</option>
                                <option value="2">Ogni provincia</option>
                                <option value="2">Olbia</option>
                            </select>
                        </label>
                        <button class="btn btn-outline-success btn-custom my-2 my-sm-0 popup giallo" type="submit">Cerca</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-newLine"></div>

    <!-- Button trigger modal -->
    <div class="modal-menu col-md-2 verde">
        <p><span>&nbsp; &nbsp;&nbsp; &nbsp;</span> FOTO E VIDEO <span>&nbsp; &nbsp;&nbsp; &nbsp;</span></p>
        <img src="img/camera.svg" alt="Foto e video">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#foto_e_video">
            Cerca
            <span>in foto e video</span>
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="foto_e_video" tabindex="-1" role="dialog" aria-labelledby="foto_e_videoLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header verde">
                    <h5 class="modal-title" id="foto_e_videoLabel">Foto e video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form my-2 my-lg-0 nav-form">
                        <p>Cosa cerchi?</p>
                        <input class="form-control form-custom mr-sm-2 popup" type="search"
                               placeholder="Reflex, Treppiede, Registratore" aria-label="Search">
                        <p>Dove lo cerchi?</p>
                        <label class="popup">
                            <select class="form-control form-custom" name="regione2" id="regione2">
                                <option value="0">Tutta Italia</option>
                                <option value="1">Lombardia</option>
                                <option value="2">Sardegna</option>
                            </select>
                        </label>
                        <label class="popup">
                            <select class="form-control form-custom" name="provincia2" id="provincia2">
                                <option value="0">Ogni provincia</option>
                                <option value="1">Ogni provincia</option>
                                <option value="1">Lecco</option>
                                <option value="2">Ogni provincia</option>
                                <option value="2">Olbia</option>
                            </select>
                        </label>
                        <button class="btn btn-outline-success btn-custom my-2 my-sm-0 popup verde" type="submit">Cerca</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-newLineMiddle"></div>

    <!-- Button trigger modal -->
    <div class="modal-menu col-md-2 rosso">
        <p><span>&nbsp; &nbsp;</span> ABBIGLIAMENTO <span>&nbsp; &nbsp;</span></p>
        <img src="img/clothes.svg" alt="Abbigliamento">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#abbigliamento">
            Cerca
            <span>in abbigliamento</span>
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="abbigliamento" tabindex="-1" role="dialog" aria-labelledby="abbigliamentoLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header rosso">
                    <h5 class="modal-title" id="abbigliamentoLabel">Abbigliamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form my-2 my-lg-0 nav-form">
                        <p>Cosa cerchi?</p>
                        <input class="form-control form-custom mr-sm-2 popup" type="search"
                               placeholder="Sciarpa, Scarpe, Borsa" aria-label="Search">
                        <p>Dove lo cerchi?</p>
                        <label class="popup">
                            <select class="form-control form-custom" name="regione3" id="regione3">
                                <option value="0">Tutta Italia</option>
                                <option value="1">Lombardia</option>
                                <option value="2">Sardegna</option>
                            </select>
                        </label>
                        <label class="popup">
                            <select class="form-control form-custom" name="provincia3" id="provincia3">
                                <option value="0">Ogni provincia</option>
                                <option value="1">Ogni provincia</option>
                                <option value="1">Lecco</option>
                                <option value="2">Ogni provincia</option>
                                <option value="2">Olbia</option>
                            </select>
                        </label>
                        <button class="btn btn-outline-success btn-custom my-2 my-sm-0 popup rosso" type="submit">Cerca</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-newLine"></div>

    <!-- Button trigger modal -->
    <div class="modal-menu col-md-2 blu">
        <p><span>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</span> HOBBY <span>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</span>
        </p>
        <img src="img/hobby.svg" alt="Hobby">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#hobby">
            Cerca
            <span>in hobby</span>
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="hobby" tabindex="-1" role="dialog" aria-labelledby="hobbyLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header blu">
                    <h5 class="modal-title" id="hobbyLabel">Hobby</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form my-2 my-lg-0 nav-form">
                        <p>Cosa cerchi?</p>
                        <input class="form-control form-custom mr-sm-2 popup" type="search"
                               placeholder="Cuffie, Chitarra, Racchettoni" aria-label="Search">
                        <p>Dove lo cerchi?</p>
                        <label class="popup">
                            <select class="form-control form-custom" name="regione4" id="regione4">
                                <option value="0">Tutta Italia</option>
                                <option value="1">Lombardia</option>
                                <option value="2">Sardegna</option>
                            </select>
                        </label>
                        <label class="popup">
                            <select class="form-control form-custom" name="provincia4" id="provincia4">
                                <option value="0">Ogni provincia</option>
                                <option value="1">Ogni provincia</option>
                                <option value="1">Lecco</option>
                                <option value="2">Ogni provincia</option>
                                <option value="2">Olbia</option>
                            </select>
                        </label>
                        <button class="btn btn-outline-success btn-custom my-2 my-sm-0 popup blu" type="submit">Cerca</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>



<div class="bbb_viewed pb-0">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="bbb_main_container drop-shadow">
                    <div class="bbb_viewed_title_container">
                        <h3 class="bbb_viewed_title">Annunci più <span>osservati</span></h3>
                        <div class="bbb_viewed_nav_container">
                            <div class="bbb_viewed_nav bbb_viewed_prev"><img src="img/chevron-left-solid.svg"
                                                                             alt="sinistra"></div>
                            <div class="bbb_viewed_nav bbb_viewed_next"><img src="img/chevron-right-solid.svg"
                                                                             alt="destra"></div>
                        </div>
                    </div>
                    <div class="bbb_viewed_slider_container">
                        <div class="owl-carousel owl-theme bbb_viewed_slider">
                            <div class="owl-item">
                                <div class="bbb_viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="annuncio.html" class="bbb_viewed_image"><img
                                            src="img/annuncio4.jpg"
                                            alt=""></a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_price">€80</div>
                                        <div class="bbb_viewed_name"><a href="annuncio.html">Ramponi da ghiaccio</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div class="bbb_viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="annuncio.html" class="bbb_viewed_image"><img
                                            src="img/annuncio3.jpg"
                                            alt=""></a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_price">€40</div>
                                        <div class="bbb_viewed_name"><a href="annuncio.html">Manuele di PHP e mysql</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div class="bbb_viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="annuncio.html" class="bbb_viewed_image"><img
                                            src="img/annuncio5.jpg"
                                            alt=""></a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_price">€50</div>
                                        <div class="bbb_viewed_name"><a href="annuncio.html">Marranzano antico</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div class="bbb_viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="annuncio.html" class="bbb_viewed_image"><img
                                            src="img/annuncio2.jpg"
                                            alt=""></a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_price">€1379</div>
                                        <div class="bbb_viewed_name"><a href="annuncio.html">Bottiglia rara di Champagne</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div class="bbb_viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="annuncio.html" class="bbb_viewed_image"><img
                                            src="img/annuncio1.jpg"
                                            alt=""></a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_price">€225</div>
                                        <div class="bbb_viewed_name"><a href="annuncio.html">Cuffie da gaming</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div class="bbb_viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="annuncio.html" class="bbb_viewed_image"><img
                                            src="img/lidl.jpeg"
                                            alt="">
                                    </a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_price">€100</div>
                                        <div class="bbb_viewed_name"><a href="annuncio.html">Chitarra Lidl</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="bbb_viewed">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="bbb_main_container drop-shadow">
                    <div class="bbb_viewed_title_container">
                        <h3 class="bbb_viewed_title">Venditori <span>TOP</span></h3>
                        <div class="bbb_viewed_nav_container">
                            <div class="bbb_viewed_nav bbb_viewed_prev_v"><img src="img/chevron-left-solid.svg"
                                                                               alt="sinistra"></div>
                            <div class="bbb_viewed_nav bbb_viewed_next_v"><img src="img/chevron-right-solid.svg"
                                                                               alt="destra"></div>
                        </div>
                    </div>
                    <div class="bbb_viewed_slider_container">
                        <div class="owl-carousel owl-theme bbb_viewed_slider_v">
                            <div class="owl-item">
                                <div class="bbb_viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="profile.html" class="bbb_viewed_image"><img
                                            src="img/venditore5.png"
                                            alt=""></a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_name"><a href="profile.html">Davide Ziaki</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div class="bbb_viewed_item d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="profile.html" class="bbb_viewed_image"><img
                                            src="img/venditore4.png"
                                            alt=""></a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_name"><a href="profile.html">Giulia Vincenti</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div class="bbb_viewed_item d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="profile.html" class="bbb_viewed_image"><img
                                            src="img/venditore6.jpg"
                                            alt=""></a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_name"><a href="profile.html">Cecilia Fusorari</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div class="bbb_viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="profile.html" class="bbb_viewed_image"><img
                                            src="img/venditore2.jpg"
                                            alt=""></a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_name"><a href="profile.html">Elena Crosten</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div href="annuncio.html" class="bbb_viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="profile.html" class="bbb_viewed_image"><img
                                            src="img/venditore1.jpg"
                                            alt=""></a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_name"><a href="profile.html">Edoardo Perego</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item">
                                <div class="bbb_viewed_item d-flex flex-column align-items-center justify-content-center text-center">
                                    <a href="profile.html" class="bbb_viewed_image"><img
                                            src="img/venditore3.jpg"
                                            alt="">
                                    </a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_name"><a href="profile.html">Vincenzo Rossi</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<footer class="page-footer font-small blue pt-4">
    <!-- Footer Links -->
    <div class="container-fluid text-center text-md-left">
        <!-- Grid row -->
        <div class="row">
            <!-- Grid column -->
            <div class="col-md-5 mt-md-0 mt-3 footer-content">
                <!-- Content -->
                <h5 class="text-uppercase">Come vendere</h5>
                <p>Per vendere un prodotto è necessario essere iscritti alla piattaforma.
                    <br>Dopo aver effettuato il login, tramite il bottone posizionato nella <a class="link-footer" href="index.html">home</a>.
                    <br>Lì verranno chiesti i dati e fornite le spiegazioni necessarie.</p>

            </div>
            <!-- Grid column -->
            <hr class="clearfix w-100 d-md-none pb-3">
            <!-- Grid column -->
            <div class="col-md-3 mb-md-0 mb-3 footer-left">
                <!-- Links -->
                <h5 class="text-uppercase">Chi siamo | Contattaci</h5>

                <ul class="list-unstyled">
                    <li>
                        <a class="link-footer" href="https://github.com/lynerist" target="_blank">Leonardo Albani</a> | <a class="link-footer" href="mailto:leonardo.albani@studenti.unimi.it">leonardo.albani@studenti.unimi.it</a>
                    </li>
                    <li>
                        <a class="link-footer" href="https://github.com/FilippoUslenghi" target="_blank">Filippo Uslenghi</a> | <a class="link-footer" href="mailto:filippo.uslenghi@studenti.unimi.it">filippo.uslenghi@studenti.unimi.it</a>
                    </li>
                </ul>
            </div>
            <!-- Grid column -->
            <!-- Grid column -->
            <div class="col-md-4 mb-md-0 mb-3">
                <!-- Links -->
                <h5 class="text-uppercase">Cookies</h5>

                <p>Questo sito fa uso di cookie per migliorare l’esperienza di navigazione degli utenti. Utilizziamo solo cookie tecnici. Proseguendo nella navigazione si accetta l’uso dei cookie.</p>
            </div>
            <!-- Grid column -->
        </div>
        <!-- Grid row -->
    </div>
    <!-- Footer Links -->
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2020 Copyright | Designed by: Leonardo Albani e Filippo Uslenghi |
        <a class="link-footer"> All rights reserved</a>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->

<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<script src="js/carosello.js"></script>
<script src="js/navbar.js"></script>
<script src="js/owl.carousel.js"></script>
<script src="js/controlloInput.js"></script>

</body>
</html>