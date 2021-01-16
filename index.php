<?php
require_once "common/session.php";
include_once "common/connessioneDB.php";
include_once "common/funzioni.php";
include_once "common/query.php";

$utente["codiceFiscale"] = "PNACCL83E41G713I";
$utente["nome"] = "Edoardo";
$utente["cognome"] = "Perego";
$utente["fotoProfilo"] = "venditore1.jpg";

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Bee Market</title>
    <?php include_once "common/common_header.php"?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
</head>

<body>
<?php include_once "common/navbar.php"?>


<div class="banner jumbotron jumbotron-fluid">
    <?php if (isset($_SESSION["nome"]) and $_SESSION["nome"]) echo '<h1 class="display-4 ciao">Ciao ' . $_SESSION["nome"] . '!</h1>'; else echo '<h1 class="display-4">Benvenuto!</h1>' ?>
    <h1 class="lead">Vuoi vendere qualcosa? Posta un nuovo annuncio e scopri chi vorrebbe comprare!</h1>

    <a class="banner-button" href="<?php echo array('#modalLoginRegister', '#modalNuovoAnnuncio')[isset($_SESSION['isLogged'])]; ?>" data-toggle="modal">Nuovo Annuncio</a>
    <div class="modal fade modal-only" id="modalNuovoAnnuncio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog edit-profile" role="document">
            <?php if ($_SESSION["tipoAccount"] != "acquirente"){?>
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
                                        <img id="fotoInput" src="fotoAnnuncio/image_not_found.png" alt=""/>
                                        <div class="file btn btn-lg x btn-primary mt-0">
                                            Inserisci foto
                                            <input type="file" name="file" class="w-100 h-100" onchange="loadFile(event)" accept="image/png, image/jpeg, image/jpg"/>
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
                                                    <select name="categoria" id="categoria" class="form-control nuovoAnnuncio" onchange="sottoCategoria('sottocategoria', selectedIndex)" required>
                                                        <option value="" disabled selected hidden>Categoria</option>
                                                        <option value="elettrodomestici">Elettrodomestici</option>
                                                        <option value="fotoEVideo">Foto e video</option>
                                                        <option value="abbigliamento">Abbigliamento</option>
                                                        <option value="hobby">Hobby</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <label>
                                                    <select name="sottcategoria" id="sottocategoria" class="form-control nuovoAnnuncio" required>
                                                        <option value="" disabled selected hidden>Sottocategoria</option>
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
                                                    </select>
                                                </label>
                                                <label>
                                                    <select name="luogoVenditaProvincia" id="luogoVenditaProvincia" class="form-control nuovoAnnuncio" required>
                                                        <option value="" disabled selected hidden>Provincia</option>
                                                    </select>
                                                </label>
                                                <label>
                                                    <select name="luogoVenditaComune" id="luogoVenditaComune" class="form-control nuovoAnnuncio" required>
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
            <?php }else{ ?>
                <div class="modal-content">
                    <div class="w-100 p-lg-5">
                        <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                            <h2 class="container">Diventa venditore per pubblicare i tuoi annunci!</h2>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
                    <form class="form my-2 my-lg-0 nav-form" method="get" action="risultati.php?">
                        <input name="sc" type="text" class="d-none" value="0">
                        <p>Cosa cerchi?</p>
                        <input name="testoRicerca" class="form-control form-custom mr-sm-2 popup" type="search"
                               placeholder="Frullatore, Smart Tv, Aspirapolvere" aria-label="Search">
                        <p>Dove lo cerchi?</p>
                        <label class="popup">
                            <select class="form-control form-custom" name="regione" id="regione1">
                                <option value="0">Tutta Italia</option>
                                <option value="1">Lombardia</option>
                                <option value="2">Sardegna</option>
                            </select>
                        </label>
                        <label class="popup">
                            <select class="form-control form-custom" name="provincia" id="provincia1">
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
                    <form class="form my-2 my-lg-0 nav-form" method="get" action="risultati.php">
                        <input name="sc" type="text" class="d-none" value="6">
                        <p>Cosa cerchi?</p>
                        <input name="testoRicerca" class="form-control form-custom mr-sm-2 popup" type="search"
                               placeholder="Reflex, Treppiede, Registratore" aria-label="Search">
                        <p>Dove lo cerchi?</p>
                        <label class="popup">
                            <select class="form-control form-custom" name="regione" id="regione2">
                                <option value="0">Tutta Italia</option>
                                <option value="1">Lombardia</option>
                                <option value="2">Sardegna</option>
                            </select>
                        </label>
                        <label class="popup">
                            <select class="form-control form-custom" name="provincia" id="provincia2">
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
                    <form class="form my-2 my-lg-0 nav-form" method="get" action="risultati.php">
                        <input name="sc" type="text" class="d-none" value="12">
                        <p>Cosa cerchi?</p>
                        <input name="testoRicerca" class="form-control form-custom mr-sm-2 popup" type="search"
                               placeholder="Sciarpa, Scarpe, Borsa" aria-label="Search">
                        <p>Dove lo cerchi?</p>
                        <label class="popup">
                            <select class="form-control form-custom" name="regione" id="regione3">
                                <option value="0">Tutta Italia</option>
                                <option value="1">Lombardia</option>
                                <option value="2">Sardegna</option>
                            </select>
                        </label>
                        <label class="popup">
                            <select class="form-control form-custom" name="provincia" id="provincia3">
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
                    <form class="form my-2 my-lg-0 nav-form" method="get" action="risultati.php">
                        <input name="sc" type="text" class="d-none" value="18">
                        <p>Cosa cerchi?</p>
                        <input name="testoRicerca" class="form-control form-custom mr-sm-2 popup" type="search"
                               placeholder="Cuffie, Chitarra, Racchettoni" aria-label="Search">
                        <p>Dove lo cerchi?</p>
                        <label class="popup">
                            <select class="form-control form-custom" name="regione" id="regione4">
                                <option value="0">Tutta Italia</option>
                                <option value="1">Lombardia</option>
                                <option value="2">Sardegna</option>
                            </select>
                        </label>
                        <label class="popup">
                            <select class="form-control form-custom" name="provincia" id="provincia4">
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
                            <div class="bbb_viewed_nav bbb_viewed_prev">
                                <img src="img/chevron-left-solid.svg" alt="sinistra">
                            </div>
                            <div class="bbb_viewed_nav bbb_viewed_next">
                                <img src="img/chevron-right-solid.svg" alt="destra">
                            </div>
                        </div>
                    </div>
                    <div class="bbb_viewed_slider_container">
                        <div class="owl-carousel owl-theme bbb_viewed_slider">
                            <?php
                            $annunciTop = annunciTop_sql($cid, isset($_SESSION["isLogged"])?$_SESSION["codiceFiscale"]:'');
                            $i = 1;
                            while ($annuncio = $annunciTop -> fetch_assoc()){
                                $annuncio["scadenza"] = calcolaScadenza($annuncio["dataOraPubblicazione"], $annuncio["venditore"], $annuncio["tempoUsura"]);
                                if ($annuncio["scadenza"] < 1) {
                                    $annuncio["statoAnnuncio"] = "eliminato";
                                    continue;
                                }
                            ?>
                            <div class="owl-item">
                                <div class="bbb_viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <i class="d-none numerino"><?php echo $i;?>°</i>
                                    <a href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']);?>" class="bbb_viewed_image">
                                        <img class="m-auto" src="fotoAnnuncio/<?php inserisciFoto($annuncio['fotoAnnuncio']);?>" alt="">
                                    </a>
                                    <?php if ($annuncio["tempoUsura"] > 0) echo '<ul class="item_marks"><li class="item_mark item_discount">Usato</li></ul>'?>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_price">€<?php echo $annuncio["prezzo"];?></div>
                                        <div class="bbb_viewed_name">
                                            <a href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']);?>"><?php echo $annuncio["titolo"];?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $i++; } ?>
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
                        <h3 class="bbb_viewed_title">Venditori TOP</h3>
                        <div class="bbb_viewed_nav_container">
                            <div class="bbb_viewed_nav bbb_viewed_prev_v">
                                <img src="img/chevron-left-solid.svg" alt="sinistra">
                            </div>
                            <div class="bbb_viewed_nav bbb_viewed_next_v">
                                <img src="img/chevron-right-solid.svg" alt="destra">
                            </div>
                        </div>
                    </div>
                    <div class="bbb_viewed_slider_container">
                        <div class="owl-carousel owl-theme bbb_viewed_slider_v">
                            <?php
                            $venditori = venditoriTop_sql($cid);
                            $i = 1;
                            while ($utente = $venditori -> fetch_assoc()){
                            ?>
                            <div class="owl-item">
                                <div class="bbb_viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <i class="d-none numerino"><?php echo $i;?>°</i>
                                    <a href="<?php echo urlCriptato($utente['codiceFiscale'], '');?>" class="bbb_viewed_image">
                                        <img src="fotoProfilo/<?php inserisciFoto($utente['fotoProfilo']);?>" alt="">
                                    </a>
                                    <div class="bbb_viewed_content text-center">
                                        <div class="bbb_viewed_name">
                                            <a href="<?php echo urlCriptato($utente['codiceFiscale'], '');?>"><?php echo $utente['nome'] . ' ' . $utente['cognome'];?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once "common/footer.php"?>

<?php include_once "common/common_script.php"; ?>
<script src="js/carosello.js"></script>
<script src="js/owl.carousel.js"></script>

</body>
</html>