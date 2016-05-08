<?php

function run_action(){
  if(isset($_GET['user'])){$user = $_GET['user'];}else{error("\"user\" is not set!");}
  if(isset($_GET['pass'])){$pass = $_GET['pass'];}else{error("\"pass\" is not set!");}

  if(login($user, $pass)){
    return true;
  }

  return false;
}




 ?>
