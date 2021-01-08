<?php
require_once "common/session.php"

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Risultati</title>
    <?php include_once "common/common_header.php";?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet" type="text/css" href="css/risultati.css">
</head>
<body>

<?php include_once "common/navbar.php";?>

<div class="container list-container col-lg-10 pt-3">
    <div class="row">
        <div class="col-lg-3">
            <form action="" class="myform max-width-100">
                <section class="panel">
                    <header class="card-header">Category</header>
                    <div class="card-body">
                        <ul class="nav prod-cat">
                            <li class="row nav-item">
                                <a href="#elettrodomestici" data-toggle="collapse" aria-expanded="true" class="nav-link d-inline">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                                <div class="radiobtn">
                                    <input id="0" name="categoria" type="radio" class="" value="0">
                                    <label for="0" class="form-check-label">Elettrodomestici</label>
                                </div>
                                <ul class="subprod-cat collapse" id="elettrodomestici">
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="1" name="categoria" type="radio" class="" value="1">
                                            <label for="1" class="form-check-label sottocategoria">Aspirapolvere</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="2" name="categoria" type="radio" class="" value="2">
                                            <label for="2" class="form-check-label sottocategoria">Caffettiere</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="3" name="categoria" type="radio" class="" value="3">
                                            <label for="3" class="form-check-label sottocategoria">Tostapane</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="4" name="categoria" type="radio" class="" value="4">
                                            <label for="4" class="form-check-label sottocategoria">Frullatori</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="5" name="categoria" type="radio" class="" value="5">
                                            <label for="5" class="form-check-label sottocategoria">Altro</label>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="row nav-item">
                                <a href="#foto-video" data-toggle="collapse" aria-expanded="true" class="nav-link d-inline">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                                <div class="radiobtn">
                                    <input id="6" name="categoria" type="radio" class="" value="6">
                                    <label for="6" class="form-check-label">Foto e video</label>
                                </div>
                                <ul class="subprod-cat collapse" id="foto-video">
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="7" name="categoria" type="radio" class="" value="7">
                                            <label for="7" class="form-check-label sottocategoria">Macchine fotografiche</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="8" name="categoria" type="radio" class="" value="8">
                                            <label for="8" class="form-check-label sottocategoria">Accessori</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="9" name="categoria" type="radio" class="" value="9">
                                            <label for="9" class="form-check-label sottocategoria">Telecamere</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="10" name="categoria" type="radio" class="" value="10">
                                            <label for="10" class="form-check-label sottocategoria">Microfoni</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="11" name="categoria" type="radio" class="" value="11">
                                            <label for="11" class="form-check-label sottocategoria">Altro</label>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="row nav-item">
                                <a href="#abbigliamento" data-toggle="collapse" aria-expanded="true" class="nav-link d-inline">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                                <div class="radiobtn">
                                    <input id="12" name="categoria" type="radio" class="" value="12">
                                    <label for="12" class="form-check-label">Abbigliamento</label>
                                </div>
                                <ul class="subprod-cat collapse" id="abbigliamento">
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="13" name="categoria" type="radio" class="" value="13">
                                            <label for="13" class="form-check-label sottocategoria">Vestiti</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="14" name="categoria" type="radio" class="" value="14">
                                            <label for="14" class="form-check-label sottocategoria">Borse</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="15" name="categoria" type="radio" class="" value="15">
                                            <label for="15" class="form-check-label sottocategoria">Scarpe</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="16" name="categoria" type="radio" class="" value="16">
                                            <label for="16" class="form-check-label sottocategoria">Accessori</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="17" name="categoria" type="radio" class="" value="17">
                                            <label for="17" class="form-check-label sottocategoria">Altro</label>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="row nav-item">
                                <a href="#hobby" data-toggle="collapse" aria-expanded="true" class="nav-link d-inline">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                                <div class="radiobtn">
                                    <input id="18" name="categoria" type="radio" class="" value="18">
                                    <label for="18" class="form-check-label">Hobby</label>
                                </div>
                                <ul class="subprod-cat collapse" id="hobby">
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="19" name="categoria" type="radio" class="" value="19">
                                            <label for="19" class="form-check-label sottocategoria">Giocattoli</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="20" name="categoria" type="radio" class="" value="20">
                                            <label for="20" class="form-check-label sottocategoria">Film e DVD</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="21" name="categoria" type="radio" class="" value="21">
                                            <label for="21" class="form-check-label sottocategoria">Musica</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="22" name="categoria" type="radio" class="" value="22">
                                            <label for="22" class="form-check-label sottocategoria">Libri e riviste</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="23" name="categoria" type="radio" class="" value="23">
                                            <label for="23" class="form-check-label sottocategoria">Altro</label>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </section>
                <section class="panel">
                    <header class="card-header">Logarithmic Price Range</header>
                    <!-- Section: Price version 2 -->
                    <section class="mb-4">
                        <h6 class="font-weight-bold mb-3 mt-2">Price</h6>
                        <div class="d-flex justify-content-center my-4">
                            <div class="w-75">
                                <label><input type="range" class="custom-range table-warning" id="customRange11" min="0" max="1000"></label>
                            </div>
                            <span class="font-weight-bold price-color ml-2 valueSpan2" id="custom-span"></span>
                        </div>
                    </section>
                </section>
                <section class="panel">
                    <header class="card-header">Condizione</header>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="w-100">
                                <select class="form-control form-custom hasCustomSelects">
                                    <option value="0">Qualsiasi</option>
                                    <option value="1">Nuovo</option>
                                    <option value="2">Come nuovo</option>
                                    <option value="3">Buono</option>
                                    <option value="4">Medio</option>
                                    <option value="5">Usurato</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </section>
                <section class="panel p-3">
                    <button class="btn btn-outline-warning" type="submit">Filtra</button>
                </section>
            </form>
        </div>
        <div class="col-lg-9">
            <section class="panel two">
                <div class="card-body pb-5">
                    <nav aria-label="Page navigation example" class="float-right">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#0" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#0">1</a></li>
                            <li class="page-item active">
                                <a class="page-link" href="#0">2 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#0">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#0">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </section>
            <div class="row product-list">
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <a href="annuncio.php?dop=MjAyMS0wMS0wMSAwMDowMDowMA==&v=U0xORlBQOThTMjhGMjA1Vg==" target="_blank"><img src="img/lidl.jpeg" alt="" class="altezza-massima"></a>

                            <?php if (!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] != "venditore") { ?>
                                <a href="#0" class="adtocart" id="a0" onclick="checked(id)">
                                    <img class="obs-icon" src="img/binocolo.svg" alt="">
                                    <img class="obs-icon" src="img/check.svg" alt="">
                                </a>
                            <?php } ?>

                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Chitarra Lidl</a></h4>
                            <p class="price">€100.00</p>
                            <b>Nuovo</b>
                            <i>Brescia, Lombardia</i>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <a href="annuncio.html"><img src="img/image_not_found.png" alt="" class="altezza-massima"></a>
                            <a href="#0" class="adtocart" id="a1" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="annuncio.html" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                            <i>Milano, Lombardia</i>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <a href="annuncio.html"><img src="img/annuncio5.jpg" alt="" class="altezza-massima"></a>
                            <a href="#0" class="adtocart" id="a2" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="annuncio.html" class="pro-title">Marranzano antico</a></h4>
                            <p class="price">€50.00</p>
                            <b>Usato</b>
                            <i>Casatenovo, Lecco</i>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a3" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="annuncio.html" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a4" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a5" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Nuovo</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a6" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a7" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a8" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a9" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a10" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a11" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a12" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a13" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="img/image_not_found.png" alt="" class="altezza-massima">
                            <a href="#0" class="adtocart" id="a14" onclick="checked(id)">
                                <img class="obs-icon" src="img/binocolo.svg" alt="">
                                <img class="obs-icon" src="img/check.svg" alt="">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h4><a href="#0" class="pro-title">Leopard Shirt Dress</a></h4>
                            <p class="price">€300.00</p>
                            <b>Usato</b>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "common/footer.php";?>

<?php include_once "common/common_script.php";?>

<script src="js/risultati.js"></script>
</body>
</html>