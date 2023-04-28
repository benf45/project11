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
function gfont_script() {

    wp_enqueue_style( 'spacemono_font', spacemono_font_url(), array(), '1.0.0' );

}
add_action( 'wp_enqueue_scripts', 'gfont_script' );