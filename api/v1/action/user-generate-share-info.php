<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Generate Share Information",
  "url": "GET: http://priph.com/api/v1/?action=user-generate-share-info&picture=[picture_id]&to-user=[user_email_optional]&comments=[comments_enabled_default_1]$single-time-link=[single_time_link_default_1]",
  "success": "{\"response\":{\"id\":68,\"verifier\":\"MQaZOc8YYj49RwOt07SimvfPD9rpaxe5\"},\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */




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
  return generatePictureShareInfo($user, $picture, $userRestrictionID, $commentsEnabled, $singleTimeLink);
}
