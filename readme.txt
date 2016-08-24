######  ABOUT  ######

Projekt: Priph
Autor: Khadim Fall






######  SETUP - ENGLISH  ######

1. Copy priph in your webroot-directory.
2. Navigate to "[Your Domain or IP]/api/setup" in the Browser you prefer.
3. Complete the form and submit with "Setup Priph-System".
	-> You can leave the email settings blank but that causes that the registration functions wont work!
5. Change the value of the $domain variable in "index.php" wich is located in the root directory to your domain or ip.
5. You finished the setup! You should be able to log in with your administrator credentials.

*. If you want to change the config after the installation, wich offers much more settings than you have seen in the setup form,
   you are able to do by editing following json-file: "api/config.v1.json".
   If you want to run the setup again, just delete the "api/config.v1.json"-File.
   As long as the config file exists, the setup is because of security reasons not accessable.






######  SETUP - DEUTSCH  ######

1. Priph-Projekt in Webroot-Verzeichnis kopieren.
2. "[Die Domain oder IP]/api/setup" im Browser aufrufen.
3. Felder ausfüllen und mit dem Button "Setup Priph-System" bestätigen.
	-> Email Einstellungen können leer gelassen werden. Registrierungs-Funktion der Seite wird darausfolgend nicht funktionieren!
5. $domain Variable in der "index.php" im Root-Verzeichnis anpassen.
5. Fertig! Loggen sie sich in ihren Adminitrator Account ein :).

*. Falls Sie änderungen der Config vornehmen möchten, welche noch viele weitere einstellungsmöglichkeiten bietet,
   können sie dies einfach durch das editieren der folgenden Datei: "api/config.v1.json".
   Falls Sie einfach nur das Setup erneut durchführen möchten, können sie diese Datei einfach löschen.
   Solang die Datei existiert kann aus Sicherheitsgründen das Setup nicht ein weiteres mal ausgeführt werden!






###### CONFIG-FILE ######

A Default Config-File looks like:
{
  "server": {
    "name": "Priph",
    "domain": "http://priph.com"
  },
  "db": {
    "host": "localhost",
    "user": "root",
    "pass": "",
    "db": "priph",
    "tables": {
      "member": "member",
      "login_attempts": "login_attempts",
      "session_token": "session_token",
      "upload_token": "upload_token",
      "pictures": "pictures",
      "share": "share",
      "public_picture_token": "public_picture_token",
      "picture_comments": "picture_comments",
      "comment_token": "comment_token"
    }
  },
  "login": {
    "max_attempts": 10,
    "attempt_time": 600,
    "cookie_name": "login_token",
    "cookie_delimiter": "/",
    "cookie_expire": 2147483647
  },
  "upload": {
    "max_profilpicture_size": 2000000,
    "profilpicture_extensions": [
      "jpeg",
      "jpg"
    ],
    "profilpicture_size": {
      "width": 200,
      "height": 200
    },
    "profilpicture_path": "../../images/profil",
    "max_picture_size": 5000000,
    "picture_extensions": [
      "jpeg",
      "jpg"
    ],
    "picture_path": "../../images/uploaded"
  },
  "comment": {
    "token_valid": 30
  },
  "mail": {
    "host": "",
    "user": "",
    "pass": "",
    "port": "",
    "SMTPSecure": "",
    "from_name": "",
    "reply_mail": "",
    "reply_name": ""
  }
}







######  EXTERNAL STUFF IN PRIPH  ######

  -> bootstrap
    > NOT USED IN MAIN-PRIPH-PAGE
    > used to make a quick small api-documentation

  -> fontawesome
    > used it for the awesome icons! <3

  -> jquery
    > Used for some features & following plugins
    > especially used for ajax, fadeIn & fadeOut

  -> fullpage
    > a jquery plugin used for the fancy page transitions!! <3

  -> Remodal
    > a jquery plugin used for the fancy inpage dialogs! *-*

  -> circle-progress
    > a jquery plugin for the amazing circle progress on image uploading!

  -> PHPMailer
    > A PHP Mail framework, to send better verify-registration-emails!







######  LINKS TO THE EXTERNAL STUFF  ######

  -> fontawesome: https://fortawesome.github.io/Font-Awesome/
  -> jquery: https://jquery.com/
  -> fullpage: http://alvarotrigo.com/fullPage/
  -> Remodal: http://vodkabears.github.io/remodal/
  -> circle-progress: http://kottenator.github.io/jquery-circle-progress/


- Khadim Fall
