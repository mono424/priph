<?php

function run_action(){
  if(attemptAuth(false,true)){
    return getUserInformation(getUserFromCookie());
  }else{
    error('Not logged in!');
  }
}

 ?>
