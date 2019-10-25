<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_GET['ref'])) {
  header('Location: index');
}
else{
  $ref = $_GET['ref'];
}
if (!isset($_COOKIE['cookieReset'])) {
  header('Location: index.php?expire=true');
}else{
  $link =  $_COOKIE['cookieReset']['link'];
}
if ($ref != $link) {
  header('Location: index.php?expire=true');
}

if (isset($_POST['save'])) {
  # code...
  $affiliate = ((isset($_POST['affiliate']))?sanitize($_POST['affiliate']): '');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']): '');
  $cpassword = ((isset($_POST['cpassword']))?sanitize($_POST['cpassword']): '');

  if (empty($password) || empty($password)) {
    $errors[].= 'Password field is empty'.'<br>';
  }
  if (empty($cpassword) || empty($cpassword)) {
    $errors[].= 'Confirm Password field is empty'.'<br>';
  }
  if ($password != $cpassword) {
    $errors[].= 'Password mis-match.'.'<br>';
  }    
  if (isset($affiliate) and empty($errors) and $affiliate > 0) {
    # code...
  $salted = 'Z%yHrcR8QDhF99CC^ZZ9qe!+k'.$password.'f+KA??dj7$S$HL4guq$yJ5_3b';
  $hashed = hash('sha224', $salted);   
      
  $update = $pdo->prepare("UPDATE aff_userstbl SET `password`=:password WHERE account_id = :user_id");
  $update->execute([':password' => $hashed, ':user_id' =>$affiliate ]); 
  $success = 'Password Reset Successfully!, Please Login now. '.'<br>';
  affiliateLogin($u_id);
  }else{
    $errors[].= 'Something went wrong, password reset failed'.'<br>';
  }  
}


  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">
.mylogin-holder{
	background-color: #103344;
	box-shadow: 4px 4px 20px 0 rgba(0,0,0,0.13);
}
.mylogin{
	padding: 15px;
}	
</style>

<div class="container">
	<div class="music-page-flex pusher-3">		
		<div class="col-md-6 mylogin-holder" style="padding: 0px;">
			<form class="mylogin" method="POST" action="aff-reset-password.php?ref=<?=$ref?>">				
				<h4>Reset Password</h4>
        <div class="row">          
          <div class="col-12">
            <p class="small">Please Fill out all fields.</p>
            <div class="<?=(isset($success) && !empty($success)) ?'custom-sucess-message':'' ?>">
              <?=(isset($success)) ? '<p class="">'.$success:'</p>' ?>
            </div>            
          </div>
          <div class="col-12">
              <?=(isset($errors))? display_errors($errors):'' ?>
          </div>
        </div> 	
        <input type="hidden" name="affiliate" value="<?=isset($_GET['affiliate'])?$_GET['affiliate']:''?>">          
				<div class="form-group">
				    <label for="inputAddress">Enter new password</label>
				    <input type="password" class="form-control custom-inputs form-pill" id="inputAddress" name="password" placeholder="Enter new password" value="<?=(isset($password)) ? $password:'' ?>">
				</div>
        <div class="form-group">
            <label for="inputAddress">Confirm Password</label>
            <input type="password" class="form-control custom-inputs form-pill" id="inputAddress" name="cpassword" placeholder="Confirm Password" value="<?=(isset($password)) ? $password:'' ?>">
        </div>        			 											  	  
			  <button type="submit" class="btn btn-custom form-pill" name="save">Save New Password</button>	
			</form>
			<img class="img-fluid" src="images/pw4.png">		
		</div>
	</div>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>

