<?php

function run_action(){
  // PARAMS
  if(isset($_GET['host'])){$host = $_GET['host'];}else{error("\"host\" is not set!");}

  // OPTIONAL PARAMS
  $allow_user_registration = (isset($_GET['allow_user_registration'])) ? $_GET['allow_user_registration'] : 0;
  $allow_key_registration = (isset($_GET['allow_key_registration'])) ? $_GET['allow_key_registration'] : 0;

  //SECURITY
  if(!preg_match("/^[01]$/",$allow_user_registration)){error("\"allow_user_registration\" is not 0 or 1!");}
  if(!preg_match("/^[01]$/",$allow_key_registration)){error("\"allow_key_registration\" is not 0 or 1!");}

  // REGISTER IT :P
  $res = addAPIKey($host, $allow_user_registration, $allow_key_registration);
  if($res){
    return $res;
  }

  return false;
}

 ?>
