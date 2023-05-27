<?php
/**
 * Partial: single.php
 * Display permalinks or full articles
 *
 */

get_header();

// Start the Loop.
while ( have_posts() ) :
	the_post();

	$post_taxonomies = array('categorie' => get_the_terms(get_the_ID(), 'categorie'),
	                         'format' => wp_get_post_terms( get_the_ID(), 'format' ));
	$post_metas = array('type' => get_post_meta( get_the_ID(), 'type', true ),
	                    'reference' => get_post_meta( get_the_ID(), 'reference', true ));
	
	set_query_var( 'post_datas', array( 'taxonomies' => $post_taxonomies, 'metas' => $post_metas ) );
	get_template_part( 'partials/content-photo' );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}

endwhile;

get_footer();
