
<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');


  $curl = curl_init();
  $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
  if(!$reference){
    // die('No reference supplied');
    header('Location: index.php');
  }
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
}

$expire_date =  date_create('+364 day')->format('Y-m-d H:i:s'); 

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
      "accept: application/json",
      "authorization: Bearer sk_test_5f94dfdac4c43b80d16f4cb0b844123d1cfed4af",
      "cache-control: no-cache"
    ],
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  if($err){
      // there was an error contacting the Paystack API
    die('Crossmusic returned an error: <i>'. $err.'</i>');
  }

  $tranx = json_decode($response);

  if(!$tranx->status){
    // there was an error from the API
    // die('API returned error: ' . $tranx->message);
  }

  if('success' == $tranx->data->status){
    // transaction was successful...

		// $result =$stmt->fetch(PDO::FETCH_ASSOC);
		if (empty($row) && $acc_type == 'Paid Account') {
			//insert free account into DB
	  	$insert_query1 = $pdo->prepare("INSERT INTO accounttbl (`company_name`, `fname`, `lname`, `phone`, `acct_type`) VALUES (:cname, :fname, :lname, :phone, :acct_type)");
	    $insert_query1->execute([':cname' =>$cname, ':fname' =>$fname, ':lname'=>$lname, ':phone'=>$phone, ':acct_type'=>$acc_type]);    
	    $acc_id = $pdo->lastInsertId(); 

	    //insert into artisttbl
	  	$insert_query2 = $pdo->prepare("INSERT INTO artisttbl (`account_id`, `email`, `password`) VALUES (:acc_id, :email, :password)");
	    $insert_query2->execute([':acc_id' =>$acc_id, ':email' =>$email, ':password'=>$password]); 

	    //insert into artisttbl
	  	$insert_query3 = $pdo->prepare("INSERT INTO paymenttbl (`account_id`, `price`, `reference`, `expire_date`) VALUES (:acc_id, :price, :reference, :expire_date)");
	    $insert_query3->execute([':acc_id' =>$acc_id, ':price' =>$price, ':reference'=>$reference, ':expire_date'=>$expire_date]); 

	    //automatic Artist login
		artistLogin($acc_id);				
	
    }  
    
    // header("Location: thank_you.php");
    // $acc_id = $pdo->lastInsertId();     
  } 	    

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
            <h2>Email verified and Payment made Successfully!</h2>
			<p>Thank you for creating a Business account, your account will expire on  the <?= date_create('+364 day')->format('l jS F Y');?>.
            </p>
            <!-- <a class="btn btn-custom form-pill" href="http://localhost/cross/cross-panel/login.php">Please Login</a> -->
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