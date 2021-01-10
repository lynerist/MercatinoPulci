<!--TODO variabile di sessione RESIDENZA per annunci con visibilità ristretta-->
<?php
session_start();
include_once "../common/connessioneDB.php";

$email = mysqli_real_escape_string($cid, $_POST["email"]);
$password = md5($_POST["password"]);

$login = "SELECT codiceFiscale, nome, tipoAccount FROM utente WHERE email = '$email' AND password = '$password';";
$res = $cid -> query($login);
print $login;
print $cid -> error;

$utente = $res -> fetch_assoc();

if (!is_null($utente["codiceFiscale"])){
    $_SESSION["isLogged"] = true;
    $_SESSION["codiceFiscale"] = $utente["codiceFiscale"];
    $_SESSION["tipoAccount"] = $utente["tipoAccount"];
    $_SESSION["nome"] = $utente["nome"];
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}else{
    echo "é andata male";
}