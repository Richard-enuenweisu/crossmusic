<?php
if (isset($_SESSION['ARTIST_ID'])) {
	$artist_id = $_SESSION['ARTIST_ID'];
	// var_dump($artist_id);
	$stmt8 = $pdo->query("SELECT * FROM accounttbl INNER JOIN artisttbl ON accounttbl.id = artisttbl.account_id 
		WHERE accounttbl.id =$artist_id");
	$acc_result = $stmt8->fetch(PDO::FETCH_ASSOC);
	$acct_type = $acc_result['acct_type'];		
}
if (isset($_SESSION['ADMIN_ID'])) {
	$admin_id = $_SESSION['ADMIN_ID'];
	// var_dump($artist_id);
	$admin_query = $pdo->query("SELECT * FROM admintbl WHERE id =$admin_id");
	$admin = $admin_query->fetch(PDO::FETCH_ASSOC);
	$privilege = $admin['privilege'];	
}
?>			
			<aside id="sidebar" class="u-sidebar">
				<div class="u-sidebar-inner">
					<header class="u-sidebar-header">
						<a class="u-sidebar-logo" href="index.html">
							<i class="fab fa-cpanel fa-3x"></i>
							<!-- <img class="img-fluid" src="./assets/img/salt-logo.png" width="124" alt="Stream Dashboard"> -->
						</a>
					</header>
					<?php if(isset($_SESSION['ADMIN_ID'])) {?>
					<nav class="u-sidebar-nav">										
						<ul class="u-sidebar-nav-menu u-sidebar-nav-menu--top-level">
							<!-- Dashboard -->
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link active" href="./admin-index.php">
									<i class="fa fa-cubes u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Dashboard</span>
								</a>
							</li>
							<?php if($privilege =='Super Admin'){?>
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="admins.php">
									<i class="far fa-user u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Administrator</span>
								</a>
							</li>
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="admin-pricing.php">
									<i class="fas fa-hand-holding-usd u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Account Pricing</span>
								</a>
							</li>							
							<?php } ?>							
							<!-- End Dashboard -->
							<!-- My Profile -->
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="#!"
								   data-target="#subMenu1">
									<i class="fas fa-users u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Customers</span>
									<i class="fa fa-angle-right u-sidebar-nav-menu__item-arrow"></i>
									<span class="u-sidebar-nav-menu__indicator"></span>
								</a>

								<ul id="subMenu1" class="u-sidebar-nav-menu u-sidebar-nav-menu--second-level" style="display: none;">
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="admin-artist.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">B</span> -->
											<span class="u-sidebar-nav-menu__item-title">Artists</span>
										</a>
									</li>
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="admin-affiliate.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">E</span> -->
											<span class="u-sidebar-nav-menu__item-title">Affiliates</span>
										</a>
									</li>
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="admin-users.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">E</span> -->
											<span class="u-sidebar-nav-menu__item-title">Users</span>
										</a>
									</li>									
								</ul>
							</li>							
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="#!"
								   data-target="#subMenu2">
									<i class="fas fa-drum u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Music Manager</span>
									<i class="fa fa-angle-right u-sidebar-nav-menu__item-arrow"></i>
									<span class="u-sidebar-nav-menu__indicator"></span>
								</a>

								<ul id="subMenu2" class="u-sidebar-nav-menu u-sidebar-nav-menu--second-level" style="display: none;">
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="admin-singles.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">B</span> -->
											<span class="u-sidebar-nav-menu__item-title">Singles</span>
										</a>
									</li>
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="admin-albums.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">E</span> -->
											<span class="u-sidebar-nav-menu__item-title">Albums</span>
										</a>
									</li>
								</ul>
							</li>							
<!-- 							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="aff-profile.php">
									<i class="far fa-user-circle u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Artist Login</span>
								</a>
							</li> -->
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="#!"
								   data-target="#subMenu4">
									<i class="fas fa-user-tie u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Account Information</span>
									<i class="fa fa-angle-right u-sidebar-nav-menu__item-arrow"></i>
									<span class="u-sidebar-nav-menu__indicator"></span>
								</a>
								<ul id="subMenu4" class="u-sidebar-nav-menu u-sidebar-nav-menu--second-level" style="display: none;">
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="admin-artist-acc.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">B</span> -->
											<span class="u-sidebar-nav-menu__item-title">Artist</span>
										</a>
									</li>
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="admin-affiliate-acc.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">E</span> -->
											<span class="u-sidebar-nav-menu__item-title">Affiliates</span>
										</a>
									</li>
								</ul>
							</li>	
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="#!"
								   data-target="#subMenu5">
									<i class="fas fa-file-invoice-dollar u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Cashout Request</span>
									<i class="fa fa-angle-right u-sidebar-nav-menu__item-arrow"></i>
									<span class="u-sidebar-nav-menu__indicator"></span>
								</a>
								<ul id="subMenu5" class="u-sidebar-nav-menu u-sidebar-nav-menu--second-level" style="display: none;">
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="admin-artist-trans.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">B</span> -->
											<span class="u-sidebar-nav-menu__item-title">Artist</span>
										</a>
									</li>
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="admin-affiliate-trans.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">E</span> -->
											<span class="u-sidebar-nav-menu__item-title">Affiliates</span>
										</a>
									</li>
								</ul>
							</li>																											
						</ul>
					</nav>
					<?php } else{ ?>
					<nav class="u-sidebar-nav">				
						<?php if(isset($_SESSION['AFFILIATE_ID'])) {?>
						<ul class="u-sidebar-nav-menu u-sidebar-nav-menu--top-level">
							<!-- Dashboard -->
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link active" href="./index2.php">
									<i class="fa fa-cubes u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Affiliate</span>
								</a>
							</li>
							<!-- End Dashboard -->
							<!-- My Profile -->
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="aff-profile.php">
									<i class="far fa-user-circle u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">My Profile</span>
								</a>
							</li>
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="aff-link.php">
									<i class="fas fa-link u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Create Link</span>
								</a>
							</li>							
							<!-- Unit Contribution -->
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="aff-account-info.php">
									<i class="fa fa-coins u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Account Information</span>
								</a>
							</li>
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="aff-transactions.php">
									<i class="fas fa-credit-card u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Online Transaction</span>
								</a>
							</li>
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="aff-cashout.php">
									<i class="fas fa-hand-holding-usd u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Cashout Request</span>
								</a>
							</li>								
						</ul>	
						<?php }else{?>
						<ul class="u-sidebar-nav-menu u-sidebar-nav-menu--top-level">
							<!-- Dashboard -->
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link active" href="./index.php">
									<i class="fa fa-cubes u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Dashboard</span>
								</a>
							</li>
							<!-- End Dashboard -->
							<!-- My Profile -->
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="profile.php">
									<i class="far fa-user-circle u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">My Profile</span>
								</a>
							</li>
							<!-- Other Pages -->
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="#!"
								   data-target="#subMenu3">
									<i class="fas fa-drum u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Music Manager</span>
									<i class="fa fa-angle-right u-sidebar-nav-menu__item-arrow"></i>
									<span class="u-sidebar-nav-menu__indicator"></span>
								</a>

								<ul id="subMenu3" class="u-sidebar-nav-menu u-sidebar-nav-menu--second-level" style="display: none;">
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="singles.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">B</span> -->
											<span class="u-sidebar-nav-menu__item-title">Singles</span>
										</a>
									</li>
									<li class="u-sidebar-nav-menu__item">
										<a class="u-sidebar-nav-menu__link" href="albums.php">
											<!-- <span class="u-sidebar-nav-menu__item-icon">E</span> -->
											<span class="u-sidebar-nav-menu__item-title">Albums</span>
										</a>
									</li>
								</ul>
							</li>
							<!-- End Other Pages -->
					

							<hr>

							<!-- Documentation -->
<!-- 							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="give.php">
									<i class="fas fa-link u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Short Link</span>
								</a>
							</li> -->
							<?php if(isset($_SESSION['ARTIST_ID']) && $acct_type == 'Paid Account'){ ?>	
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="account-info.php">
									<i class="fa fa-coins u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Account Information</span>
								</a>
							</li>														
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="transactions.php">
									<i class="fas fa-credit-card u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Online Transaction</span>
								</a>
							</li>
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="cashout.php">
									<i class="fas fa-hand-holding-usd u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Cashout Request</span>
								</a>
							</li>
							<?php }else{ ?>
							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="migrate.php">
									<i class="fas fa-shekel-sign u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">Account Migration</span>
								</a>
							</li>
							<?php } ?>
							<!-- Free Download -->
<!-- 							<li class="u-sidebar-nav-menu__item">
								<a class="u-sidebar-nav-menu__link" href="#">
									<i class="fab fa-buysellads u-sidebar-nav-menu__item-icon"></i>
									<span class="u-sidebar-nav-menu__item-title">In-Ads Manager</span>
								</a>
							</li> -->
							<!-- End Free Download -->
						</ul>							
						<?php } ?>							
					</nav>
					<?php } ?>
				</div>
			</aside>