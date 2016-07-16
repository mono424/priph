<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Login User",
  "url": "GET: http://priph.com/api/v1/?action=login&user=[user]&pass=[pass]",
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": "{\"response\":false,\"error\":false}",
  "note": []
}
   --[api_info]-- */
 ?>

<?php

function run_action(){
  if(isset($_GET['user'])){$user = $_GET['user'];}else{error("\"user\" is not set!");}
  if(isset($_GET['pass'])){$pass = $_GET['pass'];}else{error("\"pass\" is not set!");}

  if(login($user, $pass)){
    return true;
  }

  return false;
}




 ?>
