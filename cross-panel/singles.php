<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ARTIST_ID'])) {
  permission_error('login.php');
}else{
	$artist_id = $_SESSION['ARTIST_ID'];
	$stmt = $pdo->query("SELECT * FROM accounttbl WHERE id = $artist_id ");
	$acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$acct_type = $acc_result['acct_type'];		
}
if ($acct_type == 'Free Account') {
	# code...
	$singles_query = $pdo->query("SELECT * FROM singlestbl WHERE price = 0 AND acount_id = $artist_id ORDER BY id DESC");
}else{
	$singles_query = $pdo->query("SELECT * FROM singlestbl WHERE price > 0 AND acount_id = $artist_id ORDER BY id DESC");
}


if (isset($_GET['delete'])) {
	# code...
	$del = intval($_GET['delete']);
	$get_query = $pdo->query("SELECT * FROM singlestbl WHERE id = $del");
	$track_details = $get_query->fetch(PDO::FETCH_ASSOC);
	$path ='../';
	unlink($path.$track_details['short_url']);
	unlink($path.$track_details['long_url']);
	unlink($path.$track_details['image']);		
 	$insert_query = $pdo->prepare(" DELETE FROM singlestbl WHERE id = :delete_id");
	$insert_query->execute([':delete_id' =>$del]); 
	$success = "Single Deleted Successfully! Refreshing in 2 secs.";
	header("refresh:2;url=singles.php");
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
								<a class="btn custom-btn " href="manage_singles.php">
									<i class="fas fa-plus-square"></i> Add Singles
								</a>
								&nbsp;&nbsp;&nbsp;&nbsp;
							</div>
	                        <?php if(isset($success)){ ?>
	                          <div class="form-control alert alert-success fade show push" role="alert">
	                            <i class="fa fa-check-circle alert-icon mr-3"></i>
	                            <span> <?php echo $success; ?></span>
	                            <button type="button" class="close" aria-label="Close" data-dismiss="alert">
	                              <span aria-hidden="true">&times;</span>
	                            </button>
	                          </div>
	                        <?php }?>							
							<h2 class="h3 card-header-title pusher">All Singles</h2>
						</header>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col"></th>
											<th scope="col">Title</th>
											<th scope="col">Price</th>
											<th scope="col">Duration</th>
											<th scope="col">Date</th>
											<th class="text-center" scope="col"></th>
											<th class="text-center" scope="col"></th>
										</tr>
									</thead>

									<tbody>
										<?php while($singles = $singles_query->fetch(PDO::FETCH_ASSOC)) : 
										$post_date = strtotime($singles['created_at'] );
										$mydate = date('l jS F Y', $post_date );

										?>
										<tr>																					
											<td><img src="../<?=$singles['image']?>"></td>
											<td><?=$singles['title']?></td>
											<td><?=($singles['price'] == 0 )?'Free':$singles['price']?></td>
											<td><?=$singles['duration']?></td>
											<td><?=$mydate;?></td>
											<td>
												<a class="badge badge-soft-danger" href="manage_singles.php?edit=<?=$singles['id']?>">Edit single</a>							
											</td>
											<td class="text-center">
												<a class="link-muted" href="singles.php?delete=<?=$singles['id']?>">
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