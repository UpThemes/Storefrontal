<?php get_header(); ?>

<div id="content">

	<?php if (have_posts()) : ?>
	
	<?php while (have_posts()) : the_post(); ?>
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
		<?php storefrontal_navigation(); ?>
	<?php endwhile; ?>
	
	<?php else : ?>
		<?php the_404_content(); ?>
	<?php endif; ?>
	
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
