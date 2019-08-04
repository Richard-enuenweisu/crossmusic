<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_GET['ref'])) {
	header('Location: account.php');
}
else{
	$ref = $_GET['ref'];
}
if (!isset($_COOKIE['cookieLink'])) {
	header('Location: index.php?expire=true');
}
if (isset($_COOKIE['cookieLink'])) {
	$link =  $_COOKIE['cookieLink']['link'];
}
if ($ref != $link) {
	header('Location: index.php?expire=true');
}
else{

	    if (isset($_COOKIE['cookieData'])) {
			$cname = $_COOKIE['cookieData']['cname'];
			$fname = $_COOKIE['cookieData']['fname'];
			$lname = $_COOKIE['cookieData']['lname'];
			$email = $_COOKIE['cookieData']['email'];
			$phone = $_COOKIE['cookieData']['phone'];
			$acc_type = $_COOKIE['cookieData']['acc_type'];
			$password = $_COOKIE['cookieData']['password'];
			$terms = $_COOKIE['cookieData']['terms'];
			$price = $_COOKIE['cookieData']['price'];

			$stmt = $pdo->prepare('SELECT * FROM artisttbl WHERE email = ? ');
			$stmt->execute([$email]);
			$row = $stmt->rowcount();
			echo 'this is the value'.$row;
			// $result =$stmt->fetch(PDO::FETCH_ASSOC);
			if (empty($row) && $acc_type == 'Free Account') {
				//insert free account into DB
          	$insert_query1 = $pdo->prepare("INSERT INTO accounttbl (`company_name`, `fname`, `lname`, `phone`, `acct_type`) VALUES (:cname, :fname, :lname, :phone, :acct_type)");
            $insert_query1->execute([':cname' =>$cname, ':fname' =>$fname, ':lname'=>$lname, ':phone'=>$phone, ':acct_type'=>$acc_type]);    
            $acc_id = $pdo->lastInsertId(); 

            	//insert into artisttbl
          	$insert_query2 = $pdo->prepare("INSERT INTO artisttbl (`account_id`, `email`, `password`) VALUES (:acc_id, :email, :password)");
            $insert_query2->execute([':acc_id' =>$acc_id, ':email' =>$email, ':password'=>$password]); 
            //automatic Artist login
  			artistLogin($acc_id);
  			}
	    } 
}
if (isset($_POST['paynow'])) {
  # code...
    //paystack standard
    $curl = curl_init();
    // $email = "your@email.com";
    // $amount = 30000;  //the amount in kobo. This value is actually NGN 300
    // url to go to after payment
    $callback_url = 'callback.php';  
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode([
        'amount'=>$amount * 100,
        'email'=>$email,
        'callback_url' => $callback_url
      ]),
      CURLOPT_HTTPHEADER => [
        "authorization: Bearer sk_test_5f94dfdac4c43b80d16f4cb0b844123d1cfed4af", //replace this with your own test key
        "content-type: application/json",
        "cache-control: no-cache"
      ],
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    if($err){
      // there was an error contacting the Paystack API
      die('Curl returned error: ' . $err);
    }
    $tranx = json_decode($response, true);

    if(!$tranx->status){
      // there was an error from the API
      print_r('API returned error: ' . $tranx['message']);
    }
    // comment out this line if you want to redirect the user to the payment page
    print_r($tranx);
    // redirect to page so User can pay
    // uncomment this line to allow the user redirect to the payment page
    header('Location: ' . $tranx['data']['authorization_url'])  
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