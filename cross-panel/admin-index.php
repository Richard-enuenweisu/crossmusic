<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ADMIN_ID'])) {
  permission_error('admin-login.php');
}

$album_query = $pdo->query("SELECT COUNT(*) as count from  albumstbl ");							
$single_query = $pdo->query("SELECT COUNT(*) as count from  singlestbl");
$tracks_query = $pdo->query("SELECT COUNT(*) as count from  trackstbl");
$account_query = $pdo->query("SELECT COUNT(*) as count from  accounttbl");
$free_query = $pdo->query("SELECT COUNT(*) as count from  accounttbl WHERE acct_type = 'Free Account'");
$paid_query = $pdo->query("SELECT COUNT(*) as count from  accounttbl WHERE acct_type = 'Paid Account'");
$aff_query = $pdo->query("SELECT COUNT(*) as count from  aff_accounttbl");
$users_query = $pdo->query("SELECT COUNT(*) as count from  usertbl");
$orders_query = $pdo->query("SELECT COUNT(*) as count from  orderstbl");

$albums = $album_query->fetch(PDO::FETCH_ASSOC);  							
$singles = $single_query->fetch(PDO::FETCH_ASSOC); 
$tracks = $tracks_query->fetch(PDO::FETCH_ASSOC);  							
$account = $account_query->fetch(PDO::FETCH_ASSOC); 
$free = $free_query->fetch(PDO::FETCH_ASSOC);  							
$paid = $paid_query->fetch(PDO::FETCH_ASSOC); 
$aff = $aff_query->fetch(PDO::FETCH_ASSOC);  							
$users = $users_query->fetch(PDO::FETCH_ASSOC); 
$orders = $orders_query->fetch(PDO::FETCH_ASSOC); 

  include str_replace("\\","/",dirname(__FILE__).'/assets/include/header.php');
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/headbar.php');
?>

	<main class="u-main" role="main">
			<!-- Sidebar -->
		<?php
		  include str_replace("\\","/",dirname(__FILE__).'/assets/include/nav.php');
		?>			
			<!-- End Sidebar -->
			<div class="u-content">
				<div class="u-body">					
					  <div class="row">
						<!-- Success -->
<!-- 						<div class="form-control alert custom-alert-success fade show" role="alert">
							<i class="fa fa-check-circle alert-icon mr-3"></i>
							<span>Your security is our optimim priority, please ensure your informations are safe!.</span>
							<button type="button" class="close" aria-label="Close" data-dismiss="alert">
								<span aria-hidden="true">&times;</span>
							</button>
						</div> -->
						<!-- End Success -->				  	       
					  </div>					
					<div class="row push bg-light">
						<div class="col-md-4 border-md-right border-light">
							<center><img src="assets/img/logo.png" style="width: 30%;"></center>
						</div>
						<div class="col-md-8">														    						
							<h1>Welcome Administrator</h1>
							<p>Be sure to act carefully with informations here, you are in charge.</p>
						</div>															
					</div>
					<div class="row pusher">
						<div class="col-sm-4 col-xl-4 mb-4">
							<div class="card">
								<div class="card-body media align-items-center px-xl-3">
									<div class="media-body text-center">
										<h3 class="h3 text-muted text-uppercase mb-2">
											Total Albums 
										</h3>
										<br><i class="fas fa-drum ml-1"></i>
										<br>
										<span class="" style="font-size: 45px;"><?=$albums['count']?></span>
									</div>
								</div>
							</div>
						</div>						
						<div class="col-sm-4 col-xl-4 mb-4">
							<div class="card">
							<div class="card">
								<div class="card-body media align-items-center px-xl-3">
									<div class="media-body text-center">
										<h3 class="h3 text-muted text-uppercase mb-2">
											Total Singles
										</h3>
										<br><i class="fas fa-drum ml-1"></i>
										<br>
										<span class="" style="font-size: 45px;"><?=$singles['count']?></span>
									</div>
								</div>
							</div>
							</div>
						</div>
						<div class="col-sm-4 col-xl-4 mb-4">
							<div class="card">
							<div class="card">
								<div class="card-body media align-items-center px-xl-3">
									<div class="media-body text-center">
										<h3 class="h3 text-muted text-uppercase mb-2">
											Total Tracks
										</h3>
										<br><i class="fas fa-drum ml-1"></i>
										<br>
										<span class="" style="font-size: 45px;"><?=$tracks['count']?></span>
									</div>
								</div>
							</div>
							</div>
						</div>	
					</div>
						<!-- more columns	 -->
					<div class="row">
						<div class="col-sm-4 col-xl-4 mb-4">
							<div class="card">
								<div class="card-body media align-items-center px-xl-3">
									<div class="media-body text-center">
										<h3 class="h3 text-muted text-uppercase mb-2">
											Total Accounts 
										</h3>
										<br><i class="fas fa-drum ml-1"></i>
										<br>
										<span class="" style="font-size: 45px;"><?=$account['count']?></span>
									</div>
								</div>
							</div>
						</div>						
						<div class="col-sm-4 col-xl-4 mb-4">
							<div class="card">
							<div class="card">
								<div class="card-body media align-items-center px-xl-3">
									<div class="media-body text-center">
										<h3 class="h3 text-muted text-uppercase mb-2">
											Total Free Accounts
										</h3>
										<br><i class="fas fa-drum ml-1"></i>
										<br>
										<span class="" style="font-size: 45px;"><?=$free['count']?></span>
									</div>
								</div>
							</div>
							</div>
						</div>
						<div class="col-sm-4 col-xl-4 mb-4">
							<div class="card">
							<div class="card">
								<div class="card-body media align-items-center px-xl-3">
									<div class="media-body text-center">
										<h3 class="h3 text-muted text-uppercase mb-2">
											Total Paid Accounts
										</h3>
										<br><i class="fas fa-drum ml-1"></i>
										<br>
										<span class="" style="font-size: 45px;"><?=$paid['count']?></span>
									</div>
								</div>
							</div>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-sm-4 col-xl-4 mb-4">
							<div class="card">
								<div class="card-body media align-items-center px-xl-3">
									<div class="media-body text-center">
										<h3 class="h3 text-muted text-uppercase mb-2">
											Total Affiliates 
										</h3>
										<br><i class="fas fa-drum ml-1"></i>
										<br>
										<span class="" style="font-size: 45px;"><?=$aff['count']?></span>
									</div>
								</div>
							</div>
						</div>						
						<div class="col-sm-4 col-xl-4 mb-4">
							<div class="card">
							<div class="card">
								<div class="card-body media align-items-center px-xl-3">
									<div class="media-body text-center">
										<h3 class="h3 text-muted text-uppercase mb-2">
											Total Users
										</h3>
										<br><i class="fas fa-drum ml-1"></i>
										<br>
										<span class="" style="font-size: 45px;"><?=$users['count']?></span>
									</div>
								</div>
							</div>
							</div>
						</div>
						<div class="col-sm-4 col-xl-4 mb-4">
							<div class="card">
							<div class="card">
								<div class="card-body media align-items-center px-xl-3">
									<div class="media-body text-center">
										<h3 class="h3 text-muted text-uppercase mb-2">
											Total Purchased
										</h3>
										<br><i class="fas fa-drum ml-1"></i>
										<br>
										<span class="" style="font-size: 45px;"><?=$orders['count']?></span>
									</div>
								</div>
							</div>
							</div>
						</div>

					</div>					
					<!-- End Doughnut Chart -->
				</div>
			</div>					
								
<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>