<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Delete a Picture Sharelink",
  "url": "GET: http://priph.com/api/v1/?action=user-delete-picture-sharelink&sharelink_id=[sharelink_id]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */


function run_action(){
  if(attemptAuth(false, false)){
    // GET PARAM
    if(isset($_GET['sharelink_id'])){$sharelinkid = $_GET['sharelink_id'];}else{error("\"sharelink_id\" is not set!");}

    // GET USER
    $user = getUserFromCookie();

    // RETURN COMMENTS
    return deletePictureSharelink($sharelinkid,$user);
  }else{
    error('Not logged in!');
  }
}
