<?php get_header(); ?>

<div id="content">
	<?php if (have_posts()) : ?>
	
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h2><?php single_cat_title(); ?></h2>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h2>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h2>Archive for <?php the_time('F jS, Y'); ?></h2>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h2>Archive for <?php the_time('F, Y'); ?></h2>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h2>Archive for <?php the_time('Y'); ?></h2>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h2>Author Archive</h2>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h2>Blog Archives</h2>
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
				<dt>posted on</dt>
				<dd class="date"><?php the_time('m.d.Y') ?></dd>
				<dt>author</dt>
				<dd><?php the_author(); ?></dd>
				<dt>category</dt>
				<dd><?php the_category(', ') ?></dd>
			</dl>
			<ul class="social-networks">
				<li><span class="st_sharethis_custom" st_title="<?php the_title(); ?>" st_url="<?php the_permalink(); ?>"><a href="#">Share</a></span></li>
			</ul>
			<script charset="utf-8" type="text/javascript">var switchTo5x=true;</script><script charset="utf-8" type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'wp.288d6450-b79b-4e29-b296-832c0416885d'});var st_type='wordpress3.2.1';</script>
		</div>
		<div class="text">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>" class="more">KEEP READING</a>
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
			<div class="next"><?php next_posts_link('Older Entries &raquo;') ?></div>
			<div class="prev"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
		</div>
	<?php endif; ?>
	
	<?php else : ?>
	<div class="post">
		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>
	</div>
	<?php endif; ?>
	
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
