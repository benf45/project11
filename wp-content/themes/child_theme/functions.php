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

    // Enqueue Custom Script
	wp_enqueue_script( 'theme-custom-script', get_theme_file_uri( '/dist/js/custom-scripts.js' ), array( 'jquery' ), null, true );


	
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );