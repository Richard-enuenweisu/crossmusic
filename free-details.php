<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/includes/free-process.php');

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
  // search script

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "https") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$long_url = urlencode($actual_link);
$bitly_login = 'o_3imer2s9ir';
$bitly_apikey = 'R_86d9c6da47eb485bb38e814bc4fe3dd0';
$bitly_response = json_decode(file_get_contents("http://api.bit.ly/v3/shorten?login={$bitly_login}&apiKey={$bitly_apikey}&longUrl={$long_url}&format=json"));
$short_url = $bitly_response->data->url;

  include str_replace("\\","/",dirname(__FILE__).'/includes/search.php');  
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">
.jssocials-share-link, .jssocials-share-link:hover{
	border: none;
}	
</style>
<div class="container">
  <div class="row">
	<div class="music-page-flex">
	    <div class="col-md-8 pusher-3">
	    	<div class="row">
	    		<div class="col-sm-12 col-md-12">
				      <h1>Get your heart songs</h1>
				      <p>
				      Go head over heels with your next favorite song or artist. Crossmusic has over +2000 tracks for you to browse, listen, buy or download. Use our elastic search to find song or music.
				      </p>
			          <div id="custom-search-input">
			            <form method="POST" action="search-result.php">
			              <div class="input-group">
			                <select class="sinput form-control" name="category" style="border-radius:0px;">
			                  <option>-- Category --</option>
			                  <option>Albums</option>
			                  <option>Tracks</option>
			                  <option>Singles</option>
			                </select>
			                <select class="sinput form-control" name="type" style="border-radius:0px;">
			                  <option>-- Type --</option>
			                  <option>Free</option>
			                  <option>Paid</option>
			                </select>                
			                <input type="text" class="sinput form-control" name="title" placeholder="Title">
			                <!-- <div class="input-group-append"> -->
			                  <button type="submit" class="form-control" name="search" style="color: #fff;background-color: #007bff;border-color: #007bff;border-radius:0px;width: 10%;padding: 10px 0px 7px 0px;"><i class="fa fa-search"></i></button>
			                <!-- </div>                              -->
			              </div> 
			              <?php if(isset($errors)){?> 
			              <!-- alert -->
			              <div class="alert text-danger alert-dismissible fade show" role="alert">
			                <?=$errors?>
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                  <span aria-hidden="true">&times;</span>
			                </button>
			              </div>                 
			              <?php } ?>                          
			            </form>           
			          </div>	    			
	    		</div>
	    	</div>
			<div class="row music-media pusher">
				<div class="col-sm-12 col-md-12">
				    <div class="row music-view-details">
					  <div class="col-md-4">
		                  <img src="<?=$prev_result['image']?>">
							<?php if (isset($_GET['freealbums'])): ?>
							  	<div class="">
								    <span class="small">Album</span><br>
									<p><?=$prev_result['title']?></p>
									<p><em>Free Download</em></p>
								</div>									
							<?php endif ?>	                  	                  
					  </div>
					  <div class="col-md-8">
						<p class="push share-tiny-link">Share: <span id="copy"><?=$short_url?> </span> 
							<button class="btn btn-sm float-right text-white" onclick="copyToClipboard('#copy')"><i class="fa fa-copy"></i></button>
						</p>					  	
					  <?php while($result = $stmt2->fetch(PDO::FETCH_ASSOC)) : 
						//count dowload script
						if (isset($category)) {
							# code...
							$count_id = $result['id'];
							if ($category == 'tracks') {
								# code...							
							$count_query = $pdo->query("SELECT COUNT(*) as count from  tracks_downloadtbl WHERE track_id=$count_id");								
							}elseif ($category == 'singles') {
								# code...
							$count_query = $pdo->query("SELECT COUNT(*) as count from  singles_downloadtbl WHERE single_id =$count_id");								
							}
							$count = $count_query->fetch(PDO::FETCH_ASSOC);
						}
					  	?>						
							<div class="<?=(isset($_GET['freealbums']))?'music-child-details':''?>">
								<!-- jsSocials BEGIN -->
							    <div id="share" style="font-size: 10px;"></div>
							    <script src="jsSocial/jquery.js"></script>
							    <script src="jsSocial/jssocials.min.js"></script>
							    <script>
								$("#share").jsSocials({
									shareIn: "popup",									
								    url: "<?=$short_url?>",
								    text: "<?=$prev_result['title']?> - Get the song! | Get free unlimited songs uploads. Crossmusic proffer a much more simpler way to sell your gospel music and get you going.",
								    showLabel: true,
								    showCount: "inside",
								    shares: ["twitter", "facebook", "whatsapp"]
								});
							    </script>									
								<div class="music-downloads">
									<span class="small">Downloads <?=$count['count']?> <i class="fa fa-cloud-download"></i></span>
								</div>
							    <div class="music-ellipse dropdown">
							    	<a class="my-ellipse mycart-button" href="?<?=$category.'_download'?>=<?=$result['id']?>">
									    free <i class="fa fa-cloud-download" aria-hidden="true" ></i>
									</a>									
								</div>																	
							  	<div class="mediPlayer">
								    <audio class="listen" preload="none" data-size="50" src="<?=$result['short_url']?>"></audio>
								</div>
								<div class="music-descriptions">							
								    <span class="small"><?=$result['title']?></span><br>								
								    <span class="small"><?=$category?></span>
									<?php if (!isset($_GET['freealbum'])): ?>
										<p><?=$result['duration']?></p>								
									<?php endif ?>										
								</div>						
							</div>	
						<?php endwhile;?>							
					    <!-- <div class="media-attribution"><em>30:64</em> - </div> -->
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