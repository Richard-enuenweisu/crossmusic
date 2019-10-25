
<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

if (isset($_GET['track'])) {
	# code...
	$track_id = $_GET['track'];
	$stmt = $pdo->prepare("SELECT * FROM trackstbl WHERE id =:track_id"); 
	$stmt->execute([':track_id' => $track_id]);
	
	$row = $stmt->rowcount();
	if ($row < 1) {
      header('Location: blog');
    }else{
    	$result = $stmt->fetch(PDO::FETCH_ASSOC);
    	$post_date = strtotime($result['created_at'] );
		$mydate = date('jS F Y', $post_date );
    }
	
}
 if (isset($_GET['albums'])) {
	# code...
	$track_id = $_GET['albums'];
	$stmt = $pdo->prepare("SELECT accounttbl.company_name, albumstbl.id, albumstbl.title, albumstbl.price, albumstbl.featured, albumstbl.description, albumstbl.image, albumstbl.account_id FROM albumstbl INNER JOIN accounttbl ON accounttbl.id = albumstbl.account_id WHERE albumstbl.id =:track_id"); 
	$stmt->execute([':track_id' => $track_id]);	
	$row = $stmt->rowcount();
	if ($row < 1) {
      header('Location: blog');
    }else{
    	$result = $stmt->fetch(PDO::FETCH_ASSOC);
    	$post_date = strtotime($result['created_at'] );
		$mydate = date('jS F Y', $post_date );

		// fetch tracks
		$album_id = $result['id'];
	    $stmt2 = $pdo->prepare("SELECT * FROM trackstbl WHERE album_id =:album_id");
	    $stmt2->execute([':album_id' => $album_id]);

    }	  
  
}elseif (isset($_GET['singles'])) {
	# code...
	$track_id = $_GET['singles'];
	$stmt = $pdo->prepare("SELECT * FROM singlestbl WHERE id =:track_id "); 
	$stmt->execute([':track_id' => $track_id]);	
	$row = $stmt->rowcount();
	if ($row < 1) {
      header('Location: blog');
    }else{
    	$result = $stmt->fetch(PDO::FETCH_ASSOC);
    	$post_date = strtotime($result['created_at'] );
		$mydate = date('jS F Y', $post_date );
    }	
}
else{
	$track_id = $_GET['track'];
	$stmt = $pdo->prepare("SELECT * FROM trackstbl WHERE id =:track_id"); 
	$stmt->execute([':track_id' => $track_id]);
	$row = $stmt->rowcount();
	if ($row < 1) {
      header('Location: blog');
    }else{
    	$result = $stmt->fetch(PDO::FETCH_ASSOC);
    	$post_date = strtotime($result['created_at'] );
		$mydate = date('jS F Y', $post_date );
    }	 
}

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "https") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$long_url = urlencode($actual_link);
$bitly_login = 'o_3imer2s9ir';
$bitly_apikey = 'R_86d9c6da47eb485bb38e814bc4fe3dd0';
$bitly_response = json_decode(file_get_contents("http://api.bit.ly/v3/shorten?login={$bitly_login}&apiKey={$bitly_apikey}&longUrl={$long_url}&format=json"));
$short_url = $bitly_response->data->url;


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
.btn-link, .btn-link:hover{
	color: #8b8b8b;
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
      	<div class="col-md-2 push">
      		<div class="d-none d-lg-block side-ad">
      			<a href="index"><img class="img-fluid" src="images/side-ad.png"></a>
      		</div>
      	</div>
        <div class="col-md-8 col-md-8 push">
		    <div id="share" style="font-size: 10px;"></div>
		    <script src="jsSocial/jquery.js"></script>
		    <script src="jsSocial/jssocials.min.js"></script>
		    <script>
			$("#share").jsSocials({
				shareIn: "popup",									
			    url: "<?=$short_url?>",
			    text: "<?=$result['title']?> - Get the song! | Get free unlimited songs uploads. Crossmusic proffer a much more simpler way to sell your gospel music and get you going.",
			    showLabel: true,
			    showCount: "inside",
			    shares: ["twitter", "facebook", "whatsapp"]
			});
		    </script>	        	
          <h1 class="mt-3 mb-2"><?=$result['title']?></h1>
          <div class="row" style="color: #949596; padding: 5px; ">
            <div class="col-6" style="text-align: left;">
              <p class="small"><?=$result['song_by']?> • <?=$mydate?></p>
            </div>
            <div class="col-6" style="text-align: right;">
				<!-- <span class="small">Downloads 7 <i class="fa fa-cloud-download"></i></span> -->
            </div>          
          </div>
         <div class="description">
          	<?=$result['description']?>
      	</div>
      	<div class="row">
      		<div class="col-md-4">      			
      			<a href="paidmusic"><img class="img-fluid mb-1" src="<?=$result['image']?>"></a>
      			<div class="music-ellipse dropdown">
      			<a href="paidmusic" class="my-ellipse btn mycart-button">Buy <i class="fa fa-shopping-cart"></i></a>
      			</div>
			  	<div class="mediPlayer">
				    <audio class="listen" preload="none" data-size="50" src="<?=$result['short_url']?>"></audio>				    
				</div>
      		</div>
      		<div class="col-md-8">
      			<hr>      			
      			<?php if(isset($_GET['albums'])){ ?>
		        <h3 class="mt-4">Track Lyrics Listing</h3>
		        <?php while($result2 = $stmt2->fetch(PDO::FETCH_ASSOC)) : 
		        	$count = 1;
		        	$counter = $counter + $count;
		        ?>
		            <div class="accordion" id="faqExample">
		                <div class="card">
		                    <div class="card-header p-2" id="headingOne">
		                        <h5 class="mb-0">
		                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$counter;?>" aria-expanded="true" aria-controls="collapseOne">
		                             <?=$result2['title'];?>
		                            </button>
		                          </h5>
		                    </div>
		                    <div id="collapse<?=$counter;?>" class="collapse" aria-labelledby="headingOne" data-parent="#faqExample">
		                        <div class="card-body" style="background: #fff;font-style: italic;">
		                             <?=$result2['lyrics'];?>		                            
		                        </div>
		                    </div>
		                </div>      			
      				</div>
      			<?php endwhile; ?>   
      		<?php }else{ ?>   
      			<h2>Lyrics</h2>				
      			<div class="lyrics cust-pad" style="background: #fff;font-style: italic;">
		          <?=$result['lyrics']?>		                				
      			</div>
      		<?php } ?>
      		</div>
        </div>
    </div>
      	<div class=" col-md-2 push">
      		<div class="d-none d-lg-block side-ad">
      			<a href="index"><img class="img-fluid" src="images/side-ad.png"></a>
      		</div>
      	</div>        
    </div>
    <div class="row pusher-2"></div>
</div>
<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>