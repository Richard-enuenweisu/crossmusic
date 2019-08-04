<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ARTIST_ID'])) {
  permission_error('login.php');
}
if (isset($_SESSION['ARTIST_ID'])) {
	# code...
	$artist_id = $_SESSION['ARTIST_ID'];

	$stmt = $pdo->query("SELECT * FROM accounttbl INNER JOIN artisttbl ON accounttbl.id = artisttbl.account_id 
	WHERE accounttbl.id =$artist_id");
	$acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$acct_type = $acc_result['acct_type'];
	$bal_query = $pdo->query("SELECT * FROM artist_balancetbl WHERE account_id = $artist_id ");
	$balance = $bal_query->fetch(PDO::FETCH_ASSOC);

	$bank_query = $pdo->query("SELECT * FROM banktbl WHERE account_id = $artist_id");							
	$row = $bank_query->rowcount();

	$album_query = $pdo->query("SELECT COUNT(*) as count from  albumstbl WHERE account_id = $artist_id");							
	$single_query = $pdo->query("SELECT COUNT(*) as count from  singlestbl WHERE acount_id = $artist_id");

	$albums = $album_query->fetch(PDO::FETCH_ASSOC);  							
	$singles = $single_query->fetch(PDO::FETCH_ASSOC);  							

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
						<?php if($acct_type == 'Paid Account'){?>
						<div class="col-md-8">														    						
							<span style="font-size: 54px;font-weight: bold;color: #ccc;">&#8358;<?=$balance['balance']?></span>
							<p class="small text-muted">Current Balance</p>
							<?php if(empty($row)){?>
							<a class="btn btn-sm custom-btn px-3" href="account-info.php">
								<i class="fa fa-coins mr-1"></i>Please Add Account details
							</a>
							<?php } ?>
						</div>								
						<?php } else{ ?>
						<div class="col-md-8">																    
						    <h1>Migrate to paid account</h1>
							<p class="">
							Join the +2000 artiste generating revenue from Crossmusic today.
							</p>
							<a class="btn btn-sm btn-danger px-3" href="migrate.php">
								<i class="fas fa-shekel-sign mr-1"></i>Migrate to Paid Account
							</a>
						</div>
						<?php } ?>							
					</div>
					<div class="row pusher">
						<div class="col-sm-6 col-xl-6 mb-6">
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

						<div class="col-sm-6 col-xl-6 mb-6">
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
					</div>
					<!-- End Doughnut Chart -->
								
<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>