<?php

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

 ?>
