<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['USER_ID'])) {
  permission_error('login.php');
}

if (isset($_POST["submit"])) {

    $title =((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
    $description =((isset($_POST['description']) && $_POST['description'] != '')? $_POST['description']:'');
    $name = $_FILES['image']['name'];
    $errors = array();
    $success;
    if (!isset($title) || empty($title)) {
      # code...
      $errors[].= "Please enter sermon title.";
    }
    if (!isset($description) || empty($description)) {
      # code...
      $errors[].= "Please enter confession description.";
    } 
    // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["image"]["tmp_name"]);
    // var_dump($fileinfo );
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    
    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );
    // Get image file extension
    $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);    
    // Validate file input to check if is not empty
    if (empty($name)) {
        $errors[].= "Choose image file to upload.";
    }    // Validate file input to check if is with valid extension
    if (!in_array($file_extension, $allowed_image_extension)) {
        $errors[].= "Upload valiid images. Only PNG and JPEG are allowed.";
    }    // Validate image file size
    if (($_FILES["image"]["size"] > 300000)) {
        $errors[].= "Image size exceeds 300KB";
    }    // Validate image file dimension
    if ($width > "842" || $height > "842") {
        $errors[].= "Image dimension should be within 842X842";
    }
    if(empty($errors)) {
        $target = "../confessions/art/" . basename($_FILES["image"]["name"]);
        $dbpath = "confessions/art/" . basename($_FILES["image"]["name"]);
        $get_time = date('Y-m-d h:i:s', time());
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
            $insert_query = $pdo->prepare("INSERT INTO confessionstbl (`title`, `posted_by`, `post_time`, `description`, `image`) VALUES (:title, :posted_by, :post_time, :description, :image)");
            $insert_query->execute([':title' =>$title, ':posted_by' =>'Admin', ':post_time' =>$get_time, ':description' =>$description, 'image'=>$dbpath]);            
            $success = "Confession Added successfully.";
        } else {
            $errors[].= "Problem in adding confession.";
        }
    }
}

if (isset($_GET['edit'])) {
  # code...
  $edit = intval($_GET['edit']);
  $con_query = $pdo->query("SELECT * FROM confessionstbl WHERE id = $edit");
  $edit_details = $con_query->fetch(PDO::FETCH_ASSOC);

// Edit Sermon script
if (isset($_POST['edit'])) {
  # code...
    $edit_id = $edit_details['id'];
    // var_dump($edit_details['id']);
    $title =((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
    $description =((isset($_POST['description']) && $_POST['description'] != '')? $_POST['description']:'');
    $name = $_FILES['image']['name'];
    $errors = array();
    $success;

    // echo $title.' '.$source.' '. $name = $_FILES['image']['name'].' '. $name = $_FILES['image']['tmp_name'];; 

    if (!isset($title) || empty($title)) {
      # code...
      $errors[].= "Please enter sermon title.";
    }
    if (!isset($description) || empty($description)) {
      # code...
      $errors[].= "Please enter sermon description.";
    } 
    // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["image"]["tmp_name"]);
    // var_dump($fileinfo );
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    
    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );
    // Get image file extension
    $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);    
    // Validate file input to check if is not empty
    if (empty($name)) {
        $errors[].= "Choose image file to upload.";
    }    // Validate file input to check if is with valid extension
    if (!in_array($file_extension, $allowed_image_extension)) {
        $errors[].= "Upload valiid images. Only PNG and JPEG are allowed.";
    }    // Validate image file size
    if (($_FILES["image"]["size"] > 300000)) {
        $errors[].= "Image size exceeds 300KB";
    }    // Validate image file dimension
    if ($width > "842" || $height > "842") {
        $errors[].= "Image dimension should be within 842X842";
    }
    if(empty($errors)) {
        $target = "../confessions/art/" . basename($_FILES["image"]["name"]);
        $dbpath = "confessions/art/" . basename($_FILES["image"]["name"]);
        // Get Current time
        $get_time = date('Y-m-d h:i:s', time());
        // Delele the previous file
        $delete_path = '../'.$edit_details['image'];
        unlink($delete_path);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
             $insert_query = $pdo->prepare("UPDATE confessionstbl SET `title`=:title, `posted_by`=:posted_by, `post_time`=:post_time, `description`=:description, `image`=:image WHERE id = $edit_id");
            $insert_query->execute([':title' =>$title, ':posted_by' =>'Admin', ':post_time' =>$get_time, ':description' =>$description, 'image'=>$dbpath]);            
            $success = "Confession updated successfully.";
        } else {
            $errors[].= "Problem in updating confession.";
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
					<h1 class="h2 font-weight-semibold mb-4"><?=(isset($_GET['edit']))?'Edit':'Add'?> Confessions </h1>

					<div class="card mb-4">
						<div class="card-body">
							<form method="POST" action="manage_confessions.php<?=(isset($_GET['edit']))?'?edit='.$edit:''?> " enctype="multipart/form-data">
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
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-6">
									<div class="input-container">
                  <div class="file-upload">
                    <button class="file-upload-btn form-control" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Feature Image</button>

                    <div class="image-upload-wrap">
                      <input class="file-upload-input form-control" type='file' name="image" onchange="readURL(this);" accept="image/*" />
                      <div class="drag-text">
                        <h3>Drag and drop a file or select add Image</h3>
                      </div>
                    </div>
                    <?php if (isset($_GET['edit'])){?>
                      <img class="img-fluid" src="../<?=(isset($_GET['edit']))? $edit_details['image']:'#'?>" alt="your image" /> 
                      <?php } ?>                     
                    <div class="file-upload-content">
                      <img class="file-upload-image" src="#" alt="your image" />
                      <div class="image-title-wrap">
                        <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                      </div>
                    </div>
                  </div>
                <div class="row">
                    <div class="form-group col-md-12">
                      <!-- <label for="defaultInput1">Enter Amount</label> -->
                      <input id="defaultInput1" class="form-control form-pill" type="text" placeholder="Enter Confession title" aria-describedby="emailHelp" name="title" value="<?=(isset($_GET['edit']))? $edit_details['title']:''?>">
                    </div>                                                        
                </div>                  
                <div class="row">
                    <div class="form-group col-md-12">
                      <textarea class="form-control" id="#myTextarea" name="description" rows="3" placeholder="Enter confession description">
                        <?=(isset($_GET['edit']))?$edit_details['description']:''?>
                      </textarea>
                    </div>                                                         
                </div>										
										<div class="form-group col-md-12">
											<!-- <label for="defaultInput1">Continue</label> -->
											<button id="defaultInput1" class="form-control form-pill btn-secondary" name="<?=(isset($_GET['edit']))?'edit':'submit'?>" type="submit"><?=(isset($_GET['edit']))?'Edit':'Add'?> Confession
											</button>
										</div>										
									</div>	
									<div class="col-md-3"></div>																	
								</div>
							</form>
						</div>
					</div>

				</div>

<script type="text/javascript">
function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
});
</script>
<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>