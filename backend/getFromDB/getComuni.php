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

$provincia= mysqli_real_escape_string($cid, $_GET["provincia"]);
$sql = "SELECT DISTINCT comune FROM areageografica WHERE provincia = '$provincia'";

$res = $cid->query($sql);
if ($res == null) {
    $risultato["errore"] = true;
}

$comuni= array();
while($row=$res->fetch_row())
{
    $comuni[] = $row[0];
}
$risultato["contenuto"]=$comuni;


echo json_encode($risultato);
