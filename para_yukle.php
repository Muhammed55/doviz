<?php
include_once("php_includes/db_conx.php");
include_once("php_includes/giris_kontrol.php");

$sql = "SELECT paraBirimleriID FROM paraBirimleri WHERE paraIsmi='TRY' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_assoc($query);
$paraBirimiID = $row['paraBirimleriID'];
$sql = "SELECT miktar FROM cuzdan WHERE parabirimleriID='$paraBirimiID' AND kullaniciID='$log_id'";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_assoc($query);
$yuklenecekMiktar = $_GET["yuklenecekMiktar"] + $row['miktar'];

$sql = "UPDATE cuzdan SET miktar=$yuklenecekMiktar WHERE paraBirimleriID='$paraBirimiID' AND kullaniciID='$log_id'";
$query = mysqli_query($db_conx, $sql);
header("location: /doviz/kullanici.php?e=$log_email");
?>