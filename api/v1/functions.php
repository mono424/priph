<?php

$files = scandir('functions/');

foreach($files as $file) {
  if(ltrim($file,".") != $file || preg_match("/\.php$/", $file)!=true){continue;}
  require_once("functions/$file");
}

 ?>
