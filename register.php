<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['login'])) {
  # code...
  $fname = ((isset($_POST['email']))?sanitize($_POST['fname']): '');
  $lname = ((isset($_POST['email']))?sanitize($_POST['lname']): '');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']): '');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']): '');
  $errors = array();

  if (empty($fname) || empty($lname) || empty($email) || empty($password)) {
    $errors[].= 'Some fields are empty'.'<br>';
  }

  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[].='email is not a valid email address'.'<br>';
  }
    //salt password
  $salted = 'Z%yHrcR8QDhF99CC^ZZ9qe!+k'.$password.'f+KA??dj7$S$HL4guq$yJ5_3b';
  $hashed = hash('sha224', $salted);

  $str = rand(); 
  $reflink = hash("sha224", $str);
  // setcookie($reflink, true, time() + (60 * 30)); 
  setcookie("cookieUlink[link]",$reflink, time() + 7200);  /* expire in 2 hour */  

  $stmt = $pdo->prepare('SELECT * FROM usertbl WHERE email = ?');
  $stmt->execute([$email]);
  $row = $stmt->rowcount();
  $result =$stmt->fetch(PDO::FETCH_ASSOC);

  if ($row > 0) {
    $errors[].='user already exist!'.'<br>';
  }
    if (empty($errors)) {
  // Import PHPMailer classes into the global namespace
  // These must be at the top of your script, not inside a function
  require 'vendor/phpmailer/phpmailer/src/Exception.php';
  require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
  require 'vendor/phpmailer/phpmailer/src/SMTP.php';
  // Load Composer's autoloader
  require str_replace("\\","/",dirname(__FILE__).'/vendor/autoload.php');
  // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);
  // $mail = new cross\vendor\phpmailer\phpmailer\PHPMailer();
  // try {
      //Server settings
      // $mail->SMTPDebug = 2;                                       // Enable verbose debug output
      $mail->isSMTP();                                            // Set mailer to use SMTP
      $mail->Host       = 'smtp.gmail.com';             // Specify main and backup SMTP servers
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'justcross3@gmail.com';                     // SMTP username
      $mail->Password   = 'crmail6.';                               // SMTP password
      $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
      $mail->Port       = 587;                                    // TCP port to connect to
      //Recipients
      $mail->setFrom('hello.crossmusic@gmail.com', 'Crossmusic');
      $mail->addAddress($email, $lname);     // Add a recipient
      $mail->addAddress($email, $lname);               // Name is optional
      $mail->addReplyTo('noreply@gmail.com', 'Crossmusic');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');
      // Attachments
      // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Activate your Crossmusic account';
      $mail->Body    = '<div bgcolor="#EFEEEA">
        <center>
            <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-bottom:60px">
                        <p style="color:#ffe01b;display:none;font-size:0px;height:0px;width:0px">You are almost ready to get started!</p>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                            
                            <tbody><tr>
                                <td align="center" valign="top" bgcolor="#FFE01B" style="background-color:#0b2435">
                                    
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:640px" width="100%">
                                        <tbody><tr>
                                            <td align="center" valign="top" style="padding:40px">
                                                <a href=" style="text-decoration:none" target="_blank" data-saferedirecturl="https://mycrossmusic.com/"><img src="https://lh3.googleusercontent.com/-HV1s_FW_xZY/XSTFE40_BLI/AAAAAAAAABE/L5qBVwAuPXsPozlicJMmbCW70ZOCXmAEACEwYBhgL/w140-h140-p/logo.png" width="120" style="border:0;color:#ffffff;
                                                font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;height:auto;letter-spacing:-1px;padding:0;margin:0;outline:none;text-align:center;text-decoration:none"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#ffffff;padding-top:40px">&nbsp;</td>
                                        </tr>
                                    </tbody></table>
                                    
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td align="center" valign="top">
                                    
                                    <table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff;max-width:640px" width="100%" class=">
                                        <tbody><tr>
                                            <td align="center" valign="top" bgcolor="#FFFFFF" style="padding-right:40px;padding-bottom:40px;padding-left:40px">
                                                <h1 style="color:#241c15;font-family:Georgia,Times,Times New Roman,serif;font-size:30px;font-style:normal;font-weight:400;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:center">We are glad you are here,<br> '.ucfirst($lname).'</h1>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" style="padding-right:40px;padding-bottom:60px;padding-left:40px">
                                                <table border="0" cellspacing="0" cellpadding="0">
                                                    <tbody><tr>
                                                        <td align="center" bgcolor="#007C89"><a href="https://mycrossmusic.com/user-email-verified.php?ref='.$reflink.'" style="border-radius:0;border:1px solid #007c89;color:#ffffff;display:inline-block;font-size:16px;font-weight:400;letter-spacing:.3px;padding:20px;text-decoration:none;font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif;" target="_blank">Activate Account</a>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="padding-right:40px;padding-bottom:40px;padding-left:40px">
                                                <p style="color:#6a655f;font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif;font-size:16px;font-style:normal;font-weight:400;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:center">(Just confirming you are you.)</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="border-top:2px solid #efeeea;color:#6a655f;font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding-top:40px;padding-bottom:40px;text-align:center">
                                                <p style="color:#6a655f;font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding:0 20px;margin:0;text-align:center">© 2019 Crossmusic<sup>®</sup>, All Rights Reserved.</p>
                                                <a href="https://mycrossmusic.com/contact" style="color:#007c89;font-weight:500;text-decoration:none" target="_blank"> &nbsp; | &nbsp; </span><a href="#" style="color:#007c89;font-weight:500;text-decoration:none" class=" target="_blank" >Terms of Use</a><span class="> &nbsp; | &nbsp; </span><a href="#" style="color:#007c89;font-weight:500;text-decoration:none" target="_blank">Privacy Policy</a>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </center><div class="yj6qo"></div><div class="adL">
      </div>
    </div>';
      // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      if (!$mail->send()) {
        # code...
        $errors[].='Message could not be sent';
      }else{
      $success = '<h2>Check your email.</h2>'.'We’ve sent a message to '.$email.' with a link to activate your account. '.'<br>'; 
        // $msg= 'sessioned data. <br>';
        setcookie("cookieUser[fname]", htmlentities($fname), time()+7200);  /* expire in 2 hour */
        setcookie("cookieUser[lname]", htmlentities($lname), time()+7200);  /* expire in 2 hour */
        setcookie("cookieUser[email]", htmlentities($email), time()+7200);  /* expire in 2 hour */ 
        setcookie("cookieUser[password]", htmlentities($hashed), time()+7200);  /* expire in 2 hour */ 

        }
  // } catch (Exception $e) {
  //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  // }

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
			<form class="mylogin" method="POST" action="register.php">				
				<h4>Please Login</h4>
		          <div class="row">
		                <div class="col-12">
                      <div class="<?=(isset($success) && !empty($success)) ?'custom-sucess-message':'' ?>">
                        <?=(isset($success)) ? $success:'' ?>
                      </div>
		                </div>
		                <div class="col-12">
		                  	<?=(isset($errors)) ? display_errors($errors):'Please Fill out all fields.' ?>
		                </div>
		          </div> 
        <div class="form-row push">      
          <div class="form-group col-md-6">
            <label for="inputEmail4">First Name*</label>
            <input type="text" class="form-control custom-inputs form-pill" name="fname" placeholder="First Name" onkeydown="return /[ a-z]/i.test(event.key)" value="<?=(isset($fname)) ? $fname:'' ?>">
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Last Name*</label>
            <input type="text" class="form-control custom-inputs form-pill" name="lname" placeholder="Last Name" onkeydown="return /[ a-z]/i.test(event.key)" value="<?=(isset($lname)) ? $lname:'' ?>">
          </div>
        </div>              				
				<div class="form-group">
				    <label for="inputAddress">Email</label>
				    <input type="text" class="form-control custom-inputs form-pill" id="inputAddress" name="email" placeholder="Email" value="<?=(isset($email)) ? $email:'' ?>">
				</div>		
				<div class="form-group">
				    <label for="inputAddress">Password</label>
				    <input type="text" class="form-control custom-inputs form-pill" id="inputAddress" name="password" placeholder="Password" value="<?=(isset($password)) ? $password:'' ?>">
				</div>
            <div class="material-switch">
            	<span class="switcher">Aleady have an account? <a href="login.php">Login</a> </span>
            </div>	
	           <br>		 											  	  
        <div class="form-row">      
          <div class="form-group col-md-6">
        <button type="submit" class="btn btn-custom form-pill" name="login">Sign up <i class="fa fa-user-o"></i></button>
          </div>
          <div class="form-group col-md-6">
        <!-- <button type="submit" class="btn btn-secondary form-pill" name="gmail">Sign up with Gmail <i class="fa fa-google"></i></button> -->
          </div>
        </div>       
      </form>
			<img class="img-fluid" src="images/register-img.png">		
		</div>
	</div>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>