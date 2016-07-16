<?php

function shortn_link($long_link){

  //TODO: check if link is allowed Domain!

  $apiKey = 'AIzaSyC4NI1j1KGcLIW2dRYxeeuSUIX1O9s-t5E';

  $postData = array('longUrl' => $long_link);
  $jsonData = json_encode($postData);

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

  $response = curl_exec($ch);
  $json = json_decode($response, true);

  curl_close($ch);

  return $json['id'];
}

?>
