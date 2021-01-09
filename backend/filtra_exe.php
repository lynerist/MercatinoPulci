<?php
session_start();
$getUrl = 'location: ' . $_SERVER["HTTP_REFERER"] . (isset($_GET["categoria"])?('&sc=' . $_GET["categoria"]):'') . '&p=' . $_GET["prezzo"] . (isset($_GET["condizioni"])?('&c=' . $_GET["condizioni"]):'');
header($getUrl);