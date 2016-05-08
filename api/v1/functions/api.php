<?php

/* CHECK API KEY */

function checkAPIKey($key){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['api_keys'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // SECURITY
  $key = $con->real_escape_string($key);

  // GET KEY INFO
  $res = $con->query("SELECT * FROM $table WHERE `api_key`='$key' LIMIT 1");
  if(!$res){return false;} // KEY DOES NOT EXIST
  $info = $res->fetch_array();

  if("*" == $info['host'] || $_SERVER['REMOTE_ADDR'] == $info['host'] || gethostbyaddr($_SERVER['REMOTE_ADDR']) == $info['host']){
    $config['keyinfo'] = $info;
    return true;
  }else{
    return false;
  }
}

function addAPIKey($host, $allow_user_registration = false, $allow_key_registration = false){
  //CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['api_keys'];

  // ALLOWED TO REGISTER USERS ??
  if(!$config['keyinfo']['allow_register_api_keys']){error('Not allowed!');}

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // SECURITY
  $host = $con->real_escape_string($host);
  $allow_user_registration = $con->real_escape_string($allow_user_registration);
  $allow_key_registration = $con->real_escape_string($allow_key_registration);

  // RANDOM API KEY
  do{
    $key = randomPass();
  }while(APIKeyExist($key));

  // WRITE TO DB
  $con->query("INSERT INTO $table (`api_key`,`host`,`allow_register_user`,`allow_register_api_keys`) VALUES ('$key','$host','$allow_user_registration','$allow_key_registration')");

  //RETURN
  return $key;
}


function APIKeyExist($key){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['api_keys'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  //SECURITY
  $key = $con->real_escape_string($key);

  // THE QUERY
  $res = $con->query("SELECT `api_key` FROM $table WHERE `api_key`='$key' LIMIT 1");

  // CHECK & RETURN
  if(!$res || $res->num_rows > 0){return true;}else{return false;}
}






/* API RESULT FUNCTIONS */

function error($errmsg, $response = null){
  $fresponse = ["response" => $response, "error" => $errmsg];
  die(json_encode($fresponse));
}

function response($response, $error = false){
  $fresponse = ["response" => $response, "error" => false];
  die(json_encode($fresponse));
}

 ?>
