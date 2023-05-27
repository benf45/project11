(function($){

// Get the lightbox modal
var lightbox = $(".lightbox");

// Get the <span> element that closes the modal
var lightboxCloseBtn = lightbox.find(".modal_close_icon");


//function to close the lightbox modal
function closeLightbox(){

    lightboxCloseBtn.on('click',function() {

        //Hide the lightbox modal when close button is clicked
        lightbox.hide();
        lightbox.removeClass('active_lightbox');

        //We resetting the left/right lightbox arrow for the next opening of the lightbox modal
        $('.lightbox_left_arrow, .lightbox_right_arrow').removeClass('lightbox_arrow_disabled');

    });
     
}
closeLightbox();


//function to disabled the left/right lightbox arrow
function disabledLightboxArrow(userAction, hasData = true){

    //If no more data to show disabled the left/right arrow
    if(!hasData){

        if(userAction == "next"){

            if(!$('.lightbox_right_arrow').hasClass('lightbox_arrow_disabled')){

                $('.lightbox_right_arrow').addClass('lightbox_arrow_disabled');

            }    

        }else{

            if(!$('.lightbox_left_arrow').hasClass('lightbox_arrow_disabled')){

                $('.lightbox_left_arrow').addClass('lightbox_arrow_disabled');

            }

        }

    }else{

        if(userAction == "next"){

            if($('.lightbox_left_arrow').hasClass('lightbox_arrow_disabled')){

                $('.lightbox_left_arrow').removeClass('lightbox_arrow_disabled');

            }

        }else{

            if($('.lightbox_right_arrow').hasClass('lightbox_arrow_disabled')){

                $('.lightbox_right_arrow').removeClass('lightbox_arrow_disabled');

            }

        }

    }

}

/* Function ajax to get prev/next photo */
function ajaxLightboxRequest(data){

    $.ajax({

        'url': url_script.ajax_url,
        'type': 'POST',
        'data': {'action': 'change_lightbox_photo', 'data': data},
        dataType: 'json',
        beforeSend: function(response){

            //Add a loading when before we send the ajax request
            $('.lightbox_image_loading').fadeIn(250);

        },
        success: function(response){

            //Stop the loading when ajax request success
            $('.lightbox_image_loading').fadeOut(250);

            if(response.data != ''){
                
                //Add post data to the lightbox modal
                $('.lightbox').attr({'data-post-id': response.data.id, 'data-post-title': response.data.title, 'data-post-date': response.data.date});

                // We show the post data in the lightbox
                $('.lightbox').find('.lightbox_content_image img').replaceWith('<img src="'+response.data.image_url+'" alt="'+response.data.title+'">');
                
                $('.lightbox').find('.lightbox_content_image_infos').html('<p>'+response.data.title+'</p>'+
                                                                          '<span>'+response.data.term.name+' </span>'+ 
                                                                          '<span> '+response.data.date+'</span>');

                //If no more data to show disabled the left/right arrow
                disabledLightboxArrow(data['user-action'], true);
                      
            }else{

                //If no more data to show disabled the left/right arrow
                disabledLightboxArrow(data['user-action'], false);

            }


        }

    });

}



/* Function to show prev/next photo */
function changeLightboxPhoto(){

    let nextPrevBtn = $('.lightbox_right_arrow img, .lightbox_left_arrow img');

    nextPrevBtn.on('click', function(e) {

        let object = $(this);

        // Get the data of post id
        var postId = object.closest('.lightbox').attr('data-post-id');
        var postTitle = object.closest('.lightbox').attr('data-post-title');
        var postDate = object.closest('.lightbox').attr('data-post-date');
        var userAction = object.closest('span').attr('data-user-action');

        //We store the data post in an array
        let data = {'post-id':postId, 'post-title':postTitle, 'post-date':postDate, 'user-action':userAction};

        //Function ajax to get prev/next photo
        ajaxLightboxRequest(data);
    
    });

}
changeLightboxPhoto();


})( jQuery );
    