<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ADMIN_ID'])) {
  permission_error('admin-login.php');
}

if (isset($_GET['free'])) {
	# code...
	$album_query = $pdo->query("SELECT * FROM singlestbl WHERE price = 0 ORDER BY id DESC");
}elseif (isset($_GET['paid'])) {
	# code...
	$album_query = $pdo->query("SELECT * FROM singlestbl WHERE price > 0 ORDER BY id DESC");
}else{
	$album_query = $pdo->query("SELECT * FROM singlestbl ORDER BY id DESC");
}

if (isset($_GET['block'])) {
	# code...
	$block = intval($_GET['block']);
 	$del_query = $pdo->prepare("UPDATE singlestbl SET `featured`=:featured WHERE id = :block_id");
	$del_query->execute([':featured' => 0, ':block_id' =>$block ]); 
	$success = "Blocked Successfully! Refreshing in 2 secs.";
	header("refresh:2;url=admin-singles.php");
}
if (isset($_GET['unblock'])) {
	# code...
	$block = intval($_GET['unblock']);
 	$del_query = $pdo->prepare("UPDATE singlestbl SET `featured`=:featured WHERE id = :block_id");
	$del_query->execute([':featured' => 1, ':block_id' =>$block ]); 
	$success = "Unblocked Successfully! Refreshing in 2 secs.";
	header("refresh:2;url=admin-singles.php");
}
if (isset($_GET['delete'])) {
	# code...
	$del = intval($_GET['delete']);
 	$del_query = $pdo->prepare(" DELETE FROM singlestbl WHERE acount_id = :delete_id");
	$del_query->execute([':delete_id' =>$del]); 
	$success = "Album Deleted Successfully! Refreshing in 2 secs.";
	header("refresh:2;url=admin-singles.php");
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
					<h1 class="h2 font-weight-semibold mb-4">Singles</h1>
					<div class="card">
						<header class="card-header">							
							<div class="float-right">
<!-- 								<a class="btn custom-btn" href="manage_albums.php">
									<i class="fas fa-plus-square"></i> Add Album
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
							<h2 class="h3 card-header-title pusher">All Singles</h2>
							<br>
								<a class="badge badge-soft-info" href="admin-singles.php?free">Free Account</a>
								<a class="badge badge-soft-info" href="admin-singles.php?paid">Paid Account</a>							
						</header>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col"></th>
											<th scope="col">Title</th>
											<th scope="col">Price</th>
											<th scope="col">Featured</th>
											<th scope="col">Date</th>
											<th class="text-center" scope="col"></th>
											<th class="text-center" scope="col"></th>
										</tr>
									</thead>

									<tbody>
										<?php while($album = $album_query->fetch(PDO::FETCH_ASSOC)) : 
										$post_date = strtotime($album['created_at'] );
										$mydate = date('l jS F Y', $post_date );
										?>
										<tr>																					
											<td><img src="../<?=$album['image']?>"></td>
											<td><?=$album['title']?></td>
											<td><?=($album['price'] == 0 )?'Free':$album['price']?></td>
											<td><?=$album['featured']?></td>
											<td><?=$mydate;?></td>
											<td>
												<a class="badge badge-soft-danger" href="admin-singles.php?block=<?=$album['id']?>">Block</a>
												<a class="badge badge-soft-danger" href="admin-singles.php?unblock=<?=$album['id']?>">Unblock</a>							
											</td>
											<td class="text-center">
												<a class="link-muted" href="admin-singles.php?delete=<?=$album['acount_id']?>">
													<i class="fa fa-trash"></i>
												</a>											
											</td>
										</tr>
										<?php endwhile ?>										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>