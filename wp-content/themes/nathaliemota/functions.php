<?php
/*
 *
 * We charging theme styles and scripts
 * 
 */
function theme_styles_scripts(){

    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-icon', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js', array('jquery'), 1, true);
    wp_enqueue_script('boostrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js', array('jquery', 'popper'), 1, true);

    // Enqueue lightbox Script
	wp_enqueue_script( 'theme-lightbox-script', get_theme_file_uri( '/dist/js/lightbox.js' ), array( 'jquery' ), null, true );
    // Enqueue Custom Script
	wp_enqueue_script( 'theme-custom-script', get_theme_file_uri( '/dist/js/custom-scripts.js' ), array( 'jquery' ), null, true );

}
add_action('wp_enqueue_scripts', 'theme_styles_scripts');

/*
 *
 * Add ajax url variable to my js scripts
 * 
 */
function ajax_url_variable() {

    wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/dist/js/lightbox.js', array('jquery') );
    wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/dist/js/custom-scripts.js', array('jquery') );

    wp_localize_script( 'ajax-script', 'url_script',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'ajax_url_variable' );

/**
 *
 * We setup theme menu
 * 
 */
function after_setup_theme() {
    
    // We add the bootstrap menu
    register_nav_menu('header_menu', "Header menu");
    register_nav_menu('footer_menu', "Footer menu");

    //We add a php class to handle bootstrap menu
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

}
add_action('after_setup_theme', 'after_setup_theme');

/**
 * 
 * Enable support for logo.
 *
 */
add_theme_support('custom-logo',  array('height'      => 190,
			                            'width'       => 190,
			                            'flex-width'  => true,
			                            'flex-height' => true,));


/**
 * 
 * Enable support for <title> tag.
 *
 */
add_theme_support( 'title-tag' );

/*
 *
 * Action to enqueue parent theme's style.css
 * 
 */
function theme_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

/*
 *
 * Action with priority 20.
 * We take wallstreet-style out of the queue and we enter the child's style.css
 * 
 */
function style_theme_enfant() {
    wp_dequeue_style('wallstreet-style', get_stylesheet_uri() );
    wp_enqueue_style('enfant-style', get_stylesheet_uri() );
}
add_action('wp_enqueue_scripts', 'style_theme_enfant', 20);

/*
 *
 * Enqueue Google Fonts
 * 
 */
function spacemono_font_url() {
    $font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'nathalie mota' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Space Mono:ital,wght@0,400;0,700;1,400;1,700' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}
function poppins_font_url() {
    $font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'poppins' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}
function gfonts_scripts() {

    wp_enqueue_style( 'spacemono_font', spacemono_font_url(), array(), '1.0.0' );
    wp_enqueue_style( 'poppins_font', poppins_font_url(), array(), '1.0.0' );

}
add_action( 'wp_enqueue_scripts', 'gfonts_scripts' );

/*
 *
 * Function to load more photos
 * 
 */
function load_more(){

    $post_data = $_POST['data'];

    $taxonomy_categorie = $post_data['categorie'];
    $taxonomy_format = $post_data['format'];

    $filter_by = $post_data['filter_by'];

    $limit = $post_data['limit'];
    $paged = $post_data['paged'];

    $tax_query = array();
    
    // If taxonomy term of categorie term is not empty we do a taxonomy Query
    if(!empty($taxonomy_categorie['taxonomy_term'])){

        // If taxonomy term of categorie and format are not empty we do multiple taxonomy Query
        if(!empty($taxonomy_format['taxonomy_term']) && !empty($taxonomy_categorie['taxonomy_term'])){

            $tax_query = array('relation' => 'AND');

        }
        
        $tax_query[] = array('taxonomy' => $taxonomy_categorie['taxonomy_slug'],
                             'field' => 'slug',
							 'terms' => $taxonomy_categorie['taxonomy_term'],
                             'operator' => 'IN');
        
    }
    // If taxonomy term of format is not empty we do a taxonomy Query
    if(!empty($taxonomy_format['taxonomy_term'])){

        $tax_query[] = array('taxonomy' => $taxonomy_format['taxonomy_slug'],
                             'field' => 'slug',
							 'terms' => $taxonomy_format['taxonomy_term'],
                             'operator' => 'IN');

    }
    // If both taxonomies terms are empty we nulled the array 
    if(empty($taxonomy_format['taxonomy_term']) && empty($taxonomy_categorie['taxonomy_term'])){

        $tax_query = null;

    }

    if($filter_by == 'new'){

        $order = 'DESC';

    }else{

        $order = 'ASC';

    }

    $ajax_posts = new WP_Query(['post_type' => 'photo',
                                'posts_per_page' => $limit,
                                'tax_query' => $tax_query,
                                'orderby' => 'date',
                                'order' => $order,
                                'paged' => $paged]);
    

    $output = '';

    if($ajax_posts->have_posts()) {

        ob_start();

        while($ajax_posts->have_posts()) : $ajax_posts->the_post();

            get_template_part('partials/photo_block');

        endwhile;

        wp_reset_postdata();
        $output = ob_get_contents();

        ob_end_clean();
        
        $code = 'success';

    } else {

        $output =  '';
        $code = 'error';
    }

    $result = array('message' => $code,
                    'html' => $output);

    echo json_encode($result);

    wp_die();

}
add_action( 'wp_ajax_load_more', 'load_more' );
add_action('wp_ajax_nopriv_load_more', 'load_more');

/*
 *
 * Function to change lightbox photo
 * 
 */
function change_lightbox_photo(){

    $post_data = $_POST['data'];

    $post_id = $post_data['post-id'];
    $user_action = $post_data['user-action'];

    
    global $post;
    $post = get_post($post_id);

    $get_post = '';

    if($user_action == "prev"){

        $get_post = get_previous_post();

    }else{

        $get_post = get_next_post();

    }
    
    if($get_post){
       
        //Get all terms of a taxonomy
        $terms = get_the_terms($get_post->ID, 'categorie');
        
        $data['id'] = $get_post->ID;
        $data['title'] = $get_post->post_title;
        $data['date'] = date('Y', strtotime($get_post->post_date));
        $data['image_url'] = get_the_post_thumbnail_url($get_post->ID);

        //Check if terms of a taxonomy is empty
        if($terms){

            $data['term'] = $terms[0];

        }

        $code = "success";

    }else{

        $data[] = '';
        $code = "error";

    }
    
    $result = array('message' => $code,
                    'data' => $data);

    echo json_encode($result);

    wp_die();

}
add_action( 'wp_ajax_change_lightbox_photo', 'change_lightbox_photo' );
add_action('wp_ajax_nopriv_change_lightbox_photo', 'change_lightbox_photo');

/*
 *
 * Function to custom comment section
 * 
 */
if ( ! function_exists( 'custom_comment' ) ) :
	/**
	 * Template for comments.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @param string $comment Comment text.
	 * @param array  $args    Array of arguments.
	 * @param int    $depth   Depth of comments to show.
	 */
	function custom_comment( $comment, $args, $depth ) {
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				// Display trackbacks differently than normal comments.
				?>
		<li <?php comment_class(); ?> id="comment-<?php esc_attr( comment_ID() ); ?>">
		<p><?php esc_html_e( 'Pingback:', 'go' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)'), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default:
				// Proceed with normal comments.
				global $post;
				?>
		<li <?php comment_class(); ?> id="li-comment-<?php esc_attr( comment_ID() ); ?>">
		<article id="comment-<?php esc_attr( comment_ID() ); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf(
						'<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author' ) . '</span>' : ''
					);
					printf(
						'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						esc_html( get_comment_time( 'c' ) ),
						/* translators: 1: date, 2: time */
						sprintf( esc_html__( '%1$s at %2$s'), esc_html( get_comment_date() ), esc_html( get_comment_time() ) )
					);
				?>
				</header><!-- .comment-meta -->

				<?php if ( '0' === $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php esc_html__( 'Your comment is awaiting moderation.', 'go' ); ?></p>
			<?php endif; ?>

				<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit'), '<p class="edit-link">', '</p>' ); ?>
				</section><!-- .comment-content -->

				<div class="reply">
				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'reply_text' => __( 'Reply'),
							'after'      => ' <span>&darr;</span>',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
						)
					)
				);
				?>
				</div><!-- .reply -->
			</article><!-- #comment-## -->
				<?php

		endswitch; // end comment_type check.
	}
endif;
