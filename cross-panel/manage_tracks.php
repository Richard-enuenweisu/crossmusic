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
if (isset($_GET['album_id']) && !empty($_GET['album_id'])) {
	# code...
	$album_id = $_GET['album_id'];
}
if (isset($_POST["add"])) {
    $artcover = $_FILES['artcover']['name'];
    $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
    $title = str_replace('&#039;',"",$title);
    $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
    $duration = ((isset($_POST['duration']) && $_POST['duration'] != '')?sanitize($_POST['duration']):'');
    $track = $_FILES['track']['name'];

    if (!$acct_type == 'Paid Account') {
    	# code...
    	$price = 0;
    }
    //get cover extension
    $cover_piece = explode('.', $artcover);
    @$cover_name = $cover_piece[0];
    @$cover_ext = $cover_piece[1];
    //get track extension
    $track_piece = explode('.', $track);
    @$track_name = $track_piece[0];
    @$track_ext = $track_piece[1];

    $errors = array();
    $success;

    if (empty($artcover) || empty($title) || empty($price) || empty($duration) || empty($track)) {
      # code...
      $errors[].= "Found empty fields!.";
    }    
    $allowed_image_extension = array(
        "jpg",
        "jpeg"
    );
    $allowed_track_extension = array(
        "mp3",
        "ogg"
    );    
    // Get image file extension
    $artcover_extension = pathinfo($_FILES["artcover"]["name"], PATHINFO_EXTENSION);    
    $track_extension = pathinfo($_FILES["track"]["name"], PATHINFO_EXTENSION);    
  // Validate file input to check if is with valid extension
    if (!in_array($artcover_extension, $allowed_image_extension)) {
        $errors[].= "Only jpg and jpeg are allowed.";
    }
  // Validate file input to check if is with valid extension
    if (!in_array($track_extension, $allowed_track_extension)) {
        $errors[].= "Only mp3 and 0gg are allowed.";
    }
    // Validate image file size
    if (($_FILES["artcover"]["size"] > 307200)) {
        $errors[].= "Image size exceeds 300Kb";
    }    
    // Validate image file size
    if (($_FILES["track"]["size"] > 20971520)) {
        $errors[].= "track size exceeds 20MB";
    }
    if(empty($errors)) {
    	// set track path
    	$timestamp = date('m j Y g-i');
        $track_target = "../music/".$track_name.$timestamp.'.'.$track_ext;
        $track_path = "music/".$track_name.$timestamp.'.'.$track_ext;
        // set artcover path
        $cover_target = "../images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
        $cover_path = "images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
        if (move_uploaded_file($_FILES["track"]["tmp_name"], $track_target)  && move_uploaded_file($_FILES["artcover"]["tmp_name"], $cover_target)) {
		//Extract 30 seconds starting after 10 seconds.
			$path = $track_target;
			$mp3 = new PHPMP3($path);
			@$mp3_1 = $mp3->extract(10,30);
			$short_track = $mp3_1->save('../music/short_'.$track_name.$timestamp.'.'.$track_ext); 
			//short-track path
			$short_track_path = 'music/short_'.$track_name.$timestamp.'.'.$track_ext;  
			      	
            $insert_query = $pdo->prepare("INSERT INTO  trackstbl ( `album_id`, `title`, `price`, `duration`, `short_url`, `long_url`, `image`) VALUES (:album_id, :title, :price, :duration, :short_url, :long_url, :image)");
            $insert_query->execute([':album_id' =>$album_id, ':title' =>$title, ':price'=>$price, ':duration'=>$duration, ':short_url'=>$short_track_path, ':long_url'=>$track_path, ':image'=>$cover_path]);            
            $success = "Uploaded successfully.";
        } else {
            $errors[].= "Problem in uploading single.";
        }
    }
}  
//edit tracks
if (isset($_GET['edit'])) {
	# code...
	$track_id= $_GET['edit'];
	$track_query = $pdo->prepare("SELECT * FROM trackstbl WHERE id =:track_id");
	$track_query->execute([':track_id'=>$track_id]);
	$track_details = $track_query->fetch(PDO::FETCH_ASSOC);

	//edit singles
	if (isset($_POST['edit'])) {
		# code...
	    $artcover = $_FILES['artcover']['name'];
	    $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
	    $title = str_replace('&#039;',"",$title);
	    $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
	    $duration = ((isset($_POST['duration']) && $_POST['duration'] != '')?sanitize($_POST['duration']):'');
	    $track = $_FILES['track']['name'];

	    // account verification
	    if (!$acct_type == 'Paid Account') {
	    	# code...
	    	$price = 0;
	    }	    
	    //get cover extension
	    $cover_piece = explode('.', $artcover);
	    @$cover_name = $cover_piece[0];
	    @$cover_ext = $cover_piece[1];
	    //get track extension
	    $track_piece = explode('.', $track);
	    @$track_name = $track_piece[0];
	    @$track_ext = $track_piece[1];

	    $success;    
	    $allowed_image_extension = array(
	        "jpg",
	        "jpeg"
	    );
	    $allowed_track_extension = array(
	        "mp3",
	        "ogg"
	    );    
	    // Get image file extension
	    $artcover_extension = pathinfo($_FILES["artcover"]["name"], PATHINFO_EXTENSION);    
	    $track_extension = pathinfo($_FILES["track"]["name"], PATHINFO_EXTENSION);    
	  

		// set track path
		$timestamp = date('m j Y g-i');
	    $track_target = "../music/".$track_name.$timestamp.'.'.$track_ext;
	    $track_path = "music/".$track_name.$timestamp.'.'.$track_ext;
	    // set artcover path
	    $cover_target = "../images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
	    $cover_path = "images/art/" .$cover_name.$timestamp.'.'.$cover_ext;


	    if (isset($title) && !empty($title)) {
	      # code...
	      $stmt =$pdo->prepare("UPDATE `trackstbl` SET `title`=:title WHERE id =:edit_id");
	      $stmt->execute([':title'=>$title, ':edit_id'=>$track_id]);
	      $success ='Updated successfully.';
	      header('refresh:2; url = manage_tracks.php?edit='.$track_id);
	    }
	    if (isset($price) && !empty($price) && $price <= 200) {
	      # code...
	      $stmt =$pdo->prepare("UPDATE `trackstbl` SET `price`=:price WHERE id =:edit_id");
	      $stmt->execute([':price'=>$price, ':edit_id'=>$track_id]);
	      $success =' Updated successfully.';
	      header('refresh:2; url = manage_tracks.php?edit='.$track_id);
	    }   
	    if (isset($duration) && !empty($duration)) {
	      # code...
	      $stmt =$pdo->prepare("UPDATE `trackstbl` SET `duration`=:duration WHERE id =:edit_id");
	      $stmt->execute([':duration'=>$duration, ':edit_id'=>$track_id]);
	      $success = 'Updated successfully.';
	      header('refresh:2; url = manage_tracks.php?edit='.$track_id);
	    }     
	    if (isset($track) && !empty($track)) {
		      # code...
	    	$errors = array();
		    $unlink_long = '../'.$track_details['long_url'];
		    $unlink_short = '../'.$track_details['short_url'];
			@unlink($unlink_long);
			@unlink($unlink_short);
		  // Validate file input to check if is with valid extension
		    if (!in_array($track_extension, $allowed_track_extension)) {
		        $errors[].= "Only mp3 and 0gg are allowed.";
		    }		
		    // Validate image file size
		    if (($_FILES["track"]["size"] > 20971520)) {
		        $errors[].= "track size exceeds 20MB";
		    }    	

			 //update track
	        if (move_uploaded_file($_FILES["track"]["tmp_name"], $track_target) && empty($errors)) {
			//Extract 30 seconds starting after 10 seconds.
				$path = $track_target;
				$mp3 = new PHPMP3($path);
				@$mp3_1 = $mp3->extract(10,30);
				$short_track = $mp3_1->save('../music/short_'.$track_name.$timestamp.'.'.$track_ext); 
				//short-track path
				$short_track_path = 'music/short_'.$track_name.$timestamp.'.'.$track_ext;  
				      	
		      $stmt =$pdo->prepare("UPDATE `trackstbl` SET `short_url`=:short_url,`long_url`=:long_url WHERE id =:edit_id");
		      $stmt->execute([':short_url'=>$short_track_path, ':long_url'=>$track_path, ':edit_id'=>$track_id]);
		      $success='Updated successfully.';
		      header('refresh:2; url = manage_singles.php?edit='.$track_id);
	        } else {
	            $errors[].= "Track not updated.";
	        }
	    }  
	    // update art cover
	    if (isset($artcover) && !empty($artcover)) {
		      # code...
	    	$errors = array();
		    $unlink_image = '../'.$track['image'];
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
		      $stmt =$pdo->prepare("UPDATE `trackstbl` SET `image`=:image WHERE id =:edit_id");
		      $stmt->execute([':image'=>$cover_path, ':edit_id'=>$track_id]);
		      $success= 'Updated successfully.';
		      header('refresh:2; url = manage_tracks.php?edit='.$track_id);
	        } else {
	            $errors[].= "Artcover not updated";
	        }
	    }  	           
	}

}




if (isset($_GET['delete'])) {
	# code...
	// $del = intval($_GET['delete']);
 // 	$insert_query = $pdo->prepare(" DELETE FROM givetbl WHERE id = :delete_id");
	// $insert_query->execute([':delete_id' =>$del]); 
	// $success = "Transaction Deleted Successfully! Refreshing in 2 secs.";
	// header("refresh:2;url=confessions.php");
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
			<h1 class="h2 font-weight-semibold mb-4"><?=(isset($_GET['edit']))?'Edit':'Add'?> Tracks</h1>
		<main class="container-fluid " role="main">
			<div class="row">
				<div class="col-lg-6 d-flex flex-column justify-content-center align-items-center bg-white mnh-100vh">
						<a class="u-login-form py-3 text-center" href="index.html">
							<!-- <img class="img-fluid" src="./assets/img/logo.png" width="80" alt="Cross logo">						 -->
						</a>					
					<div class="u-login-form">
						<form class="mb-3" method="POST" action="manage_tracks.php<?=(isset($_GET['edit']))?'?edit='.$track_id:''?>" enctype="multipart/form-data">
							<div class="mb-3">
								<h1 class="h2"><?=(isset($_GET['edit']))?'Edit':'Upload'?> your tracks</h1>
								<p class="small">All track price are best sold between &#8358;100 and &#8358;200 to encourage patronage.</p>
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
							<label for="email">Track Artcover</label>
							<span class="small text-muted" style="font-style: italic;font-weight: bold;"><?=(isset($_GET['edit']))? $track_details['image']:''?></span>
				            <div class="file-loading form-group mb-4">				            	
				                <input id="file-2" type="file" class="file" data-show-upload="false" data-theme="fas" accept="image/*" name="artcover" value="<?=(isset($_GET['edit']))? $track_details['image']:''?>">
				            </div>												
							<div class="form-group mb-4">
								<label for="email">Title</label>
								<input id="email" class="form-control" name="title" type="text" placeholder="Title" value="<?=(isset($_GET['edit']))? $track_details['title']:''?>">
							</div>
							<?php if($acct_type == 'Paid Account'){?>
							<div class="form-group mb-4">
								<label for="password">Price</label>
								<input id="password" class="form-control" name="price" type="text" placeholder="Price e.g &#8358;100" value="<?=(isset($_GET['edit']))? $track_details['price']:''?>">
							</div>
							<?php } ?>														
							<div class="form-group mb-4">
								<label for="email">Duration</label>
								<input id="email" class="form-control" name="duration" type="text" placeholder="Duration e.g 02:45" value="<?=(isset($_GET['edit']))? $track_details['duration']:''?>">
							</div>
							<div class="form-group mb-4">
								<label for="email">Track</label>
								<span class="small text-muted" style="font-style: italic;font-weight: bold;"><?=(isset($_GET['edit']))? $track_details['long_url']:''?></span>
		                        <div class="file-loading">                          
		                          <input class="file" name="track" id="file-1" type="file" data-show-upload="false" data-theme="fas" data-show-preview="false" accept="audio/*" onchange="uploadFile()" value="<?=(isset($_GET['edit']))? $track_details['track']:''?>">
		                          <!-- <label tabindex="0" for="my-audio" class="input-audio-trigger" style="margin-bottom: 0px;">Select Audio...</label>                     -->
		                        </div>
		                        <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
		                        <h3 id="status"></h3>
		                        <p id="loaded_n_total"></p>
		                        <br>                       
                        	<p class="audio-return"></p>  
							</div>														
							<button class="btn custom-btn btn-block" type="submit" name="<?=(isset($_GET['edit']))?'edit':'add'?>"><?=(isset($_GET['edit']))?'Edit':'Add'?> Track</button>
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

<script>
	// progress bar script
	function _(el) {
	  return document.getElementById(el);
	}

	function uploadFile() {
	  var file = _("file-1").files[0];
	  // alert(file.name+" | "+file.size+" | "+file.type);
	  var formdata = new FormData();
	  formdata.append("file-1", file);
	  var ajax = new XMLHttpRequest();
	  ajax.upload.addEventListener("progress", progressHandler, false);
	  ajax.addEventListener("load", completeHandler, false);
	  ajax.addEventListener("error", errorHandler, false);
	  ajax.addEventListener("abort", abortHandler, false);
	  ajax.open("POST", ""); 
	  ajax.send(formdata);
	}

	function progressHandler(event) {
	  // _("loaded_n_total").innerHTML = "   Uploaded " + event.loaded + " bytes of " + event.total;
	  var percent = (event.loaded / event.total) * 100;
	  _("progressBar").value = Math.round(percent);
	  _("status").innerHTML = Math.round(percent) + "% Complete...";
	}

	function completeHandler(event) {
	  // _("status").innerHTML = event.target.responseText;
	  _("progressBar").value = 100; //wil clear progress bar after successful upload
	}

	function errorHandler(event) {
	  _("status").innerHTML = "Upload Failed";
	}

	function abortHandler(event) {
	  _("status").innerHTML = "Upload Aborted";
	}  
</script>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>