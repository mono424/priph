<?php

function run_action(){
    // DISABLED
    //error('Registrations disabled atm!');

    // GET PARAMETER
    if(isset($_GET['user'])){$user = $_GET['user'];}else{error("\"user\" is not set!");}

    // DO SECURITY
    if(!preg_match("/^.*\@.*\..*$/",$user)){error("\"user\" is not a valid email!");}
    if(strlen($user)>64){error("\"user\" has more than 64 chars!");}

    // USER EXIST ?
    if(user_exist($user)){error('User does already exist!');}

    $emailverify = registerUser($user);
    return true;
}

 ?>
