<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['AFFILIATE_ID'])) {
  permission_error('login.php');
}else{
	$affiliate_id = $_SESSION['AFFILIATE_ID'];
	// var_dump($affiliate_id);
	$stmt2 = $pdo->query("SELECT * FROM aff_banktbl WHERE account_id = $affiliate_id");
	$row = $stmt2->rowcount();
	$acc_ref = $stmt2->fetch(PDO::FETCH_ASSOC);	
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
if (isset($_POST['verify'])) {
	# code...
	$bname = ((isset($_POST['bname']))?sanitize($_POST['bname']): '');
	$accNum = ((isset($_POST['accNum']))?sanitize($_POST['accNum']): '');
	$split = explode('-',$bname);
	$bank_name = $split[0];
	$bank_code = $split[1];
	// $bank_name = substr_replace($bname,$bank_code,-4);	
	//resolve bank
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api.paystack.co/bank/resolve?account_number='.$accNum.'&bank_code='.$bank_code,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => [
	    "authorization: Bearer sk_test_5f94dfdac4c43b80d16f4cb0b844123d1cfed4af", //replace this with your own test key
	    "content-type: application/json",
	    "cache-control: no-cache"
	  ],
	));
	$curl_result = curl_exec($curl);
	$err = curl_error($curl);
	if($err){
		die ("page error:".$err);
	}else{
		$curl_result = json_decode($curl_result, true);
	}
	if ($curl_result['status'] == 'true') {
		# code...
		$account_name = $curl_result['data']['account_name'];
	}else{
		$account_name = 'Not resolved, continue if you are certain';
	}

}
//add bank details
if (isset($_POST['add'])) {
  # code...
	$accNum = ((isset($_POST['accNum']))?sanitize($_POST['accNum']): '');
	$bname = ((isset($_POST['bname']))?sanitize($_POST['bname']): '');
	$errors = array();
	if (empty($accNum) || empty($bname)) {
	$errors[].= 'Some fields are empty'.'<br>';
	}

	if (empty($errors)) {
	$stmt = $pdo->prepare("INSERT INTO aff_banktbl ( `account_id`, `bank_name`, `bank_account`) VALUES(:account_id, :bank_name, :bank_account)");
	$stmt->execute([':account_id' => $affiliate_id, ':bank_name'=>$bname, ':bank_account'=>$accNum]); 
	$success = 'Bank details Successfully! '.'<br>';
	header('refresh:2; url = aff-account-info.php');
	// artistLogin($u_id);
	}
}
// edit bank details
if (isset($_POST['edit'])) {
  # code...
	$accNum = ((isset($_POST['accNum']))?sanitize($_POST['accNum']): '');
	$bname = ((isset($_POST['bname']))?sanitize($_POST['bname']): '');
	$errors = array();
	if (empty($accNum) || empty($bname)) {
	$errors[].= 'Some fields are empty'.'<br>';
	}

	if (empty($errors)) {
	$stmt = $pdo->prepare("UPDATE `aff_banktbl` SET `account_id` =:account_id , `bank_name`=:bank_name, `bank_account`=:bank_account");
	$stmt->execute([':account_id' => $affiliate_id, ':bank_name'=>$bname, ':bank_account'=>$accNum]); 
	$success = 'Bank details Successfully! '.'<br>';
	header('refresh:2; url = aff-account-info.php');
	// artistLogin($u_id);
	}
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
					<h1 class="h2 font-weight-semibold mb-4">Accounts Information</h1>
					<div class="card mb-4">
						<div class="card-body">						
							<div class="row pusher">
								<div class="col-md-4 d-lg-flex flex-column align-items-start justify-content-center border-md-right border-light">
									<center><img src="assets/img/acc-img.png" style="width: 95%;"></center>
									<?php if(empty($row)) {?>
									<h2 class="push">No Account Details</h2>
									<?php }else {?>
									<h2 class="push">Account Details</h2>
									<div>
										<span for="email">Bank Name</span>
										<p class="pro-s"><?=$acc_ref['bank_name']?></p>

										<span for="email">Account Number</span>
										<p class="pro-s"><?=$acc_ref['bank_account']?></p>												
									</div>
									<?php } ?>									
								</div>
								<?php if(empty($row)) {?>
								<div class="col-md-8">																
									<form action="aff-account-info.php" method="POST">										
										<h2>Add Account Details</h2>
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
					                              <!-- <i class="fa fa-minus-circle alert-icon mr-3"></i> -->
					                              <span><?php echo display_errors($errors); ?></span>
					                              <button type="button" class="close" aria-label="Close" data-dismiss="alert">
					                                <span aria-hidden="true">&times;</span>
					                              </button>
					                            </div>
					                        <?php } ?>
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
											<label for="email">Account number</label>
											<input id="email" class="form-control " name="accNum" type="text" placeholder="Account number" value="<?=((isset($accNum))?$accNum:'');?>">	
										</div>
										<button class="btn btn-danger" type="submit" name="verify">Verify Account Number
											<div class="spinner-border m-5" role="status">
											  <span class="sr-only">Loading...</span>
											</div>
										</button>				
										<hr>
										<div class="form-group mb-4 push">
											<label for="email">Account Name</label>
											<input id="email" class="form-control " disabled name="accname" type="text" placeholder="Account Name" value="<?=((isset($account_name))?$account_name:'');?>">
										</div>																				
										<button class="btn custom-btn form-pill" type="submit" name="add">Add Details</button>			
									</form>
								</div>									
								<?php } else{ ?>
								<div class="col-md-8">																
									<form action="aff-account-info.php" method="POST">										
										<h2>Edit Account Details</h2>
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
					                              <!-- <i class="fa fa-minus-circle alert-icon mr-3"></i> -->
					                              <span><?php echo display_errors($errors); ?></span>
					                              <button type="button" class="close" aria-label="Close" data-dismiss="alert">
					                                <span aria-hidden="true">&times;</span>
					                              </button>
					                            </div>
					                        <?php } ?>
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
											<label for="email">Account number</label>
											<input id="email" class="form-control " name="accNum" type="text" placeholder="Account number" value="<?=((isset($accNum))?$accNum:'');?>">	
										</div>
										<button class="btn btn-danger" type="submit" name="verify">Verify Account Number</button>
										<hr>
										<div class="form-group mb-4 push">
											<label for="email">Account Name</label>
											<input id="email" class="form-control " disabled name="accname" type="text" placeholder="Account Name" value="<?=((isset($account_name))?$account_name:'');?>">
										</div>																				
										<button class="btn custom-btn form-pill" type="submit" name="edit">Edit Details</button>			
									</form>
								</div>
								<?php } ?>								
							</div>
						</div>
					</div>
				</div>
			</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>