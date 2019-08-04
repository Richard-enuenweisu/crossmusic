<!doctype html>
<html lang="en" class="no-js">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crossmusic</title>
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