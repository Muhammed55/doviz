<?php
include_once("php_includes/db_conx.php");
include_once("php_includes/giris_kontrol.php");
?>
<?php
$kurlar = '<table><tr><th>Döviz</th><th>Alış kuru</th><th>Şatış kuru</th></tr>';
$sql = "SELECT paraIsmi, alisKur, satisKur FROM paraBirimleri";
$query = mysqli_query($db_conx, $sql);
while($row = mysqli_fetch_assoc($query)){
    $paraIsmi = $row['paraIsmi'];
    $alisKur = $row['alisKur'];
    $satisKur = $row['satisKur'];
    $kurlar .= '<tr><th>'.$paraIsmi.'</th><th>'.$alisKur.'</th><th>'.$satisKur.'</th></tr>';
}
$kurlar .= '</table>';
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
<div id="pageMiddle">
    <h2>Döviz büromuza hoş geldiniz.</h2>
    <h5>Bu sayfada güncel kurları görebilirsiniz veya giriş yapıp kendi hesabınızı açabilirsiniz.</h5>
    <?php echo $kurlar; ?>
</div>
</body>
</html>
