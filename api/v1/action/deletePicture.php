<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Delete User Uploaded Picture",
  "url": "GET: http://priph.com/api/v1/?action=deletePicture&id=[picture_id]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */
 ?>

<?php

function run_action(){
  if(attemptAuth()){
    // GET PARAM
    if(isset($_GET['id'])){$id = $_GET['id'];}else{error("\"id\" is not set!");}

    // GET USER
    $user = getUserFromCookie();
    if(!$user){error('Not logged in!');}

    // CHECK ID
    if(!is_numeric($id)){error("\"id\" is illigal!");}

    // DELETE PICTURE
    deletePicture($user, $id);

    // RETURN TRUE
    return true;
  }else{
    error('Not logged in!');
  }
}

 ?>
