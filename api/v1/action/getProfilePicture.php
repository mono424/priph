<?php

function run_action(){
    // GET OPTIONAL PARAMS
    $user = (isset($_GET['user'])) ? $_GET['user'] : getUserFromCookie();;
    $width = (isset($_GET['width'])) ? $_GET['width'] : 0;
    $height = (isset($_GET['height'])) ? $_GET['height'] : 0;

    // SECURITY
    $crop = false;
    if(is_numeric($width) && is_numeric($height)){
      if($width > 0 && $width < 10000 && $height > 0 && $height < 10000){$crop=true;}
    }

    // GET THE PICTURE PATH
    $path = getUserProfilePicture($user);
    if(!$path){$path = "../../images/profil/no-img.jpg";}

    // LOAD IMAGE AND MAYBE CROP?
    if($crop){$image=easyImageCrop($path,false,$width,$height);}else{$image=imagecreatefromjpeg($path);}

    // DISPLAY THE IMAGE
    header('Content-Type: image/jpeg');
    imagejpeg($image);
}

 ?>
