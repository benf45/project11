<?php
/**
 * Template part for displaying home
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 *
 */

?>


<?php

$args = array('post_type' => 'photo',
			  'tax_query' => array(array('taxonomy' => 'format',
										 'field' => 'slug',
										 'terms' => 'paysage',
										 'operator' => 'IN')),
			  'orderby' => 'rand',
			  'posts_per_page' => '1');
$banner_photo = new wp_query($args);
$banner = array();

// The Loop
if ( $banner_photo->have_posts() ){

	while ( $banner_photo->have_posts() ) { 
		$banner_photo->the_post();
		
		$banner['image'] = wp_get_attachment_url( get_post_thumbnail_id());

	};
}
wp_reset_query();

$post_types = get_post_types(array('name' => 'photo')); 
$taxonomies = array();

foreach ( $post_types as $key => $post_type ) {

	$taxonomy_names = get_object_taxonomies( $post_type );
	
    foreach($taxonomy_names as $taxonomy_name){

	    $terms = get_terms( $taxonomy_names, array( 'hide_empty' => false ));

	    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){

		    foreach ( $terms as $term ) {

		        if($term->taxonomy == $taxonomy_name){

					$taxonomies[$term->taxonomy]['taxonomy'] = array('slug' => $term->taxonomy);
                    $taxonomies[$term->taxonomy]['terms'][] = array('id' => $term->term_id, 'name' => $term->name,
					                                               'slug' => $term->slug, 'taxonomy' => $term->taxonomy);

		        }

	        }
	    }
    }

}

?>

<div <?php post_class(); ?>>

    <section class="banner_section" style="background-image: url(<?php echo $banner['image'];?>)">

        <div class="banner_content flex_row">

	        <h1 class="text-center">PHOTOGRAPHE EVENT</h1>

        </div>

    </section>

    <div class="container">
	
	    <div class="content-area home-content-area">

            <section class="filter_section">

                <div class="filter_content flex_row">

		            <form id="photo_filter_form" class="photo_filter_form flex_row">

					    <div class="filter_group_first">

						    <div class="filter_group_first_select">
		                        <label for="categorie-select">Catégories:</label>

                                <select name="<?php echo $taxonomies['categorie']['taxonomy']["slug"] ;?>" id="<?php echo $taxonomies['categorie']['taxonomy']["slug"] ;?>-select">
                                    <option value=""></option>
                                <?php

                                    if ($taxonomies){

                                        foreach ($taxonomies['categorie']['terms'] as $term){
                                ?>

                                    <option value="<?php echo $term['slug'] ;?>"><?php echo $term['name'] ;?></option>

                                <?php


                                        }

                                    }

                                ?>

                                </select>
                            </div>
                            
							<div class="filter_group_first_select">
		                        <label for="format-select">Formats:</label>

                                <select name="<?php echo $taxonomies['format']['taxonomy']["slug"] ;?>" id="<?php echo $taxonomies['format']['taxonomy']["slug"] ;?>-select">
                                    <option value=""></option>
                                <?php

                                    if ($taxonomies){

                                        foreach ($taxonomies['format']['terms'] as $term){
                                ?>

                                    <option value="<?php echo $term['slug'] ;?>"><?php echo $term['name'] ;?></option>
                                    
                                <?php


                                        }

                                    }

                                ?>
                                </select>
                            </div>

                        </div>

					    <div class="filter_group_second">

						    <div class="filter_group_second_select">
		                        <label for="filterby-select">Trier par:</label>

                                <select name="filter-by" id="filterby-select">
                                    <option value="new" selected>Nouveautés</option>
                                    <option value="oldest">Les plus anciens</option>
                                </select>
                            </div>
                           
                        </div>

                    </form>
                

                </div>

            </section>

            <section class="photo_section">

                <div class="photo_content flex_row">

                <?php

                    $args = array('post_type' => 'photo',
                                  'posts_per_page' => '12',
                                  'orderby' => 'date',
                                  'order' => 'DESC');
                    $all_photos = new wp_query($args);

                    // The Loop
                    if ( $all_photos->have_posts() ){

                ?>

                    <div class="photo_box_wrapper flex_row">
                <?php
                    while ( $all_photos->have_posts() ) { 
                        $all_photos->the_post();

                        get_template_part( 'partials/photo_block' );

                    };
                ?>
                    </div>

                <?php  
                    };
                    wp_reset_query();

                ?>

                </div>

                <div class="photo_content_btn flex_row">

                    <button class="load_more_btn">Charger plus</button>

                </div>

            </section>
			
        </div>
		
    </div>

</div>
