<?php
include_once("php_includes/giris_kontrol.php");
// If user is already logged in, header that weenis away
if($user_ok == true){
    header("location: user.php?u=".$_SESSION["username"]);
    exit();
}
?><?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["e"])){
    // CONNECT TO THE DATABASE
    include_once("php_includes/db_conx.php");
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
    $e = mysqli_real_escape_string($db_conx, $_POST['e']);
    $p = md5($_POST['p']);
    // FORM DATA ERROR HANDLING
    if($e == "" || $p == ""){
        echo "login_failed";
        exit();
    } else {
        // END FORM DATA ERROR HANDLING
        $sql = "SELECT kullaniciID, email, sifre FROM kullanici WHERE email='$e' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $db_id = $row[0];
        $db_email = $row[1];
        $db_pass_str = $row[2];
        if($p != $db_pass_str){
            echo "login_failed";
            exit();
        } else {
            // CREATE THEIR SESSIONS AND COOKIES
            $_SESSION['kullaniciID'] = $db_id;
            $_SESSION['email'] = $db_email;
            $_SESSION['password'] = $db_pass_str;
            setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
            setcookie("email", $db_email, strtotime( '+30 days' ), "/", "", "", TRUE);
            setcookie("sifre", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE);
            echo $db_email;
            exit();
        }
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Log In</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/style.css">
    <style type="text/css">
        #loginform{
            <meta charset="UTF-8">
            margin-top:24px;
        }
        #loginform > div {
            margin-top: 12px;
        }
        #loginform > input {
            width: 200px;
            padding: 3px;
            background: #F3F9DD;
        }
        #loginbtn {
            font-size:15px;
            padding: 10px;
        }
    </style>
    <script src="js/main.js"></script>
    <script src="js/ajax.js."></script>
    <script>
        function emptyElement(x){
            _(x).innerHTML = "";
        }
        function login(){
            var e = _("email").value;
            var p = _("password").value;
            if(e == "" || p == ""){
                _("status").innerHTML = "Bütün alanları giriniz";
            } else {
                _("loginbtn").style.display = "none";
                _("status").innerHTML = 'please wait ...';
                var ajax = ajaxObj("POST", "giris.php");
                ajax.onreadystatechange = function() {
                    if(ajaxReturn(ajax) == true) {
                        if(ajax.responseText == "login_failed"){
                            _("status").innerHTML = "Login unsuccessful, please try again.";
                            _("loginbtn").style.display = "block";
                        } else {
                            window.location = "kullanici.php?e="+ajax.responseText;
                        }
                    }
                }
                ajax.send("e="+e+"&p="+p);
            }
        }
    </script>
</head>
<body>
<?php include_once("ust_kisim.php"); ?>
<div id="pageMiddle">
    <h3>Log In Here</h3>
    <!-- LOGIN FORM -->
    <form id="loginform" onsubmit="return false;">
        <div>Email Address:</div>
        <input type="text" id="email" onfocus="emptyElement('status')" maxlength="88">
        <div>Password:</div>
        <input type="password" id="password" onfocus="emptyElement('status')" maxlength="100">
        <br /><br />
        <button id="loginbtn" onclick="login()">Log In</button>
        <p id="status"></p>
        <a href="#">Forgot Your Password?</a>
    </form>
    <!-- LOGIN FORM -->
</div>
<?php include_once("alt_kisim.php"); ?>
</body>
</html>