<?php
require_once "../common/session.php";
include_once "../common/connessioneDB.php";
include_once "../common/query.php";

$email = mysqli_real_escape_string($cid, $_POST["email"]);
$password = md5($_POST["password"]);

$res = login_sql($cid, $email);
$utente = $res -> fetch_assoc();
if ($res->num_rows==0 || $res->num_rows>1){
    header("location: " . $_SERVER["HTTP_REFERER"] . (parse_url($_SERVER["HTTP_REFERER"], PHP_URL_QUERY) ? '&' : '?') . "dberr=eml");
}elseif ($utente["password"] != $password){
    header("location: " . $_SERVER["HTTP_REFERER"] . (parse_url($_SERVER["HTTP_REFERER"], PHP_URL_QUERY) ? '&' : '?') . "dberr=pwd&eml=" . $email);
}else{
    $_SESSION["isLogged"] = true;
    $_SESSION["codiceFiscale"] = $utente["codiceFiscale"];
    $_SESSION["tipoAccount"] = $utente["tipoAccount"];
    $_SESSION["nome"] = $utente["nome"];
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
