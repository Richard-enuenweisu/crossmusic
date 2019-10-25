<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (!isset($_SESSION['ADMIN_ID'])) {
  permission_error('admin-login.php');
}
if (isset($_GET['pending'])) {
	# code...
	$trans_query = $pdo->query("SELECT * FROM aff_transtbl WHERE `reference` = 'Pending' ORDER BY id DESC");
	$row = $trans_query->rowcount();	
}else{
	$trans_query = $pdo->query("SELECT * FROM aff_transtbl ORDER BY id DESC");
	$row = $trans_query->rowcount();	
}

if (isset($_GET['delete'])) {
	# code...
	$del = intval($_GET['delete']);
 	$insert_query = $pdo->prepare(" DELETE FROM aff_transtbl WHERE id = :delete_id");
	$insert_query->execute([':delete_id' =>$del]); 
	$success = "transaction Deleted Successfully! Refreshing in 2 secs.";
	header("refresh:2;url= aff-transactions.php");
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
					<h1 class="h2 font-weight-semibold mb-4">Affiliate Transactions</h1>
					<div class="card">
<!-- 						<header class="card-header">														
							<h2 class="h3 card-header-title pusher">All Transactions</h2>
						</header>
 -->
						<div class="card-body">
							<h2 class="h3 card-header-title push">All Affiliate Transactions</h2>
								<a class="badge badge-soft-info push" href="admin-affiliate-trans.php?pending">
									Pending transactions
								</a>																							
							<?php if($row < 1 ){?>
							<div class="text-center pusher" style="font-weight: bold;">
								<h2>No Transactions yet.</h2>
							</div>
							<?php }else{?>						
							<div class="table-responsive push">
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
											<td><?=$mydate?>												
											</td>
											<td class="text-center">
												<?php if($transacions['reference'] == 'Pending'){ ?>
												<a class="badge badge-soft-info" href="admin-payout.php?affiliate=<?=$transacions['account_id']?>">
													Make Payment
												</a>
												<?php }else{ ?>
												<span class="badge badge-soft-info">
													Paid Affiliate
												</span>												
												<?php } ?>
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