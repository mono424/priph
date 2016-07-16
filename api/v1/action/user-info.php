<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Get User Info",
  "url": "GET: http://priph.com/api/v1/?action=user-info",
  "success": "{\"response\":{\"id\":\"98\",\"email\":\"jon@do.com\",\"displayname\":\"Jon\",\"is_admin\":\"0\"},\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */




function run_action(){
  if(attemptAuth(false)){
    return getUserInformation(getUserFromCookie());
  }else{
    error('Not logged in!');
  }
}
