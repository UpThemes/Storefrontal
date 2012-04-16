<?php get_header(); ?>

<div id="content">

	<?php if (have_posts()) : ?>
	
	<?php while (have_posts()) : the_post(); ?>
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
		
		<?php comments_template(); ?>
	
	<?php endwhile; ?>
	
	<?php storefrontal_navigation(); ?>
	
	<?php else : ?>

		<?php storefrontal_the_404_content(); ?>

	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
