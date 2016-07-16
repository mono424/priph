<?php

function echoApiEntry($info){
  $headline = $info['headline'];
  $success = $info['success'];
  $unsuccess = $info['unsuccess'];
  $url = $info['url'];

  $out =  "<h3>$headline</h3>";
  if(is_array($url)){
    foreach($url as $u){
      $out.="<code>$u</code><br>";
    }
  }else{
    $out.="<code>$url</code><br>";
  }

  if($success){
    $out .= "Success:
    <pre>
    $success
    </pre>";
  }

  if($unsuccess){
    $out .= "Unsuccess:
    <pre>
    $success
    </pre>";
  }

  foreach($info['note'] as $note){
    $out .= "<p class=\"bg-info\">
    $note
    </p>";
  }

  $out .= "<br><hr><br>";
  echo $out;
}


?>


<!DOCTYPE html>
<html>
<!-- NOT DOCUMENTED:  -->
<head>
<meta charset="utf-8">
<title>Priph API</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- at least a bit styling.. -->
<style media="screen">
body{
  background: rgb(57, 59, 57);
}
#wrapper{
background: white;
width: 1000px;
margin: 60px auto;
padding: 10px 20px;
border-radius: 4px;
box-shadow: rgba(0, 0, 0, 0.4) 1px 1px 1px;
}
h1{
  text-align: center;
}
h2{
  color: rgb(87, 190, 214);
  border-bottom:dotted 5px rgb(87, 190, 214);
}
p {
  font-size: 18px;
  padding-left: 10px;
}

code{
  font-size: 18px;
}
</style>
</head>
<body>
<div id="wrapper">
<h1>Priph API</h1>

<h2>Overview</h2>
<p class="bg-danger">
<b>WARNING: The API is currently restricted to priph.com and NOT PUBLIC!</b>
</p>
<p>
The root of the API is located at: <code>http://priph.com/api/v1</code><br>
You wont need a API-Key or something!<br>Made for Wizards by a proud Developer <3
</p>
<br>
<h2>Required Params</h2>
<p>
There is at least one required Parameter:
</p>
<ul>
<li>action</li>
</ul>
<p>
Note: depending on the action, there are may other required Parameter.<br>
</p><br>
<h2>Answer Encoding</h2>
<p>
Every Answer given by API is JSON encoded. Nothing else available!
</p><br>
<h2>Error Handling</h2>
<p>
If something went wrong on our side, we will provide you an error description:
</p>
<pre>
{"response":null,"error":"Sorry, the API is not Public atm!"}
</pre>
<br>

<h2>Actions</h2><br><hr><br>
<?php

foreach(scandir("v1/action") as $file){
  // creat new way :P
  $string = file_get_contents("v1/action/".$file);
  preg_match("/\-\-\[api_info\]\-\-(.*)\-\-\[api_info\]\-\-/is", $string, $info);
  if(!empty($info)){
    $info = trim($info[1]);
    $json = json_decode($info, true);
    if(!empty($json)){
      echoApiEntry($json);
    }
  }
}

die();

 ?>

</div>
</body>
</html>
