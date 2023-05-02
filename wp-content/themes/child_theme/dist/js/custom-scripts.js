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

    //Check if contact menu is clicked
    if($(this).hasClass('menu_modal_open')){

        //Empty the input when clicking on contact menu
        modal.find('.input_reference input').val('');

    }else{

        //Get the ref of the image on single page
        reference = $('.single_photo_ref').attr('data-reference');

        if(reference){

            //Add the  ref in the form's input
            modal.find('.input_reference input').val(reference);
           
        }

    }

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


/* Change arrow on select */
$("select").click(function(){

    if($(this).hasClass('active_select')){

        $(this).removeClass('active_select');
    }
    else{

        $(this).addClass('active_select');
    }

});




})( jQuery );
