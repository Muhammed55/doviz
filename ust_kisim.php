<?php
include_once("php_includes/giris_kontrol.php");
// It is important for any file that includes this file, to have
// check_login_status.php included at its very top.
$loginLink = '<a href="giris.php">Giriş</a> &nbsp; | &nbsp; <a href="uye_kayit.php">Üye olun</a>';
if($user_ok == true) {
    $loginLink = '<a href="kullanici.php?e='.$log_email.'">'.$log_email.'</a> &nbsp; | &nbsp; <a href="cikis.php">Çıkış</a>';
}
?>
<div id="pageTop">
    <div id="pageTopWrap">
        <div id="pageTopLogo">

        </div>
        <div id="pageTopRest">
            <div id="menu1">
                <div>
                    <?php echo $loginLink; ?>
                </div>
            </div>
            <div id="menu2">
                <div>
                    <a href="http://localhost/doviz">
                        Ev
                    </a>
                    <!--<a href="#">Menu_Item_1</a>
                    <a href="#">Menu_Item_2</a> -->
                </div>
            </div>
        </div>
    </div>
</div>