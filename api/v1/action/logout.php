<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Logout User",
  "url": "GET: http://priph.com/api/v1/?logout",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */
?>

<?php

function run_action(){
  killCurrentSession();
  killUserCookie();
  return true;
}

 ?>
