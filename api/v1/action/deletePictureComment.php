<?php

function run_action(){
  if(attemptAuth()){
    // GET PARAM
    if(isset($_GET['id'])){$id = $_GET['id'];}else{error("\"id\" is not set!");}

    // GET USER
    $user = getUserFromCookie();
    if(!$user){error('Not logged in!');}

    // CHECK ID
    if(!is_numeric($id)){error("\"id\" is illigal!");}

    // DELETE PICTURE
    deletePictureComment($user, $id);

    // RETURN TRUE
    return true;
  }else{
    error('Not logged in!');
  }
}

 ?>
