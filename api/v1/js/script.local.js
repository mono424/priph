/*
JS FOR PRIPH API
BY KHADIM FALL
*/

// TODO: BETTER API SECURITY

var url = "api/v1/";
var is_request = 0;
var requestLock = false;

function request(params,cb){
  if(requestLock){
    while(is_request){}
    is_request = 1;
  }
  $.get(url + "?sessionid="+sessionid + "&" + params, function( data ) {
    is_request=0;
    if(cb){cb(data);}
  }, "json" );
}

function uploadFileRequest(params, file_data, cb, upload_status){

  request('action=create-upload-token', function(data){
    if(data.error){cb(false);return;}
    var token = data.response;
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
      xhr: function(){
        var xhr = new window.XMLHttpRequest();
        //Upload progress
        xhr.upload.addEventListener("progress", function(evt){
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            if(upload_status){upload_status(percentComplete);}
          }
        }, false);
        return xhr;
      },
      url: url + "?sessionid=" + sessionid + "&token=" + token + "&" + params,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: 'post',
      success: function(data){
        if(cb){cb(data);}
      },
      done: function(data){
      },
      error: function(data){cb(false);
      }
    });
  });

}

function login(user, pass, cb){
  request('action=login&user='+user+"&pass="+pass, cb);
}

function register(email, cb){
  request('action=register&user='+email, cb);
}

function verify(email, verificationcode, password, displayname , cb){
  request('action=verify&user='+email+"&verification="+verificationcode+"&pass="+password+"&displayname="+displayname, cb);
}

function checkLogin(cb){
  request('action=loginByCookie', cb);
}

function userInfo(cb){
  request('action=user-info', cb);
}

function userGetPictures(cb){
  request('action=user-get-pictures', cb);
}

function userGetSessions(cb){
  request('action=user-get-sessions', cb);
}

function userLogout(cb){
  request('action=logout', cb);
}

function updateProfilePicture(picture, cb, upload_status){
  uploadFileRequest('action=uploadProfilePicture', picture, cb, upload_status);
}

function updateDisplayname(displayname, cb){
  request('action=user-change-displayname&displayname='+displayname, cb);
}

function updatePassword(pass, new_pass, cb){
  request('action=user-change-password&pass='+pass+'&new_pass='+new_pass, cb);
}

function uploadPicture(picture, cb, upload_status){
  uploadFileRequest('action=uploadPicture', picture, cb, upload_status);
}

function generatePrivateImageUrl(id, width, height){
  var addParams = "";
  if(width && height){addParams = "&width="+width+"&height="+height;}
  return url + "?sessionid="+sessionid + "&action=getPicture&id="+id+addParams;
}

function profilePictureUrl(user_id, width, height){
  var addParams = "";
  if(user_id){addParams = "&user=" + user_id;}
  if(width && height){addParams += "&width="+width+"&height="+height;}
  return url + "?sessionid="+sessionid + "&action=getProfilePicture"+addParams;
}

function deletePicture(id, cb){
  request('action=deletePicture&id='+id, cb);
}

function deleteSession(id, cb){
  request('action=user-session-delete&session='+id, cb);
}

function generateShareInfo(picture, toUser, comments, singleTimeLink, cb){
  request('action=user-generate-share-info&picture='+picture+'&to-user='+toUser+"&comments="+comments+"&single-time-link="+singleTimeLink, cb);
}



/* ADMIN FUNCTIONS */

function admin_getUsers(page, limit, id, email, displayname, cb){
  var addParams = "";
  if(id){addParams += "&user=" + id;}
  if(email){addParams += "&email=" + email;}
  if(displayname){addParams += "&displayname=" + displayname;}
  request('action=admin-get-user&page='+page+"&limit="+limit+addParams, cb);
}

function admin_lockUser(user, cb){
  request('action=admin-lock-user&user='+user, cb);
}

function admin_unlockUser(user, cb){
  request('action=admin-unlock-user&user='+user, cb);
}

function admin_giveAdminRights(user, cb){
  request('action=admin-give-admin-rights&user='+user, cb);
}

function admin_stripAdminRights(user, cb){
  request('action=admin-strip-admin-rights&user='+user, cb);
}

function admin_deauthUser(user, cb){
  request('action=admin-deauth-user&user='+user, cb);
}

function admin_deleteUser(user, cb){
  request('action=admin-delete-user&user='+user, cb);
}
