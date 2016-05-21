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

  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="css/font-awesome.min.css">

  <!-- PRIPH JS API -->
  <!-- <script type="text/javascript" src="http://priph.com/api/v1/js/script.min.js"></script> -->
  <script type="text/javascript" src="api/v1/js/script.local.js"></script>

  <!-- JQUERY -->
  <script src="js/jquery-1.12.3.min.js"></script>

  <!-- SHARE JS -->
  <script type="text/javascript" src="js/share.js"></script>

  <!-- SESSION FOR API -->
  <?php echoSessionScript(); echo "\n"; ?>

  <!-- PRIVATE IMAGE SOURCE -->
  <?php
  // IF USERS OWN IMAGE
  if(isset($_GET['privateImage'])){
    echo "<script type=\"text/javascript\">var privateImage = '".$_GET['privateImage']."';</script>\n";
  }else{
    echo "<script type=\"text/javascript\">var privateImage = false;</script>\n";
  }
  ?>

  <!-- PUBLIC IMAGE SOURCE -->
  <?php
  // IF SHARE LINK
  if(isset($_GET['image']) && isset($_GET['verifier'])){
    echo "<script type=\"text/javascript\">\n    var imageid = '".$_GET['image']."';\n    var verifier = '".$_GET['verifier']."';\n  </script>\n\n";
  }else{
    echo "<script type=\"text/javascript\">var imageid = false;</script>\n\n";
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
  <div class="error">
    <i class="fa fa-frown-o" aria-hidden="true"></i>
    <p>Image not Found!</p>
  </div>
</body>
</html>
