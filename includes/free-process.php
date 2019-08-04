<?php

  if (isset($_GET['freetracks'])) {
  	# code...
  	$title = $_GET['freetracks'];
  	$price = '';
    $stmt = $pdo->prepare("SELECT * FROM trackstbl WHERE title =:title AND price =:price");
    $stmt2 = $pdo->prepare("SELECT * FROM trackstbl WHERE title =:title AND price =:price");
    $stmt->execute([':title' => $title, ':price' => $price]);
    $stmt2->execute([':title' => $title, ':price' => $price]);
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
  	$price = '';
    $stmt = $pdo->prepare("SELECT * FROM singlestbl WHERE title =:title AND price =:price");
    $stmt2 = $pdo->prepare("SELECT * FROM singlestbl WHERE title =:title AND price =:price");
    $stmt->execute([':title' => $title, ':price' => $price]);
    $stmt2->execute([':title' => $title, ':price' => $price]);
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
  	$price = '';
    $stmt = $pdo->prepare("SELECT * FROM albumstbl WHERE title =:title AND price =:price");
    $stmt->execute([':title' => $title, ':price' => $price]);
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