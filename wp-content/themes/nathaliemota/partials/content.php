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

	<?php if ( is_singular() && has_post_thumbnail() ) : ?>
		<div class="post__thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php endif; ?>

	<header class="entry-header m-auto px">

		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="post__title entry-title mt-5 mb-4 text-center">', '</h1>' );
		else :
			the_title( sprintf( '<h2 class="post__title entry-title m-0"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		endif;
		?>

	</header>

	<div>

		<div class="content-area entry-content">
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


	</div>

</article>

</div>