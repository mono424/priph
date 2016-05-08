<?php

function run_action(){
  if(attemptAuth(false, false)){
    // GET PARAM
    if(isset($_GET['id'])){$id = $_GET['id'];}else{die('');/* TODO: MAYBE DISPALY ERROR IMAGE*/}

    // GET OPTIONAL PARAMS
    $width = (isset($_GET['width'])) ? $_GET['width'] : 0;
    $height = (isset($_GET['height'])) ? $_GET['height'] : 0;

    // SECURITY
    $crop = false;
    if(is_numeric($width) && is_numeric($height)){
      if($width > 0 && $width < 10000 && $height > 0 && $height < 10000){$crop=true;}
    }

    // GET USER
    $user = getUserFromCookie();

    // GET THE PICTURE PATH
    $path = getPicturePath($user, $id);
    if(!$path){die('');/* TODO: MAYBE DISPALY ERROR IMAGE*/}

    // LOAD IMAGE AND MAYBE CROP?
    if($crop){$image=easyImageCrop($path,false,$width,$height);}else{$image=imagecreatefromjpeg($path);}

    // DISPLAY THE IMAGE
    header('Content-Type: image/jpeg');
    imagejpeg($image);
  }else{
    die(''); // TODO: MAYBE DISPALY NOT LOGGED IN IMAGE
  }
}

 ?>
