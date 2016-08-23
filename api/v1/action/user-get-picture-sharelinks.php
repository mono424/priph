<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Get created Sharelinks for Picture",
  "url": "GET: http://priph.com/api/v1/?action=user-get-picture-sharelinks&picture_id=[picture_id]",
  "success": "{\"response\":[{\"id\":\"22\",\"picture_id\":\"183\",\"verifier\":\"8ANew6f5\",\"restrict_to_user_id\":\"0\",\"comments_enabled\":\"1\",\"single_time_link\":\"0\",\"views\":\"5\",\"created\":\"2016-08-24 00:22:56\"},...],\"error\":false}",
  "unsuccess": null,
  "note": [
    "<b>NOTE:</b> Verifier value can be much longer than in the example!"
  ]
}
   --[api_info]-- */


function run_action(){
  if(attemptAuth(false, false)){
    // GET PARAM
    if(isset($_GET['picture_id'])){$id = $_GET['picture_id'];}else{error("\"picture_id\" is not set!");}

    // GET USER
    $user = getUserFromCookie();

    // RETURN COMMENTS
    return getPictureSharelinks($id,$user);
  }else{
    error('Not logged in!');
  }
}
