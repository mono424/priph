<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Change User Password",
  "url": "GET: http://priph.com/api/v1/?action=user-change-password&pass=[password]&new_pass=[new-password]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */


function run_action(){

  // LOGGED IN ??
  if(!attemptAuth()){error('Not logged in!');}

  // GET PARAMETER
  if(isset($_GET['pass'])){$pass = $_GET['pass'];}else{error("\"pass\" is not set!");}
  if(isset($_GET['new_pass'])){$pass_new = $_GET['new_pass'];}else{error("\"new_pass\" is not set!");}

  // CHECK IF NEW DISPLAYNAME VALID
  if(!validPassword($pass_new)){error('Password not valid! min. 3, max. 64 and no special chars.');}

  // GET USER
  $user = getUserFromCookie();

  // CHANGE PASSWORD
  userChangePassword($user, $pass, $pass_new);

  // RETURN
  return true;

}
