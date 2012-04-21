<?php get_header(); ?>

<div id="content">

	<?php if ( have_posts() ) : ?>
	
	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part('content',get_post_format()); ?>
	
	<?php endwhile; ?>
	
	<?php storefrontal_navigation(); ?>
	
	<?php else : ?>

		<?php storefrontal_the_404_content(); ?>

	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
