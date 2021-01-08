<!--TODO variabile di sessione RESIDENZA per annunci con visibilità ristretta-->
<?php
session_start();
if (true){
    $_SESSION["isLogged"] = true;
    $_SESSION["codiceFiscale"] = 'SLNFPP98S28F205V';
    $_SESSION["tipoAccount"] = 'venditoreAcquirente';
    $_SESSION["nome"] = 'Filippo';
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}