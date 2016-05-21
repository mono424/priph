<?php

function run_action(){

  // LOGGED IN ??
  if(attemptAuth()){
    $user = getUserFromCookie();
  }else{
    $user = false;
  }

  // GET PARAMETER
  if(isset($_GET['shareid'])){$shareid = $_GET['shareid'];}else{error("\"shareid\" is not set!");}
  if(isset($_GET['verifier'])){$verifier = $_GET['verifier'];}else{error("\"verifier\" is not set!");}


  // GENERATE LINK
  return getPictureShareInfo($user, $shareid, $verifier);
}
