<?php

function run_action(){

  // LOGGED IN ??
  if(attemptAuth()){
    $user = getUserFromCookie();
  }else{
    $user = false;
  }

  // GET PARAMETER
  if(isset($_GET['pictureid'])){$pictureid = $_GET['pictureid'];}else{error("\"pictureid\" is not set!");}
  if(isset($_GET['token'])){$token = $_GET['token'];}else{error("\"token\" is not set!");}


  // RETURN RESULT
  return updatePictureCommentToken($pictureid, $token);
}
