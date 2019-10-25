
<div class="page-search-flex">
  <div class="col-md-8 pusher-3">
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