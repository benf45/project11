(function($){

// Get the lightbox modal
var lightbox = $(".lightbox");

// Get the <span> element that closes the modal
var lightboxCloseBtn = lightbox.find(".lightbox_close_icon");


//function to close the lightbox modal
function closeLightbox(){

    lightboxCloseBtn.on('click',function() {
        lightbox.hide();
        lightbox.removeClass('active_lightbox');
    });
    
    // When the user clicks anywhere outside of the modal, close it
    $(".lightbox").click(function(ev){
          
        if(ev.target != this && lightbox.hasClass('active_modal')) return;
          
        lightbox.hide();
        lightbox.removeClass('active_modal');
          
    });
}
closeLightbox();

})( jQuery );
    