<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Get User Sessions",
  "url": "GET: http://priph.com/api/v1/?action=user-get-sessions",
  "success": "{\"response\":[{\"session\":\"f56g3Do\",\"token\":\"x4y7z\",\"browser\":\"Chrome\",\"ip\":\"123.123.123.11\",\"last_update\":\"2016-04-28 23:52:48\"},{\"session\":\"x09s9j2d\",\"token\":false,\"browser\":\"Chrome\",\"ip\":\"133.153.133.11\",\"last_update\":\"2016-04-28 22:07:32\"}],\"error\":false}",
  "unsuccess": null,
  "note": [
    "<b>NOTE:</b> You will only receive the Token of your current Session!",
    "<b>NOTE:</b> Session and Token Values can be much longer than in the example!"
  ]
}
   --[api_info]-- */
   


function run_action(){
  if(attemptAuth()){
    return getUserSessions(getUserFromCookie());
  }else{
    error('Not logged in!');
  }
}
