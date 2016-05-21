<?php

function run_action(){
    // GET PARAM
    if(isset($_GET['id'])){$id = $_GET['id'];}else{die('');/* TODO: MAYBE DISPALY ERROR IMAGE*/}
    if(isset($_GET['token'])){$token = $_GET['token'];}else{die('');/* TODO: MAYBE DISPALY ERROR IMAGE*/}

    // GET OPTIONAL PARAMS
    $width = (isset($_GET['width'])) ? $_GET['width'] : 0;
    $height = (isset($_GET['height'])) ? $_GET['height'] : 0;

    // SECURITY
    $crop = false;
    if(is_numeric($width) && is_numeric($height)){
      if($width > 0 && $width < 10000 && $height > 0 && $height < 10000){$crop=true;}
    }

    // GET THE PICTURE PATH
    $path = getPublicPicturePath($id, $token);
    if(!$path){die('');/* TODO: MAYBE DISPALY ERROR IMAGE*/}

    // LOAD IMAGE AND MAYBE CROP?
    if($crop){$image=easyImageCrop($path,false,$width,$height);}else{$image=imagecreatefromjpeg($path);}

    // DISPLAY THE IMAGE
    header('Content-Type: image/jpeg');
    imagejpeg($image);
}

?>
