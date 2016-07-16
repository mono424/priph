<?php

// INFO FOR API
/* --[api_info]--
{
  "headline": "Short Link",
  "url": "GET: http://priph.com/api/v1/?action=short-link&link=[link]",
  "success": "{\"response\":\"https:\/\/goo.gl\/XXXXX\",\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */





function run_action(){

  // LOGGED IN ??
  if(attemptAuth()){

    // GET PARAMETER
    if(isset($_GET['link'])){$link = $_GET['link'];}else{error("\"link\" is not set!");}

    // GENERATE SHORT-LINK
    return shortn_link($link);

  }else{
    error('Not logged in!');
  }

}
