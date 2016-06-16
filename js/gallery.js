
$(window).on('resize', function(){
  reCalcImageSize();
});


var galleryIsLoading = false;
function galleryLoad(){
  if(galleryIsLoading){return;}
  galleryIsLoading = true;
  galleryContainer.innerHTML = "";
  galleryRefresh.className = "loading";
  galleryContainer.style.display = "none";
  userGetPictures(function(data){
    if(!data){/* ERROR */}
    if(data.error){/* SPECIFIED ERROR */}
    if(data.response){
      currImageClass = 0;
      for(i=0;i<data.response.length;i++){
        var img = data.response[i];
        var sizeandclass = getImageSize();
        var img_src_thumb = generatePrivateImageUrl(img.id, sizeandclass.size.width, sizeandclass.size.height);
        var img_src_full = generatePriphPrivateImageUrl(img.id);
        galleryContainer.innerHTML += "\n" + createImageItem(img_src_thumb,img_src_full,img.id,sizeandclass.class,sizeandclass.size);
      }
    }else{
      galleryContainer.innerHTML = "No Images uploaded yet.";
    }
    galleryContainer.style.display = "block";
    setTimeout(function(){
      galleryRefresh.className = "";
      galleryIsLoading = false;
    },1000);
  });
}

function createImageItem(thumbimg_src, fullimg_src, id, elementclass, imgsize){
  if(elementclass){elementclass = " "+elementclass;}
  var item = '<div style="width: '+imgsize.width+'px; height: '+imgsize.height+'px;" class="image_item'+elementclass+'">';
  item +=       '<!-- IMAGE -->';
  item +=       '<img src="" style="background: url('+thumbimg_src+') no-repeat; background-size: cover; width: 100%; height: 100%;" />';
  item +=       '<!-- Overlay Buttons -->';
  item +=       '<a target="_blank" href="'+fullimg_src+'"><i class="fa fa-external-link image_overlay image_open" aria-hidden="true"></i></a>';
  item +=       '<i onclick="showSharePictureModal(\''+id+'\');" class="fa fa-share-square image_overlay image_share" aria-hidden="true"></i>';
  item +=       '<a onclick="deleteImageConfirm(\''+id+'\');"><i class="fa fa-trash-o image_overlay image_delete" aria-hidden="true"></i></a>';
  item +=     '</div>';
  return item;
}

function reCalcImageSize(){
  var img_items = document.querySelectorAll('.image_item');
  if(img_items){
    for(var i=0;i<img_items.length;i++){
      var info = getImageSize();
      img_items[i].style.width = info.size.width+"px";
      img_items[i].style.height = info.size.height+"px";
    }
  }
}

// Function is called on every image_item, u can do different image sizes ;)
function getImageSize(){
  if(checkMobile() || $('#user_gallery_wrapper').width() < 600){
    var height = 300;
    var widthpercent = 100;
  }else if($('#user_gallery_wrapper').width() < 1000){
    var height = 300;
    var widthpercent = 50;
  }else if($('#user_gallery_wrapper').width() < 1200){
    var height = 300;
    var widthpercent = 33.33;
  }else if($('#user_gallery_wrapper').width() < 1600){
    var height = 300;
    var widthpercent = 25;
  }else if($('#user_gallery_wrapper').width() < 2000){
    var height = 300;
    var widthpercent = 20;
  }else{
    var height = 300;
    var widthpercent = 13.33;
  }
  var width = $('#user_gallery_wrapper').width() / 100 * widthpercent;
  return {'class':'', 'size': {'width': width,'height':height}};
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
