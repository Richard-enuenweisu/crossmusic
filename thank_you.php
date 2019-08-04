<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
include str_replace("\\","/",dirname(__FILE__).'/includes/head.php');
include str_replace("\\","/",dirname(__FILE__).'/includes/nav.php');
?>
<style type="text/css">

#custom-search-input .search-query{
  /*background-color: #2f3238 !important;*/
}
  /*login form*/
.flex-form{
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  color: #ccc;
}
.success-box-bg{
  min-height: 100vh;
}
.box-holder{
  background-color:#000000a8;
  padding:20px 15px 20px 15px;
  color:#fff;
  margin-bottom: 15px;  
}
</style>
<div class="container-fluid success-box-bg">
  <div class="row flex-form">
    <div class=" col-md-6 pusher-2" >       
      <div class="row text-center pusher">
        <div class="col-md-12">
          <div class="box-holder">
          	<img src="images/logo.png" width="120px" height="120px">
            <h2>Thank you for making a purchase.</h2>
            <a class="btn btn-custom form-pill" href="mypage.php">Go to my page</a>
          </div>
        </div>         
      </div>   
    </div>
  </div>
</div>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/includes/paystack.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/foot.php');
  include str_replace("\\","/",dirname(__FILE__).'/includes/footscripts.php');
?>