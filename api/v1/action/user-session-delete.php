<?php

function run_action(){
  if(attemptAuth()){
    // GET PARAM
    if(isset($_GET['session'])){$session = $_GET['session'];}else{error("\"session\" is not set!");}

    // GET USER
    $user = getUserFromCookie();
    if(!$user){error('Not logged in!');}

    // DELETE PICTURE
    deleteSession($session, $user);

    // RETURN TRUE
    return true;
  }else{
    error('Not logged in!');
  }
}

 ?>
