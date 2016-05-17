document.addEventListener("DOMContentLoaded", function(event) {

  /* DEFINE STUFF */
  wrapper = document.querySelector('.wrapper');

  image = wrapper.querySelector('#image');
  author_name = wrapper.querySelector('#author_name');
  author_image = wrapper.querySelector('#author_image');
  user_image = wrapper.querySelector('#user_image');
  commentbox = wrapper.querySelector('#commentbox');


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
      imageNotFound();
    }
  });

});

$(window).load(function() {
  /* FADE IN WRAPPER */
  $(wrapper).fadeIn(1000);
})


// LOAD PRIVATE IMAGE

function loadPrivateImage(id){
  image.src = generatePrivateImageUrl(id);
  loadPrivateAuthorInfo();
}

function loadPrivateAuthorInfo(){
  userInfo(function(data){
    console.log(data);
    userinfo = data.response;
    author_name.innerHTML = userinfo.displayname;
    author_image.src = profilePictureUrl(userinfo.id, 58, 58);
  });
}

// LOAD PUBLIC IMAGE

function loadPublicImage(id, verifier){
  console.log(id);
}




// LOAD USERINFO

function loadUserInfo(cb){
  userInfo(function(data){
    userinfo = data.response;
    cb();
  });
}

function setupCommentBar(){
  user_image.src = profilePictureUrl(userinfo.id, 26, 26);
}



// ERROR

function imageNotFound(){
  document.querySelector('.wrapper').style.display = "none";
  document.querySelector('.not-found').style.display = "block";
}



// CREATE COMMENT

function generateComment(author_name, author_img, content){
  var out = '<div class="comment"><div class="comment-author cf"><img src="'+author_img+'" alt="" /><div>'+author_name+'</div></div>';
  out += '<div class="content"><p>'+content+'</p></div></div></div>';
  return out;
}
