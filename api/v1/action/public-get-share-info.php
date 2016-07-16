<?php


// INFO FOR API
/* --[api_info]--
{
  "headline": "Public get Share Information",
  "url": "GET: http://priph.com/api/v1/?action=public-get-share-info&shareid=[share_id]&verifier=[verifier]",
  "success": "{\"response\":{\"pictureid\":\"259\",\"picture_token\":{\"id\":225,\"token\":\"G5SFGvfaKrJqRlF7dPNJmgoVi9ffToAX6LJezwFvC5BlKfZIdrD9ug2xDqiiTFNn\"},\"author\":{\"id\":\"22\",\"displayname\":\"Hannibal\"},\"single_time_link\":\"0\",\"comments_enabled\":\"1\",\"comments\":[{\"user_id\":\"22\",\"text\":\"test\",\"displayname\":\"Hannibal\",\"comment_id\":\"62\"}],\"comment_token\":{\"token\":\"7E3OjcVs5kWBvjygmlbg2owM6LqLy5ks\",\"valid\":30},\"created\":\"2016-07-15 19:43:38\"},\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */



function run_action(){

  // LOGGED IN ??
  if(attemptAuth()){
    $user = getUserFromCookie();
  }else{
    $user = false;
  }

  // GET PARAMETER
  if(isset($_GET['shareid'])){$shareid = $_GET['shareid'];}else{error("\"shareid\" is not set!");}
  if(isset($_GET['verifier'])){$verifier = $_GET['verifier'];}else{error("\"verifier\" is not set!");}


  // GENERATE LINK
  return getPictureShareInfo($user, $shareid, $verifier);
}
