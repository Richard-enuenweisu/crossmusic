<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">
.music{
	-webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
	transition: opacity 0.35s, transform 0.35s;
	-webkit-transform: scale(1.12);
	transform: scale(1.06);	
	/*overflow: hidden;*/
}
.music:hover{
	opacity: 0.8;
	-webkit-transform: scale(1);
	transform: scale(1);	
}
.	
</style>
<div class="">
	<div class="container"> 
		<div class="row">
			<div class="col-12 pusher-3 home-text-intro">
				<div class="text-center">
					<h1>Sell and promote your music</h1>
					<p>You can browse, listen, buy or download your next favourite song. Choose your preferencial below to get started</p>					
				</div>
			</div>
		</div>	
		<div class="row push">
		  <div class="col-md-4 col-sm-4 push">
		  	<a href="paidmusic">
		    <div class="card music text-center" style="background-color: #0d2b3c; border-right: 0px; min-height: 310px">
		    	<center><img src="images/home3.png" style="width: 60%;padding-top: 15px;"></center>
		      <div class="card-body">
		        <h3 class="card-title"><i class="fa fa-shopping-cart"></i> Cross Business</h3>
		        <p class="card-text">Get a paid music</p>
		        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->		        
		      </div>
		    </div>
		    </a>
		  </div>
		  <div class="col-md-4 col-sm-4 push">
		    <div class="card text-center" style="background-color: #052d4a; border-right: 0px; min-height: 310px">		    	
		      <div class="card-body d-flex flex-column align-items-center justify-content-center">
		        <p class="card-text">Join +1000 affiliates generating revenue from Crossmusic today. You get whopping 10% commission on each successful sales.</p>
		        <a href="affiliate" class="btn btn-primary">Affiliate Marketer</a>
				<!-- <i class="fa fa-cloud-download fa-2x float-right"></i> -->
		      </div>
		    </div>
		  </div>   
		  <div class="col-md-4 col-sm-4 push">
		  	<a href="freemusic">
		    <div class="card music text-center" style="background-color: #0d2b3c; border-right: 0px; min-height: 310px">
		    	<center><img src="images/home4.png" style="width: 60%;padding-top: 15px;"></center> 		    	
		      <div class="card-body">
		        <h3 class="card-title"><i class="fa fa-cloud-download "></i> Cross Free</h3>
		        <p class="card-text">Get a Free music</p>
		        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
		      </div>
		    </div>
		    </a>
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
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>