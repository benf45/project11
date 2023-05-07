<?php
/**
 * Template part for displaying photo block
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Go
 */

?>

<?php
$terms_post = get_the_terms( get_the_ID(), 'categorie' );

//We get the image title
$image_id = get_post_thumbnail_id();
$image_title = get_the_title($image_id);

?>

<div class="photo_block">
 
    <?php echo the_post_thumbnail('medium_large'); ?>

    <div class="photo_overlay">

        <div class="show_photo_icon" data-link="<?php echo get_permalink(get_the_ID()); ?>">
            <img src="<?php echo get_stylesheet_directory_uri() ;?>/dist/images/eye.svg" alt="Oeil">
        </div>

        <div class="show_lightbox_icon lightbox_open" data-post-title="<?php echo $image_title; ?>" 
                                                      data-post-date="<?php echo get_the_date('Y'); ?>" 
                                                      data-post-id="<?php echo get_the_ID(); ?>" 
                                                      data-post-term="<?php if($terms_post){ echo $terms_post[0]->name;} ?>" 
                                                      data-image-path="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>">
                
            <img src="<?php echo get_stylesheet_directory_uri() ;?>/dist/images/fullscreen.svg" alt="Plein écran">
                
        </div>
        <div class="photo_overlay_footer flex_row">

            <p><?php if(!empty($image_title)){ echo $image_title;} ?></p>
            <p><?php if($terms_post){ echo $terms_post[0]->name;} ?></p>

        </div>

    </div>

   
</div>
