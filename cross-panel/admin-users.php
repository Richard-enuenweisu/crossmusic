<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ADMIN_ID'])) {
  permission_error('admin-login.php');
}
$stmt = $pdo->query("SELECT * FROM usertbl ORDER BY id DESC ");
$row = $stmt->rowcount();
if (isset($_GET['block'])) {
	# code...
	$block = intval($_GET['block']);
 	$del_query = $pdo->prepare("UPDATE usertbl SET `featured`=:featured WHERE id = :block_id");
	$del_query->execute([':featured' => 0, ':block_id' =>$block ]); 
	$success = "Blocked Successfully!  Refreshing in 2 secs.";
	header("refresh:2;url=admin-users.php");
}
if (isset($_GET['unblock'])) {
	# code...
	$block = intval($_GET['unblock']);
 	$del_query = $pdo->prepare("UPDATE usertbl SET `featured`=:featured WHERE id = :block_id");
	$del_query->execute([':featured' => 1, ':block_id' =>$block ]); 
	$success = "Unblocked Successfully! Refreshing in 2 secs.";
	header("refresh:2;url=admin-users.php");
}
if (isset($_GET['delete'])) {
	# code...
	$del = intval($_GET['delete']);
 	$del_query = $pdo->prepare(" DELETE FROM usertbl WHERE id = :delete_id");
	$del_query->execute([':delete_id' =>$del]); 
	$success = "Affiliate Deleted Successfully! Refreshing in 2 secs.";
	header("refresh:2;url=admin-users.php");
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
					<h1 class="h2 font-weight-semibold mb-4">Users</h1>
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
							<h2 class="h3 card-header-title pusher">All Users</h2>
						</header>						
						<div class="card-body">
							<?php if(empty($row)){?>
							<h2>No Users yet.</h2>
							<?php } else{ ?>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col">Full name</th>
											<th scope="col">Email</th>
											<th scope="col">featured</th>
											<th scope="col">Created at</th>
											<th class="text-center" scope="col"></th>
											<th class="text-center" scope="col"></th>
										</tr>
									</thead>

									<tbody>
										<?php while($user = $stmt->fetch(PDO::FETCH_ASSOC)) : 
										$created_date = strtotime($user['created_at'] );
										$created_date = date('l jS F Y', $created_date );
										?>
										<tr>																					
											<td><?=$user['fname']?> <?=$user['lname']?></td>
											<td><?=$user['email']?></td>
											<td><?=$user['featured']?></td>
											<td><?=$created_date?></td>
											<td>
												<a class="badge badge-soft-danger" href="admin-users.php?block=<?=$user['id']?>">
													Block
												</a>
												<a class="badge badge-soft-danger" href="admin-users.php?unblock=<?=$user['id']?>">
													Unblock
												</a>																						
											</td>
											<td class="text-center">
												<a class="link-muted" href="admin-users.php?delete=<?=$user['id']?>">
													<i class="fa fa-trash"></i>
												</a>											
											</td>
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