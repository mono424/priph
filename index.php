<?php

/* API RESTRICTION SESSION */
require 'session.php';

/* SKIN */
$skin = "default";
$skin_muted = true;
$skin_video = false;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Priph - Private like it used to be!</title>
  <meta name="author" content="Khadim Fall" />
  <meta name="description" content="Picture sharing service with remarkable privacy features!" />
  <meta http-equiv="cache-control" content="no-cache">
  <link rel="shortcut icon" type="image/ico" href="img/priph.ico" />
  <!-- MOBILE ;) -->
  <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">

  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="css/font-awesome.min.css">

  <!-- FULLPAGE CSS -->
  <link rel="stylesheet" href="css/jquery.fullpage.min.css" />

  <!-- NOTIE CSS -->
  <link rel="stylesheet" href="css/notie.css" />

  <!-- REMODAL CSS -->
  <link rel="stylesheet" href="css/remodal.css" />
  <link rel="stylesheet" href="css/remodal-default-theme.css" />

  <!-- SMALL PRELOADER -->
  <link rel="stylesheet" href="/css/small_preloader.css">

  <!-- PRIPH CSS -->
  <link rel="stylesheet" href="/css/master.css">
  <link rel="stylesheet" href="/css/about_slide.css">
  <link rel="stylesheet" href="/css/mobile.css">

  <!-- JQUERY -->
  <script src="js/jquery-1.12.3.min.js"></script>

  <!-- FULLPAGE & SLIMSCROLL -->
  <script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
  <script type="text/javascript" src="js/jquery.fullpage.min.js"></script>
  <script type="text/javascript" src="js/jquery.fullpage.setup.js"></script>

  <!-- REMODAL -->
  <script type="text/javascript" src="js/remodal.min.js"></script>

  <!-- PULL 2 REFRESH -->
  <script type="text/javascript" src="js/jquery.p2r.min.js" defer></script>

  <!-- CIRCLE PROGRESS -->
  <script type="text/javascript" src="js/circle-progress.js"></script>

  <!-- PRIPH LOADSCREEN -->
  <script type="text/javascript" src="js/jquery.preload.js"></script>

  <!-- PRIPH JS API -->
  <!-- <script type="text/javascript" src="http://priph.com/api/v1/js/script.min.js"></script> -->
  <script type="text/javascript" src="api/v1/js/script.local.js"></script>

  <!-- ADDITIONAL PRIPH JS -->
  <script type="text/javascript" src="js/start.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <script type="text/javascript" src="js/gallery.js"></script>

  <!-- PRIPH PAGE SELECTOR & JS VIDEO VARS -->
  <script type="text/javascript">
  if(window.location.hash){startPage = window.location.hash.substr(1);}else{startPage=false;}
  <?php
  if(isset($_GET['verify'])){echo "startPage = 'verify';";}
  ?>
  var skinVideoDisabled = <?php echo !$skin_video; ?>;
  </script>

  <!-- SESSION FOR API -->
  <?php echoSessionScript(); ?>

</head>
<body>
  <!-- Preloader -->
  <div id="preloader">
    <div id="preloader_status">&nbsp;</div>
  </div>

  <!-- FULL PAGE -->
  <div id="fullpage" class="remodal-bg">

    <!-- INTRO CONTAINER & USER SETINGS -->
    <div id="slide0" class="section" data-anchor="intro">

      <!-- INTRO CONTAINER -->
      <div class="slide">
        <!-- VIDEO BACKGROUND -->
        <div class="intro-video">
          <!-- SKIN BACKGROUND POSTER -->
          <?php
          $poster = "skin/$skin/poster.jpg";
          if(file_exists($poster)){$poster = " poster=\"$poster\"";}else{$poster="";} ?>
          <video autoplay loop<?php echo $poster; ?> preload="auto" <?php if($skin_muted){echo "muted";} ?>>
            <!-- SKIN BACKGROUND VIDEO WEBM -->
            <?php
            $path = "skin/$skin/video.webm";
            if(file_exists($path) && $skin_video){
              echo '<source src="'.$path.'" type="video/webm" />Your browser does not support the video tag. I suggest you upgrade your browser.'."\n";
            } ?>

            <!-- SKIN BACKGROUND VIDEO MP4 -->
            <?php
            $path = "skin/$skin/video.mp4";
            if(file_exists($path) && $skin_video){
              echo '<source src="'.$path.'" type="video/mp4" />Your browser does not support the video tag. I suggest you upgrade your browser.'."\n";
            } ?>
          </video>
        </div>

        <!-- PRIPH -->
        <div class="intro-overlay">

          <!-- USER OVERLAY-->
          <div id="user-overlay" class="cf">
            <!-- MENU -->
            <div class="overlay-menu">
              <ul>
                <li><a href="#" id="logoutButton">Logout</a></li>
              </ul>
            </div>

            <!-- DISPLAY -->
            <div class="display">
              <div class="welcome"></div>
              <img src="">
            </div>
          </div>


          <!-- LOGIN / REGISTER -->
          <div id="loginmenu-overlay">
            <ul>
              <li><a id="btn-login" href="#login">Login</a></li>
              <li><a id="btn-register" href="#register">Register</a></li>
            </ul>
          </div>





          <!-- OVERLAY MAIN PART -->

          <div id="overlay_main">

            <!-- LOGO -->
            <div id="logo" class="logo logo-alone">
              <img src="img/priph_full.png" alt="" />
              <span>in Development</span>
            </div>

            <!-- OVERLAY BAR -->
            <div id="upload-overlay">
              <div>
                <center>
                  <div id="upload_picture_btn" class="button-intro" data-uploadstatus="0">Upload Picture</div>
                  <div id="webcam_snapshot_btn" class="button-intro overlay-bar-right">Webcam Snapshot</div>
                  <input id="upload_picture" type="file" name="image" value="" accept="image/jpeg">
                  <input id="upload_video" type="file" name="video" value="">
                </center>
              </div>
              <div class="dropText">
                <center>
                  <p>
                    Or just drop one..
                  </p>
                </center>
              </div>
            </div>
            <div id="more_btn" class="more_about">
              <center>
                <p>More about Priph</p>
                <i class="fa fa-arrow-down" aria-hidden="true"></i>
              </center>
            </div>

            <!-- UPLOAD OVERLAY -->
            <div id="uploadStatus">
              <div id="uploadCircle"></div>
              <p id="uploadText">0 Pictures in queue..</<?php  ?>>
              </div>
            </div>

            <!-- OVERLAY IMPRESSUM PART -->
            <div class="overlay" id="overlay_impressum">
              <h1>Impressum</h1>
              <p>
                Angaben gemäß § 5 TMG

                Khadim Fall
                Spitzerstr.1
                80939 Muenchen
                Vertreten durch:
                Khadim Fall
                Kontakt:
                Telefon: 089-33089782
                E-Mail: support@priph.com

                Haftungsausschluss:

                Haftung für Inhalte

                Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen. Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.

                Haftung für Links

                Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.

                Urheberrecht

                Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet. Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.

                Datenschutz

                Die Nutzung unserer Webseite ist in der Regel ohne Angabe personenbezogener Daten möglich. Soweit auf unseren Seiten personenbezogene Daten (beispielsweise Name, Anschrift oder eMail-Adressen) erhoben werden, erfolgt dies, soweit möglich, stets auf freiwilliger Basis. Diese Daten werden ohne Ihre ausdrückliche Zustimmung nicht an Dritte weitergegeben.
                Wir weisen darauf hin, dass die Datenübertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitslücken aufweisen kann. Ein lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.
                Der Nutzung von im Rahmen der Impressumspflicht veröffentlichten Kontaktdaten durch Dritte zur Übersendung von nicht ausdrücklich angeforderter Werbung und Informationsmaterialien wird hiermit ausdrücklich widersprochen. Die Betreiber der Seiten behalten sich ausdrücklich rechtliche Schritte im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-Mails, vor.


                Google Analytics

                Diese Website benutzt Google Analytics, einen Webanalysedienst der Google Inc. (''Google''). Google Analytics verwendet sog. ''Cookies'', Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie ermöglicht. Die durch den Cookie erzeugten Informationen über Ihre Benutzung diese Website (einschließlich Ihrer IP-Adresse) wird an einen Server von Google in den USA übertragen und dort gespeichert. Google wird diese Informationen benutzen, um Ihre Nutzung der Website auszuwerten, um Reports über die Websiteaktivitäten für die Websitebetreiber zusammenzustellen und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen zu erbringen. Auch wird Google diese Informationen gegebenenfalls an Dritte übertragen, sofern dies gesetzlich vorgeschrieben oder soweit Dritte diese Daten im Auftrag von Google verarbeiten. Google wird in keinem Fall Ihre IP-Adresse mit anderen Daten der Google in Verbindung bringen. Sie können die Installation der Cookies durch eine entsprechende Einstellung Ihrer Browser Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht sämtliche Funktionen dieser Website voll umfänglich nutzen können. Durch die Nutzung dieser Website erklären Sie sich mit der Bearbeitung der über Sie erhobenen Daten durch Google in der zuvor beschriebenen Art und Weise und zu dem zuvor benannten Zweck einverstanden.
              </p>
              <a class="close" href="#intro">&#x2716;</a>
            </div>

            <!-- OVERLAY REGISTER PART -->
            <div class="overlay" id="overlay_register">
              <form id="form_register" action="index.php" method="post">
                <h1>Start now, its Free!</h1>
                <div class="errorbar"></div>
                <input class="priph" type="email" name="name" value="" placeholder="Your Email" required>
                <!--<center><div class="g-recaptcha" data-sitekey="6LcPsh0TAAAAAIIYJ1Rx0WVrYONgufSKSYerCn_3"></div></center>-->
                <button id="registerButton" type="submit">Register</button>
                <div id="registerPreloader" class="bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>
              </form>
              <a class="close" href="#intro">&#x2716;</a>
            </div>

            <!-- OVERLAY LOGIN PART -->
            <div class="overlay" id="overlay_login">
              <form id="form_login" action="index.php" method="post">
                <h1>Login</h1>
                <div class="errorbar"></div>
                <input class="priph" type="email" name="name" value="" placeholder="Email" required>
                <input class="priph" type="password" name="pass" value="" placeholder="Password" required>
                <button id="loginButton" type="submit">Login</button>
                <div id="loginPreloader" class="bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>
              </form>
              <a class="close" href="#intro">&#x2716;</a>
            </div>

            <!-- OVERLAY VERIFY PART -->
            <div class="overlay" id="overlay_verify">
              <form id="form_verify" action="index.php" method="post">
                <h1>Verify Account</h1>
                <div class="errorbar"></div>
                <input type="email" name="user" value="<?php if(isset($_GET['user'])){echo htmlspecialchars($_GET['user']);} ?>" placeholder="Email" required>
                <input type="text" pattern="[A-z0-9]{3,64}" name="verifycode" value="<?php if(isset($_GET['verify'])){echo htmlspecialchars($_GET['verify']);} ?>" placeholder="Verification-Code" required>
                <input type="text" pattern="[A-z0-9_-]{3,64}" name="displayname" value="" placeholder="Displayname" required>
                <input type="password" pattern=".{4,128}" name="pass" value="" placeholder="Password" required>
                <input type="password" pattern=".{4,128}" name="pass_wdh" value="" placeholder="Password repeat" required>
                <button id="verifyButton" type="submit">Verify now!</button>
                <div id="verifyPreloader" class="bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>
              </form>
              <a class="close" href="#intro">&#x2716;</a>
            </div>

            <!-- FOOTER -->
            <?php require 'files/footer.php'; ?>
          </div>
        </div>

        <!-- USER AREA -->
        <div id="user_slide" class="slide" data-anchor="user" style="display:none;">

          <!-- HEADER -->
          <div class="head">
            <img src="img/priph_back.png" />
            <ul>
              <!-- <li><div class="activ">Profil</div></li> -->
              <li><div id="userGalleryButton" class="activ">Gallery</div></li>
              <li><div id="userSettingsButton">Settings</div></li>
              <li><div id="userAdminButton">Admin</div></li>
            </ul>
          </div>

          <!-- GALLERY -->
          <div id="user_gallery" class="body">
            <div id="user_gallery_wrapper" class="wrapper">
              <div id="galleryRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></div>
              <div id="galleryPreloader" class="bubblingG settingsPreloader"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>
              <div id="galleryContainer" class="image_gallery cf">
                No Images uploaded yet.
              </div>
              <!-- FOOTER -->
              <?php require 'files/footer.php'; ?>
            </div>
          </div>

          <!-- SETTINGS -->
          <div id="user_settings" class="body" style="display:none;">
            <div class="wrapper user_settings">
              <div class="errorbar" style="margin: -20px 0 20px 0;"></div>

              <h1 class="priph">Display Settings</h1>
              <form id="displaysettings_form" class="settings">
                <label for="displayname">Picture(jpeg):</label>
                <input id="displaysettings_image" type="file" name="displayimage" value="" accept="image/jpeg"><br>
                <label for="displayname">Displayname:</label>
                <input class="priph" id="displaysettings_displayname" pattern="[A-z0-9_-]{3,64}" type="text" name="displayname" value=""><br>
                <div id="displaysettingsPreloader" class="bubblingG settingsPreloader"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>
                <button class="discard">Discard</button>
                <button class="save" type="submit">Save</button>
              </form>

              <h1 class="priph">Account Settings</h1>
              <form id="accountsettings_form" class="settings">
                <label for="email">Email:</label>
                <input class="priph" id="accountsettings_email" type="email" name="email" value="" disabled><br>
                <label for="pass_old">Old Password:</label>
                <input class="priph" id="accountsettings_pass_old" type="password" name="pass_old" value="" required><br>
                <label for="pass">New Password:</label>
                <input class="priph" id="accountsettings_pass" pattern=".{4,128}" type="password" name="pass" value="" required><br>
                <label for="pass2">New Password repeat:</label>
                <input class="priph" id="accountsettings_pass2" pattern=".{4,128}" type="password" name="pass2" value="" required><br>
                <div id="accountSettingsPreloader" class="bubblingG settingsPreloader"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>
                <button class="discard">Discard</button>
                <button class="save" type="submit">Save</button>
              </form>

              <h1 class="priph">Activ Sessions</h1>
              <ul id="activ_sessions">

              </ul>
              <!-- FOOTER -->
              <?php require 'files/footer.php'; ?>
            </div>
          </div>

          <!-- ADMIN -->
          <div id="user_admin" class="body" style="display:none;">
            <div id="user_admin_wrapper" class="wrapper">


              <!-- HEADLINE USERS -->
              <h1 class="priph">Manage User</h1>

              <!-- Searchbar -->
              <div class="user_searchbar">

                <!-- PAGE & ENTRIES -->
                Page:
                <select class="priph" id="admin_user_pages">
                </select>
                Entries:
                <select class="priph" id="admin_user_limit">
                  <option value="1">1</option>
                  <option value="5" selected>5</option>
                  <option value="10">10</option>
                  <option value="30">30</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                </select>

                <!-- Search -->
                <form id="user_search_form" class="searchbar" action="" method="post">
                  <select id="user_search_mode" class="priph">
                    <option value="all">All</option>
                    <option value="id">ID</option>
                    <option value="email">Email</option>
                    <option value="displayname">Displayname</option>
                  </select>
                  <input id="user_search_text" class="priph" type="text" name="name" value="">
                  <button class="priph" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                </form>
              </div>

              <!-- USER DISPLAY -->
              <div id="user_container" class="user-container">
              </div>

              <!-- FOOTER -->
              <?php require 'files/footer.php'; ?>
            </div>
          </div>

        </div>

      <!-- END OF SLIDE -->
      </div>



      <!-- INFO CONTAINER -->
      <div id="slide1" data-anchor="info" class="section">

        <!-- BACK TO TOP BUTTON -->
        <div id="less_btn" class="less_about">
          <center>
            <i class="fa fa-arrow-up" aria-hidden="true"></i>
            <p>Back to Top</p>
          </center>
        </div>

        <!-- FOOTER -->
        <?php require 'files/footer.php'; ?>
      </div>
    </div>



    <!-- REMODAL DIALOG TEMPLATE -->
    <div class="remodal" data-remodal-id="modal" data-remodal-options="hashTracking: false">
      <button data-remodal-action="close" class="remodal-close"></button>
      <h1></h1>
      <p></p>
      <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
      <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
    </div>

    <!-- OVERLAY DRAG AND DROP PART -->
    <div class="overlayArea" id="dragArea">
      <div>
        <center><p>Drag File here to upload</p></center>
      </div>
    </div>

    <!-- OVERLAY WEBCAM PART -->
    <div class="overlayArea" id="webcamArea">
      <div>

        <!-- VIDEO CONTAINER -->
        <div class="video-container">
          <!-- WEBCAM OUTPUT -->
          <video autoplay></video>
          <!-- IMAGE CANVAS -->
          <canvas class="snap-ov"></canvas>
          <!-- IMAGE -->
          <img class="snap-ov" src="" alt="" />
          <!-- UPLOAD -->
          <div class="snap-ov" id="webcamUploadOv">
            <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
            <p>
              Upload to Priph
            </p>
          </div>
        </div>

        <!-- WEBCAM BUTTONS -->
        <button id="snapshot_do" type="button">Take Snapshot</button>
        <button id="snapshot_close" type="button">Close</button>

        <!-- FOR MOBILE -->
        <input id="mobileCameraSnapshot" style="display:none;" type="file" accept="image/*;capture=camera">
      </div>
    </div>

    <!-- NOTIE -->
    <script type="text/javascript" src="js/notie.min.js"></script>
  </body>
  </html>
