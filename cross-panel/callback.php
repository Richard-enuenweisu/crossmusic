<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ARTIST_ID'])) {
  permission_error('login.php');
}else{
  $artist_id = $_SESSION['ARTIST_ID'];
  $stmt = $pdo->query("SELECT * FROM accounttbl INNER JOIN artisttbl ON accounttbl.id = artisttbl.account_id  WHERE accounttbl.id = $artist_id ");
  $acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
  $acct_type = $acc_result['acct_type'];
}

  $curl = curl_init();
  $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
  if(!$reference){
    // die('No reference supplied');
    header('Location: index.php');
  }

  $stmt = $pdo->prepare('SELECT * FROM accounttbl WHERE id = :acc_id AND acct_type = :acct_type');
  $stmt->execute(['acc_id'=>$artist_id, 'acct_type'=>'Free Account']);
  $row = $stmt->rowcount();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/".rawurlencode($reference),
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

    //Update artist accounttbl
      $acct_type = 'Paid Artist';
      $stmt = $pdo->prepare(" UPDATE accounttbl SET `acct_type` = :acct_type WHERE id = :acc_id");
      $stmt->execute([':acct_type' =>$acct_type, ':acc_id' =>$artist_id]);  

    //Update artist albumstbl
      $acct_type = 'Paid Artist';
      $stmt = $pdo->prepare(" UPDATE albumstbl SET `price` = :price WHERE account_id = :acc_id");
      $stmt->execute([':price' => 500.00, ':acc_id' =>$artist_id]);  

    //Update artist tracks
      $acct_type = 'Paid Artist';
      $stmt = $pdo->prepare("UPDATE trackstbl INNER JOIN albumstbl ON trackstbl.album_id = albumstbl.id
            SET trackstbl.price = :price WHERE albumstbl.account_id =:acc_id ");
      $stmt->execute([':price' =>150.00, ':acc_id' =>$artist_id]);  

    //Update artist singles
      $acct_type = 'Paid Artist';
      $stmt = $pdo->prepare(" UPDATE singlestbl SET `price` = :price WHERE acount_id = :acc_id");
      $stmt->execute([':price' =>150.00, ':acc_id' =>$artist_id]); 

      }
    }  
    // header('refresh:5; url = index.php');
    // $acc_id = $pdo->lastInsertId();     
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
          <h1 class="h2 font-weight-semibold mb-4">Migration Successs</h1>
          <div class="card mb-4">
            <div class="card-body">             
              <div class="row push">
                <div class="col-md-4 border-md-right border-light">
                  <center><img src="assets/img/migrate-img.png" style="width: 90%;"></center>
                </div>
                <div class="col-md-8">                                    
                    <h1>Migrated Successfully</h1>
                  <p class="">
                  Upon migration, your prices are stipulated at &#8358;500.00 for ablums, while singles and tracks are stipulated at &#8358;150.00 respectively which is our Standard Price Stipulation policy, however you can make necessary changes to each to suit your need.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>