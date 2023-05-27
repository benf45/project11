<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="site-content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 *
 */


?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	
	<?php wp_head(); ?>
</head>

<body>

<?php wp_body_open(); ?>

<div id="page" class="site">

	<div class="container-fluid site-header">

		<!-- Header -->
		<header>
			<nav class="navbar navbar-expand-lg" id="navbar">
				<div class="container">
					<div>
						<?php
						if(!has_custom_logo()){
						?>

							<a class="navbar-brand text-dark" href="<?php bloginfo('url'); ?>"><?php bloginfo('name') ?></a>

						<?php
						}else{

							echo the_custom_logo();

						}
					   ?>
					</div>

					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header-menu" aria-controls="header-menu" aria-expanded="false" aria-label="Toggle navigation">
						<span><i class="navbar-toggler-icon bi bi-list"></i></span>
					</button>


<?php
			wp_nav_menu(array(
				'theme_location'    => 'header_menu',
				'depth'             => 2,
				'container'         => 'div',
				'container_class'   => 'collapse navbar-collapse',
				'container_id'      => 'header-menu',
				'menu_class'        => 'navbar-nav ml-auto',
				'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
				'walker'            => new WP_Bootstrap_Navwalker(),
			));
?>

				</div>
			</nav>
		</header>
	</div>

	<main id="site-content" class="site-content" role="main">