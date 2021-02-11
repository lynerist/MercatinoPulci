<?php
require_once "common/session.php";
include_once "common/connessioneDB.php";
include_once "common/query.php";

$nNotifiche = nNotificheRichiesteRicevute_sql($cid, isset($_SESSION["codiceFiscale"])?$_SESSION["codiceFiscale"]:"");
$nNotifiche += nNotificheValutazioniSuVenditore_sql($cid, isset($_SESSION["codiceFiscale"])?$_SESSION["codiceFiscale"]:"");
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">
        <img src="img/bee.svg" class="icon-bee" alt="bee"><span>Be</span><span>e-Market</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form id="fromCercaAnnuncio" method="get" action="risultati.php" class="form-inline my-2 my-lg-0 nav-form">
            <label>
                <select id="navRegione" name="regione" class="form-control form-custom white-inputs"></select>
            </label>
            <label>
                <select id="navProvincia" name="provincia" class="form-control form-custom white-inputs"></select>
            </label>
            <div class="nav-newline"></div>
            <input id="testoRicerca" name="testoRicerca" class="form-control form-custom mr-sm-2 white-inputs nav-search" type="search" placeholder="Cerca" aria-label="Search" value="<?php echo isset($_GET['testoRicerca'])?$_GET['testoRicerca']:'';?>">
            <button class="btn btn-outline-success btn-custom my-2 my-sm-0" type="submit">Cerca</button>
        </form>
<?php
        if (isset($_SESSION["isLogged"]) && $_SESSION["isLogged"]){ ?>
        <ul class="navbar-nav mr-auto">

            <?php if ($_SESSION["tipoAccount"] != "venditore"){ ?>
                <li class="nav-item active">
                    <a class="nav-link" href="watched.php">
                        <img src="img/binocolo.svg" class="nav-icon w-bin" alt="Annunci osservati">
                        <p class="nav-icon-text nav-link">Annunci osservati</p>
                    </a>
                </li>
            <?php } ?>
            <li class="nav-item active">
                <a class="nav-link" href="operazioni.php">
                    <img id="iconaOperazioni" src="img/operazioni.svg" class="nav-icon" alt="Operazioni">
                    <p class="nav-icon-text nav-link mr-2">Operazioni</p><?php if ($nNotifiche>0) echo '<span class="badge badge-danger rounded-circle position-absolute">' . $nNotifiche . '</span>'?>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo urlCriptato($_SESSION['codiceFiscale'], '');?>">
                    <img src="img/user-solid.svg" class="nav-icon" alt="Profilo">
                    <p class="nav-icon-text nav-link">Profilo</p>
                </a>
            </li>
        </ul>
        <?php }else{ ?>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="watched.php">
                    <img src="img/binocolo.svg" class="nav-icon" alt="Annunci osservati">
                    <p class="nav-icon-text nav-link">Annunci osservati</p>
                </a>
            </li>
            <li class="nav-item pt-3px">
                <a class="nav-link pt" onclick="accediRegistrati('tabAccedi')">Accedi</a>
            </li>
            <li class="nav-item pt-3px">
                <a class="nav-link pt" onclick="accediRegistrati('tabRegistrati')">Registrati</a>
            </li>
        </ul>
        <?php } ?>
    </div>
    <!-- Modal -->
    <div class="modal fade show" id="modalLoginRegister" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <!-- Pills -->
                    <ul class="nav nav-justified container">
                        <li class="nav-item mr-1">
                            <a id="tabAccedi" class="nav-link border border-warning border-rounded bg-warning text-white" data-toggle="tab"
                               href="#modalLoginRegister-login" role="tab" aria-selected="true">Accedi</a>
                        </li>
                        <li class="nav-item pt-0">
                            <a id="tabRegistrati" class="nav-link border border-warning border-rounded bg-warning text-white" data-toggle="tab"
                               href="#modalLoginRegister-register" role="tab" aria-selected="false">Registrati</a>
                        </li>
                    </ul>
                    <!-- Pills -->

                    <!-- Content -->
                    <div class="tab-content">

                        <!-- First panel -->
                        <div class="tab-pane fade in show active" id="modalLoginRegister-login" role="tabpanel">

                            <!-- Login form -->
                            <form id="formLoginRegister-login" class="container pt-2 needs-validation" method="post" action="backend/login_exe.php" onsubmit="return controllaForm(id)">
                                <div class="md-form md-outline">
                                    <i class="fas fa-envelope prefix"></i>
                                    <input type="email" name="email" id="formLoginRegister-email" class="form-control formLoginRegister-login <?php echo ((isset($_GET['dberr']) and $_GET['dberr'] == 'eml')?'is-invalid':'');?>" placeholder="E-mail" value="<?php echo ((isset($_GET['dberr']) and $_GET['dberr'] == 'pwd')?$_GET['eml']:'');?>" oninput="colora(id,controllaEmail(value))" required>
                                    <label data-error="wrong" data-success="right" class="<?php echo ((isset($_GET['dberr']) and $_GET['dberr'] == 'eml')?'invalid-feedback ml-1':'');?>" for="formLoginRegister-email"><?php echo ((isset($_GET['dberr']) and $_GET['dberr'] == 'eml')?'E-mail sconosciuta':'');?></label>
                                </div>
                                <div class="md-form md-outline">
                                    <i class="fas fa-lock prefix"></i>
                                    <input type="password" name="password" id="formLoginRegister-password" class="form-control formLoginRegister-login <?php echo ((isset($_GET['dberr']) and $_GET['dberr'] == 'pwd')?'is-invalid':'');?>" placeholder="Password" oninput="colora(id, controllaPassword(value))" required>
                                    <label data-error="wrong" class="<?php echo ((isset($_GET['dberr']) and $_GET['dberr'] == 'pwd')?'invalid-feedback ml-1':'');?>" data-success="right" for="formLoginRegister-password"><?php echo ((isset($_GET['dberr']) and $_GET['dberr'] == 'pwd')?'Password errata':'');?></label>
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
                            <form id="formLoginRegister-register" class="container pt-2 needs-validation" action="backend/registrati_exe.php" method="post" onsubmit="return controllaForm(id)">

                                <div class="md-form md-outline">
                                    <i class="fas fa-user prefix"></i>
                                    <input type="text" name="regNome" id="formLoginRegister-name" class="form-control formLoginRegister-register" placeholder="Nome" oninput="colora(id,controllaTestoAnagrafico(value))" value="<?php echo (isset($_GET['nm'])?$_GET['nm']:'');?>" required>
                                    <label data-error="wrong" data-success="right" for="formLoginRegister-name"></label>
                                </div>
                                <div class="md-form md-outline">
                                    <i class="fas fa-user-tie prefix"></i>
                                    <input type="text" name="regCognome" id="formLoginRegister-surname" class="form-control formLoginRegister-register" placeholder="Cognome" oninput="colora(id,controllaTestoAnagrafico(value))" value="<?php echo (isset($_GET['cg'])?$_GET['cg']:'');?>" required>
                                    <label data-error="wrong" data-success="right" for="formLoginRegister-surname"></label>
                                </div>
                                <div class="md-form md-outline">
                                    <i class="fas fa-id-card prefix"></i>
                                    <input type="text" name="regCodiceFiscale" id="formLoginRegister-codiceFiscale" class="form-control formLoginRegister-register <?php echo ((isset($_GET['dberr']) and ($_GET['dberr'] == 'CfE' or $_GET['dberr'] == 'Cf'))?'is-invalid':'');?>" placeholder="Codice Fiscale" oninput="colora(id,controllaCodiceFiscale(value))" value="<?php echo (isset($_GET['Cf'])?$_GET['Cf']:'');?>" required>
                                    <label data-error="wrong" data-success="right" class="<?php echo ((isset($_GET['dberr']) and ($_GET['dberr'] == 'CfE' or $_GET['dberr'] == 'Cf'))?'invalid-feedback ml-1':'');?>" for="formLoginRegister-codiceFiscale"><?php echo ((isset($_GET['dberr']) and ($_GET['dberr'] == 'CfE' or $_GET['dberr'] == 'Cf'))?'codice fiscale già in uso':'');?></label>
                                </div>
                                <div class="md-form md-outline">
                                    <i class="fas fa-map-marked-alt prefix"></i>
                                    <label>
                                        <select name="regRegione" id="register-regione" class="form-control formLoginRegister-register" required>
                                            <option value="" disabled selected hidden>Regione</option>
                                        </select>
                                    </label>
                                    <label>
                                        <select name="regProvincia" id="register-provincia" class="form-control formLoginRegister-register" required>
                                            <option value="" disabled selected hidden>Provincia</option>
                                        </select>
                                    </label>
                                    <label>
                                        <select name="regComune" id="register-comune" class="form-control formLoginRegister-register" required>
                                            <option value="" disabled selected hidden>Comune</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="md-form md-outline">
                                    <i class="fas fa-envelope prefix"></i>
                                    <input type="email" id="emailRegistrazione" name="regEmail" class="form-control formLoginRegister-register <?php echo ((isset($_GET['dberr']) and ($_GET['dberr'] == 'CfE' or $_GET['dberr'] == 'E'))?'is-invalid':'');?>" placeholder="E-mail" oninput="colora(id,controllaEmail(value))" value="<?php echo (isset($_GET['E'])?$_GET['E']:'');?>" required>
                                    <label data-error="wrong" data-success="right" class="<?php echo ((isset($_GET['dberr']) and ($_GET['dberr'] == 'CfE' or $_GET['dberr'] == 'E'))?'invalid-feedback ml-1':'');?>" for="emailRegistrazione"><?php echo ((isset($_GET['dberr']) and ($_GET['dberr'] == 'CfE' or $_GET['dberr'] == 'E'))?'email già in uso':'');?></label>
                                </div>
                                <div class="md-form md-outline">
                                    <i class="fas fa-lock prefix"></i>
                                    <input type="password" id="passwordRegistrazione" name="regPassword" class="form-control formLoginRegister-register" placeholder="Password" oninput="colora(id,controllaPassword(value)); colora('passwordRipetizioneRegistrazione',controllaRipetizionePassword('passwordRipetizioneRegistrazione',value))" required>
                                    <label data-error="wrong" data-success="right" for="passwordRegistrazione"></label>
                                    <div class="invalid-feedback ml-1">Minimo 8 caratteri, almeno un numero, una maiuscola ed una minuscola.</div>
                                </div>
                                <div class="md-form md-outline">
                                    <i class="fas fa-key prefix"></i>
                                    <input type="password" id="passwordRipetizioneRegistrazione" name="regPasswordRipetizione" class="form-control formLoginRegister-register" placeholder="Ripeti Password" oninput="colora(id,controllaRipetizionePassword('passwordRegistrazione',value))" required>
                                    <label data-error="wrong" data-success="right" for="passwordRipetizioneRegistrazione"></label>
                                    <div class="invalid-feedback ml-1">Le due password non corrispondono.</div>
                                </div>
                                <div class="md-form md-outline">
                                    <i class="fas fa-user-tag prefix"></i>
                                    <label>
                                        <select name="regTipoAccount" id="tipoAccount" class="form-control formLoginRegister-register" required>
                                            <option value="" disabled hidden>Tipologia</option>
                                            <option value="acquirente" <?php echo ((isset($_GET['tp']) and $_GET['tp'] == 'acquirente')?'selected':'');?>>Acquirente</option>
                                            <option value="venditore" <?php echo ((isset($_GET['tp']) and $_GET['tp'] == 'venditore')?'selected':'');?>>Venditore</option>
                                            <option value="venditoreAcquirente" <?php echo ((isset($_GET['tp']) and $_GET['tp'] == 'venditoreAcquirente')?'selected':'');?>>Acquirente e venditore</option>
                                        </select>
                                    </label>
                                </div>

                                <div class="form-check mt-4 mb-3 pl-0 text-left d-inline">
                                    <input type="checkbox" class="form-check-input filled-in" id="formLoginRegister-newsletter" name="regNewsletter" <?php echo (isset($_GET['nw'])?"checked":'');?>>
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
</nav>