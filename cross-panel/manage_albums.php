<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/assets/PHP-MP3-master/phpmp3.php');

if (!isset($_SESSION['ARTIST_ID'])) {
  permission_error('login.php');
}else{
	$artist_id = $_SESSION['ARTIST_ID'];
	$stmt = $pdo->query("SELECT * FROM accounttbl WHERE id = $artist_id ");
	$acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$acct_type = $acc_result['acct_type'];		
}

if (isset($_POST["add"])) {
    $artcover = $_FILES['artcover']['name'];
    $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
    $title = str_replace('&#039;',"",$title);
    // $title = str_replace(';',"",$title);
    $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
    //account verification
    if (!$acct_type == 'Paid Account') {
    	# code...
    	$price = 0;
    }
    //get cover extension
    $cover_piece = explode('.', $artcover);
    @$cover_name = $cover_piece[0];
    @$cover_ext = $cover_piece[1];
    //get track extension

    $errors = array();
    $success;

    if (empty($artcover) || empty($title) || empty($price) ) {
      # code...
      $errors[].= "Found empty fields!.";
    }    
    $allowed_image_extension = array(
        "jpg",
        "jpeg"
    );   
    // Get image file extension
    $artcover_extension = pathinfo($_FILES["artcover"]["name"], PATHINFO_EXTENSION);    
  // Validate file input to check if is with valid extension
    if (!in_array($artcover_extension, $allowed_image_extension)) {
        $errors[].= "Only jpg and jpeg are allowed.";
    }
    // Validate image file size
    if (($_FILES["artcover"]["size"] > 307200)) {
        $errors[].= "Image size exceeds 300Kb";
    }    
    if(empty($errors)) {
    	// set track path
    	$timestamp = date('m j Y g-i');
        // set artcover path
        $cover_target = "../images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
        $cover_path = "images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
        if (move_uploaded_file($_FILES["artcover"]["tmp_name"], $cover_target)) {
			//insert into albumstbl
            $insert_query = $pdo->prepare("INSERT INTO  albumstbl ( `account_id`, `title`, `price`, `image`) VALUES (:account_id, :title, :price, :image)");
            $insert_query->execute([':account_id' =>$artist_id, ':title' =>$title, ':price'=>$price, ':image'=>$cover_path]);      
            $success = "Uploaded successfully.";

        } else {
            $errors[].= "Problem in uploading single.";
        }
    }
}  

if (isset($_GET['edit'])) {
	# code...
	$album_id = $_GET['edit'];
	$album_query = $pdo->prepare("SELECT * FROM albumstbl WHERE id =:album_id");
	$album_query->execute([':album_id'=>$album_id]);
	$album = $album_query->fetch(PDO::FETCH_ASSOC);

	//edit singles
	if (isset($_POST['edit'])) {
		# code...
	    $artcover = $_FILES['artcover']['name'];
	    $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
	    $title = str_replace('&#039;',"",$title);
	    $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');

	    // account verification
	    if (!$acct_type == 'Paid Account') {
	    	# code...
	    	$price = 0;
	    }	    
	    //get cover extension
	    $cover_piece = explode('.', $artcover);
	    @$cover_name = $cover_piece[0];
	    @$cover_ext = $cover_piece[1];

	    $success;    
	    $allowed_image_extension = array(
	        "jpg",
	        "jpeg"
	    );  
	    // Get image file extension
	    $artcover_extension = pathinfo($_FILES["artcover"]["name"], PATHINFO_EXTENSION);    
		// set track path
		$timestamp = date('m j Y g-i');
	    // set artcover path
	    $cover_target = "../images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
	    $cover_path = "images/art/" .$cover_name.$timestamp.'.'.$cover_ext;


	    if (isset($title) && !empty($title)) {
	      # code...
	      $stmt =$pdo->prepare("UPDATE `albumstbl` SET `title`=:title WHERE id =:edit_id");
	      $stmt->execute([':title'=>$title, ':edit_id'=>$album_id]);
	      $success ='Updated successfully.';
	      header('refresh:2; url = manage_albums.php?edit='.$album_id);
	    }
	    if (isset($price) && !empty($price) && $price <= 200) {
	      # code...
	      $stmt =$pdo->prepare("UPDATE `albumstbl` SET `price`=:price WHERE id =:edit_id");
	      $stmt->execute([':price'=>$price, ':edit_id'=>$album_id]);
	      $success =' Updated successfully.';
	      header('refresh:2; url = manage_albums.php?edit='.$album_id);
	    }      
	    // update art cover
	    if (isset($artcover) && !empty($artcover)) {
		      # code...
	    	$errors = array();
		    $unlink_image = '../'.$album['image'];
			@unlink($unlink_image);
		  	// Validate file input to check if is with valid extension
		    if (!in_array($artcover_extension, $allowed_image_extension)) {
		        $errors[].= "Only jpg and jpeg are allowed.";
		    }
		    // Validate image file size
		    if (($_FILES["artcover"]["size"] > 307200)) {
		        $errors[].= "Image size exceeds 300Kb";
		    }  			

			 // move_uploaded_file($_FILES["artcover"]["tmp_name"], $cover_target)
	        if (move_uploaded_file($_FILES["artcover"]["tmp_name"], $cover_target) && empty($errors)) {
			//update cover				      	
		      $stmt =$pdo->prepare("UPDATE `albumstbl` SET `image`=:image WHERE id =:edit_id");
		      $stmt->execute([':image'=>$cover_path, ':edit_id'=>$album_id]);
		      $success= 'Updated successfully.';
		      header('refresh:2; url = manage_albums.php?edit='.$album_id);
	        } else {
	            $errors[].= "Artcover not updated";
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
	span.hidden-xs{
		content: none;
	}	
/*	span.hidden-xs:after{
		content: none;
	}*/
</style>
			<div class="u-content">
				<div class=" u-body">
					<h1 class="h2 font-weight-semibold mb-4"><?=(isset($_GET['edit']))?'Edit':'Add'?> Albums</h1>
		<main class="container-fluid " role="main">
			<div class="row">
				<div class="col-lg-6 d-flex flex-column justify-content-center align-items-center bg-white mnh-100vh">
						<a class="u-login-form py-3 text-center" href="index.html">
							<!-- <img class="img-fluid" src="./assets/img/logo.png" width="80" alt="Cross logo">						 -->
						</a>					
					<div class="u-login-form">
						<form class="mb-3" method="POST" action="manage_albums.php<?=(isset($_GET['edit']))?'?edit='.$album_id:''?>" enctype="multipart/form-data">
							<div class="mb-3">
								<h1 class="h2"><?=(isset($_GET['edit']))?'Edit':'Upload'?> your Album</h1>
								<p class="small">All album price are best sold between &#8358;500 and &#8358;1000 to encourage patronage.</p>
							</div>
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
							<label for="email">Album Artcover</label>
							<span class="small text-muted" style="font-style: italic;font-weight: bold;"><?=(isset($_GET['edit']))? $album['image']:''?></span>
				            <div class="file-loading form-group mb-4">				            	
				                <input id="file-2" type="file" class="file" data-show-upload="false" data-theme="fas" accept="image/*" name="artcover" value="<?=(isset($_GET['edit']))? $album['image']:''?>">
				            </div>												
							<div class="form-group mb-4">
								<label for="email">Title</label>
								<input id="email" class="form-control" name="title" type="text" placeholder="Title" value="<?=(isset($_GET['edit']))? $album['title']:''?>">
							</div>
							<?php if($acct_type == 'Paid Account'){?>
							<div class="form-group mb-4">
								<label for="password">Price</label>
								<input id="password" class="form-control" name="price" type="text" placeholder="Price e.g &#8358;100" value="<?=(isset($_GET['edit']))? $album['price']:''?>">
							</div>
							<?php } ?>																							
							<button class="btn custom-btn btn-block" type="submit" name="<?=(isset($_GET['edit']))?'edit':'add'?>"><?=(isset($_GET['edit']))?'Edit':'Add'?> Album</button>
						</form>
					</div>

					<div class="u-login-form text-muted py-3 mt-auto">
						<!-- <small><i class="far fa-question-circle mr-1"></i> If you are not able to make request, please <a href="#" style="color: #333;">contact us</a>.</small> -->
					</div>
				</div>

				<div class="col-lg-6 d-none d-lg-flex flex-column align-items-center justify-content-center bg-light">
					<img class="position-relative u-z-index-3 " src="./assets/img/cash-out.png" alt="Image description" style="width: 90%;">
				</div>
			</div>
		</main>
	</div>
</div>
<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>