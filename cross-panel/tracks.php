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
if (isset($_GET['album_id']) && !empty($_GET['album_id'])) {
	# code...
	$album_id = $_GET['album_id'];
}else{
	header('Location: albums.php');
}
if ($acct_type == 'Free Account') {
	# code...
	$track_query = $pdo->query("SELECT * FROM trackstbl WHERE price = 0 AND album_id = $album_id ORDER BY id DESC");
}else{
	$track_query = $pdo->query("SELECT * FROM trackstbl WHERE price > 0 AND album_id = $album_id ORDER BY id DESC");
}
	$album_id = $_GET['album_id'];
if (isset($_GET['delete'])) {
	# code...
	$del = intval($_GET['delete']);
	$get_query = $pdo->query("SELECT * FROM trackstbl WHERE id = $del");
	$track_details = $get_query->fetch(PDO::FETCH_ASSOC);
	$path ='../';
	unlink($path.$track_details['short_url']);
	unlink($path.$track_details['long_url']);
	unlink($path.$track_details['image']);	
 	$del_query = $pdo->prepare(" DELETE FROM trackstbl WHERE id = :delete_id");
	$del_query->execute([':delete_id' =>$del]); 
	$success = "Track Deleted Successfully!  Refreshing in 2 secs.";
	header("refresh:2;url=tracks.php");
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
					<h1 class="h2 font-weight-semibold mb-4">Tracks</h1>
					<div class="card">
						<header class="card-header">							
							<div class="float-right">
								<a class="btn custom-btn" href="manage_tracks.php?album_id=<?=$album_id?>">
									<i class="fas fa-plus-square"></i> Add Tracks
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
							<h2 class="h3 card-header-title pusher">Track List</h2>
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
										<?php while($track_details = $track_query->fetch(PDO::FETCH_ASSOC)) : 
										$post_date = strtotime($track_details['created_at'] );
										$mydate = date('l jS F Y', $post_date );

										?>
										<tr>																					
											<td><img src="../<?=$track_details['image']?>"></td>
											<td><?=$track_details['title']?></td>
											<td><?=($track_details['price'] == 0 )?'Free':$track_details['price']?></td>
											<td><?=$track_details['duration']?></td>
											<td><?=$mydate;?></td>
											<td>
												<a class="badge badge-soft-danger" href="manage_tracks.php?edit=<?=$track_details['id']?>">Edit Track</a>							
											</td>
											<td class="text-center">
												<a class="link-muted" href="tracks.php?delete=<?=$track_details['id']?>">
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