
function galleryLoad(){
  galleryContainer.innerHTML = "";
  galleryContainer.style.display = "none";
  galleryRefresh.className = "loading";
  userGetPictures(function(data){
    if(!data){/* ERROR */}
    if(data.error){/* SPECIFIED ERROR */}
    if(data.response){
      for(i=0;i<data.response.length;i++){
        var img = data.response[i];
        var img_src_thumb = generatePrivateImageUrl(img.id, 260, 220);
        var img_src_full = generatePriphPrivateImageUrl(img.id);
        galleryContainer.innerHTML += "\n" + createImageItem(img_src_thumb,img_src_full,img.id);
      }
      //mobileHoverFix();
    }else{
      galleryContainer.innerHTML = "No Images uploaded yet.";
    }
    setTimeout(function(){
      galleryRefresh.className = "";
      galleryContainer.style.display = "block";
    },1000);
  });
}

function createImageItem(thumbimg_src, fullimg_src, id){
  var item = '<div class="image_item" style="background: url('+thumbimg_src+') no-repeat; background-size: cover;">';
  item +=       '<!-- Overlay Buttons -->';
  item +=       '<i class="fa fa-pencil-square-o image_overlay image_edit" aria-hidden="true"></i>';
  item +=       '<a target="_blank" href="'+fullimg_src+'"><i class="fa fa-external-link image_overlay image_open" aria-hidden="true"></i></a>';
  item +=       '<i class="fa fa-share-square image_overlay image_share" aria-hidden="true"></i>';
  item +=       '<a onclick="deleteImageConfirm(\''+id+'\');"><i class="fa fa-trash-o image_overlay image_delete" aria-hidden="true"></i></a>';
  item +=     '</div>';
  return item;
}

function deleteImageConfirm(id){
  niceConfirm('Delete Image?', 'Sure you want to delete the Selected Image?',function(){
    deletePicture(id, function(data){
      galleryLoad();
    });
  });
}

function generatePriphPrivateImageUrl(id){
  return "share.php?privateImage="+id;
}

/*function mobileHoverFix(){
  $('.image_gallery .image_item').on("touchstart", function (e) {
    'use strict'; //satisfy code inspectors
    var link = $(this); //preselect the link
    if (link.hasClass('hover')) {
        return true;
    } else {
        link.addClass('hover');
        $('.image_gallery .image_item').not(this).removeClass('hover');
        e.preventDefault();
        return false; //extra, and to make sure the function has consistent return points
    }
  });

  $('.image_gallery .image_item .image_overlay').on("touchstart", function (e) {
    'use strict'; //satisfy code inspectors
    var link = $(this); //preselect the link
    if (link.hasClass('hover')) {
        return true;
    } else {
        link.addClass('hover');
        $('.image_gallery .image_item .image_overlay').not(this).removeClass('hover');
        e.preventDefault();
        return false; //extra, and to make sure the function has consistent return points
    }
  });
}*/
