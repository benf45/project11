
(function($){


// Get the modal
var modal = $("#my_modal");

// Get the button that opens the modal
var modalOpenBtn = $(".modal_open");

// Get the <span> element that closes the modal
var modalCloseBtn = modal.find(".modal_close_icon");

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

    //When the user clicks on close icon of the modal, close it
    modalCloseBtn.on('click',function() {

        //Hide the modal when close button is clicked
        modal.hide();
        modal.removeClass('active_modal');


    });

      
    // When the user clicks anywhere outside of the modal, close it
    $("#my_modal").click(function(ev){
      
        if(ev.target != this && modal.hasClass('active_modal')) return;
      
        modal.hide();
        modal.removeClass('active_modal');
      
    });

}
closeModal();

/* Change arrow on select */
function changeSelectArrow(){

    $("select").click(function(e){
    
        if(!$(this).is('.active_select')){

            $('.active_select').removeClass('active_select');

        }
    
        if($(this).hasClass('active_select')){

            $(this).removeClass('active_select');

        }
        else{

            $(this).addClass('active_select');

        }

    });

    document.addEventListener("click", function(e){

        var container = $("select");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            container.removeClass('active_select');

        }

    });

}
changeSelectArrow();

/* Hide scroll bar when mobile menu is shown */
function hideScrollbar(){

    const body = document.querySelector("body");
    $('.navbar-toggler').click(function() {
    
        let ariaExpended = $(this).attr('aria-expanded');
    
        if(ariaExpended == 'true'){
            // Disable scroll
            body.style.overflow = "hidden";
    
            $('.navbar-toggler-icon').removeClass('bi-list').addClass('bi-x-lg');
          
        }else{
            // Disable scroll
            body.style.overflow = "auto";
            $('.navbar-toggler-icon').removeClass('bi-x-lg').addClass('bi-list');
        }
    
    });

}
hideScrollbar();

/*
 *
 * Grid photo
 * 
 */

/* function to show photo overlay */
function showPhotoOverlay(){

    $(".photo_block, .single_photo_thumb").hover(function(e){

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
    var lightboxOpenBtn = $(".lightbox_open img");;

    lightboxOpenBtn.on('click', function(e) {

        // Get the data of post id
        let dataImagePath = $(this).closest('.show_lightbox_icon').attr('data-image-path');    
        let postId = $(this).closest('.show_lightbox_icon').attr('data-post-id');
        let postTitle = $(this).closest('.show_lightbox_icon').attr('data-post-title');
        let postTaxonomyTerm = $(this).closest('.show_lightbox_icon').attr('data-post-term');
        let postDate = $(this).closest('.show_lightbox_icon').attr('data-post-date');

        //Add post data to the lightbox modal
        $('.lightbox').attr({'data-post-id': postId, 'data-post-title': postTitle, 'data-post-date': postDate});

        // Wen a user click on show lightbox button we remove the image from the dom
        lightbox.find('.lightbox_content_image img').remove();

        // We show the post data in the lightbox
        lightbox.find('.lightbox_content_image').prepend('<img src="'+dataImagePath+'" alt="'+postTitle+'">');

        lightbox.find('.lightbox_content_image_infos').html('<p>'+postTitle+'</p>'+
                                                            '<span>'+postTaxonomyTerm+' </span>'+ 
                                                            '<span> '+postDate+'</span>');
      
    
       //Show the lightbox modal
       lightbox.fadeIn(250);
       lightbox.addClass('active_modal');
    
    });

}
openLightbox();


let currentPage = 1;
let limit = 12;

/* Function ajax to load more photos */
function ajaxRequest(data){

    $.ajax({

        'url': url_script.ajax_url,
        'type': 'POST',
        'data': {'action': 'load_more', 'data': data},
        dataType: 'json',
        success: function(response){

            //If the html is not empty we show more messages or we show a completely new data depending on filter
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

                //Activate load more button
                activateLoadMoreButton();
                //change the text of load more button when select change state
                changeLoadMoreButtontxt('Charger plus');
                      
            }else{ //Do this when user has changed the filter

                //Show a message when no data to show
                if(data.action == 'onChange'){

                    $('.photo_box_wrapper').html('<p class="no_photo_data">Aucune photo à afficher</p>');

                }

                //If the html is empty we disable the show more button
                if(response.html == ''){

                    //disable load more button
                    disableLoadMoreButton();
                    //change the text of load more button when there are no data
                    changeLoadMoreButtontxt('Plus de données');

                }

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
