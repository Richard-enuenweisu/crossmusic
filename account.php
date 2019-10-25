<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$stmt = $pdo->prepare('SELECT * FROM pricingtbl WHERE id = :id ');
$stmt->execute([':id'=>1]);
$acc_price = $stmt->fetch(PDO::FETCH_ASSOC); 

$amount = $acc_price['price'];
$amount = number_format($amount);

if (isset($_POST['submit'])) {
	# code...
	$cname = ((isset($_POST['cname']))?sanitize($_POST['cname']): '');
	$fname = ((isset($_POST['fname']))?sanitize($_POST['fname']): '');
	$lname = ((isset($_POST['lname']))?sanitize($_POST['lname']): '');
	$email = ((isset($_POST['email']))?sanitize($_POST['email']): '');
	$phone = ((isset($_POST['phone']))?sanitize($_POST['phone']): '');
	$acc_type = ((isset($_POST['acc_type']))?sanitize($_POST['acc_type']): '');	
	$password = ((isset($_POST['password']))?sanitize($_POST['password']): '');
	$cpassword = ((isset($_POST['cpassword']))?sanitize($_POST['cpassword']): '');
	$terms = ((isset($_POST['terms']))?sanitize($_POST['terms']): '');	

	$errors = array();
	$success ='';

	//salt password
	$salted = 'Z%yHrcR8QDhF99CC^ZZ9qe!+k'.$password.'f+KA??dj7$S$HL4guq$yJ5_3b';
	$hashed = hash('sha224', $salted);
	//echo $hashed;
	$str = rand(); 
	$reflink = hash("sha224", $str);
	// setcookie($reflink, true, time() + (60 * 30)); 
    setcookie("cookieLink[link]",$reflink, time() + 7200);  /* expire in 2 hour */

	if (empty($cname) || empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($password) || empty($cpassword) ) {
		# code...
		$errors[].= 'Found empty fields'.'<br>';
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	    $errors[].='Found invalid email address'.'<br>';
	}
	if ($password !== $cpassword) {
		# code...
		$errors[].= 'Password mis-match!'.'<br>';
	}
	if ($acc_type == '--Select Account--') {
		# code...
		$errors[].= 'Please select account type.'.'<br>';
	}
	if ($acc_type == 'Free Account') {
		# code...
		$price = 0.00;			
	}
	else{
		$price = $amount;
	}
	if (empty($terms) && $terms =='') {
		# code...
		$errors[].= 'You must accept our terms and condtions.'.'<br>';
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
	    $mail->Host       = 'smtp.gmail.com'; 						// Specify main and backup SMTP servers
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
                                                        <td align="center" bgcolor="#007C89"><a href="https://mycrossmusic.com/email-verified.php?ref='.$reflink.'" style="border-radius:0;border:1px solid #007c89;color:#ffffff;display:inline-block;font-size:16px;font-weight:400;letter-spacing:.3px;padding:20px;text-decoration:none;font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif;" target="_blank">Activate Account</a>
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
        setcookie("cookieData[cname]", htmlentities($cname), time()+7200);  /* expire in 2 hour */
        setcookie("cookieData[fname]", htmlentities($fname), time()+7200);  /* expire in 2 hour */
        setcookie("cookieData[lname]", htmlentities($lname), time()+7200);  /* expire in 2 hour */ 
        setcookie("cookieData[email]", htmlentities($email), time()+7200);  /* expire in 2 hour */
        setcookie("cookieData[phone]", htmlentities($phone), time()+7200);  /* expire in 2 hour */
        setcookie("cookieData[acc_type]", htmlentities($acc_type), time()+7200);  /* expire in 2 hour */ 
        setcookie("cookieData[password]", htmlentities($hashed), time()+7200);  /* expire in 2 hour */
        setcookie("cookieData[price]", htmlentities($price), time()+7200);  /* expire in 2 hour */
        setcookie("cookieData[terms]", htmlentities($terms), time()+7200);  /* expire in 2 hour */
        setcookie("cookieData[price]", htmlentities($price), time()+7200);  /* expire in 2 hour */
        }
	// } catch (Exception $e) {
	//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	// }

  }

 }

  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');

?>

<div class="container">
	<div class="row pusher-3">
		<div class="col-md-12 price-header">
	        <h1>Create your account. Get going.</h1>
	        <p>
	        crossmusic profer a much more simpler way to sell your music and get you going. With our free account platform you get unlimited singles uplaods and people can freely download your songs. while our business account comes with a price and gives you unlimited singles and albums uploads.
	        <br>
	        <img class="img-fluid d-block d-" src="images/step.png">
			</p>			
		</div>
	</div>		
	<form method="POST" action="account.php" class="pusher">
		<h4>Account information</h4>
		<div class="row">
		    <div class="col-12">
		    	<div class="<?=(isset($success) && !empty($success)) ?'custom-sucess-message':'' ?>">
		    		<?=(isset($success)) ? $success:'' ?>
		    	</div>		      	
		    </div>
		    <div class="col-12">
		      	<?=(isset($errors)) ? display_errors($errors):'<p class="share-tiny-link">Please Fill out all fields with Asterisk(*).</p>' ?>
		    </div>
		</div> 		
	  <div class="form-group">
	    <label for="inputAddress">Comapany Name*</label>
	    <input type="text" class="form-control custom-inputs form-pill" name="cname" placeholder="Company Name"  onkeydown="return /[ a-z]/i.test(event.key)" value="<?=(isset($cname)) ? $cname:'' ?>">
	  </div>		
	  <div class="form-row">	  	
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
	    <label for="inputAddress">Email*</label>
	    <input type="text" class="form-control custom-inputs form-pill" name="email" placeholder="Enter Email" value="<?=(isset($email)) ? $email:'' ?>">
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inputEmail4">Phone*</label>
	      <input type="number" class="form-control custom-inputs form-pill" name="phone" placeholder="Phone Number" value="<?=(isset($phone)) ? $phone:'' ?>">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inputPassword4">Account type*</label>
	      <select name="acc_type" class="form-control custom-inputs form-pill">
		    <option selected><?=(isset($acc_type)) ? $acc_type:'--Select Account--' ?></option>
		    <option>Free Account</option>
		    <option>Paid Account</option>
		  </select>
	    </div>
	  </div>	  	  
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inputEmail4">Password*</label>
	      <input type="password" class="form-control custom-inputs form-pill" name="password" placeholder="Enter password" value="<?=(isset($password)) ? $password:'' ?>">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inputPassword4">Confirm Password*</label>
	      <input type="password" class="form-control custom-inputs form-pill" name="cpassword" placeholder="Confirm Password" value="<?=(isset($cpassword)) ? $cpassword:'' ?>">
	    </div>
	  </div>   
	<label class="custom-checkbox">I accept the <a href="terms.php"><u>Terms and Conditions</u></a>
	  <input type="checkbox" name="terms">
	  <span class="checkmark"></span>
	</label>
	  <br>
	  <button type="submit" class="btn btn-custom form-pill" name="submit">Please create Account</button>
	</form>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>