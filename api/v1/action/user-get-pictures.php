<?php

function run_action(){
  if(attemptAuth()){
    return getUserPictures(getUserFromCookie());
  }else{
    error('Not logged in!');
  }
}

 ?>
