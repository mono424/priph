document.addEventListener("DOMContentLoaded", function(event) {

  /* DEFINE STUFF */
  wrapper = document.querySelectorAll('.wrapper');

  image = wrapper[0].querySelector('#image');
  author_name = wrapper[0].querySelector('#author_name');
  author_image = wrapper[0].querySelector('#author_image');
  user_image = wrapper[0].querySelector('#user_image');
  commentbox = wrapper[0].querySelector('#commentbox');
  commentform = wrapper[0].querySelector('.comment-form');
  commenttextbox = wrapper[0].querySelector('#commenttextbox');
  commentContextMenu = document.querySelector('.comment-menu');
  commentContextMenuDeleteButton = document.querySelector('#comment_delete');
  sharelinkContextMenu = document.querySelector('.sharelink-menu');
  sharelinkContextMenuOpenButton = document.querySelector('#sharelink_open');
  sharelinkContextMenuCopyButton = document.querySelector('#sharelink_copy');
  sharelinkContextMenuDeleteButton = document.querySelector('#sharelink_delete');
  sharelinkContainer = document.querySelector('#sharelinks');
  lastContextComment = false;
  lastContextSharelink = false;

  // Context Menu Handler

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

  sharelinkContextMenuOpenButton.addEventListener('click', function(e){
    var id = this.parentElement.dataset.sharelinkid;
    var sharelink = document.querySelector('#sharelink-'+this.parentElement.dataset.sharelinkid);
    var verifier = sharelink.querySelector(".sharelink-verifier").title;
    var url = window.location.href.split('?')[0];
    var link = url+"?image="+id+"&verifier="+verifier;
    window.open(link,'_blank');
    sharelink.style.background = "";
    $(sharelinkContextMenu).hide(100);
  });

  sharelinkContextMenuCopyButton.addEventListener('click', function(e){
    var id = this.parentElement.dataset.sharelinkid;
    var sharelink = document.querySelector('#sharelink-'+this.parentElement.dataset.sharelinkid);
    var verifier = sharelink.querySelector(".sharelink-verifier").title;
    var url = window.location.href.split('?')[0];
    var link = url+"?image="+id+"&verifier="+verifier;
    sharelink.style.background = "";
    $(sharelinkContextMenu).hide(100);
    copyToClipboard(link);
  });

  sharelinkContextMenuDeleteButton.addEventListener('click', function(e){
    var id = this.parentElement.dataset.sharelinkid;
    var sharelink = document.querySelector('#sharelink-'+this.parentElement.dataset.sharelinkid);
    sharelink.style.opacity ="0.3";
    deletePictureSharelink(id, function(data){
      if(data.error){console.log(data.error);sharelink.style.opacity ="1";sharelink.style.background = "";return;}
      else if(!data.response){console.log('Unknown Error!');sharelink.style.opacity ="1";sharelink.style.background = "";return;}
      sharelink.remove();
    });
    $(sharelinkContextMenu).hide(100);
  });




  document.addEventListener('click', function(e){
    // If the clicked element is not the menu
    if (!$(e.target).parents('.comment-menu').length > 0) {
      // Hide it
      $(commentContextMenu).hide(100);
      if(lastContextComment){lastContextComment.style.background = "";}
    }

    // If the clicked element is not the menu or item
    if ((!$(e.target).parents('.sharelink-menu').length > 0)  &&  (!$(e.target).parents('.sharelink-item').length > 0) && (!$(e.target).hasClass('sharelink-item'))) {
      // Hide it
      $(sharelinkContextMenu).hide(100);
      if(lastContextSharelink){lastContextSharelink.style.background = "";}
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
    var commentsLoaded = false;
    var sharelinksLoaded = false;
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
      addCommentContextMenuHandler();

      // COMMENTS ARE LOADED
      commentsLoaded = true;

      // PAGE LOADED IF SHARELINKS ARE LOADED TOO
      if(sharelinksLoaded){loaded();}
    });

    // LOAD
    getPictureSharelinks(id, function(data){
      console.log(data);

      // SHARELINKS ARE LOADED
      sharelinksLoaded = true;

      // INTO CONTAINER
      for(var x in data.response){
        x = data.response[x]; // CANCER-CODE BUT WORKS AND ITS SHORT :)
        sharelinkContainer.innerHTML += generateShareLinkItem(x);
      }

      // SET HANDLER
      addSharelinkContextMenuHandler();

      // PAGE LOADED IF COMMENTS ARE LOADED TOO
      if(sharelinksLoaded){loaded();}
    });


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
    setAuthorInfo(data.response.author.id, data.response.author.displayname);

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
    addCommentContextMenuHandler();


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
      addCommentContextMenuHandler();
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
  if(privateImage){
    $(wrapper).fadeIn(1000);
  }else{
    $(wrapper[0]).fadeIn(1000);
  }
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

// CREATE SHARELINK-ITEM
function generateShareLinkItem(info){
  var checkmark = '<i class="fa fa-check" aria-hidden="true"></i>';
  var crossmark = '<i class="fa fa-times" aria-hidden="true"></i>';

  var html = '<div id="sharelink-'+info.id+'" class="sharelink-item" data-id="'+info.id+'">';
  html += '<div class="sharelink-verifier" title="'+info.verifier+'">'+info.verifier.substr(0,5)+'...</div>';
  html += '<div class="sharelink-single-time">'+(info.single_time_link==1 ? checkmark : crossmark)+'</div>';
  html += '<div class="sharelink-comments-enabled">'+(info.comments_enabled==1 ? checkmark : crossmark)+'</div>';
  html += '<div class="sharelink-views">'+info.views+'</div>';
  html += '<div class="sharelink-created">'+info.created+'</div>';
  html += '</div>';

  return html;
}


// SHOW CONTEXT-MENU SHARE LINK
function addSharelinkContextMenuHandler(){
  var sharelinks = document.querySelectorAll('.sharelink-item');
  for(var i = 0; i < sharelinks.length; i++){
    var sharelink = sharelinks[i];
    // sharelink.oncontextmenu = sharelinkContextHandler;
    sharelink.onclick = sharelinkContextHandler;
  }
}

function sharelinkContextHandler(e){
    if(lastContextComment){lastContextComment.style.background = "";}
    lastContextSharelink = this;
    if(privateImage){
      sharelinkContextMenu.dataset.sharelinkid = this.dataset.id;
      sharelinkContextMenu.style.top = event.pageY + "px";
      sharelinkContextMenu.style.left = event.pageX + "px";
      $(sharelinkContextMenu).fadeIn(100);
      this.style.background = "rgb(236, 236, 236)";
    }
}


// SHOW CONTEXT-MENU COMMENT
function addCommentContextMenuHandler(){
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
    if(privateImage || this.dataset.authorid == userinfo.id){
      commentContextMenu.dataset.commentid = this.dataset.commentid;
      commentContextMenu.dataset.commentcontentid = this.id;
      commentContextMenu.style.top = event.pageY + "px";
      commentContextMenu.style.left = event.pageX + "px";
      $(commentContextMenu).fadeIn(100);
      this.style.background = "rgb(236, 236, 236)";
    }
}



// CLIPBOARD
function copyToClipboard(text) {
  window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}
