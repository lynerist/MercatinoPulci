<?php
require_once "common/session.php";
include_once "common/connessioneDB.php";
include_once "common/query.php";

$utente["codiceFiscale"] = base64_decode($_GET["cf"], true);
if (!$utente['codiceFiscale']){
    header("location: 404.php");
}

$utente = trovaUtente_sql($cid, $utente["codiceFiscale"]);

$valutazioni = valutazioni_sql($cid, $utente["codiceFiscale"]);
$utente["punteggioAcquirente"] = arrotondaValutazione($valutazioni["mediaAcquirente"]);
$utente["nRecensioniAcquirente"] = $valutazioni["nValutazioniAcquirente"];
$utente["punteggioVenditore"] = arrotondaValutazione($valutazioni["mediaVenditore"]);
$utente["nRecensioniVenditore"] = $valutazioni["nValutazioniVenditore"];

$utente["nAnnunciAcquistati"] = nAnnunciAcquistati_sql($cid, $utente["codiceFiscale"]);
$utente["nAnnunciVenduti"] = nAnnunciVenduti_sql($cid, $utente["codiceFiscale"]);

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <title>
        <?php
        if (isset($_SESSION["codiceFiscale"]) and $_SESSION["codiceFiscale"] == $utente["codiceFiscale"]){
            echo 'Il mio profilo';
        }else{
            echo $utente["nome"] . " " . $utente["cognome"];
        }
        ?>
    </title>
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
                <img src="fotoProfilo/<?php inserisciFoto($utente['fotoProfilo']);?>" alt=""/>
            </div>
        </div>
        <div class="col-md-8">
            <div class="profile-head mt-2">
                <h5>
                    <?php
                    echo $utente["nome"] . " " . $utente["cognome"]
                    ?>
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
                                    <form id="modificaProfilo" action="backend/modificaProfilo_exe.php" method="post" enctype="multipart/form-data" onsubmit="return controllaForm(id)">
                                        <div class="modal-header arancio">
                                            <h5 class="modal-title" id="exampleModalLabel">Modifica profilo</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container rounded bg-white mt-5">
                                                <div class="row">
                                                    <div class="col-md-4 border-right">
                                                        <div class="profile-img">
                                                            <img id="fotoInput" src="fotoProfilo/<?php inserisciFoto($utente['fotoProfilo']);?>" alt=""/>
                                                            <div class="file btn btn-lg x btn-primary mt-0">
                                                                Cambia foto
                                                                <input type="file" name="foto" class="w-100 h-100" onchange="loadFile(event)"  accept="image/png, image/jpeg, image/jpg"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="p-3 py-5 no-padding-top form-width">
                                                            <div class="row mt-2">
                                                                <div class="col-md-6"><label><input id="modificaCodiceFiscale" name="modificaCodiceFiscale" type="text" class="form-control form-custom" placeholder="Codice fiscale" value="<?php echo $utente['codiceFiscale'] ?>" readonly></label></div>
                                                                <div class="col-md-6"><label><input id="modificaEmail" name="modificaEmail" type="email" class="form-control form-custom modificaProfilo <?php echo (isset($_GET["Merr"]) and strpos($_GET["Merr"], "E") !== false)?"is-invalid":"";?>" placeholder="E-mail" value="<?php echo $utente['email'] ?>" oninput="colora(id, controllaEmail(value))" required></label></div>
                                                                <label for="modificaEmail" class="<?php echo (isset($_GET["Merr"]) and strpos($_GET["Merr"], "E") !== false)?"invalid-feedback":"";?>"><?php echo (isset($_GET["Merr"]) and strpos($_GET["Merr"], "E") !== false)?"email già in uso":"";?></label>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6"><label><input id="modificaNome" name="modificaNome" type="text" class="form-control form-custom modificaProfilo" placeholder="Nome" value="<?php echo (isset($_GET["Mnm"]))?$_GET["Mnm"]:$utente["nome"];?>" oninput="colora(id, controllaTestoAnagrafico(value))" required></label></div>
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <select name="modificaRegione" id="modificaRegione" class="form-control modificaProfilo" required></select>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6"><label><input id="modificaCognome" name="modificaCognome" type="text" class="form-control form-custom modificaProfilo" placeholder="Cognome" value="<?php echo (isset($_GET["Mcg"]))?$_GET["Mcg"]:$utente["cognome"];?>" oninput="colora(id, controllaTestoAnagrafico(value))" required></label></div>
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <select name="modificaProvincia" id="modificaProvincia" class="form-control modificaProfilo" required></select>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <select name="modificaTipoAccount" id="modificaTipoAccount" class="form-control modificaProfilo <?php echo (isset($_GET["Merr"]) and $_GET["Merr"] == "TA")?"is-invalid":"";?>" onchange="this.classList.remove('is-invalid');" required>
                                                                            <option value="acquirente"<?php echo ((isset($_GET["Mtp"]))?$_GET["Mtp"]:$utente["tipoAccount"])=="acquirente"?"selected":"";?>>Acquirente</option>
                                                                            <option value="venditore"<?php echo ((isset($_GET["Mtp"]))?$_GET["Mtp"]:$utente["tipoAccount"])=="venditore"?"selected":"";?>>Venditore</option>
                                                                            <option value="venditoreAcquirente"<?php echo ((isset($_GET["Mtp"]))?$_GET["Mtp"]:$utente["tipoAccount"])=="venditoreAcquirente"?"selected":"";?>>Acquirente e venditore</option>
                                                                        </select>
                                                                        <label for="modificaTipoAccount" class="<?php echo (isset($_GET["Merr"]) and $_GET["Merr"] == "TA")?"invalid-feedback":"";?>"><?php echo (isset($_GET["Merr"]) and $_GET["Merr"] == "TA")?"Hai richieste di acquisto attive, perciò non puoi smettere di essere acquirente.":"";?></label>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <select name="modificaComune" id="modificaComune" class="form-control modificaProfilo" required></select>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="mb-2">
                                                                <b>Cambia Password</b>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <label>
                                                                        <input id="nuovaPassword" name="nuovaPassword" class="form-control form-custom modificaProfilo" type="password" placeholder="Nuova Password" oninput="colora(id, controllaPassword(value) || value === ''); colora('ripetiNuovaPassword',controllaRipetizionePassword('ripetiNuovaPassword',value))" autocomplete="off" readonly
                                                                               onfocus="this.removeAttribute('readonly');">
                                                                    </label>
                                                                    <div class="invalid-feedback ml-1">Minimo 8 caratteri, almeno un numero ed una maiuscola.</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input id="ripetiNuovaPassword" name="ripetiNuovaPassword" class="form-control form-custom modificaProfilo <?php echo (isset($_GET["Merr"]) and strpos($_GET["Merr"], "Np") !== false)?"is-invalid":"";?>" type="password" placeholder="Ripeti Password" oninput="colora(id,controllaRipetizionePassword('nuovaPassword',value))" autocomplete="off" readonly
                                                                           onfocus="this.removeAttribute('readonly');">
                                                                    <label for="ripetiNuovaPassword" class="<?php echo (isset($_GET["Merr"]) and strpos($_GET["Merr"], "Np") !== false)?"invalid-feedback":"";?>"></label>
                                                                    <div class="invalid-feedback ml-1">Le due password non corrispondono.</div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-2 mt-5">
                                                                <b>Password Corrente</b>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="w-100">
                                                                    <label>
                                                                        <input id="passwordCorrente" name="passwordCorrente" class="form-control form-custom <?php echo (isset($_GET["Merr"]) and strpos($_GET["Merr"], "P") !== false)?"is-invalid":"";?>" type="password" placeholder="Password corrente" oninput="colora(id, controllaPassword(value))" autocomplete="off" required>
                                                                        <label for="passwordCorrente" class="<?php echo (isset($_GET["Merr"]) and strpos($_GET["Merr"], "P") !== false)?"invalid-feedback":"";?>"><?php echo (isset($_GET["Merr"]) and $_GET["Merr"] == "P")?"Password errata":"";?></label>
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
                                    <form id="eliminaProfilo" action="backend/eliminaProfilo_exe.php" method="post" onsubmit="return controllaForm(id)">
                                        <div class="modal-body">
                                            <h5 class="text-danger">Per creare un nuovo account dovrai contattare un amministratore di sistema.</h5>
                                            <input id="passwordEliminaProfilo" name="passwordEliminaProfilo" class="form-control form-custom eliminaProfilo <?php echo (isset($_GET['Mep'])?'is-invalid':'');?>" type="password" placeholder="Immetti la tua password" oninput="colora(id, controllaPassword(value))" required>
                                            <label for="passwordEliminaProfilo" class="<?php echo (isset($_GET['Mep'])?'invalid-feedback':'');?>"><?php echo (isset($_GET['Mep'])?'Password errata':'');?></label>
                                        </div>
                                        <div class="modal-footer">
                                            <button data-dismiss="modal" class="btn btn-outline-warning">Annulla</button>
                                            <button type="submit" class="btn btn-danger">Conferma</button>
                                        </div>
                                    </form>
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
                            <label class="material-tooltip-main card-link orange-color" data-toggle="tooltip" data-placement="top" title="Read reviews">
                                (<?php echo $utente["nRecensioniAcquirente"] ?> recensioni)
                            </label>
                        </li>
                    </ul>
                <?php } ?>

                <?php
                if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <p class="profile-rating">PUNTEGGIO VENDITORE:</p>
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
                            <label class="material-tooltip-main card-link orange-color" data-toggle="tooltip" data-placement="top" title="Read reviews">
                                (<?php echo $utente["nRecensioniVenditore"] ?> recensioni)
                            </label>
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

                    <?php
                    if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#annunciInVendita" role="tab" aria-controls="annunciInVendita" aria-selected="false">Annunci in vendita</a>
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
                <p> <?php echo $utente["email"] ?> </p>
                <p> <?php echo $utente["comune"] ?> </p>
                <p> <?php echo $utente["provincia"] . ", " . $utente["regione"] ?> </p>
                <p class="profile-title">STATISTICHE</p>

                <?php
                if ($utente["tipoAccount"] == "acquirente" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                <p>Annunci acquistati: <?php echo $utente["nAnnunciAcquistati"] ?></p>
                <?php } ?>

                <?php
                if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <p>Annunci venduti: <?php echo $utente["nAnnunciVenduti"] ?></p>
                <?php } ?>

                <?php
                if (isset($_SESSION["isLogged"]) and $_SESSION["codiceFiscale"] == $utente["codiceFiscale"]){ ?>
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
                    <div id="annunciAcquistati" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab"></div>
                <?php } ?>

                <?php
                if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <div id="annunciVenduti" class="tab-pane fade <?php if ($utente["tipoAccount"] == "venditore") echo "show active" ?>" role="tabpanel" aria-labelledby="profile-tab"></div>
                <?php } ?>

                <?php
                if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <div id="annunciInVendita" class="tab-pane fade" role="tabpanel" aria-labelledby="profile-tab"></div>
                <?php } ?>

            </div>
        </div>
        <div class="col-md-4 hidden-block">
            <div class="profile-work">
                <p class="profile-title">DATI PERSONALI</p>
                <p> <?php echo $utente["email"] ?> </p>
                <p> <?php echo $utente["comune"] ?> </p>
                <p> <?php echo $utente["provincia"] . ", " . $utente["regione"] ?> </p>
                <p class="profile-title">STATISTICHE</p>

                <?php
                if ($utente["tipoAccount"] == "acquirente" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <p>Annunci acquistati: <?php echo $utente["nAnnunciAcquistati"] ?></p>
                <?php } ?>

                <?php
                if ($utente["tipoAccount"] == "venditore" or $utente["tipoAccount"] == "venditoreAcquirente"){ ?>
                    <p>Annunci venduti: <?php echo $utente["nAnnunciVenduti"] ?></p>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<?php include_once "common/footer.php";?>
<?php include_once "common/common_script.php";?>

<script src="js/modal.js"></script>
<script src="js/profilo.js"></script>
<script>
    <?php if (isset($_SESSION["codiceFiscale"]) and $_SESSION["codiceFiscale"] == $utente["codiceFiscale"]){ ?>
    window.addEventListener('DOMContentLoaded', function () {
        popolaRegioni('modificaRegione', 'modificaProvincia', 'modificaComune', '<?php echo (isset($_GET["Mrg"]))?$_GET["Mrg"]:mysqli_real_escape_string($cid, $utente["regione"]);?>', '<?php echo (isset($_GET["Mpr"]))?$_GET["Mpr"]:mysqli_real_escape_string($cid, $utente["provincia"]);?>', '<?php echo (isset($_GET["Mcm"]))?$_GET["Mcm"]:mysqli_real_escape_string($cid, $utente["comune"]);?>')
    });
    document.getElementById('modificaRegione').addEventListener('change', function () {
        popolaProvince('modificaRegione', 'modificaProvincia', 'modificaComune')
    });
    document.getElementById('modificaProvincia').addEventListener('change', function () {
        popolaComuni('modificaProvincia', 'modificaComune')
    });
    <?php } ?>

    popolaAnnunciAcquistati('<?php echo base64_encode($utente["codiceFiscale"]);?>', 0);
    popolaAnnunciVenduti('<?php echo base64_encode($utente["codiceFiscale"]);?>', 0);
    popolaAnnunciInVendita('<?php echo base64_encode($utente["codiceFiscale"]);?>', 0);

    <?php echo (isset($_GET['Merr'])?'$("#basicExampleModal").modal()':'');?>
    <?php echo (isset($_GET['Mep'])?'$("#modalEliminaProfilo").modal()':'');?>
</script>
</body>
</html>