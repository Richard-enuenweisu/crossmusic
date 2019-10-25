<?php

  if (isset($_GET['paidtracks'])) {
  	# code...
    $title = $_GET['paidtracks'];
    $songby = $_GET['songby'];
  	$price = 0;
    $stmt = $pdo->prepare("SELECT * FROM trackstbl WHERE title =:title AND song_by =:song_by AND price >:price");
    $stmt2 = $pdo->prepare("SELECT * FROM trackstbl WHERE title =:title AND song_by =:song_by AND price >:price");
    $stmt->execute([':title' => $title, ':song_by'=>$songby, ':price' => $price]);
    $stmt2->execute([':title' => $title, ':song_by'=>$songby, ':price' => $price]);
    $prev_result = $stmt->fetch(PDO::FETCH_ASSOC);
   	if (is_null($prev_result) || empty($prev_result)) {
	# code...
	header('Location:paidmusic.php?user=false');
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
    $songby = $_GET['songby'];
  	$price = 0;
    $stmt = $pdo->prepare("SELECT * FROM singlestbl WHERE title =:title AND song_by =:song_by AND price >:price");
    $stmt2 = $pdo->prepare("SELECT * FROM singlestbl WHERE title =:title AND song_by =:song_by AND price >:price");
    $stmt->execute([':title' => $title, ':song_by'=>$songby, ':price' => $price]);
    $stmt2->execute([':title' => $title, ':song_by'=>$songby, ':price' => $price]);
    $prev_result = $stmt->fetch(PDO::FETCH_ASSOC);
   	if (is_null($prev_result) || empty($prev_result)) {
	# code...
	header('Location:paidmusic.php?user=false');
	} 
  $category = 'singles';  
  //get account id  
  $acc_id = $prev_result['acount_id']; 
  }
  if (isset($_GET['paidalbums'])) {
  	# code...
    $title = $_GET['paidalbums'];
    $songby = $_GET['songby'];
  	$price = 0;
    $stmt = $pdo->prepare("SELECT accounttbl.company_name, albumstbl.id, albumstbl.title, albumstbl.price, albumstbl.featured, albumstbl.image, albumstbl.account_id FROM albumstbl INNER JOIN accounttbl ON accounttbl.id = albumstbl.account_id WHERE albumstbl.title =:title AND accounttbl.company_name =:song_by AND albumstbl.price >:price");
    $stmt->execute([':title' => $title, ':song_by'=>$songby, ':price' => $price]);
    $prev_result = $stmt->fetch(PDO::FETCH_ASSOC);
   	if (is_null($prev_result) || empty($prev_result)) {
	# code...
  header('Location:paidmusic.php?user=false');
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