<?php

function new_consumer_key() {
  $entropy = generateRandomString(120);
  $entropy .= uniqid(mt_rand(), true);
  $hash = hash('whirlpool', $entropy);
  // sha1 gives us a 128-byte hash
  return array(substr($hash,0,30),substr($hash,30,64));
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
