<?php

function randomSalt($len = 8) {
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
	$l = strlen($chars) - 1;
	$str = '';
	for ($i = 0; $i < $len; ++$i) {
		$str .= $chars[rand(0, $l)];
 	}
	return $str;
}

function randomPass($len = 32) {
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	$l = strlen($chars) - 1;
	$str = '';
	for ($i = 0; $i < $len; ++$i) {
		$str .= $chars[rand(0, $l)];
 	}
	return $str;
}


/* UNIQUE RANDOM GENERTATORS */


function createRandomName($outputpath, $extension){
  do{
    $randName = randomPass(32).'.'.$extension;
  }while(in_array($randName, scandir($outputpath)));
  return $randName;
}

function generateUserSession($con = false){
  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  //CREATE SESSION ID
  do{
    $session = randomPass(64);
  }while(userSessionExists($session));
  return $session;
}

function generateUploadToken($con = false){
  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  //CREATE UPLOAD TOKEN
  do{
    $token = randomPass(64);
  }while(uploadTokenExists($token));
  return $token;
}

function generateCommentToken($picture_id, $con = false){
  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  //CREATE UPLOAD TOKEN
  do{
    $token = randomPass(32);
  }while(checkPictureCommentToken($picture_id, $token, $con));
  return $token;
}


 ?>
