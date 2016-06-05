

var galleryIsLoading = false;
function galleryLoad(){
  if(galleryIsLoading){return;}
  galleryIsLoading = true;
  galleryContainer.innerHTML = "";
  galleryRefresh.className = "loading";
  galleryContainer.style.display = "none";
  masonryContainer.masonry('destroy');
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
        galleryContainer.innerHTML += "\n" + createImageItem(img_src_thumb,img_src_full,img.id,sizeandclass.class,sizeandclass.csssize);
      }
    }else{
      galleryContainer.innerHTML = "No Images uploaded yet.";
    }
    galleryContainer.style.display = "block";
    masonryContainer.masonry({
      itemSelector: '.image_item',
      percentPosition: true
    });
    setTimeout(function(){
      galleryRefresh.className = "";
      galleryIsLoading = false;
    },1000);
  });
}

function createImageItem(thumbimg_src, fullimg_src, id, elementclass, imgsize){
  var item = '<div style="width: '+imgsize.width+'; height: '+imgsize.height+';" class="'+elementclass+'">';
  item +=       '<!-- IMAGE -->';
  item +=       '<img src="" style="background: url('+thumbimg_src+') no-repeat; background-size: cover; width: 100%; height: 100%;" />';
  item +=       '<!-- Overlay Buttons -->';
  item +=       '<a target="_blank" href="'+fullimg_src+'"><i class="fa fa-external-link image_overlay image_open" aria-hidden="true"></i></a>';
  item +=       '<i onclick="showSharePictureModal(\''+id+'\');" class="fa fa-share-square image_overlay image_share" aria-hidden="true"></i>';
  item +=       '<a onclick="deleteImageConfirm(\''+id+'\');"><i class="fa fa-trash-o image_overlay image_delete" aria-hidden="true"></i></a>';
  item +=     '</div>';
  return item;
}

var currImageClass = 0;
function getImageSize(){
  if(checkMobile()){
    var height = 300;
    var widthpercent = 100;
  }else{
    var height = 300;
    if(currImageClass === 0){
      var widthpercent = 20;
      currImageClass = 1;
    }else if(currImageClass === 1){
      var widthpercent = 40;
      currImageClass = 0;
    }
  }
  var width = $('#user_gallery_wrapper').width() / 100 * widthpercent;
  return {'class':'image_item', 'size': {'width': width,'height':height}, 'csssize': {'width': widthpercent+'%','height':height+'px'}};
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
