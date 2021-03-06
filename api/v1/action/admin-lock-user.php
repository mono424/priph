<?php

// INFO FOR API
/* --[api_info]--
{
  "headline": "Admin Lock User",
  "url": "GET: http://priph.com/api/v1/?action=admin-lock-user&user=[user]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */

function run_action(){
  if(attemptAuth(false,false)){
    $user = getUserFromCookie();
    if(!userIsAdmin($user)){error('No access!');}

    // PARAM
    if(isset($_GET['user']) && $_GET['user'] != $user){$user = $_GET['user'];}else{error("\"user\" is not set or points to yourself!");}

    // LOCK USER
    return user_lock($user, true);
  }else{
    error('Not logged in!');
  }
}
