<!doctype html>
<html lang="en" class="no-js">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crossmusic: Sell & Promote Your Music | Earn Money From Gospel Music</title>

  <meta name="keywords" content="CR Music, crossmusic, to buy music, buy music online, music to buy, buy songs, buy albums, buy mp3s, buy songs, buy music, free music, paid music, discover music, new music, purchase music, purchase songs, purchase albums, online music store, affiliate, gospel affiliates, pay gospel affiliates, earn money from gospel music, crossmusic affiliates, gospel affiliate marketer, get paid for gospel music sales">
  <meta name="description" content="Go head over heels with your next favorite song or artist. crossmusic has over +2000 tracks for you to browse, download, listen and buy.">
  <meta name="author" content="mycrossmusic.com">
  <!-- Favicon -->
  <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
  <!-- Apple tags -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="format-detection" content="telephone=no">
<!--   <meta name= "viewport" content = "width = 320, initial-scale = 2.3, user-scalable = no">
  <meta name= "viewport" content = "width = device-width">
  <meta name = "viewport" content = "initial-scale = 1.0">
  <meta name = "viewport" content = "initial-scale = 2.3, user-scalable = no"> -->
  <link rel="apple-touch-icon" href="images/logo.png" />
  <link rel="apple-touch-icon" sizes="72x72" href="images/logo.png" />
  <link rel="apple-touch-icon" sizes="114x114" href="images/logo.png" />
  <link rel="apple-touch-startup-image" href="/images/logo.png">
  <link rel="apple-touch-icon" type="image/png" href="/images/logo.png" />
  <!-- Apple tags ends here -->
  <link rel="stylesheet" type="text/css" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="bootstrap-4.3.1-dist/dist/bsnav.css">
  <link href="https://fonts.googleapis.com/css?family=PT+Sans|Open+Sans|Josefin+Sans|Signika:700" rel="stylesheet">
  <!-- <link rel="stylesheet" href="themify-icons/demo-files/demo.css"> -->
  <link rel="stylesheet" type="text/css" href="bootstrap-4.3.1-dist/css/pisocials.css">
  <link rel="stylesheet" href="themify-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="bootstrap-4.3.1-dist/css/custom.css">
  <script type="text/javascript" src="bootstrap-4.3.1-dist/js/jquery-3.2.1.js"></script>
  <!-- jsSocial  -->
  <link rel="stylesheet" type="text/css" href="jsSocial/jssocials.css" />
  <link rel="stylesheet" type="text/css" href="jsSocial/jssocials-theme-flat.css" />  
  <link rel="stylesheet" href="music-player/progress-bar.css">
  <!--[if lt IE 8]><!-->
  <!-- <link rel="stylesheet" href="themify-icons/ie7/ie7.css"> -->
  </head>
  <body>

<?php
if (isset($_GET['aff'])) {
  # code...
    $aff_id = $_GET['aff'];
    setcookie("affiliate[aff_id]", htmlentities($aff_id), time()+7200);  /* expire in 2 hour */
}
?>