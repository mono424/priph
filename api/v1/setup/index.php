<?php

require '../config.php';

$link = openCON();
if(!$link){die('Connection ERROR!');}

$db_selected = mysqli_select_db($link, $config['db']['db']);
if (!$db_selected) {
  // START SETUP
  if(file_exists('setup.sql')){
    $link->query('CREATE DATABASE IF NOT EXISTS '.$config['db']['db'].';');
    if($link->error){die($link->error);}
    if(!mysqli_select_db($link, $config['db']['db'])){die('Cant create Database!');}
    $link->multi_query(file_get_contents('setup.sql'));
    if($link->error){die($link->error);}
    echo "Finished!";
  }else{
    die('setup.sql not found!');
  }
}else{
  die('DB Exists!');
}

 ?>
