<?php
require_once "common/session.php";

//url = ?cf=U0xORlBQOThTMjhGMjA1Vg==
//codiceFiscale criptato -> U0xORlBQOThTMjhGMjA1Vg==
$utente["codiceFiscale"] = base64_decode($_GET["cf"], true);
if (!$utente['codiceFiscale']){
    header("location: 404.php");
}

$utente["tipoAccount"] = "venditoreAcquirente";

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <?php include_once "common/common_header.php" ?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" type="text/css" href="css/watched.css">
</head>

<body>
<?php include_once "common/navbar.php" ?>


<h1 class="title-watched container">Profilo</h1>

<div class="container emp-profile drop-shadow">
    <div class="row">
        <div class="col-md-4">
            <div class="profile-img">
                <img src="img/venditore1.jpg" alt=""/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="profile-head mt-2">
                <h5>
                    Edoardo Perego
                </h5>

                <?php if (isset($_SESSION["codiceFiscale"]) and $_SESSION["codiceFiscale"] == $utente["codiceFiscale"]){ ?>
                    <div id="myProfile">
                        <!-- Button trigger modal -->
                        <button type="button" class="profile-edit-btn w-25" data-toggle="modal" data-target="#basicExampleModal">
                            Modifica
                        </button>
                        <!-- Modal -->
                        <div class="modal fade modal-only" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog edit-profile" role="document">
                                <div class="modal-content">
                                    <form id="modificaProfilo" action="" onsubmit="return controllaForm(id)">
                                        <div class="modal-header arancio">
                                            <h5 class="modal-title" id="exampleModalLabel">Modifica profilo</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container rounded bg-white mt-5">
                                                <div class="row">
                                                    <div class="col-md-4 border-right">
                                                        <div class="profile-img">
                                                            <img src="img/venditore1.jpg" alt=""/>
                                                            <div class="file btn btn-lg x btn-primary mt-0">
                                                                Cambia foto
                                                                <input type="file" name="file" class="w-100 h-100"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="p-3 py-5 no-padding-top form-width">
                                                            <div class="row mt-2">
                                                                <div class="col-md-6"><label><input id="modificaCodiceFiscale" name="modificaCodiceFiscale" type="text" class="form-control form-custom" placeholder="Codice fiscale" value="" readonly></label></div>
                                                                <div class="col-md-6"><label><input id="modificaEmail" name="modificaEmail" type="email" class="form-control form-custom modificaProfilo" placeholder="E-mail" value="" oninput="colora(id, controllaEmail(value))" required></label></div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6"><label><input id="modificaNome" name="modificaNome" type="text" class="form-control form-custom modificaProfilo" placeholder="Nome" value="" oninput="colora(id, controllaTesto(value))" required></label></div>
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <select name="modificaRegione" id="modificaRegione" class="form-control modificaProfilo" required>
                                                                            <option value="" disabled selected hidden>Regione</option>
                                                                            <option value="lombardia">Lombardia</option>
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6"><label><input id="modificaCognome" name="modificaCognome" type="text" class="form-control form-custom modificaProfilo" placeholder="Cognome" value="" oninput="colora(id, controllaTesto(value))" required></label></div>
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <select name="modificaProvincia" id="modificaProvincia" class="form-control modificaProfilo" required>
                                                                            <option value="" disabled selected hidden>Provincia</option>
                                                                            <option value="milano">Milano</option>
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <select name="modificaTipoAccount" id="modificaTipoAccount" class="form-control modificaProfilo" required>
                                                                            <option value="" disabled selected hidden>Tipo account</option>
                                                                            <option value="pubblica">Acquirente</option>
                                                                            <option value="ristretta">Venditore</option>
                                                                            <option value="privata">Acquirente e venditore</option>
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <select name="modificaComune" id="modificaComune" class="form-control modificaProfilo" required>
                                                                            <option value="" disabled selected hidden>Comune</option>
                                                                            <option value="milano">Milano</option>
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="mb-2">
                                                                <b>Cambia Password</b>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <label>Nuova Password
                                                                        <input id="nuovaPassword" name="nuovaPassword" class="form-control form-custom modificaProfilo" type="password" placeholder="••••••" oninput="colora(id, controllaPassword(value) || value === ''); colora('ripetiNuovaPassword',controllaRipetizionePassword('ripetiNuovaPassword',value))">
                                                                    </label>
                                                                    <div class="invalid-feedback ml-1">Minimo 8 caratteri, almeno un numero ed una maiuscola.</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Ripeti <span class="d-none d-xl-inline">Password</span>
                                                                        <input id="ripetiNuovaPassword" name="ripetiNuovaPassword" class="form-control form-custom modificaProfilo" type="password" placeholder="••••••" oninput="colora(id,controllaRipetizionePassword('nuovaPassword',value))">
                                                                    </label>
                                                                    <div class="invalid-feedback ml-1">Le due password non corrispondono.</div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-2 mt-5">
                                                                <b>Password Corrente</b>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="w-100">
                                                                    <label>
<!--                                                                    TODO controllo password con php-->
                                                                        <input id="passwordCorrente" name="passwordCorrente" class="form-control form-custom" type="password" placeholder="••••••" oninput="colora(id, controllaPassword(value))" required>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer flex-row d-flex">
                                            <a class="btn btn-secondary btn-danger" data-toggle="modal" href="#modalEliminaProfilo">Elimina profilo</a>
                                            <button type="button" class="btn btn-secondary btn-outline-danger ml-auto" data-dismiss="modal">Annulla</button>
                                            <button type="submit" class="btn btn-primary btn-outline-success">Salva</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalEliminaProfilo">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>Sei sicuro?</h3>
                                    </div>
                                    <div class="modal-body">
                                        <h5 class="text-danger">Per creare un nuovo account dovrai contattare un amministratore di sistema.</h5>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="#" data-dismiss="modal" class="btn btn-outline-warning">Annulla</a>
                                        <a href="profilo_eliminato.html " class="btn btn-danger">Conferma</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <h6>

                    <?php
                    if ($utente["tipoAccount"] == "venditoreAcquirente"){
                        echo 'Acquirente e venditore';
                    }elseif ($utente["tipoAccount"] == "venditore"){
                        echo 'Venditore';
                    }else{
                        echo 'Acquirente';
                    }
                    ?>

                </h6>

                <?php
                if ($utente["tipoAccount"] == "acquirente" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <p class="profile-rating">PUNTEGGIO ACQUIRENTE:</p>
                    <ul class="rating p-0">
                        <li>
                            <i class="fas fa-star fa-sm text-primary orange-color"></i>
                        </li>
                        <li>
                            <i class="fas fa-star fa-sm text-primary orange-color"></i>
                        </li>
                        <li>
                            <i class="fas fa-star fa-sm text-primary orange-color"></i>
                        </li>
                        <li>
                            <i class="fas fa-star fa-sm text-primary orange-color"></i>
                        </li>
                        <li>
                            <i class="fas fa-star-half-alt fa-sm text-primary orange-color"></i>
                        </li>
                        <li class="ml-1">
                            <label class="material-tooltip-main card-link orange-color" data-toggle="tooltip" data-placement="top" title="Read reviews">(3 recensioni)</label>
                        </li>
                    </ul>
                <?php } ?>

                <?php
                if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <p class="profile-rating">PUNTEGGIO VENDITORE:</p>
                    <ul class="rating p-0">
                        <li>
                            <i class="fas fa-star fa-sm text-primary orange-color"></i>
                        </li>
                        <li>
                            <i class="fas fa-star fa-sm text-primary orange-color"></i>
                        </li>
                        <li>
                            <i class="fas fa-star fa-sm text-primary orange-color"></i>
                        </li>
                        <li>
                            <i class="fas fa-star fa-sm text-primary orange-color"></i>
                        </li>
                        <li>
                            <i class="fas fa-star-half-alt fa-sm text-primary orange-color"></i>
                        </li>
                        <li class="ml-1">
                            <label class="material-tooltip-main card-link orange-color" data-toggle="tooltip" data-placement="top" title="Read reviews">(1 recensioni)</label>
                        </li>
                    </ul>
                <?php } ?>

                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <?php
                    if ($utente["tipoAccount"] == "acquirente" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#annunciAcquistati" role="tab" aria-controls="annunciAcquistati" aria-selected="true">Annunci acquistati</a>
                        </li>
                    <?php } ?>

                    <?php
                    if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($utente["tipoAccount"] == "venditore") echo "active" ?>" id="profile-tab" data-toggle="tab" href="#annunciVenduti" role="tab" aria-controls="annunciVenduti" aria-selected="false">Annunci venduti</a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="profile-work profile-work-hiding">
                <p class="profile-title">DATI PERSONALI</p>
                <p>edoardo.perego@mail.com</p>
                <p>Merate</p>
                <p>Lecco, Lombardia</p>
                <p class="profile-title">STATISTICHE</p>

                <?php
                if ($utente["tipoAccount"] == "acquirente" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                <p>Annunci acquistati: 3</p>
                <?php } ?>

                <?php
                if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <p>Annunci venduti: 1</p>
                <?php } ?>

                <?php
                if (isset($_SESSION["isLogged"]) and $_SESSION["isLogged"]){ ?>
                    <form id="formLogout" action="backend/logout_exe.php">
                        <button id="logout" type="submit" class="btn btn-outline-danger btn-sm mt-4">Disconnetti</button>
                    </form>
                <?php } ?>

            </div>
        </div>
        <div class="col-md-8">
            <div id="myTabContent" class="tab-content profile-tab">

                <?php
                if ($utente["tipoAccount"] == "acquirente" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <div id="annunciAcquistati" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                        <div class="container pb-5 mt-n2 mt-md-n3">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Item-->
                                    <div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom">
                                        <div class="media d-block d-sm-flex text-center text-sm-left">
                                            <a class="cart-item-thumb mx-auto mr-sm-4" href="annuncio.php?dop=MjAyMS0wMS0wMSAwMDowMDowMA==&v=U0xORlBQOThTMjhGMjA1Vg==" target="_blank"><img src="img/lidl.jpeg" alt="Product" id="foto1"></a>
                                            <div class="media-body pt-3">
                                                <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo1"><a href="annuncio.html" target="_blank">Chitarra Lidl</a></h3>
                                                <div class="font-size-sm" id="prodotto1"><span class="text-muted mr-2">Prodotto:</span>Chitarra</div>
                                                <div class="font-size-sm" id="tempoUsura1"><span class="text-muted mr-2"><b>Nuovo</b></span></div>
                                                <div class="font-size-lg text-primary pt-2" id="prezzo1">€100.00</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Item-->
                                    <div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom">
                                        <div class="media d-block d-sm-flex text-center text-sm-left">
                                            <a class="cart-item-thumb mx-auto mr-sm-4" href="#" target="_blank"><img src="img/image_not_found.png" alt="Product" id="foto2"></a>
                                            <div class="media-body pt-3">
                                                <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo2"><a href="#" target="_blank">Album di figurine rare</a></h3>
                                                <div class="font-size-sm" id="prodotto2"><span class="text-muted mr-2">Prodotto:</span>Album</div>
                                                <div class="font-size-sm" id="tempoUsura2"><span class="text-muted mr-2"><b>Usato</b></span></div>
                                                <div class="font-size-lg text-primary pt-2" id="prezzo2">€75.00</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Item-->
                                    <div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom">
                                        <div class="media d-block d-sm-flex text-center text-sm-left">
                                            <a class="cart-item-thumb mx-auto mr-sm-4" href="#" target="_blank"><img src="img/image_not_found.png" alt="Product" id="foto3"></a>
                                            <div class="media-body pt-3">
                                                <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo3"><a href="#" target="_blank">Calvin Klein Jeans</a></h3>
                                                <div class="font-size-sm" id="prodotto3"><span class="text-muted mr-2">Prodotto:</span>Pantaloni</div>
                                                <div class="font-size-sm" id="tempoUsura3"><span class="text-muted mr-2"><b>Nuovo</b></span></div>
                                                <div class="font-size-lg text-primary pt-2" id="prezzo3">€125.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <nav class="pagination-wrapper pagination-box" aria-label="Esempio di navigazione con jump to page">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="fas fa-angle-left"></i>
                                        <span class="sr-only">Pagina precedente</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><span class="page-link">...</span></li>
                                <li class="page-item sparisci-2"><a class="page-link sparisci-2" href="#">24</a></li>
                                <li class="page-item sparisci"><a class="page-link sparisci" href="#">25</a></li>
                                <li class="page-item active">
                                    <a class="page-link" href="#" aria-current="page">26</a>
                                </li>
                                <li class="page-item sparisci"><a class="page-link sparisci" href="#">27</a></li>
                                <li class="page-item sparisci-2"><a class="page-link sparisci-2" href="#">28</a></li>
                                <li class="page-item"><span class="page-link">...</span></li>
                                <li class="page-item"><a class="page-link" href="#">50</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <span class="sr-only">Pagina successiva</span>
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="form-group page-box">
                                <label for="jumpToPageAnnunciAcquistati">
                                    <span aria-hidden="true"></span>
                                    <input type="text" class="form-control" id="jumpToPageAnnunciAcquistati" maxlength="3">
                                    Vai a ...<span class="sr-only">Indica la pagina desiderata</span>
                                </label>
                            </div>
                        </nav>
                    </div>
                <?php } ?>

                <?php
                if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <div id="annunciVenduti" class="tab-pane fade <?php if ($utente["tipoAccount"] == "venditore") echo "show active" ?>" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="container pb-5 mt-n2 mt-md-n3">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Item-->
                                    <div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom">
                                        <div class="media d-block d-sm-flex text-center text-sm-left">
                                            <a class="cart-item-thumb mx-auto mr-sm-4" href="#" target="_blank"><img src="img/gaming_pc.jpg" alt="Product" id="foto4"></a>
                                            <div class="media-body pt-3">
                                                <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo4"><a href="#" target="_blank">Computer portatile da gaming</a></h3>
                                                <div class="font-size-sm" id="prodotto4"><span class="text-muted mr-2">Prodotto:</span>Computer</div>
                                                <div class="font-size-sm" id="tempoUsura4"><span class="text-muted mr-2"><b>Usato</b></span></div>
                                                <div class="font-size-lg text-primary pt-2" id="prezzo4">€325.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <nav class="pagination-wrapper pagination-box nav-padding" aria-label="Esempio di navigazione con jump to page">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="fas fa-angle-left"></i>
                                        <span class="sr-only">Pagina precedente</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><span class="page-link">...</span></li>
                                <li class="page-item sparisci-2"><a class="page-link sparisci-2" href="#">7</a></li>
                                <li class="page-item sparisci"><a class="page-link sparisci" href="#">8</a></li>
                                <li class="page-item active">
                                    <a class="page-link" href="#" aria-current="page">9</a>
                                </li>
                                <li class="page-item sparisci"><a class="page-link sparisci" href="#">10</a></li>
                                <li class="page-item sparisci-2"><a class="page-link sparisci-2" href="#">11</a></li>
                                <li class="page-item"><span class="page-link">...</span></li>
                                <li class="page-item"><a class="page-link" href="#">50</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <span class="sr-only">Pagina successiva</span>
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="form-group page-box">
                                <label for="jumpToPageAnnunciVenduti">
                                    <span aria-hidden="true"></span>
                                    <input type="text" class="form-control" id="jumpToPageAnnunciVenduti" maxlength="3">
                                    Vai a ...<span class="sr-only">Indica la pagina desiderata</span>
                                </label>
                            </div>
                        </nav>
                    </div>
                <?php } ?>

            </div>
        </div>
        <div class="col-md-4 hidden-block">
            <div class="profile-work">
                <p class="profile-title">DATI PERSONALI</p>
                <p>edoardo.perego@mail.com</p>
                <p>Merate</p>
                <p>Lecco, Lombardia</p>
                <p class="profile-title">STATISTICHE</p>

                <?php
                if ($utente["tipoAccount"] == "acquirente" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <p>Annunci acquistati: 3</p>
                <?php } ?>

                <?php
                if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <p>Annunci venduti: 1</p>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<?php include_once "common/footer.php"?>

<?php include_once "common/common_script.php"; ?>

<script src="js/style.js"></script>
</body>
</html>