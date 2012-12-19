<?php

include_once('meta_handler.php');

/*
 * Custom Content Type for Series
 ***********************************************/

function storefrontal_slides_init() {

	add_image_size('carousel', 940, 400, true );

  wp_register_script('flexslider', trailingslashit( get_template_directory_uri() ) . 'library/carousel/flexslider/jquery.flexslider.js', array('jquery'), false );
  wp_register_style('flexslider-css', trailingslashit( get_template_directory_uri() ) . 'library/carousel/flexslider/flexslider.css' );
	$icon =  trailingslashit( get_template_directory_uri() ) . 'library/carousel/images/slides_icon.png';

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
		'register_meta_box_cb' => 'storefrontal_slides_custom_meta',
		'taxonomies' => array(),
		'rewrite' => false,
		'supports' => array('title', 'thumbnail', 'page-attributes')
	);

	register_post_type( 'slide' , $args );

}

add_action( 'after_setup_theme', 'storefrontal_slides_init' );

function storefrontal_slides_get_meta(){

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

function storefrontal_slides_custom_init(){

	if( get_post_type($_REQUEST['post']) == 'slide' ):
	  wp_enqueue_script('metaboxes', get_template_directory_uri() . '/library/carousel/scripts/jquery.metaboxes.js', array('jquery') );
		wp_enqueue_style('metaboxes-style', get_template_directory_uri() . '/library/carousel/styles/metaboxes.css');
	endif;

}

add_action("admin_print_styles-post.php", 'storefrontal_slides_custom_init',0);  
add_action("admin_print_styles-post-new.php", 'storefrontal_slides_custom_init',0);  

function storefrontal_slides_custom_meta(){
	add_meta_box( 'slides_metabox', __('Slide Details', 'storefrontal'), 'storefrontal_slides_metabox_output', 'slide' ,'normal', 'high' );
}

function storefrontal_slides_metabox_output(){

	global $post;

	$storefrontal_slides_custom_meta = storefrontal_slides_get_meta();
	?>
	<p class="meta item">
	Upload an image or select an existing image from the Media Library:
	<a class="button thickbox" href="<?php echo get_admin_url(); ?>media-upload.php?post_id=<?php echo $post->ID; ?>&TB_iframe=1" id="upload-attachments" style="margin:5px;">Set/Update Featured Image</a>
	<br><em>Slide image size: 960px X 340px</em>
	</p>
	<?php
	foreach( $storefrontal_slides_custom_meta as $meta ):
	
		meta_handler($meta);

	endforeach;
	
}

add_action('wp_ajax_get_post_thumbnail','storefrontal_slides_get_post_thumbnail');

function storefrontal_slides_get_post_thumbnail(){

	$id = esc_html($_GET['id']);

	if( $post_thumbnail = wp_get_attachment_image( $id, 'blog' ) ){
		$success = true;
	} else
		$success = false;

	$response = json_encode( array( 'post_id' => $id, 'img' => $post_thumbnail, 'success' => $success ) );

	header( "Content-Type: application/json" );
	echo $response;

	exit;
	
}

function storefrontal_slides_save(){

	global $post;

	$storefrontal_slides_custom_meta = storefrontal_slides_get_meta();

	if($_REQUEST['action'] != 'autosave'):
	
		foreach( $storefrontal_slides_custom_meta as $meta ):
				update_post_meta($post->ID, $meta['id'], $_REQUEST[$meta['id']]);
		endforeach;
		
	endif;
	
}

function storefrontal_slides_columns($columns) {
		unset($columns['categories']); 
	    $columns['slides_image'] = 'Slide';
	    $columns['menu_order'] = 'Order';
    return $columns;
}

function storefrontal_slides_columns_output($name) {
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

function storefrontal_slides_ajax_populate() {
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

add_action('wp_ajax_up_ajax_populate','storefrontal_slides_ajax_populate');
add_action('manage_pages_custom_column',  'storefrontal_slides_columns_output');
add_filter('manage_edit-storefrontal_slides_columns', 'storefrontal_slides_columns');
add_action('save_post','storefrontal_slides_save');

function storefrontal_carousel_embed( $atts ) {

	extract( shortcode_atts( array(
		'type' => 'slide'
	), $atts ) );

$carousel_query = query_posts(array('post_type' => $type, 'showposts' => -1));

if( have_posts() ):

  wp_enqueue_script('flexslider');
  wp_enqueue_style('flexslider-css');

  $slides = "
    <div class=\"flexslider\">
    	<ul class=\"slides\">
    ";

  while (have_posts()) : the_post();
  
  $post_thumbnail = get_the_post_thumbnail(get_the_ID(),'carousel');
  $title = get_the_title();
  $description = get_post_meta(get_the_ID(),'slide_blurb',true);
  $link = get_permalink();
  $link = $link ? get_post_meta(get_the_ID(), 'link', true) : get_permalink();
  $text = __("shop this style &raquo;","storefrontal");
  
  $slides .= <<<SLIDE
  	<li>
  		$post_thumbnail
  		<div class="text-holder">
  			<h2>$title</h2>
  			<p>$description</p>
  			<a href="$link">$text</a>
  		</div>
  	</li>
SLIDE;

  endwhile;
  
  $slides .= "
    </ul>
  </div>
  ";

else:

  $url = admin_url('post-new.php?post_type=slide');
  $message = sprintf( __("No carousel images added. Please <a href='%s'>add a new carousel item</a> to see a carousel here.","storefrontal"), $url);
  
  $slides = <<<SLIDE
  <div class="no-flexslider">
  	$message
  </div>
SLIDE;

endif;

$carousel = <<<CAROUSEL
<div class="carousel">
	$slides
	<a href="#" class="link-prev"><?php _e("prev","storefrontal"); ?></a>
	<a href="#" class="link-next"><?php _e("next","storefrontal"); ?></a>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
  jQuery('.flexslider').flexslider({
    animation: "slide",
    smoothHeight: true
  });
});
</script>
CAROUSEL;

	return $carousel;
}
add_shortcode( 'slideshow', 'storefrontal_carousel_embed' );