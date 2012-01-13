<?php
/*
Template Name: Home page
*/
?>
<?php get_header(); ?>
<div class="carousel">
	<?php query_posts(array('post_type' => 'slide', 'showposts' => -1)); ?>
	<?php if (have_posts()) : ?>
	<div class="frame">
		<ul>
		<?php $cnt = 0; ?>
		<?php while (have_posts()) : the_post(); ?>
			<li>
				<?php the_post_thumbnail('full'); ?>
				<div class="text-holder">
					<h2><?php the_title(); ?></h2>
					<span><?php echo get_post_meta(get_the_ID(),'slide_blurb',true); ?></span>
					<?php $link = get_post_meta(get_the_ID(), 'link', true); ?>
					<a href="<?php echo $link ? $link : get_permalink(); ?>"><?php _e("shop this style &raquo;","storefrontal"); ?></a>
				</div>
			</li>
		<?php $cnt++; ?>
		<?php endwhile; ?>
		</ul>
	</div>
	<ul class="switcher">
		<?php for($i = 0; $i < $cnt; $i++):?>
		<li><a href="#"><?php echo $i;?></a></li>
		<?php endfor; ?>
	</ul>
	<a href="#" class="link-prev"><?php _e("prev","storefrontal"); ?></a>
	<a href="#" class="link-next"><?php _e("next","storefrontal"); ?></a>
	<?php else : ?>
	<?php the_404_content(); ?>
	<?php endif; wp_reset_query(); ?>
</div>
<?php if( function_exists('wpsc_have_products') ): ?>
	<?php get_template_part('loop','wpsc'); ?>
<?php endif; ?>
<div class="block-holder">
	<?php get_sidebar('home-1'); ?>
	<?php get_sidebar('home-2'); ?>
	<?php get_sidebar('home-3'); ?>
</div>
<?php get_footer(); ?>
