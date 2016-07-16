<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Delete User Session",
  "url": "GET: http://priph.com/api/v1/?action=user-session-delete&session=[session_id]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */



function run_action(){
  if(attemptAuth()){
    // GET PARAM
    if(isset($_GET['session'])){$session = $_GET['session'];}else{error("\"session\" is not set!");}

    // GET USER
    $user = getUserFromCookie();
    if(!$user){error('Not logged in!');}

    // DELETE PICTURE
    deleteSession($session, $user);

    // RETURN TRUE
    return true;
  }else{
    error('Not logged in!');
  }
}
