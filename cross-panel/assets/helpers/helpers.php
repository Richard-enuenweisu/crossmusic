<?php

function display_errors($errors)
{
	$display = '<ul class="" style="list-style-type:none;padding:0px;">';
	foreach ($errors as $error) {
		$display .='<li class="text-danger">'.$error.'</li>'; 
	}
	$display .= '</ul>';

	return $display;
}
function sanitize($dirty){
	return htmlentities($dirty, ENT_QUOTES, "UTF-8");
}
function login($user_id)
{
	$_SESSION['USER_ID'] = $user_id;
	global $db;
	// $date = date("y-m-d h:m:s");

	// $db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
	$_SESSION['success_flash'] = 'You are now logged in';
	header('Location: acknowledgement.php');
}
function artistLogin($user_id)
{
	$_SESSION['ARTIST_ID'] = $user_id;
	global $db;
	// $date = date("y-m-d h:m:s");

	// $db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
	$_SESSION['success_flash'] = 'You are now logged in';
	header('Location: index.php');
}
function is_logged_in(){
	if (isset($_SESSION['USER_ID']) && $_SESSION['USER_ID'] > 0) {
		return true;
	}
	return false;
}

function logout($url = 'login.php'){
$_SESSION['error_flash'] = 'You are now logged out';
header('Location: '. $url);
}

function permission_error($url = 'login.php'){
$_SESSION['error_flash'] = 'you must be logged in to access that page.';
header('Location: '. $url);
}

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


?>