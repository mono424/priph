<?php

/* DB-CONFIG */

// GLOBAL
$config['db']['host'] = "localhost";
$config['db']['user'] = "root";
$config['db']['pass'] = "";
$config['db']['db'] = "priph";

// TABLES
$config['db']['tables']['member'] = "member";
$config['db']['tables']['login_attempts'] = "login_attempts";
$config['db']['tables']['api_keys'] = "api_keys";
$config['db']['tables']['session_token'] = "session_token";
$config['db']['tables']['upload_token'] = "upload_token";
$config['db']['tables']['pictures'] = "pictures";

// LOGIN
$config['login']['max_attempts'] = 10;      // max wrong attempts in
$config['login']['attempt_time'] = 600;     // 10 Min
$config['login']['cookie_name'] = 'login_token';  // JUST LIKE INFINITY ;)
$config['login']['cookie_delimiter'] = '/';  // JUST LIKE INFINITY ;)
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


// API KEY INFOheight
// $config['keyinfo'];

// MYSQLi
function openDB(){
  global $config;
  $mysqli = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['db']);
  if ($mysqli->connect_errno) {
    return false;
  }
  return $mysqli;
}


?>
