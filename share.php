<?php

/* API RESTRICTION SESSION */
require 'session.php';

?>

<!DOCTYPE html>
<html>
<head>
  <!-- TITLE & CHARSET -->
  <meta charset="utf-8">
  <title>Priph - </title>

  <!-- FAVICON -->
  <link rel="shortcut icon" type="image/ico" href="img/priph.ico" />

  <!-- SHARE STYLESHEET -->
  <link rel="stylesheet" href="/css/share.css">

  <!-- MOBILE ;) -->
  <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">

  <!-- PRIPH JS API -->
  <!-- <script type="text/javascript" src="http://priph.com/api/v1/js/script.min.js"></script> -->
  <script type="text/javascript" src="api/v1/js/script.local.js"></script>

  <!-- JQUERY -->
  <script src="js/jquery-1.12.3.min.js"></script>

  <!-- SHARE JS -->
  <script type="text/javascript" src="js/share.js"></script>

  <!-- SESSION FOR API -->
  <?php echoSessionScript(); ?>

  <!-- IMAGE SOURCE -->
  <?php
  // IF USERS OWN IMAGE
  if(isset($_GET['privateImage'])){
    echo "<script>var privateImage = '".$_GET['privateImage']."';</script>";
  }else{
    echo "<script>var privateImage = false;</script>";
  }
  ?>
</head>
<body>
  <!-- <div class="topbar"></div> -->
  <center><a href="/"><img class="logo" src="img/priph_full.png" alt="" /></a></center>
  <div class="wrapper">

    <!-- IMAGE CONTENT -->
    <div class="image">
      <img id="image" src="" alt="" />
    </div>

    <!-- INFO CONTENT -->
    <div class="info">
      <div class="infowrap">

        <!-- AUTHOR STUFF -->
        <div class="author cf">
          <img id="author_image" src="" alt="" />
          <div id="author_name"></div>
        </div>
        <hr>

        <!-- COMMENTBOX -->
        <div class="comment-hl">Comments</div>
        <div id="commentbox" class="commentbox">
        </div>
        <div class="comment-form">
            <input type="text" name="comment" placeholder="Write something nice..">
            <img id="user_image" src="" alt="" />
        </div>

      </div>
    </div>

  </div>
</body>
</html>
