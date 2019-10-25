<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<div class="home-container">
	<div class="container"> 
		<div class="row">
			<div class="col-12 pusher-3 home-text-intro">
				<div class="text-center">
					<h1>Sell and promote your music</h1>
					<p>You can browse, listen, buy or download your next favourite song. Choose your preferencial below to get started</p>					
				</div>
			</div>
		</div>	 
		<div class="row row-pref">
			<div class="col-12 push">
			</div>
			<div class="col-md-6 col-sm-6">
				<a href="paidmusic.php">
					<div class="paid category">
						<div class="pref-text">
							<p>Get paid <br> music</p>
						</div>
						<div class="pref-icons">
							<i class="fa fa-shopping-cart fa-2x"></i>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6 col-sm-6">
				<a href="freemusic.php">
					<div class="free category">
						<div class="pref-text">
							<p>Get free <br> music</p>
						</div>					
						<div class="pref-icons">
							<i class="fa fa-cloud-download fa-2x"></i>
						</div>
					</div>
				</a>
			</div>		
		</div>		
		<div class="row">
			<div class="payment-flex col-md-12 pusher-2">
				<!-- <p>Get free <br> music</p> -->
				<img class="actions-img" src="images/cross-payment-2.png">
			</div>
		</div>
		<div class="row">
			<?php if(isset($_GET['expire']) && $_GET['expire'] == 'true'){ ?>
				<script type="text/javascript">
				$( document ).ready(function() {
				   $('.toast').toast('show');
				});	
				</script>
				<style type="text/css">
					.toast{
						background-color: #eee !important;
						border: none !important;
						color: #0b2435;
					}
					.toast-header{
						background-color: #ffffff;
					}
				</style>	
				<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000" style="position: absolute;top: 10px;right: 10px;z-index: 999999999999999">
				  <div class="toast-header">
				    <img src="images/logo.png" width="40" height="" class="rounded mr-2" alt="...">
				    <strong class="mr-auto">Crossmusic</strong>
				    <small>...</small>
				    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
				      <span aria-hidden="true">&times;</span>
				    </button>
				  </div>
				  <div class="toast-body">
				    The link has expired, or is no longer available on this server.
				  </div>
				</div>	
			<?php }  ?>
			<?php if(isset($_GET['login']) && $_GET['login'] == 'true'){ ?>
				<script type="text/javascript">
				$( document ).ready(function() {
				   $('.toast').toast('show');
				});	
				</script>
				<style type="text/css">
					.toast{
						background-color: #eee !important;
						border: none !important;
						color: #0b2435;
					}
					.toast-header{
						background-color: #ffffff;
					}
				</style>	
				<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000" style="position: absolute;top: 10px;right: 10px;z-index: 999999999999999">
				  <div class="toast-header">
				    <img src="images/logo.png" width="40" height="" class="rounded mr-2" alt="...">
				    <strong class="mr-auto">Crossmusic</strong>
				    <small>...</small>
				    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
				      <span aria-hidden="true">&times;</span>
				    </button>
				  </div>
				  <div class="toast-body">
				    Welcome, your are now logged in.
				  </div>
				</div>	
			<?php }  ?>			
		</div>
	</div>	
</div>

<?php
  // include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>