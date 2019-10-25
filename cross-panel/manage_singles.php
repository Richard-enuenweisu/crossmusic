<?php
  require_once  str_replace("\\","/",dirname(__FILE__). '/core/init.php');
  require_once  str_replace("\\","/",dirname(__FILE__). '/helpers/helpers.php');
  require 'assets/PHP-MP3-master/phpmp3.php';
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
if (!isset($_SESSION['ARTIST_ID'])) {
  permission_error('login.php');
}else{
	$artist_id = $_SESSION['ARTIST_ID'];
	$stmt = $pdo->query("SELECT * FROM accounttbl WHERE id = $artist_id ");
	$acc_result = $stmt->fetch(PDO::FETCH_ASSOC);
	$acct_type = $acc_result['acct_type'];		
}

if (isset($_POST["add"])) {
    $artcover = $_FILES['artcover']['name'];
    $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
    $title = str_replace('&#039;',"",$title);
    $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
    $duration = ((isset($_POST['duration']) && $_POST['duration'] != '')?sanitize($_POST['duration']):'');
    $description = ((isset($_POST['description']) && $_POST['description'] != '')?$_POST['description']:'');
    $lyrics = ((isset($_POST['lyrics']) && $_POST['lyrics'] != '')?$_POST['lyrics']:'');
    $songby = ((isset($_POST['songby']) && $_POST['songby'] != '')?sanitize($_POST['songby']):'');
    $songby = str_replace('&#039;',"",$songby);
    $track = $_FILES['track']['name'];

    if (!$acct_type == 'Paid Account') {
    	# code...
    	$price = 0;
		$description ='No Details avaialable.';			
		$lyrics ='No Details avaialable.';
    }
    //get cover extension
    $cover_piece = explode('.', $artcover);
    @$cover_name = $cover_piece[0];
    @$cover_ext = $cover_piece[1];
    //get track extension
    $track_piece = explode('.', $track);
    @$track_name = $track_piece[0];
    @$track_ext = $track_piece[1];

    $errors = array();
    $success;

    if (empty($artcover) || empty($title) || empty($duration) || empty($track) || empty($songby) || empty($description) || empty($lyrics)) {
      # code...
      $errors[].= "Found empty fields!.";
    }    
    $allowed_image_extension = array(
        "jpg",
        "jpeg"
    );
    $allowed_track_extension = array(
        "mp3",
        "ogg"
    );    
    // Get image file extension
    $artcover_extension = pathinfo($_FILES["artcover"]["name"], PATHINFO_EXTENSION);    
    $track_extension = pathinfo($_FILES["track"]["name"], PATHINFO_EXTENSION);    
  // Validate file input to check if is with valid extension
    if (!in_array($artcover_extension, $allowed_image_extension)) {
        $errors[].= "Only jpg and jpeg are allowed.";
    }
  // Validate file input to check if is with valid extension
    if (!in_array($track_extension, $allowed_track_extension)) {
        $errors[].= "Only mp3 and 0gg are allowed.";
    }
    // Validate image file size
    if (($_FILES["artcover"]["size"] > 307200)) {
        $errors[].= "Image size exceeds 300Kb";
    }    
    // Validate image file size
    if (($_FILES["track"]["size"] > 20971520)) {
        $errors[].= "track size exceeds 20MB";
    }
    if(empty($errors)) {
    	// set track path
    	$timestamp = date('m j Y g-i');
        $track_target = "../music/".$track_name.$timestamp.'.'.$track_ext;
        $track_path = "music/".$track_name.$timestamp.'.'.$track_ext;
        // set artcover path
        $cover_target = "../images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
        $cover_path = "images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
        if (move_uploaded_file($_FILES["track"]["tmp_name"], $track_target)  && move_uploaded_file($_FILES["artcover"]["tmp_name"], $cover_target)) {
		//Extract 30 seconds starting after 10 seconds.
			$path = $track_target;
			$mp3 = new PHPMP3($path);
			@$mp3_1 = $mp3->extract(10,30);
			$short_track = $mp3_1->save('../music/short_'.$track_name.$timestamp.'.'.$track_ext); 
			//short-track path
			$short_track_path = 'music/short_'.$track_name.$timestamp.'.'.$track_ext;  
			      	
            $insert_query = $pdo->prepare("INSERT INTO  singlestbl ( `acount_id`, `title`, `price`, `song_by`, `duration`, `description`, `lyrics`,`short_url`, `long_url`, `image`) VALUES (:acount_id, :title, :price, :song_by, :duration, :short_url, :long_url, :image)");
            $insert_query->execute([':acount_id' =>$artist_id, ':title' =>$title, ':price'=>$price, ':song_by'=>$songby, ':duration'=>$duration, ':description'=>$description, ':lyrics'=>$lyrics, ':short_url'=>$short_track_path, ':long_url'=>$track_path, ':image'=>$cover_path]);            
            $success = "Uploaded successfully.";
        } else {
            $errors[].= "Problem in uploading single.";
        }

	    if ($acct_type == 'Paid Account') {
	    	# code...
	    // sending email to afffiliate
		require 'vendor/phpmailer/phpmailer/src/Exception.php';
		require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
		require 'vendor/phpmailer/phpmailer/src/SMTP.php';
		require str_replace("\\","/",dirname(__FILE__).'/vendor/autoload.php');
		$mail = new PHPMailer(true);                                     
		    $mail->isSMTP();                                            // Set mailer to use SMTP
		    $mail->Host       = 'smtp.gmail.com'; 						// Specify main and backup SMTP servers
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = 'justcross3@gmail.com';                     // SMTP username
		    $mail->Password   = 'crmail6.';                               // SMTP password
		    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
		    $mail->Port       = 587;                                    // TCP port to connect to
		    //Recipients
		    $mail->setFrom('hello.crossmusic@gmail.com', 'Crossmusic');

		    $mail->addReplyTo('noreply@gmail.com', 'Crossmusic');
		    //loop through emails
			while ($aff_result = $aff_query->fetch(PDO::FETCH_ASSOC)) {
			// clear addresses
			$mail->clearAddresses();
			$mail->AddAddress($aff_result['email']);
			$mail->AddBCC($aff_result['email']);
			}	     		      
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'New Single Release - Crossmusic';
		    $mail->Body    = 
		    '<!doctype html>
	<html>
	  <head>
	    <meta name="viewport" content="width=device-width" />
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <title>Affiliate Updates - Crossmusic</title>
	    <style>
	      /* -------------------------------------
	          GLOBAL RESETS
	      ------------------------------------- */
	      
	      /*All the styling goes here*/
	      
	      img {
	        border: none;
	        -ms-interpolation-mode: bicubic;
	        max-width: 100%; 
	      }
	      body {
	        background-color: #f6f6f6;
	        font-family: sans-serif;
	        -webkit-font-smoothing: antialiased;
	        font-size: 14px;
	        line-height: 1.4;
	        margin: 0;
	        padding: 0;
	        -ms-text-size-adjust: 100%;
	        -webkit-text-size-adjust: 100%; 
	      }
	      table {
	        border-collapse: separate;
	        mso-table-lspace: 0pt;
	        mso-table-rspace: 0pt;
	        width: 100%; }
	        table td {
	          font-family: sans-serif;
	          font-size: 14px;
	          vertical-align: top; 
	      }
	      /* -------------------------------------
	          BODY & CONTAINER
	      ------------------------------------- */
	      .body {
	        background-color: #f6f6f6;
	        width: 100%; 
	      }
	      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
	      .container {
	        display: block;
	        margin: 0 auto !important;
	        /* makes it centered */
	        max-width: 580px;
	        padding: 10px;
	        width: 580px; 
	      }
	      /* This should also be a block element, so that it will fill 100% of the .container */
	      .content {
	        box-sizing: border-box;
	        display: block;
	        margin: 0 auto;
	        max-width: 580px;
	        padding: 10px; 
	      }
	      /* -------------------------------------
	          HEADER, FOOTER, MAIN
	      ------------------------------------- */
	      .main {
	        background: #ffffff;
	        border-radius: 3px;
	        width: 100%; 
	      }
	      .wrapper {
	        box-sizing: border-box;
	        padding: 20px; 
	      }
	      .content-block {
	        padding-bottom: 10px;
	        padding-top: 10px;
	      }
	      .footer {
	        clear: both;
	        margin-top: 10px;
	        text-align: center;
	        width: 100%; 
	      }
	        .footer td,
	        .footer p,
	        .footer span,
	        .footer a {
	          color: #999999;
	          font-size: 12px;
	          text-align: center; 
	      }
	      /* -------------------------------------
	          TYPOGRAPHY
	      ------------------------------------- */
	      h1,
	      h2,
	      h3,
	      h4 {
	        color: #000000;
	        font-family: sans-serif;
	        font-weight: 400;
	        line-height: 1.4;
	        margin: 0;
	        margin-bottom: 30px; 
	      }
	      h1 {
	        font-size: 35px;
	        font-weight: 300;
	        text-align: center;
	        text-transform: capitalize; 
	      }
	      p,
	      ul,
	      ol {
	        font-family: sans-serif;
	        font-size: 14px;
	        font-weight: normal;
	        margin: 0;
	        margin-bottom: 15px; 
	      }
	        p li,
	        ul li,
	        ol li {
	          list-style-position: inside;
	          margin-left: 5px; 
	      }
	      a {
	        color: #3498db;
	        text-decoration: underline; 
	      }
	      /* -------------------------------------
	          BUTTONS
	      ------------------------------------- */
	      .btn {
	        box-sizing: border-box;
	        width: 100%; }
	        .btn > tbody > tr > td {
	          padding-bottom: 15px; }
	        .btn table {
	          width: auto; 
	      }
	        .btn table td {
	          background-color: #ffffff;
	          border-radius: 5px;
	          text-align: center; 
	      }
	        .btn a {
	          background-color: #ffffff;
	          border: solid 1px #3498db;
	          border-radius: 5px;
	          box-sizing: border-box;
	          color: #3498db;
	          cursor: pointer;
	          display: inline-block;
	          font-size: 14px;
	          font-weight: bold;
	          margin: 0;
	          padding: 12px 25px;
	          text-decoration: none;
	          text-transform: capitalize; 
	      }
	      .btn-primary table td {
	        background-color: #3498db; 
	      }
	      .btn-primary a {
	        background-color: #3498db;
	        border-color: #3498db;
	        color: #ffffff; 
	      }
	      /* -------------------------------------
	          OTHER STYLES THAT MIGHT BE USEFUL
	      ------------------------------------- */
	      .last {
	        margin-bottom: 0; 
	      }
	      .first {
	        margin-top: 0; 
	      }
	      .align-center {
	        text-align: center; 
	      }
	      .align-right {
	        text-align: right; 
	      }
	      .align-left {
	        text-align: left; 
	      }
	      .clear {
	        clear: both; 
	      }
	      .mt0 {
	        margin-top: 0; 
	      }
	      .mb0 {
	        margin-bottom: 0; 
	      }
	      .preheader {
	        color: transparent;
	        display: none;
	        height: 0;
	        max-height: 0;
	        max-width: 0;
	        opacity: 0;
	        overflow: hidden;
	        mso-hide: all;
	        visibility: hidden;
	        width: 0; 
	      }
	      .powered-by a {
	        text-decoration: none; 
	      }
	      hr {
	        border: 0;
	        border-bottom: 1px solid #f6f6f6;
	        margin: 20px 0; 
	      }
	      /* -------------------------------------
	          RESPONSIVE AND MOBILE FRIENDLY STYLES
	      ------------------------------------- */
	      @media only screen and (max-width: 620px) {
	        table[class=body] h1 {
	          font-size: 28px !important;
	          margin-bottom: 10px !important; 
	        }
	        table[class=body] p,
	        table[class=body] ul,
	        table[class=body] ol,
	        table[class=body] td,
	        table[class=body] span,
	        table[class=body] a {
	          font-size: 16px !important; 
	        }
	        table[class=body] .wrapper,
	        table[class=body] .article {
	          padding: 10px !important; 
	        }
	        table[class=body] .content {
	          padding: 0 !important; 
	        }
	        table[class=body] .container {
	          padding: 0 !important;
	          width: 100% !important; 
	        }
	        table[class=body] .main {
	          border-left-width: 0 !important;
	          border-radius: 0 !important;
	          border-right-width: 0 !important; 
	        }
	        table[class=body] .btn table {
	          width: 100% !important; 
	        }
	        table[class=body] .btn a {
	          width: 100% !important; 
	        }
	        table[class=body] .img-responsive {
	          height: auto !important;
	          max-width: 100% !important;
	          width: auto !important; 
	        }
	      }
	      /* -------------------------------------
	          PRESERVE THESE STYLES IN THE HEAD
	      ------------------------------------- */
	      @media all {
	        .ExternalClass {
	          width: 100%; 
	        }
	        .ExternalClass,
	        .ExternalClass p,
	        .ExternalClass span,
	        .ExternalClass font,
	        .ExternalClass td,
	        .ExternalClass div {
	          line-height: 100%; 
	        }
	        .apple-link a {
	          color: inherit !important;
	          font-family: inherit !important;
	          font-size: inherit !important;
	          font-weight: inherit !important;
	          line-height: inherit !important;
	          text-decoration: none !important; 
	        }
	        #MessageViewBody a {
	          color: inherit;
	          text-decoration: none;
	          font-size: inherit;
	          font-family: inherit;
	          font-weight: inherit;
	          line-height: inherit;
	        }
	        .btn-primary table td:hover {
	          background-color: #34495e !important; 
	        }
	        .btn-primary a:hover {
	          background-color: #34495e !important;
	          border-color: #34495e !important; 
	        } 
	      }
	    </style>
	  </head>
	  <body class="">
	    <span class="preheader">New updates from crossmusic</span>
	    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
	      <tr>
	        <td>&nbsp;</td>
	        <td class="container">
	          <div class="content">

	            <!-- START CENTERED WHITE CONTAINER -->
	            <table role="presentation" class="main">

	              <!-- START MAIN CONTENT AREA -->
	              <tr>
	                <td class="wrapper">
	                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
	                    <tr>
	                      <td>
	                        <p>Hello From Crossmusic,</p>
	                        <p>New Single updates from crossmusic, be the first to create an affiliate link.</p>
	                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
	                          <tbody>
	                            <tr>
	                                <td><img src="https://mycrossmusic.com/'.$cover_path.'" style="width: 100%"><br>
	                                    <h1>♫ '.$title.' by '.$songby.'</h1>
	                                </td>
	                            </tr>
	                            <tr>
	                              <td align="center">
	                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
	                                  <tbody>
	                                    <tr>
	                                      <td> <a href="https://mycrossmusic.com/affiliate.php?login" target="_blank">Login Now</a> </td>
	                                    </tr>
	                                  </tbody>
	                                </table>
	                              </td>
	                            </tr>
	                            <tr>
	                              <td align="center">
	                                <p>We have provided a simple way of providing updates from artists as they make a new release upload. Have Fun Sharing!.
	                                </p>                                  
	                              </td>                                
	                            </tr>
	                          </tbody>
	                        </table>
	                      </td>
	                    </tr>
	                  </table>
	                </td>
	              </tr>

	            <!-- END MAIN CONTENT AREA -->
	            </table>
	            <!-- END CENTERED WHITE CONTAINER -->

	            <!-- START FOOTER -->
	            <div class="footer">
	              <table role="presentation" border="0" cellpadding="0" cellspacing="0">
	                <tr>
	                  <td class="content-block">
	                    <span class="apple-link">Company Inc, 3 Abbey Road, San Francisco CA 94102</span>
	                  </td>
	                </tr>
	                <tr>
	                  <td class="content-block powered-by">
	                    All right Reserved '.date("Y").'<a href="https://mycrossmusic.com">myrossmusic.com</a>.
	                  </td>
	                </tr>
	              </table>
	            </div>
	            <!-- END FOOTER -->

	          </div>
	        </td>
	        <td>&nbsp;</td>
	      </tr>
	    </table>
	  </body>
	</html>';
		    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		    if (!$mail->send()) {
		    	# code...
		    	$errors[].='Message could not be sent';
		    }else{
	    	// $success = '';
	        }

	    } 
	    //email ends here        

    }
}  

if (isset($_GET['edit'])) {
	# code...
	$single_id = $_GET['edit'];
	$singles_query = $pdo->prepare("SELECT * FROM singlestbl WHERE id =:single_id");
	$singles_query->execute([':single_id'=>$single_id]);
	$singles = $singles_query->fetch(PDO::FETCH_ASSOC);

	//edit singles
	if (isset($_POST['edit'])) {
		# code...
	    $artcover = $_FILES['artcover']['name'];
	    $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
	    $title = str_replace('&#039;',"",$title);
	    $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
	    $duration = ((isset($_POST['duration']) && $_POST['duration'] != '')?sanitize($_POST['duration']):'');
	    $description = ((isset($_POST['description']) && $_POST['description'] != '')?$_POST['description']:'');
	    $lyrics = ((isset($_POST['lyrics']) && $_POST['lyrics'] != '')?$_POST['lyrics']:'');	    
	    $songby = ((isset($_POST['songby']) && $_POST['songby'] != '')?sanitize($_POST['songby']):'');	    
	    $track = $_FILES['track']['name'];

	    // account verification
	    if (!$acct_type == 'Paid Account') {
	    	# code...
	    	$price = 0;
			$description ='No Details avaialable.';			
			$lyrics ='No Details avaialable.';
	    }	    
	    //get cover extension
	    $cover_piece = explode('.', $artcover);
	    @$cover_name = $cover_piece[0];
	    @$cover_ext = $cover_piece[1];
	    //get track extension
	    $track_piece = explode('.', $track);
	    @$track_name = $track_piece[0];
	    @$track_ext = $track_piece[1];

	    $success;    
	    $allowed_image_extension = array(
	        "jpg",
	        "jpeg"
	    );
	    $allowed_track_extension = array(
	        "mp3",
	        "ogg"
	    );    
	    // Get image file extension
	    $artcover_extension = pathinfo($_FILES["artcover"]["name"], PATHINFO_EXTENSION);    
	    $track_extension = pathinfo($_FILES["track"]["name"], PATHINFO_EXTENSION);    
	  
	    if (empty($artcover) || empty($title) || empty($duration) || empty($track) || empty($songby) || empty($description) || empty($lyrics)) {
	      # code...
	      $errors[].= "Found empty fields!.";
	    }
		// set track path
		$timestamp = date('m j Y g-i');
	    $track_target = "../music/".$track_name.$timestamp.'.'.$track_ext;
	    $track_path = "music/".$track_name.$timestamp.'.'.$track_ext;
	    // set artcover path
	    $cover_target = "../images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
	    $cover_path = "images/art/" .$cover_name.$timestamp.'.'.$cover_ext;

 
	  // Validate file input to check if is with valid extension
	    if (!in_array($artcover_extension, $allowed_image_extension)) {
	        $errors[].= "Only jpg and jpeg are allowed.";
	    }
	  // Validate file input to check if is with valid extension
	    if (!in_array($track_extension, $allowed_track_extension)) {
	        $errors[].= "Only mp3 and 0gg are allowed.";
	    }
	    // Validate image file size
	    if (($_FILES["artcover"]["size"] > 307200)) {
	        $errors[].= "Image size exceeds 300Kb";
	    }    
	    // Validate image file size
	    if (($_FILES["track"]["size"] > 20971520)) {
	        $errors[].= "track size exceeds 20MB";
	    }

	    if(empty($errors)) {
	    	// set track path
	    	$timestamp = date('m j Y g-i');
	        $track_target = "../music/".$track_name.$timestamp.'.'.$track_ext;
	        $track_path = "music/".$track_name.$timestamp.'.'.$track_ext;
	        // set artcover path
	        $cover_target = "../images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
	        $cover_path = "images/art/" .$cover_name.$timestamp.'.'.$cover_ext;
	        if (move_uploaded_file($_FILES["track"]["tmp_name"], $track_target)  && move_uploaded_file($_FILES["artcover"]["tmp_name"], $cover_target)) {
	        	// delete image
	        	$unlink_image = '../'.$singles['image'];
	        	// delete music
	        	$unlink_short = '../'.$singles['short_url'];
	        	$unlink_long = '../'.$singles['long_url'];
	        	@unlink($unlink_image);
	        	@unlink($unlink_short);
	        	@unlink($unlink_long);

			//Extract 30 seconds starting after 10 seconds.
				$path = $track_target;
				$mp3 = new PHPMP3($path);
				@$mp3_1 = $mp3->extract(10,30);
				$short_track = $mp3_1->save('../music/short_'.$track_name.$timestamp.'.'.$track_ext); 
				//short-track path
				$short_track_path = 'music/short_'.$track_name.$timestamp.'.'.$track_ext;  
				      	
	            $insert_query = $pdo->prepare(" UPDATE `singlestbl` SET `title`=:title, `price`=:price, `song_by`=:song_by, `duration`=:duration, `description`=:description, `lyrics`=:lyrics, `short_url`=:short_url, `long_url`=:long_url, `image`=:image WHERE `id` =:single_id");
	            $insert_query->execute([':title' =>$title, ':price'=>$price, ':song_by'=>$songby, ':duration'=>$duration, ':description'=>$description, ':lyrics'=>$lyrics, ':short_url'=>$short_track_path, ':long_url'=>$track_path, ':image'=>$cover_path, ':single_id'=>$single_id]);            
	            $success = "Uploaded successfully.";
	            header('refresh:2; url = manage_singles.php?edit='.$single_id);
	        } else {
	            $errors[].= "Problem in uploading single.";
	        }
	    }	    
    
 	           
	}

}




if (isset($_GET['delete'])) {
	# code...
	// $del = intval($_GET['delete']);
 // 	$insert_query = $pdo->prepare(" DELETE FROM givetbl WHERE id = :delete_id");
	// $insert_query->execute([':delete_id' =>$del]); 
	// $success = "Transaction Deleted Successfully! Refreshing in 2 secs.";
	// header("refresh:2;url=confessions.php");
}


  include str_replace("\\","/",dirname(__FILE__).'/assets/include/header.php');
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/headbar.php');
?>

	<main class="u-main" role="main">
			<!-- Sidebar -->
		<?php
		  include str_replace("\\","/",dirname(__FILE__).'/assets/include/nav.php');
		?>	
<style type="text/css">
	.table-responsive img{
		width: 65px;
		height: 65px;
	}
	span.hidden-xs{
		content: none;
	}	
/*	span.hidden-xs:after{
		content: none;
	}*/
</style>
			<div class="u-content">
				<div class=" u-body">
					<h1 class="h2 font-weight-semibold mb-4"><?=(isset($_GET['edit']))?'Edit':'Add'?> Singles</h1>
		<main class="container-fluid " role="main">
			<div class="row">
				<div class="col-lg-12 bg-white mnh-100vh" style="padding: 15px;">
						<a class="u-login-form py-3 text-center" href="index.html">
							<!-- <img class="img-fluid" src="./assets/img/logo.png" width="80" alt="Cross logo">						 -->
						</a>					
					<div> <!-- class="u-login-form" -->
						<form class="mb-3" method="POST" action="manage_singles.php<?=(isset($_GET['edit']))?'?edit='.$single_id:''?>" enctype="multipart/form-data">
							<div class="mb-3">
								<h1 class="h2"><?=(isset($_GET['edit']))?'Edit':'Upload'?> your single</h1>
								<p class="small">All track price are best sold between &#8358;100 and &#8358;200 to encourage patronage.</p>
							</div>
		                      <div class="row">
		                        <?php if(isset($success)){ ?>
		                          <div class="form-control alert alert-success fade show" role="alert">
		                            <i class="fa fa-check-circle alert-icon mr-3"></i>
		                            <span> <?php echo $success; ?></span>
		                            <button type="button" class="close" aria-label="Close" data-dismiss="alert">
		                              <span aria-hidden="true">&times;</span>
		                            </button>
		                          </div>
		                        <?php } else if(isset($errors)){ ?>
		                            <div class="form-control alert alert-danger fade show" role="alert">
		                              <!-- <i class="fa fa-minus-circle alert-icon mr-3"></i> -->
		                              <span><?php echo display_errors($errors); ?></span>
		                              <button type="button" class="close" aria-label="Close" data-dismiss="alert">
		                                <span aria-hidden="true">&times;</span>
		                              </button>
		                            </div>
		                        <?php } ?>
		                      </div> 
		                    <div class="row">
		                    	<div class="col-md-4">
									<label for="email">Single Artcover</label>
									<span class="small text-muted" style="font-style: italic;font-weight: bold;"><?=(isset($_GET['edit']))? $singles['image']:''?></span>
						            <div class="file-loading form-group mb-4">				            	
						                <input id="file-2" type="file" class="file" data-show-upload="false" data-theme="fas" accept="image/*" name="artcover" value="<?=(isset($_GET['edit']))? $singles['image']:''?>">
						            </div>		                    		
		                    	</div>
		                    	<div class="col-md-8">
									<div class="form-group mb-4">
										<label for="email">Title</label>
										<input id="email" class="form-control" name="title" type="text" placeholder="Title" value="<?=(isset($_GET['edit']))? $singles['title']:''?>">
									</div>
									<?php if($acct_type == 'Paid Account'){?>
									<div class="form-group mb-4">
										<label for="password">Price</label>
										<input id="password" class="form-control" name="price" type="text" placeholder="Price e.g &#8358;100" value="<?=(isset($_GET['edit']))? $singles['price']:''?>">
									</div>
									<?php } ?>	
									<div class="form-group mb-4">
										<label for="email">Song By</label>
										<input id="email" class="form-control" name="songby" type="text" placeholder="Enter song by e.g Crossmusic records" value="<?=(isset($_GET['edit']))? $singles['song_by']:''?>">
									</div>																				
									<div class="form-group mb-4">
										<label for="email">Duration</label>
										<input id="email" class="form-control" name="duration" type="text" placeholder="Duration e.g 02:45" value="<?=(isset($_GET['edit']))? $singles['duration']:''?>">
									</div>
									<?php if($acct_type == 'Paid Account'){?>
									<div class="row">					                  	
									  <div class="form-group col-md-12">
									  	<label for="email">Single Description</label>
									  	<span class="small">Your first journey in telling the World about your single</span>
									    <textarea id="myTextarea" class="form-control myTextarea" rows="3" name="description">
									    <?=(isset($_GET['edit']))? $singles['description']:''?>
									    </textarea> 
									  </div>                                                        
									</div>	
									<div class="row">					                  	
									  <div class="form-group col-md-12">
									  	<label for="email">Single Lyrics</label>
									  	<span class="small">show the world your amazing single lytics</span>
									    <textarea id="myTextarea" class="form-control myTextarea" rows="3" name="lyrics">
									    <?=(isset($_GET['edit']))? $singles['lyrics']:''?>
									    </textarea> 
									  </div>                                                        
									</div>	
									<?php } ?>							
									<div class="form-group mb-4">
										<label for="email">Track</label>
										<span class="small text-muted" style="font-style: italic;font-weight: bold;"><?=(isset($_GET['edit']))? $singles['long_url']:''?></span>
				                        <div class="file-loading">                          
				                          <input class="file" name="track" id="file-1" type="file" data-show-upload="false" data-theme="fas" data-show-preview="false" accept="audio/*" onchange="uploadFile()" value="<?=(isset($_GET['edit']))? $singles['track']:''?>">
				                          <!-- <label tabindex="0" for="my-audio" class="input-audio-trigger" style="margin-bottom: 0px;">Select Audio...</label>                     -->
				                        </div>
				                        <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
				                        <h3 id="status"></h3>
				                        <p id="loaded_n_total"></p>
				                        <br>                       
		                        	<p class="audio-return"></p>  
									</div>	
									<button class="btn custom-btn btn-block" type="submit" name="<?=(isset($_GET['edit']))?'edit':'add'?>"><?=(isset($_GET['edit']))?'Edit':'Add'?> Single</button>	                    		
		                    	</div>
		                    </div>						
							
						</form>
					</div>

					<div class="u-login-form text-muted py-3 mt-auto">
						<!-- <small><i class="far fa-question-circle mr-1"></i> If you are not able to make request, please <a href="#" style="color: #333;">contact us</a>.</small> -->
					</div>
				</div>
			</div>
		</main>
	</div>
</div>

<script>
	// progress bar script
	function _(el) {
	  return document.getElementById(el);
	}

	function uploadFile() {
	  var file = _("file-1").files[0];
	  // alert(file.name+" | "+file.size+" | "+file.type);
	  var formdata = new FormData();
	  formdata.append("file-1", file);
	  var ajax = new XMLHttpRequest();
	  ajax.upload.addEventListener("progress", progressHandler, false);
	  ajax.addEventListener("load", completeHandler, false);
	  ajax.addEventListener("error", errorHandler, false);
	  ajax.addEventListener("abort", abortHandler, false);
	  ajax.open("POST", ""); 
	  ajax.send(formdata);
	}

	function progressHandler(event) {
	  // _("loaded_n_total").innerHTML = "   Uploaded " + event.loaded + " bytes of " + event.total;
	  var percent = (event.loaded / event.total) * 100;
	  _("progressBar").value = Math.round(percent);
	  _("status").innerHTML = Math.round(percent) + "% Complete...";
	}

	function completeHandler(event) {
	  // _("status").innerHTML = event.target.responseText;
	  _("progressBar").value = 100; //wil clear progress bar after successful upload
	}

	function errorHandler(event) {
	  _("status").innerHTML = "Upload Failed";
	}

	function abortHandler(event) {
	  _("status").innerHTML = "Upload Aborted";
	}  
</script>

<?php
  include str_replace("\\","/",dirname(__FILE__).'/assets/include/foot.php');
?>