<?php
require_once "common/session.php"

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Annunci osservati</title>
    <?php include_once "common/common_header.php" ?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" type="text/css" href="css/watched.css">
</head>

<body>

<?php include_once "common/navbar.php" ?>

<h1 class="title-watched container">Annunci osservati</h1>


<div class="container pb-5 mt-n2 mt-md-n3 drop-shadow altezza-minima">
    <div class="col-md-12 d-flex flex-row row">
        <!-- Item-->
        <div class="justify-content-between my-4 pb-4 border-bottom col-md-6" id="1">
            <div class="media d-block d-sm-flex text-center text-sm-left">
                <a class="cart-item-thumb mx-auto mr-sm-4" href="annuncio.html" target="_blank"><img src="img/lidl.jpeg"
                                                                                                     alt="Product" id="foto1"></a>
                <div class="media-body pt-3">
                    <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo1"><a href="annuncio.html"
                                                                                                      target="_blank">Chitarra Lidl</a></h3>
                    <div class="font-size-sm" id="prodotto1"><span
                            class="text-muted mr-2">Prodotto:</span>Chitarra elettrica</div>
                    <div class="font-size-sm" id="tempoUsura1"><span class="text-muted mr-2"><b>Nuovo</b></span>
                    </div>
                    <div class="font-size-lg text-primary pt-2" id="prezzo1">€100.00</div>
                    <div class="non-osservare">
                        <button type="button" class="btn btn-secondary btn-outline-danger btn-sm" data-dismiss="modal" id="rimuovi1" onclick="rimuovi(id, 'annulla1')">Rimuovi</button>
                        <button type="button" class="btn btn-secondary btn-outline-warning btn-sm" data-dismiss="modal" id="annulla1" onclick="rimuovi(id, 'rimuovi1')">Annulla</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Item-->
        <div class="justify-content-between my-4 pb-4 border-bottom col-md-6" id="2">
            <div class="media d-block d-sm-flex text-center text-sm-left">
                <a class="cart-item-thumb mx-auto mr-sm-4" href="#" target="_blank"><img src="img/image_not_found.png"
                                                                                         alt="Product" id="foto1"></a>
                <div class="media-body pt-3">
                    <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo1"><a href="#"
                                                                                                      target="_blank">Calvin Klein Jeans Keds</a></h3>
                    <div class="font-size-sm" id="prodotto1"><span
                            class="text-muted mr-2">Prodotto:</span>Pantaloni</div>
                    <div class="font-size-sm" id="tempoUsura1"><span class="text-muted mr-2"><b>Nuovo</b></span>
                    </div>
                    <div class="font-size-lg text-primary pt-2" id="prezzo1">€125.00</div>
                    <div class="non-osservare">
                        <button type="button" class="btn btn-secondary btn-outline-danger btn-sm" data-dismiss="modal" id="rimuovi2" onclick="rimuovi(id, 'annulla2')">Rimuovi</button>
                        <button type="button" class="btn btn-secondary btn-outline-warning btn-sm" data-dismiss="modal" id="annulla2" onclick="rimuovi(id, 'rimuovi2')">Annulla</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 d-flex flex-row row">
        <!-- Item-->
        <div class="justify-content-between my-4 pb-4 border-bottom col-md-6" id="3">
            <div class="media d-block d-sm-flex text-center text-sm-left">
                <a class="cart-item-thumb mx-auto mr-sm-4" href="#" target="_blank"><img src="img/annuncio4.jpg"
                                                                                         alt="Product" id="foto1"></a>
                <div class="media-body pt-3">
                    <h3 class="product-card-title font-weight-semibold border-0 pb-0" id="titolo1"><a href="#"
                                                                                                      target="_blank">Ramponi da ghiaccio</a></h3>
                    <div class="font-size-sm" id="prodotto1"><span
                            class="text-muted mr-2">Prodotto:</span>Ramponi</div>
                    <div class="font-size-sm" id="tempoUsura1"><span class="text-muted mr-2"><b>Nuovo</b></span>
                    </div>
                    <div class="font-size-lg text-primary pt-2" id="prezzo1">€80.00</div>
                    <div class="non-osservare">
                        <button type="button" class="btn btn-secondary btn-outline-danger btn-sm" data-dismiss="modal" id="rimuovi3" onclick="rimuovi(id, 'annulla3')">Rimuovi</button>
                        <button type="button" class="btn btn-secondary btn-outline-warning btn-sm" data-dismiss="modal" id="annulla3" onclick="rimuovi(id, 'rimuovi3')">Annulla</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once "common/footer.php" ?>

<?php include_once "common/common_script.php"; ?>

<script src="js/bottoni.js"></script>
</body>

</html>
