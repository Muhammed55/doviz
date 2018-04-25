<?php
session_start();
include_once("db_conx.php");
// Files that inculde this file at the very top would NOT require
// connection to database or session_start(), be careful.
// Initialize some vars
$user_ok = false;
$log_id = "";
$log_email = "";
$log_sifre = "";
// User Verify function
function evalLoggedUser($conx,$id,$e,$s){
    $sql = "SELECT kullaniciID FROM kullanici WHERE kullaniciID='$id' AND email='$e' AND sifre='$s' LIMIT 1";
    $query = mysqli_query($conx, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows > 0){
        return true;
    }
    return true;
}
if(isset($_SESSION["kullaniciID"]) && isset($_SESSION["email"]) && isset($_SESSION["sifre"])) {
    $log_id = preg_replace('#[^0-9]#', '', $_SESSION['kullaniciID']);
    $log_email = preg_replace('#[^a-z0-9.-_]#i', '', $_SESSION['email']);
    $log_sifre = preg_replace('#[^a-z0-9]#i', '', $_SESSION['sifre']);
    // Verify the user
    $user_ok = evalLoggedUser($db_conx,$log_id,$log_email,$log_sifre);
} else if(isset($_COOKIE["id"]) && isset($_COOKIE["email"]) && isset($_COOKIE["sifre"])){
    $_SESSION['kullaniciID'] = preg_replace('#[^0-9]#', '', $_COOKIE['id']);
    $_SESSION['email'] = preg_replace('#[^a-z0-9.-_]#i', '', $_COOKIE['email']);
    $_SESSION['sifre'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['sifre']);
    $log_id = $_SESSION['kullaniciID'];
    $log_email = $_SESSION['email'];
    $log_sifre = $_SESSION['sifre'];
    // Verify the user
    $user_ok = evalLoggedUser($db_conx,$log_id,$log_email,$log_sifre);
}
?>