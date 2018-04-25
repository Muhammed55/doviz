<?php
include_once("php_includes/db_conx.php");
$XML=simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
//the file is updated at around 16:00 CET

foreach($XML->Cube->Cube->Cube as $rate){
    $isim = $rate["currency"];
    $alisKur = $rate["rate"];
    $satisKur = (double)$rate["rate"] + 0.02;
    $tbl_paraBirimler_doldur = "UPDATE paraBirimleri SET alisKur=$alisKur, satisKur='$satisKur' WHERE paraIsmi='$isim'";
    if($query = mysqli_query($db_conx, $tbl_paraBirimler_doldur) == TRUE){
        echo "<h3> GÜNCELLENDİ </h3>";
    }
    else{
        echo "<h3> GÜNCELLENEMEDI :( </h3>";
        printf(mysqli_error($db_conx));
    }
    //--------------------------------------------------
}
?>