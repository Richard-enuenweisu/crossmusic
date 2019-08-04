<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['USER_ID'])) {
  permission_error('login.php');
}

$sermon_query = $pdo->query("SELECT * FROM sermontbl ORDER BY id DESC");

if (isset($_GET['delete'])) {
	# code...
	$del = intval($_GET['delete']);
 	$insert_query = $pdo->prepare(" DELETE FROM sermontbl WHERE id = :delete_id");
	$insert_query->execute([':delete_id' =>$del]); 
	$success = "Sermon Deleted Successfully!  Refreshing in 2 secs.";
	header("refresh:2;url=confessions.php");
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
					<h1 class="h2 font-weight-semibold mb-4">Sermons</h1>
					<div class="card">
						<header class="card-header">							
							<div class="float-right">
								<a class="link-muted" href="manage_sermon.php">
									<i class="fas fa-plus-square"></i> Add Sermon
								</a>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a class="link-muted" href="sermon_resources.php">
									<i class="fas fa-plus-square"></i> Add Resources
								</a>
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
							<h2 class="h3 card-header-title pusher">All Sermons</h2>
						</header>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col"></th>
											<th scope="col">Title</th>
											<th scope="col">Source</th>
											<th scope="col">Created at</th>
											<th class="text-center" scope="col"></th>
											<th class="text-center" scope="col"></th>
										</tr>
									</thead>

									<tbody>
										<?php while($sermon = $sermon_query->fetch(PDO::FETCH_ASSOC)) : 

										$post_date = strtotime($sermon['created_at'] );
										$mydate = date('l jS F Y', $post_date );
										?>
										<tr>
											<td><img src="../<?=$sermon['image']?>"></td>
											<td><?=$sermon['title']?></td>
											<td><?=$sermon['source']?></td>
											<td><?=$mydate?></td>
											<td>
												<a class="badge badge-soft-primary" href="manage_sermon.php?edit=<?=$sermon['id']?>">Edit Sermon</a>
												<a class="badge badge-soft-primary" href="sermon_resources.php?edit=<?=$sermon['id']?>">Edit Resources</a>							
											</td>
											<td class="text-center">
												<a class="link-muted" href="sermons.php?delete=<?=$sermon['id']?>">
													<i class="fa fa-trash"></i>
												</a>											
											</td>
										</tr>										
										<?php endwhile;?>
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