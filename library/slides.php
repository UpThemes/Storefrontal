<?php

/*
 * Custom Content Type for Series
 ***********************************************/

function slides_init() {

	wp_enqueue_script('metab-jquery', get_template_directory_uri() . '/library/scripts/metaboxes.jquery.js', array('jquery'));
	wp_enqueue_script('sundance', get_template_directory_uri() . '/library/scripts/global.js', array('jquery','fancybox'));
    wp_enqueue_style('metaboxes', get_template_directory_uri() . "/library/styles/metaboxes.css", false, false, false);

	$icon =  trailingslashit( get_template_directory_uri() ).'images/slides_icon.png';
	
	$show_labels = array(
		'name' => __( 'Slides','storefrontal' ),
		'singular_name' => __( 'Slide','storefrontal' ),
		'add_new' => __( 'Add New','storefrontal' ),
		'add_new_item' => __( 'Add New Slide','storefrontal' ),
		'edit' => __( 'Edit','storefrontal' ),
		'edit_item' => __( 'Edit Slides','storefrontal' ),
		'new_item' => __( 'New Slide','storefrontal' ),
		'view' => __( 'View Slides','storefrontal' ),
		'view_item' => __( 'View Slide','storefrontal' ),
		'search_items' => __( 'Search Slides','storefrontal' ),
		'not_found' => __( 'No slides found','storefrontal' ),
		'not_found_in_trash' => __( 'No slides found in Trash','storefrontal' ),
		'parent' => __( 'Parent Slide','storefrontal' ),
	);
	
	$args = array(
    	'labels' => $show_labels,
    	'menu_icon' => $icon,
		'public' => false,
		'show_ui' => true,
		'capability_type' => 'page',
		'hierarchical' => true,
		'menu_position' => 10,
		'register_meta_box_cb' => 'slides_custom_meta',
		'taxonomies' => array(),
		'rewrite' => false,
		'supports' => array('title', 'thumbnail', 'page-attributes')
	);

	register_post_type( 'slide' , $args );

}

add_action( 'init', 'slides_init' );

function get_slides_meta(){

	return array(
				array(
				'id' => 'slide_uploader',
				'name' => __('Slide Image','storefrontal'),
				'descr' => __('Upload the slide image.','storefrontal'),
				'type' => 'media_uploader'
				 ),
				 array(
				'id' => 'slide_related_content',
				'name' => __('Related Post or Product','storefrontal'),
				'descr' => __('Select a post or product to associate with this slide.','storefrontal'),
				'type' => 'related_post',
				'options' => array('post_types' => array('post','wpsc-product'))
				),
				array(
				'id' => 'slide_blurb',
				'name' => __('Slide Subtitle','storefrontal'),
				'descr' => __('Appears below the title.','storefrontal'),
				'type' => 'textarea'
				 ),
				array(
				'id' => 'slide_link',
				'name' => __('Slide links to','storefrontal'),
				'descr' => __('Enter the full URL or where you would like the slide to link','storefrontal'),
				'type' => 'text',
				),
				array(
				'id' => 'slide_hidden',
				'name'=>'',
				'descr'=>'',
				'type'=>'hidden',
				'hidden_val'=>get_admin_url()
				)
				);
				
}

function slides_custom_init(){

	if( get_post_type($_REQUEST['post']) == 'slide' ):
	    wp_enqueue_style('metaboxes');
		wp_enqueue_script('metab-jquery');
	endif;

}

add_action("admin_print_styles-post.php", 'slides_custom_init',0);  
add_action("admin_print_styles-post-new.php", 'slides_custom_init',0);  

function slides_custom_meta(){
	add_meta_box( 'slides_metabox', __('Slide Details', 'storefrontal'), 'slides_metabox_output', 'slide' ,'normal', 'high' );
}

function slides_metabox_output(){

	global $post;

	$slides_custom_meta = get_slides_meta();
	?>
	<p class="meta item">
	Upload an image or select an existing image from the Media Library:
	<a class="button thickbox" href="<?php echo get_admin_url(); ?>media-upload.php?post_id=<?php echo $post->ID; ?>&TB_iframe=1" id="upload-attachments" style="margin:5px;">Set/Update Featured Image</a>
	<br><em>Slide image size: 960px X 340px</em>
	</p>
	<?php
	foreach( $slides_custom_meta as $meta ):
	
		meta_handler($meta);

	endforeach;
	
}

function save_slides(){

	global $post;

	$slides_custom_meta = get_slides_meta();

	if($_REQUEST['action'] != 'autosave'):
	
		foreach( $slides_custom_meta as $meta ):
				update_post_meta($post->ID, $meta['id'], $_REQUEST[$meta['id']]);
		endforeach;
		
	endif;
	
}

function slides_columns($columns) {
		unset($columns['categories']); 
	    $columns['slides_image'] = 'Slide';
	    $columns['menu_order'] = 'Order';
    return $columns;
}

function slides_columns_output($name) {
    global $post;
    switch ($name) {
        case 'slides_image':
        	$img = get_the_post_thumbnail($post->ID, 'carousel', array('class'=>'edit-columns-slide-image'));
            echo $img;
           break;
         case 'menu_order':
         	echo $post->menu_order;
         	break;
    }
}

function ajaxPopulate() {
	global $post;
	$post = &get_post($id = $_POST['pid']);
	$guid = get_permalink($_POST['pid']);
	$excerpt = get_post_meta($post->ID,'subtitle',true);
	if(!$excerpt) {	$excerpt = substr(strip_tags($post->post_content), 0 , 100) . ' ... '; }
	$x = new WP_Ajax_Response( 
		array(
		   'what' => 'autosave',
		   'id' => $post->ID,
		   'data' => 'Success',
		   'supplemental' => array('post_title'=>$post->post_title,'post_ID'=> $post->ID, 'guid'=>$guid, 'content'=>$excerpt)
		));
	$x->send();
}

add_action('wp_ajax_up_ajax_populate','ajaxPopulate');
add_action('manage_pages_custom_column',  'slides_columns_output');
add_filter('manage_edit-slides_columns', 'slides_columns');
add_action('save_post','save_slides');