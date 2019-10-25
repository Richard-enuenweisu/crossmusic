
<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">
.mylogin-holder{
	background-color: #103344;
	box-shadow: 4px 4px 20px 0 rgba(0,0,0,0.13);
	text-align: center;
}
.mylogin{
	padding: 15px;
}
.fa-whatsapp{
	font-size: 120px;
	margin-bottom: 30px;
	color: #68FA82;
}
</style>

<div class="container">
	<div class="music-page-flex pusher-3">		
		<div class="col-md-6 mylogin-holder" style="padding: 0px;">
			<div class="push">
				<h2>Contact us</h2>
					<p>Reach us directly with our office number or file a complain to us via whatsApp</p>	
					<h4>Reach us on:</h4>		
					<h6><i class="fa fa-mobile-phone fa-2x"></i> +2349015952595</h6>	
					<h6><i class="fa fa-mobile-phone fa-2x"></i> +2348060771255</h6> 
					<h4>Make a complain via whatsApp</h4>		
					<a onclick="window.open(this.href,'_blank');return false;" href="https://wa.me/2348060771255" target="blank"><i class="fa fa-whatsapp fa-4x"></i></a>	 				 
				  <br>
				<img class="img-fluid" src="images/contact.png">				
			</div>		
		</div>
	</div>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>