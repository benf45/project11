
(function($){


// Get the modal
var modal = $("#my_modal");

// Get the button that opens the modal
var modalOpenBtn = $(".modal_open");

// Get the <span> element that closes the modal
var modalCloseBtn = modal.find(".close");

// When the user clicks on the button, open the modal
function openModal(){

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
}
openModal();

//Function to close the modal
function closeModal(){

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

}
closeModal();

/* Change arrow on select */
$("select").click(function(){

    if($(this).hasClass('active_select')){

        $(this).removeClass('active_select');
    }
    else{

        $(this).addClass('active_select');
    }

});


/*
 *
 * Grid photo
 * 
 */

/* function to show photo overlay */
function showPhotoOverlay(){

    $(".photo_block").hover(function(e){

        e.stopImmediatePropagation();
        $(this).find('.photo_overlay').fadeIn(200);

    }, function(e){

        e.stopImmediatePropagation();

        $(this).find('.photo_overlay').fadeOut(250);

    });

}
showPhotoOverlay();

/* function to redirect to single page */
function redirectSinglePage(){

    $(".show_photo_icon img").on('click', function(){

        let siteUrl= $(this).closest('.show_photo_icon').attr('data-link');

        window.location.replace(siteUrl);

    });

}
redirectSinglePage();

// Function to open lightbox when the user clicks on the button
function openLightbox(){

    // Get the lightbox modal
    var lightbox = $(".lightbox");

    // Get the button that opens the lightbox modal
    var lightboxOpenBtn = $(".lightbox_open img");

    lightboxOpenBtn.on('click', function(e) {

        //We get the image path
        let imagePath = $(this).closest('.show_lightbox_icon').attr('data-image-path');
    
        // We show the imafe in the lightbox
        lightbox.find('.lightbox_content img').attr('src', imagePath);
    
       //Show the lightbox modal
       lightbox.fadeIn(250);
       lightbox.addClass('active_modal');
    
    });
}
openLightbox();


let currentPage = 1;
let limit = 8;

/* Function ajax to load more photos */
function ajaxRequest(data){

    $.ajax({

        'url': "./wp-admin/admin-ajax.php",
        'type': 'POST',
        'data': {'action': 'load_more', 'data': data},
        dataType: 'json',
        success: function(response){

            if(response.html != ''){

                if(data.action == 'loadMore'){

                    $('.photo_box_wrapper').append(response.html);

                }else{

                    $('.photo_box_wrapper').html(response.html);

                }

                //function to show photo overlay
                showPhotoOverlay();
                //function to redirect to single page
                redirectSinglePage();
                // Function to open lightbox when the user clicks on the button
                openLightbox();
                       //Show the lightbox modal
                       /*$(".lightbox_open img").click(function(e) {

                        //We get the image path
                        let imagePath = $(this).closest('.show_lightbox_icon').attr('data-image-path');
                    
                        // We show the imafe in the lightbox
                        $(".lightbox").find('.lightbox_content img').attr('src', imagePath);
                    
                       //Show the lightbox modal
                       $(".lightbox").fadeIn(250);
                       $(".lightbox").addClass('active_modal');
                    
                    });*/
            }

            if(data.action == 'loadMore' && response.html == ''){
                //disable load more button
                disableLoadMoreButton();
                //change the text of load more button when there are no data
                changeLoadMoreButtontxt('Plus de données');

            }

        }

    });

}

/* Function to load more photo */
function loadMore(){

    // Do currentPage + 1, because we want to load the next page
    currentPage++;

    let categorie = $('#categorie-select').val();
    let format = $('#format-select').val();
    let filterBy = $('#filterby-select').val();

    let categorieObject = {'taxonomy_slug': 'categorie', 
                           'taxonomy_term': categorie};

    let formatObject = {'taxonomy_slug': 'format', 
                        'taxonomy_term': format};

    let action = 'loadMore';

    let data = {'categorie': categorieObject, 
                'format': formatObject,
                'filter_by': filterBy,
                'limit': limit,
                'paged': currentPage,
                'action': action};
    
    ajaxRequest(data);


}

/* Function to load photos on select change */
function changeState(){

    //Activate load more button
    activateLoadMoreButton();
    //change the text of load more button when select change state
    changeLoadMoreButtontxt('Charger plus');
    
    // Do currentPage 1, because we want to show the first page
    currentPage = 1;
    limit = 8;

    let categorie = $('#categorie-select').val();
    let format = $('#format-select').val();
    let filterBy = $('#filterby-select').val();

    let categorieObject = {'taxonomy_slug': 'categorie', 
                           'taxonomy_term': categorie};

    let formatObject = {'taxonomy_slug': 'format', 
                        'taxonomy_term': format};

    let action = 'onChange';

    let data = {'categorie': categorieObject, 
                'format': formatObject,
                'filter_by': filterBy,
                'limit': limit,
                'paged': currentPage,
                'action': action};
    
    ajaxRequest(data);


}


/* Click event to load more photos */
$(".load_more_btn").click(function(){
    
    //Function to load more button
    loadMore(); 
        
});

/* Click event to load photos on select change */
$("#categorie-select, #format-select, #filterby-select").change(function(){

    //Function to load photos on select change
    changeState(); 
        
});

/* Function to disable load more button */
function disableLoadMoreButton(){

    $('.load_more_btn').addClass('disabled_load_more_btn').removeClass('load_more_btn');

}

/* Function to activate load more button */
function activateLoadMoreButton(){

    $('.disabled_load_more_btn').addClass('load_more_btn').removeClass('disabled_load_more_btn');

}

/* Function to change load more button text */
function changeLoadMoreButtontxt(text){

    $('.load_more_btn, .disabled_load_more_btn').text(text);

}

})( jQuery );
