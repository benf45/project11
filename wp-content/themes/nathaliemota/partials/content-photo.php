<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

?>

<div class="container">
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div>
	
		<div class="content-area photo-content-area">

		    <div class="photo_header flex_row">
		        <div class="single_photo_content">
				    <?php
		            if ( is_singular() ) :
			        the_title( '<h1 class="post__title entry-title text-break">', '</h1>' );
		            else :
			        the_title( sprintf( '<h2 class="post__title entry-title m-0"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		            endif;
		            ?>
					<p class="single_photo_ref" data-reference="<?php echo mb_strtoupper($post_datas['metas']['reference'], 'UTF8'); ?>">
		                Référence : <?php echo mb_strtoupper($post_datas['metas']['reference'], 'UTF8'); ?>
					</p>
					<p class="single_photo_cat">Catégorie : <?php echo mb_strtoupper($post_datas['taxonomies']['categorie'][0]->name, 'UTF8'); ?></p>
					<p class="single_photo_for">FORMAT : <?php echo mb_strtoupper($post_datas['taxonomies']['format'][0]->name, 'UTF8'); ?></p>
					<p class="single_photo_type">Type : <?php echo mb_strtoupper($post_datas['metas']['type'], 'UTF8'); ?></p>
					<p class="single_photo_date">ANNÉE : <?php echo the_date('Y'); ?></p>
                </div>

                <div class="single_photo_thumb">

			        <?php if ( is_singular() && has_post_thumbnail() ) : ?>
		            <div>
			            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt="<?php the_title();?>">

						<?php
                        $terms_post = get_the_terms( get_the_ID(), 'categorie' );

                        //We get the image title
                        $image_id = get_post_thumbnail_id();
                        $image_title = get_the_title($image_id);

                        ?>

						<div class="photo_overlay">

                            

							<div class="show_lightbox_icon lightbox_open" data-post-title="<?php echo $image_title; ?>" 
							                                              data-post-date="<?php echo get_the_date('Y'); ?>" 
											                              data-post-id="<?php echo get_the_ID(); ?>" 
											                              data-post-term="<?php if($terms_post){ echo $terms_post[0]->name;} ?>" 
											                              data-image-path="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>">
		
								<img src="<?php echo get_stylesheet_directory_uri() ;?>/dist/images/fullscreen.svg" alt="Plein écran">
		
                            </div>
                            

						</div>

		            </div>
	                <?php endif; ?>

	            </div>
			</div>

			<div class="photo_contact_wrapper flex_row">

			    <div class="photo_contact_button">
			        <span>Cette photo vous intéresse ?</span>
					<button class="button modal_open">Contact</button>
				</div>

			    <div class="photo_contact_img flex_col">

				<?php
                $next_post = get_next_post(false);

				if ( is_singular() && $next_post ){ ?>

		            <div class="single_photo_next_img">
						<img src="<?php echo get_the_post_thumbnail_url($next_post); ?>" alt="<?php the_title();?>">
		            </div>

	            <?php }else{ ?>

                    <div class="single_photo_next_img">
						<img src="<?php echo get_the_post_thumbnail_url($next_post); ?>" alt="<?php the_title();?>">
                    </div>

                <?php } ?>

					<div class="single_photo_next_nav">

				        <span class="photo_next_arrow_left">   
						    <?php echo previous_post_link('%link', '<img src="'.get_stylesheet_directory_uri().'/partials/layouts/images/arrow_leftb.png" alt="Fléche gauche">');?>
						</span>

				        <span class="photo_next_arrow_right">
							<?php echo next_post_link('%link', '<img src="'.get_stylesheet_directory_uri().'/partials/layouts/images/arrow_rightb.png" alt="Fléche droite">');?>
						</span>

				    </div>
				</div>

			</div>

			<div class="related_photo_wrapper flex_col">

                <h2>Vous aimerez aussi</h2>

				<?php

                $args = array('post_type' => 'photo',
				              'tax_query' => array(array('taxonomy' => 'categorie',
							                             'field' => 'slug',
														 'terms' => $post_datas['taxonomies']['categorie'][0]->slug,
														 'operator' => 'IN')),
							  'orderby' => 'rand',
							  'posts_per_page' => '2');
                $related_photo = new wp_query($args);
               
                // The Loop
                if ( $related_photo->have_posts() ){
	            
				?>

				<div class="photo_box_wrapper flex_row">
                <?php
				while ( $related_photo->have_posts() ) { 
					$related_photo->the_post();
					
				    get_template_part( 'partials/photo_block' );

				};
				?>
				</div>

				<?php  
				};
                wp_reset_query();
                ?>

				<div class="single_related_photo_btn flex_row">
				    <a class="button" href="<?php echo get_home_url(); ?>">Toutes les photos</a>
				</div>

			</div>

			
		</div>


	</div>

</article>
</div>