<?php

require '../v1/config.php';
require '../v1/functions/random.php';
require '../v1/functions/member.php';

if($config_found){die("already setup! You can manually change settings in your 'api/config.v1.json' ;)");}

// TEMP CONFIG OVERWRITE
$config['server'] = array_replace ($config['server'], $_POST['server']);
$config['db'] = array_replace ($config['db'], $_POST['db']);
$config['mail'] = array_replace($config['mail'], $_POST['mail']);

$link = openCON();
if(!$link){die('Database Connection ERROR!');}

// SETUP DATABASE
if(file_exists('setup.sql')){
  $link->query('CREATE DATABASE IF NOT EXISTS '.$config['db']['db'].';');
  if($link->error){die($link->error);}
  if(!mysqli_select_db($link, $config['db']['db'])){die('Cant create Database!');}
  $link->multi_query(file_get_contents('setup.sql'));
  if($link->error){die($link->error);}
}else{
  die('setup.sql not found!');
}

// WAIT FOR MULTIQUERY
do {
    if($result = mysqli_store_result($link)){
        mysqli_free_result($link);
    }
} while(mysqli_next_result($link));

if(mysqli_error($link)) {
    die(mysqli_error($link));
}


// REOPEN CONNECTION
// mysqli_close($link);
// $link = openDB();

// CREATE ADMIN USER
$table = $config['db']['tables']['member'];
$user = $link->real_escape_string($_POST['email']);
$pass = $link->real_escape_string($_POST['pass']);
$salt = randomSalt();
$hashedPassword = hashPassword($pass, $salt);
$link->query("INSERT INTO `$table` (`email`,`password`,`salt`,`displayname`,`email_verification`,`admin`,`blocked`) VALUES ('$user','$hashedPassword','$salt','Admin','',1,0)");
if($link->error){die($link->error);}

// SAVE CONFIG
configSave();

// SUCCESS
echo "1";
?>
