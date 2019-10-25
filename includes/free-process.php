<?php

  if (isset($_GET['freetracks'])) {
  	# code...
    $title = $_GET['freetracks'];
    $songby = $_GET['songby'];
    $price = 0;
    $stmt = $pdo->prepare("SELECT * FROM trackstbl WHERE title =:title AND song_by =:song_by AND price =:price");
    $stmt2 = $pdo->prepare("SELECT * FROM trackstbl WHERE title =:title AND song_by =:song_by AND price =:price");
    $stmt->execute([':title' => $title, ':song_by'=>$songby, ':price' => $price]);
    $stmt2->execute([':title' => $title, ':song_by'=>$songby, ':price' => $price]);
    $prev_result = $stmt->fetch(PDO::FETCH_ASSOC);    
   	if (is_null($prev_result) || empty($prev_result)) {
	# code...
	header('Location:freemusic.php');
	}
  $category = 'tracks'; 
  }
  if (isset($_GET['freesingles'])) {
  	# code...
  	$title = $_GET['freesingles'];
    $songby = $_GET['songby'];
  	$price = 0;
    $stmt = $pdo->prepare("SELECT * FROM singlestbl WHERE title =:title AND song_by =:song_by AND price =:price");
    $stmt2 = $pdo->prepare("SELECT * FROM singlestbl WHERE title =:title AND song_by =:song_by AND price =:price");
    $stmt->execute([':title' => $title, ':song_by'=>$songby, ':price' => $price]);
    $stmt2->execute([':title' => $title, ':song_by'=>$songby, ':price' => $price]);
    $prev_result = $stmt->fetch(PDO::FETCH_ASSOC);
   	if (is_null($prev_result) || empty($prev_result)) {
	# code...
	header('Location:freemusic.php');
	} 
  $category = 'singles';    
  }
  if (isset($_GET['freealbums'])) {
  	# code...
  	$title = $_GET['freealbums'];
    $songby = $_GET['songby'];
  	$price = 0;
    $stmt = $pdo->prepare("SELECT accounttbl.company_name, albumstbl.id, albumstbl.title, albumstbl.price, albumstbl.featured, albumstbl.image, albumstbl.account_id FROM albumstbl INNER JOIN accounttbl ON accounttbl.id = albumstbl.account_id WHERE albumstbl.title =:title AND accounttbl.company_name =:song_by AND albumstbl.price =:price");
    $stmt->execute([':title' => $title, ':song_by'=>$songby, ':price' => $price]);
    $prev_result = $stmt->fetch(PDO::FETCH_ASSOC);
   	if (is_null($prev_result) || empty($prev_result)) {
	# code...
	header('Location:freemusic.php');
	}     
  $main_category = 'albums';      
  $category = 'tracks'; 
	// fetch tracks
	$album_id = $prev_result['id'];
    $stmt2 = $pdo->prepare("SELECT * FROM trackstbl WHERE album_id =:album_id AND price =:price");
    $stmt2->execute([':album_id' => $album_id, ':price' => $price]);

  }  




?>