<?php

// INFO FOR API
/* --[api_info]--
{
  "headline": "Add Picture Comment",
  "url": "GET: http://priph.com/api/v1/?action=addPictureComment&pictureid=[picture_id]&comment=[comment]&token=[token_optional]",
  "success": "{\"response\":{\"comment_id\":63,\"user_id\":\"22\"},\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */

function run_action(){

  // LOGGED IN ??
  if(attemptAuth()){
    $user = getUserFromCookie();
  }else{
    error('Not logged in!');
  }

  // GET PARAMETER
  if(isset($_GET['pictureid'])){$pictureid = $_GET['pictureid'];}else{error("\"pictureid\" is not set!");}
  if(isset($_GET['comment'])){$comment = $_GET['comment'];}else{error("\"comment\" is not set!");}

  // OPTIONAL PARAMETERS
  $token = (isset($_GET['token'])) ? $_GET['token'] : false;


  // GENERATE LINK
  return addPictureComment($user, $pictureid, $token, $comment);
}
