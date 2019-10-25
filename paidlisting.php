<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

// get free tracks
if (isset($_GET['tracks'])) {
# code...
/*How many records you want to show in a single page.*/
$limit = 12;
/*How may adjacent page links should be shown on each side of the current page link.*/
$adjacents = 2;
/*Get total number of records */
$stmt = $pdo->query("SELECT COUNT(*) 'total_rows' FROM `trackstbl` WHERE price > 0 AND featured = 1");
$res = $stmt->fetch(PDO::FETCH_ASSOC);
$total_rows = $res['total_rows'];
/*Get the total number of pages.*/
$total_pages = ceil($total_rows / $limit);

if(isset($_GET['page']) && $_GET['page'] != "") {
  $page = $_GET['page'];
  $offset = $limit * ($page-1);
} else {
  $page = 1;
  $offset = 0;
}
$stmt = $pdo->query("SELECT * from `trackstbl` WHERE price > 0 AND featured = 1 ORDER BY RAND() limit $offset, $limit ");
$rows = $stmt->rowcount();

}elseif (isset($_GET['singles'])) {
  # code...
/*How many records you want to show in a single page.*/
$limit = 12;
/*How may adjacent page links should be shown on each side of the current page link.*/
$adjacents = 2;
/*Get total number of records */
$stmt = $pdo->query("SELECT COUNT(*) 'total_rows' FROM `singlestbl` WHERE price > 0 AND featured = 1");
$res = $stmt->fetch(PDO::FETCH_ASSOC);
$total_rows = $res['total_rows'];
/*Get the total number of pages.*/
$total_pages = ceil($total_rows / $limit);

if(isset($_GET['page']) && $_GET['page'] != "") {
  $page = $_GET['page'];
  $offset = $limit * ($page-1);
} else {
  $page = 1;
  $offset = 0;
}
$stmt = $pdo->query("SELECT * from `singlestbl` WHERE price > 0 AND featured = 1 ORDER BY RAND() limit $offset, $limit ");
$rows = $stmt->rowcount();
}elseif (isset($_GET['albums'])) {
  # code...
/*How many records you want to show in a single page.*/
$limit = 12;
/*How may adjacent page links should be shown on each side of the current page link.*/
$adjacents = 2;
/*Get total number of records */
$stmt = $pdo->query("SELECT COUNT(*) 'total_rows' FROM `albumstbl` WHERE price > 0 AND featured = 1");
$res = $stmt->fetch(PDO::FETCH_ASSOC);
$total_rows = $res['total_rows'];
/*Get the total number of pages.*/
$total_pages = ceil($total_rows / $limit);

if(isset($_GET['page']) && $_GET['page'] != "") {
  $page = $_GET['page'];
  $offset = $limit * ($page-1);
} else {
  $page = 1;
  $offset = 0;
}
  // get free albums
$stmt = $pdo->query("SELECT * FROM albumstbl INNER JOIN accounttbl ON accounttbl.id = albumstbl.account_id WHERE albumstbl.price > 0 AND albumstbl.featured = 1 ORDER BY RAND() DESC LIMIT $offset, $limit "); 
$rows = $stmt->rowcount();  
  
}else{
  header('Location:paidmusic.php');
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
    <?php include str_replace("\\","/",dirname(__FILE__).'/includes/elastic-search.php');  ?>      
  </div>

  <?php if(isset($_GET['tracks'])){ ?>
  <div class="row display">
    <div class="col-lg-12 header-title pusher">
      <span>All Songs</span>
    </div>
    <?php 
    if($rows > 0) {
    while($l_song = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
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
    <?php endwhile; } ?>                                
  </div>
      <!-- pagination -->
      <div class="row">
        <div class="col-lg-12 text-center pusher">
          <?php
          //Checking if the adjacent plus current page number is less than the total page number.
          //If small then page link start showing from page 1 to upto last page.
          if($total_pages <= (1+($adjacents * 2))) {
            $start = 1;
            $end   = $total_pages;
          } else {
            if(($page - $adjacents) > 1) {           //Checking if the current page minus adjacent is greateer than one.
              if(($page + $adjacents) < $total_pages) {  //Checking if current page plus adjacents is less than total pages.
                $start = ($page - $adjacents);         //If true, then we will substract and add adjacent from and to the current page number  
                $end   = ($page + $adjacents);         //to get the range of the page numbers which will be display in the pagination.
              } else {                   //If current page plus adjacents is greater than total pages.
                $start = ($total_pages - (1+($adjacents*2)));  //then the page range will start from total pages minus 1+($adjacents*2)
                $end   = $total_pages;               //and the end will be the last page number that is total pages number.
              }
            } else {                     //If the current page minus adjacent is less than one.
              $start = 1;                                //then start will be start from page number 1
              $end   = (1+($adjacents * 2));             //and end will be the (1+($adjacents * 2)).
            }
          }
          //If you want to display all page links in the pagination then
          //uncomment the following two lines
          //and comment out the whole if condition just above it.
          /*$start = 1;
          $end = $total_pages;*/
          ?>
          
          <?php if($total_pages > 1) { ?>
            <nav aria-label="Page navigation example">
            <ul class="pagination pagination-sm justify-content-center">
              <!-- Link of the first page -->
              <li class='page-item <?php ($page <= 1 ? print '' : '')?>'>
                <a class='page-link' href='?tracks&page=1'>PREVIOUS</a>
              </li>
              <!-- Link of the previous page -->
<!--               <li class='page-item <?php ($page <= 1 ? print '' : '')?>'>
                <a class='page-link' href='?tracks&page=<?php ($page>1 ? print($page-1) : print 1)?>'>&laquo;</a>
              </li>
 -->              <!-- Links of the pages with page number -->
              <?php for($i=$start; $i<=$end; $i++) { ?>
              <li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
                <a class='page-link' href='?tracks&page=<?php echo $i;?>'><?php echo $i;?></a>
              </li>
              <?php } ?>
              <!-- Link of the next page -->
<!--               <li class='page-item <?php ($page >= $total_pages ? print '' : '')?>'>
                <a class='page-link' href='?tracks&page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'>&raquo;</a>
              </li> -->
              <!-- Link of the last page -->
              <li class='page-item <?php ($page >= $total_pages ? print '' : '')?>'>
                <a class='page-link' href='?tracks&page=<?php echo $total_pages;?>'>NEXT</a>
              </li>
            </ul>
            </nav>
          <?php } ?>         
        </div>
      </div>  
<?php } elseif (isset($_GET['singles'])){ ?>

  <div class="row display">
    <div class="col-lg-12 header-title pusher">
      <span>All Singles</span>
    </div>
    <?php while($l_singles = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col-md-4 col-sm-4 col-lg-2 col-6" style="padding: 5px;">
      <div class="music-ds">
        <a href="paid-details.php?paidsingles=<?=$l_singles['title']?>&songby=<?=$l_singles['song_by']?>">
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
      <!-- pagination -->
      <div class="row">
        <div class="col-lg-12 text-center pusher">
          <?php
          //Checking if the adjacent plus current page number is less than the total page number.
          //If small then page link start showing from page 1 to upto last page.
          if($total_pages <= (1+($adjacents * 2))) {
            $start = 1;
            $end   = $total_pages;
          } else {
            if(($page - $adjacents) > 1) {           //Checking if the current page minus adjacent is greateer than one.
              if(($page + $adjacents) < $total_pages) {  //Checking if current page plus adjacents is less than total pages.
                $start = ($page - $adjacents);         //If true, then we will substract and add adjacent from and to the current page number  
                $end   = ($page + $adjacents);         //to get the range of the page numbers which will be display in the pagination.
              } else {                   //If current page plus adjacents is greater than total pages.
                $start = ($total_pages - (1+($adjacents*2)));  //then the page range will start from total pages minus 1+($adjacents*2)
                $end   = $total_pages;               //and the end will be the last page number that is total pages number.
              }
            } else {                     //If the current page minus adjacent is less than one.
              $start = 1;                                //then start will be start from page number 1
              $end   = (1+($adjacents * 2));             //and end will be the (1+($adjacents * 2)).
            }
          }
          //If you want to display all page links in the pagination then
          //uncomment the following two lines
          //and comment out the whole if condition just above it.
          /*$start = 1;
          $end = $total_pages;*/
          ?>          
          <?php if($total_pages > 1) { ?>
            <nav aria-label="Page navigation example">
            <ul class="pagination pagination-sm justify-content-center">
              <!-- Link of the first page -->
              <li class='page-item <?php ($page <= 1 ? print '' : '')?>'>
                <a class='page-link' href='?singles&page=1'>PREVIOUS</a>
              </li>
              <!-- Link of the previous page -->
<!--               <li class='page-item <?php ($page <= 1 ? print '' : '')?>'>
                <a class='page-link' href='?tracks&page=<?php ($page>1 ? print($page-1) : print 1)?>'>&laquo;</a>
              </li>
 -->              <!-- Links of the pages with page number -->
              <?php for($i=$start; $i<=$end; $i++) { ?>
              <li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
                <a class='page-link' href='?singles&page=<?php echo $i;?>'><?php echo $i;?></a>
              </li>
              <?php } ?>
              <!-- Link of the next page -->
<!--               <li class='page-item <?php ($page >= $total_pages ? print '' : '')?>'>
                <a class='page-link' href='?tracks&page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'>&raquo;</a>
              </li> -->
              <!-- Link of the last page -->
              <li class='page-item <?php ($page >= $total_pages ? print '' : '')?>'>
                <a class='page-link' href='?singles&page=<?php echo $total_pages;?>'>NEXT</a>
              </li>
            </ul>
            </nav>
          <?php } ?>         
        </div>
      </div>  
<?php } elseif (isset($_GET['albums'])){ ?>
  <div class="row display">
    <div class="col-lg-12 header-title pusher">
      <span>All Albums</span>
    </div>
    <?php while($l_albums = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
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
      <!-- pagination -->
      <div class="row">
        <div class="col-lg-12 text-center pusher">
          <?php
          //Checking if the adjacent plus current page number is less than the total page number.
          //If small then page link start showing from page 1 to upto last page.
          if($total_pages <= (1+($adjacents * 2))) {
            $start = 1;
            $end   = $total_pages;
          } else {
            if(($page - $adjacents) > 1) {           //Checking if the current page minus adjacent is greateer than one.
              if(($page + $adjacents) < $total_pages) {  //Checking if current page plus adjacents is less than total pages.
                $start = ($page - $adjacents);         //If true, then we will substract and add adjacent from and to the current page number  
                $end   = ($page + $adjacents);         //to get the range of the page numbers which will be display in the pagination.
              } else {                   //If current page plus adjacents is greater than total pages.
                $start = ($total_pages - (1+($adjacents*2)));  //then the page range will start from total pages minus 1+($adjacents*2)
                $end   = $total_pages;               //and the end will be the last page number that is total pages number.
              }
            } else {                     //If the current page minus adjacent is less than one.
              $start = 1;                                //then start will be start from page number 1
              $end   = (1+($adjacents * 2));             //and end will be the (1+($adjacents * 2)).
            }
          }
          //If you want to display all page links in the pagination then
          //uncomment the following two lines
          //and comment out the whole if condition just above it.
          /*$start = 1;
          $end = $total_pages;*/
          ?>          
          <?php if($total_pages > 1) { ?>
            <nav aria-label="Page navigation example">
            <ul class="pagination pagination-sm justify-content-center">
              <!-- Link of the first page -->
              <li class='page-item <?php ($page <= 1 ? print '' : '')?>'>
                <a class='page-link' href='?albums&page=1'>PREVIOUS</a>
              </li>
              <!-- Link of the previous page -->
<!--               <li class='page-item <?php ($page <= 1 ? print '' : '')?>'>
                <a class='page-link' href='?tracks&page=<?php ($page>1 ? print($page-1) : print 1)?>'>&laquo;</a>
              </li>
 -->              <!-- Links of the pages with page number -->
              <?php for($i=$start; $i<=$end; $i++) { ?>
              <li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
                <a class='page-link' href='?albums&page=<?php echo $i;?>'><?php echo $i;?></a>
              </li>
              <?php } ?>
              <!-- Link of the next page -->
<!--               <li class='page-item <?php ($page >= $total_pages ? print '' : '')?>'>
                <a class='page-link' href='?tracks&page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'>&raquo;</a>
              </li> -->
              <!-- Link of the last page -->
              <li class='page-item <?php ($page >= $total_pages ? print '' : '')?>'>
                <a class='page-link' href='?albums&page=<?php echo $total_pages;?>'>NEXT</a>
              </li>
            </ul>
            </nav>
          <?php } ?>         
        </div>
      </div>  
<?php } ?>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>