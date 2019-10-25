<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ADMIN_ID'])) {
  permission_error('admin-login.php');
}
$stmt = $pdo->query("SELECT * FROM admintbl WHERE privilege = 'Admin' ORDER BY id DESC");
$row = $stmt->rowcount();
if (isset($_GET['delete'])) {
	# code...
	$del = intval($_GET['delete']);
 	$del_query = $pdo->prepare(" DELETE FROM admintbl WHERE id = :delete_id");
	$del_query->execute([':delete_id' =>$del]); 
	$success = "Album Deleted Successfully!  Refreshing in 2 secs.";
	header("refresh:2;url=admins.php");
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
					<h1 class="h2 font-weight-semibold mb-4">Administrators</h1>
					<div class="card">
						<header class="card-header">							
							<div class="float-right">
								<a class="btn custom-btn" href="manage-admins.php">
									<i class="fas fa-plus-square"></i> Add Admin
								</a>
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
							<h2 class="h3 card-header-title pusher">All Administrator</h2>
						</header>						
						<div class="card-body">
							<?php if(empty($row)){?>
							<h2>No Administrator yet.</h2>
							<?php } else{ ?>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col">Username</th>
											<th scope="col">Email</th>
											<th scope="col">Privilege</th>
											<th scope="col">Last Login</th>
											<th scope="col">Created at</th>
											<th class="text-center" scope="col"></th>
											<th class="text-center" scope="col"></th>
										</tr>
									</thead>

									<tbody>
										<?php while($admin = $stmt->fetch(PDO::FETCH_ASSOC)) : 
										$created_date = strtotime($admin['created_at'] );
										$login_date = strtotime($admin['last_login'] );

										$created_date = date('l jS F Y', $created_date );
										$login_date = date('l jS F Y', $login_date );

										?>
										<tr>																					
											<td><?=$admin['uname']?></td>
											<td><?=$admin['email']?></td>
											<td><?=$admin['privilege']?></td>
											<td><?=$login_date;?></td>
											<td><?=$created_date;?></td>
											<td>
												<a class="badge badge-soft-danger" href="manage-admins.php?edit=<?=$admin['id']?>">
													Edit Admin
												</a>																			
											</td>
											<td class="text-center">
												<a class="link-muted" href="admins.php?delete=<?=$admin['id']?>">
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