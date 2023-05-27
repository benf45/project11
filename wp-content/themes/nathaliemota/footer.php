<?php
/**
 * The template for displaying the footer.
 *
 *
 */

?>

	    </main>

	<?php
    get_template_part( 'partials/modal' );
	get_template_part( 'partials/lightbox' );
	?>

	</div>

    <!-- Footer -->
    <footer class="text-center">

        <!-- Section: Links  -->
        <section class="border-top">

            <div class="container-fluid text-center text-md-start">
  <?php
                wp_nav_menu(array(
                    'theme_location'    => 'footer_menu',
                    'depth'             => 2,
                    'container'         => 'div',
					'menu_class'        => 'nav footer-nav flex_row',
                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                    'walker'            => new WP_Bootstrap_Navwalker(),
                ));
?>		
            </div>
        </section>
    </footer>
    <!-- Footer -->

    <?php wp_footer(); ?>

	</body>
</html>
