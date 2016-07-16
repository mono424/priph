<?php

/* REGISTER FUNCTIONS*/

function registerUser($user, $pass = ""){
  //CONFIG STUFF
  global $config;
  $table = $config['db']['tables']['member'];

  // USER EXISTS
  $user_id = getUserIdFromMail($user);
  if($user_id){error('Email is already registered!');}

  // DATABASE CONNECTION
  $con = openDB();
  if($con === false){error('SQL ERROR');}

  // DISABLE AUTO COMMIT FOR ROLLBACK
  $con->autocommit(FALSE);

  // SECURITY
  $user = $con->real_escape_string($user);
  $pass = $con->real_escape_string($pass);

  // HASHES
  $salt = randomSalt();
  $hashedPassword = hashPassword($pass, $salt);

  // EMAIL-VERIFICATION
  $emailverify = randomPass();

  // WRITE TO DB
  if(!$con->query("INSERT INTO $table (`email`,`password`,`salt`,`email_verification`,`admin`,`blocked`) VALUES ('$user','$hashedPassword','$salt','$emailverify',0,1)")){
    // ROLLBACK AND ERROR
    $con->rollback();
    error('Database exception!');
  }

  // SEND MAIL
  if(!sendMail($user, $emailverify)){
    // ROLLBACK AND ERROR
    $con->rollback();
    error('mail couldnt be sent!');
  }

  // FINISH STUFF
  $con->commit();

  // ENABLE AUTO COMMIT AGAIN
  $con->autocommit(TRUE);

  //RETURN
  return true;
}

function verifyUser($user, $emailVerification, $pass, $displayname){
  // GET USER ID
  $user_id = getUserIdFromMail($user);
  if(!$user_id){error('Email is not registered!');}

  // GET USER INFO
  $info = getUserInfo($user_id);
  if(!$info){error('Email is not registered!');}

  // CHECK IF PASSWORD & DISPLAYNAME VALID
  if(!validPassword($pass)){error('Password-Length has to be between 3 and 128 Chars!');}
  if(!validDisplayname($displayname)){error('Displayname not valid! min. 3, max. 64 and no special chars.');}

  // CHECK Verification-Code
  if($info['email_verification'] === $emailVerification){
    // ACCOUNT ALREADY VERIFICATED
    if($info['email_verification'] == "" || $info['blocked'] == 0){
      error('Account already verificated.');
    }

    $info['email_verification'] = "";
    $info['displayname'] = $displayname;
    $info['password'] = hashPassword($pass, $info['salt']);
    $info['blocked'] = 0;
    return updateUser($user_id, $info); // DOES ANTI SQL INJECTION DONT WORRY ;)
  }else{error('Wrong Verification-Code!');}
}


function sendMail($user, $verifycode){
  //CONFIG STUFF
  global $config;

  $mail = new PHPMailer;

  $mail->isSMTP();
  $mail->Host = $config['mail']['host'];
  $mail->SMTPAuth = true;
  $mail->Username = $config['mail']['user'];
  $mail->Password = $config['mail']['pass'];
  $mail->SMTPSecure = $config['mail']['SMTPSecure'];
  $mail->Port = $config['mail']['port'];

  $mail->setFrom($config['mail']['user'], $config['mail']['from_name']);
  $mail->addAddress($user);
  $mail->addReplyTo($config['mail']['reply_mail'], $config['mail']['reply_name']);

  $mail->isHTML(true);

  $mail->Subject = 'Thank you for your Registration';
  $mail->Body    = "Welcome to ".$config['server']['name']."!<br><br><b>Please verify your Account <a href=\"".$config['server']['domain']."?user=$user&verify=$verifycode\">here</a></b>.<br><br>
    Or manually on ".$config['server']['domain']."?verify with following verification code: <i>$verifycode</i>.<br><br>
    Gratefully<br><br><br>
    ".$config['server']['name']."
    ";
  $mail->AltBody = "Thank you for your Registration at ".$config['server']['name']."!\nPlease verify your Account here: ".$config['server']['domain']."?user=$user&verify=$verifycode .\n
    Or manually on ".$config['server']['domain']."?verify with following verification code: $verifycode.\n\n
    Gratefully\n\n\n
    ".$config['server']['name']."
    ";

  if(!$mail->send()) {
    //echo 'Message could not be sent.';
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
    return false;
  }

  return true;
}

?>
