document.addEventListener("DOMContentLoaded", function(event) {

  /* DEFINE STUFF */
  wrapper = document.querySelector('.wrapper');

  image = wrapper.querySelector('#image');
  author_name = wrapper.querySelector('#author_name');
  author_image = wrapper.querySelector('#author_image');
  user_image = wrapper.querySelector('#user_image');
  commentbox = wrapper.querySelector('#commentbox');
  commentform = wrapper.querySelector('.comment-form');
  commenttextbox = wrapper.querySelector('#commenttextbox');
  commentContextMenu = document.querySelector('.comment-menu');
  commentContextMenuDeleteButton = document.querySelector('#comment_delete');
  lastContextComment = false;

  commentContextMenuDeleteButton.addEventListener('click', function(e){
    var commentid = this.parentElement.dataset.commentid;
    var comment = document.querySelector('#'+this.parentElement.dataset.commentcontentid);
    comment.style.opacity ="0.3";
    $(commentContextMenu).hide(100);
    deletePictureComment(commentid,commentToken, function(data){
      if(data.error){console.log(data.error);comment.style.opacity ="1";return;}
      else if(!data.response){console.log('Unknown Error!');comment.style.opacity ="1";return;}
      comment.remove();
    });
  });

  document.addEventListener('click', function(e){
    // If the clicked element is not the menu
    if (!$(e.target).parents('.comment-menu').length > 0) {
      // Hide it
      $(commentContextMenu).hide(100);
      if(lastContextComment){lastContextComment.style.background = "";}
    }
  });

  /* LOAD USERINFO */
  loadUserInfo(function(){
    // SETUP COMMENT BAR
    setupCommentBar();

    // LOAD THE IMAGE
    if(privateImage){
      loadPrivateImage(privateImage);
    }else if (imageid) {
      loadPublicImage(imageid, verifier);
    }else{
      error("Image not found!");
    }
  });

});







// **** LOAD PRIVATE IMAGE

function loadPrivateImage(id){
  // PRIVATE IMAGE
  image.src = generatePrivateImageUrl(id);

  // LOAD AUTHOR INFO
  loadPrivateAuthorInfo(function(){

    // LOAD COMMENTS
    userGetPictureComments(id, function(data){
      // ERROR
      if(data.error){error(data.error);return;}
      if(!data.response){error('Unknown Error!');return;}

      //VARS
      realPictureId = id;
      commentToken = 0;

      // SETUP COMMENTBAR
      setupCommentBarHandler();

      // SET COMMENTS
      addCommentsToBox(data.response);

      // SET HANDLER
      addContextMenuHandler();

      // PAGE LOADED
      loaded();
    })

  });

}


// **** LOAD PUBLIC IMAGE

//VARS
// commentToken
// commentTokenRefreshInterval
// commentTokenRefresh

function loadPublicImage(id, verifier){
  publicGetShareInfo(id, verifier, function(data){
    if(data.error){error(data.error);return;}
    if(!data.response){error('Unknown Error!');return;}

    // SET AUTHOR INFO
    currentUser = data.response.author.id;
    setAuthorInfo(currentUser, data.response.author.displayname);

    // SET IMG SOURCE
    image.src = publicGeneratePictureSrc(data.response.picture_token.id, data.response.picture_token.token);

    // DO WARNING IF SINGLE TIME LINK
    if(data.response.single_time_link){/* WARNING */}

    // SETUP COMMENTS
    if(data.response.comments_enabled){

      // COMMENT TOKEN & COMMENT TOKEN UPDATE
      realPictureId = data.response.pictureid;
      commentToken = data.response.comment_token.token;
      commentTokenRefreshInterval = data.response.comment_token.valid - 10; /* 10 seconds before it expires */
      if(commentTokenRefreshInterval < 0){commentTokenRefreshInterval = 1;}
      commentTokenRefresh = setInterval(updateCommentTokenInterval, commentTokenRefreshInterval * 1000);
      window.addEventListener("beforeunload", function(e){
        deleteCommentTokenHandler();
      }, false);

      // SET COMMENTS
      setupCommentBarHandler();

    }else{/* DISABLE */}

    // COMMENTS
    if(data.response.comments){
      addCommentsToBox(data.response.comments);
    }

    // SET HANDLER
    addContextMenuHandler();


    // PAGE LOADED
    loaded();
  });
}

function updateCommentTokenInterval(){
  updateCommentToken(realPictureId, commentToken, function(data){
    if(data.error){error(data.error);return;}
    if(!data.response){error('Unknown Error!');return;}
  });
}

function deleteCommentTokenHandler(){
  deleteCommentToken(realPictureId, commentToken, function(data){
    if(data.error){error(data.error);return;}
    if(!data.response){error('Unknown Error!');return;}
  });
}

var comid = 0;
function sendComment(text){
  // commenttextbox.value = "sending..";
  // commenttextbox.disabled = true;
  var commentItem = addCommentToBox(userinfo.displayname, profilePictureUrl(userinfo.id, 26, 26), text, 'priv_com_'+comid++);
  commentItem.style.opacity = '0.3';
  addPictureComment(realPictureId, commentToken, text, function(data){
    // todo: better error display
    if(data.error){console.log(data.error);commentItem.remove();}
    else if(!data.response){console.log('Unknown Error!');commentItem.remove();}
    else{console.log(data);
      commentItem.dataset.commentid = data.response.comment_id;
      commentItem.dataset.authorid = data.response.user_id;
      addContextMenuHandler();
      commentItem.style.opacity = '1';
    }
    commenttextbox.value = "";
    commenttextbox.disabled = false;
  });
}



// **** OTHER STUFF


// PRIVATE FUNCTIONS

function loadPrivateAuthorInfo(cb){
  userInfo(function(data){
    userinfo = data.response;
    setAuthorInfo(userinfo.id, userinfo.displayname);
    cb();
  });
}

// LOAD COMMENTS
function addCommentsToBox(comments){
  for(var i = 0; i < comments.length; i++){
    var comment = comments[i];
    var commentitem = addCommentToBox(comment.displayname, profilePictureUrl(comment.user_id, 26, 26), comment.text, 'pub_com_'+comment.comment_id);
    commentitem.dataset.commentid = comment.comment_id;
    commentitem.dataset.authorid = comment.user_id;
  }
}

function addCommentToBox(author_name, author_img, content, id){
  html = generateComment(author_name, author_img, content, id);
  commentbox.innerHTML += html;
  if(id){
    return document.querySelector('#'+id);
  }else{
    return true;
  }
}

// SET AUTHOR INFO

function setAuthorInfo(id, displayname){
  author_name.innerHTML = displayname;
  author_image.src = profilePictureUrl(id, 58, 58);
}


// PAGE LOADED

function loaded(){
  $(wrapper).fadeIn(1000);
}


// SETUP COMMENTBAR
function setupCommentBarHandler(){
  // SETUP COMMENT BAR
  commenttextbox.addEventListener('keyup', function(e){
    var charCode = (typeof e.which === "number") ? e.which : e.keyCode;
    if(charCode === 13){
      sendComment(this.value);
    }
  });
}

// LOAD USERINFO

function loadUserInfo(cb){
  userInfo(function(data){
    userinfo = data.response;
    cb();
  });
}

function setupCommentBar(){
  if(userinfo){user_image.src = profilePictureUrl(userinfo.id, 26, 26);}else{commentform.style.display = 'none';}
}



// ERROR

function error(text){
  document.querySelector('.wrapper').style.display = 'none';
  document.querySelector('.error p').innerHTML = text;
  $('.error').fadeIn(1000);
}



// CREATE COMMENT

function generateComment(author_name, author_img, content, id){
  if(id){id=' id="'+id+'"';}else{id="";}
  var out = '<div class="comment">';
  out += '<div class="content"'+id+'><div class="comment-author cf"><img src="'+author_img+'" alt="" /><div>'+author_name+'</div></div><p>'+content+'</p></div></div></div>';
  return out;
}


// SHOW CONTEXT-MENU
function addContextMenuHandler(){
  var comments = document.querySelectorAll('.comment .content');
  for(var i = 0; i < comments.length; i++){
    var comment = comments[i];
    comment.oncontextmenu = commentContextHandler;
  }
}

function commentContextHandler(e){
    e.preventDefault();
    if(lastContextComment){lastContextComment.style.background = "";}
    lastContextComment = this;
    if(privateImage || this.dataset.authorid == currentUser){
      commentContextMenu.dataset.commentid = this.dataset.commentid;
      commentContextMenu.dataset.commentcontentid = this.id;
      commentContextMenu.style.top = event.pageY + "px";
      commentContextMenu.style.left = event.pageX + "px";
      $(commentContextMenu).fadeIn(100);
      this.style.background = "rgb(236, 236, 236)";
    }
}
