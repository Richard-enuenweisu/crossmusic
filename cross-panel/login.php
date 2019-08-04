<?php
require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');

// echo str_replace("\\","/",dirname(__FILE__).'/core/init.php');

if (isset($_POST['affiliate'])) {
  # code...
  $email = ((isset($_POST['email']))?sanitize($_POST['email']): '');
  $pass = ((isset($_POST['pass']))?sanitize($_POST['pass']): '');
  $errors = array();

  if (empty($email) || empty($pass)) {
    $errors[].= 'Some fields are empty'.'<br>';
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[].='email is not a valid email address'.'<br>';
  }


  $salted = 'Z%yHrcR8QDhF99CC^ZZ9qe!+k'.$pass.'f+KA??dj7$S$HL4guq$yJ5_3b';
  $hashed = hash('sha224', $salted);

  $stmt = $pdo->prepare("SELECT * FROM aff_userstbl WHERE email=:email AND password=:pass");
  $stmt->execute([':email' => $email, ':pass'=>$hashed]); 
  $row = $stmt->rowcount();
  $result =$stmt->fetch(PDO::FETCH_ASSOC);

  if ($row < 1) {
    $errors[].='users does not exist!'.'<br>';
  }
  if (empty($errors)) {
    $u_id = intval($result['account_id']);
    $success = 'Logged in Successfully! '.'<br>';
    affiliateLogin($u_id);
  }
}

if (isset($_POST['login'])) {
  # code...
  $email = ((isset($_POST['email']))?sanitize($_POST['email']): '');
  $pass = ((isset($_POST['pass']))?sanitize($_POST['pass']): '');
  $errors = array();

  if (empty($email) || empty($pass)) {
    $errors[].= 'Some fields are empty'.'<br>';
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[].='email is not a valid email address'.'<br>';
  }


  $salted = 'Z%yHrcR8QDhF99CC^ZZ9qe!+k'.$pass.'f+KA??dj7$S$HL4guq$yJ5_3b';
  $hashed = hash('sha224', $salted);

  $stmt = $pdo->prepare("SELECT * FROM artisttbl WHERE email=:email AND password=:pass");
  $stmt->execute([':email' => $email, ':pass'=>$hashed]); 
  $row = $stmt->rowcount();
  $result =$stmt->fetch(PDO::FETCH_ASSOC);

  if ($row < 1) {
    $errors[].='users does not exist!'.'<br>';
  }
  if (empty($errors)) {
    $u_id = intval($result['account_id']);
    $success = 'Logged in Successfully! '.'<br>';
    artistLogin($u_id);
  }
}
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/header.php');
  // include str_replace("\\","/",dirname(__FILE__).'/assets/include/headbar.php');

?>
<main class="u-main" role="main">
      <!-- Sidebar -->
    <?php
      // include str_replace("\\","/",dirname(__FILE__).'/assets/include/nav.php');
    ?>  
<style type="text/css">
  /*login form*/
  .form-container{
  background-color:#0B2435;
  /*height: 100vh;*/
  color: #fff;
  }
.flex-form{
  display: flex;
  justify-content: center;
  align-items: center;
  /*height: 100vh;*/
}
.myform-holder{
  background-color:#103344;
  /*flex-direction: column;*/
  /*padding:15px;*/
  color:#fff;
}
.myform{
  padding:15px;
}
.img-login{
  width: 100%;
}
@media (min-width: 768px){
.u-main {
    min-height: calc(100% - 3.75rem);
     padding-left: 0px; 
}
}
</style>

<div class="container-fluid form-container">
  <div class="row flex-form">
    <?php if(isset($_GET['affiliate'])) {?>
    <div class="col-md-6" >
      <h2 class="content-title pusher-2">Affiliate Login</h2>
      <div class="myform-holder">
        <form class="myform" method="post" action="login.php?affiliate">
          <div class="row">
            <div class="col-md-12">
            <?php if(isset($success)){ ?>
                <span class="text-success"> <?php echo $success; ?></span>
            <?php } else if(isset($errors)){ ?>
                  <span class="text-danger"><?php echo display_errors($errors); ?></span>
            <?php } ?>              
            </div>
          </div>            
          <div class="myinputs">
            <label for="exampleInputEmail1">Email</label>
            <input class="form-control form-pill" type="email" name="email" aria-describedby="emailHelp" placeholder="Enter Email" value="<?=((isset($email))?$email:'');?>">
          </div>
          <div class="myinputs push">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control form-pill" type="password" name="pass" placeholder="Password" value="<?=((isset($pass))?$pass:'');?>">
          </div>
          <div class="contact-btn push">
            <button type="submit" class="btn btn-primary form-pill" name="affiliate"><span class="ti-key"></span>Please Login </button>
          </div>
          <br>
         <i>Are you an artist ? <a class="" href="login.php">click here</a></i>
        </form>
        <img class="img-login" src="assets/img/login-img.png">                  
        </div>
        <div class="text-center">
          <!-- click here to <a class="d-block small mt-3" href="/cross/account.php">Register an Account</a> -->
          <!-- <a class="d-block small" href="forgot-password.html">Forgot Password?</a> -->
        </div>
      <div class="pusher-2"></div>    
    </div>        
    <?php }else{?>  
    <div class="col-md-6" >
      <h2 class="content-title pusher-2">Admin Login</h2>
      <div class="myform-holder">
        <form class="myform" method="post" action="login.php">
          <div class="row">
            <div class="col-md-12">
            <?php if(isset($success)){ ?>
                <span class="text-success"> <?php echo $success; ?></span>
            <?php } else if(isset($errors)){ ?>
                  <span class="text-danger"><?php echo display_errors($errors); ?></span>
            <?php } ?>              
            </div>
          </div>            
          <div class="myinputs">
            <label for="exampleInputEmail1">Email</label>
            <input class="form-control form-pill" type="email" name="email" aria-describedby="emailHelp" placeholder="Enter Email" value="<?=((isset($email))?$email:'');?>">
          </div>
          <div class="myinputs push">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control form-pill" type="password" name="pass" placeholder="Password" value="<?=((isset($pass))?$pass:'');?>">
          </div>
          <div class="contact-btn push">
            <button type="submit" class="btn btn-primary form-pill" name="login"><span class="ti-key"></span>Please Login </button>
          </div>
          <br>
         <i>Affiliate marketer? <a class="" href="login.php?affiliate">click here</a></i>
        </form>
        <img class="img-login" src="assets/img/login-img.png">                  
        </div>
        <div class="text-center">
          <!-- click here to <a class="d-block small mt-3" href="/cross/account.php">Register an Account</a> -->
          <!-- <a class="d-block small" href="forgot-password.html">Forgot Password?</a> -->
        </div>
      <div class="pusher-2"></div>    
    </div>  
    <?php }?>      
  </div>
</div>

<?php
  // include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>