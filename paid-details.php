<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/includes/paid-process.php');
  // require_once  str_replace("\\","/",dirname(__FILE__). '/includes/cartscript.php');
  if (isset($_SESSION['USER_ID'])) {
  	# code...
  	$user_id = $_SESSION['USER_ID'];
	$stmt = $pdo->prepare('SELECT * FROM usertbl WHERE id = ? ');
	$stmt->execute([$user_id]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
  }
 
if (isset($_POST['purchase'])) {
  	# code...
	$prod_id = ((isset($_POST['prod_id']))?sanitize($_POST['prod_id']): '');
	$category = ((isset($_POST['category']))?sanitize($_POST['category']): '');
	$amount = ((isset($_POST['amount']))?sanitize($_POST['amount']): '');
	$email = ((isset($_POST['email']))?sanitize($_POST['email']): ''); 
	$errors = array();	
	// echo $prod_id. '<br>'.$category.'<br>'.$amount.'<br>'.$email.'<br>'.$user_id; 
	if ($category == 'tracks' || $category =='singles') {
		# code...
		if ($amount =='100.00' || $amount =='150.00' || $amount =='200.00') {
			# code...
			$process = 'ok';
		}
		else{
			$errors[].='inavlid price!';
		}
	}
	if ($category == 'albums') {
		# code...
		if ($amount >= '200') {
			# code...
			$process = 'ok';
		}
		else{
			$errors[].='inavlid price!';
		}
	}	
	if (empty($errors) && $process == 'ok') {
		# code...			
		$sys_price = 0.3 * $amount;
		$artist_price = $amount - $sys_price;
		$aff_price = 0.10 * $amount;

		setcookie("cookieOrder[prod_id]", htmlentities($prod_id), time()+7200);  /* expire in 2 hour */
		setcookie("cookieOrder[user_id]", htmlentities($user_id), time()+7200);  /* expire in 2 hour */
		setcookie("cookieOrder[category]", htmlentities($category), time()+7200);  /* expire in 2 hour */
		
		setcookie("cookieOrder[acc_id]", htmlentities($acc_id), time()+7200);  /* expire in 2 hour */
		setcookie("cookieOrder[artist_price]", htmlentities($artist_price), time()+7200);  /* expire in 2 hour */
		setcookie("cookieOrder[aff_price]", htmlentities($aff_price), time()+7200);  /* expire in 2 hour */

		//paystack standard
		$curl = curl_init();
		// $email = "your@email.com";
		// $amount = 30000;  //the amount in kobo. This value is actually NGN 300
		// url to go to after payment
		$callback_url = 'http://localhost/cross/callback.php';  
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
  }  
  // search script
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "https") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$long_url = urlencode($actual_link);
$bitly_login = 'o_3imer2s9ir';
$bitly_apikey = 'R_86d9c6da47eb485bb38e814bc4fe3dd0';
$bitly_response = json_decode(file_get_contents("http://api.bit.ly/v3/shorten?login={$bitly_login}&apiKey={$bitly_apikey}&longUrl={$long_url}&format=json"));
$short_url = $bitly_response->data->url;

  include str_replace("\\","/",dirname(__FILE__).'/includes/search.php');   
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<div class="container">
	<div class="row">
		<div class="music-page-flex">
		    <div class="col-md-8 pusher-3">
			      <h1>Get your heart songs</h1>
			      <p>
			      Go head over heels with your next favorite song or artist. Crossmusic has over +2000 tracks for you to browse, listen, buy or download. Use our elastic search to find song or music.
			      </p>
<!-- 				  <ul class="list-unstyled list-inline social pull-right">
				    <li class="list-inline-item"><a href="">
				    <i class="fa fa-facebook"></i></a></li>
				    <li class="list-inline-item"><a href=""><i class="fa fa-twitter"></i></a></li>
				    <li class="list-inline-item"><a href=""><i class="fa fa-instagram"></i></a></li>
				    <li class="list-inline-item"><a href="javascript:void();" target="_blank"><i class="fa fa-envelope"></i></a></li>
				  </ul>  -->			
		          <div id="custom-search-input">
		            <form method="POST" action="search-result.php">
		              <div class="input-group">
		                <select class="sinput form-control" name="category" style="border-radius:0px;">
		                  <option>-- Category --</option>
		                  <option>Albums</option>
		                  <option>Tracks</option>
		                  <option>Singles</option>
		                </select>
		                <select class="sinput form-control" name="type" style="border-radius:0px;">
		                  <option>-- Type --</option>
		                  <option>Free</option>
		                  <option>Paid</option>
		                </select>                
		                <input type="text" class="sinput form-control" name="title" placeholder="Title">
		                <!-- <div class="input-group-append"> -->
		                  <button type="submit" class="form-control" name="search" style="color: #fff;background-color: #007bff;border-color: #007bff;border-radius:0px;width: 10%;padding: 10px 0px 7px 0px;"><i class="fa fa-search"></i></button>
		                <!-- </div>                              -->
		              </div> 
		              <?php if(isset($errors)){?> 
		              <!-- alert -->
		              <div class="alert text-danger alert-dismissible fade show" role="alert">
		                <?=display_errors($errors)?>
		                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                  <span aria-hidden="true">&times;</span>
		                </button>
		              </div>                 
		              <?php } ?>                          
		            </form>           
		          </div>
				<div class="row music-media pusher">
					<div class="col-sm-12 col-md-12">
					    <!-- <form  method="post" action="paid-details.php?<?=$urlquery?>">					 -->
					    <div class="row music-view-details">
						  <div class="col-md-4">
			                  <img src="<?=$prev_result['image']?>">
								<?php if (isset($_GET['paidalbums'])): ?>
								  	<div class="">
									    <span class="small">Album</span><br>
										<p><?=$prev_result['title']?></p>
										<?php if(!isset($_SESSION['USER_ID'])){ ?>
								    	<a class="my-ellipse btn mycart-button" href="paid-details.php?paidalbums=<?=$title?>&prod_title=<?=$prev_result['title']?>&category=<?=$main_category?>&user=false">
										    &#8358; <?=$prev_result['price']?> <i class="fa fa-shopping-cart" aria-hidden="true"></i>
										</a>
										<?PHP }else{ ?>
										<form method="POST" action="paid-details.php?paidalbums=<?=$title?>&prod_title=<?=$prev_result['title']?>&category=<?=$main_category?>">
										  <script src="https://js.paystack.co/v1/inline.js"></script>
                      						<input type="hidden" name="prod_id" value="<?=$prev_result['id']?>">	
                      						<input type="hidden" name="category" value="<?=$main_category?>">	
                      						<input type="hidden" name="amount" value="<?=$prev_result['price']?>">	
                      						<input type="hidden" name="email" value="<?=$user['email']?>">	 
										  <button type="submit" name="purchase" class="my-ellipse btn mycart-button">
										   &#8358; <?=$prev_result['price']?> Buy</button>
										</form>
										<?php }?>
									</div>									
								<?php endif ?>						  		                  	                  
						  </div>
						  <div class="col-md-8">	
						  	<p class="push share-tiny-link">Share: <span id="copy"><?=$short_url?> </span> 
							<button class="btn btn-sm float-right text-white" onclick="copyToClipboard('#copy')"><i class="fa fa-copy"></i></button>
						  </p>
						  <?php while($result = $stmt2->fetch(PDO::FETCH_ASSOC)) : 						  	
							//count dowload script
							if (isset($category)) {
								# code...
								$count_id = $result['id'];
								if ($category == 'tracks') {
									# code...							
								$count_query = $pdo->query("SELECT COUNT(*) as count from  tracks_downloadtbl WHERE track_id=$count_id");								
								}elseif ($category == 'singles') {
									# code...
								$count_query = $pdo->query("SELECT COUNT(*) as count from  singles_downloadtbl WHERE single_id =$count_id");								
								}
								$count = $count_query->fetch(PDO::FETCH_ASSOC);
							}						  	
						  	?>						
								<div class="<?=(isset($_GET['paidalbums']))?'music-child-details':''?>">
									<!-- jsSocials BEGIN -->
								    <div id="share" style="font-size: 10px;"></div>
								    <script src="jsSocial/jquery.js"></script>
								    <script src="jsSocial/jssocials.min.js"></script>
								    <script>
									$("#share").jsSocials({
										shareIn: "popup",									
									    url: "<?=$short_url?>",
									    text: "♫ <?=$prev_result['title']?> - Get the song! | Get free unlimited songs uploads. Crossmusic proffer a much more simpler way to sell your gospel music and get you going.",
									    showLabel: true,
									    showCount: "inside",
									    shares: ["twitter", "facebook", "whatsapp"]
									});
								    </script>									
									<div class="music-downloads">										
										<span class="small">Downloads <?=$count['count']?> <i class="fa fa-cloud-download"></i></span>
									</div>

								    <div class="music-ellipse dropdown">
								    	<?php if(!isset($_SESSION['USER_ID'])){ ?>
								    	<a class="my-ellipse btn mycart-button" href="paid-details.php?<?=(isset($_GET['paidtracks']))?'paidtracks':''?><?=(isset($_GET['paidsingles']))?'paidsingles':''?><?=(isset($_GET['paidalbums']))?'paidalbums':''?>=<?=$title?>&prod_title=<?=$result['title']?>&user=false">
										    &#8358; <?=$result['price']?> Buy
										</a>
									<?php } else{ ?>
										<form method="POST" action="paid-details.php?<?=(isset($_GET['paidtracks']))?'paidtracks':''?><?=(isset($_GET['paidsingles']))?'paidsingles':''?><?=(isset($_GET['paidalbums']))?'paidalbums':''?>=<?=$title?>&prod_title=<?=$result['title']?>">
										  <script src="https://js.paystack.co/v1/inline.js"></script>
                      						<input type="hidden" name="prod_id" value="<?=$result['id']?>">	
                      						<input type="hidden" name="category" value="<?=$category?>">	
                      						<input type="hidden" name="amount" value="<?=$result['price']?>">	
                      						<input type="hidden" name="email" value="<?=$user['email']?>">	 
										  <button type="submit" name="purchase" class="my-ellipse btn mycart-button">
										   &#8358; <?=$result['price']?> Buy</button>
										</form>
									<?php } ?>																
									</div>																	
								  	<div class="mediPlayer">
									    <audio class="listen" preload="none" data-size="50" src="<?=$result['short_url']?>"></audio>
									</div>
									<div class="music-descriptions">	
									    <span class="small"><?=$result['song_by']?></span><br>												
									    <span><?=$result['title']?></span><br>									
										<?php if (!isset($_GET['freealbum'])): ?>
											<p><?=$result['duration']?></p>								
										<?php endif ?>										
									</div>
								</div>	
							<?php endwhile;?>						  													
						    <!-- <div class="media-attribution"><em>30:64</em> - </div> -->
						  </div>
						</div>
					</form>				
					</div>
				</div>	            
		    </div>		
		</div>        
	</div>
	<div class="row">
		<?php if(isset($_GET['user']) && $_GET['user'] == 'false'){ ?>
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
			    Please Login to purchase your selected item.
			  </div>
			</div>	
		<?php }  ?>
	</div>  
</div>

<script type="text/javascript">
function fetch(val)
{
 // alert("working " +val);
 $.ajax({
 type: 'post',
 url: 'index.php',
 data: {
  get_val:val
 },
 success: function (response) {
 	alert('Working');
 }
 });
}	
</script>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/paystack.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>