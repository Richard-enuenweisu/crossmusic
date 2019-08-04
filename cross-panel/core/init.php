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
session_start();
// if (isset($_SESSION['success_flash'])) {
// 	echo '<div class="bg-success" style="padding:4px;margin-top:77px;text-align:center;display:block"><p class="">'.$_SESSION['success_flash'].'</p></div>';
// 	unset($_SESSION['success_flash']);
// }
// if (isset($_SESSION['error_flash'])) {
// 	echo '<div class="row" style="padding:4px;margin-top:77px;text-align:center;background:#dc3545;display:block"><p class="text-white">'.$_SESSION['error_flash'].'</p></div>';
// 	unset($_SESSION['error_flash']);
// }
?>
