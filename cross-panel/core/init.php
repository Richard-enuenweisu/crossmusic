<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'cross';

try
{
//Set DSN
$dsn ="mysql:host=".$host.";dbname=".$dbname;
//Create a PDO Instance
$pdo = new PDO($dsn,$user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}


// server should keep session data for AT LEAST 1 day
ini_set('session.gc_maxlifetime', 86400);

// each client should remember their session id for EXACTLY 1 day
session_set_cookie_params(86400);

session_start(); // ready to go!

$now = time(); //mktime(). time()+60*60*24*30

// either new or old, it should live at most for another day
$_SESSION['discard_after'] = $now + 86400;

if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
}


error_reporting(1); // Set to 1 if you want PHP error to Display But Mind you use Zero(0) To prevent  from Hackers..

// if (isset($_SESSION['success_flash'])) {
// 	echo '<div class="bg-success" style="padding:4px;margin-top:77px;text-align:center;display:block"><p class="">'.$_SESSION['success_flash'].'</p></div>';
// 	unset($_SESSION['success_flash']);
// }
// if (isset($_SESSION['error_flash'])) {
// 	echo '<div class="row" style="padding:4px;margin-top:77px;text-align:center;background:#dc3545;display:block"><p class="text-white">'.$_SESSION['error_flash'].'</p></div>';
// 	unset($_SESSION['error_flash']);
// }
?>
