<?php

function run_action(){
  killCurrentSession();
  killUserCookie();
  return true;
}

 ?>
