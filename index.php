<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>

<div class="home-container">
	<div class="container"> 
		<div class="row">
			<div class="col-12 pusher-2 home-text-intro">
				<div class="">
					<h1>Welcome to Crossmusic</h1>
					<p>Choose your preferencial below to get started</p>					
				</div>
			</div>
		</div>	 
		<div class="row row-pref">
			<div class="col-12 push">
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="paid category">
					<div class="pref-text">
						<p>Get paid <br> music</p>
					</div>
					<div class="pref-icons">
						<i class="fa fa-shopping-cart fa-2x"></i>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="free category">
					<div class="pref-text">
						<p>Get free <br> music</p>
					</div>					
					<div class="pref-icons">
						<i class="fa fa-cloud-download fa-2x"></i>
					</div>
				</div>
			</div>		
		</div>
		<div class="row">
			<div class="payment-flex col-md-12 pusher-3">
				<!-- <p>Get free <br> music</p> -->
				<img class="actions-img" src="images/cross-payment-2.png">
			</div>
		</div>
	</div>	
</div>

<?php
  // include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>