<?php
/*
      PRIPH API 1.0.0.0
      BY KHADIM FALL
*/

/* NO ERRORS */
error_reporting(0);

/* SESSIONS :) */
session_start();

/* SECURITY - ANTI IFRAME */
header('X-Frame-Options: SAMEORIGIN');

/* LOAD FUNCTIONS AND CONFIG */
require 'config.php';
require 'functions.php';

/* SECURITY - priph.com restriction */
if(!isset($_GET['sessionid']) || $_GET['sessionid'] !== $_SESSION['sessionid']){error("Sorry, the API is not Public atm!");}

/* START GETTING PARAMS */
if(isset($_GET['action'])){$action = $_GET['action'];}else{error("\"action\" is not set!");}

/* SECURITY */
if(!preg_match("/^[A-z0-9_-]{3,}$/",$action)){error("\"action\" includes illigal and/or under 3 chars!");}

/* CHECK ACTION WHICH USER WANTS EXISTS AND REQUIRE IT */
$file = "action/".$action.".php";
if(file_exists($file)){
  require_once($file);
  response(run_action());
}else{error("\"action\" is not valid!");}

?>
