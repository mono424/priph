<?php
/*
      PRIPH API 1.0.0.0
      BY KHADIM FALL
*/

/* NO ERRORS */
//error_reporting(0);

/* NO API-KEYS */
$_GET['api_key'] = "NOo0WppuSl97XfppbVVm1kEBbMdkiomh";

/* LOAD FUNCTIONS AND CONFIG */
require 'config.php';
require 'functions.php';

/* CHECK IF CONFIG SET */
if(configExists()){error("Please install Priph first!");}

/* START GETTING PARAMS */
if(isset($_GET['action'])){$action = $_GET['action'];}else{error("\"action\" is not set!");}
if(isset($_GET['api_key'])){$api_key = $_GET['api_key'];}else{error("\"api_key\" is not set!");}

/* CHECK API KEY*/
if(!checkAPIKey($api_key)){error("\"api_key\" is not valid!");}

/* SECURITY */
if(!preg_match("/^[A-z0-9_-]{3,}$/",$action)){error("\"action\" includes illigal or under 3 chars!");}

/* CHECK ACTION WHICH USER WANTS EXISTS AND REQUIRE IT */
$file = "action/".$action.".php";
if(file_exists($file)){
  require $file;
  response(run_action());
}else{error("\"action\" is not valid!");}

?>
