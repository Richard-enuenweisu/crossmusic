<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ARTIST_ID'])) {
  permission_error('login.php');
}else{
	$artist_id = $_SESSION['ARTIST_ID'];
	// var_dump($artist_id);
	$stmt = $pdo->query("SELECT * FROM accounttbl INNER JOIN artisttbl ON accounttbl.id = artisttbl.account_id 
		WHERE accounttbl.id =$artist_id");
	$acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$acct_type = $acc_result['acct_type'];		
}

if (isset($_POST['submit'])) {
  # code...
	$opassword = ((isset($_POST['npassword']))?sanitize($_POST['npassword']): '');
	$npassword = ((isset($_POST['npassword']))?sanitize($_POST['npassword']): '');
	$cpassword = ((isset($_POST['cpassword']))?sanitize($_POST['cpassword']): '');
	$errors = array();
	if (empty($opassword) || empty($npassword) || empty($cpassword)) {
	$errors[].= 'Some fields are empty'.'<br>';
	}
	if ($npassword != $cpassword) {
		# code...
	$errors[].='Password mismatch!'.'<br>';	
	}
	$salted = 'Z%yHrcR8QDhF99CC^ZZ9qe!+k'.$npassword.'f+KA??dj7$S$HL4guq$yJ5_3b';
	$hashed = hash('sha224', $salted);

	if (empty($errors)) {
	$stmt = $pdo->prepare("UPDATE artisttbl SET `password` = :npassword WHERE account_id =:acc_id");
	$stmt->execute([':npassword' => $hashed, ':acc_id'=>$artist_id]); 
	$success = 'Password Changed Successfully! '.'<br>';
	// artistLogin($u_id);
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
	.pro-s{
	font-size: 18px;font-style: italic;font-weight: bold		
	}
</style>
			<div class="u-content">
				<div class="u-body">
					<h1 class="h2 font-weight-semibold mb-4">Profile</h1>

					<div class="card mb-4">
						<div class="card-body">
							<div class="row">
								<div class="col-md-4 border-md-right border-light text-center">
									<img class="img-fluid rounded-circle mb-3" src="./assets/img/avatars/img1.jpg" alt="Image description" width="84">

									<h2 class="mb-2"><?=$acc_result['fname'];?> <?=$acc_result['lname'];?></h2>
									<h5 class="text-muted mb-4"> <?=$acc_result['email'];?></h5>
<!-- 									<ul class="list-inline mb-4">
										<li class="list-inline-item mr-3">
											<a class="link-muted" href="#!">
												<i class="fab fa-facebook"></i>
											</a>
										</li>
										<li class="list-inline-item mr-3">
											<a class="link-muted" href="#!">
												<i class="fab fa-twitter"></i>
											</a>
										</li>
										<li class="list-inline-item mr-3">
											<a class="link-muted" href="#!">
												<i class="fab fa-slack"></i>
											</a>
										</li>
										<li class="list-inline-item">
											<a class="link-muted" href="#!">
												<i class="fab fa-linkedin-in"></i>
											</a>
										</li>
									</ul>
									<div class="mb-3">
										<a class="btn custom-btn mb-2" href="#!">Follow Me</a>
									</div>
 -->
									<a class="link-muted" href="mailto://<?=$acc_result['email'];?>">
										<i class="fa fa-envelope mr-2"></i> Send Message
									</a>
								</div>

								<div class="col-md-8 pusher">
									<?php if($acct_type == 'Free Account'){ ?>
									<div class="form-group mb-4">
										<a class="btn btn-sm btn-danger px-3 " href="migrate.php">
											<i class="fas fa-shekel-sign mr-1"></i>Migrate to Paid Account
										</a>
									</div>										
									<?php } ?>									
									<div>
										<span for="email">Company name</span>
										<p class="pro-s"><?=$acc_result['company_name'];?></p>

										<span for="email">First name</span>
										<p class="pro-s"><?=$acc_result['fname'];?></p>

										<span for="email">Last name</span>
										<p class="pro-s"><?=$acc_result['lname'];?></p>	

										<span for="email">Phone</span>
										<p class="pro-s"><?=$acc_result['phone'];?></p>

										<span for="email">Accout Type</span>
										<p class="pro-s"><?=$acc_result['acct_type'];?></p>													
									</div>
									<hr>
									<form action="profile.php" method="POST" class="push">										
										<h3>Change Account Password</h3>
<!-- 										<div class="" style="background-color: #0b243517;padding: 10px;">
											Errors shows here.
										</div> -->
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
										<div class="form-group mb-4 push">
											<label for="email">Old password</label>
											<input id="email" class="form-control " name="opassword" type="password" placeholder="Old password" value="<?=((isset($opassword))?$opassword:'');?>">
										</div>	
										<div class="form-group mb-4">
											<label for="email">New password</label>
											<input id="email" class="form-control" name="npassword" type="password" placeholder="New password" value="<?=((isset($npassword))?$npassword:'');?>">
										</div>																		
										<div class="form-group mb-4 push">
											<label for="email">Confirm new password</label>
											<input id="email" class="form-control" name="cpassword" type="password" placeholder="Confirm new password" value="<?=((isset($cpassword))?$cpassword:'');?>">
										</div>	
										<button class="btn custom-btn " type="submit" name="submit">Change Password</button>			
									</form>

									<div class="row">
									<!-- 	<div class="col-lg-4 mb-5 mb-lg-0">
											<h4 class="h3 mb-3">Profile Rating</h4>
											<div class="mb-1">
												<span class="font-size-44 text-dark">4.8</span>
												<span class="h1 font-weight-light text-muted">/ 5.0</span>
											</div>
											<p class="text-muted mb-0">245 Reviews</p>
										</div> -->

										<!-- <div class="col-lg-8">
											<h4 class="h3 mb-3">Skills</h4>

											<div class="d-flex flex-wrap align-items-center">
												<span class="bg-light text-muted rounded py-2 px-3 mb-2 mr-2">Tag</span>
												<span class="bg-light text-muted rounded py-2 px-3 mb-2 mr-2">Web Design</span>
												<span class="bg-light text-muted rounded py-2 px-3 mb-2 mr-2">HTML5</span>
												<span class="bg-light text-muted rounded py-2 px-3 mb-2 mr-2">CSS</span>
												<span class="bg-light text-muted rounded py-2 px-3 mb-2 mr-2">Marketing</span>
												<span class="bg-light text-muted rounded py-2 px-3 mb-2 mr-2">JavaScript</span>
											</div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>