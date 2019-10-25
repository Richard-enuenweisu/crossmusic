    <style type="text/css">
      .nav-user-category{
        padding: 20px;
      }
      .social-intro-icons a{
        color: #f81d89;
      }
    </style>
    <nav>
      <div class="navbar navbar-expand-lg bsnav bsnav-light">
        <a class="navbar-brand" href="index"><img src="images/logo.png"></a>
        <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-md-end">
          <ul class="navbar-nav navbar-mobile mr-0">
<!--             <li class="nav-item dropdown"><a class="nav-link" href="#">Has children! <i class="caret"></i></a>
              <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#">Action</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Levels <i class="caret"></i></a>
                  <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#">Action</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Levels <i class="caret"></i></a>
                      <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="#">Action</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Other action</a></li>
                      </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Other action</a></li>
                  </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">Other action</a></li>
              </ul>
            </li> -->
            <li class="nav-item"><a class="nav-link" href="pricing">Let's do Business</a></li>
            <li class="nav-item"><a class="nav-link" href="freemusic">Free music</a></li>
            <li class="nav-item"><a class="nav-link" href="paidmusic">Paid music</a></li>
            <li class="nav-item"><a class="nav-link" href="blog">Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="contact">Contact us</a></li>
            <li class="nav-item dropdown dropdown-right"><a class="nav-link" href="#">Account <i class="caret"></i></a>
              <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#myModal-1" href="">Create account</a></li>
                <?php if (isset($_SESSION['USER_ID'])){ ?>
                  <li class="nav-item"><a class="nav-link" href="mypage">My Page</a></li>
                <?php } ?>                 
                <?php if (isset($_SESSION['USER_ID']) || isset($_SESSION['ARTIST_ID']) || isset($_SESSION['AFFILIATE_ID']) ){?>
                  <li class="nav-item"><a class="nav-link" href="logout">Log out</a></li>
                <?php }else { ?>
                  <li class="nav-item"><a class="nav-link" href="login">Log in</a></li>
                <?php } ?>                                                              
              </ul>
            </li>
            <li class="nav-item"><a class="btn btn-sm btn-custom" href="affiliate" style="margin-top: 5px;">Affiliate Marketer</a></li>                      
          </ul>
        </div>
      </div>
      <div class="bsnav-mobile">
        <div class="bsnav-mobile-overlay"></div>
        <div class="navbar"></div>
      </div>      
    </nav>
    <div class="modal fade" id="myModal-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-center">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="images/logo.png" style="width: 45px;height: auto;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col">
                      <div class="nav-user-category">
                          <h6 class="h6">As a</h6>
                          <h1>USER</h1>
                          <a href="register" class="btn btn-small btn-custom">Register</a>
                      </div>
                    </div>
                    <div class="col">
                      <div class="nav-user-category">
                          <h6 class="h6">As an</h6>
                          <h1>Artist</h1>
                          <a href="pricing" class="btn btn-small btn-custom">Register</a>
                      </div>
                    </div>                    
                  </div>
<!--                   <form>
                    <h1>As a User</h1>
                    <button type="button" class="btn btn-custom btn-pinky" data-dismiss="modal">Close</button>
                    <hr>
                    <h1>As a Savor of Men</h1>
                    <button type="button" class="btn btn-custom btn-pinky">Continue</button>        
                  </form> -->                 
                </div>
                <div class="modal-footer text-center">
                  <div class="col-12">
                    <div class="blog-view-social-icons">
                      <li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-facebook"></i></a></li>
                      <li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-twitter"></i></a></li>
                      <li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-instagram"></i></a></li>
                      <li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-google-plus"></i></a></li>      
                     <!--  <a href="#"><i class="fa fa-facebook fa-2x intro-icons" aria-hidden="true"></i></a>
                      <a href="#"><i class="fa fa-instagram fa-2x intro-icons" aria-hidden="true"></i></a>
                      <a href="#"><i class="fa fa-twitter fa-2x intro-icons" aria-hidden="true"></i></a> -->
                    </div>
                  </div> 
                </div>
            </div>
        </div>
    </div>
</div>