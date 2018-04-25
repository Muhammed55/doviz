<?php
include_once("php_includes/db_conx.php");

$tbl_kullanici = "CREATE TABLE IF NOT EXISTS kullanici (
              kullaniciID INT(11) NOT NULL AUTO_INCREMENT,
              email VARCHAR(255) NOT NULL,
              sifre VARCHAR(255) NOT NULL,
              PRIMARY KEY(kullaniciID)
            )";
$query = mysqli_query($db_conx, $tbl_kullanici);
if($query === TRUE) {
    echo "<h3>kullanici tablo oluşturuldu OK :) </h3>";
} else {
    echo "<h3>kullanici tablo olusturulAMADI:( </h3>";
}

$tbl_paraBirimler = "CREATE TABLE IF NOT EXISTS paraBirimleri (
                paraBirimleriID INT(11) NOT NULL AUTO_INCREMENT,
                paraIsmi VARCHAR(40),
                alisKur DECIMAL(15,6),
                satisKur DECIMAL(15,6),
                PRIMARY KEY(paraBirimleriID)
            )";
$query = mysqli_query($db_conx, $tbl_paraBirimler);
if($query === TRUE) {
    echo "<h3>paraBirimler tablo oluşturuldu OK :) </h3>";
} else {
    echo "<h3>paraBirimler tablo olusturulAMADI:( </h3>";
}

$tbl_cuzdan = "CREATE TABLE IF NOT EXISTS cuzdan (
              kullaniciID INT(11) NOT NULL AUTO_INCREMENT,
              paraBirimleriID INT(11),
              miktar alisKur DECIMAL(15,6),
              PRIMARY KEY(kullaniciID, paraBirimleriID),
              FOREIGN KEY(kullaniciID) REFERENCES kullanici(kullaniciID),
              FOREIGN KEY(paraBirimleriID) REFERENCES paraBirimleri(paraBirimleriID)
            )";
$query = mysqli_query($db_conx, $tbl_cuzdan);
if($query === TRUE) {
    echo "<h3>cuzdan tablo oluşturuldu OK :) </h3>";
} else {
    echo "<h3>cuzdan tablo olusturulAMADI:( </h3>";
}

$tbl_paraTarihi = "CREATE TABLE IF NOT EXISTS paraTarihi (
              paraTarihiID INT(11) NOT NULL AUTO_INCREMENT,
              tarih DATE,
              deger DECIMAL,
              PRIMARY KEY(paraTarihiID)
            )";
$query = mysqli_query($db_conx, $tbl_paraTarihi);
if($query === TRUE) {
    echo "<h3>paraTarihi tablo oluşturuldu OK :) </h3>";
} else {
    echo "<h3>paraTarihi tablo olusturulAMADI:( </h3>";
}

$tbl_paraBirimleriParaTarihi = "CREATE TABLE IF NOT EXISTS paraBirimleriParaTarihi (
              paraBirimleriID INT(11),
              paraTarihiID INT(11),
              PRIMARY KEY(paraBirimleriID, paraTarihiID),
              FOREIGN KEY(paraBirimleriID) REFERENCES paraBirimleri(paraBirimleriID),
              FOREIGN KEY(paraTarihiID) REFERENCES paraTarihi(paraTarihiID)
            )";
$query = mysqli_query($db_conx, $tbl_paraBirimleriParaTarihi);
if($query === TRUE) {
    echo "<h3>paraBirimleriParaTarihi tablo oluşturuldu OK :) </h3>";
} else {
    echo "<h3>paraBirimleriParaTarihi tablo olusturulAMADI:( </h3>";
}
/*
if(mysqli_query($db_conx, "GRANT SUPER ON *.* TO Muhammed@'localhost' IDENTIFIED BY '98lqgj50U4GUxOd2';")){
    echo " privilige";
}
else
    echo "no priviilhe,";

if(mysqli_query($db_conx, "DROP TRIGGER IF EXISTS kurGuncelle"))
    echo "trigger dropped";

if(mysqli_query($db_conx, "DELIMITER //")){
    echo "delimiter degistirildi";
}
else{
    echo "delimiter degistirilemedi";
    printf(mysqli_error($db_conx));
}



$sql = "
            CREATE TRIGGER kurGuncelle BEFORE update ON cuzdan
        FOR EACH ROW
        BEGIN
            DECLARE cmd CHAR(255);
            DECLARE result int(10);
            SET cmd=('/usr/bin/php ', 'C:/xampp/htdocs/doviz/kur_guncelle.php');
            SET RESULT = sys_exec(cmd);
        END //";
$query = mysqli_query($db_conx, $sql);
mysqli_query($db_conx, "DELIMITER ;");
if(mysqli_query($db_conx, "DELIMITER //")){
    echo "delimiter geri";
}
else{
    echo "delimiter geri alınamadı";
    printf(mysqli_error($db_conx));
}

if($query === TRUE){
    echo "<h1>TRIGGER ÇALIŞTI</h1>";
}
else{
    echo "<h1>trigger ccalısmasdı</h1>";
    printf(mysqli_error($db_conx));
}


*/


?>