<?php
require_once  "common/session.php";

$utente["codiceFiscale"] = "SLNFPP98S28F205V";
$utente["nome"] = "Edoardo";
$utente["cognome"] = "Perego";
$utente["punteggioAcquirente"] = arrotondaValutazione("4.4");
$utente["nRecensioniAcquirente"] = "3";
$utente["punteggioVenditore"] = arrotondaValutazione("2.8");
$utente["nRecensioniVenditore"] = "1";
$utente["metodoDiPagamento"] = 0;
$utente["pagamento"] = $utente["metodoDiPagamento"]?"Carta di credito":"Contanti";
$utente["fotoProfilo"] = "venditore1.jpg";

$annuncio["dataOraPubblicazione"] = "2021-01-07 00:00:00";
$annuncio["venditore"] = "SLNFPP98S28F205V";
$annuncio["nomeVenditore"] = "Elena";
$annuncio["cognomeVenditore"] = "Crosta";
$annuncio["titolo"] = "Chitarra Lidl";
$annuncio["statoAnnuncio"] = "inVendita";
$annuncio["prodotto"] = "Chitarra";
$annuncio["tempoUsura"] = intval("1");
$annuncio["prezzo"] = "100.00";
$annuncio["fotoAnnuncio"] = "lidl.jpeg";
if ($annuncio["statoAnnuncio"] == "inVendita") {
    $annuncio["scadenza"] = calcolaScadenza($annuncio["dataOraPubblicazione"], $annuncio["venditore"], $annuncio["tempoUsura"]);
    if ($annuncio["scadenza"] < 1) $annuncio["statoAnnuncio"] = "eliminato";
}

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Operazioni</title>
    <?php include_once "common/common_header.php" ?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet" type="text/css" href="css/operazioni.css">
    <link rel="stylesheet" type="text/css" href="css/watched.css">
    <link rel="stylesheet" type="text/css" href="css/rating.css">
</head>

<body>
<?php include_once "common/navbar.php" ?>

<div class="d-flex flex-row container">
    <div class="p-2 text-center container-fluid">
        <h1 class="title-watched">Richieste</h1>
    </div>
    <div class="p-2 text-center container-fluid">
        <h1 class="title-watched">Valutazioni</h1>
    </div>
</div>

<ul class="nav nav-pills mb-3 justify-content-center container" id="pills-tab" role="tablist">
    <li class="nav-item w-25">
        <a class="nav-link orange-nav bordo-zero <?php if (isset($_SESSION["tipoAccount"]) and $_SESSION["tipoAccount"] != "acquirente") echo "active" ?>" data-toggle="pill" href="#tab-1" role="tab" aria-controls="pills-home"
           aria-selected="true">Da approvare</a>
    </li>
    <li class="nav-item w-25">
        <a class="nav-link orange-nav bordo-zero <?php if (isset($_SESSION["tipoAccount"]) and $_SESSION["tipoAccount"] == "acquirente") echo "active" ?>" data-toggle="pill" href="#tab-2" role="tab" aria-controls="pills-profile"
           aria-selected="false">Effettuate</a>
    </li>
    <li class="nav-item w-25">
        <a class="nav-link border-left orange-nav bordo-zero" data-toggle="pill" href="#tab-4" role="tab" aria-controls="pills-contact"
           aria-selected="false">Verso acquirente</a>
    </li>
    <li class="nav-item w-25">
        <a class="nav-link orange-nav bordo-zero" data-toggle="pill" href="#tab-3" role="tab"
           aria-controls="pills-contact" aria-selected="false">Verso venditore</a>
    </li>
</ul>

<div class="tab-content container drop-shadow altezza-minima" id="pills-tabContent">

    <div class="tab-pane fade <?php if (isset($_SESSION["tipoAccount"]) and $_SESSION["tipoAccount"] != "acquirente") echo "active show"?> " id="tab-1" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="container pb-5 mt-n2 mt-md-n3">

            <?php
            if (!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] == "acquirente"){ ?>
                <div class="w-100 p-lg-5">
                    <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                        <h2 class="container">Diventa venditore per pubblicare i tuoi annunci!</h2>
                    </div>
                </div>
            <?php }else{

                for ($j=0; $j<3; $j++){?>

                    <div class="col-md-12 d-flex flex-row row">
                        <!-- Item-->
                        <div class="justify-content-between my-4 pb-4 border-bottom col-md-6 nascondi-barra">
                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']);?>" target="_blank">
                                <img src="fotoAnnuncio/<?php inserisciFoto($annuncio['fotoAnnuncio']);?>" alt="Product"></a>
                                <div class="media-body pt-3">
                                    <h3 class="product-card-title font-weight-semibold border-0 pb-0"><a
                                            href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione'])?>" target="_blank"><?php echo $annuncio['titolo'];?></a></h3>
                                    <div class="font-size-sm"><span
                                            class="text-muted mr-2">Prodotto:</span><?php echo $annuncio['prodotto'];?></div>
                                    <div class="font-size-sm">
                                        <span class="text-muted mr-2"><b><?php echo $annuncio['tempoUsura'] == 0?'Nuovo':'Usato';?></b></span>
                                    </div>
                                    <div class="font-size-lg text-primary pt-2">€<?php echo $annuncio['prezzo'];?></div>
                                </div>
                            </div>
                        </div>
                        <!-- Item-->
                        <div class="justify-content-between my-4 pb-4 border-bottom col-md-6">
                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($utente['codiceFiscale'], '');?>" target="_blank">
                                    <img src="fotoProfilo/<?php inserisciFoto($utente['fotoProfilo']);?>" alt="Profilo">
                                </a>
                                <div class="media-body pt-3">
                                    <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                        <a href="<?php echo urlCriptato($utente['codiceFiscale'], '');?>" target="_blank"><?php echo $utente['nome'] . ' ' . $utente['cognome'];?></a>
                                    </h3>
                                    <div class="font-size-sm stelline">
                                        <ul class="rating p-0">
                                            <?php
                                            for ($i = 0; $i < 5; $i++) {

                                                if ($utente['punteggioAcquirente'] - $i >= 1){
                                                    echo '<li><i class="fas fa-star fa-sm text-primary orange-color"></i></li>';
                                                }elseif ($utente['punteggioAcquirente'] - $i == 0.5) {
                                                    echo '<li><i class="fas fa-star-half-alt fa-sm text-primary orange-color"></i></li>';
                                                }else{
                                                    echo '<li><i class="far fa-star fa-sm text-primary orange-color"></i></li>';
                                                }

                                            }?>
                                            <li class="ml-1">
                                                <label class="material-tooltip-main card-link orange-color"
                                                       data-toggle="tooltip" data-placement="top"
                                                       title="Read reviews">(<?php echo $utente['nRecensioniAcquirente'];?>)</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="font-size-sm pb-3 text-newline">
                                        <span class="text-muted mr-2">Pagamento:</span><?php echo $utente['pagamento'];?>
                                    </div>
                                    <form action="" method="get" >
                                        <div class="non-osservare d-flex">
                                            <button type="submit" class="btn btn-sm btn-outline-success mr-1">Approva</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            <?php } ?>
        </div>
    </div>

    <div class="tab-pane fade <?php if (isset($_SESSION["tipoAccount"]) and $_SESSION["tipoAccount"] == "acquirente") echo "active show"?>" id="tab-2" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="container pb-5 mt-n2 mt-md-n3">

            <?php
            if (!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] == "venditore"){ ?>
                <div class="w-100 p-lg-5">
                    <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                        <h2 class="container">Diventa acquirente per comprare qualcosa!</h2>
                    </div>
                </div>
            <?php }else{
                for ($j=0; $j<1; $j++){?>

                    <div class="col-md-12 d-flex flex-row row">
                        <!-- Item-->
                        <div class="justify-content-between my-4 pb-4 border-bottom col-md-6 nascondi-barra">
                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']);?>" target="_blank">
                                    <img src="fotoAnnuncio/<?php inserisciFoto($annuncio['fotoAnnuncio']);?>" alt="Product"></a>
                                <div class="media-body pt-3">
                                    <h3 class="product-card-title font-weight-semibold border-0 pb-0"><a
                                                href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione'])?>" target="_blank"><?php echo $annuncio['titolo'];?></a></h3>
                                    <div class="font-size-sm"><span
                                                class="text-muted mr-2">Prodotto:</span><?php echo $annuncio['prodotto'];?></div>
                                    <div class="font-size-sm">
                                        <span class="text-muted mr-2"><b><?php echo $annuncio['tempoUsura'] == 0?'Nuovo':'Usato';?></b></span>
                                    </div>
                                    <div class="font-size-lg text-primary pt-2">€<?php echo $annuncio['prezzo'];?></div>
                                </div>
                            </div>
                        </div>
                        <!-- Item-->
                        <div class="justify-content-between my-4 pb-4 border-bottom col-md-6">
                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($utente['codiceFiscale'], '');?>" target="_blank">
                                    <img src="fotoProfilo/<?php inserisciFoto($utente['fotoProfilo']);?>" alt="Profilo">
                                </a>
                                <div class="media-body pt-3">
                                    <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                        <a href="<?php echo urlCriptato($utente['codiceFiscale'], '');?>" target="_blank"><?php echo $utente['nome'] . ' ' . $utente['cognome'];?></a>
                                    </h3>
                                    <div class="font-size-sm stelline">
                                        <ul class="rating p-0">
                                            <?php
                                            for ($i = 0; $i < 5; $i++) {

                                                if ($utente['punteggioVenditore'] - $i >= 1){
                                                    echo '<li><i class="fas fa-star fa-sm text-primary orange-color"></i></li>';
                                                }elseif ($utente['punteggioVenditore'] - $i == 0.5) {
                                                    echo '<li><i class="fas fa-star-half-alt fa-sm text-primary orange-color"></i></li>';
                                                }else{
                                                    echo '<li><i class="far fa-star fa-sm text-primary orange-color"></i></li>';
                                                }

                                            }?>
                                            <li class="ml-1">
                                                <label class="material-tooltip-main card-link orange-color"
                                                       data-toggle="tooltip" data-placement="top"
                                                       title="Read reviews">(<?php echo $utente['nRecensioniVenditore'];?>)</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="font-size-sm pb-3 text-newline">
                                        <span class="text-muted mr-2">Pagamento:</span><?php echo $utente['pagamento'];?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <div class="tab-pane fade" id="tab-4" role="tabpanel" aria-labelledby="pills-contact-tab">
        <div class="container pb-5 mt-n2 mt-md-n3">

            <?php
            if (!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] == "acquirente"){ ?>
                <div class="w-100 p-lg-5">
                    <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                        <h2 class="container">Diventa venditore per valutare i tuoi compratori!</h2>
                    </div>
                </div>
            <?php }else{

                for ($j = 0; $j < 3; $j++){?>

                    <div class="col-md-12 d-flex flex-row row">
                    <!-- Item-->
                    <div class="justify-content-between my-4 pb-4 border-bottom col-md-6 nascondi-barra">
                        <div class="media d-block d-sm-flex text-center text-sm-left">
                            <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']);?>" target="_blank">
                                <img src="fotoAnnuncio/<?php inserisciFoto($annuncio['fotoAnnuncio']);?>" alt="Product"></a>
                            <div class="media-body pt-3">
                                <h3 class="product-card-title font-weight-semibold border-0 pb-0"><a
                                            href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione'])?>" target="_blank"><?php echo $annuncio['titolo'];?></a></h3>
                                <div class="font-size-sm"><span
                                            class="text-muted mr-2">Prodotto:</span><?php echo $annuncio['prodotto'];?></div>
                                <div class="font-size-sm">
                                    <span class="text-muted mr-2"><b><?php echo $annuncio['tempoUsura'] == 0?'Nuovo':'Usato';?></b></span>
                                </div>
                                <div class="font-size-lg text-primary pt-2">€<?php echo $annuncio['prezzo'];?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Item-->
                    <div class="justify-content-between my-4 pb-4 border-bottom col-md-6">
                        <div class="media d-block d-sm-flex text-center text-sm-left">
                            <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($utente['codiceFiscale'], '');?>" target="_blank">
                                <img src="fotoProfilo/<?php inserisciFoto($utente['fotoProfilo']);?>" alt="Profilo">
                            </a>
                            <div class="media-body pt-3">
                                <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                    <a href="<?php echo urlCriptato($utente['codiceFiscale'], '');?>" target="_blank"><?php echo $utente['nome'] . ' ' . $utente['cognome'];?></a>
                                </h3>
                                <div class="font-size-sm stelline">
                                    <ul class="rating p-0">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {

                                            if ($utente['punteggioAcquirente'] - $i >= 1){
                                                echo '<li><i class="fas fa-star fa-sm text-primary orange-color"></i></li>';
                                            }elseif ($utente['punteggioAcquirente'] - $i == 0.5) {
                                                echo '<li><i class="fas fa-star-half-alt fa-sm text-primary orange-color"></i></li>';
                                            }else{
                                                echo '<li><i class="far fa-star fa-sm text-primary orange-color"></i></li>';
                                            }

                                        }?>
                                        <li class="ml-1">
                                            <label class="material-tooltip-main card-link orange-color"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="Read reviews">(<?php echo $utente['nRecensioniAcquirente'];?>)</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="font-size-sm pb-3 text-newline">
                                    <span class="text-muted mr-2">Pagamento:</span><?php echo $utente['pagamento'];?>
                                </div>
                            </div>
                        </div>
                        <form id="valutazioneAcquirente_<?php echo $j;?>" action="" method="get">
                            <div class="media-body pt-3 mt-3">
                                <div class="starrating risingstar d-flex flex-row-reverse">
                                    <div class="ml-auto">
                                        <button type="submit" class="btn btn-sm btn-outline-success mr-1" onclick="colora('valutazioneAcquirente_<?php echo $j;?>', controllaValutazione('valutazioneAcquirente_<?php echo $j;?>'))">Conferma</button>
                                    </div>
                                    <input type="radio" id="serieta5-a<?php echo $j;?>" name="ratingS" value="5" required/><label
                                        for="serieta5-a<?php echo $j;?>" title="5 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="serieta4-a<?php echo $j;?>" name="ratingS" value="4" required/><label
                                        for="serieta4-a<?php echo $j;?>" title="4 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="serieta3-a<?php echo $j;?>" name="ratingS" value="3" required/><label
                                        for="serieta3-a<?php echo $j;?>" title="3 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="serieta2-a<?php echo $j;?>" name="ratingS" value="2" required/><label
                                        for="serieta2-a<?php echo $j;?>" title="2 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="serieta1-a<?php echo $j;?>" name="ratingS" value="1" required/><label
                                        for="serieta1-a<?php echo $j;?>" title="1 star"><i class="fas fa-star fa-sm"></i></label>
                                    <span class="mr-3"><i><b>Serietà:&nbsp; &nbsp; &nbsp;</b></i></span>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="starrating risingstar d-flex flex-row-reverse justify-content-end">
                                    <div class="ml-auto text-danger mt-2">
                                        Servono entrambe le valutazioni
                                    </div>
                                    <input type="radio" id="puntalita5-a<?php echo $j;?>" name="ratingP" value="5" required/><label
                                        for="puntalita5-a<?php echo $j;?>" title="5 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="puntalita4-a<?php echo $j;?>" name="ratingP" value="4" required/><label
                                        for="puntalita4-a<?php echo $j;?>" title="4 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="puntalita3-a<?php echo $j;?>" name="ratingP" value="3" required/><label
                                        for="puntalita3-a<?php echo $j;?>" title="3 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="puntalita2-a<?php echo $j;?>" name="ratingP" value="2" required/><label
                                        for="puntalita2-a<?php echo $j;?>" title="2 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="puntalita1-a<?php echo $j;?>" name="ratingP" value="1" required/><label
                                        for="puntalita1-a<?php echo $j;?>" title="1 star"><i class="fas fa-star fa-sm"></i></label>
                                    <span class="mr-3"><i><b>Puntualità:</b></i></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <?php } ?>

            <?php } ?>

        </div>
    </div>

    <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="pills-contact-tab">
        <div class="container pb-5 mt-n2 mt-md-n3">

            <?php
            if (!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] == "venditore"){?>
                <div class="w-100 p-lg-5">
                    <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                        <h2 class="container">Diventa acquirente per valutare i tuoi venditori!</h2>
                    </div>
                </div>
            <?php }else{

                for ($j=0; $j<2; $j++){?>

                    <div class="col-md-12 d-flex flex-row row">
                    <!-- Item-->
                    <div class="justify-content-between my-4 pb-4 border-bottom col-md-6 nascondi-barra">
                        <div class="media d-block d-sm-flex text-center text-sm-left">
                            <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']);?>" target="_blank">
                                <img src="fotoAnnuncio/<?php inserisciFoto($annuncio['fotoAnnuncio']);?>" alt="Product"></a>
                            <div class="media-body pt-3">
                                <h3 class="product-card-title font-weight-semibold border-0 pb-0"><a
                                            href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione'])?>" target="_blank"><?php echo $annuncio['titolo'];?></a></h3>
                                <div class="font-size-sm"><span
                                            class="text-muted mr-2">Prodotto:</span><?php echo $annuncio['prodotto'];?></div>
                                <div class="font-size-sm">
                                    <span class="text-muted mr-2"><b><?php echo $annuncio['tempoUsura'] == 0?'Nuovo':'Usato';?></b></span>
                                </div>
                                <div class="font-size-lg text-primary pt-2">€<?php echo $annuncio['prezzo'];?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Item-->
                    <div class="justify-content-between my-4 pb-4 border-bottom col-md-6" id="2">
                        <div class="media d-block d-sm-flex text-center text-sm-left">
                            <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($utente['codiceFiscale'], '');?>" target="_blank">
                                <img src="fotoProfilo/<?php inserisciFoto($utente['fotoProfilo']);?>" alt="Profilo">
                            </a>
                            <div class="media-body pt-3">
                                <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                    <a href="<?php echo urlCriptato($utente['codiceFiscale'], '');?>" target="_blank"><?php echo $utente['nome'] . ' ' . $utente['cognome'];?></a>
                                </h3>
                                <div class="font-size-sm stelline">
                                    <ul class="rating p-0">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {

                                            if ($utente['punteggioVenditore'] - $i >= 1){
                                                echo '<li><i class="fas fa-star fa-sm text-primary orange-color"></i></li>';
                                            }elseif ($utente['punteggioVenditore'] - $i == 0.5) {
                                                echo '<li><i class="fas fa-star-half-alt fa-sm text-primary orange-color"></i></li>';
                                            }else{
                                                echo '<li><i class="far fa-star fa-sm text-primary orange-color"></i></li>';
                                            }

                                        }?>
                                        <li class="ml-1">
                                            <label class="material-tooltip-main card-link orange-color"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="Read reviews">(<?php echo $utente['nRecensioniVenditore'];?>)</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="font-size-sm pb-3 text-newline">
                                    <span class="text-muted mr-2">Pagamento:</span><?php echo $utente['pagamento'];?>
                                </div>
                            </div>
                        </div>
                        <form id="valutazioneVenditore_<?php echo $j;?>" action="">
                            <div class="media-body pt-3 mt-3">
                                <div class="starrating risingstar d-flex flex-row-reverse">
                                    <div class="ml-auto">
                                        <button type="submit" class="btn btn-sm btn-outline-success mr-1" onclick="colora('valutazioneVenditore_<?php echo $j;?>', controllaValutazione('valutazioneVenditore_<?php echo $j;?>'))">Conferma</button>
                                    </div>
                                    <input type="radio" id="serieta5-v<?php echo $j;?>" name="ratingS" value="5" required/><label
                                        for="serieta5-v<?php echo $j;?>" title="5 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="serieta4-v<?php echo $j;?>" name="ratingS" value="4" required/><label
                                        for="serieta4-v<?php echo $j;?>" title="4 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="serieta3-v<?php echo $j;?>" name="ratingS" value="3" required/><label
                                        for="serieta3-v<?php echo $j;?>" title="3 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="serieta2-v<?php echo $j;?>" name="ratingS" value="2" required/><label
                                        for="serieta2-v<?php echo $j;?>" title="2 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="serieta1-v<?php echo $j;?>" name="ratingS" value="1" required/><label
                                        for="serieta1-v<?php echo $j;?>" title="1 star"><i class="fas fa-star fa-sm"></i></label>
                                    <span class="mr-3"><i><b>Serietà:&nbsp; &nbsp; &nbsp;</b></i></span>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="starrating risingstar d-flex flex-row-reverse justify-content-end">
                                    <div class="ml-auto text-danger mt-2">
                                        Servono entrambe le valutazioni
                                    </div>
                                    <input type="radio" id="puntalita5-v<?php echo $j;?>" name="ratingP" value="5" required/><label
                                        for="puntalita5-v<?php echo $j;?>" title="5 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="puntalita4-v<?php echo $j;?>" name="ratingP" value="4" required/><label
                                        for="puntalita4-v<?php echo $j;?>" title="4 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="puntalita3-v<?php echo $j;?>" name="ratingP" value="3" required/><label
                                        for="puntalita3-v<?php echo $j;?>" title="3 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="puntalita2-v<?php echo $j;?>" name="ratingP" value="2" required/><label
                                        for="puntalita2-v<?php echo $j;?>" title="2 star"><i class="fas fa-star fa-sm"></i></label>
                                    <input type="radio" id="puntalita1-v<?php echo $j;?>" name="ratingP" value="1" required/><label
                                        for="puntalita1-v<?php echo $j;?>" title="1 star"><i class="fas fa-star fa-sm"></i></label>
                                    <span class="mr-3"><i><b>Puntualità:</b></i></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <?php } ?>

            <?php } ?>

        </div>
    </div>

</div>

<?php include_once "common/footer.php" ?>

<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<script src="js/navbar.js"></script>
<script src="js/controlloInput.js"></script>
</body>
</html>
