
/*  --------------------------------------------------------------
DOM CONTENT LOADED // DEFINE VARS AND HANDLER
-------------------------------------------------------------- */
var user_id, email, username, imgsrc, is_admin;

function defineStuff() {
  /* FROM START*/
  backgroundVideo = document.querySelector("#backgroundVideo");
  registerButton = document.querySelector("#btn-register");
  loginButton = document.querySelector("#btn-login");
  skinButton = document.querySelector("#skinButton");
  closeButtons = document.querySelectorAll(".close");
  registerButton.addEventListener('click', registerButtonHandler);
  loginButton.addEventListener('click', loginButtonHandler);
  skinButton.addEventListener('click', skinButtonHandler);
  for(var i = 0;i<closeButtons.length;i++){
    closeButtons[i].addEventListener('click',closeButtonHandler);
  }

  /* OVERLAY FOOTER */
  overlayFooter = document.querySelector('.intro-overlay .footer');

  /* UPLOAD PROGRESS */
  uploadStatus = document.querySelector('#uploadStatus');
  uploadText = document.querySelector('#uploadText');
  uploadCircle = document.querySelector('#uploadCircle');
  $(uploadCircle).circleProgress({
    value: 0,
    size: 50,
    animation: false,
    fill: {
      gradient: ["rgba(212, 250, 255, 0.8)", "rgba(212, 250, 255, 0.4)"]
    }
  });

  /* ADMIN STUFF */
  adminUserSearchForm = document.querySelector('#user_search_form');
  adminUserPageSelect = document.querySelector('#admin_user_pages');
  adminUserLimitSelect = document.querySelector('#admin_user_limit');
  adminUserSearchMode = document.querySelector('#user_search_mode');
  adminUserSearchText = document.querySelector('#user_search_text');
  adminUserContainer = document.querySelector('#user_container');
  adminUserPageSelect.addEventListener('change', adminUserPageSelectChange);
  adminUserSearchForm.addEventListener('submit', adminUserSearchFormSubmitHandler);

  /* LOGO */
  logo = document.querySelector("#logo");

  /* UPLOAD OVERLAY */
  upload_overlay = document.querySelector("#upload-overlay");

  /* SESSIONS */
  active_sessions = document.querySelector("#activ_sessions");

  /* GALLERY */
  galleryContainer = document.querySelector("#galleryContainer");
  galleryRefresh = document.querySelector("#galleryRefresh");
  galleryRefresh.addEventListener('click', galleryRefreshHandler);

  /* UPLOAD IMAGE & WEBCAM*/
  uploadPictureBtn = document.querySelector("#upload_picture_btn");
  uploadDragArea = document.querySelector("#dragArea");
  webcamSnapshotBtn = document.querySelector("#webcam_snapshot_btn");
  webcamSnapshotArea = document.querySelector("#webcamArea");
  webcamSnapshotVideo = document.querySelector('#webcamArea video');
  uploadPictureInput = document.querySelector("#upload_picture");
  snapshotDoBtn = document.querySelector('#snapshot_do');
  snapshotCloseBtn = document.querySelector('#snapshot_close');
  snapshotCanvas = document.querySelector('#webcamArea canvas');
  snapshotImage = document.querySelector('#webcamArea img');
  webcamUploadOv = document.querySelector('#webcamUploadOv');
  mobileCameraSnapshot = document.querySelector('#mobileCameraSnapshot');
  uploadPictureBtn.addEventListener('click', uploadPictureHandler);
  webcamSnapshotBtn.addEventListener('click', webcamSnapshotHandler);
  document.addEventListener('dragenter', documentDragenterHandler);
  document.addEventListener('dragleave', documentDragleaveHandler);
  uploadDragArea.addEventListener('dragover', uploadDragAreaDragoverHandler);
  uploadDragArea.addEventListener('drop', uploadDragAreaDropHandler);
  snapshotDoBtn.addEventListener('click', snapshotDoBtnHandler);
  snapshotCloseBtn.addEventListener('click', snapshotCloseBtnHandler);
  webcamUploadOv.addEventListener('click', snapshotUploadBtnHandler);

  /* DISPLAY SETTINGS */
  userSettingsErrorBar = document.querySelector("#user_settings .errorbar");
  displaySettingsForm = document.querySelector('#displaysettings_form');
  displaySettingsName = document.querySelector('#displaysettings_displayname');
  displaySettingsImage = document.querySelector('#displaysettings_image');
  displaySettingsPreloader = document.querySelector('#displaysettingsPreloader');
  displaySettingsSave = displaySettingsForm.querySelector('.save');
  displaySettingsDiscard = displaySettingsForm.querySelector('.discard');
  displaySettingsForm.addEventListener('submit', displaySettingsSubmitHandler);
  displaySettingsImage.addEventListener('change', validateProfileImage);

  /* ACCOUNT SETTINGS */
  accountSettingsForm = document.querySelector('#accountsettings_form');
  accountSettingsEmail = document.querySelector('#accountsettings_email');
  accountSettingsPassOld = document.querySelector('#accountsettings_pass_old');
  accountSettingsPass = document.querySelector('#accountsettings_pass');
  accountSettingsPass2 = document.querySelector('#accountsettings_pass2');
  accountSettingsPreloader = document.querySelector('#accountSettingsPreloader');
  accountSettingsSave = accountSettingsForm.querySelector('.save');
  accountSettingsDiscard = accountSettingsForm.querySelector('.discard');
  accountSettingsForm.addEventListener('submit', accountSettingsSubmitHandler);

  /* USER SLIDE */
  userSlide = document.querySelector('#user_slide');
  userGalleryButton = document.querySelector('#userGalleryButton');
  userSettingsButton = document.querySelector('#userSettingsButton');
  userAdminButton = document.querySelector('#userAdminButton');
  userSlideBackButton = userSlide.querySelector('.head img');
  userSlideBackButton.addEventListener('click', userSlideBackButtonHandler);
  userGalleryButton.addEventListener('click', userGalleryButtonHandler);
  userSettingsButton.addEventListener('click', userSettingsButtonHandler);
  userAdminButton.addEventListener('click', userAdminButtonHandler);

  /* INFO SLIDE */
  infoSlide = document.querySelector('#slide1');

  /* HOME MENU */
  logoutButton = document.querySelector('#logoutButton');
  logoutButton.addEventListener('click', logoutButtonHandler);

  /* MORE LESS INFO BUTTON*/
  moreButton = document.querySelector('#more_btn');
  lessButton = document.querySelector('#less_btn');
  moreButton.addEventListener('click', moreButtonHandler);
  lessButton.addEventListener('click', lessButtonHandler);


  /* USER OVERLAY */
  userOverlayDisplay = document.querySelector('#user-overlay .display');
  userOverlayDisplayWelcome = userOverlayDisplay.querySelector('.welcome');
  userOverlayDisplayImage = userOverlayDisplay.querySelector('img');
  userOverlayDisplay.addEventListener('click', userOverlayDisplayClickHandler);

  /* LOGIN STUFF */
  loginButton = document.querySelector("#loginButton");
  loginPreloader = document.querySelector("#loginPreloader");
  loginForm = document.querySelector("#form_login");
  loginUserbox = loginForm.querySelectorAll('input')[0];
  loginPassbox = loginForm.querySelectorAll('input')[1];
  loginErrorbar = loginForm.querySelector('.errorbar');
  loginForm.addEventListener('submit', loginHandler);

  /* REGISTER STUFF */
  registerButton = document.querySelector("#registerButton");
  registerPreloader = document.querySelector("#registerPreloader");
  registerForm = document.querySelector("#form_register");
  registerUserbox = registerForm.querySelectorAll('input')[0];
  registerErrorbar = registerForm.querySelector('.errorbar');
  registerForm.addEventListener('submit', registerHandler);

  /* VERIFY STUFF*/
  verifyButton = document.querySelector("#verifyButton");
  verifyPreloader = document.querySelector("#verifyPreloader");
  verifyForm = document.querySelector("#form_verify");
  verifyUserbox = verifyForm.querySelectorAll('input')[0];
  verifyCodebox = verifyForm.querySelectorAll('input')[1];
  verifyDisplaynamebox = verifyForm.querySelectorAll('input')[2];
  verifyPassbox = verifyForm.querySelectorAll('input')[3];
  verifyPassbox2 = verifyForm.querySelectorAll('input')[4];
  verifyErrorbar = verifyForm.querySelector('.errorbar');
  verifyForm.addEventListener('submit', verifyHandler);
  verifyPassbox.addEventListener('change', verifyValidatePassword);
  verifyPassbox2.addEventListener('keyup', verifyValidatePassword);

  /* CHECK IF LOGGED IN BY COOKIE */
  refreshUserInfo(true);
}


/*  --------------------------------------------------------------
HANDLER DEFINED HERE AND RELEVANT FUNCTIONS
-------------------------------------------------------------- */

/* UPLOAD QUEUE SYSTEM */

var uploadFileQueue = [];
var uploadFileBusy;
function addToUploadQueue(file){
  uploadFileQueue.push(file);
  refreshQueue();
}

function refreshQueue(){
  if(!uploadFileBusy){
    if(uploadFileQueue && uploadFileQueue.length > 0){
      uploadStatusVisible(true);
      uploadStatusUpdate(0,uploadFileQueue.length);
      startNextUpload();
    }else {
      uploadStatusVisible(false);
    }
  }
  uploadStatusUpdate(false,uploadFileQueue.length);
}

function startNextUpload(){
  uploadFileBusy = true;
  var file = uploadFileQueue[0];
  uploadFileQueue.shift();
  if(file.type=="image/jpeg" || (typeof file.type == 'undefined')){
    uploadPicture(file, function(data){console.log(data);
      if(data.error){notie.alert(3,data.error,2);}
      else if(!data){notie.alert(3,'Unknown Error occured!',2);}
      else{notie.alert(1, 'Picture uploaded successful!', 2);}
      galleryLoad();
      uploadFileBusy = false;
      refreshQueue();
    },function(status){
      uploadStatusUpdate(status, false)
    });
  }else{
    notie.alert(3,'Currently only JPEG-Images allowed!',2);
    uploadFileBusy = false;
    refreshQueue();
  }
}

function uploadStatusUpdate(current, queue){
  if(current!==false){$(uploadCircle).circleProgress('value', current);}
  if(queue!==false){uploadText.innerHTML = queue+" Pictures in queue..";}
}

function uploadStatusVisible(state){
  if(state){$(uploadStatus).fadeIn('slow');}else{$(uploadStatus).fadeOut('slow');}
}



/* DRAG AND DROP */

function documentDragenterHandler(e){
  // CHECK IF LOGGED IN
  if(!user_id){return;}
  $(uploadDragArea).fadeIn('fast');
}

function documentDragleaveHandler(e){
  if(e.screenX == 0 && e.screenY == 0){
    $(uploadDragArea).fadeOut('fast');
  }
}

function uploadDragAreaDragoverHandler(e){
  e.preventDefault();
  /* TODO: MAYBE SOME FILE CHECK */
}

function uploadDragAreaDropHandler(e){
  e.preventDefault();
  $(uploadDragArea).fadeOut('fast');
  var files = e.dataTransfer.files;
  for (var i=0; i<files.length; i++) {
    var file = files[i];
    addToUploadQueue(file);
  }
}


/* ADMIN STUFF*/

var adminUserSearchCurrentPage;
var adminUserSearchCurrentLimit;
var adminUserSearchCurrentId;
var adminUserSearchCurrentEmail;
var adminUserSearchCurrentName;
function adminUserSearchFormSubmitHandler(e){
  e.preventDefault()
  if(!adminUserSearchCurrentPage){adminUserSearchCurrentPage = 1;}
  if(adminUserSearchCurrentLimit != adminUserLimitSelect.value){
    adminUserSearchCurrentLimit = adminUserLimitSelect.value;
    adminUserSearchCurrentPage = 1; /* OTHERWISE MAYBE BUGGY!! */
  }
  adminUserPageSelect.innerHTML = "";
  adminUserContainer.innerHTML = "";

  adminUserSearchCurrentId = false;
  adminUserSearchCurrentEmail = false;
  adminUserSearchCurrentName = false;
  if(adminUserSearchText.value){
    if(adminUserSearchMode.value == "all"){
      adminUserSearchCurrentId = adminUserSearchText.value;
      adminUserSearchCurrentEmail = adminUserSearchText.value;
      adminUserSearchCurrentName = adminUserSearchText.value;
    }else if(adminUserSearchMode.value == "id"){
      adminUserSearchCurrentId = adminUserSearchText.value;
    }else if(adminUserSearchMode.value == "email"){
      adminUserSearchCurrentEmail = adminUserSearchText.value;
    }else if(adminUserSearchMode.value == "displayname"){
      adminUserSearchCurrentName = adminUserSearchText.value;
    }
  }

  admin_getUsers(adminUserSearchCurrentPage, adminUserSearchCurrentLimit, adminUserSearchCurrentId, adminUserSearchCurrentEmail, adminUserSearchCurrentName, adminRefreshUsers);
}

function adminUserPageSelectChange(e){
  adminUserSearchCurrentPage = adminUserPageSelect.value;
  adminUserPageSelect.innerHTML = "";
  adminUserContainer.innerHTML = "";
  admin_getUsers(adminUserSearchCurrentPage, adminUserSearchCurrentLimit, adminUserSearchCurrentId, adminUserSearchCurrentEmail, adminUserSearchCurrentName, adminRefreshUsers);
}

function adminRefreshUsers(data){
  adminUserPageSelect.innerHTML = "";
  adminUserContainer.innerHTML = "";
  if(data.error){notie.alert(3, data.error, 2);}
  else if(!data.response){notie.alert(3, 'Unknown error occured!', 2);}
  for(var i=1;i<=data.response.pages;i++){
    var selected = "";
    if(i == adminUserSearchCurrentPage){selected = " selected";}
    adminUserPageSelect.innerHTML += '<option value="'+i+'"'+selected+'>'+i+'</option>';
  }
  if(data.response.user.length){
    for(var i=0;i<data.response.user.length;i++){
      adminUserContainer.innerHTML += createAdminUserItem(data.response.user[i]);
    }
  }else{
    adminUserContainer.innerHTML += "<center>No Users found!</center>";
  }

}

function galleryRefreshHandler(e){
  galleryLoad();
}

function moreButtonHandler(e){
  $('#fullpage').fullpage.moveTo(2);
}

function lessButtonHandler(e){
  $('#fullpage').fullpage.moveTo(1);
}


function uploadPictureHandler(e){
  uploadPictureInput.onchange = function(){
    addToUploadQueue(uploadPictureInput.files[0]);
  }
  uploadPictureInput.click();
}


/* WEBCAM STUFF */

function snapshotUploadBtnHandler(e){
  // DISABLED ATM
  // notie.alert(4, 'Not available atm!', 3);return;
  addToUploadQueue(snapshotImage.src);
  resetSnaptshot();
}




var webcamstream;
var newPhoto=false;

function snapshotDoBtnHandler(e){
  if(newPhoto){
    resetSnaptshot();
  }else{
    snapshotCanvas.style.opacity = "1";
    snapshotImage.style.opacity = "1";
    webcamUploadOv.style.display = "block";
    // set the canvas to the dimensions of the video
    snapshotCanvas.width = webcamSnapshotVideo.clientWidth;
    snapshotCanvas.height = webcamSnapshotVideo.clientHeight;
    // COPY IMAGE
    snapshotCanvas.getContext('2d').drawImage(webcamSnapshotVideo,0,0);
    var data = snapshotCanvas.toDataURL('image/jpeg');
    var dataURL = snapshotCanvas.toDataURL();
    snapshotImage.setAttribute('src', data);
    // CHANGE BUTTON
    snapshotDoBtn.innerHTML = "New Photo";
    newPhoto=true;
  }
}

function resetSnaptshot(){
  snapshotCanvas.style.opacity = "0";
  snapshotImage.style.opacity = "0";
  webcamUploadOv.style.display = "none";
  snapshotDoBtn.innerHTML = "Take Snapshot";
  newPhoto=false;
}

function snapshotCloseBtnHandler(e){
  webcamstream.getVideoTracks()[0].stop();
  $(webcamSnapshotArea).fadeOut(200);
}

var videosettings = {
  "audio": false,
  "video": {
    "mandatory": {
      "minWidth": 320,
      "maxWidth": 1280,
      "minHeight": 180,
      "maxHeight": 720,
      "minFrameRate": 30
    },
    "optional": []
  }
};

function webcamSnapshotHandler(e){
  // DISABLED ATM
  //notie.alert(4, 'Not available atm!', 3);return;

  // IF MOBILE
  if(checkMobile()){
    mobileCameraSnapshot.click();return;
  }

  resetSnaptshot();
  var onFail = function(){notie.alert(3, 'Unknown Error!', 3);}
  if (hasGetUserMedia()) {
    if (navigator.getUserMedia) {
      navigator.getUserMedia(videosettings, function(stream) {
        webcamstream = stream;
        webcamSnapshotVideo.src = stream;
        $(webcamSnapshotArea).fadeIn(200);
      }, onFail);
    } else if (navigator.webkitGetUserMedia) {
      navigator.webkitGetUserMedia(videosettings, function(stream) {
        webcamstream = stream;
        webcamSnapshotVideo.src = window.URL.createObjectURL(stream);
        $(webcamSnapshotArea).fadeIn(200);
      }, onFail);
    } else {
      notie.alert(3, 'Unknown Error!', 3);
    }
  } else {
    notie.alert(3, 'getUserMedia() is not supported in your browser', 3);
  }
}




function displaySettingsSubmitHandler(e){
  e.preventDefault();
  var imageUploadFinished = false;
  var changeNameFinished = false;

  if(displaySettingsImage.files[0]){
    displaySettingsPreloaderVisible(true);
    updateProfilePicture(displaySettingsImage.files[0], function(data){
      imageUploadFinished = true;
      if(changeNameFinished){
        displaySettingsImage.value = "";
        refreshUserInfo();
        displaySettingsPreloaderVisible(false);
        if(data.error){notie.alert(3, data.error, 2);}
        else if(!data.response){notie.alert(3, 'Unknown error occured!', 2);}
        else{notie.alert(1, 'Account settings updated!', 2);}
      }
    });
  }else{imageUploadFinished = true;}

  if(username != displaySettingsName.value){
    displaySettingsPreloaderVisible(true);
    updateDisplayname(displaySettingsName.value, function(data){
      changeNameFinished = true;
      if(imageUploadFinished){
        refreshUserInfo();
        displaySettingsPreloaderVisible(false);
        if(data.error){notie.alert(3, data.error, 2);}
        else if(!data.response){notie.alert(3, 'Unknown error occured!', 2);}
        else{notie.alert(1, 'Account settings updated!', 2);}
      }
    });
  }else{changeNameFinished = true;}

}

function accountSettingsSubmitHandler(e){
  e.preventDefault();
  if(accountSettingsPass.value == accountSettingsPass2.value){
    accountSettingsPreloaderVisible(true);
    updatePassword(accountSettingsPassOld.value, accountSettingsPass.value, function(data){console.log(data);
      if(data.error){
        notie.alert(3, data.error, 2);
      }else{
        accountSettingsPassOld.value = "";
        accountSettingsPass.value = "";
        accountSettingsPass2.value = "";
        notie.alert(1, 'Account Password updated!', 2);
      }
      accountSettingsPreloaderVisible(false);
    });
  }else{notie.alert(3, "Passwords don't match!", 2);}
}

function userGalleryButtonHandler(e){
  userpage_select('gallery');
}

function userSettingsButtonHandler(e){
  userpage_select('settings');
}

function userAdminButtonHandler(e){
  userpage_select('admin');
}

function userSlideBackButtonHandler(e){
  $('#fullpage').fullpage.moveTo('intro', 0);
}

function userOverlayDisplayClickHandler(e){
  $('#fullpage').fullpage.moveTo('intro', 'user');
}

function logoutButtonHandler(e){
  userLogout(function(data){
    location.reload();
  });
}

function userPageHandler(focus){
  if(focus){
    infoSlide.style.display = "none";
  }else{
    infoSlide.style.display = "block";
  }
}

function loginHandler(e){
  e.preventDefault();
  loginButton.style.display = "none";
  loginErrorbar.style.display = "none";
  loginPreloader.style.display = "block";
  login(loginUserbox.value, loginPassbox.value, function(data){
    if(data.error){
      // ERROR
      loginErrorbar.style.display = "block";
      loginErrorbar.innerHTML = data.error;
    }else if(!data.response){
      /* ERROR */
      loginErrorbar.style.display = "block";
      loginErrorbar.innerHTML = "Wrong Username or Password!";
    } else {
      // LOGIN SUCCESSFUL !!
      refreshUserInfo(true);
      overlay_select("main");
    }
    loginButton.style.display = "block";
    loginPreloader.style.display = "none";
  });
}

function registerHandler(e){
  e.preventDefault();
  registerButton.style.display = "none";
  registerErrorbar.style.display = "none";
  registerPreloader.style.display = "block";
  register(registerUserbox.value, function(data){
    if(data.error){
      // REGISTATION FAILED !!
      registerErrorbar.style.display = "block";
      registerErrorbar.innerHTML = data.error;
      registerButton.style.display = "block";
      registerPreloader.style.display = "none";
    }else{
      // REGISTATION SUCCESSFUL !!
      overlay_select("verify");
      verifyUserbox.value = registerUserbox.value;
    }
  });
}


function verifyHandler(e){
  e.preventDefault();
  verifyButton.style.display = "none";
  verifyErrorbar.style.display = "none";
  verifyPreloader.style.display = "block";
  verify(verifyUserbox.value, verifyCodebox.value, verifyPassbox.value, verifyDisplaynamebox.value, function(data){
    if(data.error){
      // VERIFICATION FAILED !!
      verifyErrorbar.style.display = "block";
      verifyErrorbar.innerHTML = data.error;
    }else{
      // VERIFICATION SUCCESSFUL !!
      overlay_select("login");
    }
    verifyButton.style.display = "block";
    verifyPreloader.style.display = "none";
  });
}

function verifyValidatePassword(){
  if(verifyPassbox.value != verifyPassbox2.value){
    verifyPassbox2.setCustomValidity("Passwords don't Match");
  }else{
    verifyPassbox2.setCustomValidity("");
  }
}

function validateProfileImage(){
  if(displaySettingsImage.files[0]){
    if(displaySettingsImage.files[0].type != "image/jpeg"){
      displaySettingsImage.setCustomValidity("Only jpeg is supported!");
      return;
    }
    if(!displaySettingsImage.files[0].name.match('\.(jpeg|jpg)$')){
      displaySettingsImage.setCustomValidity("Only jpeg is supported!");
      return;
    }
  }
  displaySettingsImage.setCustomValidity("");
}

function displaySettingsPreloaderVisible(state){
  if(state){
    displaySettingsDiscard.style.display = "none";
    displaySettingsSave.style.display = "none";
    displaySettingsPreloader.style.display = "block";
  }else{
    displaySettingsDiscard.style.display = "block";
    displaySettingsSave.style.display = "block";
    displaySettingsPreloader.style.display = "none";
  }
}

function accountSettingsPreloaderVisible(state){
  if(state){
    accountSettingsDiscard.style.display = "none";
    accountSettingsSave.style.display = "none";
    accountSettingsPreloader.style.display = "block";
  }else{
    accountSettingsDiscard.style.display = "block";
    accountSettingsSave.style.display = "block";
    accountSettingsPreloader.style.display = "none";
  }
}

function userSettingsError(error){
  if(error){
    userSettingsErrorBar.style.display = "block";
    userSettingsErrorBar.innerHTML = error;
  }else{
    userSettingsErrorBar.style.display = "none";
    userSettingsErrorBar.innerHTML = "";
  }
}



/*  --------------------------------------------------------------
USERMENU & USERSLIDE FUNCTIONS GOIN HERE
-------------------------------------------------------------- */

function refreshUserInfo(loadGallery){
  // GET USER INFO AND DISPLAY USER OVERLAY
  userInfo(function(data){
    if(data.error || !data.response){
      logo.className = "logo logo-alone";
      $('#user-overlay').delay(100).fadeOut('slow');
      $('#upload-overlay').delay(100).fadeOut('slow');
      $('#loginmenu-overlay').delay(300).fadeIn('slow');
      $('#more_btn').delay(300).fadeIn('slow');
      setTimeout(function(){
        username = "";
        imgsrc = "";
        email = "";
        is_admin = false;
        userOverlayDisplayImage.src = "";
        userOverlayDisplayWelcome.innerHTML = "";
      },3000);
    }else{
      // HIDE LOGIN / REGISTER - BUTTON
      logo.className = "logo";
      $('#loginmenu-overlay').delay(100).fadeOut('slow');
      $('#more_btn').delay(100).fadeOut('slow');
      user_id = data.response.id;
      username = data.response.displayname;
      imgsrc = profilePictureUrl(false,58,58) + "&cacheBreaker=" + new Date().getTime();
      email = data.response.email;
      if(data.response.is_admin == "1"){is_admin = true;}else{is_admin = false;}
      userOverlayDisplayWelcome.innerHTML = "Hello, " + username;
      userOverlayDisplayImage.src = imgsrc;

      userSlide.style.display = "block";
      $('#user-overlay').delay(300).fadeIn('slow');
      $('#upload-overlay').delay(300).fadeIn('slow');
      $(overlayFooter).delay(300).fadeIn('slow');
      infoSlide.remove();

      if(!is_admin){
        userAdminButton.remove();
      }

      if(loadGallery){galleryLoad();}

      displaySettingsName.value = username;
      accountSettingsEmail.value = email;

      updateSession();
    }
    $.fn.fullpage.reBuild();
  });
}

function updateSession(){
  active_sessions.innerHTML = "";
  userGetSessions(function(data){
    if(data.error){notie.alert(3, data.error, 2);}
    else if(!data.response){notie.alert(3, 'Unknown error occured!', 2);}
    for(var i=0;i<data.response.length;i++){
      var session = data.response[i];
      var sessionText = session.session.substr(0,16)+"...";
      var current = (session.token) ? true : false;
      var html = "<li><div class=\"item\">";
      html     += "   <div class=\"key\"><span>Indentefier:</div>";
      html     += "   <div class=\"value\">"+sessionText+"</div>";
      html     += "</div>";
      html     += "<div class=\"item\">";
      html     += "   <div class=\"key\">Browser:</div>";
      html     += "   <div class=\"value\">"+session.browser+"</div>";
      html     += "</div>";
      html     += "<div class=\"item\">";
      html     += "   <div class=\"key\">IP-Address:</div>";
      html     += "   <div class=\"value\">"+session.ip+"</div>";
      html     += "</div>";
      html     += "<div class=\"item\">";
      html     += "   <div class=\"key\">Last-Update:</div>";
      html     += "   <div class=\"value\">"+session.last_update+"</div>";
      html     += "</div>";
      if(current){
        html   += "<div class=\"session_current\">Current</div>";
      }
      html     += "<div onclick=\"delete_session('"+session.session+"');\" class=\"delete-session\">";
      html     += "   <i class=\"fa fa-ban\" aria-hidden=\"true\"></i>";
      html     += "</div>";
      html     += "</li>";

      active_sessions.innerHTML += html;
    }
  });
}

function delete_session(session){
  var sessionText = session.substr(0,16)+"...";
  niceConfirm('Really?','Sure you want to delete User-Session: '+sessionText+"?",function(){
    deleteSession(session,function(data){
      if(data.error){notie.alert(3, data.error, 2);}
      else if(!data.response){notie.alert(3, 'Unknown error occured!', 2);}
      else{notie.alert(1, 'Session deleted successful!', 2);}
      updateSession();
    });
  });
}

function userpage_select(page){
  switch(page){
    case "admin":
    $('#user_gallery').delay(100).fadeOut('fast');
    $('#user_settings').delay(100).fadeOut('fast');
    $('#user_admin').delay(350).fadeIn('slow');
    userAdminButton.className = "activ";
    userGalleryButton.className = "";
    userSettingsButton.className = "";
    break;

    case "settings":
    if(is_admin){$('#user_admin').delay(100).fadeOut('fast');}
    $('#user_gallery').delay(100).fadeOut('fast');
    $('#user_settings').delay(350).fadeIn('slow');
    if(is_admin){userAdminButton.className = "";}
    userGalleryButton.className = "";
    userSettingsButton.className = "activ";
    break;

    case "gallery":
    default:
    if(is_admin){$('#user_admin').delay(100).fadeOut('fast');}
    $('#user_settings').delay(100).fadeOut('fast');
    $('#user_gallery').delay(350).fadeIn('slow');
    if(is_admin){userAdminButton.className = "";}
    userSettingsButton.className = "";
    userGalleryButton.className = "activ";
  }
}

function createAdminUserItem(user){
  var adminclass = getAdminClass(user.admin);
  var adminrev;if(user.admin=="1" || user.admin==true){adminrev = false;}else{adminrev = true;}

  var blockclass = getBlockClass(user.blocked);
  var blocktext = getBlockText(user.blocked);
  var blockrev;if(user.blocked=="1" || user.blocked==true){blockrev = false;}else{blockrev = true;}

  var html = '<div class="user-item cf">';
  html    += '<img src="'+profilePictureUrl(user.id,58,58)+'" alt="" />';
  html    += '<ul>';
  html    += '<li><span>ID:</span> <div>'+user.id+'</div></li>';
  html    += '<li><span>Name:</span> <div title="'+user.displayname+'">'+cutString(user.displayname,9)+'</div> <!--<i class="fa fa-pencil btn" aria-hidden="true"></i>--></li>';
  html    += '</ul>';
  html    += '<ul>';
  html    += '<li><span>Email:</span> <div title="'+user.email+'">'+cutString(user.email,9)+'</div> <!--<i class="fa fa-pencil btn" aria-hidden="true"></i>--></li>';
  html    += '<li><span>Reg.:</span> <div title="'+user.created+'">'+user.created.split(' ')[0]+'</div></li>';
  html    += '</ul>';
  html    += '<ul>';
  html    += '<li class="btn" onclick="deauthUser(this,'+user.id+');"><i class="fa fa-chain-broken" aria-hidden="true"></i> <span>Deauth</span></li>';
  html    += '<li class="btn" onclick="adminRights(this,'+user.id+','+adminrev+');"><i class="'+adminclass+'" aria-hidden="true"></i> <span>Admin</span></li>';
  html    += '</ul>';
  html    += '<ul>';
  html    += '<li class="btn danger" onclick="lockUser(this,'+user.id+','+blockrev+');"><i class="'+blockclass+'" aria-hidden="true"></i> <span>'+blocktext+'</span></li>';
  html    += '<li class="btn danger" onclick="deleteUser(this,'+user.id+');"><i class="fa fa-minus-circle" aria-hidden="true"></i> <span>Delete</span></li>';
  html    += '</ul>';
  html    += '</div>';
  html    += '<hr>';
  return html;
}

/* USER ITEM HANDLER */
function deauthUser(sender, user){
  niceConfirm('Deauthenticate?', 'You sure u want to DEAUTH user with id:  '+user, function(){
    admin_deauthUser(user, function(data){
      if(data.error){/* ERROR */notie.alert(3, data.error, 2);return;}
      if(!data.response){/* ERROR */notie.alert(3, 'Unknown Error!', 2);return;}
      notie.alert(1, 'User deauthenticated!', 2);
    });
  });
}

function deleteUser(sender, user){
  niceConfirm('Delete?', 'You sure u want to DELETE user with id:  '+user, function(){
    admin_deleteUser(user, function(data){console.log(data);
      if(data.error){/* ERROR */notie.alert(3, data.error, 2);return;}
      if(!data.response){/* ERROR */notie.alert(3, 'Unknown Error!', 2);return;}
      sender.parentElement.parentElement.parentElement.Remove();
      notie.alert(1, 'User deleted!', 2);
    });
  });
}

function lockUser(sender, user, state){
  if(state){var action = "Lock";}else{var action = "Unlock";}
  niceConfirm(action+'?', 'You sure u want to '+action.toUpperCase()+' user with id:  '+user, function(){
    var finish = function(data){
      if(data.error){/* ERROR */notie.alert(3, data.error, 2);return;}
      if(!data.response){/* ERROR */notie.alert(3, 'Unknown Error!', 2);return;}
      var blockclass = getBlockClass(state);
      var blocktext = getBlockText(state);
      sender.querySelector('i').className = blockclass;
      sender.querySelector('span').innerHTML = blocktext;
      sender.onclick = function(){
        lockUser(sender, user, !state);
      };
      notie.alert(1, 'User '+action+'ed!', 2);
    }

    if(state){
      admin_lockUser(user, finish);
    }else{
      admin_unlockUser(user, finish);
    }
  });
}

function adminRights(sender, user, state){
  if(state){var action = "Give Adminrights to";}else{var action = "Strip Adminrights from";}
  niceConfirm(action+'?', 'You sure u want to '+action.toUpperCase()+' user with id:  '+user, function(){
    var finish = function(data){
      if(data.error){/* ERROR */notie.alert(3, data.error, 2);return;}
      if(!data.response){/* ERROR */notie.alert(3, 'Unknown Error!', 2);return;}
      var adminclass = getAdminClass(state);
      sender.querySelector('i').className = adminclass;
      sender.onclick = function(){
        adminRights(sender, user, !state);
      };
      if(state){notie.alert(1, 'User got adminrights now!', 2);}
      if(!state){notie.alert(1, 'User got no adminrights anymore!', 2);}
    }

    if(state){
      admin_giveAdminRights(user, finish);
    }else{
      admin_stripAdminRights(user, finish);
    }
  });
}

function getAdminClass(state){
  if(state == "1" || state == true){return "fa fa-star";}else{return "fa fa-star-o";}
}

function getBlockClass(state){
  if(state == "1" || state == true){return "fa fa-lock";}else{return "fa fa-unlock";}
}

function getBlockText(state){
  if(state == "1" || state == true){return "Unlock";}else{return "Lock";}
}



function cutString(string, length){
  if(string.length > length){
    string = string.substr(0,length) + "...";
  }
  return string;
}

var inst;
function niceConfirm(title, text, success, abort){
  // VAR :P
  inst = $('[data-remodal-id=modal-dialog]').remodal();

  // SET DATA
  remodal = document.querySelector('.modal-dialog');
  remodal.querySelector('h1').innerHTML = title;
  remodal.querySelector('p').innerHTML = text;

  // CALLBACKS
  if(success){$(document).on('confirmation', '.modal-dialog', success);}
  if(abort){$(document).on('cancellation', '.modal-dialog', abort);}

  // CLEANUP ON MODAL CLOSE
  $(document).on('closed', '.modal-dialog', function (e) {
    $(document).off('confirmation', '.modal-dialog');
    $(document).off('cancellation', '.modal-dialog');
    $(document).off('closed', '.modal-dialog');
  });

  //GO!GO!GO!
  inst.open();
}


/* WEBCAM STUFF */

function hasGetUserMedia() {
  // Note: Opera builds are unprefixed.
  return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia || navigator.msGetUserMedia);
  }


/* SHARE MODAL */
function showSharePictureModal(id){
  // VAR :P
  inst = $('[data-remodal-id=modal-share]').remodal();

  // GET CONTROLS
  var remodalContent = document.querySelector('.modal-share .content');
  var remodalMenu = remodalContent.querySelector('.share-menu-wrapper');
  var remodalOut = remodalContent.querySelector('.share-output');
  var remodalPreloader = remodalContent.querySelector('.share-preloader');
  var publicShareBtn = remodalMenu.querySelector('#public-share');
  var priphShareBtn = remodalMenu.querySelector('#priph-share');
  var onetimeShareBtn = remodalMenu.querySelector('#onetime-share');
  var remodelOutInput = remodalOut.querySelector('#output-share-link');
  var remodelOutShortInput = remodalOut.querySelector('#output-share-link-short');

  // SHOW RIGHT THINGS :P
  remodalMenu.style.display = "block";
  remodalOut.style.display = "none";
  remodalPreloader.style.display = "none";

  // SOME HANDLER STUFF
  publicShareBtn.onclick = function(){
    remodalMenu.style.display = "none";
    remodalPreloader.style.display = "block";
    generateShareInfo(id, 0, 1, 0, function(data){
        shareLinkCallback(data, remodelOutInput, remodelOutShortInput);
        remodalOut.style.display = "block";
        remodalPreloader.style.display = "none";
    });
  };
  priphShareBtn.onclick = function(){
    notie.alert(4, 'Not available atm!', 3);
  };
  onetimeShareBtn.onclick = function(){
    remodalMenu.style.display = "none";
    remodalPreloader.style.display = "block";
    generateShareInfo(id, 0, 1, 1, function(data){
        shareLinkCallback(data, remodelOutInput, remodelOutShortInput);
        remodalOut.style.display = "block";
        remodalPreloader.style.display = "none";
    });
  };

  // CLEANUP ON MODAL CLOSE
  $(document).on('closed', '.modal-share', function (e) {
    $(document).off('closed', '.modal-share');
  });

  //GO!GO!GO!
  inst.open();
}

function shareLinkCallback(data, input, shortInput){
  if(data.error){/* ERROR */notie.alert(3, data.error, 2);return;}
  if(!data.response){/* ERROR */notie.alert(3, 'Unknown Error!', 2);return;}
  var link = "https://priph.com/share.php?image="+data.response.id+"&verifier="+data.response.verifier;
  input.value = link;
  shortInput.value = "loading..";
  shortLink(link, function(data){
    if(data.error || !data.response){shortInput.value = "Priph couldnt create a shortlink :(";return;}
    shortInput.value = data.response;
  });
}



// SKIN CHANGE
function select_skin(sender, skin, mp4, webm){
  var allskins = document.querySelectorAll('.skin .image');
  for(var i=0;i<allskins.length;i++){
    allskins[i].className = "image";
  }
  sender.className += " selected";
  load_skin(skin, mp4, webm);
}

function load_skin(skin, mp4, webm){
  backgroundVideo.setAttribute('poster','skin/' + skin + "/poster.jpg");
  backgroundVideo.innerHTML = "";
  var video = false;
  if(mp4){backgroundVideo.innerHTML += '<source src="skin/'+skin+'/video.mp4" type="video/mp4" />';video = true;}
  if(webm){backgroundVideo.innerHTML += '<source src="skin/'+skin+'/video.webm" type="video/webm" />';video = true;}

  if(webm){
    backgroundVideo.setAttribute('src','skin/'+skin+'/video.webm');
  }else if (mp4) {
    backgroundVideo.setAttribute('src','skin/'+skin+'/video.mp4');
  }

  initBackground(video);

  // set cookie :)
  if(video){
    var skintype = "video";
  }else{
    var skintype = "picture";
  }
  $.get("php/setSkin.php?sessionid="+sessionid+"&skin="+skin+"&skin_type="+skintype);
}

function initBackground(videoSkin){
  if(!videoSkin || checkMobile()){
    backgroundVideo.parentElement.style.background="url("+backgroundVideo.poster+") 50% 50%";
    backgroundVideo.parentElement.style.backgroundSize="cover";
    backgroundVideo.innerHTML = "";
    backgroundVideo.style.display = "none"
  }else{
    backgroundVideo.style.display = "block"
  }
}
