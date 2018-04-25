<?php
include_once("php_includes/giris_kontrol.php");
// Initialize any variables that the page might echo
$e = "";
// Make sure the _GET email is set, and sanitize it
if(isset($_GET["e"])){
    $e = preg_replace('#[^a-z0-9@._-]#i', '', $_GET['e']);
} else {
    //header("location: http://localhost/doviz");
    exit();
}?>

<?php
// Select the member from the users table
$sql = "SELECT kullaniciID FROM kullanici WHERE email='$e' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);
if($numrows < 1){
    echo "Böyle bir kullanıcı --" .$e. "-- yok.";
    exit();
}
// Check to see if the viewer is the account owner
$isOwner = "no";
if($e == $log_email && $user_ok == true){
    $isOwner = "yes";
    /*$profile_pic_btn = '<a href="#" onclick="return false;" onmousedown="toggleElement(\'avatar_form\')">Toggle Avatar Form</a>';
    $avatar_form  = '<form id="avatar_form" enctype="multipart/form-data" method="post" action="php_parsers/photo_system.php">';
    $avatar_form .=   '<h4>Change your avatar</h4>';
    $avatar_form .=   '<input type="file" name="avatar" required>';
    $avatar_form .=   '<p><input type="submit" value="Upload"></p>';
    $avatar_form .= '</form>';*/
}
else{
    header("location: http://localhost/doviz");
}
$row = mysqli_fetch_array($user_query, MYSQLI_ASSOC);
$kullaniciID = $row['kullaniciID'];
$cuzdan = '<table><tr><th>Para türü</th><th>Miktar</th></tr>';
$sql = "SELECT paraBirimleriID, miktar FROM cuzdan WHERE kullaniciID='$kullaniciID'";
$query = mysqli_query($db_conx, $sql);
while($row = mysqli_fetch_assoc($query)){
    $paraBirimleriID = $row['paraBirimleriID'];
    $miktar = $row['miktar'];
    $paraIsmi_query = mysqli_query($db_conx, "SELECT paraIsmi FROM ParaBirimleri WHERE paraBirimleriID='$paraBirimleriID' LIMIT 1");
    if(!$paraIsmi_query){
        $cuzdan .= '<tr><th>HATA</th></tr>';
    }
    else{
        $row = mysqli_fetch_assoc($paraIsmi_query);
        $paraIsmi = $row['paraIsmi'];
        $cuzdan .= '<tr><th>'.$paraIsmi.'</th><th>'.$miktar.'</th></tr>';
    }

}
$cuzdan .= '</table>';
$sql = "SELECT paraIsmi FROM  ParaBirimleri";
$query = mysqli_query($db_conx, $sql);
$dovizCinsleri = "";
while($row = mysqli_fetch_assoc($query)){
    $doviz = $row['paraIsmi'];
    $dovizCinsleri .= '<option value="'.$doviz.'">'.$doviz.'</option>';
}
$dovizCinsleri .= "</select>";
?>

<!DOCTYPE html>
<head>
    <script src="js/main.js"></script>
    <script src="js/ajax.js"></script>

    <meta charset="UTF-8">
    <title><?php echo $e; ?></title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <script>
        function hesapEkle(){
            var paraIsim = _("acilacakHesap").value;
            var status = _("status");
            if(paraIsim == ""){
                status.innerHTML = "Bütün alanları giriniz lütfen";
            } else {
                _("dvzBtn").style.display = "none";
                status.innerHTML = 'please wait ...';
                var ajax = ajaxObj("POST", "hesap_ekle.php");
                ajax.onreadystatechange = function() {
                    if(ajaxReturn(ajax) == true) {
                        if(ajax.responseText != "signup_success"){
                            status.innerHTML = "hata"+ajax.responseText;
                            _("dvzBtn").style.display = "block";
                        } else {
                            status.innerHTML = "dogru"+ajax.responseText;
                            _("dvzBtn").style.display = "block";
                            _("status").innerHTML = paraIsim + " hesabınız başarılya oluşturulmuştur."
                            _("status").style.display = "block";
                        }
                    }
                }
                ajax.send("paraIsim="+paraIsim);
            }
        }
    </script>
</head>
<body>
<?php include_once("ust_kisim.php"); ?>
<div id="pageMiddle">

    <div class="modal-body row">
        <div class="col-md-6">
            <h3>Merhaba, <?php echo $e; ?></h3>
            <h3>Cüdanınız:</h3>
            <?php echo "$cuzdan"; ?>
            <p>Cüzdanınıza buradan yeni yabancı döviz hesabı açabilirsiniz.</p>
            <p>Açılacak yeni döviz hesabı: <select id='acilacakHesap'><?php echo "$dovizCinsleri" ?>
                <button id="dvzBtn" onclick="hesapEkle()">Döviz hesabını aç</button></p>
            <p id="status" style="display: none"></p>
        </div>

        <div class="col-md-6">
            <div>
                <h4>Buradan (bankanızdan) hesabınıza para yükleyebilirsiniz</h4>
                <form action="para_yukle.php">
                    <input type="text" name="yuklenecekMiktar" value="00,00"> TL <br>
                    <input type="submit" value="Yükle" style="margin-top: 10px">
                </form>
            </div>
            <div style="margin-top: 10px;">
                <form action="para_bozdur.php">
                    <h4>Buradan da parınızı yabancı dövizlere bozdurabilirsiniz</h4>

                    <select name="dovizden"><?php echo $dovizCinsleri; ?>'nden <select name="dovize"><?php echo $dovizCinsleri; ?>'ne
                    <input type="text" name="miktar">
                    <input type="submit" value="BOZDUR">
                </form>
            </div>
        </div>
    </div>

</div>
</body>