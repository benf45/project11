<?php
/**
 * Template part for displaying photo block
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Go
 */

?>

<a href="<?php echo get_permalink(get_the_ID());?>"><div class="photo_block"><?php the_post_thumbnail('medium_large') ?></div></a>