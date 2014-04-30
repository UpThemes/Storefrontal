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

	add_theme_support( 'woocommerce' );

	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'base' ),
	) );

	add_theme_support( 'post-formats', array( 'link', 'quote', 'image', 'video', 'audio' ) );

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

add_action('init','storefrontal_init',400);

/**
 * Hook in on activation
 */
global $pagenow;

if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
	add_action( 'admin_init', 'storefrontal_woocommerce_image_dimensions', 1 );
	add_action( 'admin_init', 'storefrontal_woocommerce_update_frontend_styles', 1 );
}

/**
 * Define image sizes
 */
function storefrontal_woocommerce_image_dimensions() {
	$catalog = array(
		'width' 	=> '420',	// px
		'height'	=> '420',	// px
		'crop'		=> 1 		// true
	);

	$single = array(
		'width' 	=> '600',	// px
		'height'	=> '600',	// px
		'crop'		=> 0 		// false
	);

	$thumbnail = array(
		'width' 	=> '64',	// px
		'height'	=> '64',	// px
		'crop'		=> 1		// true
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

/**
 * Set default colors
 */
function storefrontal_woocommerce_update_frontend_styles() {
	$colors = array(
		'primary' 		=> apply_filters('woocommerce_primary_color','ff4a4b'),
		'secondary' 	=> apply_filters('woocommerce_secondary_color','ffffff'),
		'highlight' 	=> apply_filters('woocommerce_highlight_color','3ba96f'),
		'content_bg' 	=> apply_filters('woocommerce_content_bg_color','f1f2f0'),
		'subtext' 		=> apply_filters('woocommerce_subtext_color','8f8f8f')
	);

	// Front-end Colors
	update_option( 'woocommerce_frontend_css_colors', $colors );
}

/**
 * Register sidebars
 *
 * This function creates all the sidebars for our theme.
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

add_action('widgets_init','storefrontal_register_sidebars');

/**
 * Enqueue the scripts and styles for StoreFrontal
 *
 * Sets up all the assets required for the theme to function properly.
 */
function storefrontal_enqueue_scripts(){
	$up_options = upfw_get_options();

	if( $up_options->disable_custom_fonts['checked'] != 1 || !class_exists('Typecase') ){
		wp_enqueue_style('fonts',get_template_directory_uri() . "/fonts.css", false, THEME_VERSION, 'all');
	}

	wp_enqueue_style('print',get_template_directory_uri() . "/print.css", false, THEME_VERSION, 'print');
	wp_enqueue_script('view', get_template_directory_uri() . "/assets/js/view.js?auto", array('jquery'), THEME_VERSION );
	wp_enqueue_script('fitvids', get_template_directory_uri() . "/assets/js/jquery.fitvids.js", array('jquery'), THEME_VERSION );
	wp_enqueue_script('storefrontal-master',get_template_directory_uri() . "/assets/js/theme.js", array('view','fitvids'), THEME_VERSION, 'all');
	wp_enqueue_style( 'storefrontal-style', get_stylesheet_uri(), false, THEME_VERSION );

}

add_action('wp_enqueue_scripts','storefrontal_enqueue_scripts',9999);

/**
 * Creates default header style
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
 * Creates head image style preview in admin
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

function storefrontal_theme_style($classes){

	global $up_options;
	$up_options = upfw_get_options();

	if( $up_options->theme_color_scheme )
		$classes[] = $up_options->theme_color_scheme;

	return $classes;

}

add_filter('body_class','storefrontal_theme_style');

?>
