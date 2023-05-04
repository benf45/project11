<?php
// action to enqueue parent theme's style.css
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function theme_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

// action with priority 20. 
// we take wallstreet-style out of the queue and we enter the child's style.css
add_action('wp_enqueue_scripts', 'style_theme_enfant', 20);

function style_theme_enfant() {
    wp_dequeue_style('wallstreet-style', get_stylesheet_uri() );
    wp_enqueue_style('enfant-style', get_stylesheet_uri() );
}


/*
** Enqueue Google Fonts
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
** Enqueue scripts and styles
*/
function theme_scripts() {
    // Enqueue lightbox Script
	wp_enqueue_script( 'theme-lightbox-script', get_theme_file_uri( '/dist/js/lightbox.js' ), array( 'jquery' ), null, true );
    // Enqueue Custom Script
	wp_enqueue_script( 'theme-custom-script', get_theme_file_uri( '/dist/js/custom-scripts.js' ), array( 'jquery' ), null, true );

	
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );


/*
** Function to load more photos
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