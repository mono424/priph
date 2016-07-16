<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Register new User",
  "url": "GET: http://priph.com/api/v1/?action=register&user=[email]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": ["<b>NOTE:</b> User has to verfiy Account before logging in to it!"]
}
   --[api_info]-- */
 ?>

<?php

function run_action(){
    // DISABLED
    //error('Registrations disabled atm!');

    // GET PARAMETER
    if(isset($_GET['user'])){$user = $_GET['user'];}else{error("\"user\" is not set!");}

    // DO SECURITY
    if(!preg_match("/^.*\@.*\..*$/",$user)){error("\"user\" is not a valid email!");}
    if(strlen($user)>64){error("\"user\" has more than 64 chars!");}

    // USER EXIST ?
    if(user_exist($user)){error('User does already exist!');}

    $emailverify = registerUser($user);
    return true;
}

 ?>
