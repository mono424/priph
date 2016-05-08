<?php

require '../config.php';

$link = openCON();
if(!$link){die('Connection ERROR!');}

$db_selected = mysqli_select_db('foo', $link);
if (!$db_selected) {
  // START SETUP
  if(file_exists('setup.sql')){
    $link->query('CREATE DATABASE IF NOT EXISTS '+$config['db']['db']+';')
    if(mysqli_select_db('foo', $link)){die('Cant create Database!');}
    $link->query(file_get_contents('setup.sql'));
    echo "Finished!";
  }else{
    die('setup.sql not found!');
  }
}else{
  die('DB Exists!');
}

 ?>
