<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

 if (isset($_SESSION['USER_ID'])) {
  	# code...
  	$user_id = $_SESSION['USER_ID'];
	$stmt = $pdo->prepare('SELECT * FROM usertbl WHERE id = ? ');
	$stmt->execute([$user_id]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);  	
  }else{
  	header('Location: index.php');
  }

 if (isset($_GET['albums'])) {
	# code...
  $query = $pdo->query("SELECT 
  	albumstbl.id, albumstbl.title, albumstbl.image, orderstbl.category
		FROM albumstbl	INNER JOIN	orderstbl ON orderstbl.product_id = albumstbl.id 
		WHERE orderstbl.category = 'albums' AND orderstbl.user_id = $user_id ORDER BY orderstbl.id DESC");   
  
}elseif (isset($_GET['singles'])) {
	# code...
  $query = $pdo->query("SELECT 
  	singlestbl.id, singlestbl.title, singlestbl.duration, singlestbl.long_url, singlestbl.image, orderstbl.category
		FROM singlestbl	INNER JOIN	orderstbl ON orderstbl.product_id = singlestbl.id 
		WHERE orderstbl.category = 'singles' AND orderstbl.user_id = $user_id ORDER BY orderstbl.id DESC"); 	
}
else{
  $query = $pdo->query("SELECT 
  	trackstbl.id, trackstbl.title, trackstbl.duration, trackstbl.long_url, trackstbl.image, orderstbl.category
		FROM trackstbl	INNER JOIN	orderstbl ON orderstbl.product_id = trackstbl.id 
		WHERE orderstbl.category = 'tracks' AND orderstbl.user_id = $user_id ORDER BY orderstbl.id DESC");  
  }
if (isset($_GET['tracks_download'])) {
	# code...
	$tr_id = $_GET['tracks_download'];
	$stmt = $pdo->prepare('SELECT * FROM trackstbl WHERE id = :track_id ');
	$stmt->execute([':track_id'=>$tr_id]);
	$track_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$file = $track_result['long_url'];
	// var_dump($file);

	if (isset($file)) {
			# code...
		$type = 'mp3';
	    #setting headers
	    header('Content-Description: File Transfer');
	    header('Cache-Control: public');
	    header('Content-Type: '.$type);
	    header("Content-Transfer-Encoding: binary");
	    header('Content-Disposition: attachment; filename='. basename($file));
	    header('Content-Length: '.filesize($file));
	    ob_clean(); #THIS!
	    flush();
	    readfile($file);
      	$insert_query = $pdo->prepare("INSERT INTO tracks_downloadtbl (`track_id`) VALUES (:track)");
        $insert_query->execute([':track' =>$tr_id]);  	    		
		}	
}
if (isset($_GET['singles_download'])) {
	# code...
	$tr_id = $_GET['singles_download'];
	$stmt = $pdo->prepare('SELECT * FROM singlestbl WHERE id = :track_id ');
	$stmt->execute([':track_id'=>$tr_id]);
	$track_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$file = $track_result['long_url'];
	// var_dump($file);

	if (isset($file)) {
			# code...
		$type = 'mp3';
	    #setting headers
	    header('Content-Description: File Transfer');
	    header('Cache-Control: public');
	    header('Content-Type: '.$type);
	    header("Content-Transfer-Encoding: binary");
	    header('Content-Disposition: attachment; filename='. basename($file));
	    header('Content-Length: '.filesize($file));
	    ob_clean(); #THIS!
	    flush();
	    readfile($file);
      	$insert_query = $pdo->prepare("INSERT INTO singles_downloadtbl (`single_id`) VALUES (:track)");
        $insert_query->execute([':track' =>$tr_id]);  	    		
		}	
}


  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<div class="container">
  	<div class="row">
		<div class="music-page-flex">
		    <div class="col-md-8 pusher-3">
		        <h1>Welcome <?=ucfirst($user['lname'])?></h1>
		        <p>
		        All purchased order are carefully structured in categories for you to stream and download directly from our web server. Thanks for your patronage. 
				</p>
	        </div>
	    </div>
	</div>
</div>
<div class="container-fluid">
    <div class="row col-lg-12 header-title pusher">
      <span style="padding-left: 15px;"><a href="?tracks">All Tracks</a></span>
      <span style="padding-left: 15px;"><a href="?singles">All Singles</a></span>
      <span style="padding-left: 15px;"><a href="?albums">All Albums</a></span>
    </div>	
    <?php if(!isset($_GET['albums'])){ ?>
	<div class="row music-media">
	<?php  while($result = $query->fetch(PDO::FETCH_ASSOC)) :  ?>
		<div class="col-sm-6 col-md-6">
		    <div class="row music-view-details">
			  <div class="col-md-4">
                  <img src="<?=$result['image'];?>">	                  
			  </div>
			  <div class="col-md-8">					
					<div class="">
					    <div class="music-ellipse dropdown">
							<a class="my-ellipse mycart-button" href="?<?=$result['category']?>&<?=$result['category'].'_download'?>=<?=$result['id'];?>">
							    Get song <i class="fa fa-cloud-download" aria-hidden="true" ></i>
							</a>									
						</div>																	
					  	<div class="mediPlayer">
						    <audio class="listen" preload="none" data-size="50" src="<?=$result['long_url'];?>"></audio>
						</div>
						<div class="music-descriptions">							
						    <span class=""><?=$result['title'];?></span><br>
						    <span class="small"><?=$result['category'];?></span><br>
							<p><?=$result['duration'];?></p>
						</div>
					</div>								
			  </div>
			</div>			
		</div>
	<?php endwhile; ?>
						
	</div>	
<?php } else { ?>
	<div class="row display">
	<?php  while($result = $query->fetch(PDO::FETCH_ASSOC)) :  ?>		
		<div class="col-md-4 col-sm-4 col-lg-2" style="padding:10px;">
		  <div class="music-ds">
		    <a href="mypage-details.php?album_title=<?=$result['title'];?>">
		      <div class="music-img-holder">
		        <img src="<?=$result['image'];?>">
		      </div>
		      <div class="music-dt">
		        <p><?=$result['title'];?></p>
		      </div>
		    </a>
		  </div>
		</div>
	<?php endwhile; ?>                               
	</div>
<?php }?>

<div class="row">
<?php if(isset($_GET['login']) && $_GET['login'] == 'true'){ ?>
	<script type="text/javascript">
	$( document ).ready(function() {
	   $('.toast').toast('show');
	});	
	</script>
	<style type="text/css">
		.toast{
			background-color: #eee !important;
			border: none !important;
			color: #0b2435;
		}
		.toast-header{
			background-color: #ffffff;
		}
	</style>	
	<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000" style="position: absolute;top: 10px;right: 10px;z-index: 999999999999999">
	  <div class="toast-header">
	    <img src="images/logo.png" width="40" height="" class="rounded mr-2" alt="...">
	    <strong class="mr-auto">Crossmusic</strong>
	    <small>...</small>
	    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
	      <span aria-hidden="true">&times;</span>
	    </button>
	  </div>
	  <div class="toast-body">
	    Welcome, your are now logged in.
	  </div>
	</div>	
<?php }  ?>		
</div>	            
</div>



<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>