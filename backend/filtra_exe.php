<?php
session_start();

$regione = "Tutta Italia";
$provincia = "Ogni provincia";
$testoRicerca = "";
$link = explode('?', $_SERVER['HTTP_REFERER']);
parse_str($link[1]);
if (isset($_GET["regione"])) $regione = $_GET["regione"];
if (isset($_GET["provincia"])) $provincia = $_GET["provincia"];
if (isset($_GET["testoRicerca"])) $testoRicerca = $_GET["testoRicerca"];

$getUrl = 'location: ' . $link[0] . "?regione=" . $regione . "&provincia=" . $provincia . "&testoRicerca=" . $testoRicerca . (isset($_GET["categoria"])?('&sc=' . $_GET["categoria"]):'') . '&p=' . $_GET["prezzo"] . (isset($_GET["condizioni"])?('&c=' . $_GET["condizioni"]):'');
header($getUrl);
