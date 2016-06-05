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

function getPictureShareInfo($user, $shareId, $verifier, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['share'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY
  $user = $con->real_escape_string($user);
  $shareId = $con->real_escape_string($shareId);
  $verifier = $con->real_escape_string($verifier);

  // LOOK IF EXISTS AND GET SHARE INFO
  $res = $con->query("SELECT * FROM $table WHERE `id` = '$shareId' AND `verifier` = '$verifier'");

  // EXISTS ?!
  if($res && $res->num_rows > 0){$info = $res->fetch_assoc();}else{error('Not found!');}

  // CHECK ACCESS
  if(!$info['restrict_to_user_id'] == "0" && !($user && $info['restrict_to_user_id'] == $user)){
    error('Not allowed!');
  }

  // IF SINGLE TIME LINK
  if($info['single_time_link'] && $info['views'] > 0){
    error('Link expired!');
  }

  // ADD A VIEW
  $con->query("UPDATE $table SET `views`='".($info['views']+1)."' WHERE `id` = '$shareId'");

  // generateShareLink
  $pictureInfo = generatePublicPictureToken($info['picture_id'],$con);
  $authorInfo = getAuthorInfo($info['picture_id'],$con);
  $comments = [];
  $comment_token = false;
  if($info['comments_enabled']){
    $comments = getPictureComments($info['picture_id'], false, $con);
    $comment_token = generatePictureCommentToken($info['picture_id'], $con);
  }

  // DO THE OUTPUT
  $out = [];
  $out['pictureid'] = $info['picture_id'];
  $out['picture_token'] = $pictureInfo;
  $out['author'] = $authorInfo;
  $out['single_time_link'] = $info['single_time_link'];
  $out['comments_enabled'] = $info['comments_enabled'];
  $out['comments'] = $comments;
  $out['comment_token'] = $comment_token;
  $out['created'] = $info['created'];

  // todo: get info and picture and return!

  return $out;
}

function generatePublicPictureToken($picture, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['public_picture_token'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY
  $picture = $con->real_escape_string($picture);
  $token = $con->real_escape_string(randomPass(64));

  // INSERT IT
  $con->query("INSERT INTO $table (`picture_id`,`token`) VALUES ('$picture','$token')");

  // RETURN
  return ['id'=>$con->insert_id,'token'=>$token];
}

function getAuthorInfo($picture, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['pictures'];
  $table_member = $config['db']['tables']['member'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY
  $picture = $con->real_escape_string($picture);

  // GET INFO
  $res = $con->query("SELECT $table_member.`id` as `id`, $table_member.`displayname` as `displayname` FROM $table JOIN $table_member ON $table.`user_id`=$table_member.`id` WHERE $table.`id`='$picture'");
  if($res && $res->num_rows > 0){$array = $res->fetch_assoc();}else{return false;}

  // RETURN
  return $array;
}

function getPublicPicturePath($id, $token){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['pictures'];
  $token_table = $config['db']['tables']['public_picture_token'];

  // OPEN NEW DB CONNECTION
  $con = openDB();
  if($con === false){return false;}

  // SECURITY
  $id = $con->real_escape_string($id);
  $token = $con->real_escape_string($token);

  // GET PICTURE ID
  $res = $con->query("SELECT `picture_id` FROM $token_table WHERE `id`='$id' AND `token`='$token' LIMIT 1");
  if($res && $res->num_rows > 0){$picId = $res->fetch_assoc()['picture_id'];}else{return false;}

  // DELETE TOKEN
  $con->query("DELETE FROM $token_table WHERE `id`='$id' AND `token`='$token'");

  // GET INFORMATION
  $res = $con->query("SELECT `path` FROM $table WHERE `id`='$picId' LIMIT 1");
  if($res && $res->num_rows > 0){$array = $res->fetch_assoc();}else{return false;}
  return $array['path'];
}



/* COMMENT SYSTEM */

// -> TOKEN

function generatePictureCommentToken($picture_id, $con = false){
  // GLOBAL STUFF
  global $config;
  $table_token = $config['db']['tables']['comment_token'];
  $valid_time = $config['comment']['token_valid'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY & VARS
  $picture_id = $con->real_escape_string($picture_id);
  $token = $con->real_escape_string(generateCommentToken($picture_id,$con));
  $valid = time() + $valid_time;

  // CREATE TOKEN
  $con->query("INSERT INTO `$table_token` (`picture_id`,`token`,`valid`) VALUES ('$picture_id','$token','$valid')");

  // RETUR INFO
  return ['token' => $token, 'valid' => $valid_time];
}

function checkPictureCommentToken($picture_id, $token, $con = false){
  // GLOBAL STUFF
  global $config;
  $table_token = $config['db']['tables']['comment_token'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY & VARS
  $picture_id = $con->real_escape_string($picture_id);
  $token = $con->real_escape_string($token);

  // GET TOKEN VALID TIME
  $res = $con->query("SELECT `valid` FROM `$table_token` WHERE `picture_id`='$picture_id' AND `token`='$token' LIMIT 1");
  if($res && $res->num_rows > 0){$valid = $res->fetch_assoc()['valid'];}else{return false;}

  // RETURN
  if($valid >= time()){return true;}else{deletePictureCommentToken($picture_id, $token, $con); return false;}
}


function updatePictureCommentToken($picture_id, $token, $con = false){
  // GLOBAL STUFF
  global $config;
  $table_token = $config['db']['tables']['comment_token'];
  $valid_time = $config['comment']['token_valid'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // CHECK TOKEN
  if(!checkPictureCommentToken($picture_id, $token, $con)){
    return false;
  }

  // SECURITY & VARS
  $picture_id = $con->real_escape_string($picture_id);
  $token = $con->real_escape_string($token);
  $valid = time() + $valid_time;

  // UPDATE TOKEN
  $con->query("UPDATE `$table_token` SET `valid`='$valid' WHERE `picture_id`='$picture_id' AND `token`='$token'");
  if($con->error){error("SQL QUERY ERROR");}

  // RETURN INFO
  return true;
}

function deletePictureCommentToken($picture_id, $token, $con = false){
  // GLOBAL STUFF
  global $config;
  $table_token = $config['db']['tables']['comment_token'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY & VARS
  $picture_id = $con->real_escape_string($picture_id);
  $token = $con->real_escape_string($token);

  // DELETE TOKEN
  $con->query("DELETE FROM `$table_token` WHERE `picture_id`='$picture_id' AND `token`='$token'");
  if($con->error){error("SQL QUERY ERROR");}

  // RETUR INFO
  return true;
}


// -> ADD COMMENT
function addPictureComment($authorid, $picture_id, $token, $text, $con = false){
  // GLOBAL STUFF
  global $config;
  $table_comments = $config['db']['tables']['picture_comments'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }


  if($token){
    // CHECK TOKEN
    if(!checkPictureCommentToken($picture_id, $token, $con)){
      return false;
    }
  }else{
    // CHECK IF USER AUTHOR OF IMAGE
    $info = getAuthorInfo($picture_id);
    if(!$info || $info['id'] !== $authorid){
      return false;
    }
  }

  // SECURITY
  $picture_id = $con->real_escape_string($picture_id);
  $authorid = $con->real_escape_string($authorid);
  $text = $con->real_escape_string($text);

  // ADD PICTURE COMMENT
  $con->query("INSERT INTO `$table_comments` (`picture_id`,`user_id`,`text`) VALUES ('$picture_id','$authorid','$text')");
  if($con->error){error("SQL QUERY ERROR");}

  // RETURN
  return true;
}


// -> GET COMMENTS
function getPictureComments($picture_id, $user = false, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['picture_comments'];
  $table_member = $config['db']['tables']['member'];
  $table_pictures = $config['db']['tables']['pictures'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY
  $picture_id = $con->real_escape_string($picture_id);
  if($user){
    $user = $con->real_escape_string($user);
    $user = " AND `$table_pictures`.`user_id`='".$user."'";
  }else{
    $user = "";
  }


  // LOOK IF EXISTS AND GET COMMENTS
  $res = $con->query("SELECT `$table`.`user_id`,`text`,`displayname`,`comment_id` FROM `$table`
                      JOIN `$table_member` ON `id`=`$table`.`user_id`
                      JOIN `$table_pictures` ON `$table_pictures`.`id`=`picture_id` WHERE `picture_id` = '$picture_id'$user ORDER BY `comment_id` ASC");

  // EXISTS IF YES DO OUTPUT
  $comments = [];
  if($res && $res->num_rows > 0){
    while($comment = $res->fetch_assoc()){
      $comments[] = $comment;
    }
    return $comments;
  }else{return $comments;}
}

// -> GET COMMENT
function getPictureComment($commentid, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['picture_comments'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY
  $id = $con->real_escape_string($id);


  // LOOK IF EXISTS AND GET COMMENTS
  $res = $con->query("SELECT * FROM `$table` WHERE `comment_id`='$id'");

  // EXISTS IF YES DO OUTPUT
  if($res && $res->num_rows > 0){return $res->fetch_assoc();}else{return false;}
}

// -> DELETE COMMENT
function deletePictureComment($authorid, $commentid, $token, $con = false){
  // GLOBAL STUFF
  global $config;
  $table_comments = $config['db']['tables']['picture_comments'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // TOKEN VALID OR IMAGE AUTHOR
  if($token){
    // CHECK TOKEN
    if(!checkPictureCommentToken($picture_id, $token, $con)){
      return false;
    }
    $isPictureAuthor = false;
  }else{
    // CHECK IF USER AUTHOR OF IMAGE
    $info = getAuthorInfo($picture_id);
    if(!$info || $info['id'] !== $authorid){
      return false;
    }
    $isPictureAuthor = true;
  }

  // GET COMMENT INFO AND CHECK IF ALLOWED TO DELETE
  $comment = getPictureComment($commentid, $con);
  if(!$isPictureAuthor && $comment['user_id'] != $authorid){
    return false;
  }

  // SECURITY
  $picture_id = $con->real_escape_string($picture_id);
  $authorid = $con->real_escape_string($authorid);
  $text = $con->real_escape_string($text);

  // ADD PICTURE COMMENT
  $con->query("DELETE FROM `$table_comments` WHERE `comment_id`='$commentid'");
  if($con->error){error("SQL QUERY ERROR");}

  // RETURN
  return true;
}





 ?>
