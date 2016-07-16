<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Change User Displayname",
  "url": "GET: http://priph.com/api/v1/?action=user-change-displayname&displayname=[new-displayname]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */


function run_action(){

  // LOGGED IN ??
  if(!attemptAuth()){error('Not logged in!');}

  // GET PARAMETER
  if(isset($_GET['displayname'])){$displayname = $_GET['displayname'];}else{error("\"displayname\" is not set!");}

  // CHECK IF NEW DISPLAYNAME VALID
  if(!validDisplayname($displayname)){error('Displayname not valid! min. 3, max. 64 and no special chars.');}

  // GET USER
  $user = getUserFromCookie();

  // CHANGE DISPLAYNAME
  userChangeDisplayName($user, $displayname);

  // RETURN
  return true;

}
