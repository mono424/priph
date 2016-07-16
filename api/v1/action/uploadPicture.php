<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Upload Picture",
  "url": [
          "GET: http://priph.com/api/v1/?action=uploadPicture&token=[upload-token]",
          "POST: file=[jpg-image]"
  ],
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */


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


  // IF BLOB OR IMAGE IS UPLOADED
  if (isset($_POST["file"])) {

    // PARSE INFO
    $info = explode(',', $_POST["file"], 2);
    if(count($info) < 2){error('Data is corrupted!');}
    $infostuff = $info[0];
    $encoded = $info[1];

    // CHECK SIZE
    $size = (strlen($encoded) * 3) / 4 - $encoded.count('=', -2);
    if ($size > $max_size){error('"file" is to big!');}

    // GET EXTENSION
    if(preg_match("/data\:image\/(.*?)\;/",$infostuff,$match)){
      $type=$match[1];
    }else{error('Data is corrupted!');}

    // CHECK MIME TYPE
    if(!in_array($type, $extensions)){error('"file" type not allowed!');}

    // DECODE FILE
    $decoded = base64_decode($encoded);

    // CONVERT TO IMAGE
    $image = imagecreatefromstring($decoded);
    if(false === $image){error('Image is corrupted!');}


    // GET OUTPUT PATH
    $randName = createRandomName($path, mime2ext($type));
    $outputname = $path.'/'.$randName;
    $publicname = preg_replace("/\..*$/","",$_FILES["file"]["name"]);

    // WRITE FILE <3
    imagejpeg($image, $outputname, 100);

    // WRITE TO DB
    indexUploadedPicture($user, "WEBCAM-IMAGE", $outputname);

  }elseif(isset($_FILES["file"])){

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

  }else{error('"file" is missing!');}

  // RETURN TRUE
  return true;

}
