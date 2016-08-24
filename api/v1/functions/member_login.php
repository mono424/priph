<?php

/* LOGIN FUNCTIONS */

function attemptAuth($con = false, $refreshToken = false){ // refreshToken default turned off cuz of some ajax problems!
  // GLOBAL STUFF
  global $config;
  $expire = $config['login']['cookie_expire'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // PARSE INFORMATION
  $info = parseCookie();

  // IF COOKIE EXISTS AND VALID
  if($info){

    // I BRING SOME STRUCTURE IN IT :)
    $user_id = $info['user_id'];
    $session = $info['session'];
    $token = $info['token'];

    // CHECK IF THE SESSION EXISTS WITH TOKEN
    if(userSessionExists($session, $user_id, $token, $con)){
      // VALID SESSION WITH TOKEN - IF NO TOKEN UPDATE WANTED RETURN DIRECTLY TRUE
      if(!$refreshToken){return true;}
      // UPDATE SESSION WITH NEW TOKEN
      $new_token = updateUserSession($user_id, $session, $con);
      // UPDATE THE COOKIE
      updateUserCookie($user_id, $session, $new_token, $expire);
      return true;
    }else{
      // INVALID SESSION OR TOKEN
      if(userSessionExists($session, $user_id, "", $con)){
        // SESSION EXISTS; MAYBE SESSION HIJACKING TODO: User Warning
        killCurrentSession();
        killUserCookie();
      }else{
        // SESSION DOESNT EXISTS
      }
    }
  }
  killUserCookie();
  return false;
}

function login($user, $pass, $remember = false){
  // CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // SECURITY
  $user = $con->real_escape_string($user);
  $pass = $con->real_escape_string($pass);

  // GET USER ID FROM MAIL
  $user_id = getUserIdFromMail($user,$con);
  if(!$user_id){return false;}

  // CHECK FOR ATTEMPTS
  if(checkAttempts($con, $user_id)){

    // GET INFO FOR LOGIN
    $res = $con->query("SELECT * FROM $table WHERE `id`='$user_id' LIMIT 1");
    if(!$res){return false;} // USER DOES NOT EXIST
    $info = $res->fetch_array();

    // CHECK BLOCK
    if($info['blocked']){
      if($info['email_verification'] != ""){
        error('Please verify your Email!');
      }else{
        error('Youre Account has been suspended!');
      }
    }

    // CHECK HASHED PASSWORD
    if(validateLogin($pass, $info['password'], $info['salt'])){

      // LOGIN SUCCESSFUL
      clearAttempts($con, $user_id); // CLEAR FAILED ATTEMPTS
      $cookie_length = ($remember) ? $config['login']['cookie_expire'] : 0;

      // CREATE USER SESSION
      $usersession = createUserSession($user_id, $con);

      // CREATE COOKIE
      updateUserCookie($user_id, $usersession['session'], $usersession['token'], $cookie_length);

      return true;
    }else{
      addAttempt($con, $user_id);
      return false;
    }



  }else{
    error('To many failed Login attempts!');
  }
}





/* ATTEMPT SYSTEM */

function addAttempt($con, $user_id){
  //CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['login_attempts'];

  // ADD TO TABLE
  $date = date("Y-m-d H:i:s", time());
  $ip = $_SERVER['REMOTE_ADDR'];

  // SECURITY
  $date = $con->real_escape_string($date);
  $ip = $con->real_escape_string($ip);
  $user_id = $con->real_escape_string($user_id);

  $res = $con->query("INSERT INTO $table VALUES ('$user_id','$date','$ip')");
  return true;
}

function checkAttempts($con,$user_id){
  // CONFIG STUFF
  global $config;
  $max_attempts = $config['login']['max_attempts'];
  $secs = $config['login']['attempt_time'];
  $table = $config['db']['tables']['login_attempts'];

  // CALC DATE
  $ts = time(); // Current Time as Timestamp
  $ts -= $secs; // minus the config time
  $date = date("Y-m-d H:i:s", $ts); // to human datetime

  // ESCAPE
  $user_id = $con->real_escape_string($user_id);

  // THE QUERY
  $res = $con->query("SELECT `user_id` FROM $table WHERE `user_id`='$user_id' AND `time`>'$date'");

  // CHECK & RETURN
  if($res->num_rows >= $max_attempts){return false;}else{return true;}
}

function clearAttempts($con, $user_id){
  //CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['login_attempts'];

  // ADD TO TABLE
  $date = date("Y-m-d H:i:s", time());
  $ip = $_SERVER['REMOTE_ADDR'];

  // THE QUERY
  $res = $con->query("DELETE FROM $table WHERE `user_id`='$user_id'");

  // RETURN
  return true;
}






/* USERSESSION SYSTEM */

function updateUserCookie($user_id, $session, $token, $expire = 0){
  // GLOBAL STUFF
  global $config;
  $cookiename = $config['login']['cookie_name'];
  $delimiter = $config['login']['cookie_delimiter'];

  // CREATE VALUE
  $value = $user_id.$delimiter.$session.$delimiter.$token;

  // SET COOKIE
  setcookie($cookiename, $value, $expire, "/");
}

function createUserSession($user_id, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['session_token'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // GET UNIQUE SESSION ID
  $session = generateUserSession($con);

  // CREATE USER SESSION
  $con->query("INSERT INTO $table VALUES ('$session', '$user_id', '', '' , '', NOW())");

  // UPDATE USERSESSION
  $firstToken = updateUserSession($user_id, $session, $con);

  // CREATE RETURN VALUE
  $out['session'] = $session;
  $out['token'] = $firstToken;
  return $out;
}

// CREATES NEW TOKEN
function updateUserSession($user_id, $session, $con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['session_token'];

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // CHECK IF SESSION EXISTS FOR THIS USER
  if(!userSessionExists($session, $user_id, "", $con)){return false;}

  // GET TOKEN FOR SESSION
  $new_token = randomPass(64);

  // GET MORE CLIENT INFO
  $browser = $con->real_escape_string(getBrowser());
  $ip = $con->real_escape_string($_SERVER['REMOTE_ADDR']);

  // CREATE USER SESSION
  $con->query("UPDATE $table SET `token`='$new_token',`ip`='$ip',`browser`='$browser' WHERE `session`='$session'");

  return $new_token;
}

function killUserCookie(){
  // GLOBAL STUFF
  global $config;
  $cookiename = $config['login']['cookie_name'];

  // KILL IT
  if(isset($_COOKIE[$cookiename])){unset($_COOKIE[$cookiename]);setcookie($cookiename, null, -1, '/');}
}

function killCurrentSession($con = false){
  // GLOBAL STUFF
  global $config;
  $table = $config['db']['tables']['session_token'];

  // INFO FROM COOKIE
  $info = parseCookie();
  if(!$info){error('No valid Cookie!');}

  // OPEN NEW DB CONNECTION IF NOT EXISTS
  if(!$con){
    $con = openDB();
    if($con === false){error('SQL ERROR');}
  }

  // SECURITY
  $info['user_id'] = $con->real_escape_string($info['user_id']);
  $info['session'] = $con->real_escape_string($info['session']);

  // CHECK IF SESSION EXISTS FOR THIS USER
  if(!userSessionExists($info['session'], $info['user_id'], "", $con)){return false;}

  // CREATE USER SESSION
  $con->query("DELETE FROM $table WHERE `session`='".$info['session']."'");

  return true;
}

function parseCookie(){
  global $config;
  $cookiename = $config['login']['cookie_name'];
  $delimiter = $config['login']['cookie_delimiter'];

  // IF COOKIE EXISTS
  if(!isset($_COOKIE[$cookiename])){return false;}

  $info = explode($delimiter, $_COOKIE[$cookiename], 3);

  // CHECK COOKIE CORRUPTED
  if(count($info)<3){killUserCookie();return false;}

  // I BRING SOME STRUCTURE IN IT :)
  $arr['user_id'] = $info[0];
  $arr['session'] = $info[1];
  $arr['token'] = $info[2];

  return $arr;
}

 ?>
