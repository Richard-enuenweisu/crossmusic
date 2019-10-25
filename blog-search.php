<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
$price = 0;
if (isset($_POST['blog-search'])) {
	# code...
	$category = ((isset($_POST['category']))?sanitize($_POST['category']): '');
	$title = ((isset($_POST['title']))?sanitize($_POST['title']): '');  
	$errors;
	// echo $title.' '.$category; 
	if ($category =='-- Category --' || empty($title)) {
	 	# code...
	 	$errors = 'Please enter the search values';
	 } 
	if ($category == 'Tracks') {
		# code...
		$title = '%'.$title.'%';
		$stmt1 = $pdo->prepare("SELECT * FROM trackstbl WHERE title like :title AND price >:price");
		$stmt1->execute([':title'=>$title, ':price' => $price]);
		$checker = $stmt1->fetch(PDO::FETCH_ASSOC);
		$row = $stmt1->rowcount();
		if ($row < 1) {
	      $errors = 'No matching Record.';
	    }else{
	    	$stmt2 = $pdo->prepare("SELECT * FROM trackstbl WHERE title like :title AND price >:price");
			$stmt2->execute([':title'=>$title, ':price' => $price]);
	    }		
	}
	if ($category == 'Singles') {
		# code...
		$title = '%'.$title.'%';
		$stmt1 = $pdo->prepare("SELECT * FROM singlestbl WHERE title like :title AND price >:price");
		$stmt1->execute([':title'=>$title, ':price' => $price]);
		$checker = $stmt1->fetch(PDO::FETCH_ASSOC);
		$row = $stmt1->rowcount();
		if ($row < 1) {
	      $errors = 'No matching Record.';
	    }else{
	    	$stmt2 = $pdo->prepare("SELECT * FROM singlestbl WHERE title like :title AND price >:price");
			$stmt2->execute([':title'=>$title, ':price' => $price]);
	    }		
	}
	if ($category == 'Albums') {
		# code...
		$title = '%'.$title.'%';
		$stmt1 = $pdo->prepare("SELECT * FROM albumstbl WHERE title like :title AND price >:price");
		$stmt1->execute([':title'=>$title, ':price' => $price]);
		$checker = $stmt1->fetch(PDO::FETCH_ASSOC);
		$row = $stmt1->rowcount();
		if ($row < 1) {
	      $errors = 'No matching Record.';
	    }else{
	    	$stmt2 = $pdo->prepare("SELECT * FROM albumstbl WHERE title like :title AND price >:price");
			$stmt2->execute([':title'=>$title, ':price' => $price]);
	    }		
	}		

}

  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">
body{
	background-color: #f6f6f7;
	color: #8b8b8b;
}
a, a:hover{
	color: #8b8b8b;
}
.search-button{
	color: #fff;background-color: #4C2660;border-color: #4C2660;border-radius:0px;width: 70px;height:63px;padding: 10px 0px 7px 0px;
	z-index:5;position: absolute;right:-1px;
}
</style>

<div class="general">
	<div class="blog-container">
		<div class="container"> 
			<div class="row">
				<div class="col-12 pusher-2">
					<div class="col-lg-8 py-5">
					<h1 class="mb-2">Search for your<br>favourite music</h1>
					<p class="m-0">Here we enage audience with a more updated musical contents of artists on our paid account platform.
					</p><br>
					<a href="pricing.php" class="btn btn-custom">Learn More</a>										
					</div>					
				</div>
			</div>	
			<div class="row pusher"></div>	
		</div>	
	</div>
</div>
<div class="overlay-image"></div>

<div class="container">
	<div class="row">
    <div class="row col-lg-12 header-title">
      
    </div>			
		<div class="col-md-12 px-0 push" style="">
			<h5 class="small">Your serach result will display below</h5>
			<div class="blog-search-holder">				
				<form method="post">					
		          <div class="input-group">
		            <select class="sinput form-control home-search" name="category" style="border-radius:0px;">
		              <option>-- Category --</option>
		              <option>Albums</option>
		              <option>Tracks</option>
		              <option>Singles</option>
		            </select>               
		            <input type="text" class="sinput form-control home-search" name="title" placeholder="Title">
		            <!-- <div class="input-group-append"> -->
					  <div class="input-group-append">
					    <button class="form-control search-button" type="submit" name="blog-search" style="color: #fff;background-color: #007bff;border-color: #007bff;border-radius:0px;width: 10%;padding: 10px 0px 7px 0px;"><i class="fa fa-search"></i></button>
					  </div>		            	
		              <!-- <button type="submit" class="form-control" name="search" ></button> -->
		            <!-- </div>                              -->
		          </div>											
				</form>					
			</div>			
		</div>
	</div>	
</div>
<div class="container">
<?php if(isset($_POST['blog-search']) && !empty($errors)){ ?>
	<div class="row pusher-2">
		<div class="col-12 pusher-2" style="margin-bottom: 170px;">
			<center>
			<i class="fa fa-search fa-2x"></i>
			<h4>No matching record for your search, please try again.</h4>
			</center>
		</div>
	</div>
<?php }else{ ?>
	<div class="row push">
		<!-- track -->
		<?php if (isset($category) && $category =='Tracks'){?>
			<?php while($track = $stmt2->fetch(PDO::FETCH_ASSOC)) :
				$post_date = strtotime($result['created_at'] );
				$mydate = date('l jS F Y', $post_date );
			 ?>
			<div class="col-md-4">
				<a href="blog-view?track=<?=$track['id']?>">
					<div class="item-image-bg"></div>
					<div class="item-image cust-shadow" style="background-image: url('<?=$track['image']?>');">
					</div>
					<div class="blog-item-holder cust-pad">				
						<p class="small pt-3"><?=$mydate?></p>										
						<h3 class="my-0"><?=$track['title']?></h3>
						<span class="small my-0"><?=$track['song_by']?></span>
					</div>
				</a>
			</div>
			<?php endwhile; ?>	
			<!-- Singles -->
		<?php } elseif (isset($category) && $category =='Singles'){?>
			<?php while($track = $stmt2->fetch(PDO::FETCH_ASSOC)) :
				$post_date = strtotime($result['created_at'] );
				$mydate = date('l jS F Y', $post_date );
			 ?>
			<div class="col-md-4">
				<a href="blog-view?singles=<?=$track['id']?>">
					<div class="item-image-bg"></div>
					<div class="item-image cust-shadow" style="background-image: url('<?=$track['image']?>');">
					</div>
					<div class="blog-item-holder cust-pad">				
						<p class="small pt-3"><?=$mydate?></p>										
						<h3 class="my-0"><?=$track['title']?></h3>
						<span class="small my-0"><?=$track['song_by']?></span>
					</div>
				</a>
			</div>
			<?php endwhile; ?>
			<!-- albums -->
		<?php } elseif (isset($category) && $category =='Albums'){?>
			<?php while($track = $stmt2->fetch(PDO::FETCH_ASSOC)) :
				$post_date = strtotime($result['created_at'] );
				$mydate = date('l jS F Y', $post_date );
			 ?>
			<div class="col-md-4">
				<a href="blog-view?albums=<?=$track['id']?>">
					<div class="item-image-bg"></div>
					<div class="item-image cust-shadow" style="background-image: url('<?=$track['image']?>');">
					</div>
					<div class="blog-item-holder cust-pad">				
						<p class="small pt-3"><?=$mydate?></p>										
						<h3 class="my-0"><?=$track['title']?></h3>
						<span class="small my-0"><?=$track['song_by']?></span>
					</div>
				</a>
			</div>
			<?php endwhile; ?>
		<?php } ?>														
	</div>
<?php } ?>
</div>

 
<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>