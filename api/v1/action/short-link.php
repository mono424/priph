<?php

function run_action(){

  // LOGGED IN ??
  if(attemptAuth()){

    // GET PARAMETER
    if(isset($_GET['link'])){$link = $_GET['link'];}else{error("\"link\" is not set!");}

    // GENERATE SHORT-LINK
    return shortn_link($link);

  }else{
    error('Not logged in!');
  }

}

 ?>
