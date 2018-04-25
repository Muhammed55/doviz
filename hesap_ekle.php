<?php
if(isset($_POST['paraIsim'])){
    include_once("php_includes/db_conx.php");
    include_once("php_includes/giris_kontrol.php");
    /*$sql = "SELECT kullaniciID FROM kullanici WHERE email = '$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_assoc($query);
    $kullaniciID = $row['kullaniciID'];*/
    $paraIsim = preg_replace('#[^a-z0-9]#i', '', $_POST['paraIsim']);
    $sql = "SELECT paraBirimleriID FROM paraBirimleri WHERE paraIsmi='$paraIsim' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_assoc($query);
    $paraBirimleriID = $row['paraBirimleriID'];

    $sql = "INSERT INTO cuzdan (kullaniciID, paraBirimleriID, miktar)
            VALUES('$log_id', '$paraBirimleriID', 0)";
    $query = mysqli_query($db_conx, $sql);
    if($query)
        echo "signup_success";
    exit();
}
?>