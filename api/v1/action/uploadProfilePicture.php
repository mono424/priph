<?php
// INFO FOR API
/* --[api_info]--
{
  "headline": "Change User Profilepicture",
  "url": [
          "GET: http://priph.com/api/v1/?action=uploadProfilePicture&token=[upload-token]",
          "POST: file=[jpg-image]"
  ],
  "success": "{\"response\":true,\"error\":false}",
  "unsuccess": null,
  "note": ["<b>NOTE:</b> You will need to create a upload-token first!"]
}
   --[api_info]-- */

function run_action(){
  // GLOBAL CONFIG STUFF
  global $config;
  $max_size = $config['upload']['max_profilpicture_size'];
  $extensions = $config['upload']['profilpicture_extensions'];
  $size = $config['upload']['profilpicture_size'];
  $path = $config['upload']['profilpicture_path'];

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

  // IMAGE TO SMALL ??
  if($width < $size['width'] || $height < $size['height']){error('"file" resolution to low!');}

  // GET OUTPUT PATH
  $randName = createRandomName($path, mime2ext($type));
  $outputname = $path.'/'.$randName;

  // CROP MOOOOVE IT IT <3
  easyImageCrop($_FILES["file"]["tmp_name"], $outputname, $size['width'], $size['height']);

  // WRITE TO DB
  updateUserProfilePicture($user, $outputname);

  // RETURN TRUE
  return true;

}
