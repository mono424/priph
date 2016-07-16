<?php

// INFO FOR API
/* --[api_info]--
{
  "headline": "Delete Comment Token",
  "url": "GET: http://priph.com/api/v1/?action=deleteCommentToken&pictureid=[picture_id]&token=[token]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */



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
  return deletePictureCommentToken($pictureid, $token);
}
