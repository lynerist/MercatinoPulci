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

$regione= mysqli_real_escape_string($cid, $_GET["regione"]);
$sql = "SELECT DISTINCT provincia FROM areageografica WHERE regione = '$regione'";

$res = $cid->query($sql);
if ($res == null) {
    $risultato["errore"] = true;
}

$prov= array();
while($row=$res->fetch_row()){
    $prov[]=$row[0];
}
$risultato["contenuto"]=$prov;


echo json_encode($risultato);
