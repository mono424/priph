<?php

function run_action(){
  // GLOBAL CONFIG STUFF
  global $config;
  $max_size = $config['upload']['max_picture_size'];
  $extensions = $config['upload']['picture_extensions'];
  $path = $config['upload']['picture_path'];

  // GET USER
  $user = getUserFromCookie();
  if(!$user){error('Not logged in!');}

  // CHECK TOKEN
  if(!$_GET['token']){error('"\"token\" is not set!"');}

  // HAS UPLOAD TOKEN
  if(!uploadTokenExists($_GET['token'], $user)){error('token is invalid!');}

  // DELETE THE TOKEN
  deleteUploadToken($_GET['token'], $user);

  // FILE UPLOADED ?
  if(!isset($_FILES["file"])){error('"file" is missing!');}

  // CHECK MAX FILESIZE
  if ($_FILES["file"]["size"] > $max_size){error('"file" is to big!');}

  // CHECK EXTENSION
  $imageExt = pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
  if(!in_array($imageExt, $extensions)){error('"file" extension not allowed!');}

  // GET IMAGE INFO // CHECK IF IMAGE
  $info = getimagesize($_FILES["file"]["tmp_name"]);
  if(!$info){error('"file" is corrupted');}
  list($width, $height, $type, $attr) = $info;

  // CHECK MIME TYPE
  if(!in_array(mime2ext($type), $extensions)){error('"file" type not allowed!');}

  // GET OUTPUT PATH
  $randName = createRandomName($path, mime2ext($type));
  $outputname = $path.'/'.$randName;
  $publicname = preg_replace("/\..*$/","",$_FILES["file"]["name"]);

  // MOOOOVE IT IT <3
  move_uploaded_file($_FILES["file"]["tmp_name"],$outputname);

  // WRITE TO DB
  indexUploadedPicture($user, $_FILES["file"]["name"], $outputname);

  // RETURN TRUE
  return true;

}

?>
