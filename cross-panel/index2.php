<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['AFFILIATE_ID'])) {
  permission_error('login.php');
}
if (isset($_SESSION['AFFILIATE_ID'])) {
	# code...
	$artist_id = $_SESSION['AFFILIATE_ID'];

	$bal_query = $pdo->query("SELECT * FROM aff_balancetbl WHERE account_id = $artist_id ");
	$balance = $bal_query->fetch(PDO::FETCH_ASSOC);

	$bank_query = $pdo->query("SELECT * FROM aff_banktbl WHERE account_id = $artist_id");							
	$row = $bank_query->rowcount();

	$trans_query = $pdo->query("SELECT COUNT(*) as count from  aff_transtbl WHERE account_id = $artist_id");
	$trans = $trans_query->fetch(PDO::FETCH_ASSOC);  	

}

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
							<span style="font-size: 44px;font-weight: bold;color: #ccc;">&#8358;<?=(empty($balance['balance'])?'0.00':$balance['balance'])?></span>
							<p class="small text-muted">Current Balance</p>
							<?php if(empty($row)){?>
							<a class="btn btn-sm custom-btn px-3" href="account-info.php">
								<i class="fa fa-coins mr-1"></i>Please Add Account details
							</a>
							<?php } ?>
						</div>															
					</div>
					<div class="row pusher">
						<div class="col-sm-12 col-xl-12 mb-12">
							<div class="card">
							<div class="card">
								<div class="card-body media align-items-center px-xl-3">
									<div class="media-body text-center">
										<h3 class="h3 text-muted text-uppercase mb-2">
											Total Transactions
										</h3>
										<br><i class="fas fa-drum ml-1"></i>
										<br>
										<span class="" style="font-size: 45px;"><?=$trans['count']?></span>
									</div>
								</div>
							</div>
							</div>
						</div>
					</div>
					<!-- End Doughnut Chart -->
								
<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>