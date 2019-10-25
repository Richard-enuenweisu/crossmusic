<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['AFFILIATE_ID'])) {
  permission_error('login.php');
}else{
	$affiliate_id = $_SESSION['AFFILIATE_ID'];
	// var_dump($affiliate_id);
	$stmt = $pdo->query("SELECT * FROM aff_accounttbl INNER JOIN aff_userstbl ON aff_accounttbl.id = aff_userstbl.account_id 
		WHERE aff_accounttbl.id =$affiliate_id");
	$acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
}
if (isset($_POST['submit'])) {
  # code...
	$link = ((isset($_POST['link']))?sanitize($_POST['link']): '');

	$prefix = '&aff='.$affiliate_id;
	$errors = array();
	if (empty($link)) {
	$errors[].= 'link field must not be empty'.'<br>';
	}
	if (empty($errors)) {

	$actual_link = $link.$prefix;
	$long_url = urlencode($actual_link);
	$bitly_login = 'o_3imer2s9ir';
	$bitly_apikey = 'R_86d9c6da47eb485bb38e814bc4fe3dd0';
	$bitly_response = json_decode(file_get_contents("http://api.bit.ly/v3/shorten?login={$bitly_login}&apiKey={$bitly_apikey}&longUrl={$long_url}&format=json"));
	$short_url = $bitly_response->data->url;

	$success = '<span class="small">Link Generated Successfully! </span>'.'<br><span id="copy">'.$short_url.'</span>';
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
					<h1 class="h2 font-weight-semibold mb-4">Create Link</h1>
					<div class="card mb-4">
						<div class="card-body">							
							<div class="row push">
								<div class="col-md-4 d-lg-flex flex-column align-items-center justify-content-center border-md-right border-light">
									<center><img src="assets/img/migrate-img.png" style="width: 90%;"></center>
								</div>
								<div class="col-md-8">																    
								    <h1>Create Affiliate Link</h1>								  
									<form action="aff-link.php" method="POST" class="push">										
					                      <div class="row">
					                        <?php if(isset($success)){ ?>
					                          <div class="form-control alert alert-success fade show" role="alert">
					                            <i class="fa fa-check-circle alert-icon mr-3"></i>
					                            <p class="text-white"> <?php echo $success; ?></p>
					                            <button class="btn custom-btn btn-sm" onclick="copyToClipboard('#copy')"><i class="fas fa-copy"></i></button>
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
											<label for="email">Enter URL</label>
											<input id="email" class="form-control " name="link" type="text" placeholder="Enter URL" value="<?=((isset($link))?$link:'');?>">
										</div>		
										<button class="btn custom-btn " type="submit" name="submit">Create Link</button>			
									</form>
									<br>
									<span class="small"><b>Tips:</b> <br>
									1. The URL to enter is the link of the music project in paid music from the browser URL<br>
									2. Always test your link to see that it takes you to the desired page before sharing.<br>
									</span>								    
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<script type="text/javascript">
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}	
</script>			

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>