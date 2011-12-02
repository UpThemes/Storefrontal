<?php get_header(); ?>

<div id="content">

	<?php if (have_posts()) : ?>
	
	<?php while (have_posts()) : the_post(); ?>
		<h2><?php the_title(); ?></h2>
		<?php
			$video_url = get_post_meta(get_the_ID(), 'video_url', true);
			if($video_url):
				if(strpos($video_url, 'youtube')):
					$video_id = getParameter($video_url, 'v');
					echo '<iframe width="600" height="400" src="http://www.youtube.com/embed/'.$video_id.'" frameborder="0" allowfullscreen></iframe>';
				elseif(strpos($video_url, 'vimeo')):
					$video_id = getVimeoID($video_url);
					echo '<iframe src="http://player.vimeo.com/video/'.$video_id.'?title=0&amp;byline=0&amp;portrait=0" width="600" height="400" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';
				endif;
			endif;
		?>
		<?php $audio_files = get_audio_files(get_the_ID());?>
			<?php
				if(is_array($audio_files)){
					if (function_exists("insert_audio_player")) {
						foreach($audio_files as $audio_file){
							insert_audio_player("[audio:$audio_file]");  
						}
					}
				}
		?>
		<?php the_content(); ?>
	<?php comments_template(); ?>
	
	<?php endwhile; ?>
	
	<div class="navigation">
		<div class="next"><?php previous_post_link('%link &raquo;') ?></div>
		<div class="prev"><?php next_post_link('&laquo; %link') ?></div>
	</div>
	
	<?php else : ?>
		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>
	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
