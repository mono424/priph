<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Get User Uploaded Pictures",
  "url": "GET: http://priph.com/api/v1/?action=user-get-pictures",
  "success": "{\"response\":[{\"id\":\"129\",\"name\":\"runnin_unicorn.jpg\"},{\"id\":\"837\",\"name\":\"big_globe.jpg\"}],\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */


function run_action(){
  if(attemptAuth()){
    return getUserPictures(getUserFromCookie());
  }else{
    error('Not logged in!');
  }
}
