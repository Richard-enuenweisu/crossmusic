<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

  // get free tracks
  $stmt = $pdo->query("SELECT * FROM trackstbl WHERE price > 0 AND featured = 1 ORDER BY id DESC LIMIT 12");
  // get free singles
  $stmt2 = $pdo->query("SELECT * FROM singlestbl WHERE price > 0 AND featured = 1 ORDER BY id DESC LIMIT 12");
  // get free albums
  $stmt3 = $pdo->query("SELECT * FROM albumstbl INNER JOIN accounttbl ON accounttbl.id = albumstbl.account_id WHERE albumstbl.price > 0 AND albumstbl.featured = 1 ORDER BY albumstbl.id DESC LIMIT 12");  

  // search script
  include str_replace("\\","/",dirname(__FILE__).'/includes/search.php');  
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>

<div class="container">
<div class="row">
  <?php include str_replace("\\","/",dirname(__FILE__).'/includes/elastic-search.php');  ?>      
</div>

  <div class="row display">
    <div class="col-lg-12 header-title pusher">
      <span>Latest Songs</span>
      <a href="paidlisting.php?tracks"><span class="pull-right">See All <i class="fa fa-arrow-right"></i></span></a>
    </div>
    <?php while($l_song = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col-md-4 col-sm-4 col-lg-2 col-6" style="padding: 5px;">
      <div class="music-ds">
        <a href="paid-details.php?paidtracks=<?=$l_song['title']?>&songby=<?=$l_song['song_by']?>">
          <div class="music-img-holder">
            <img src="<?=$l_song['image']?>">
          </div>
          <div class="music-dt">
            <span class="small"><?=$l_song['song_by']?></span>
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
      <a href="paidlisting.php?singles"><span class="pull-right">See All <i class="fa fa-arrow-right"></i></span></a>
    </div>
    <?php while($l_songles = $stmt2->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col-md-4 col-sm-4 col-lg-2 col-6" style="padding: 5px;">
      <div class="music-ds">
        <a href="paid-details.php?paidsingles=<?=$l_songles['title']?>&songby=<?=$l_songles['song_by']?>">
          <div class="music-img-holder">
            <img src="<?=$l_songles['image']?>">
          </div>
          <div class="music-dt">
            <span class="small"><?=$l_songles['song_by']?></span>
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
      <a href="paidlisting.php?albums"><span class="pull-right">See All <i class="fa fa-arrow-right"></i></span></a>
    </div>
    <?php while($l_albums = $stmt3->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col-md-4 col-sm-4 col-lg-2 col-6" style="padding: 5px;">
      <div class="music-ds">
        <a href="paid-details.php?paidalbums=<?=$l_albums['title']?>&songby=<?=$l_albums['company_name']?>">
          <div class="music-img-holder">
            <img src="<?=$l_albums['image']?>">
          </div>
          <div class="music-dt">
            <span class="small"><?=$l_albums['company_name']?></span>
            <p><?=$l_albums['title']?></p>
          </div>
        </a>
      </div>
    </div>  
    <?php endwhile; ?>                              
  </div> 
</div>

<div class="container">
  <div class="row">
    <?php if(isset($_GET['user']) && $_GET['user'] == 'false'){ ?>
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
          Please Login and try purchasing your selected item.
        </div>
      </div>  
    <?php }  ?>
  </div>    
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>