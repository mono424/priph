<?php

function run_action(){
  if(attemptAuth(false,false)){
    $user = getUserFromCookie();
    if(!userIsAdmin($user)){error('No access!');}

    // PARAM
    if(isset($_GET['user']) && $_GET['user'] != $user){$user = $_GET['user'];}else{error("\"user\" is not set or points to yourself!");}

    // LOCK USER
    return user_deauth($user);
  }else{
    error('Not logged in!');
  }
}

 ?>
