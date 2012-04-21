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

		<?php the_content(); ?>

		<?php comments_template(); ?>

	</div>
</div>