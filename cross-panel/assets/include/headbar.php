<?php
if (isset($_SESSION['ARTIST_ID'])) {
	$artist_id = $_SESSION['ARTIST_ID'];
	// var_dump($affiliate_id);
	$stmt = $pdo->query("SELECT * FROM accounttbl WHERE accounttbl.id = $artist_id");
	$acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$name = $acc_result['lname'];
}elseif (isset($_SESSION['AFFILIATE_ID'])) {
	# code...
	$affiliate_id = $_SESSION['AFFILIATE_ID'];
	// var_dump($affiliate_id);
	$stmt = $pdo->query("SELECT * FROM aff_accounttbl INNER JOIN aff_userstbl ON aff_accounttbl.id = aff_userstbl.account_id 
		WHERE aff_accounttbl.id =$affiliate_id");
	$acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$name = $acc_result['lname'];	
}elseif (isset($_SESSION['ADMIN_ID'])) {
	$admin_id = $_SESSION['ADMIN_ID'];
	// var_dump($artist_id);
	$admin_query = $pdo->query("SELECT * FROM admintbl WHERE id =$admin_id");
	$admin = $admin_query->fetch(PDO::FETCH_ASSOC);
	$name = $admin['uname'];	
}else{
	$name = 'Crossmusic';
}
?>			<!-- Header (Topbar) -->
		<header class="u-header">
			<div class="u-header-left">
				<?php if(isset($affiliate_id)){ ?>
				<a class="u-header-logo" href="index2.php">
				<?php }else{ ?>
				<a class="u-header-logo" href="index.php">
				<?php }?>
					<img class="u-logo-desktop" src="./assets/img/logo.png" width="50" alt="Crossmusic CMS">
					<img class="img-fluid u-logo-mobile" src="./assets/img/logo.png" width="50" alt="Crossmusic CMS">
				</a>
			</div>

			<div class="u-header-middle">
				<a class="js-sidebar-invoker u-sidebar-invoker" href="#!"
				   data-is-close-all-except-this="true"
				   data-target="#sidebar">
					<i class="fa fa-bars u-sidebar-invoker__icon--open"></i>
					<i class="fa fa-times u-sidebar-invoker__icon--close"></i>
				</a>
				<!-- search input field -->
<!-- 				<div class="u-header-search"
				     data-search-mobile-invoker="#headerSearchMobileInvoker"
				     data-search-target="#headerSearch">
					<a id="headerSearchMobileInvoker" class="btn btn-link input-group-prepend u-header-search__mobile-invoker" href="#!">
						<i class="fa fa-search"></i>
					</a>

					<div id="headerSearch" class="u-header-search-form">
						<form>
							<div class="input-group">
								<button class="btn-link input-group-prepend u-header-search__btn" type="submit">
									<i class="fa fa-search"></i>
								</button>
								<input class="form-control u-header-search__field" type="search" placeholder="Type to search…">
							</div>
						</form>
					</div>
				</div> -->
			</div>

			<div class="u-header-right">
		  	<!-- Activities -->
				<!-- <div class="dropdown mr-4">
				  <a class="link-muted" href="#!" role="button" id="dropdownMenuLink" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">
				    <span class="h3">
			    		<i class="far fa-envelope"></i>
				    </span>
				    <span class="u-indicator u-indicator-top-right u-indicator--xxs bg-secondary"></span>
				  </a>
				</div> -->
		  	<!-- End Activities -->

		  	<!-- User Profile -->
				<div class="dropdown ml-2">
				  <a class="link-muted d-flex align-items-center" href="#!" role="button" id="dropdownMenuLink" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">
				    <img class="u-avatar--xs img-fluid rounded-circle mr-2" src="./assets/img/avatars/img1.jpg" alt="User Profile">
						<span class="text-dark d-none d-sm-inline-block">
							<?=$name?> <small class="fa fa-angle-down text-muted ml-1"></small>
						</span>
				  </a>

				  <div class="dropdown-menu dropdown-menu-right border-0 py-0 mt-3" aria-labelledby="dropdownMenuLink" style="width: 260px;">
				  	<div class="card">
							<div class="card-body">
								<ul class="list-unstyled mb-0">
									<!-- <li class="mb-4">
										<a class="d-flex align-items-center link-dark" href="#!">
											<span class="h3 mb-0"><i class="far fa-user-circle text-muted mr-3"></i></span> View Profile
										</a>
									</li> -->
<!-- 									<li class="mb-4">
										<a class="d-flex align-items-center link-dark" href="#!">
											<span class="h3 mb-0"><i class="far fa-list-alt text-muted mr-3"></i></span> Settings
										</a>
									</li>
									<li class="mb-4">
										<a class="d-flex align-items-center link-dark" href="#!">
											<span class="h3 mb-0"><i class="far fa-laugh-wink text-muted mr-3"></i></span> Invite your friends
										</a>
									</li> -->
									<li>
										<a class="d-flex align-items-center link-dark" href="logout.php">
											<span class="h3 mb-0"><i class="far fa-share-square text-muted mr-3"></i></span> Sign Out
										</a>
									</li>
								</ul>
							</div>
				  	</div>
				  </div>
				</div>
		  	<!-- End User Profile -->
			</div>
		</header>
		<!-- End Header (Topbar) -->