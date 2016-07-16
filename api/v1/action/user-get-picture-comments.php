<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Generate Share Information",
  "url": "GET: http://priph.com/api/v1/?action=user-get-picture-comments&id=[picture_id]",
  "success": "{\"response\":[{\"user_id\":\"22\",\"text\":\"test\",\"displayname\":\"Hannibal\",\"comment_id\":\"60\"},{\"user_id\":\"22\",\"text\":\"blah\",\"displayname\":\"Hannibal\",\"comment_id\":\"61\"}],\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */


function run_action(){
  if(attemptAuth(false, false)){
    // GET PARAM
    if(isset($_GET['id'])){$id = $_GET['id'];}else{die('');/* TODO: MAYBE DISPALY ERROR IMAGE*/}

    // GET USER
    $user = getUserFromCookie();

    // RETURN COMMENTS
    return getPictureComments($_GET['id'],$user);
  }else{
    die(''); // TODO: MAYBE DISPALY NOT LOGGED IN IMAGE
  }
}
