<?php
/**
 * Template part for displaying photo block
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Go
 */

?>

<div class="photo_block"><a href="<?php echo get_permalink(get_the_ID());?>"><?php the_post_thumbnail('medium_large') ?></a></div>