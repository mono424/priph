<?php

function run_action(){
  // PARAMS
  if(isset($_GET['user'])){$user = $_GET['user'];}else{error("\"user\" is not set!");}
  if(isset($_GET['verification'])){$verification = $_GET['verification'];}else{error("\"verification\" is not set!");}
  if(isset($_GET['pass'])){$pass = $_GET['pass'];}else{error("\"pass\" is not set!");}
  if(isset($_GET['displayname'])){$displayname = $_GET['displayname'];}else{error("\"displayname\" is not set!");}

  // OPTIONAL PARAMS
  if(isset($_GET['pass2']) && $pass !== $_GET['pass2']){error('Passwords dont match!');}

  // NOW DO VERIFICATION
  return verifyUser($user, $verification, $pass, $displayname);
}




 ?>
