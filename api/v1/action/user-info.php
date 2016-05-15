<?php

function run_action(){
  if(attemptAuth(false)){
    return getUserInformation(getUserFromCookie());
  }else{
    error('Not logged in!');
  }
}

 ?>
