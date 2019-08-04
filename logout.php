<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
 unset($_SESSION['USER_ID']);
 // $_SESSION['error_flash'] = 'You are now logged out';
 header('Location: login.php');
?>