<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Verify new Users Registration",
  "url": "GET: http://priph.com/api/v1/?action=validate&user=[email]&verification=[code]&pass=[password]&displayname=[displayname]&pass2=[password_repeat_optional]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */


function run_action(){
  // PARAMS
  if(isset($_GET['user'])){$user = $_GET['user'];}else{error("\"user\" is not set!");}
  if(isset($_GET['verification'])){$verification = $_GET['verification'];}else{error("\"verification\" is not set!");}
  if(isset($_GET['pass'])){$pass = $_GET['pass'];}else{error("\"pass\" is not set!");}
  if(isset($_GET['displayname'])){$displayname = $_GET['displayname'];}else{error("\"displayname\" is not set!");}

  // OPTIONAL PARAMS
  if(isset($_GET['pass2']) && $pass !== $_GET['pass2']){error('Passwords dont match!');}

  // NOW DO VERIFICATION
  return verifyUser($user, $verification, $pass, $displayname);
}
