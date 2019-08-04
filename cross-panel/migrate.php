<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ARTIST_ID'])) {
  permission_error('login.php');
}

  include str_replace("\\","/",dirname(__FILE__).'/assets/include/header.php');
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/headbar.php');
?>
<style type="text/css">
	.pro-s{
	font-size: 18px;font-style: italic;font-weight: bold		
	}
</style>
	<main class="u-main" role="main">
			<!-- Sidebar -->
		<?php
		  include str_replace("\\","/",dirname(__FILE__).'/assets/include/nav.php');
		?>	
			<div class="u-content">
				<div class="u-body">
					<h1 class="h2 font-weight-semibold mb-4">Migrate Account</h1>
					<div class="card mb-4">
						<div class="card-body">							
							<div class="row push">
								<div class="col-md-4 border-md-right border-light">
									<center><img src="assets/img/migrate-img.png" style="width: 90%;"></center>
								</div>
								<div class="col-md-8">																    
								    <h1>Migrating to paid account?</h1>
									<p class="">
									Join the +2000 artiste generating revenue from Crossmusic today. crossmusic profer a much more simpler way to sell your music and get you going. With our Paid Account platform you get 80% of each purchased song with a yearly subscription of &#8358;10,000.00
									</p>
									<a class="btn btn-sm btn-danger px-3" href="#">
										<i class="fas fa-shekel-sign mr-1"></i>Migrate to Paid Account
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>