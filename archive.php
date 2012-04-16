<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>
	
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h2><?php single_cat_title(); ?></h2>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h2><?php _e("Posts Tagged","storefrontal"); ?> &#8216;<?php single_tag_title(); ?>&#8217;</h2>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h2><?php _e("Archive for","storefrontal"); ?> <?php the_time('F jS, Y'); ?></h2>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h2><?php _e("Archive for","storefrontal"); ?> <?php the_time('F, Y'); ?></h2>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h2><?php _e("Archive for","storefrontal"); ?> <?php the_time('Y'); ?></h2>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h2><?php _e("Author Archive","storefrontal"); ?></h2>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h2><?php _e("Blog Archives","storefrontal"); ?></h2>
	<?php } ?>
	<?php while (have_posts()) : the_post(); ?>
	<div class="post">
		<div class="info">
			<?php
				$thumbnail = get_the_post_thumbnail(get_the_ID(), 'small-post-thumbnail');
				if($thumbnail):
			?>
			<a href="<?php the_permalink(); ?>" class="img-holder"><?php echo $thumbnail; ?></a>
			<?php endif; ?>
			<dl>
				<dt><?php _e("posted on","storefrontal"); ?></dt>
				<dd class="date"><?php the_time('m.d.Y') ?></dd>
				<dt><?php _e("author","storefrontal"); ?></dt>
				<dd><?php the_author(); ?></dd>
				<dt><?php _e("category","storefrontal"); ?></dt>
				<dd><?php the_category(', ') ?></dd>
			</dl>
			<ul class="social-networks">
				<li><span class="st_sharethis_custom" st_title="<?php the_title(); ?>" st_url="<?php the_permalink(); ?>"><a href="#"><?php _e("Share","storefrontal"); ?></a></span></li>
			</ul>
			<script charset="utf-8" type="text/javascript">var switchTo5x=true;</script><script charset="utf-8" type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'wp.288d6450-b79b-4e29-b296-832c0416885d'});var st_type='wordpress3.2.1';</script>
		</div>
		<div class="text">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e("Permanent Link to","storefrontal"); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>" class="more"><?php _e("Keep Reading","storefrontal"); ?></a>
		</div>
	</div>
	<?php endwhile; ?>

	<?php storefrontal_navigation(); ?>
	
	<?php else : ?>
	<div class="post">
		<?php storefrontal_the_404_content(); ?>
	</div>
	<?php endif; ?>
	
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
