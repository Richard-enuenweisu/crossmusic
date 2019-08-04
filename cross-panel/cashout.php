<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['ARTIST_ID'])) {
  permission_error('login.php');
}else{
	$artist_id = $_SESSION['ARTIST_ID'];
	$stmt = $pdo->query("SELECT * FROM accounttbl WHERE id = $artist_id ");
	$acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$acct_type = $acc_result['acct_type'];
	$acc_name =  $acc_result['company_name'];
}

  $bal_query = $pdo->query("SELECT * FROM artist_balancetbl WHERE account_id = $artist_id ");
  $balance = $bal_query->fetch(PDO::FETCH_ASSOC);

  $curr_balance = $balance['balance'];

if (isset($_POST['submit'])) {
	# code...
	$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
	$amount = ((isset($_POST['amount']) && $_POST['amount'] != '')?sanitize($_POST['amount']):'');

	$success;
	$errors = array();

	if (empty($description) || empty($amount)) {
		# code...
		$errors[].='Found empty fields!';
	}
	if ($amount < 2000 ) {
		# code...
		$errors[].='Amount is too small.';
	}	
	if ($amount > $curr_balance || $amount < 1) {
		# code...
		$errors[].='Specify amount withdrawable from your current Balance.';
	}
  if (empty($errors)) {
	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	require '../vendor/phpmailer/phpmailer/src/Exception.php';
	require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
	require '../vendor/phpmailer/phpmailer/src/SMTP.php';
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
	    $mail->addAddress('reechiedeclan@gmail.com');     // Add a recipient
	    $mail->addAddress('reechiedeclan@gmail.com');               // Name is optional
	    $mail->addReplyTo('noreply@gmail.com', 'Crossmusic');
	    // $mail->addCC('cc@example.com');
	    // $mail->addBCC('bcc@example.com');
	    // Attachments
	    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Cashout Request - Crossmusic';
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
                                                <a href=" style="text-decoration:none" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.mail.com/&amp;source=gmail&amp;ust=1562686520120000&amp;usg=AFQjCNGGDFeD51MH09C3mcNqZD6XyP0pdw"><img src="https://lh3.googleusercontent.com/-HV1s_FW_xZY/XSTFE40_BLI/AAAAAAAAABE/L5qBVwAuPXsPozlicJMmbCW70ZOCXmAEACEwYBhgL/w140-h140-p/logo.png" width="120" style="border:0;color:#ffffff;
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
                                                <h1 style="color:#241c15;font-family:Georgia,Times,Times New Roman,serif;font-size:30px;font-style:normal;font-weight:400;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:center">New Cashout Request from,<br> '
                                                .ucfirst($acc_name).'</h1>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" style="padding-right:40px;padding-bottom:60px;padding-left:40px">
                                                <table border="0" cellspacing="0" cellpadding="0">
                                                    <tbody><tr>
                                                        <td align="center" bgcolor="#007C89"><a href="http://localhost/cross/cross-panel/login.php" style="border-radius:0;border:1px solid #007c89;color:#ffffff;display:inline-block;font-size:16px;font-weight:400;letter-spacing:.3px;padding:20px;text-decoration:none;font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif;" target="_blank">Approve Request</a>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="padding-right:40px;padding-bottom:40px;padding-left:40px">
                                                <p style="color:#6a655f;font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif;font-size:16px;font-style:normal;font-weight:400;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:center">(Just confirming you"re you.)</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="border-top:2px solid #efeeea;color:#6a655f;font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding-top:40px;padding-bottom:40px;text-align:center">
                                                <p style="color:#6a655f;font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding:0 20px;margin:0;text-align:center">© 2019 Crossmusic<sup>®</sup>, All Rights Reserved.<br><a style="color:#6a655f;text-decoration:none">675 Ponce De Leon Ave NE - Suite 5000 - Atlanta, GA 30308 USA</a></p>
                                                <a href="#/contact/" style="color:#007c89;font-weight:500;text-decoration:none" target="_blank"> &nbsp; | &nbsp; </span><a href="https://mailchimp.com/legal/terms/" style="color:#007c89;font-weight:500;text-decoration:none" class=" target="_blank" >Terms of Use</a><span class="> &nbsp; | &nbsp; </span><a href="https://mailchimp.com/legal/privacy/" style="color:#007c89;font-weight:500;text-decoration:none" target="_blank">Privacy Policy</a>
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
	    $stmt = $pdo->prepare("INSERT INTO `artist_trasanctionstbl` ( `account_id`, `description`, `amount`, `curr_bal`) VALUES(:account_id, :description, :amount, :curr_bal)");
	    $stmt->execute([':account_id'=>$artist_id, ':description'=>$description, ':amount'=>$amount, ':curr_bal'=>$curr_balance]);
    	$success = 'Cashout request sent successfully.';	
        }
	// } catch (Exception $e) {
	//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	// }

  }

	
}

  include str_replace("\\","/",dirname(__FILE__).'/assets/include/header.php');
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/headbar.php');
?>

	<main class="u-main" role="main">
			<!-- Sidebar -->
		<?php
		  include str_replace("\\","/",dirname(__FILE__).'/assets/include/nav.php');
		?>	
<style type="text/css">
	.table-responsive img{
		width: 65px;
		height: 65px;
	}
</style>
			<div class="u-content">
				<div class=" u-body">
					<h1 class="h2 font-weight-semibold mb-4">Cashout Request</h1>
		<main class="container-fluid " role="main">
			<div class="row">
				<div class="col-lg-6 d-flex flex-column justify-content-center align-items-center bg-white mnh-100vh">
						<a class="u-login-form py-3 text-center" href="index.html">
							<!-- <img class="img-fluid" src="./assets/img/logo.png" width="80" alt="Cross logo">						 -->
						</a>					
					<div class="text-center">						
						<span style="font-size: 54px;font-weight: bold;color: #ccc;">&#8358;<?=$balance['balance']?></span>
						<p class="small text-muted">Current Balance</p>
					</div>

					<div class="u-login-form">
						<form class="mb-3" method="POST" action="cashout.php">
							<div class="mb-3">
								<h1 class="h2">Make Request</h1>
								<p class="small">All payments and cashout requests are attended at the end of the month with amount not less than &#8358;2000.</p>
							</div>
		                      <div class="row">
		                        <?php if(isset($success)){ ?>
		                          <div class="form-control alert alert-success fade show" role="alert">
		                            <i class="fa fa-check-circle alert-icon mr-3"></i>
		                            <span> <?php echo $success; ?></span>
		                            <button type="button" class="close" aria-label="Close" data-dismiss="alert">
		                              <span aria-hidden="true">&times;</span>
		                            </button>
		                          </div>
		                        <?php } else if(isset($errors)){ ?>
		                            <div class="form-control alert alert-danger fade show" role="alert">
		                              <!-- <i class="fa fa-minus-circle alert-icon mr-3"></i> -->
		                              <span><?php echo display_errors($errors); ?></span>
		                              <button type="button" class="close" aria-label="Close" data-dismiss="alert">
		                                <span aria-hidden="true">&times;</span>
		                              </button>
		                            </div>
		                        <?php } ?>
		                      </div> 							
							<div class="form-group mb-4">
								<label for="email">Description</label>
								<input id="email" class="form-control" name="description" type="text" placeholder="Description">
							</div>

							<div class="form-group mb-4">
								<label for="password">Amount</label>
								<input id="password" class="form-control" name="amount" type="text" placeholder="Cashout Amount">
							</div>
							<button class="btn custom-btn btn-block" type="submit" name="submit">Make Request</button>
						</form>
					</div>

					<div class="u-login-form text-muted py-3 mt-auto">
						<!-- <small><i class="far fa-question-circle mr-1"></i> If you are not able to make request, please <a href="#" style="color: #333;">contact us</a>.</small> -->
					</div>
				</div>

				<div class="col-lg-6 d-none d-lg-flex flex-column align-items-center justify-content-center bg-light">
					<img class="position-relative u-z-index-3 " src="./assets/img/cash-out.png" alt="Image description" style="width: 90%;">
<!-- 
					<figure class="u-shape u-shape--top-right u-shape--position-5">
						<img src="./assets/svg/shapes/shape-1.svg" alt="Image description">
					</figure>
					<figure class="u-shape u-shape--center-left u-shape--position-6">
						<img src="./assets/svg/shapes/shape-2.svg" alt="Image description">
					</figure>
					<figure class="u-shape u-shape--center-right u-shape--position-7">
						<img src="./assets/svg/shapes/shape-3.svg" alt="Image description">
					</figure>
					<figure class="u-shape u-shape--bottom-left u-shape--position-8">
						<img src="./assets/svg/shapes/shape-4.svg" alt="Image description">
					</figure> -->
				</div>
			</div>
		</main>
				</div>
			</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>