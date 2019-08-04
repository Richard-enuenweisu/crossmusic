<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

  // get free tracks
  $stmt = $pdo->query("SELECT * FROM trackstbl WHERE price = 0 AND featured = 1 ORDER BY id DESC LIMIT 12");
  // get free singles
  $stmt2 = $pdo->query("SELECT * FROM singlestbl WHERE price = 0 AND featured = 1 ORDER BY id DESC LIMIT 12");
  // get free albums
  $stmt3 = $pdo->query("SELECT * FROM albumstbl WHERE price = 0 AND featured = 1 ORDER BY id DESC LIMIT 12");  

  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>

<div class="container">
  <div class="row">
	<div class="page-search-flex">
	    <div class="col-md-8 pusher-3">
	        <h1>Get your heart songs</h1>
	        <p>
	        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
			    </p>
    	    <div id="custom-search-input">
                <div class="input-group">
                    <input type="text" class="search-query form-control" placeholder="Search" />
                    <span class="input-group-btn">
                        <button type="button" disabled>
                            <span class="fa fa-search"></span>
                        </button>
                    </span>
                </div>
            </div>            
	    </div>		
	</div>        
  </div>

  <div class="row display">
    <div class="col-lg-12 header-title pusher">
      <span>Latest Songs</span>
      <a href=""><span class="pull-right">See All <i class="fa fa-arrow-right"></i></span></a>
    </div>
    <?php while($l_song = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col-md-4 col-sm-4 col-lg-2" style="padding: 5px;">
      <div class="music-ds">
        <a href="free-details.php?freetracks=<?=$l_song['title']?>">
          <div class="music-img-holder">
            <img src="<?=$l_song['image']?>">
          </div>
          <div class="music-dt">
            <p><?=$l_song['title']?></p>
          </div>
        </a>
      </div>
    </div>  
    <?php endwhile; ?>                            
  </div>
</div>
<!-- Add banner section -->
<div class="container d-none d-lg-block d-xl-block pusher-2">
  <div class="row">
    <img class="img-fluid" src="images/banner.jpg">
  </div>
</div>
<!-- banner section ends here -->
<div class="container">
  <div class="row display">
    <div class="col-lg-12 header-title pusher">
      <span>Latest Singles</span>
      <a href=""><span class="pull-right">See All <i class="fa fa-arrow-right"></i></span></a>
    </div>
    <?php while($l_songles = $stmt2->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col-md-4 col-sm-4 col-lg-2" style="padding: 5px;">
      <div class="music-ds">
        <a href="free-details.php?freesingles=<?=$l_songles['title']?>">
          <div class="music-img-holder">
            <img src="<?=$l_songles['image']?>">
          </div>
          <div class="music-dt">
            <p><?=$l_songles['title']?></p>
          </div>
        </a>
      </div>
    </div>  
    <?php endwhile; ?>                                  
  </div> 
</div>

<div class="container">
  <div class="row display">
    <div class="col-lg-12 header-title pusher">
      <span>Latest Albums</span>
      <a href=""><span class="pull-right">See All <i class="fa fa-arrow-right"></i></span></a>
    </div>
    <?php while($l_albums = $stmt3->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col-md-4 col-sm-4 col-lg-2" style="padding: 5px;">
      <div class="music-ds">
        <a href="free-details.php?freealbums=<?=$l_albums['title']?>">
          <div class="music-img-holder">
            <img src="<?=$l_albums['image']?>">
          </div>
          <div class="music-dt">
            <p><?=$l_albums['title']?></p>
          </div>
        </a>
      </div>
    </div>  
    <?php endwhile; ?>                              
  </div> 
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>