<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Create Upload Token",
  "url": "GET: http://priph.com/api/v1/?action=create-upload-token",
  "success": "{\"response\":[upload-token],\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */
 ?>

<?php

function run_action(){

  // LOGGED IN ??
  if(!attemptAuth()){error('Not logged in!');}

  // GET USER
  $user = getUserFromCookie();

  // CREATE AND RETURN TOKEN
  return createUploadToken($user);

}


 ?>
