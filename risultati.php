<?php
require_once "common/session.php";
include_once "common/connessioneDB.php";
include_once "common/query.php";

$risultati = trovaRisultati_sql($cid, $_GET, isset($_SESSION["isLogged"])?$_SESSION["codiceFiscale"]:'', isset($_GET["pagina"])?$_GET["pagina"]:"1");
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
            <form action="backend/filtra_exe.php" method="get" class="myform max-width-100">
                <section class="panel">
                    <header class="card-header">Categoria</header>
                    <div class="card-body">
                        <ul class="nav prod-cat">
                            <li class="row nav-item">
                                <a href="#elettrodomestici" data-toggle="collapse" aria-expanded="true" class="nav-link d-inline">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                                <div class="radiobtn">
                                    <input id="0" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='0')?"checked":"";?> class="" value="0">
                                    <label for="0" class="form-check-label">Elettrodomestici</label>
                                </div>
                                <ul class="subprod-cat collapse" id="elettrodomestici">
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="1" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='1')?"checked":"";?> class="" value="1">
                                            <label for="1" class="form-check-label sottocategoria">Aspirapolvere</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="2" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='2')?"checked":"";?> class="" value="2">
                                            <label for="2" class="form-check-label sottocategoria">Caffettiere</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="3" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='3')?"checked":"";?> class="" value="3">
                                            <label for="3" class="form-check-label sottocategoria">Tostapane</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="4" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='4'?"checked":"");?> class="" value="4">
                                            <label for="4" class="form-check-label sottocategoria">Frullatori</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="5" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='5')?"checked":"";?> class="" value="5">
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
                                    <input id="6" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='6')?"checked":"";?> class="" value="6">
                                    <label for="6" class="form-check-label">Foto e video</label>
                                </div>
                                <ul class="subprod-cat collapse" id="foto-video">
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="7" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='7')?"checked":"";?> class="" value="7">
                                            <label for="7" class="form-check-label sottocategoria">Macchine fotografiche</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="8" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='8')?"checked":"";?> class="" value="8">
                                            <label for="8" class="form-check-label sottocategoria">Accessori</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="9" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='9')?"checked":"";?> class="" value="9">
                                            <label for="9" class="form-check-label sottocategoria">Telecamere</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="10" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='10')?"checked":"";?> class="" value="10">
                                            <label for="10" class="form-check-label sottocategoria">Microfoni</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="11" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='11')?"checked":"";?> class="" value="11">
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
                                    <input id="12" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='12')?"checked":"";?> class="" value="12">
                                    <label for="12" class="form-check-label">Abbigliamento</label>
                                </div>
                                <ul class="subprod-cat collapse" id="abbigliamento">
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="13" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='13')?"checked":"";?> class="" value="13">
                                            <label for="13" class="form-check-label sottocategoria">Vestiti</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="14" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='14')?"checked":"";?> class="" value="14">
                                            <label for="14" class="form-check-label sottocategoria">Borse</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="15" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='15')?"checked":"";?> class="" value="15">
                                            <label for="15" class="form-check-label sottocategoria">Scarpe</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="16" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='16')?"checked":"";?> class="" value="16">
                                            <label for="16" class="form-check-label sottocategoria">Accessori</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="17" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='17')?"checked":"";?> class="" value="17">
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
                                    <input id="18" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='18')?"checked":"";?> class="" value="18">
                                    <label for="18" class="form-check-label">Hobby</label>
                                </div>
                                <ul class="subprod-cat collapse" id="hobby">
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="19" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='19')?"checked":"";?> class="" value="19">
                                            <label for="19" class="form-check-label sottocategoria">Giocattoli</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="20" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='20')?"checked":"";?> class="" value="20">
                                            <label for="20" class="form-check-label sottocategoria">Film e DVD</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="21" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='21')?"checked":"";?> class="" value="21">
                                            <label for="21" class="form-check-label sottocategoria">Musica</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="22" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='22')?"checked":"";?> class="" value="22">
                                            <label for="22" class="form-check-label sottocategoria">Libri e riviste</label>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="radiobtn">
                                            <input id="23" name="categoria" type="radio" <?php echo (isset($_GET["sc"]) and $_GET["sc"]=='23')?"checked":"";?> class="" value="23">
                                            <label for="23" class="form-check-label sottocategoria">Altro</label>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </section>
                <section class="panel">
                    <header class="card-header">Prezzo massimo</header>
                    <!-- Section: Price version 2 -->
                    <section class="mb-4">
                        <div class="d-flex justify-content-center my-4">
                            <div class="w-75">
                                <label><input type="range" class="custom-range table-warning" id="customRange11" name="prezzo" min="0" max="1000" value="<?php echo (isset($_GET['p'])?$_GET['p']:'1000');?>"></label>
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
                                <select name="condizioni" class="form-control form-custom hasCustomSelects">
                                    <option value="0" <?php echo (isset($_GET["c"]) and $_GET["c"]=='0')?"selected":"";?>>Qualsiasi</option>
                                    <option value="1" <?php echo (isset($_GET["c"]) and $_GET["c"]=='1')?"selected":"";?>>Nuovo</option>
                                    <option value="2" <?php echo (isset($_GET["c"]) and $_GET["c"]=='2')?"selected":"";?>>Come nuovo</option>
                                    <option value="3" <?php echo (isset($_GET["c"]) and $_GET["c"]=='3')?"selected":"";?>>Buono</option>
                                    <option value="4" <?php echo (isset($_GET["c"]) and $_GET["c"]=='4')?"selected":"";?>>Medio</option>
                                    <option value="5" <?php echo (isset($_GET["c"]) and $_GET["c"]=='5')?"selected":"";?>>Usurato</option>
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
                <div class="card-body pb-0">
                    <nav class="pagination-wrapper pagination-box d-flex justify-content-between" aria-label="Esempio di navigazione con jump to page">
                        <?php
                        $maxPagina = intval((nRisultati_sql($cid, $_GET, isset($_SESSION["isLogged"])?$_SESSION["codiceFiscale"]:'')-1)/9)+1;
                        $link = "risultati.php?";
                        foreach ($_GET as $key => $value) {
                            if ($key == "pagina") continue;
                            $link .= $key . "=" . $value . "&";
                        }
                        ?>
                        <ul class="pagination">
                            <li class="page-item <?php echo (!isset($_GET["pagina"]) or $_GET["pagina"] == 1)?"disabled":"";?>">
                                <a class="page-link" href="<?php echo $link . 'pagina=1';?>">
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                            </li>
                            <li class="page-item <?php echo (!isset($_GET["pagina"]) or $_GET["pagina"] == 1)?'disabled':'';?>">
                                <a class="page-link" href="<?php echo $link . 'pagina=' . ((isset($_GET["pagina"]) and $_GET["pagina"] > 1)?$_GET["pagina"]-1:"1");?>">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item active">
                                <button class="page-link" aria-current="page"><?php echo isset($_GET["pagina"])?$_GET["pagina"]:"1";?></button>
                            </li>
                            <li class="page-item <?php echo (isset($_GET["pagina"]) and $_GET["pagina"] == $maxPagina or $maxPagina == 1)?'disabled':'';?>">
                                <a class="page-link" href="<?php echo $link . 'pagina=' . (isset($_GET["pagina"])?($_GET["pagina"] < $maxPagina?$_GET["pagina"]+1:$maxPagina):"2");?>">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                            <li class="page-item <?php echo (isset($_GET["pagina"]) and $_GET["pagina"] == $maxPagina or $maxPagina == 1)?'disabled':'';?>">
                                <a class="page-link" href="<?php echo $link . 'pagina=' . $maxPagina;?>">
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="form-group page-box">
                            <label for="jumpToPage">
                                <input type="text" class="form-control restringi" id="jumpToPage" placeholder="/<?php echo $maxPagina;?>" maxlength="2" onchange="header('<?php echo $link;?>', value, '<?php echo $maxPagina;?>')">
                            </label>
                        </div>
                    </nav>
                </div>
            </section>
            <div class="row product-list">
                <?php
                if ($risultati->num_rows==0){
                    echo '<div class="alert alert-warning text-center p-lg-5 m-auto" role="alert">
                                <h2 class="container">Nessun risultato</h2>
                          </div>';
                }
                $i = 0;
                while ($annuncio = $risultati -> fetch_assoc()){
                    if ($annuncio["statoAnnuncio"] == "inVendita") {
                        $annuncio["scadenza"] = calcolaScadenza($cid, $annuncio["dataOraPubblicazione"], $annuncio["venditore"], $annuncio["tempoUsura"]);
                        if ($annuncio["scadenza"] < 1) continue;
                    }
                    $annuncio["isWatched"] = isWatched($cid, $annuncio["dataOraPubblicazione"], $annuncio["venditore"], isset($_SESSION["isLogged"])?$_SESSION["codiceFiscale"]:"", isset($_COOKIE["annunciOsservati"])?$_COOKIE["annunciOsservati"]:"");
                    ?>
                    <div class="col-lg-4">
                        <section class="panel">
                            <div class="pro-img-box">
                                <a href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']);?>" target="_blank">
                                    <img src="fotoAnnuncio/<?php inserisciFoto($annuncio['fotoAnnuncio']);?>" alt="" class="altezza-massima">
                                </a>
                                <?php
                                if ((!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] != "venditore" and $_SESSION["codiceFiscale"] != $annuncio["venditore"]) and !$annuncio["isWatched"]) {

                                    echo '<a href="#0" class="adtocart" id="binocolo' . $i . '" onclick="checked(id); osservaAnnuncioAjax(\'' . base64_encode($annuncio["dataOraPubblicazione"]) . '\', \'' . base64_encode($annuncio["venditore"]) . '\')">
                                        <img class="obs-icon" src="img/binocolo.svg" alt="">
                                        <img class="obs-icon" src="img/check.svg" alt="">
                                    </a>';

                                } elseif (!isset($_SESSION["tipoAccount"]) or $_SESSION["tipoAccount"] != "venditore"){

                                    echo '<a href="#0" class="adtocart"' . $i . '">
                                        <img class="obs-icon-clicked" src="img/check.svg" alt="">
                                    </a>';

                                }
                                ?>
                            </div>
                            <div class="card-body text-center">
                                <h4><a href="<?php echo urlCriptato($annuncio['venditore'], $annuncio['dataOraPubblicazione']); ?>" class="pro-title" target="_blank"><?php echo $annuncio["titolo"] ?></a></h4>
                                <p class="price">€<?php echo $annuncio["prezzo"] ?></p>
                                <b><?php echo array("Nuovo", "Usato")[$annuncio["tempoUsura"] > 0] ?></b>
                                <i><?php echo $annuncio["provincia"] . ", " . $annuncio["regione"];?></i>
                            </div>
                        </section>
                    </div>
                <?php $i++; } ?>
            </div>
        </div>
    </div>
</div>

<?php include_once "common/footer.php";?>
<?php include_once "common/common_script.php";?>

<script src="js/risultati.js"></script>
</body>
</html>