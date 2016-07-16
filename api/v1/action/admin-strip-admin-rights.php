<?php

// INFO FOR API
/* --[api_info]--
{
  "headline": "Admin Strip Adminrights",
  "url": "GET: http://priph.com/api/v1/?action=admin-strip-admin-rights&user=[user]",
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
    return user_adminrights($user, false);
  }else{
    error('Not logged in!');
  }
}
