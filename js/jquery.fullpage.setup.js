$(document).ready(function() {
  $('#fullpage').fullpage({
    controlArrows: false,
    slidesNavigation: false,
    keyboardScrolling: false,
    anchors: ['intro', 'info'],
    scrollOverflow:true,
    autoScrolling:true,
    afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex){
      //if(slideAnchor=="user"){userPageHandler(true);}else{userPageHandler(false);}
    }
  });
  $.fn.fullpage.setMouseWheelScrolling(false);
  $.fn.fullpage.setAllowScrolling(false);
  $.fn.fullpage.reBuild();
  //touchScroll("user_gallery");
  //touchScroll("user_settings");
});




/*function isTouchDevice(){
	try{
		document.createEvent("TouchEvent");
		return true;
	}catch(e){
		return false;
	}
}


function touchScroll(id){
	if(isTouchDevice()){ //if touch events exist...
		var el=document.getElementById(id);
		var scrollStartPos=0;

		document.getElementById(id).addEventListener("touchstart", function(event) {
			scrollStartPos=this.scrollTop+event.touches[0].pageY;
			event.preventDefault();
		},false);

		document.getElementById(id).addEventListener("touchmove", function(event) {
			this.scrollTop=scrollStartPos-event.touches[0].pageY;
			event.preventDefault();
		},false);
	}
}*/
