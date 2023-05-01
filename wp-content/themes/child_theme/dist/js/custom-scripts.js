(function($){

// Get the modal
var modal = $("#my_modal");

// Get the button that opens the modal
var modalOpenBtn = $(".modal_open");

// Get the <span> element that closes the modal
var modalCloseBtn = modal.find(".close");

// When the user clicks on the button, open the modal
modalOpenBtn.click(function(e) {
   e.stopPropagation();  
   modal.css({'display': 'block'});
   modal.addClass('active_modal');
});

// When the user clicks on <span> (x), close the modal
modalCloseBtn.click(function() {
  modal.css({'display': 'none'});
  modal.removeClass('active_modal');
});

// When the user clicks anywhere outside of the modal, close it
$("#my_modal").click(function(ev){

    if(ev.target != this && modal.hasClass('active_modal')) return;

    modal.css({'display': 'none'});
    modal.removeClass('active_modal');

});


})( jQuery );
