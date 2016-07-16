<?php

/* DB-CONFIG */

// SERVER
$config['server']['name'] = "Priph";
$config['server']['domain'] = "https://priph.com";

// DATABASE
$config['db']['host'] = "localhost";
$config['db']['user'] = "root";
$config['db']['pass'] = "";
$config['db']['db'] = "priph";

// TABLES
$config['db']['tables']['member'] = "member";
$config['db']['tables']['login_attempts'] = "login_attempts";
$config['db']['tables']['session_token'] = "session_token";
$config['db']['tables']['upload_token'] = "upload_token";
$config['db']['tables']['pictures'] = "pictures";
$config['db']['tables']['share'] = "share";
$config['db']['tables']['public_picture_token'] = "public_picture_token";
$config['db']['tables']['picture_comments'] = "picture_comments";
$config['db']['tables']['comment_token'] = "comment_token";

// LOGIN
$config['login']['max_attempts'] = 10;      // max wrong attempts in
$config['login']['attempt_time'] = 600;     // 10 Min
$config['login']['cookie_name'] = 'login_token';
$config['login']['cookie_delimiter'] = '/';
$config['login']['cookie_expire'] = 2147483647;  // JUST LIKE INFINITY ;)

// UPLOAD RESTRICTIONS
$config['upload']['max_profilpicture_size'] = 2 * 1000 * 1000; // 2MB
$config['upload']['profilpicture_extensions'] = ['jpeg','jpg'];
$config['upload']['profilpicture_size']['width'] = 200;
$config['upload']['profilpicture_size']['height'] = 200;
$config['upload']['profilpicture_path'] = "../../images/profil";

// UPLOAD RESTRICTIONS
$config['upload']['max_picture_size'] = 5 * 1000 * 1000; // 5MB
$config['upload']['picture_extensions'] = ['jpeg','jpg'];
$config['upload']['picture_path'] = "../../images/uploaded";

// COMMENT RESTRICTIONS
$config['comment']['token_valid'] = 30;//60 * 5; // 5min

// EMAIL AUTH STUFF
$config['mail']['host'] = '';
$config['mail']['user'] = '';
$config['mail']['pass'] = '';
$config['mail']['port'] = 465;
$config['mail']['SMTPSecure'] = 'ssl';

// EMAIL INFO STUFF
$config['mail']['from_name'] = "";
$config['mail']['reply_mail'] = "";
$config['mail']['reply_name'] = "";



//  ### ONLINE CONFIG OVERWRITE ###
$config_found = configOverwrite();




// CONFIG OVERWRITE
function configOverwrite($file = "../config.v1.json"){
  if(!file_exists($file)){
    return false;
  }else{
    global $config;
    $config = array_replace($config, json_decode(file_get_contents($file),true));
    return true;
  }
}

// CONFIG SAVE
function configSave($file = "../config.v1.json"){
  global $config;
  $json = json_encode($config);
  file_put_contents($file, $json);
  return true;
}



// MYSQLi
function openDB(){
  global $config;
  $mysqli = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['db']);
  if ($mysqli->connect_errno) {
    return false;
  }
  mysql_query("SET NAMES 'utf8'");
  return $mysqli;
}

function openCON(){
  global $config;
  $mysqli = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['pass']);
  if ($mysqli->connect_errno) {
    return false;
  }
  $mysqli->query("SET NAMES 'utf8'");
  return $mysqli;
}


/* API RESULT FUNCTIONS */

function error($errmsg, $response = null){
  $fresponse = ["response" => $response, "error" => $errmsg];
  die(json_encode($fresponse));
}

function response($response, $error = false){

  // ENCODE
  $fresponse = ["response" => $response, "error" => false];
  $string = json_encode($fresponse);

  // CHECK FOR ENCODING ERROR
  $jsonError = json_error();
  if($jsonError){error("JSON-Encoding-Error: ".$jsonError);}

  // OUTPUT
  echo $string;

  die();
}

function json_error(){
  switch (json_last_error()) {
    case JSON_ERROR_NONE:
    return false;
    break;
    case JSON_ERROR_DEPTH:
    return 'Maximum stack depth exceeded';
    break;
    case JSON_ERROR_STATE_MISMATCH:
    return 'Underflow or the modes mismatch';
    break;
    case JSON_ERROR_CTRL_CHAR:
    return 'Unexpected control character found';
    break;
    case JSON_ERROR_SYNTAX:
    return 'Syntax error, malformed JSON';
    break;
    case JSON_ERROR_UTF8:
    return 'Malformed UTF-8 characters, possibly incorrectly encoded';
    break;
    default:
    return 'Unknown error';
    break;
  }
}

?>
