<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_GET['ref'])) {
	header('Location: account.php');
}
else{
	$ref = $_GET['ref'];
}
if (!isset($_COOKIE['cookieUlink'])) {
	header('Location: index.php?expire=true');
}
if (isset($_COOKIE['cookieUlink'])) {
	$link =  $_COOKIE['cookieUlink']['link'];
}
if ($ref != $link) {
	header('Location: index.php?expire=true');
}
else{

	    if (isset($_COOKIE['cookieUser'])) {
			$fname = $_COOKIE['cookieUser']['fname'];
			$lname = $_COOKIE['cookieUser']['lname'];
			$email = $_COOKIE['cookieUser']['email'];
			$password = $_COOKIE['cookieUser']['password'];

      $stmt = $pdo->prepare('SELECT * FROM usertbl WHERE email = ?');
      $stmt->execute([$email]);
      $row = $stmt->rowcount();
			// $result =$stmt->fetch(PDO::FETCH_ASSOC);

			if (empty($row)) {
				//insert free account into DB
          	$insert_query1 = $pdo->prepare("INSERT INTO usertbl (`fname`, `lname`, `email`, `password`) 
              VALUES (:fname, :lname, :email, :password)");
            $insert_query1->execute([':fname' =>$fname, ':lname'=>$lname, ':email'=>$email, ':password'=>$password]);    
            $user_id = $pdo->lastInsertId();   

            //automatic Artist login
  			   login($user_id);
  			}
	    } 
}

	    // if (isset($_COOKIE['cookieLink'])) {
	    //     foreach ($_COOKIE['cookieLink'] as $name => $value) {
	    //         $name = $name;
	    //         $value = $value;
	    //         echo "$name : $value <br />\n";
	    //     }
	    // }
	    // if (isset($_COOKIE['cookieData'])) {
	    //     foreach ($_COOKIE['cookieData'] as $name => $value) {
	    //         $name = $name;
	    //         $value = $value;
	    //         echo "$name : $value <br />\n";
	    //     }
	    // } 	    

  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">

#custom-search-input .search-query{
  /*background-color: #2f3238 !important;*/
}
  /*login form*/
.flex-form{
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  color: #ccc;
}
.success-box-bg{
  /*background-color: #280a2f;*/
  /*background-image: url('images/6.jpg');*/
  /*background-size: cover;*/
  /*background-repeat: no-repeat;*/
  /*background-color: #000;*/
  /*background-blend-mode: overlay;  */
  min-height: 100vh;
}
.box-holder{
  background-color:#000000a8;
  padding:20px 15px 20px 15px;
  color:#fff;
  margin-bottom: 15px;  
}
</style>




<div class="container-fluid success-box-bg">
  <div class="row flex-form">
    <div class=" col-md-6 pusher-2" >       
      <div class="row text-center pusher">
        <div class="col-md-12">
          <div class="box-holder">
          	<img src="images/logo.png" width="120px" height="120px">
            <h2>Email Verified Successfully!</h2>
			<p>Thank you for verifying your email. Welcome to the number gospel music platform which exclusively offers a free and paid options for every artiste in Naija.
            </p>      
            <?php if(isset($acc_type) && $acc_type ='Free Account'){ ?>      
            <!-- <a class="btn btn-custom form-pill" href="http://localhost/cross/cross-panel/login.php">Please Login</a> -->
            <h4>You will be logged in automatically.</h4>
        	<?php }else {?>
			<form method="POST" action="email-verified.php">
			  <!-- <script src="https://js.paystack.co/v1/inline.js"></script> -->
			  <button type="submit" class="btn btn-success" name="paynow">
			   Click here to continue </button> 
			</form>  
			<?php } ?>
          </div>
        </div>         
      </div>   
    </div>
  </div>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/paystack.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>