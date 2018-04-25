<?php
include_once("php_includes/giris_kontrol.php")
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/style.css">
    <title>Döviz</title>

</head>
<body>
<?php include_once("ust_kisim.php"); ?>
<button type="button" onclick='getRate()'>Bas buraya</button>
<?php
//This is aPHP(5)script example on how eurofxref-daily.xml can be parsed
//Read eurofxref-daily.xml file in memory
//For the next command you will need the config
//option allow_url_fopen=On (default)
$XML=simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
//the file is updated at around 16:00 CET

foreach($XML->Cube->Cube->Cube as $rate){
    //Output the value of 1EUR for a currency code
    echo '1&euro;='.$rate["rate"].' '.$rate["currency"].'<br/>';
    //--------------------------------------------------
    //Here you can add your code for inserting
    //$rate["rate"] and $rate["currency"] into your database
    //--------------------------------------------------
}
?>
</body>
</html>
