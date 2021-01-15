<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'mercatinopulci';
$cid = new mysqli($hostname,$username,$password,$db);

if($cid->connect_errno){
    header("location: ../erroreConnessione.php");
    exit;
}



$regione= $_GET["regione"];
$sql = "SELECT provincia, sigla FROM regioni WHERE regione = '$regione'";

$res = $cid->query($sql);
if ($res == null) {
    header("location: ../erroreConnessione.php");
    exit;
}
else
{
    $prov= array();
    while($row=$res->fetch_row())
    {
        $prov[]=array("prov"=>$row[0],"sigla"=>$row[1]);
    }
    $risultato["contenuto"]=$prov;
}

echo json_encode($risultato);
