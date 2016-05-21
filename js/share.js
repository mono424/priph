document.addEventListener("DOMContentLoaded", function(event) {

  /* DEFINE STUFF */
  wrapper = document.querySelector('.wrapper');

  image = wrapper.querySelector('#image');
  author_name = wrapper.querySelector('#author_name');
  author_image = wrapper.querySelector('#author_image');
  user_image = wrapper.querySelector('#user_image');
  commentbox = wrapper.querySelector('#commentbox');
  commentform = wrapper.querySelector('.comment-form');


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
  image.src = generatePrivateImageUrl(id);
  loadPrivateAuthorInfo();
}

function loadPrivateAuthorInfo(){
  userInfo(function(data){
    userinfo = data.response;
    setAuthorInfo(userinfo.id, userinfo.displayname);

    // PAGE LOADED
    loaded();
  });
}







// **** LOAD PUBLIC IMAGE

function loadPublicImage(id, verifier){
  publicGetShareInfo(id, verifier, function(data){
    if(data.error){error(data.error);return;}
    if(!data.response){error('Unknown Error!');return;}

    // SET AUTHOR INFO
    setAuthorInfo(data.response.author.id, data.response.author.displayname)

    // SET IMG SOURCE
    image.src = publicGeneratePictureSrc(data.response.picture_token.id, data.response.picture_token.token);

    // DO WARNING IF SINGLE TIME LINK
    if(data.response.single_time_link){/* WARNING */}

    // DISABLE COMMENT BAR IF COMMENTS ARE DISABLED
    if(!data.response.comments_enabled){/* DISABLE */}


    // PAGE LOADED
    loaded();
  });
}







// **** OTHER STUFF


// SET AUTHOR INFO

function setAuthorInfo(id, displayname){
  author_name.innerHTML = displayname;
  author_image.src = profilePictureUrl(id, 58, 58);
}



// PAGE LOADED

function loaded(){
  $(wrapper).fadeIn(1000);
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
  document.querySelector('.error p').innerHTML = text;
  $('.error').fadeIn(1000);
}



// CREATE COMMENT

function generateComment(author_name, author_img, content){
  var out = '<div class="comment"><div class="comment-author cf"><img src="'+author_img+'" alt="" /><div>'+author_name+'</div></div>';
  out += '<div class="content"><p>'+content+'</p></div></div></div>';
  return out;
}
