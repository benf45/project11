<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Go
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<!--<?php if ( is_singular() && has_post_thumbnail() ) : ?>
		<div class="post__thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php endif; ?>-->

	<header class="entry-header m-auto px">

		

		<?php Go\post_meta( get_the_ID(), 'top' ); ?>

	</header>

	<div class="<?php Go\content_wrapper_class( 'content-area__wrapper' ); ?>">

		<div class="content-area">

		    <div class="photo_header flex_row">
		        <div class="single_photo_content">
				    <?php
		            if ( is_singular() ) :
			        the_title( '<h1 class="post__title entry-title m-0">', '</h1>' );
		            else :
			        the_title( sprintf( '<h2 class="post__title entry-title m-0"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		            endif;
		            ?>
					<p>Référence : 34BR567</p>
					<p>Catégorie : MARIAGE</p>
					<p>FORMAT : 1/1</p>
					<p>Type : ARGENTIQUE</p>
					<p>ANNÉE : 2021</p>
                </div>

                <div class="single_photo_thumb">

			        <?php if ( is_singular() && has_post_thumbnail() ) : ?>
		            <div class="">
			            <?php the_post_thumbnail(); ?>
		            </div>
	                <?php endif; ?>

	            </div>
			</div>

			<div class="photo_contact_wrapper flex_row">

			    <div class="photo_contact_button">
			        <span>Cette photo vous intéresse ?</span>
				    <a class="button" href="#">Contact</a>
				</div>

			    <div class="photo_contact_img flex_col">

				    <?php if ( is_singular() && has_post_thumbnail() ) : ?>
		            <div class="single_photo_next_img">
			            <?php the_post_thumbnail(); ?>
		            </div>
	                <?php endif; ?>
					<div class="single_photo_next_nav">
				        <span class="photo_next_arrow_left"><img src="<?php echo get_stylesheet_directory_uri().'/partials/layouts/images/arrow_left.png'; ?>"></span>
				        <span class="photo_nnext_arrow_right"><img src="<?php echo get_stylesheet_directory_uri().'/partials/layouts/images/arrow_right.png'; ?>"></span>
				    </div>
				</div>

			</div>

			<?php
			if ( is_search() || ( get_theme_mod( 'blog_excerpt', false ) && is_home() ) ) {
				the_excerpt();
			} else {
				the_content();
			}
			wp_link_pages(
				array(
					'before' => '<nav class="post-nav-links" aria-label="' . esc_attr__( 'Page', 'go' ) . '"><span class="label">' . __( 'Pages:', 'go' ) . '</span>',
					'after'  => '</nav>',
				)
			);
			?>
		</div>

		<?php
		if ( is_singular() ) {
			Go\post_meta( get_the_ID(), 'single-bottom' );
		}
		?>

	</div>

</article>
