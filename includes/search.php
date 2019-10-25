<?php
if (isset($_POST['search'])) {
  # code...
  $category = ((isset($_POST['category']))?sanitize($_POST['category']): '');
  $type = ((isset($_POST['type']))?sanitize($_POST['type']): '');
  $title = ((isset($_POST['title']))?sanitize($_POST['title']): '');  
  $errors;  

  if ($category == '-- Category --' || $type == '-- Type --' || empty($title)) {
    # code...
    $errors ="<strong>Sorry,</strong> your search didn't match any record.";
  }

  if ($category == 'Albums' && $type =='Free') {
    # code...
    $stitle = '%'.$title.'%';
    $search_stmt = $pdo->prepare("SELECT * FROM albumstbl  WHERE title LIKE :title AND price = 0 AND featured = 1");
    $search_stmt->execute([':title' => $stitle]);
    $rows = $search_stmt->rowcount();
    if ($rows < 1) {
      # code...
          $errors ="<strong>Sorry,</strong> your search didn't match any record.";
    }else{
      header('Location: search-result.php?albums='.$title.'&type=free');        
    }
  }
    // search for singles
  if ($category == 'Singles' && $type =='Free') {
    # code...
    $stitle = '%'.$title.'%';
    $search_stmt = $pdo->prepare("SELECT * FROM singlestbl WHERE title LIKE :title AND price = 0 AND featured = 1");
    $search_stmt->execute([':title' => $stitle]);
    $rows = $search_stmt->rowcount();
    if ($rows < 1) {
      # code...
          $errors ="<strong>Sorry,</strong> your search didn't match any record.";
    }else{
      header('Location: search-result.php?singles='.$title.'&type=free');        
    } 
  }
    // search tracks
  if ($category == 'Tracks' && $type =='Free') {
    # code...
    $stitle = '%'.$title.'%';
    $search_stmt = $pdo->prepare("SELECT * FROM trackstbl WHERE title LIKE :title AND price = 0 AND featured = 1");
    $search_stmt->execute([':title' => $stitle]);
    $rows = $search_stmt->rowcount();
    if ($rows < 1) {
      # code...
          $errors ="<strong>Sorry,</strong> your search didn't match any record.";
    }else{
      header('Location: search-result.php?tracks='.$title.'&type=free');        
    }    
  } 

  //paid search begins here
  if ($category == 'Albums' && $type =='Paid') {
    # code...
    $stitle = '%'.$title.'%';
    $search_stmt = $pdo->prepare("SELECT * FROM albumstbl  WHERE title LIKE :title AND price > 0 AND featured = 1");
    $search_stmt->execute([':title' => $stitle]);
    $rows = $search_stmt->rowcount();
    if ($rows < 1) {
      # code...
          $errors ="<strong>Sorry,</strong> your search didn't match any record.";
    }else{
      header('Location: search-result.php?albums='.$title.'&type=paid');        
    }
  }
    // search for singles
  if ($category == 'Singles' && $type =='Paid') {
    # code...
    $stitle = '%'.$title.'%';
    $search_stmt = $pdo->prepare("SELECT * FROM singlestbl WHERE title LIKE :title AND price > 0 AND featured = 1");
    $search_stmt->execute([':title' => $stitle]);
    $rows = $search_stmt->rowcount();
    if ($rows < 1) {
      # code...
          $errors ="<strong>Sorry,</strong> your search didn't match any record.";
    }else{
      header('Location: search-result.php?singles='.$title.'&type=paid');        
    } 
  }
    // search tracks
  if ($category == 'Tracks' && $type =='Paid') {
    # code...
    $stitle = '%'.$title.'%';
    $search_stmt = $pdo->prepare("SELECT * FROM trackstbl WHERE title LIKE :title AND price > 0 AND featured = 1");
    $search_stmt->execute([':title' => $stitle]);
    $rows = $search_stmt->rowcount();
    if ($rows < 1) {
      # code...
          $errors ="<strong>Sorry,</strong> your search didn't match any record.";
    }else{
      header('Location: search-result.php?tracks='.$title.'&type=paid');        
    }    
  }       

}
?>