<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>

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
				<dt>posted on</dt>
				<dd class="date"><?php the_time('m.d.Y') ?></dd>
				<dt>author</dt>
				<dd><?php the_author(); ?></dd>
				<dt>category</dt>
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
	<?php if(function_exists('wp_pagenavi')) : ?>
	<div class="paging">
		<div class="paging-holder">
			<div class="paging-frame">
				<?php wp_pagenavi(); ?>
			</div>
		</div>
	</div>
	<?php else : ?>
		<div class="navigation">
			<div class="next"><?php next_posts_link(__('Older Entries &raquo;','storefrontal')) ?></div>
			<div class="prev"><?php previous_posts_link(__('&laquo; Newer Entries','storefrontal')) ?></div>
		</div>
	<?php endif; ?>
	
	<?php else : ?>
	<div class="post">
		<h2><?php _e("Not Found","storefrontal"); ?></h2>
		<p><?php _e("Sorry, but you are looking for something that isn't here.","storefrontal"); ?></p>
	</div>
	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
