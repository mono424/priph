<?php

// INFO FOR API
/* --[api_info]--
{
  "headline": "Admin Unlock User",
  "url": "GET: http://priph.com/api/v1/?action=admin-unlock-user&user=[user]",
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

    // UNLOCK USER
    return user_lock($user, false);
  }else{
    error('Not logged in!');
  }
}
