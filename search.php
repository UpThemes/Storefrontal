<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>

	<div class="post">
		<div class="title">
			<h1><?php _e("Search Results","storefrontal"); ?></h1>
		</div>
	</div>

	<?php while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<div class="title">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e("Permanent Link to","storefrontal"); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		</div>
		<div class="content">
			<?php the_excerpt(_e("Read the rest of this entry &raquo;","storefrontal")); ?>
		</div>
	</div>
	<?php endwhile; ?>
	
	<?php storefrontal_navigation(); ?>
	
	<?php else : ?>
		<?php the_404_content(); ?>
	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
