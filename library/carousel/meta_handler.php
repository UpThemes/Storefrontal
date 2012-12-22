<?php

function get_meta_handler( $meta ){

	global $post;

	switch ($meta['type']) {
			case 'text':
				echo '<p class="meta item">';
				echo '<label>' . $meta['name'] . '</label>';
				echo '<input type="text" id="' . $meta['id'] . '" name="' . $meta['id'] . '" value="' . get_post_meta($post->ID,$meta['id'],true) . '">';
				echo '<kbd>' . $meta['descr'] . '</kbd>';
				echo '</p>';
				break;
			case 'textarea':
				echo '<p class="meta item">';
				echo '<label>' . $meta['name'] . '</label>';
				echo '<textarea type="text" cols="60" rows="4" id="' . $meta['id'] . '" name="' . $meta['id'] . '">' . get_post_meta($post->ID,$meta['id'],true) . '</textarea><br/>';
				echo '<kbd>' . $meta['descr'] . '</kbd>';
				echo '</p>';
				break;
			case 'checkbox':
				echo '<p class="meta item">';
				echo '<label>' . $meta['name'] . '</label>';
				echo '<input type="checkbox" value="1" id="' . $meta['id'] . '" name="' . $meta['id'] . '" ';
				if( get_post_meta($post->ID,$meta['id'],true) ) echo "checked";
				echo '>';
				echo '<kbd>' . $meta['descr'] . '</kbd>';
				echo '</p>';
				break;
			case 'video':
				echo '<p class="meta item">';
				echo '<label>' . $meta['name'] . '</label>';
				echo '<input type="text" id="' . $meta['id'] . '" name="' . $meta['id'] . '" value="' . get_post_meta($post->ID,$meta['id'],true) . '">';
				echo '<kbd>' . $meta['descr'] . '</kbd>';
				echo '</p>';
				break;
			case 'media_uploader':
				echo '<div class="show-image">';
				if(has_post_thumbnail($post->ID)) { echo get_the_post_thumbnail($post->ID, 'carousel', array('class' => 'meta-box-image')); }
				echo '</div>';
				break;
			case 'attachment':
				echo '<p class="meta item attachment-field">';
				echo '<label>' . $meta['name'] . '</label>';
				$old = get_post_meta($post->ID, $meta['id'],true); 
				$options = get_posts(array('post_type'=>'attachment', 'post_parent'=> $post->ID ));
				if(!$options) { echo '<span>There are currently no attachments to this post</span><br>';}
				else {
				echo '<select id="'.$meta['id'] .'" name="'.$meta['id'].'" class="'.$meta['id'].'" style="float:left;margin:5px;">';
				echo "<option value=''>Select ... </option>";
					foreach($options as $option) {	 
						if($option->ID == $old) { $sel = 'selected'; } else { $sel = ''; }
						echo "<option value=\"$option->ID\"  $sel>$option->post_title</option>";	
					} 
				echo '</select>';
				} 
				echo '<a href="#" class="button insert-media add_media" data-editor="content" title="'. __("Add Media") . '"><span class="wp-media-buttons-icon"></span> '. __("Add Media") . '</a>';
				echo '</p>';
				echo '<div class="clear:both;"></div>';
			break;
		}
		
}

	function meta_handler( $meta ){
		echo get_meta_handler( $meta );	
	}