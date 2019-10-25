<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/assets/PHP-MP3-master/phpmp3.php');

if (!isset($_SESSION['ADMIN_ID'])) {
  permission_error('admin-login.php');
}
if (isset($_GET['page-id'])) {
	# code...
	$id = $_GET['page-id'];
	var_dump($id);
}

if (isset($_POST["add"])) {
	$uname = ((isset($_POST['uname']) && $_POST['uname'] != '')?sanitize($_POST['uname']):'');
	$email = ((isset($_POST['email']) && $_POST['email'] != '')?sanitize($_POST['email']):'');
	$privilege = ((isset($_POST['privilege']) && $_POST['privilege'] != '')?sanitize($_POST['privilege']):'');
	$password = ((isset($_POST['password']) && $_POST['password'] != '')?sanitize($_POST['password']):'');	

    $errors = array();
    $success;

    if (empty($uname) || empty($email) || empty($privilege) || empty($password) ) {
      # code...
	    $errors[].= "Found empty fields!.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[].='email is not a valid email address'.'<br>';
	}
	if ($privilege == '--Select Privilege--') {
		# code...
		$errors[].= "Please choose a privilege";
	}

	$salted = 'Z%yHrcR8QDhF99CC^ZZ9qe!+k'.$password.'f+KA??dj7$S$HL4guq$yJ5_3b';
	$hashed = hash('sha224', $salted);

	$stmt = $pdo->prepare("SELECT * FROM admintbl WHERE email=:email AND password=:pass");
	$stmt->execute([':email' => $email, ':pass'=>$hashed]); 
	$row = $stmt->rowcount();
	$result =$stmt->fetch(PDO::FETCH_ASSOC);

	if ($row > 0) {
		$errors[].='users already exist!'.'<br>';
	}
	if (empty($errors)) {
        $insert_query = $pdo->prepare("INSERT INTO  admintbl (`uname`, `email`, `password`, `privilege`) VALUES (:uname, :email, :password, :privilege)");
        $insert_query->execute([':uname' =>$uname, ':email' =>$email, ':password'=>$hashed, ':privilege'=>$privilege]);      
        $success = "Admin Added successfully.";
	}
}  
if (isset($_GET['edit'])) {
	# code...
	$edit_id = $_GET['edit'];
	$admin_query = $pdo->prepare("SELECT * FROM admintbl WHERE id =:admin_id");
	$admin_query->execute([':admin_id'=>$edit_id]);
	$admin_details = $admin_query->fetch(PDO::FETCH_ASSOC);

	//edit singles
	if (isset($_POST['edit'])) {	
		$uname = ((isset($_POST['uname']) && $_POST['uname'] != '')?sanitize($_POST['uname']):'');
		// $email = ((isset($_POST['email']) && $_POST['email'] != '')?sanitize($_POST['email']):'');
		$privilege = ((isset($_POST['privilege']) && $_POST['privilege'] != '')?sanitize($_POST['privilege']):'');
		$password = ((isset($_POST['password']) && $_POST['password'] != '')?sanitize($_POST['password']):'');	

	    $errors = array();
	    $success;

	    if (empty($uname) || empty($privilege) || empty($password) ) {
	      # code...
		    $errors[].= "Found empty fields!.";
	    }
		if ($privilege == '--Select Privilege--') {
			# code...
			$errors[].= "Please choose a privilege";
		}
		$salted = 'Z%yHrcR8QDhF99CC^ZZ9qe!+k'.$password.'f+KA??dj7$S$HL4guq$yJ5_3b';
		$hashed = hash('sha224', $salted);

		if (empty($errors)) {
	        $insert_query = $pdo->prepare(" UPDATE `admintbl` SET `uname`= :uname, `password`=:password, `privilege` = :privilege WHERE id =:edit_id");
	        $insert_query->execute([':uname' =>$uname, ':password'=>$hashed, ':privilege'=>$privilege, ':edit_id'=>$edit_id]);      
	        $success = "Admin Edited successfully.";
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
					<h1 class="h2 font-weight-semibold mb-4"><?=(isset($_GET['edit']))?'Edit':'Add'?> Admin</h1>
		<main class="container-fluid " role="main">
			<div class="row">
				<div class="col-lg-6 d-flex flex-column justify-content-center align-items-center bg-white mnh-100vh">
						<a class="u-login-form py-3 text-center" href="index.html">
							<!-- <img class="img-fluid" src="./assets/img/logo.png" width="80" alt="Cross logo">						 -->
						</a>					
					<div class="u-login-form">
						<form class="mb-3" method="POST" action="manage-admins.php<?=(isset($_GET['edit']))?'?edit='.$edit_id:''?>">
							<div class="mb-3">
								<h1 class="h2"><?=(isset($_GET['edit']))?'Edit':'Add'?> Administrator</h1>
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
							<div class="form-group mb-4">
								<label for="email">Username</label>
								<input id="email" class="form-control" name="uname" type="text" placeholder="Username" value="<?=(isset($_GET['edit']))? $admin_details['uname']:''?>">
							</div>
							<div class="form-group mb-4">
								<label for="password">Email</label>
								<input id="password" class="form-control" <?=(isset($_GET['edit']))?'disabled':''?> name="email" type="email" placeholder="Email" value="<?=(isset($_GET['edit']))? $admin_details['email']:''?>">
							</div>
							<div class="form-group mb-4">
								<label for="email">Privilege</label>
								<select class="form-control" name="privilege">
									<option><?=(isset($_GET['edit']))? $admin_details['privilege']:'--Select Privilege--'?></option>
									<option>Admin</option>
									<option>Super Admin</option>
								</select>
							</div>
							<div class="form-group mb-4">
								<label for="password">Password</label>
								<input id="password" class="form-control" name="password" type="password" placeholder="Password" value="<?=(isset($_GET['edit']))?'':''?>">
							</div>
							<button class="btn custom-btn btn-block" type="submit" name="<?=(isset($_GET['edit']))?'edit':'add'?>"><?=(isset($_GET['edit']))?'Edit':'Add'?> Admin</button>
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