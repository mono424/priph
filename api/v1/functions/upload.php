<?php

function createUploadToken($user_id){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['upload_token'];

  // OPEN DB
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // CREATE TOKEN
  $user_id = $con->real_escape_string($user_id);
  $token = $con->real_escape_string(generateUploadToken($con));

  // WRITE IT
  $con->query("INSERT INTO $table (`user_id`,`token`) VALUES ('$user_id','$token')");

  // RETURN
  return $token;
}

function deleteUploadToken($user_id, $token){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['upload_token'];

  // OPEN DB
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // CREATE TOKEN
  $user_id = $con->real_escape_string($user_id);
  $token = $con->real_escape_string($token);

  // DELETE TOKEN
  $con->query("DELETE FROM $table WHERE `token`='$token' AND `user_id`='$user_id'");

  // RETURN
  return true;
}


function uploadTokenExists($token, $user_id = false, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['upload_token'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // CREATE SESSIONID
  $user_id = $con->real_escape_string($user_id);
  $token = $con->real_escape_string($token);

  // GENERATE WHERE
  $where = "`token`='$token'";
  if($user_id){$where.=" AND `user_id`='$user_id'";}

  // THE QUERY
  $res = $con->query("SELECT `user_id` FROM $table WHERE $where LIMIT 1");

  // CHECK & RETURN
  if(!$res || $res->num_rows > 0){return true;}else{return false;}
}


 ?>
