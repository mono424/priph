<?php

// INFO FOR API
/* --[api_info]--
{
  "headline": "Admin get User",
  "url": "GET: http://priph.com/api/v1/?action=admin-get-user&id=[id_optional]&email=[email_optional]&displayname=[displayname_optional]&limit=[limit_optional]&page=[page_optional]",
  "success": "{\"response\":{\"pages\":56,\"user\":[{\"id\":\"6\",\"email\":\"admin@priph.com\",\"displayname\":\"Kimbo\",\"imageurl\":\"..\/..\/images\/profil\/O3vP.jpeg\",\"email_verification\":\"\",\"admin\":\"1\",\"blocked\":\"0\",\"created\":\"2016-04-23 19:15:53\"},{\"id\":\"22\",\"email\":\"testyTest@testy.com\",\"displayname\":\"Hannibal\",\"imageurl\":\"..\/..\/images\/profil\/HN5zR.jpeg\",\"email_verification\":\"\",\"admin\":\"0\",\"blocked\":\"0\",\"created\":\"2016-05-18 17:47:37\"}]},\"error\":false}",
  "unsuccess": null,
  "note": []
}
   --[api_info]-- */


function run_action(){
  if(attemptAuth(false,false)){
    $user = getUserFromCookie();
    if(!userIsAdmin($user)){error('No access!');}

    // OPTIONAL PARAMS
    $limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $id = (isset($_GET['user'])) ? $_GET['user'] : false;
    $email = (isset($_GET['email'])) ? $_GET['email'] : false;
    $displayname = (isset($_GET['displayname'])) ? $_GET['displayname'] : false;

    // SECURITY
    if(!is_numeric($limit)){error("Illigal Limit: '$limit'");}
    if(!is_numeric($page)){error("Illigal Page: '$start'");}

    // GENERATE START WITH PAGE
    $start = --$page*$limit;

    // LIST USER
    return list_user($limit, $start, $id, $email, $displayname);
  }else{
    error('Not logged in!');
  }
}
