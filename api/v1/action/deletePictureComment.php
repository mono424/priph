<?php

// INFO FOR API
/* --[api_info]--
{
  "headline": "Delete Picture Comment",
  "url": "GET: http://priph.com/api/v1/?action=deletePictureComment&commentid=[comment_id]&token=[token]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */


function run_action(){
  if(attemptAuth()){
    // LOGGED IN ??
    if(attemptAuth()){
      $user = getUserFromCookie();
    }else{
      error('Not logged in!');
    }

    // GET PARAMETER
    if(isset($_GET['commentid'])){$commentid = $_GET['commentid'];}else{error("\"commentid\" is not set!");}

    // OPTIONAL PARAMETERS
    $token = (isset($_GET['token'])) ? $_GET['token'] : false;

    // DELETE COMMENT
    return deletePictureComment($user, $commentid, $token);
  }else{
    error('Not logged in!');
  }
}
