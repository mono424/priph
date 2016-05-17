<?php

/* USER SECURITY */

function validPassword($password){
  return preg_match("/.{3,128}/",$password);
}

function validDisplayname($displayname){
  return preg_match("/[A-z0-9_-]{3,64}/",$displayname);
}

function user_exist($user_id){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);

  // THE QUERY
  $res = $con->query("SELECT `id` FROM $table WHERE `id`='$user_id' LIMIT 1");

  // CHECK & RETURN
  if($res && $res->num_rows > 0){return true;}else{return false;}
}

function userIsAdmin($user_id){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);

  // THE QUERY
  $res = $con->query("SELECT `id` FROM $table WHERE `id`='$user_id' AND `admin`='1' LIMIT 1");

  // CHECK & RETURN
  if(!$res || $res->num_rows > 0){return true;}else{return false;}
}

function getUserInfo($user_id){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);

  // GET INFO FOR LOGIN
  $res = $con->query("SELECT * FROM $table WHERE `id`='$user_id'");
  if(!$res){error('User not found!');} // USER DOES NOT EXIST
  $info = $res->fetch_array(MYSQLI_ASSOC);
  return $info;
}


function updateUser($user_id, $info){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);

  // CREATE QUERY
  $sets = "";
  foreach($info as $key => $value){
    $sets .= "`".$con->real_escape_string($key)."`='".$con->real_escape_string($value)."',";
  }
  $sets = substr($sets, 0, -1);
  $query = "UPDATE $table SET $sets WHERE `id`='$user_id' LIMIT 1";
  $con->query($query);

  // RETURN
  return true;
}



/* UPLOAD */

function indexUploadedPicture($user_id, $pictureName, $picturePath){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['pictures'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);
  $pictureName = $con->real_escape_string($pictureName);
  $picturePath = $con->real_escape_string($picturePath);

  // INSERT IMAGE
  $query = "INSERT INTO `$table` (`user_id`,`name`,`path`) VALUES ('$user_id','$pictureName','$picturePath')";
  $con->query($query);

  // RETURN
  return true;
}













/* FAST CHANGE USER SETTINGS */

function updateUserProfilePicture($user_id, $newProfilePictureLink){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);
  $newProfilePictureLink = $con->real_escape_string($newProfilePictureLink);

  // DELETE OLD IMAGE
  deleteUserProfilePicture($user_id, $con);

  // UPDATE IMAGE
  $query = "UPDATE $table SET `imageurl`='$newProfilePictureLink' WHERE `id`='$user_id' LIMIT 1";
  $con->query($query);

  // RETURN
  return true;
}

function deleteUserProfilePicture($user_id, $con = false){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  //SECURITY
  $user_id = $con->real_escape_string($user_id);

  // DELETE THE IMAGE
  $res = $con->query("SELECT `imageurl` FROM `$table` WHERE `id`='$user_id'");
  $info = $res->fetch_array(MYSQLI_ASSOC);
  if($info['imageurl']){unlink($info['imageurl']);}

  // UPDATE TABLE
  $res = $con->query("UPDATE `$table` SET `imageurl`=''  WHERE `id`='$user_id'");
}

function userChangeDisplayName($user_id, $displayname){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);
  $displayname = $con->real_escape_string($displayname);

  // UPDATE NAME
  $query = "UPDATE $table SET `displayname`='$displayname' WHERE `id`='$user_id' LIMIT 1";
  $con->query($query);

  // RETURN
  return true;
}

function userChangePassword($user_id, $pass, $pass_new){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);
  $pass_new = $con->real_escape_string($pass_new);

  // CHECK OLD PASS
  $res = $con->query("SELECT `password`,`salt` FROM $table WHERE `id`='$user_id'");
  $info = $res->fetch_array(MYSQLI_ASSOC);
  if(!validateLogin($pass, $info['password'], $info['salt'])){error('Wrong Password!');}

  // NEW PASSWORD HASHES
  $saltNew = randomSalt();
  $hashedPasswordNew = hashPassword($pass_new, $saltNew);

  // SECURITY
  $saltNew = $con->real_escape_string($saltNew);
  $hashedPasswordNew = $con->real_escape_string($hashedPasswordNew);

  // UPDATE PASSWORD
  $query = "UPDATE $table SET `password`='$hashedPasswordNew', `salt`='$saltNew' WHERE `user_id`='$user_id' LIMIT 1";
  $con->query($query);

  // RETURN
  return true;
}








/* SECURITY, SALT & HASH */

function validateLogin($pass, $hashed_pass, $salt, $hash_method = 'sha1') {
  return password_verify(hash($hash_method, $salt . $pass), $hashed_pass);
}

function hashPassword($pass, $salt, $hash_method = 'sha1'){
  return password_hash(hash($hash_method, $salt . $pass), PASSWORD_BCRYPT);
}






/* USER SESSION */

function userSessionExists($session, $user_id = false, $token = "", $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['session_token'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // CREATE SESSIONID
  $session = $con->real_escape_string($session);
  $user_id = $con->real_escape_string($user_id);
  $token = $con->real_escape_string($token);

  // GENERATE WHERE
  $where = "`session`='$session'";
  if($user_id){$where.=" AND `user_id`='$user_id'";}
  if($token){$where.=" AND `token`='$token'";}

  // THE QUERY
  $res = $con->query("SELECT `user_id` FROM $table WHERE $where LIMIT 1");

  // CHECK & RETURN
  if(!$res || $res->num_rows > 0){return true;}else{return false;}
}

function getUserSessions($user_id, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['session_token'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY
  $user_id = $con->real_escape_string($user_id);

  // PARSE INFORMATION
  $info = parseCookie();

  // GENERATE WHERE
  $where = "`user_id`='$user_id'";

  // THE QUERY
  $res = $con->query("SELECT `session`,`token`,`browser`,`ip`,`last_update` FROM $table WHERE $where");
  $array = [];
  if($res){
    while($arr = $res->fetch_array(MYSQLI_ASSOC)){
      if($info['session'] != $arr['session'] || $info['token'] != $arr['token']){
        $arr['token'] = false;
      }
      array_push($array, $arr);
    }
  }else{$array=false;}

  // CHECK & RETURN
  return $array;
}

function deleteSession($session, $user_id, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['session_token'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // CREATE SESSIONID
  $session = $con->real_escape_string($session);
  $user_id = $con->real_escape_string($user_id);

  // GENERATE WHERE
  $where = "`session`='$session' AND `user_id`='$user_id'";

  // THE QUERY
  $res = $con->query("DELETE FROM $table WHERE $where");

  // CHECK & RETURN
  return true;
}

function getUserFromCookie(){
  // GLOBAL STUFF
  global $config;
  $cookiename = $config['login']['cookie_name'];
  $delimiter = $config['login']['cookie_delimiter'];

  // RETURN IF COOKIE SET
  if(isset($_COOKIE[$cookiename])){
    return explode($delimiter, $_COOKIE[$cookiename], 2)[0];
  }

  // OTHERWISE RETURN FALSE
  return false;
}

function getUserInformation($user_id){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // SECURITY
  $user_id = $con->real_escape_string($user_id);

  // GET INFORMATION
  $res = $con->query("SELECT `id`,`email`,`displayname`,`admin` as 'is_admin' FROM $table WHERE `id`='$user_id'");
  if($res){$array = $res->fetch_array(MYSQLI_ASSOC);}else{$array=false;}
  return $array;
}

function getUserProfilePicture($user_id){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // SECURITY
  $user_id = $con->real_escape_string($user_id);

  // GET INFORMATION
  $res = $con->query("SELECT `imageurl` FROM $table WHERE `id`='$user_id'");
  if($res){$array = $res->fetch_array(MYSQLI_ASSOC);}else{$array=false;}
  return $array['imageurl'];
}

function getUserIdFromMail($mail, $con = false){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // OPEN CONNECTION IF NOT EXIST
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // GET ID
  $res = $con->query("SELECT `id` FROM $table WHERE `email`='$mail' LIMIT 1");
  if(!$res){return false;} // USER DOES NOT EXIST
  $info = $res->fetch_array();
  return $info['id'];
}















/* HANDLE USER PICTURES */

function getUserPictures($user_id){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['pictures'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // SECURITY
  $user_id = $con->real_escape_string($user_id);

  // GET INFORMATION
  $res = $con->query("SELECT `id`,`name` FROM $table WHERE `user_id`='$user_id'");
  $array = [];
  if($res){
    while($arr = $res->fetch_array(MYSQLI_ASSOC)){
      array_push($array, $arr);
    }
  }else{$array=false;}
  return $array;
}

function getPicturePath($user_id, $id){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['pictures'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // SECURITY
  $id = $con->real_escape_string($id);
  $user_id = $con->real_escape_string($user_id);

  // GET INFORMATION
  $res = $con->query("SELECT `path` FROM $table WHERE `id`='$id' AND `user_id`='$user_id' LIMIT 1");
  if($res){$array = $res->fetch_array(MYSQLI_ASSOC);}else{$array=false;}
  return $array['path'];
}

function deletePicture($user_id, $id){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['pictures'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // SECURITY
  $id = $con->real_escape_string($id);
  $user_id = $con->real_escape_string($user_id);

  // GET INFORMATION
  $res = $con->query("SELECT `id`,`path` FROM $table WHERE `id`='$id' AND `user_id`='$user_id' LIMIT 1");
  if($res){$array = $res->fetch_array(MYSQLI_ASSOC);}else{$array=false;}

  // DELETE IMAGE
  unlink($array['path']);

  // DELETE FROM DATABASE
  $con->query("DELETE FROM $table WHERE `id`='$id' AND `user_id`='$user_id' LIMIT 1");

  // RETURN
  return true;
}

function deleteAllPictures($user_id, $con=false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['pictures'];

  // DATABASE CONNECTION
  if(!$con){$con = openDB();}
  if($con === false){error('SQL ERROR');}

  // SECURITY
  $id = $con->real_escape_string($id);
  $user_id = $con->real_escape_string($user_id);

  // GET INFORMATION
  $res = $con->query("SELECT `path` FROM $table WHERE `user_id`='$user_id'");

  // DELETE IMAGES
  while($array = $res->fetch_array(MYSQLI_ASSOC)){
    unlink($array['path']);
  }

  // DELETE FROM DATABASE
  $con->query("DELETE FROM $table WHERE `user_id`='$user_id'");

  // RETURN
  return true;
}

/* CHECK PICTURE */

function checkImageExists($user_id, $picture_id, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['pictures'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY
  $picture_id = $con->real_escape_string($picture_id);
  $user_id = $con->real_escape_string($user_id);

  // GET INFORMATION
  $res = $con->query("SELECT `path` FROM $table WHERE `id`='$picture_id' AND `user_id`='$user_id' LIMIT 1");
  if($res && $res->num_rows > 0){$ret = true;}else{$ret=false;}
  return $ret;
}

/* SHARE PICTURE */

function generatePictureShareInfo($user_id, $picture_id, $userRestrictionID,  $commentsEnabled, $singleTimeLink, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['share'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // CHECK IMAGE
  if(!checkImageExists($user_id, $picture_id, $con)){error('Invalid Picture ID!');}

  // CHECK USER EXISTS ON PRIPH SHARE
  if($userRestrictionID){
    if(!user_exist($userRestrictionID)){error('Invalid Priph-User!');}
  }else{
    $userRestrictionID = 0;
  }

  // GENERATE VERFIER
  $verifier = randomPass(32);

  // SECURITY
  $picture_id = $con->real_escape_string($picture_id);
  $verifier = $con->real_escape_string($verifier);
  $userRestrictionID = $con->real_escape_string($userRestrictionID);
  $commentsEnabled = ($commentsEnabled) ? 1 : 0;
  $singleTimeLink = ($singleTimeLink) ? 1 : 0;


  // WRITE INFORMATION
  $con->query("INSERT INTO $table (`picture_id`,`verifier`,`restrict_to_user_id`,`comments_enabled`,`single_time_link`)
                                  VALUES ('$picture_id','$verifier','$userRestrictionID','$commentsEnabled','$singleTimeLink')");

  // RETURN
  return ['id' => $con->insert_id, 'verifier' => $verifier];
}

 ?>
