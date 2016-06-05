<?php

function run_action(){

  // LOGGED IN ??
  if(!attemptAuth()){error('Not logged in!');}

  // GET PARAMETER
  if(isset($_GET['picture'])){$picture = $_GET['picture'];}else{error("\"picture\" is not set!");}

  // GET OPTIONAL PARAMS
  $userRestrictionID = (isset($_GET['to-user'])) ? $_GET['to-user'] : false;
  $commentsEnabled = (isset($_GET['comments'])) ? $_GET['comments'] : true;
  $singleTimeLink = (isset($_GET['single-time-link'])) ? $_GET['single-time-link'] : false;

  // GET USER
  $user = getUserFromCookie();

  // GENERATE LINK
  return generatePictureShareLink($user, $picture, $userRestrictionID, $commentsEnabled, $singleTimeLink);
}

 ?>
