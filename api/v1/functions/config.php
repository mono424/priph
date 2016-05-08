<?php

function configExists(){
  return file_exists('config.json');
}

function loadConfig(){
  global $config;
  if(!configExists()){return false;}

  $string = file_get_contents('config.json');
  $cnfg = json_decode($string);
  if($cnfg){$config = $cnfg; return true;}else{return false;}
}

function writeConfig(){
  global $config;
  $string = json_encode($config);
  file_put_contents('config.json', $string);
}

 ?>
