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
	$acc_name =  $acc_result['company_name'];
}

$trans_query = $pdo->query("SELECT * FROM artist_trasanctionstbl WHERE account_id = $artist_id ORDER BY id DESC");
$row = $trans_query->rowcount();

if (isset($_GET['delete'])) {
	# code...
	$del = intval($_GET['delete']);
 	$insert_query = $pdo->prepare(" DELETE FROM artist_trasanctionstbl WHERE id = :delete_id");
	$insert_query->execute([':delete_id' =>$del]); 
	$success = "transaction Deleted Successfully! Refreshing in 2 secs.";
	header("refresh:2;url=transactions.php");
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
					<h1 class="h2 font-weight-semibold mb-4">Transactions</h1>
					<div class="card">
<!-- 						<header class="card-header">														
							<h2 class="h3 card-header-title pusher">All Transactions</h2>
						</header>
 -->
						<div class="card-body">
							<center><img src="assets/img/trans-img.png" style="width: 40%;"></center>
								<p style="width: 80%; margin:0px auto;text-align: center;margin-top: 20px;">
								All your transactions are dynamically arrayed here.
								</p>
							<?php if($row < 1 ){?>
							<div class="text-center pusher" style="font-weight: bold;">
								<h2>No Transactions yet.</h2>
							</div>
							<?php }else{?>						
							<div class="table-responsive pusher">
								<table id="empTable" class="table table-hover display dataTable">
									<thead>
										<tr>
											<th scope="col">Purpose</th>
											<th scope="col">Amount</th>
											<th scope="col">Current Balance</th>
											<th scope="col">Status</th>
											<th scope="col">Reference</th>
											<th scope="col">Date</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									<?php while($transacions = $trans_query->fetch(PDO::FETCH_ASSOC)): 
										$post_date = strtotime($transacions['created_at'] );
										$mydate = date('l jS F Y', $post_date );
									?>
										<tr>
											<td><?=$transacions['description'];?></td>
											<td><?=$transacions['amount'];?></td>
											<td><?=$transacions['curr_bal'];?></td>
											<td><?=$transacions['status'];?></td>
											<td><?=$transacions['reference'];?></td>
											<td><?=$mydate?></td>
											<td class="text-center">
												<a class="link-muted" href="transactions.php?delete=<?=$transacions['id']?>">
													<i class="fa fa-trash"></i>
												</a>											
											</td>											
										</tr>
									<?php endwhile; ?>
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