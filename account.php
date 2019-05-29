
<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>

<div class="container">
	<div class="row pusher-3">
		<div class="col-md-12 price-header">
	        <h1>Create your account. Get going.</h1>
	        <p>
	        crossmusic profer a much more simpler way to sell your music and get you going. With our free account platform you get unlimited singles uplaods and people can freely download your songs. while our business account comes with a price and gives you unlimited singles and albums uploads.
	        <br>
	        <img class="img-fluid d-block d-" src="images/step.png">
			</p>			
		</div>
	</div>		
	<form class="pusher">
		<h4>Account information</h4>
		<p class="share-tiny-link">Please Fill out all fields.</p>
	  <div class="form-group">
	    <label for="inputAddress">Comapany Name</label>
	    <input type="text" class="form-control custom-inputs form-pill" id="inputAddress" placeholder="Comapany Name">
	  </div>		
	  <div class="form-row">	  	
	    <div class="form-group col-md-6">
	      <label for="inputEmail4">First Name</label>
	      <input type="email" class="form-control custom-inputs form-pill" id="inputEmail4" placeholder="First Name">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inputPassword4">Last Name</label>
	      <input type="password" class="form-control custom-inputs form-pill" id="inputPassword4" placeholder="Last Name">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="inputAddress">Phone</label>
	    <input type="text" class="form-control custom-inputs form-pill" id="inputAddress" placeholder="Phone Number">
	  </div>	  
	  <div class="form-group">
	    <label for="inputAddress">Email</label>
	    <input type="text" class="form-control custom-inputs form-pill" id="inputAddress" placeholder="Comapany Name">
	  </div>	  
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inputEmail4">Password</label>
	      <input type="email" class="form-control custom-inputs form-pill" id="inputEmail4" placeholder="Email">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inputPassword4">Confirm Password</label>
	      <input type="password" class="form-control custom-inputs form-pill" id="inputPassword4" placeholder="Password">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="inputAddress">Address</label>
	    <input type="text" class="form-control custom-inputs form-pill" id="inputAddress" placeholder="1234 Main St">
	  </div>
	  <div class="form-group">
	    <label for="inputAddress2">Address 2</label>
	    <input type="text" class="form-control custom-inputs form-pill" id="inputAddress2" placeholder="Apartment, studio, or floor">
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inputCity">City</label>
	      <input type="text" class="form-control custom-inputs form-pill" id="inputCity">
	    </div>
	    <div class="form-group col-md-4">
	      <label for="inputState">State</label>
	      <select id="inputState" class="form-control custom-inputs form-pill">
	        <option selected>Choose...</option>
	        <option>...</option>
	      </select>
	    </div>
	    <div class="form-group col-md-2">
	      <label for="inputZip">Zip</label>
	      <input type="text" class="form-control custom-inputs form-pill" id="inputZip">
	    </div>
	  </div>
	  <div class="custom-control custom-checkbox my-1 mr-sm-2">
	    <input type="checkbox" class="custom-control-input" id="customControlInline">
	    <label class="custom-control-label" for="customControlInline">Agree to terms and conditions</label>
	  </div>
	  <br>
	  <button type="submit" class="btn btn-custom form-pill">Please create Account</button>
	</form>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>