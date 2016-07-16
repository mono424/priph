<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Install Priph</title>
  <style media="screen">
  body{
    background-color: rgb(143, 206, 208);
    font-family: helvetica, sans-serif;
  }
  img{
    width: 400px;
    height: auto;
  }
  h2{
    margin: 0 0 20px 0;
    text-align: center;
    color: rgba(156, 156, 156, 0.5);
    /*border-bottom: 1px solid rgba(156, 156, 156, 0.5);*/
  }
  input{
    font-size: large;
    border-radius: 2px;
    border: 1px solid rgb(179, 179, 179);
    padding: 3px 2px 2px 3px;
    display: block;
    margin: 0 auto 5px auto;
    width: 500px;
  }
  button{
    position:absolute;
    bottom: 10px;
    left: 0;
    width: 800px;
    height: 30px;
    background-color: rgb(73, 149, 108);
    color: white;
    display: block;
    text-align:center;
    font-size: large;
    text-decoration: none;
    border:none;
    cursor:pointer;
  }
  button:hover{
    transition: ease-in 0.3s;
    background-color: rgb(105, 182, 141);
  }
  .wrapper{
    width: 800px;
    margin: 40px auto;
  }
  .wrapper_body{
    height: 900px;
    border-radius: 4px;
    background-color: white;
    padding: 10px;
    position:relative;
  }
  .group{
    text-align: center;
    margin-bottom: 50px;
  }
  </style>
  <script src="js/jquery-1.12.3.min.js"></script>
</head>
<body>

  <div class="wrapper">
    <img src="img/priph_full.png" alt="" />
    <?php require '../v1/config.php'; ?>

    <?php
    if(!$config_found){
      ?>
      <div class="wrapper_body">
        <form id="setupForm" method="post">
          <div class="group">
            <h2>Server</h2>
            <input type="text" name="server[name]" placeholder="Name*" required>
            <input type="text" name="server[domain]" placeholder="Domain*" required>
          </div>
          <div class="group">
            <h2>Database</h2>
            <input type="text" name="db[host]" placeholder="Host*" required>
            <input type="text" name="db[user]" placeholder="Username">
            <input type="text" name="db[pass]" placeholder="Password">
            <input type="text" name="db[db]" placeholder="Database*" required>
          </div>
          <div class="group">
            <h2>Email Settings</h2>
            <input type="text" name="mail[host]" placeholder="Host">
            <input type="text" name="mail[port]" placeholder="Port">
            <input type="text" name="mail[SMTPSecure]" placeholder="SMTP-Security: ssl or tls">
            <input type="text" name="mail[user]" placeholder="Username">
            <input type="text" name="mail[pass]" placeholder="Password">
          </div>
          <div class="group">
            <h2>Administrator</h2>
            <input type="email" name="email" placeholder="Email*" required>
            <input type="text" name="pass" placeholder="Password*" required>
          </div>
          <button id="submit" type="submit" href="">Setup Priph-System</button>
        </form>
      </div>
      <?php
    }else{
      ?>
      <div class="wrapper_body">
        <h2>already setup! You can manually change settings in your 'api/config.v1.json' ;)</h2>
      </div>
      <?php } ?>
    </div>
    <script type="text/javascript">
    var submit = document.querySelector('#submit');
    $("#setupForm").submit(function(e) {
      submit.disabled = "disabled";

      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "install.php",
        data: $("#setupForm").serialize(),
        success: function(data)
        {
          if(data == "1"){
            alert('Success!');
            window.location.href = "/";
          }else{
            alert(data);
            submit.disabled = "";
          }
        }
      });
    });
    </script>
  </body>
  </html>
