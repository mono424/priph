<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Attempt Login by Cookie",
  "url": "GET: http://priph.com/api/v1/?action=loginByCookie",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": "{\"response\":false,\"error\":false}",
  "note": []
}
   --[api_info]-- */
?>

<?php

function run_action(){
  return attemptAuth();
}

 ?>
