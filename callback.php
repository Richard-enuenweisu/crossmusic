<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');


  $curl = curl_init();
  $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
  if(!$reference){
    // die('No reference supplied');
    header('Location: index.php');
  }
  if (isset($_COOKIE['cookieOrder'])) {
  $prod_id = $_COOKIE['cookieOrder']['prod_id'];
  $user_id = $_COOKIE['cookieOrder']['user_id'];
  $category = $_COOKIE['cookieOrder']['category'];

  $acc_id = ((isset($_COOKIE['cookieOrder']['acc_id']))? $_COOKIE['cookieOrder']['acc_id']: '');
  $artist_price = ((isset($_COOKIE['cookieOrder']['artist_price']))? $_COOKIE['cookieOrder']['artist_price']: '');
  $aff_price = ((isset($_COOKIE['cookieOrder']['aff_price']))? $_COOKIE['cookieOrder']['aff_price']: '');

  }

  //credit artist account
  $query = $pdo->prepare('SELECT * FROM acct_transactiontbl WHERE account_id = ? ');
  $query->execute([$acc_id]);
  $rowCount = $query->rowcount();


  $stmt = $pdo->prepare('SELECT * FROM orderstbl WHERE reference = ? ');
  $stmt->execute([$reference]);
  $row = $stmt->rowcount();

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
        //insert free account into DB
      // echo $prod_id. '<br>'.$category.'<br>'.$user_id; 
    if (empty($row)) {
      # code...
    $insert_query1 = $pdo->prepare("INSERT INTO orderstbl (`user_id`, `product_id`, `category`, `reference`) VALUES (:user_id, :product_id, :category, :reference)");
    $insert_query1->execute([':user_id' =>$user_id, ':product_id' =>$prod_id, ':category'=>$category, ':reference'=>$reference]);      
    }

    //pay artist
    if (isset($artist_price)) {
      # code...
      $insert_query2 = $pdo->prepare("SELECT balance FROM artist_balancetbl WHERE account_id = :acc_id");
      $insert_query2->execute([':acc_id'=>$acc_id]);
      $balance_result = $insert_query2->fetch(PDO::FETCH_ASSOC);

      if (is_null($balance_result['balance']) || empty($balance_result['balance'])) {
        # code...
      $stmt = $pdo->prepare("INSERT INTO artist_balancetbl (`account_id`, `balance`) VALUES (:account_id, :balance)");
      $stmt->execute([':account_id' =>$acc_id, ':balance' =>$artist_price]); 
      }else{
      $new_balance = $artist_price + $balance_result['balance'];

      $stmt = $pdo->prepare(" UPDATE artist_balancetbl SET `balance` = :new_balance WHERE account_id = :acc_id");
      $stmt->execute([':new_balance' =>$new_balance, ':acc_id' =>$acc_id]);         
      }
    }
    //pay affiliate
    $aff_id = ((isset($_COOKIE['affiliate']['aff_id']))? $_COOKIE['affiliate']['aff_id']: '');    
    if (isset($aff_price) && !empty($aff_id)) {
      # code...
      $insert_query2 = $pdo->prepare("SELECT balance FROM aff_balancetbl WHERE account_id = :acc_id");
      $insert_query2->execute([':acc_id'=>$aff_id]);
      $balance_result = $insert_query2->fetch(PDO::FETCH_ASSOC);

      if (is_null($balance_result['balance']) || empty($balance_result['balance'])) {
        # code...
      $stmt = $pdo->prepare("INSERT INTO aff_balancetbl (`account_id`, `balance`) VALUES (:account_id, :balance)");
      $stmt->execute([':account_id' =>$aff_id, ':balance' =>$aff_price]); 
      }else{
      $new_bal = $aff_price + $balance_result['balance'];

      $stmt = $pdo->prepare(" UPDATE aff_balancetbl SET `balance` = :new_balance WHERE account_id = :acc_id");
      $stmt->execute([':new_balance' =>$new_bal, ':acc_id' =>$aff_id]);   
      //unset cookies
      $res = setcookie($_COOKIE['affiliate']['aff_id'], '', time() - 3600);            
      }
    }  
    
    header("Location: thank_you.php");
    // $acc_id = $pdo->lastInsertId();     
  } 	    

  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
