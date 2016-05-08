<?php

function run_action(){

  // LOGGED IN ??
  if(!attemptAuth()){error('Not logged in!');}

  // GET PARAMETER
  if(isset($_GET['displayname'])){$displayname = $_GET['displayname'];}else{error("\"displayname\" is not set!");}

  // CHECK IF NEW DISPLAYNAME VALID
  if(!validDisplayname($displayname)){error('Displayname not valid! min. 3, max. 64 and no special chars.');}

  // GET USER
  $user = getUserFromCookie();

  // CHANGE DISPLAYNAME
  userChangeDisplayName($user, $displayname);

  // RETURN
  return true;

}

 ?>
