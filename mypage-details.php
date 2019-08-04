<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
 if (isset($_GET['album_title'])) {
  	# code...
  	$title = $_GET['album_title'];
    $stmt = $pdo->prepare("SELECT * FROM albumstbl WHERE title =:title");
    $stmt->execute([':title' => $title]);
    $prev_result = $stmt->fetch(PDO::FETCH_ASSOC);
   	if (is_null($prev_result) || empty($prev_result)) {
	# code...
	header('Location: mypage.php');
	}     
  $main_category = 'albums';      
  $category = 'tracks'; 
	// fetch tracks
	$album_id = $prev_result['id'];
    $stmt2 = $pdo->prepare("SELECT * FROM trackstbl WHERE album_id =:album_id");
    $stmt2->execute([':album_id' => $album_id]);

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
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<div class="container">
  <div class="row">
	<div class="music-page-flex">
	    <div class="col-md-8 pusher-3">
	        <h1>Welcome Oluwatoyin</h1>
	        <p>
	        All purchased order are carefully structured in categories for you to stream and download directly from our web server. Thanks for your patronage. 
			</p>
			<div class="row music-media pusher">
				<div class="col-sm-12 col-md-12">
				    <div class="row music-view-details">
					  <div class="col-md-4">
		                  <img src="<?=$prev_result['image']?>">
						  	<div class="">
							    <span class="small"><?=$main_category?></span><br>
								<p><?=$prev_result['title']?></p>
								<p><em>Purchased Album</em></p>
							</div>									
					  </div>
					  <div class="col-md-8">	
					  <?php while($result = $stmt2->fetch(PDO::FETCH_ASSOC)) : ?>					
							<div class="music-child-details">
							    <div class="music-ellipse dropdown">
								<a class="my-ellipse mycart-button" href="?<?=$category.'_download'?>=<?=$result['id']?>">
								    Get song <i class="fa fa-cloud-download" aria-hidden="true" ></i>
								</a>
								</div>																	
							  	<div class="mediPlayer">
								    <audio class="listen" preload="none" data-size="50" src="<?=$result['long_url']?>"></audio>
								</div>
								<div class="music-descriptions">							
								    <span class="small"><?=$result['title']?></span><br>
									<p><?=$result['duration']?></p>
								</div>
							</div>
						<?php endwhile; ?>																
					  </div>
					</div>			
				</div>
			</div>	            
	    </div>		
	</div>        
  </div>
</div>



<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>