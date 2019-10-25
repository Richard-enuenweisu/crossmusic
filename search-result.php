<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

// get free tracks
if (isset($_GET['tracks']) && isset($_GET['type'])) {
$title = '%'.$_GET['tracks'].'%';
$type = $_GET['type'];
if ($type =='free') {
  # code...
  $stmt = $pdo->prepare("SELECT * from `trackstbl` WHERE title LIKE :title AND price = 0 AND featured = 1 ORDER BY id DESC "); 
  $stmt->execute([':title' => $title]); 
}else{
  $stmt = $pdo->prepare("SELECT * from `trackstbl` WHERE title LIKE :title AND price > 0 AND featured = 1 ORDER BY id DESC "); 
  $stmt->execute([':title' => $title]);
}
$rows = $stmt->rowcount();

}elseif (isset($_GET['singles']) && isset($_GET['type'])) {
$title = '%'.$_GET['singles'].'%';
$type = $_GET['type'];  
if ($type =='free') {
  # code...
  $stmt = $pdo->prepare("SELECT * from `singlestbl` WHERE title LIKE :title AND price = 0 AND featured = 1 ORDER BY id DESC "); 
  $stmt->execute([':title' => $title]); 
}else{
  $stmt = $pdo->prepare("SELECT * from `singlestbl` WHERE title LIKE :title AND price > 0 AND featured = 1 ORDER BY id DESC "); 
  $stmt->execute([':title' => $title]);
}
$rows = $stmt->rowcount();
}elseif (isset($_GET['albums']) && isset($_GET['type'])) {
$title = '%'.$_GET['albums'].'%';
$type = $_GET['type']; 

if ($type =='free') {
  # code...
  $stmt = $pdo->prepare("SELECT * FROM albumstbl INNER JOIN accounttbl ON accounttbl.id = albumstbl.account_id WHERE albumstbl.title LIKE :title AND albumstbl.price = 0 AND albumstbl.featured = 1 ORDER BY albumstbl.id DESC"); 
  $stmt->execute([':title' => $title]); 
}else{
  $stmt = $pdo->prepare("SELECT * FROM albumstbl INNER JOIN accounttbl ON accounttbl.id = albumstbl.account_id WHERE albumstbl.title LIKE :title AND albumstbl.price > 0 AND albumstbl.featured = 1 ORDER BY albumstbl.id DESC"); 
  $stmt->execute([':title' => $title]);
}
$rows = $stmt->rowcount();  
  
}else{
  // header('Location:paidmusic.php');
}
 
  // search script
  include str_replace("\\","/",dirname(__FILE__).'/includes/search.php');  
  include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">
.page-link{
  background-color: #042c49;
  border: 1px solid #042c49;  
  color: #eee;
}
.page-link:hover{
  background-color: #233e5285;
  border: 1px solid #233e5285;  
  color: #eee;
}
li .page-link.active{
  background-color: #233e5285;
}
</style>
<div class="container">
  <div class="row">
  <div class="page-search-flex">
      <div class="col-md-8 pusher-3">
          <h1>Get your heart songs</h1>
          <p>
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
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
  </div>

  <?php if(isset($_GET['tracks'])){ ?>
  <div class="row display">
    <div class="col-lg-12 header-title pusher">
      <span>All Songs</span>
    </div>
    <?php 
    if($rows > 0) {
    while($l_song = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col-md-4 col-sm-4 col-lg-2" style="padding: 5px;">
      <div class="music-ds">
        <?php if ($type == 'paid' ){ ?>
        <a href="paid-details.php?paidtracks=<?=$l_song['title']?>&songby=<?=$l_song['song_by']?>">
        <?php }else{ ?>
        <a href="free-details.php?freetracks=<?=$l_song['title']?>&songby=<?=$l_song['song_by']?>">
        <?php } ?>
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
    <?php endwhile; } ?>                                
  </div>
<?php } elseif (isset($_GET['singles'])){ ?>

  <div class="row display">
    <div class="col-lg-12 header-title pusher">
      <span>All Singles</span>
    </div>
    <?php while($l_singles = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col-md-4 col-sm-4 col-lg-2" style="padding: 5px;">
      <div class="music-ds">
        <?php if ($type == 'paid' ){ ?>
        <a href="paid-details.php?paidtracks=<?=$l_song['title']?>&songby=<?=$l_song['song_by']?>">
        <?php }else{ ?>
        <a href="free-details.php?freetracks=<?=$l_song['title']?>&songby=<?=$l_song['song_by']?>">
        <?php } ?>
          <div class="music-img-holder">
            <img src="<?=$l_singles['image']?>">
          </div>
          <div class="music-dt">
            <span class="small"><?=$l_singles['song_by']?></span>
            <p><?=$l_singles['title']?></p>
          </div>
        </a>
      </div>
    </div>  
    <?php endwhile; ?>                                  
  </div> 
<?php } elseif (isset($_GET['albums'])){ ?>
  <div class="row display">
    <div class="col-lg-12 header-title pusher">
      <span>All Albums</span>
    </div>
    <?php while($l_albums = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col-md-4 col-sm-4 col-lg-2" style="padding: 5px;">
      <div class="music-ds">
        <?php if ($type == 'paid' ){ ?>
        <a href="paid-details.php?paidtracks=<?=$l_song['title']?>&songby=<?=$l_song['song_by']?>">
        <?php }else{ ?>
        <a href="free-details.php?freetracks=<?=$l_song['title']?>&songby=<?=$l_song['song_by']?>">
        <?php } ?>
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
<?php } ?>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>