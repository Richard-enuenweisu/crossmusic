<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['USER_ID'])) {
  permission_error('login.php');
}

$sermon_query = $pdo->query("SELECT * FROM sermontbl ORDER BY id DESC LIMIT 15");

if (isset($_POST["submit"])) {
    $sermon = ((isset($_POST['sermon']) && $_POST['sermon'] != '')?sanitize($_POST['sermon']):'');
    $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
    $sermon_by = ((isset($_POST['sermon_by']) && $_POST['sermon_by'] != '')?sanitize($_POST['sermon_by']):'');
    $duration = ((isset($_POST['duration']) && $_POST['duration'] != '')?sanitize($_POST['duration']):'');
    $audio = $_FILES['message']['name'];

    $errors = array();
    $success;
    // echo $sermon.' '.$title.' '.$sermon_by.' '. $audio.' '.$_FILES["message"]["size"]; 
    $stmt = $pdo->prepare("SELECT * FROM sermontbl WHERE title =:title");
    $stmt->execute([':title' => $sermon]);
    $get_details = $stmt->fetch(PDO::FETCH_ASSOC);
    //get sermon id
    $get_id = intval($get_details['id']);

    if (!isset($title) || empty($title)) {
      # code...
      $errors[].= "Please enter sermon title.";
    }
    if (!isset($sermon_by) || empty($sermon_by)) {
      # code...
      $errors[].= "Please enter preacher";
    } 
    if (!isset($duration) || empty($duration)) {
      # code...
      $errors[].= "Please enter Duration";
    }     

    $allowed_image_extension = array(
        "mp3",
        "ogg"
    );
    // Get image file extension
    $file_extension = pathinfo($_FILES["message"]["name"], PATHINFO_EXTENSION);    
    // Validate file input to check if is not empty
    if (empty($audio)) {
        $errors[].= "Choose ausio file to upload.";
    }    // Validate file input to check if is with valid extension
    if (!in_array($file_extension, $allowed_image_extension)) {
        $errors[].= "Only Mp3 and Ogg are allowed.";
    }    // Validate image file size
    if (($_FILES["message"]["size"] > 100000000)) {
        $errors[].= "Image size exceeds 100MB";
    }
    if(empty($errors)) {
        $target = "../sermon/audio/" . basename($_FILES["message"]["name"]);
        $dbpath = "sermon/audio/" . basename($_FILES["message"]["name"]);
        if (move_uploaded_file($_FILES["message"]["tmp_name"], $target)) {
            $insert_query = $pdo->prepare("INSERT INTO  messagetbl ( `sermon_id`, `title`, `sermon_by`, `duration`, `path`) VALUES (:sermon_id, :title, :sermon_by , :duration, :mypath)");
            $insert_query->execute([':sermon_id' =>$get_id, ':title' =>$title, ':sermon_by'=>$sermon_by, ':duration'=>$duration, ':mypath'=>$dbpath]);            
            $success = "Uploaded successfully.";
        } else {
            $errors[].= "Problem in uploading sermon.";
        }
    }
}  

if (isset($_GET['edit'])) {
  # code...
  $edit = intval($_GET['edit']);
  $edit_query = $pdo->query("SELECT * FROM messagetbl WHERE sermon_id = $edit");
  $edit_details = $edit_query->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['edit'])) {

  var_dump($edit_details['id']);
  $edit_id = $edit_details['id'];
     
  $sermon = ((isset($_POST['sermon']) && $_POST['sermon'] != '')?sanitize($_POST['sermon']):'');
  $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
  $sermon_by = ((isset($_POST['sermon_by']) && $_POST['sermon_by'] != '')?sanitize($_POST['sermon_by']):'');
  $duration = ((isset($_POST['duration']) && $_POST['duration'] != '')?sanitize($_POST['duration']):'');
  // $audio = ((isset($_FILES['message']['name']) && $_POST['message'] != '')?sanitize($_POST['message']):'');

  $audio = $_FILES['message']['name'];

  $errors = array();
  $success;

  // echo $sermon.' '.$title.' '.$sermon_by.' '. $audio.' '.$_FILES["message"]["size"]; 

  if (!isset($title) || empty($title)) {
    # code...
    $errors[].= "Please enter sermon title.";
  } 
  if (!isset($sermon_by) || empty($sermon_by)) {
    # code...
    $errors[].= "Please enter preacher.";
  }   
  if (!isset($duration) || empty($duration)) {
    # code...
    $errors[].= "Please enter Duration";
  }     

  $allowed_image_extension = array(
      "mp3",
      "ogg"
  );
  // Get image file extension
  $file_extension = pathinfo($_FILES["message"]["name"], PATHINFO_EXTENSION);    
  // Validate file input to check if is not empty
  if (empty($audio)) {
      $errors[].= "Choose audio file to upload.";
  }    // Validate file input to check if is with valid extension
  if (!in_array($file_extension, $allowed_image_extension)) {
      $errors[].= "Only Mp3 and Ogg are allowed.";
  }    // Validate image file size
  if (($_FILES["message"]["size"] > 100000000)) {
      $errors[].= "Image size exceeds 100MB";
  }
  if(empty($errors)) {
      $target = "../sermon/audio/" . basename($_FILES["message"]["name"]);
      $dbpath = "sermon/audio/" . basename($_FILES["message"]["name"]);
      $delete_path = '../'.$edit_details['path'];
      unlink($delete_path);      
      if (move_uploaded_file($_FILES["message"]["tmp_name"], $target)) {
          $insert_query = $pdo->prepare("UPDATE `messagetbl` SET `sermon_id`=:sermon_id, `title`=:title, `sermon_by`=:sermon_by, 
            `duration`=:duration, `path`=:mypath WHERE `id`=:edit_id");
          $insert_query->execute([':sermon_id' =>$edit_id, ':title' =>$title, ':sermon_by'=>$sermon_by, ':duration'=>$duration, ':mypath'=>$dbpath, ':edit_id'=>$edit_id]);            
          $success = "Sermon Updated successfully.";
      } else {
          $errors[].= "Problem in Updating sermon.";
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
 
</style>
			<div class="u-content">
				<div class="u-body">
					<h1 class="h2 font-weight-semibold mb-4">Add Sermon Resources </h1>
					<div class="card mb-4">
						<div class="card-body">
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-6">
                    <form method="POST" action="sermon_resources.php<?=(isset($_GET['edit']))?'?edit='.$edit :''?>" enctype="multipart/form-data">
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
                              <i class="fa fa-minus-circle alert-icon mr-3"></i>
                              <span><?php echo display_errors($errors); ?></span>
                              <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        <?php } ?>
                      </div> 
                      <?php  if (!isset($_GET['edit'])){ ?>                  
                      <div class="row pusher">
                        <label for="defaultInput1">Select Sermon</label>                    
                        <select class="form-control form-pill" name="sermon">
                          <option>--Select Title--</option>
                          <?php while($sermon = $sermon_query->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option><?=$sermon['title'];?></option>
                          <?php endwhile;?>
                        </select>
                        <hr>
                      </div>
                      <?php } ?>                      
                      <div class="row pusher">
                          <div class="form-group col-md-12">
                            <input id="defaultInput1" class="form-control form-pill" name="title" type="text" placeholder="Enter Sermon title" aria-describedby="emailHelp" value="<?=(isset($_GET['edit']))?$edit_details['title']:''?>">
                          </div>                                                        
                      </div>
                      <div class="row">
                          <div class="form-group col-md-12">
                            <input id="defaultInput1" class="form-control form-pill" name="sermon_by" type="text" placeholder="Enter Preacher" aria-describedby="emailHelp" value="<?=(isset($_GET['edit']))?$edit_details['sermon_by']:''?>">
                          </div>                                                        
                      </div>
                      <div class="row">
                          <div class="form-group col-md-12">
                            <input id="defaultInput1" class="form-control form-pill" name="duration" type="text" placeholder="Enter Sermon Duration eg. 01:24:03" aria-describedby="emailHelp" value="<?=(isset($_GET['edit']))?$edit_details['duration']:''?>">
                          </div>                                                        
                      </div>                      
                      <div class="row push">
                        <div class="input-audio-container">                          
                          <input class="form-control input-audio" name="message" id="file1" type="file" accept="audio/*" onchange="uploadFile()">
                          <label tabindex="0" for="my-audio" class="input-audio-trigger" style="margin-bottom: 0px;">Select Audio...</label>                    
                        </div>
                        <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
                        <h3 id="status"></h3>
                        <p id="loaded_n_total"></p>

                        <br>                       
                        <p class="audio-return"></p>                                                
                      </div> 

                      <div class="row pusher">                    
                       <!-- <div class="form-group col-md-12"> -->
                        <!-- <label for="defaultInput1">Continue</label> -->
                        <button id="defaultInput1" class="form-control form-pill btn-secondary" name="<?=(isset($_GET['edit']))?'edit':'submit'?>" type="submit"><?=(isset($_GET['edit']))?'Edit':'Add'?> Sermon
                        </button>
                      <!-- </div>                     -->
                      </div>                                                                
                    </form>                    
                  </div>	
									<div class="col-md-3"></div>																	
								</div>
						</div>
					</div>
			</div>

<script type="text/javascript">
document.querySelector("html").classList.add('js');

// Second button
var fileInput2  = document.querySelector( ".input-audio" ),  
    button2    = document.querySelector( ".input-audio-trigger" ),
    the_return2 = document.querySelector(".audio-return");    

      
button2.addEventListener( "keydown", function( event ) {  
    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
        fileInput2.focus();  
    }  
});
button2.addEventListener( "click", function( event ) {
   fileInpu2.focus();
   return false;
});  
fileInput2.addEventListener( "change", function( event ) {  
    the_return2.innerHTML = this.value;  
});

// progress bar script
function _(el) {
  return document.getElementById(el);
}

function uploadFile() {
  var file = _("file1").files[0];
  // alert(file.name+" | "+file.size+" | "+file.type);
  var formdata = new FormData();
  formdata.append("file1", file);
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