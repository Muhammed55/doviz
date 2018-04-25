<?php
include_once("php_includes/giris_kontrol.php");
//session_start();
// If user is logged in, header them away
if(isset($_SESSION["username"])){
    header("location: message.php?msg=olmaz");
    exit();
}
?><?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
    include_once("php_includes/db_conx.php");
    $username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
    $sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
        echo '<strong style="color:#F00;">3 - 16 karakter uzunluğunda olması gerekiyor</strong>';
        exit();
    }
    if (is_numeric($username[0])) {
        echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
        exit();
    }
    if ($uname_check < 1) {
        echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
        exit();
    } else {
        echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
        exit();
    }
}
?><?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["e"])){
    // CONNECT TO THE DATABASE
    include_once("php_includes/db_conx.php");
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $e = mysqli_real_escape_string($db_conx, $_POST['e']);
    $p = $_POST['p'];
    // DUPLICATE DATA CHECKS FOR EMAIL
    // -------------------------------------------
    $sql = "SELECT kullaniciID FROM kullanici WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $e_check = mysqli_num_rows($query);
    // FORM DATA ERROR HANDLING
    if($e == "" || $p == ""){
        echo "Bütün değerler girilmemiştir";
        exit();
    } else if ($e_check > 0){
        echo "Bu email ile daha önce kayıt yapılmış bile.";
        exit();
    }
    else {
        // END FORM DATA ERROR HANDLING
        // Begin Insertion of data into the database
        // Hash the password and apply your own mysterious unique salt
        /*$cryptpass = @crypt($p);
        include_once ("php_includes/randStrGen.php");
        $p_hash = randStrGen(20)."$cryptpass".randStrGen(20);*/
        $p_hash = md5($p);
        // Add user info into the database table for the main site table
        $sql = "INSERT INTO kullanici (email, sifre)       
		        VALUES('$e','$p_hash')";
        if($query = mysqli_query($db_conx, $sql))
        {
            echo "signup_success";
            $query = mysqli_query($db_conx, "SELECT kullaniciID FROM kullanici WHERE email='$e' LIMIT 1");
            $row = mysqli_fetch_array($query);
            $kullaniciID = $row['kullaniciID'];
            //echo "\n $kullaniciID";
            $query = mysqli_query($db_conx, "SELECT paraBirimleriID FROM parabirimleri WHERE paraIsmi='TRY' LIMIT 1");
            $row = mysqli_fetch_array($query);
            $paraBirimleriID = $row['paraBirimleriID'];
            //echo "\n $paraBirimleriID";
            $sql = "INSERT INTO cuzdan(kullaniciID, paraBirimleriID, miktar)
                    VALUES('$kullaniciID', '$paraBirimleriID', '0')";
            if(!$query = mysqli_query($db_conx, $sql))
                echo "hata";
        }



        /*$uid = mysqli_insert_id($db_conx);
        // Email the user their activation link*/

        exit();
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/style.css">
    <style type="text/css">
        #signupform{
            margin-top:24px;
        }
        #signupform > div {
            margin-top: 12px;
        }
        #signupform > input,select {
            width: 200px;
            padding: 3px;
            background: #F3F9DD;
        }
        #signupbtn {
            font-size:18px;
            padding: 12px;
        }
        #terms {
            border:#CCC 1px solid;
            background: #F5F5F5;
            padding: 12px;
        }
    </style>
    <script src="js/main.js"></script>
    <script src="js/ajax.js"></script>
    <script>
        function restrict(elem){
            var tf = _(elem);
            var rx = new RegExp;
            if(elem == "email"){
                rx = /[' "]/gi;
            }
            tf.value = tf.value.replace(rx, "");
        }
        function emptyElement(x){
            _(x).innerHTML = "";
        }
        function checkusername(){
            var u = _("username").value;
            if(u != ""){
                _("unamestatus").innerHTML = 'checking ...';
                var ajax = ajaxObj("POST", "signup.php");
                ajax.onreadystatechange = function() {
                    if(ajaxReturn(ajax) == true) {
                        _("unamestatus").innerHTML = ajax.responseText;
                    }
                }
                ajax.send("usernamecheck="+u);
            }
        }
        function signup(){
            var e = _("email").value;
            var p1 = _("pass1").value;
            var p2 = _("pass2").value;
            var status = _("status");
            if(e == "" || p1 == "" || p2 == ""){
                status.innerHTML = "Bütün alanları giriniz lütfen";
            } else if(p1 != p2){
                status.innerHTML = "Girdiğiniz şifreler uyuşmuyor";
            } else if( _("terms").style.display == "none"){
                status.innerHTML = "Lütfen Şartları okuyun ilk önce";
            } else {
                _("signupbtn").style.display = "none";
                status.innerHTML = 'please wait ...';
                var ajax = ajaxObj("POST", "uye_kayit.php");
                ajax.onreadystatechange = function() {
                    if(ajaxReturn(ajax) == true) {
                        if(ajax.responseText != "signup_success"){
                            status.innerHTML = ajax.responseText;
                            _("signupbtn").style.display = "block";
                        } else {
                            window.scrollTo(0,0);
                            _("signupform").innerHTML = "Pekala "+e+", hesabınız oluşturulmuştur.";
                        }
                    }
                }
                ajax.send("e="+e+"&p="+p1);
            }
        }
        function openTerms(){
            _("terms").style.display = "block";
            emptyElement("status");
        }
        /* function addEvents(){
            _("elemID").addEventListener("click", func, false);
        }
        window.onload = addEvents; */
    </script>
</head>
<body>
<?php include_once("ust_kisim.php"); ?>
<div id="pageMiddle">
    <h3>Sign Up Here</h3>
    <form name="signupform" id="signupform" onsubmit="return false;">
        <div>Email Adresi:</div>
        <input id="email" type="text" onfocus="emptyElement('status')" onkeyup="restrict('email')" maxlength="88">
        <div>Şifre Oluştur:</div>
        <input id="pass1" type="password" onfocus="emptyElement('status')" maxlength="100">
        <div>Şifreyi Doğrula:</div>
        <input id="pass2" type="password" onfocus="emptyElement('status')" maxlength="100">
        <div>
            <a href="#" onclick="return false" onmousedown="openTerms()">
                View the Terms Of Use
            </a>
        </div>
        <div id="terms" style="display:none;">
            <h3>Web Intersect Terms Of Use</h3>
            <p>1. Play nice here.</p>
            <p>2. Take a bath before you visit.</p>
            <p>3. Brush your teeth before bed.</p>
        </div>
        <br /><br />
        <button id="signupbtn" onclick="signup()">Create Account</button>
        <span id="status"></span>
    </form>
</div>
<?php include_once("alt_kisim.php"); ?>
</body>
</html>