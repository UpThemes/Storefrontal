<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage StoreFrontal
 * @since StoreFrontal 1.0
 */

get_header(); ?>

<div id="content">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part('content',get_post_format()); ?>
		<?php storefrontal_navigation(); ?>
	<?php endwhile; ?>
	<?php else : ?>
		<?php get_template_part('content','none'); ?>
	<?php endif; ?>
</div><!--/#content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>