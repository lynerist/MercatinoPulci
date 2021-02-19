<?php
require_once "common/session.php";
include_once "common/funzioni.php";
include_once "common/connessioneDB.php";
include_once "common/query.php";

$nNotificheRichiesteRicevute = nNotificheRichiesteRicevute_sql($cid,isset($_SESSION["codiceFiscale"])?$_SESSION["codiceFiscale"]:"");
$nNotificheValutazioniSuVenditore = nNotificheValutazioniSuVenditore_sql($cid,isset($_SESSION["codiceFiscale"])?$_SESSION["codiceFiscale"]:"");
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
           aria-selected="true">Da approvare<?php if ($nNotificheRichiesteRicevute>0) echo '<span class="badge badge-warning rounded ml-2">' . $nNotificheRichiesteRicevute . ' novità</span>'?></a>
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
           aria-controls="pills-contact" aria-selected="false">Verso venditore<?php if ($nNotificheValutazioniSuVenditore>0) echo '<span class="badge badge-warning rounded ml-2">' . $nNotificheValutazioniSuVenditore . ' novità</span>'?></a>
    </li>
</ul>

<div class="tab-content container drop-shadow altezza-minima" id="pills-tabContent">

    <div class="tab-pane fade <?php if (isset($_SESSION["tipoAccount"]) and $_SESSION["tipoAccount"] != "acquirente") echo "active show"?> " id="tab-1" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="container pb-5 mt-n2 mt-md-n3 pt-4">

            <?php
            if (!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] == "acquirente"){ ?>
                <div class="w-100 p-lg-5">
                    <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                        <h2 class="container">Diventa venditore per pubblicare i tuoi annunci!</h2>
                    </div>
                </div>
            <?php }else{
                $daApprovare = trovaDaApprovare_sql($cid, $_SESSION["codiceFiscale"]);
                if($daApprovare -> num_rows == 0){
                    echo '<div class="w-100 p-lg-5">
                            <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                                <h2 class="container">Nessuna richiesta di acquisto da approvare</h2>
                            </div>
                          </div>';
                }
                while ($annuncio = $daApprovare -> fetch_assoc()){
                    $annuncio["scadenza"] = calcolaScadenza($cid, $annuncio["dataOraPubblicazione"], $annuncio["venditore"], $annuncio["tempoUsura"]);
                    if ($annuncio["scadenza"] < 1) {
                        $annuncio["statoAnnuncio"] = "eliminato";
                        continue;
                    }
                    $valutazioni = valutazioni_sql($cid, $annuncio["acquirente"]);?>
                    <div class="col-md-12 d-flex flex-row row border-bottom <?php echo ($annuncio['daNotificare']=='1'?'background-notifica':'');?>">
                        <!-- Item-->
                        <div class="justify-content-between my-4 pb-4 col-md-6">
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
                        <div class="justify-content-between my-4 pb-4 col-md-6">
                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($annuncio['acquirente'], '');?>" target="_blank">
                                    <img src="fotoProfilo/<?php inserisciFoto($annuncio['fotoProfilo']);?>" alt="Profilo">
                                </a>
                                <div class="media-body pt-3">
                                    <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                        <a href="<?php echo urlCriptato($annuncio['acquirente'], '');?>" target="_blank"><?php echo $annuncio['nome'] . ' ' . $annuncio['cognome'];?></a>
                                    </h3>
                                    <div class="font-size-sm stelline">
                                        <ul class="rating p-0">
                                            <?php
                                            for ($i = 0; $i < 5; $i++) {

                                                if ($valutazioni['mediaAcquirente'] - $i >= 1){
                                                    echo '<li><i class="fas fa-star fa-sm text-primary orange-color"></i></li>';
                                                }elseif ($valutazioni['mediaAcquirente'] - $i == 0.5) {
                                                    echo '<li><i class="fas fa-star-half-alt fa-sm text-primary orange-color"></i></li>';
                                                }else{
                                                    echo '<li><i class="far fa-star fa-sm text-primary orange-color"></i></li>';
                                                }

                                            }?>
                                            <li class="ml-1">
                                                <label class="material-tooltip-main card-link orange-color"
                                                       data-toggle="tooltip" data-placement="top"
                                                       title="Read reviews">(<?php echo $valutazioni['nValutazioniAcquirente'];?>)</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="font-size-sm pb-3 text-newline">
                                        <span class="text-muted mr-2">Pagamento:</span><?php echo $annuncio['pagamento']?'Carta di credito':'Contanti';?>
                                    </div>
                                    <form method="post" action="backend/confermaVendita_exe.php<?php echo "?a=" . base64_encode($annuncio['acquirente']) . "&v=" . base64_encode($annuncio['venditore']) . "&dop=" . base64_encode($annuncio['dataOraPubblicazione'])?>" >
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
        <div class="container pb-5 mt-n2 mt-md-n3 pt-4">

            <?php
            if (!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] == "venditore"){ ?>
                <div class="w-100 p-lg-5">
                    <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                        <h2 class="container">Diventa acquirente per comprare qualcosa!</h2>
                    </div>
                </div>
            <?php }else{
                $effettuate = trovaEffettuate_sql($cid, $_SESSION["codiceFiscale"]);
                if ($effettuate -> num_rows == 0){
                    echo '<div class="w-100 p-lg-5">
                            <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                                <h2 class="container">Nessuna richiesta di acquisto effettuata</h2>
                            </div>
                          </div>';
                }
                while ($annuncio = $effettuate -> fetch_assoc()){
                    $annuncio["scadenza"] = calcolaScadenza($cid, $annuncio["dataOraPubblicazione"], $annuncio["venditore"], $annuncio["tempoUsura"]);
                    if ($annuncio["scadenza"] < 1) {
                        $annuncio["statoAnnuncio"] = "eliminato";
                        continue;
                    }
                    $valutazioni = valutazioni_sql($cid, $annuncio["venditore"]);?>

                    <div class="col-md-12 d-flex flex-row row border-bottom">
                        <!-- Item-->
                        <div class="justify-content-between my-4 pb-4 col-md-6">
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
                        <div class="justify-content-between my-4 pb-4 col-md-6">
                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($annuncio['venditore'], '');?>" target="_blank">
                                    <img src="fotoProfilo/<?php inserisciFoto($annuncio['fotoProfilo']);?>" alt="Profilo">
                                </a>
                                <div class="media-body pt-3">
                                    <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                        <a href="<?php echo urlCriptato($annuncio['venditore'], '');?>" target="_blank"><?php echo $annuncio['nome'] . ' ' . $annuncio['cognome'];?></a>
                                    </h3>
                                    <div class="font-size-sm stelline">
                                        <ul class="rating p-0">
                                            <?php
                                            for ($i = 0; $i < 5; $i++) {

                                                if ($valutazioni['mediaVenditore'] - $i >= 1){
                                                    echo '<li><i class="fas fa-star fa-sm text-primary orange-color"></i></li>';
                                                }elseif ($valutazioni['mediaVenditore'] - $i == 0.5) {
                                                    echo '<li><i class="fas fa-star-half-alt fa-sm text-primary orange-color"></i></li>';
                                                }else{
                                                    echo '<li><i class="far fa-star fa-sm text-primary orange-color"></i></li>';
                                                }

                                            }?>
                                            <li class="ml-1">
                                                <label class="material-tooltip-main card-link orange-color"
                                                       data-toggle="tooltip" data-placement="top"
                                                       title="Read reviews">(<?php echo $valutazioni['nValutazioniVenditore'];?>)</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="font-size-sm pb-3 text-newline">
                                        <span class="text-muted mr-2">Pagamento:</span><?php echo $annuncio['pagamento']?'Carta di credito':'Contanti';?>
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
        <div class="container pb-5 mt-n2 mt-md-n3 pt-4">

            <?php
            if (!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] == "acquirente"){ ?>
                <div class="w-100 p-lg-5">
                    <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                        <h2 class="container">Diventa venditore per valutare i tuoi compratori!</h2>
                    </div>
                </div>
            <?php }else{
                $versoAcquirente = trovaVersoAcquirente_sql($cid, $_SESSION["codiceFiscale"]);
                if ($versoAcquirente -> num_rows == 0){
                    echo '<div class="w-100 p-lg-5">
                            <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                                <h2 class="container">Nessuna valutazione da effettuare</h2>
                            </div>
                          </div>';
                }
                $j = 0;
                while ($annuncio = $versoAcquirente -> fetch_assoc()){
                    $valutazioni = valutazioni_sql($cid, $annuncio["acquirente"]);?>

                    <div class="col-md-12 d-flex flex-row row border-bottom">
                    <!-- Item-->
                    <div class="justify-content-between my-4 pb-4 col-md-6">
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
                    <div class="justify-content-between my-4 pb-4 col-md-6">
                        <div class="media d-block d-sm-flex text-center text-sm-left">
                            <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($annuncio['acquirente'], '');?>" target="_blank">
                                <img src="fotoProfilo/<?php inserisciFoto($annuncio['fotoProfilo']);?>" alt="Profilo">
                            </a>
                            <div class="media-body pt-3">
                                <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                    <a href="<?php echo urlCriptato($annuncio['acquirente'], '');?>" target="_blank"><?php echo $annuncio['nome'] . ' ' . $annuncio['cognome'];?></a>
                                </h3>
                                <div class="font-size-sm stelline">
                                    <ul class="rating p-0">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {

                                            if ($valutazioni['mediaAcquirente'] - $i >= 1){
                                                echo '<li><i class="fas fa-star fa-sm text-primary orange-color"></i></li>';
                                            }elseif ($valutazioni['mediaAcquirente'] - $i == 0.5) {
                                                echo '<li><i class="fas fa-star-half-alt fa-sm text-primary orange-color"></i></li>';
                                            }else{
                                                echo '<li><i class="far fa-star fa-sm text-primary orange-color"></i></li>';
                                            }

                                        }?>
                                        <li class="ml-1">
                                            <label class="material-tooltip-main card-link orange-color"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="Read reviews">(<?php echo $valutazioni['nValutazioniAcquirente'];?>)</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <form id="valutazioneAcquirente_<?php echo $j;?>" action="backend/inserisciValutazione_exe.php?verso=acquirente<?php echo "&a=" . base64_encode($annuncio['acquirente']) . "&v=" . base64_encode($annuncio['venditore']) . "&dop=" . base64_encode($annuncio['dataOraPubblicazione'])?>" method="post">
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

                <?php $j++; } ?>

            <?php } ?>

        </div>
    </div>

    <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="pills-contact-tab">
        <div class="container pb-5 mt-n2 mt-md-n3 pt-4">

            <?php
            if (!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] == "venditore"){?>
                <div class="w-100 p-lg-5">
                    <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                        <h2 class="container">Diventa acquirente per valutare i tuoi venditori!</h2>
                    </div>
                </div>
            <?php }else{
                $versoVenditore = trovaVersoVenditore_sql($cid, $_SESSION["codiceFiscale"]);
                if ($versoVenditore -> num_rows == 0){
                    echo '<div class="w-100 p-lg-5">
                            <div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                                <h2 class="container">Nessuna valutazione da effettuare</h2>
                            </div>
                          </div>';
                }
                $j = 0;
                while ($annuncio = $versoVenditore -> fetch_assoc()){
                    $valutazioni = valutazioni_sql($cid, $annuncio["venditore"])
                    ?>
                    <div class="col-md-12 d-flex flex-row row border-bottom <?php echo ($annuncio['daNotificare']=='1'?'background-notifica':'');?>">
                    <!-- Item-->
                    <div class="justify-content-between my-4 pb-4 col-md-6">
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
                    <div class="justify-content-between my-4 pb-4 col-md-6" id="2">
                        <div class="media d-block d-sm-flex text-center text-sm-left">
                            <a class="cart-item-thumb mx-auto mr-sm-4" href="<?php echo urlCriptato($annuncio['venditore'], '');?>" target="_blank">
                                <img src="fotoProfilo/<?php inserisciFoto($annuncio['fotoProfilo']);?>" alt="Profilo">
                            </a>
                            <div class="media-body pt-3">
                                <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                    <a href="<?php echo urlCriptato($annuncio['venditore'], '');?>" target="_blank"><?php echo $annuncio['nome'] . ' ' . $annuncio['cognome'];?></a>
                                </h3>
                                <div class="font-size-sm stelline">
                                    <ul class="rating p-0">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {

                                            if ($valutazioni['mediaVenditore'] - $i >= 1){
                                                echo '<li><i class="fas fa-star fa-sm text-primary orange-color"></i></li>';
                                            }elseif ($valutazioni['mediaVenditore'] - $i == 0.5) {
                                                echo '<li><i class="fas fa-star-half-alt fa-sm text-primary orange-color"></i></li>';
                                            }else{
                                                echo '<li><i class="far fa-star fa-sm text-primary orange-color"></i></li>';
                                            }

                                        }?>
                                        <li class="ml-1">
                                            <label class="material-tooltip-main card-link orange-color"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="Read reviews">(<?php echo $valutazioni['nValutazioniVenditore'];?>)</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <form id="valutazioneVenditore_<?php echo $j;?>" action="backend/inserisciValutazione_exe.php?verso=venditore<?php echo "&a=" . base64_encode($annuncio['acquirente']) . "&v=" . base64_encode($annuncio['venditore']) . "&dop=" . base64_encode($annuncio['dataOraPubblicazione'])?>" method="post">
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

                <?php $j++; } ?>

            <?php } ?>

        </div>
    </div>

</div>

<?php svuotaNotifiche_sql($cid, isset($_SESSION["codiceFiscale"])?$_SESSION["codiceFiscale"]:"");?>
<?php include_once "common/footer.php";?>
<?php include_once "common/common_script.php";?>

</body>
</html>
