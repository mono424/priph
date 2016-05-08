<?php

$files = scandir('functions/');
array_shift($files);array_shift($files); // CUZ OF ".." and "."
foreach($files as $file) {
  if(preg_match("/\.php$/", $file)){require_once("functions/$file");}
}

 ?>
