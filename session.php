<?php

session_start();
if(!isset($_SESSION['sessionid'])){
  $sessionid = md5(mt_rand(0,999999999));
  $_SESSION['sessionid'] = $sessionid;
}else{
  $sessionid = $_SESSION['sessionid'];
}

function echoSessionScript(){
  global $sessionid;
  echo "<script type=\"text/javascript\">var sessionid = '".$sessionid."';</script>";
}
 ?>
