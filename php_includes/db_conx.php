<?php
/**
 * Created by PhpStorm.
 * User: Muhammed
 * Date: 5.12.2017
 * Time: 14:19
 */

//error_reporting(-1);
//ini_set('display_errors', 'On');
//set_error_handler("var_dump");
$db_conx = mysqli_connect("localhost", "Muhammed", "98lqgj50U4GUxOd2", "doviz_burosu");
//Evaluate the connection
if(mysqli_connect_errno()){
    echo mysqli_connect_error();
    exit();
}
?>