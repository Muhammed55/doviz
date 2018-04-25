<?php
include_once("php_includes/db_conx.php");
include_once("php_includes/giris_kontrol.php");

$dovizden = $_GET["dovizden"];
$sql = "SELECT paraBirimleriID FROM paraBirimleri WHERE paraIsmi='$dovizden' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_assoc($query);
$dovizdenID = $row['paraBirimleriID'];

$dovize = $_GET["dovize"];
$sql = "SELECT paraBirimleriID FROM paraBirimleri WHERE paraIsmi='$dovize' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_assoc($query);
$dovizeID = $row['paraBirimleriID'];

$sql = "SELECT paraBirimleriID FROM cuzdan WHERE kullaniciID='$log_id' AND (paraBirimleriID='$dovizdenID' OR paraBirimleriID='$dovizeID')";
$query = mysqli_query($db_conx, $sql);
if(mysqli_num_rows($query) < 2)
{
    header("location: /doviz/kullanici.php?e=$log_email");
    exit();
}

$miktar = $_GET["miktar"];

$sql = "SELECT miktar FROM cuzdan WHERE paraBirimleriID='$dovizdenID' AND kullaniciID='$log_id'";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_assoc($query);
$dovizdenEskiMiktar = $row['miktar'];

$eksilmisMiktar = $dovizdenEskiMiktar - $miktar;
if($eksilmisMiktar < 0){
    header("location: /doviz/kullanici.php?e=$log_email");
    exit();
}
$sql = "UPDATE cuzdan SET miktar='$eksilmisMiktar' WHERE paraBirimleriID='$dovizdenID' AND kullaniciID='$log_id'";
$query = mysqli_query($db_conx, $sql);

$sql = "SELECT alisKur FROM paraBirimleri WHERE paraBirimleriID='$dovizdenID' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_assoc($query);
$dovizdenKur = $row['alisKur'];

$sql = "SELECT alisKur FROM paraBirimleri WHERE paraBirimleriID='$dovizeID' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_assoc($query);
$dovizeKur = $row['alisKur'];

$sql = "SELECT miktar FROM cuzdan WHERE paraBirimleriID='$dovizeID' AND kullaniciID='$log_id'";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_assoc($query);
$dovizeEskiMiktar = $row['miktar'];

$bozdurulmusMiktar = ($miktar * $dovizeKur) / $dovizdenKur;
$eklenecekMiktar = $dovizeEskiMiktar + $bozdurulmusMiktar;

$sql = "UPDATE cuzdan SET miktar='$eklenecekMiktar' WHERE paraBirimleriID='$dovizeID' AND kullaniciID='$log_id'";
$query = mysqli_query($db_conx, $sql);
header("location: /doviz/kullanici.php?e=$log_email");
?>