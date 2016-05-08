<?php

function run_action(){
  if(attemptAuth()){
    return getUserSessions(getUserFromCookie());
  }else{
    error('Not logged in!');
  }
}

 ?>
