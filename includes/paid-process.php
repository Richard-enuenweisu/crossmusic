<?php

  if (isset($_GET['paidtracks'])) {
  	# code...
  	$title = $_GET['paidtracks'];
  	$price = 0;
    $stmt = $pdo->prepare("SELECT * FROM trackstbl WHERE title =:title AND price >:price");
    $stmt2 = $pdo->prepare("SELECT * FROM trackstbl WHERE title =:title AND price >:price");
    $stmt->execute([':title' => $title, ':price' => $price]);
    $stmt2->execute([':title' => $title, ':price' => $price]);
    $prev_result = $stmt->fetch(PDO::FETCH_ASSOC);
   	if (is_null($prev_result) || empty($prev_result)) {
	# code...
	header('Location:paidmusic.php');
	}  
  $category = 'tracks'; 
  //get account id
  $find_id = $prev_result['album_id'];
  $album_q = $pdo->prepare("SELECT * FROM albumstbl WHERE id =:find_id");
  $album_q->execute([':find_id' => $find_id]); 
  $album_result = $album_q->fetch(PDO::FETCH_ASSOC);
  $acc_id = $album_result['account_id'];
  }
  if (isset($_GET['paidsingles'])) {
  	# code...
  	$title = $_GET['paidsingles'];
  	$price = 0;
    $stmt = $pdo->prepare("SELECT * FROM singlestbl WHERE title =:title AND price >:price");
    $stmt2 = $pdo->prepare("SELECT * FROM singlestbl WHERE title =:title AND price >:price");
    $stmt->execute([':title' => $title, ':price' => $price]);
    $stmt2->execute([':title' => $title, ':price' => $price]);
    $prev_result = $stmt->fetch(PDO::FETCH_ASSOC);
   	if (is_null($prev_result) || empty($prev_result)) {
	# code...
	header('Location:paidmusic.php');
	} 
  $category = 'singles';  
  //get account id  
  $acc_id = $prev_result['acount_id']; 
  }
  if (isset($_GET['paidalbums'])) {
  	# code...
  	$title = $_GET['paidalbums'];
  	$price = 0;
    $stmt = $pdo->prepare("SELECT * FROM albumstbl WHERE title =:title AND price >:price");
    $stmt->execute([':title' => $title, ':price' => $price]);
    $prev_result = $stmt->fetch(PDO::FETCH_ASSOC);
   	if (is_null($prev_result) || empty($prev_result)) {
	# code...
	header('Location:paidmusic.php');
	}
	$main_category = 'albums';      
	$category = 'tracks';  
  // get account id
  $acc_id = $prev_result['account_id']; 
	// fetch tracks
	$album_id = $prev_result['id'];
    $stmt2 = $pdo->prepare("SELECT * FROM trackstbl WHERE album_id =:album_id AND price >:price");
    $stmt2->execute([':album_id' => $album_id, ':price' => $price]);
  	
  } 


?>