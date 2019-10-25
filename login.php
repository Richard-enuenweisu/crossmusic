<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (isset($_POST['login'])) {
    # code...
    $email = ((isset($_POST['email']))?sanitize($_POST['email']): '');
    $password = ((isset($_POST['password']))?sanitize($_POST['password']): '');
    $errors = array();

    if (empty($email) || empty($password)) {
      $errors[].= 'Some fields are empty'.'<br>';
    }

    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[].='email is not a valid email address'.'<br>';
    }
      //salt password
    $salted = 'Z%yHrcR8QDhF99CC^ZZ9qe!+k'.$password.'f+KA??dj7$S$HL4guq$yJ5_3b';
    $hashed = hash('sha224', $salted);

    if (isset($_POST['userType']) && ($_POST['userType'] != "")) {
    $stmt = $pdo->prepare('SELECT * FROM artisttbl WHERE email = ? AND password = ?');
    $stmt->execute([$email , $hashed]);
    $row = $stmt->rowcount();
    $result =$stmt->fetch(PDO::FETCH_ASSOC);

    if ($row < 1) {
      $errors[].='users does not exist!'.'<br>';
    }
    if ($result['featured'] == 0) {
      # code...
      $errors[].='user is blocked!'.'<br>';
    }
    if (empty($errors)) {
      $u_id = intval($result['account_id']);
      $success = 'Logged in Successfully!, redirecting to Dashboard in 2secs. '.'<br>';
      artistLogin($u_id);
    }
    }
    else{
    $stmt = $pdo->prepare('SELECT * FROM usertbl WHERE email = ? AND password = ?');
    $stmt->execute([$email , $hashed]);
    $row = $stmt->rowcount();
    $result =$stmt->fetch(PDO::FETCH_ASSOC);

    if ($row < 1) {
      $errors[].='users does not exist!'.'<br>';
    }
    if ($result['featured'] == 0) {
      # code...
      $errors[].='user is blocked!'.'<br>';
    }    
    if (empty($errors)) {
      $u_id = intval($result['id']);
      $success = 'Logged in Successfully! '.'<br>';
      login($u_id);
    }
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
			<form class="mylogin" method="POST" action="login.php">				
				<h4>Please Login</h4>
        <div class="row">
          <div class="col-12">
            <div class="<?=(isset($success) && !empty($success)) ?'custom-sucess-message':'' ?>">
              <?=(isset($success)) ? '<p>'.$success:'</p>' ?>
            </div>            
          </div>
          <div class="col-12">
              <?=(isset($errors))? display_errors($errors):'<p class="share-tiny-link">Please Fill out all fields.</p>' ?>
          </div>
        </div> 				
				<div class="form-group push">
				    <label for="inputAddress">Email</label>
				    <input type="text" class="form-control custom-inputs form-pill" id="inputAddress" name="email" placeholder="Email" value="<?=(isset($email)) ? $email:'' ?>">
				</div>		
				<div class="form-group">
				    <label for="inputAddress">Password</label>
				    <input type="password" class="form-control custom-inputs form-pill" id="inputAddress" name="password" placeholder="Password" value="<?=(isset($password)) ? $password:'' ?>">
				</div>
	                <div class="material-switch">
	                	<span class="switcher">User</span> &nbsp;&nbsp;
	                    <input id="someSwitchOptionSuccess" name="userType" type="checkbox" <?=(empty($_POST['userType'])) ? '':'checked' ?>/>
	                    <label for="someSwitchOptionSuccess" class="label-success"></label>&nbsp;&nbsp;
	                    <span class="switcher">Artist</span> 
	                </div>	
	           <br>
	           <br>			 											  	  
			  <button type="submit" class="btn btn-custom form-pill" name="login">Please Login</button>	
        <a class="link-muted small float-right" href="forget-password">Forgot Password?</a>
			</form>
			<img class="img-fluid" src="images/login-img.png">		
		</div>
	</div>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>