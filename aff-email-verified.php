<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_GET['ref'])) {
	header('Location: affiliate.php');
}
else{
	$ref = $_GET['ref'];
}
if (!isset($_COOKIE['cookieVerif'])) {
	header('Location: index.php?expire=true');
}
if (isset($_COOKIE['cookieVerif'])) {
	$link =  $_COOKIE['cookieVerif']['link'];
}
if ($ref != $link) {
	header('Location: index.php?expire=true');
}
else{
	    if (isset($_COOKIE['cookieAff'])) {
			$fname = $_COOKIE['cookieAff']['fname'];
			$lname = $_COOKIE['cookieAff']['lname'];
			$email = $_COOKIE['cookieAff']['email'];
      $phone = $_COOKIE['cookieAff']['phone'];
			$password = $_COOKIE['cookieAff']['password'];

      $stmt = $pdo->prepare('SELECT * FROM aff_userstbl WHERE email = ?');
      $stmt->execute([$email]);
      $row = $stmt->rowcount();
			// $result =$stmt->fetch(PDO::FETCH_ASSOC);
			if (empty($row)) {
        //insert free account into DB
            $insert_query1 = $pdo->prepare("INSERT INTO aff_accounttbl (`fname`, `lname`, `phone`) VALUES (:fname, :lname, :phone)");
            $insert_query1->execute([':fname' =>$fname, ':lname'=>$lname, ':phone'=>$phone]);    
            $acc_id = $pdo->lastInsertId(); 

              //insert into artisttbl
            $insert_query2 = $pdo->prepare("INSERT INTO aff_userstbl (`account_id`, `email`, `password`) VALUES (:acc_id, :email, :password)");
            $insert_query2->execute([':acc_id' =>$acc_id, ':email' =>$email, ':password'=>$password]); 
            //automatic Artist login
           affiliateLogin($acc_id);
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
		        <p>Thank you for verifying your email. Welcome to the number gospel music viral affiliate marketing scheme.
            </p>  
            <h4>You will be logged in automatically.</h4>    
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