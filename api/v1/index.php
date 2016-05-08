<?php
/*
      PRIPH API 1.0.0.0
      BY KHADIM FALL
*/

/* NO ERRORS */
//error_reporting(0);

/* LOAD FUNCTIONS AND CONFIG */
require 'config.php';
require 'functions.php';

/* START GETTING PARAMS */
if(isset($_GET['action'])){$action = $_GET['action'];}else{error("\"action\" is not set!");}

/* SECURITY */
if(!preg_match("/^[A-z0-9_-]{3,}$/",$action)){error("\"action\" includes illigal or under 3 chars!");}

/* CHECK ACTION WHICH USER WANTS EXISTS AND REQUIRE IT */
$file = "action/".$action.".php";
if(file_exists($file)){
  require $file;
  response(run_action());
}else{error("\"action\" is not valid!");}

?>
