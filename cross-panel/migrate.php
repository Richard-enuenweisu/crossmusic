<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

$stmt = $pdo->prepare('SELECT * FROM pricingtbl WHERE id = :id ');
$stmt->execute([':id'=>1]);
$price = $stmt->fetch(PDO::FETCH_ASSOC); 

$amount = $price['price'];
// $amount = number_format($amount);

if (!isset($_SESSION['ARTIST_ID'])) {
  permission_error('login.php');
}else{
	$artist_id = $_SESSION['ARTIST_ID'];
	$stmt = $pdo->query("SELECT * FROM accounttbl INNER JOIN artisttbl ON accounttbl.id = artisttbl.account_id  WHERE accounttbl.id = $artist_id ");
	$acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$acct_type = $acc_result['acct_type'];
}

	if (isset($_GET['migrate'])) {
		//paystack standard
		$curl = curl_init();
		$email = $acc_result['email'];;
		// $amount = 10000;  //the amount in kobo. This value is actually NGN 300
		// url to go to after payment
		$callback_url = 'http://localhost/cross/cross-panel/callback.php';  
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
		  // die('Curl returned error: ' . $err);
			die('
<html lang="en" class="no-js">
	<head>
	  <meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <title>Crossmusic</title>
	  <link rel="stylesheet" type="text/css" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
	  <link rel="stylesheet" type="text/css" href="bootstrap-4.3.1-dist/dist/bsnav.css">

	  <link href="https://fonts.googleapis.com/css?family=PT+Sans|Open+Sans|Josefin+Sans|Signika:700" rel="stylesheet">
	  <!-- <link rel="stylesheet" href="themify-icons/demo-files/demo.css"> -->
	  <link rel="stylesheet" type="text/css" href="bootstrap-4.3.1-dist/css/pisocials.css">
	  <link rel="stylesheet" href="themify-icons/css/themify-icons.css">
	  <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	  <link rel="stylesheet" type="text/css" href="bootstrap-4.3.1-dist/css/custom.css">

	  <script type="text/javascript" src="bootstrap-4.3.1-dist/js/jquery-3.2.1.js"></script>
	</head>
	<body>
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
		      <div class="row pusher">
		        <div class="col-md-12">
		          <div class="box-holder d-lg-flex flex-column align-items-center justify-content-center">
		            <img src="images/logo.png" width="120px" height="120px">
		            <h2>Poor Internet!</h2>
		            <ul>
		              <li>Check the network cables, modem, and router</li>
		              <li>Reconnect to Wi-Fi</li>
		              <li>Run Windows Network Diagnostics</li>
		            </ul>
		            ERR_INTERNET_DISCONNECTED<br>                    
		            <a class="btn btn-custom form-pill push" href="paidmusic.php">Try Again?</a>
		          </div>
		        </div>         
		      </div>   
		    </div>
		  </div>
		</div>
	</body>
</html>');
		}
		$tranx = json_decode($response, true);

		if(!$tranx->status){
		  // there was an error from the API
		  print_r('API returned error: ' . $tranx['message']);
		}
		// comment out this line if you want to redirect the user to the payment page
		// print_r($tranx);
		// redirect to page so User can pay
		// uncomment this line to allow the user redirect to the payment page
		header('Location: ' . $tranx['data']['authorization_url']);
	}
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/header.php');
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/headbar.php');
?>
<style type="text/css">
	.pro-s{
	font-size: 18px;font-style: italic;font-weight: bold		
	}
</style>
	<main class="u-main" role="main">
			<!-- Sidebar -->
		<?php
		  include str_replace("\\","/",dirname(__FILE__).'/assets/include/nav.php');
		?>	
			<div class="u-content">
				<div class="u-body">
					<h1 class="h2 font-weight-semibold mb-4">Migrate Account</h1>
					<div class="card mb-4">
						<div class="card-body">							
							<div class="row push">
								<div class="col-md-4 border-md-right border-light">
									<center><img src="assets/img/migrate-img.png" style="width: 90%;"></center>
								</div>
								<div class="col-md-8">																    
								    <h1>Migrating to paid account?</h1>
									<p class="">
									Join the +2000 artiste generating revenue from Crossmusic today. crossmusic profer a much more simpler way to sell your music and get you going. With our Paid Account platform you get 70% of each purchased song with a one-time account setup of &#8358;<?=$amount?>. 
									<br>
									<br>
									Upon migration, your prices will be stipulated at &#8358;500.00 for ablums, while singles and tracks are stipulated at &#8358;150.00 respectively which is our Standard Price Stipulation Policy. However, you can edit these prices to suit your need.
									</p>
									<a class="btn btn-sm btn-danger px-3" href="?migrate">
										<i class="fas fa-shekel-sign mr-1"></i>Migrate to Paid Account
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>