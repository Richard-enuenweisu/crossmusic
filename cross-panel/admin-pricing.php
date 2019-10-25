<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ADMIN_ID'])) {
  permission_error('admin-login.php');
}

if (isset($_POST['submit'])) {
  # code...
	$price = ((isset($_POST['price']))?sanitize($_POST['price']): '');
	$errors = array();

	if (empty($price)) {
	$errors[].= 'Price field must not be empty'.'<br>';
	}
	if (empty($errors)) {

 	$price_query = $pdo->prepare("UPDATE pricingtbl SET `price`=:price WHERE id = :acc_id");
	$price_query->execute([':price' =>$price, ':acc_id' =>1 ]); 	
	$success = 'Price determined Successfully! ';
	header("refresh:2;url=admin-pricing.php");
	// artistLogin($u_id);
	}
}


include str_replace("\\","/",dirname(__FILE__).'/assets/include/header.php');
include str_replace("\\","/",dirname(__FILE__).'/assets/include/headbar.php');
?>
<style type="text/css">
	.pro-s{
	font-size: 18px;font-style: italic;font-weight: bold		
	}
</style>
	<main class="u-main" role="main">
			<!-- Sidebar -->
		<?php
		  include str_replace("\\","/",dirname(__FILE__).'/assets/include/nav.php');
		?>	
			<div class="u-content">
				<div class="u-body">
					<h1 class="h2 font-weight-semibold mb-4">Price Determinant</h1>
					<div class="card mb-4">
						<div class="card-body">							
							<div class="row push">
								<div class="col-md-4 d-lg-flex flex-column align-items-center justify-content-center border-md-right border-light">
									<center><img src="assets/img/migrate-img.png" style="width: 90%;"></center>
								</div>
								<div class="col-md-8">																    
								    <h1>Determine Account Price</h1>								  
									<form action="admin-pricing.php" method="POST" class="push">										
					                      <div class="row">
					                        <?php if(isset($success)){ ?>
					                          <div class="form-control alert alert-success fade show" role="alert">
					                            <i class="fa fa-check-circle alert-icon mr-3"></i>
					                            <p class="text-white"> <?php echo $success; ?></p>
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
										<div class="form-group mb-4 push">
											<label for="email">Enter Price</label>
											<input id="email" class="form-control " name="price" type="text" placeholder="Enter Account Price" value="<?=((isset($price))?$price:'');?>">
										</div>		
										<button class="btn custom-btn " type="submit" name="submit">Set Price</button>			
									</form>
									<br>
									<span class="small">Tip: Alwats test your link to see that it takes you to the desired page before sharing.</span>								    
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>