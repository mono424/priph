<?php

function list_user($limit, $start, $id = false, $email = false, $displayname = false, $con = false){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  if(!$con){$con = openDB();}
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $start = $con->real_escape_string($start);
  $limit = $con->real_escape_string($limit);
  $id = $con->real_escape_string($id);
  $email = $con->real_escape_string($email);
  $displayname = $con->real_escape_string($displayname);
  if(!is_numeric($limit)){error("Illigal Limit: '$limit'");}
  if(!is_numeric($start)){error("Illigal Page: '$start'");}

  // GENERATE WHERE
  $where = "";
  if($id){$where.=" OR `id` = '$id'";}
  if($email){$where.=" OR `email` LIKE '%$email%'";}
  if($displayname){$where.=" OR `displayname` LIKE '%$displayname%'";}
  if($where){$where = "WHERE ".substr($where, 4);}

  // THE QUERY
  $cres = $con->query("SELECT COUNT(*) as 'count' FROM `$table` $where");
  $res = $con->query("SELECT
                      `id`,
                      `email`,
                      `displayname`,
                      `imageurl`,
                      `email_verification`,
                      `admin`,
                      `blocked`,
                      `created` FROM `$table` $where LIMIT $start,$limit");

  // CHECK & RETURN
  $pages = false;
  $array = [];
  if($res){
    $pages = ceil($cres->fetch_array(MYSQLI_ASSOC)['count'] / $limit);
    while($arr = $res->fetch_array(MYSQLI_ASSOC)){
      array_push($array, $arr);
    }
  }else{$array=false;}
  return ["pages" => $pages, "user"=>$array];
}




function user_lock($user_id, $state, $con = false){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  if(!$con){$con = openDB();}
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);
  $state = $con->real_escape_string($state);

  // DOIT
  $cres = $con->query("UPDATE `$table` SET `blocked`='$state' WHERE `id`='$user_id'");
  return true;
}


function user_adminrights($user_id, $state, $con = false){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  if(!$con){$con = openDB();}
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);
  $state = $con->real_escape_string($state);

  // DOIT
  $cres = $con->query("UPDATE `$table` SET `admin`='$state' WHERE `id`='$user_id'");
  return true;
}

function user_deauth($user_id, $con = false){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['session_token'];

  // DATABASE CONNECTION
  if(!$con){$con = openDB();}
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $user_id = $con->real_escape_string($user_id);

  // DOIT
  $cres = $con->query("DELETE FROM `$table` WHERE `user_id`='$user_id'");
  return true;
}

function user_delete($user_id, $con = false){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  if(!$con){$con = openDB();}
  if($con === false){error('SQL ERROR');}

  // DELETE PROFILE PICTURE
  deleteUserProfilePicture($user_id, $con);

  // DELETE GALLERY PICTURES
  deleteAllPictures($user_id, $con);

  // DELETE ALL SESSIONS
  user_deauth($user_id, $con);

  // DELETE USER
  $res = $con->query("DELETE FROM `$table` WHERE `id`='$user_id'");
  return true;
}


 ?>
