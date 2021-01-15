<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'mercatinopulci';
$cid = new mysqli($hostname,$username,$password,$db);

if($cid->connect_errno){
    $risultato["errore"] = true;
    echo json_encode($risultato);
    exit;
}

$sql = "SELECT DISTINCT regione FROM areageografica order by regione";

$res = $cid->query($sql);
if ($res == null) {
    $risultato["errore"] = true;
}

$regioni = array();
while ($row = $res->fetch_row()) {
    $regioni[] = $row[0];
}
$risultato["contenuto"] = $regioni;

echo json_encode($risultato);
