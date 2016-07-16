<?php
session_start();

/* SECURITY - priph.com restriction */
if(!isset($_GET['sessionid']) || $_GET['sessionid'] !== $_SESSION['sessionid']){die("0");}
/* SECURITY - params */
if(!isset($_GET['skin']) || !isset($_GET['skin_type'])){die("1");}

/* SET SKIN AS COOKIE */
setcookie('skin', $_GET['skin'], 2147483647, "/");
setcookie('skin_type', $_GET['skin_type'], 2147483647, "/");

 ?>
