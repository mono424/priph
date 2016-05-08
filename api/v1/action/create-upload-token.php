<?php

function run_action(){

  // LOGGED IN ??
  if(!attemptAuth()){error('Not logged in!');}

  // GET USER
  $user = getUserFromCookie();

  // CREATE AND RETURN TOKEN
  return createUploadToken($user);

}


 ?>
