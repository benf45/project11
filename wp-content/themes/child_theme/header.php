<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="site-content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Go
 */

$header_flex_class = in_array( get_theme_mod( 'header_variation', \Go\Core\get_default_header_variation() ), array( 'header-6' ), true ) ? '' : ' flex';

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body
	<?php
	$body_class = get_body_class();
	if ( Go\AMP\is_amp() ) {
		?>
		aria-expanded="false"
		[aria-expanded]="mainNavMenuExpanded ? 'true' : 'false'"
		[class]="'<?php echo esc_attr( implode( ' ', $body_class ) ); ?>' + ( mainNavMenuExpanded ? ' menu-is-open' : '' )"
		<?php
	}
	?>
	class="<?php echo esc_attr( implode( ' ', $body_class ) ); ?>"
>

	<?php wp_body_open(); ?>

	<div id="page" class="site">

		<a class="skip-link screen-reader-text" href="#site-content"><?php esc_html_e( 'Skip to content', 'go' ); ?></a>

		<header id="site-header" class="site-header header relative <?php echo esc_attr( Go\has_header_background() ); ?> <?php echo esc_attr( get_theme_mod( 'header_variation' ) ); ?>" role="banner" itemscope itemtype="http://schema.org/WPHeader">

			<div class="header__inner<?php echo esc_attr( $header_flex_class ); ?> items-center justify-between h-inherit w-full relative">


				<div class="header__title-nav<?php echo esc_attr( $header_flex_class ); ?> items-center flex-nowrap">

					<?php Go\display_site_branding(); ?>

					<?php if ( has_nav_menu( 'primary' ) ) : ?>

						<nav id="header__navigation" class="header__navigation" aria-label="<?php esc_attr_e( 'Horizontal', 'go' ); ?>" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">

							<div class="header__navigation-inner">
								<?php
								wp_nav_menu(
									array(
										'menu_class'     => 'primary-menu list-reset',
										'theme_location' => 'primary',
									)
								);
								?>
							</div>

						</nav>

					<?php endif; ?>

				</div>


				<div class="header__nav-toggle">
				    <button id="nav-toggle" class="nav-toggle" type="button" aria-controls="header__navigation" aria-expanded="false">
			            <div class="nav-toggle-icon">
			                <span class="dashicons dashicons-menu-alt3"></span>
			            </div>
			            <div class="nav-toggle-icon nav-toggle-icon--close">
			                <span class="dashicons dashicons-no-alt"></span>
			            </div>
			            <span class="screen-reader-text">Menu</span>
		            </button>
	            </div>

			</div>

			

		</header>

		<main id="site-content" class="site-content" role="main">
