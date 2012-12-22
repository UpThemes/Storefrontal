<?php

/*
 * Assign theme folder name that you want to get information.
 * make sure theme exist in wp-content/themes/ folder.
 */

$theme_name = 'storefrontal'; 

/*
* Do not use get_stylesheet_uri() as $theme_filename,
* it will result in PHP fopen error if allow_url_fopen is set to Off in php.ini,
* which is what most shared hosting does. You can use get_stylesheet_directory()
* or get_template_directory() though, because they return local paths.
*/

// Theme Version
$theme_data = wp_get_theme();
define('THEME_VERSION',$theme_data->Version);

// Load UpThemes Framework
include_once( get_template_directory().'/options/options.php' );

// Custom Widgets
include_once( get_template_directory().'/library/widgets.php' );

// Slider
include_once( get_template_directory().'/library/carousel/carousel.php' );

// Theme Options
include_once( get_template_directory().'/theme-options/colors-and-images.php' );

/**
 * Theme initialization.
 *
 * Sets up theme-specific functionality.
 *
 * @since Storefrontal 1.0
 */
function storefrontal_init(){

  if ( function_exists( 'add_theme_support' ) ) {
  	add_theme_support( 'post-thumbnails' );
  	set_post_thumbnail_size( 50, 50, true ); // Normal post thumbnails
  	add_image_size('blog', 439, 9999, true );
  	add_image_size('product-thumbnail', 200, 200, true );
  	add_image_size('cart-thumbnail', 40, 40, true );
  	add_image_size('sigle-product-thumbnail', 270, 268, true );
  	add_image_size('small-post-thumbnail', 136, 96, true );
  	add_image_size('widget-thumbnail', 260, 9999);
  }
  
  register_nav_menus( array(
  	'primary' => __( 'Primary Navigation', 'base' ),
  ) );
  
  add_theme_support( 'post-formats', array( 'link', 'quote', 'image', 'video', 'audio' ) );

	register_default_headers( array (
		'default' => array (
			'url' => '%s/images/logo-storefrontal.png',
			'thumbnail_url' => '%s/images/logo-storefrontal.png',
			'description' => __( 'Storefrontal Logo', 'storefrontal' ) )
		)
	);

	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'storefrontal_header_image_width', 253 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'storefrontal_header_image_height',	57 ) );
	define( 'HEADER_TEXTCOLOR', apply_filters( 'storefrontal_header_image_textcolor', "#ff4a4b" ) );

	
	$header_args = array(
		'width'                  => HEADER_IMAGE_WIDTH,
		'height'                 => HEADER_IMAGE_HEIGHT,
		'flex-height'            => true,
		'flex-width'             => true,
		'default-text-color'     => HEADER_TEXTCOLOR,
		'wp-head-callback'       => 'storefrontal_header_image_style',
		'admin-preview-callback' => 'storefrontal_header_image_style_admin',
	);

	add_theme_support('custom-header', $header_args);

}

add_action("init","storefrontal_init",400);


/**
 * Register sidebars
 *
 * This function creates all the sidebars for our theme.
 *
 * @since Storefrontal 1.0
 */

function storefrontal_register_sidebars(){
  
  if ( function_exists('register_sidebar') ) {
  	register_sidebar(array(
  		'id' => 'default-sidebar',
  		'name' => 'Default Sidebar',
  		'before_widget' => '<div class="widget %2$s">',
  		'after_widget' => '</div>',
  		'before_title' => '<h4>',
  		'after_title' => '</h4>'
  	));
  	register_sidebar(array(
  		'id' => 'footer-1',
  		'name' => 'Footer 1 (left side)',
  		'before_widget' => '<div class="widget %2$s">',
  		'after_widget' => '</div>',
  		'before_title' => '<h4>',
  		'after_title' => '</h4>'
  	));
  register_sidebar(array(
  	'id' => 'footer-2',
  	'name' => 'Footer 2 (right side)',
  	'before_widget' => '<div class="widget %2$s">',
  	'after_widget' => '</div>',
  	'before_title' => '<h4>',
  	'after_title' => '</h4>'
  ));
  register_sidebar(array(
  	'id' => 'footer-3',
  	'name' => 'Footer 3 (right side)',
  	'before_widget' => '<div class="widget %2$s">',
  	'after_widget' => '</div>',
  	'before_title' => '<h4>',
  	'after_title' => '</h4>'
  ));
  	register_sidebar(array(
  		'id' => 'home-1',
  		'name' => 'Column 1 (homepage)',
  		'before_widget' => '<div class="widget %2$s">',
  		'after_widget' => '</div>',
  		'before_title' => '<h4>',
  		'after_title' => '</h4>'
  	));
  	register_sidebar(array(
  		'id' => 'home-2',
  		'name' => 'Column 2 (homepage)',
  		'before_widget' => '<div class="widget %2$s">',
  		'after_widget' => '</div>',
  		'before_title' => '<h4>',
  		'after_title' => '</h4>'
  	));
  	register_sidebar(array(
  		'id' => 'home-3',
  		'name' => 'Column 3 (homepage)',
  		'before_widget' => '<div class="widget %2$s">',
  		'after_widget' => '</div>',
  		'before_title' => '<h4>',
  		'after_title' => '</h4>'
  	));
  }

}

add_action("widgets_init","storefrontal_register_sidebars");

/**
 * Enqueue the scripts and styles for StoreFrontal
 *
 * Sets up all the assets required for the theme to function properly.
 *
 * @since Storefrontal 1.0
 */
function storefrontal_enqueue_scripts(){
	$up_options = upfw_get_options();

	if( $up_options->disable_custom_fonts['checked'] != 1 || !class_exists('Typecase') )
  	wp_enqueue_style('fonts',get_template_directory_uri() . "/fonts.css", false, THEME_VERSION, 'all');

	wp_enqueue_style('print',get_template_directory_uri() . "/print.css", false, THEME_VERSION, 'print');
  wp_enqueue_script('view', get_template_directory_uri() . "/assets/js/view.js?auto", array('jquery'), THEME_VERSION );
  wp_enqueue_script('fitvids', get_template_directory_uri() . "/assets/js/jquery.fitvids.js", array('jquery'), THEME_VERSION );
	wp_enqueue_script('storefrontal-master',get_template_directory_uri() . "/assets/js/theme.js", array('view','fitvids'), THEME_VERSION, 'all');
  wp_enqueue_style( 'storefrontal-style', get_stylesheet_uri(), false, THEME_VERSION );

}

add_action('wp_enqueue_scripts','storefrontal_enqueue_scripts',9999);

/**
 * Creates default header style
 *
 * @since StoreFrontal 1.0
 */
function storefrontal_header_image_style(){
	echo "<style type='text/css'>";
	echo "#logo a{";
	echo "height: " . HEADER_IMAGE_HEIGHT . "px";
	echo "width: " . HEADER_IMAGE_WIDTH . "px";
	echo "background-image:"; header_image(); echo ";"; 
	echo "}";
	echo "</style>";
}

/**
 * Destroys default gallery styling
 *
 * This ensures our pretty gallery grid styles don't get overridden by WordPress
 * default styles.
 *
 * @since StoreFrontal 1.0
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Creates head image style preview in admin
 *
 * @since StoreFrontal 1.0
 */
function storefrontal_header_image_style_admin(){
	echo "<link href='http://fonts.googleapis.com/css?family=Neuton' rel='stylesheet' type='text/css'/>";
	echo "<style type='text/css'>";
	echo "#logo{";
	echo "margin-bottom: 0.3em;";
	echo "}";
	echo "#logo a{";
	echo "height: " . HEADER_IMAGE_HEIGHT . "px";
	echo "width: " . HEADER_IMAGE_WIDTH . "px";
	echo "background-image:"; header_image(); echo ";"; 
	echo "font-family: Neuton;";
	echo "color: #ff4a4b;";
	echo "font-size: 53px;";
	echo "font-weight: normal;";
	echo "text-decoration: none;";
	echo "}";
	echo "p.desc{";
	echo "text-transform: uppercase;";
	echo "font-family: Neuton;";
	echo "font-size: 17px;";
	echo "color: #6b6666;";
	echo "}";
	echo "</style>";
	echo "<h1 id='logo'><a href=" . get_bloginfo('url') . ">" . get_bloginfo('name') . "</a></h1>";
	echo "<p class='desc'>" . get_bloginfo('description') . "</h1>";

}

/**
 * Replace Standard WP Menu Classes
 *
 * @since StoreFrontal 1.0
 */
function change_menu_classes($css_classes) {
        $css_classes = str_replace("current-menu-item", "active", $css_classes);
        $css_classes = str_replace("current-menu-parent", "active", $css_classes);
        return $css_classes;
}
add_filter('nav_menu_css_class', 'change_menu_classes');

/**
 * Navigation
 *
 * Checks for existence of WP PageNavi then falls back to standard post navigation.
 *
 * @since StoreFrontal 1.0
 */
function storefrontal_navigation(){

	if( function_exists('wp_pagenavi') ) : ?>
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
	<?php endif;

}

/**
 * Get Audio Files
 *
 * Finds and returns audio files for posts.
 *
 * @since StoreFrontal 1.0
 */
function storefrontal_get_audio_files($postid){
	$attachment = get_children(array(
					'post_parent' => $postid,
					'post_type' => 'attachment'));
	$str = 'audio';
	$audio_files = array();
	foreach($attachment as $file){
		if(substr_count($file -> post_mime_type, $str)){
			$audio_files[] = $file -> guid;
		}
	}
	if(!count($attachment)) return false;
	else return $audio_files;
}

function storefrontal_get_parameter($url,$param){

	$url_components = parse_url($url);

	$querystring = $url_components['query'];

 	parse_str($querystring,$querystring_components);

	return $querystring_components[$param];

}

function storefrontal_get_vimeo_id($url){

	return sscanf(parse_url($url, PHP_URL_PATH), '/%d', $video_id);

}

function storefrontal_get_thumbnail_video($url){

	$permalink = get_permalink();

	if( strpos($url, 'youtube') ){
		$id = storefrontal_get_parameter($url,'v');
		$url = "http://img.youtube.com/vi/$id/hqdefault.jpg";
	} elseif( strpos($url, 'vimeo') ){
		$id = storefrontal_get_vimeo_id($url);
		$url = file_get_contents("http://vimeo.com/api/v2/video/$id.php");
		$url = $url['thumbnail_small'];
	}

	echo "<a href='$permalink'><img src='$url' style='max-width:100%;height:auto;' alt=''></a>";

}

function storefrontal_theme_style($classes){

	global $up_options;
	$up_options = upfw_get_options();

	if( $up_options->theme_color_scheme )
		$classes[] = $up_options->theme_color_scheme;

	return $classes;

}

add_filter('body_class','storefrontal_theme_style');

?>
