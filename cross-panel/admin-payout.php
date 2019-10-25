<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['ADMIN_ID'])) {
  permission_error('admin-login.php');
}
if (isset($_GET['artist'])) {
	# code...
	$artist_id = $_GET['artist'];
	$trans_query = $pdo->query("SELECT * FROM banktbl INNER JOIN accounttbl ON accounttbl.id = banktbl.account_id WHERE `account_id` = $artist_id ");
	$row = $trans_query->rowcount();
	$bank_details = $trans_query->fetch(PDO::FETCH_ASSOC);
	$header = 'artist';
	// var_dump($bank_details);
}elseif (isset($_GET['affiliate'])) {
	# code...
	$affiliate_id = $_GET['affiliate'];
	$trans_query = $pdo->query("SELECT * FROM aff_banktbl INNER JOIN aff_accounttbl ON aff_accounttbl.id = aff_banktbl.account_id  WHERE `account_id` = $affiliate_id ");
	$row = $trans_query->rowcount();
	$bank_details = $trans_query->fetch(PDO::FETCH_ASSOC);
	$header = 'affiliate';
	// var_dump($bank_details);
}else{
	header('Location: index.php');
}	

//list bank code
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/bank",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer sk_test_5f94dfdac4c43b80d16f4cb0b844123d1cfed4af", //replace this with your own test key
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));
$response = curl_exec($curl);
$err = curl_error($curl);
if($err){
	die ("page error:".$err);
}else{
	$response = json_decode($response, true);
}


if (isset($_POST['receipt'])) {
	# code...
	$curl = curl_init();

	$name = ((isset($_POST['name']))?sanitize($_POST['name']): '');
	$bname = ((isset($_POST['bname']))?sanitize($_POST['bname']): '');
	$accNum = ((isset($_POST['accNum']))?sanitize($_POST['accNum']): '');
	$split = explode('-',$bname);
	$bank_name = trim($split[0]);
	$bank_code = trim($split[1]);
	$errors2 = array();	

	if (empty($name) || empty($bank_name) || empty($bank_code)) {
		# code...
		$errors2[].= 'please fill the necessary form data';
	}
	if (empty($errors2)) {
		# code...
	//create receipt
	$params=[
	   'type'=>'nuban',
	   'name'=>$name,
	   'description'=>'Receipt',
	   'account_number'=>$accNum,
	   'bank_code'=>$bank_code,
	   'currency'=>'NGN'
	];
	$params = json_encode($params, true);
	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://api.paystack.co/transferrecipient',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => $params,  
	CURLOPT_HTTPHEADER => [
	    "authorization: Bearer sk_test_5f94dfdac4c43b80d16f4cb0b844123d1cfed4af", //replace this with your own test key
	    "content-type: application/json",
	    "cache-control: no-cache"
	  ]

	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
		if($err){
			die ("page error:".$err);
		}else{
			$response = json_decode($response, true);
			// echo $response['data']['recipient_code'];
			$rcc = $response['data']['recipient_code'];
			$success2 = 'Receipt Generated successfully';
		} 

	}
}

if (isset($_POST['payment'])) {
	# code...

$amount = ((isset($_POST['amount']))?sanitize($_POST['amount']): '');
$rcc = ((isset($_POST['rcc']))?sanitize($_POST['rcc']): '');
$note = ((isset($_POST['note']))?sanitize($_POST['note']): '');	
$errors = array();

if (empty($amount) || $amount < 2000) {
	# code...
	$errors[].= 'amount must not be empty or less than 2000';
}
if (empty($note)) {
	# code...
	$errors[].= 'Please enter note.';
}
if (empty($errors)) {
	# code...
	//lnitiate transfer
	$curl = curl_init();
	$params=[
		'source'=>'balance',
		'reason'=>$note, 
		'amount'=>$amount,
		'recipient'=>$rcc
		];
	$params = json_encode($params, true);
	var_dump($params);

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.paystack.co/transfer",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  // CURLOPT_POSTFIELDS => $params,
	  CURLOPT_HTTPHEADER => [
	    "authorization: Bearer sk_test_5f94dfdac4c43b80d16f4cb0b844123d1cfed4af", //replace this with your own test key
	    "content-type: application/json",
	    "cache-control: no-cache"
	  ],
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	if($err){
		// die ("page error:".$err);
	}else{
		$response = json_decode($response, true);
		if ($response['status'] == true) {
			# code...
			$success = 'Transfer made successfully.';
		}
	}
}
	
}


  include str_replace("\\","/",dirname(__FILE__).'/assets/include/header.php');
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/headbar.php');
?>

	<main class="u-main" role="main">
			<!-- Sidebar -->
		<?php
		  include str_replace("\\","/",dirname(__FILE__).'/assets/include/nav.php');
		?>	
<style type="text/css">
	.table-responsive img{
		width: 65px;
		height: 65px;
	}
</style>
			<div class="u-content">
				<div class=" u-body">
					<h1 class="h2 font-weight-semibold mb-4">Payout form</h1>
		<main class="container-fluid " role="main">
			<div class="row">
				<div class="col-lg-6">
					<div class="card mnh-100vh" style="padding: 15px;">
						<form class="mb-3" method="POST" action="admin-payout.php?artist=<?=$artist_id?>">
							<div class="mb-3">
								<h1 class="h2">Artist Details</h1>
								<p class="small">Artist bank details</p>
							</div>							
							<div class="form-group mb-4">
								<label for="password">First Name</label>
								<input id="password" class="form-control" name="amount" type="text" placeholder="Bank name" value="<?=$bank_details['fname'];?>" readonly>
							</div>
							<div class="form-group mb-4">
								<label for="password">Last name</label>
								<input id="password" class="form-control" name="amount" type="text" placeholder="Bank name" value="<?=$bank_details['lname'];?>" readonly>
							</div>														<div class="form-group mb-4">
								<label for="password">Bank name</label>
								<input id="password" class="form-control" name="amount" type="text" placeholder="Bank name" value="<?=$bank_details['bank_name'];?>" readonly>
							</div>
							<div class="form-group mb-4">
								<label for="email">Account Number</label>
								<input id="email" class="form-control" name="description" type="text" placeholder="Accoun Number" value="<?=$bank_details['bank_account'];?>" readonly>
							</div>														
						</form>
					</div>					

					<div class="u-login-form text-muted py-3 mt-auto">
					</div>
				</div>

				<div class="col-lg-6">
					<div class="card mnh-100vh" style="padding: 15px;">
						<form class="mb-3" method="POST" action="admin-payout.php?<?=($header == 'affiliate')?'affiliate='.$affiliate_id:'artist='.$artist_id?>">
							<div class="mb-3">
								<h1 class="h2">Make Payment</h1>
								<p class="small">All payments and cashout requests are attended at the end of the month with amount not less than &#8358;2000.</p>
							</div>
		                      <div class="row">
		                        <?php if(isset($success2)){ ?>
		                          <div class="form-control alert alert-success fade show" role="alert">
		                            <i class="fa fa-check-circle alert-icon mr-3"></i>
		                            <span> <?php echo $success2; ?></span>
		                            <button type="button" class="close" aria-label="Close" data-dismiss="alert">
		                              <span aria-hidden="true">&times;</span>
		                            </button>
		                          </div>
		                        <?php } else if(isset($errors2)){ ?>
		                            <div class="form-control alert alert-danger fade show" role="alert">
		                              <span><?php echo display_errors($errors2); ?></span>
		                              <button type="button" class="close" aria-label="Close" data-dismiss="alert">
		                                <span aria-hidden="true">&times;</span>
		                              </button>
		                            </div>
		                        <?php } ?>
		                      </div> 							
							<div class="form-group mb-4">
								<label for="email">Name</label>
								<input id="email" class="form-control" name="name" type="text" placeholder="Enter Name">
							</div>
							<div class="form-group mb-4">
								<label for="password">Bank Name</label>
								<select class="form-control" name="bname">
									<option><?=((isset($bank_name))?$bank_name:'--Select Bank--');?></option>					
									<?php 
									 foreach($response as $details => $data)
									    	{
									    		foreach($data as $info){?>
													<option><?=$info['name']?>-<?=$info['code']?></option>
									<?php } } ?>
								</select>
							</div>
							<div class="form-group mb-4">
								<label for="email">Account Number</label>
								<input id="email" class="form-control" name="accNum" type="text" placeholder="Accoun Number">
							</div>
							<button class="btn custom-btn btn-block" type="submit" name="receipt">Generate Receipt</button>

							<?php if (isset($rcc)){ ?>
							<hr>
		                      <div class="row">
		                        <?php if(isset($success)){ ?>
		                          <div class="form-control alert alert-success fade show" role="alert">
		                            <i class="fa fa-check-circle alert-icon mr-3"></i>
		                            <span> <?php echo $success; ?></span>
		                            <button type="button" class="close" aria-label="Close" data-dismiss="alert">
		                              <span aria-hidden="true">&times;</span>
		                            </button>
		                          </div>
		                        <?php } else if(isset($errors)){ ?>
		                            <div class="form-control alert alert-danger fade show" role="alert">
		                              <span><?php echo display_errors($errors); ?></span>
		                              <button type="button" class="close" aria-label="Close" data-dismiss="alert">
		                                <span aria-hidden="true">&times;</span>
		                              </button>
		                            </div>
		                        <?php } ?>
		                      </div>							
							<div class="form-group mb-4">
								<label for="email">Generated Receipt</label>
								<input id="email" class="form-control" type="text" disabled value="<?=((isset($rcc))?$rcc:'')?>">
								<input id="email" class="form-control" hidden name="rcc" type="text" value="<?=((isset($rcc))?$rcc:'')?>">
							</div>
							<hr>							
							<div class="form-group mb-4">
								<label for="email">Enter Amount</label>
								<input id="email" class="form-control" name="amount" type="text" placeholder="Enter Amount">
							</div>							
							<div class="form-group mb-4">
								<label for="password">Transfer Note</label>
								<textarea class="form-control" name="note" rows="2"></textarea>
							</div>														
							<button class="btn custom-btn btn-block" type="submit" name="payment">Make Payment</button>
							<?php } ?>
						</form>
					</div>	
				</div>
			</div>
		</main>
				</div>
			</div>
<script>
    $(document).ready(function(){
    $('#myDropDown').change(function(){
        //Selected value
        var inputValue = $(this).val();
        $("#codes").val(inputValue);
        // alert("value in js "+inputValue);


        //Ajax for calling php function
    });
});
</script>
<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>