<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');


  $price = 0;
  $stmt = $pdo->prepare("SELECT * FROM trackstbl WHERE price >:price AND featured = 1 ORDER BY id DESC");
  $stmt->execute([':price' => $price]);

 if (isset($_GET['albums'])) {
	# code...
  $stmt = $pdo->prepare("SELECT accounttbl.company_name, albumstbl.id, albumstbl.title, albumstbl.price, albumstbl.featured, albumstbl.image, albumstbl.account_id FROM albumstbl INNER JOIN accounttbl ON accounttbl.id = albumstbl.account_id WHERE albumstbl.price >:price ORDER BY id DESC");  
  $stmt->execute([':price' => $price]);	
  
}elseif (isset($_GET['singles'])) {
	# code...
  $stmt = $pdo->prepare("SELECT * FROM singlestbl WHERE price >:price AND featured = 1 ORDER BY id DESC"); 
  $stmt->execute([':price' => $price]);	
}
else{
  $stmt = $pdo->prepare("SELECT * FROM trackstbl WHERE price >:price ORDER BY id DESC"); 
  $stmt->execute([':price' => $price]); 
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
					<h1 class="mb-2">Welcome to <br>Crossmusic Blog</h1>
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
      <span class="pl-3"><a href="?tracks">All Tracks</a></span>
      <span class="pl-3"><a href="?singles">All Singles</a></span>
      <span class="pl-3"><a href="?albums">All Albums</a></span>
    </div>			
		<div class="col-md-12 px-0 push" style="">
			<div class="blog-search-holder">				
				<form method="post" action="blog-search">					
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
	<div class="row push" style="background-color: #fff;">
		<div class="col-md-8">
			<div class="blog-ban-holder cust-pad">
				<span>1st Sept. 2019</span>
				<h1>Why your customer are your biggest assets, why do gospel artist need more customer than fans </h1>
				<p>
					Lorem ipsum dolor sit amet, consectetuer adipiscing diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. 
				</p>
				<img src="images/logo.png" style="width: 70px; border-radius: 50%;float: left;">
				<p class="mb-0 mt-4">Richard Enuenweisu</p>
				<p class="small">C.E.O Mycrossmusic</p>
			</div>
		</div>
		<div class="col-md-4 px-0">
			<a href="#">
				<div class="ad-head-img" style="background-image: url(images/ad-head-img.png);"></div>
			</a>
		</div>
	</div>
</div>

<div class="container">
	<?php if(isset($_GET['tracks'])){ ?>
	<div class="row push">
		<?php while($result = $stmt->fetch(PDO::FETCH_ASSOC)) :
			$post_date = strtotime($result['created_at'] );
			$mydate = date('l jS F Y', $post_date );
		 ?>
		<div class="col-md-4">
			<a href="blog-view?track=<?=$result['id']?>">
				<div class="item-image-bg">
				</div>
				<div class="item-image cust-shadow" style="background-image: url('<?=$result['image']?>');">
				</div>
				<div class="blog-item-holder cust-pad">				
					<p class="small pt-3"><?=$mydate?></p>										
					<h3 class="my-0"><?=$result['title']?></h3>
					<span class="small my-0"><?=$result['song_by']?></span>
				</div>
			</a>
		</div>
		<?php endwhile; ?>								
	</div>
	<?php }elseif (isset($_GET['singles'])){ ?>	
	<div class="row push">
		<?php while($result = $stmt->fetch(PDO::FETCH_ASSOC)) :
			$post_date = strtotime($result['created_at'] );
			$mydate = date('l jS F Y', $post_date );
		 ?>
		<div class="col-md-4">
			<a href="blog-view?singles=<?=$result['id']?>">
				<div class="item-image-bg">
				</div>
				<div class="item-image cust-shadow" style="background-image: url('<?=$result['image']?>');">
				</div>
				<div class="blog-item-holder cust-pad">				
					<p class="small pt-3"><?=$mydate?></p>										
					<h3 class="my-0"><?=$result['title']?></h3>
					<span class="small my-0"><?=$result['song_by']?></span>
				</div>
			</a>
		</div>
		<?php endwhile; ?>								
	</div>
	<?php }elseif (isset($_GET['albums'])){ ?>
	<div class="row push">
		<?php while($result = $stmt->fetch(PDO::FETCH_ASSOC)) :
			$post_date = strtotime($result['created_at'] );
			$mydate = date('l jS F Y', $post_date );
		 ?>
		<div class="col-md-4">
			<a href="blog-view?albums=<?=$result['id']?>">
				<div class="item-image-bg">
				</div>
				<div class="item-image cust-shadow" style="background-image: url('<?=$result['image']?>');">
				</div>
				<div class="blog-item-holder cust-pad">				
					<p class="small pt-3"><?=$mydate?></p>										
					<h3 class="my-0"><?=$result['title']?></h3>
					<span class="small my-0"><?=$result['song_by']?></span>
				</div>
			</a>
		</div>
		<?php endwhile; ?>								
	</div>
	<?php }else{ ?>
	<div class="row push">
		<?php while($result = $stmt->fetch(PDO::FETCH_ASSOC)) :
			$post_date = strtotime($result['created_at'] );
			$mydate = date('l jS F Y', $post_date );
		 ?>
		<div class="col-md-4">
			<a href="blog-view?track=<?=$result['id']?>">
				<div class="item-image-bg">
				</div>
				<div class="item-image cust-shadow" style="background-image: url('<?=$result['image']?>');">
				</div>
				<div class="blog-item-holder cust-pad">				
					<p class="small pt-3"><?=$mydate?></p>										
					<h3 class="my-0"><?=$result['title']?></h3>
					<span class="small my-0"><?=$result['song_by']?></span>
				</div>
			</a>
		</div>
		<?php endwhile; ?>								
	</div>		
	<?php } ?>
	<div class="row pusher-3"></div>	
</div> 
<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>