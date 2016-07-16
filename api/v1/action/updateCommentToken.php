<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Update Comment Token",
  "url": "GET: http://priph.com/api/v1/?action=updateCommentToken&pictureid=[pictureid]&token=[token]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": ["Otherwise the Token expires after a specific Time(30sec)!"]
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
  return updatePictureCommentToken($pictureid, $token);
}
