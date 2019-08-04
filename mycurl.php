<?php
//step1
$curl = curl_init();

$params=[
	'business_name'=>'ENUENWEISU RICHARD CHUKWUBUEZE',
	'settlement_bank'=>'Guaranty Trust Bank', 
	'account_number'=>'0279344451',
	'percentage_charge'=>'18.2'
	];

  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/subaccount",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_POSTFIELDS => $params,
  // CURLOPT_HEADER => true,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer sk_test_0000ee7f9a55011d3c05dabf1ee48fd8118dd846", //replace this with your own test key
    "content-type: application/json",
    "cache-control: no-cache",
  ]
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$response = array_flip(array($response));
// $tranx = json_decode($response, true);


print_r($response);


// if(!$tranx->status){
//   // there was an error from the API
//   print_r('API returned error: ' . $tranx['message']);
// }



?>

