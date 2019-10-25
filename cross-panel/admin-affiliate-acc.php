<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ADMIN_ID'])) {
  permission_error('admin-login.php');
}
$stmt = $pdo->query("SELECT 
  	 aff_accounttbl.fname, aff_accounttbl.lname, aff_accounttbl.id, aff_banktbl.bank_name, aff_banktbl.bank_account, aff_banktbl.created_at FROM aff_banktbl INNER JOIN aff_accounttbl ON aff_banktbl.account_id = aff_accounttbl.id 
		ORDER BY aff_accounttbl.fname DESC");
$row = $stmt->rowcount();
if (isset($_GET['block'])) {
	# code...
	$block = intval($_GET['block']);
 	$del_query = $pdo->prepare("UPDATE artisttbl SET `featured`=:featured WHERE account_id = :block_id");
	// $del_query->execute([':featured' => 0, ':block_id' =>$block ]); 
	$success = "Blocked Successfully! Refreshing in 2 secs.";
	header("refresh:2;url=admin-artist.php");
}
if (isset($_GET['unblock'])) {
	# code...
	$block = intval($_GET['unblock']);
 	$del_query = $pdo->prepare("UPDATE artisttbl SET `featured`=:featured WHERE account_id = :block_id");
	// $del_query->execute([':featured' => 1, ':block_id' =>$block]); 
	$success = "Unblocked Successfully! Refreshing in 2 secs.";
	header("refresh:2;url=admin-artist.php");
}
if (isset($_GET['delete'])) {
	# code...
	$del = intval($_GET['delete']);
 	$del_query = $pdo->prepare(" DELETE FROM accounttbl WHERE id = :delete_id");
	$del_query->execute([':delete_id' =>$del]); 
	$success = "Album Deleted Successfully!  Refreshing in 2 secs.";
	header("refresh:2;url=admin-artist.php");
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
</style>
			<div class="u-content">
				<div class="u-body">
					<h1 class="h2 font-weight-semibold mb-4">Affiliate</h1>
					<div class="card">
						<header class="card-header">							
							<div class="float-right">
<!-- 								<a class="btn custom-btn" href="manage-admins.php">
									<i class="fas fa-plus-square"></i> Add Admin
								</a> -->
								&nbsp;&nbsp;&nbsp;&nbsp;
							</div>
	                        <?php if(isset($success)){ ?>
	                          <div class="form-control alert alert-success fade show" role="alert">
	                            <i class="fa fa-check-circle alert-icon mr-3"></i>
	                            <span> <?php echo $success; ?></span>
	                            <button type="button" class="close" aria-label="Close" data-dismiss="alert">
	                              <span aria-hidden="true">&times;</span>
	                            </button>
	                          </div>
	                        <?php }?>							
							<h2 class="h3 card-header-title pusher">All Affiliate</h2>
						</header>						
						<div class="card-body">
							<?php if(empty($row)){?>
							<h2>No Affiliate yet.</h2>
							<?php } else{ ?>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col">First name</th>
											<th scope="col">Last name</th>
											<th scope="col">Bank name</th>
											<th scope="col">Bank Account</th>
											<th scope="col">Created at</th>
										</tr>
									</thead>

									<tbody>
										<?php while($user = $stmt->fetch(PDO::FETCH_ASSOC)) : 
										$created_date = strtotime($user['created_at'] );
										$created_date = date('l jS F Y', $created_date );
										?>
										<tr>																					
											<td><?=$user['fname']?></td>
											<td><?=$user['lname']?></td>
											<td><?=$user['bank_name']?></td>
											<td><?=$user['bank_account']?></td>
											<td><?=$created_date?></td>
										</tr>
										<?php endwhile ?>										
									</tbody>
								</table>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>