<?php

// Custom Text Widget without <div>
class Custom_Widget_Text extends WP_Widget {

	function Custom_Widget_Text() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __('Arbitrary text or HTML'));
		$control_ops = array('width' => 400, 'height' => 350);
		$this->WP_Widget('text', __('Text'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$text = apply_filters( 'widget_text', $instance['text'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
			<?php echo $instance['filter'] ? wpautop($text) : $text; ?>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = esc_textarea($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("Custom_Widget_Text");'));

class WP_Widget_Post_Formats extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'widget_post_formats ', 'description' => __( "The most recent posts on your site (post formats)") );
		parent::__construct('post-formats', __('Post Formats'), $widget_ops);
		$this->alt_option_name = 'widget_post_formats';
	}

	function widget($args, $instance) {
		static $post_offset = array();

		ob_start();
		extract($args);
		$widgets = wp_get_sidebars_widgets();
		$format = $instance['format'];
		
		$post_offset[$format] = isset($post_offset[$format]) ? $post_offset[$format]+1 : 0;
		$r = new WP_Query(array(
					'no_found_rows' => true,
					'post_status' => 'publish',
					'ignore_sticky_posts' => true,
					'posts_per_page' => 1,
					'offset' => $post_offset[$format],
					'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'terms' => array($format),
									'field' => 'slug',
									'operator' => 'IN',
								),
					)));
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php  while ($r->have_posts()) : $r->the_post(); ?>
		<?php
			$current_format = get_post_format(get_the_ID());
			if($current_format == 'image'):
		?>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php
				$thumbnail = get_the_post_thumbnail(get_the_ID(), 'widget-thumbnail');
				if($thumbnail):
				$image_src =  wp_get_attachment_image_src( get_post_thumbnail_id(), 'full')
			?>
			<a href="<?php echo $image_src[0]; ?>" rel="adventure" class="video-holder view"><span>&nbsp;</span><?php echo $thumbnail; ?></a>
			<?php endif; ?>
			<span class="comments"><?php comments_popup_link('0 comments', '1 comment', '% comments'); ?></span>
		<?php elseif($current_format == 'audio'): ?>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php $audio_files = get_audio_files(get_the_ID());?>
			<?php if (function_exists("insert_audio_player")) {
					foreach($audio_files as $audio_file){
						insert_audio_player("[audio:$audio_file]");  
					}
				}
			?>
			<span class="comments"><?php comments_popup_link('0 comments', '1 comment', '% comments'); ?></span>
		<?php elseif($current_format == 'link'): ?>
			<?php
				$link = get_post_meta(get_the_ID(), 'link', true);
				if($link):
			?>
				<h3><a href="<?php echo $link; ?>"><?php echo $link; ?></a></h3>
			<?php endif; ?>
			<div class="text-block">
				<div class="update">
				<?php the_excerpt(); ?>
				</div>
			</div>
			<span class="comments"><?php comments_popup_link('0 comments', '1 comment', '% comments'); ?></span>
		<?php elseif($current_format == 'quote'): ?>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<div class="text-block">
				<blockquote>
					<q><?php echo get_the_excerpt(); ?></q>
				</blockquote>
			</div>
			<span class="comments"><?php comments_popup_link('0 comments', '1 comment', '% comments'); ?></span>
		<?php elseif($current_format == 'video'): ?>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php
				$video_url = get_post_meta(get_the_ID(), 'video_url', true);
				if($video_url):
			?>
			<a href="<?php the_permalink(); ?>" class="video-holder">
			<?php
				if(strpos($video_url, 'youtube')):
					$video_id = getParameter($video_url, 'v');
					getThumbnailVideo($video_id, 'youtube');
				elseif(strpos($video_url, 'vimeo')):
					$video_id = getVimeoID($video_url);
					getThumbnailVideo($video_id, 'vimeo');
				endif;
			?>
			</a>
			<?php endif; ?>
			<span class="comments"><?php comments_popup_link('0 comments', '1 comment', '% comments'); ?></span>
		<?php endif; ?>
		<?php endwhile; ?>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['format'] = strip_tags($new_instance['format']);

		return $instance;
	}

	function form( $instance ) {
		$format = isset($instance['format']) ? esc_attr($instance['format']) : '';
		$formats = get_terms('post_format');
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>Choosing a Post Format:</p>
		<?php foreach($formats as $f): ?>
		<p>
			<input id="<?php echo $f -> slug; ?>" name="<?php echo $this->get_field_name('format'); ?>" type="radio" value="<?php echo $f -> slug; ?>" <?php echo $f -> slug == $format ? 'checked="checked"' : ''; ?> />
			<label for="<?php echo $f -> slug; ?>"><?php echo $f -> name; ?></label>
		</p>
		<?php endforeach; ?>

<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_Post_Formats");'));
?>