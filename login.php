
<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">
.mylogin-holder{
	background-color: #103344;
	box-shadow: 4px 4px 20px 0 rgba(0,0,0,0.13);
}
.mylogin{
	padding: 15px;
}	
</style>

<div class="container">
	<div class="music-page-flex pusher-3">		
		<div class="col-md-6 mylogin-holder" style="padding: 0px;">
			<form class="mylogin">
				<h4>Please Login</h4>
				<p class="share-tiny-link">Please Fill out all fields.</p>
			  <div class="form-group">
			    <label for="inputAddress">Email</label>
			    <input type="text" class="form-control custom-inputs form-pill" id="inputAddress" placeholder="Email">
			  </div>		
			  <div class="form-group">
			    <label for="inputAddress">Password</label>
			    <input type="text" class="form-control custom-inputs form-pill" id="inputAddress" placeholder="Password">
			  </div>	  
			  <br>
			  <button type="submit" class="btn btn-custom form-pill">Please Login</button>				
			</form>
			<img class="img-fluid" src="images/login-img.png">		
		</div>
	</div>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>