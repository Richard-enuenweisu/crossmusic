<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

 unset($_SESSION['ARTIST_ID']);
 unset($_SESSION['AFFILIATE_ID']);
 // $_SESSION['error_flash'] = 'You are now logged out';
 if (isset($_SESSION['ADMIN_ID'])) {
 	# code...
 	unset($_SESSION['ADMIN_ID']);
 	header('Location: admin-login.php');
 }else{
 	header('Location: login.php');
}
?>