<?php

// Load UpThemes Framework
require_once( get_template_directory().'/admin/admin.php' );

// Load Theme Options into Array
//require_once(get_template_directory() . '/theme-options/layout-and-display.php');
require_once(get_template_directory() . '/theme-options/colors-and-images.php');

// Set Up Theme
require_once( get_template_directory().'/library/theme_setup.php' );
require_once( get_template_directory().'/library/constants.php' );

// Homepage Slides
require_once( get_template_directory().'/library/meta_handler.php' );
require_once( get_template_directory().'/library/slides.php' );

// Custom Widgets
require_once( get_template_directory().'/library/widgets.php' );

//remove_action('wp_head', 'wp_generator');

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'id' => 'default-sidebar',
		'name' => 'Default Sidebar',
		'before_widget' => '<div class="sb-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'id' => 'footer-1',
		'name' => 'Footer 1 (left side)',
		'before_widget' => '<div class="block frame">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'id' => 'footer-2',
		'name' => 'Footer 2 (right side)',
		'before_widget' => '<div class="block">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'id' => 'home-1',
		'name' => 'Column 1 (homepage)',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'id' => 'home-2',
		'name' => 'Column 2 (homepage)',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'id' => 'home-3',
		'name' => 'Column 3 (homepage)',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 50, 50, true ); // Normal post thumbnails
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

function storefrontal_init(){

	deregister_theme_layout('left_column_grid');
	deregister_theme_layout('right_column_grid');

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
	
	add_custom_image_header('', 'storefrontal_header_image_style','storefrontal_header_image_style_admin');

}

add_action("init","storefrontal_init",400);

function storefrontal_header_image_style(){
	echo "<style type='text/css'>";
	echo "#logo a{";
	echo "height: " . HEADER_IMAGE_HEIGHT . "px";
	echo "width: " . HEADER_IMAGE_WIDTH . "px";
	echo "background-image:"; header_image(); echo ";"; 
	echo "}";
	echo "</style>";

}

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

// register tag [template-url]
function filter_template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'filter_template_url');
add_filter('get_the_content', 'filter_template_url');
add_filter('widget_text', 'filter_template_url');

/* Replace Standart WP Menu Classes */
function change_menu_classes($css_classes) {
        $css_classes = str_replace("current-menu-item", "active", $css_classes);
        $css_classes = str_replace("current-menu-parent", "active", $css_classes);
        return $css_classes;
}
add_filter('nav_menu_css_class', 'change_menu_classes');

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

//allow tags in category description
$filters = array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description');
foreach ( $filters as $filter ) {
    remove_filter($filter, 'wp_filter_kses');
}

function getVimeoInfo($id) {
	if (!function_exists('curl_init')) die('CURL is not installed!');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/$id.php");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = unserialize(curl_exec($ch));
	$output = $output[0];
	curl_close($ch);
	return $output;
}

function getParameter($url, $name) {
    $urlparts = explode('?', $url);
    if (count($urlparts) > 1) {
        $parameters = explode('&', $urlparts[1]);
        for ($i = 0; $i < count($parameters); $i++) {
            $paramparts = explode('=', $parameters[$i]);
            if (count($paramparts) > 1 && $paramparts[0] == $name) {
                return $paramparts[1];
            }
        }
    }
    return null;
}

function getVimeoID($video_url){
	preg_match('/vimeo\.com\/([0-9]{1,10})/', $video_url, $match);
	return $match[1];
}

function getThumbnailVideo($video_id, $website){
	if(substr_count($website, 'vimeo')){
		$video_info = getVimeoInfo($video_id);
		echo '<img height="145" width="260" src="'.$video_info['thumbnail_small'].'" />';
	} elseif(substr_count($website, 'youtube')){
		echo '<img height="145" width="260" src="http://img.youtube.com/vi/'.$video_id.'/0.jpg" />';
	}
}

function get_audio_files($postid){
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

function the_404_content(){ ?>
	<h2><?php _e("Not Found","storefrontal"); ?></h2>
	<p><?php _e("Sorry, but you are looking for something that isn't here.","storefrontal"); ?></p> <?php
	if( is_search() )
		get_search_form();
	
}

function custom_wpsc_pagination($totalpages = '', $per_page = '', $current_page = '', $page_link = '') {
	global $wp_query;
	$num_paged_links = 4; //amount of links to show on either side of current page

	$additional_links = '';

	//additional links, items per page and products order
	if( get_option('permalink_structure') != '' ){
		$additional_links_separator = '?';
	}else{
		$additional_links_separator = '&';
	}
	if( !empty( $_GET['items_per_page'] ) ){
			$additional_links = $additional_links_separator . 'items_per_page=' . $_GET['items_per_page'];
			$additional_links_separator = '&';
	}
	if( !empty( $_GET['product_order'] ) )
		$additional_links .= $additional_links_separator . 'product_order=' . $_GET['product_order'];

	$additional_links = apply_filters('wpsc_pagination_additional_links', $additional_links);
	//end of additional links

	if(empty($totalpages)){
			$totalpages = $wp_query->max_num_pages;
	}
	if(empty($per_page))
		$per_page = (int)get_option('wpsc_products_per_page');

	$current_page = absint( get_query_var('paged') );
	if($current_page == 0)
		$current_page = 1;

	if(empty($page_link))
		$page_link = wpsc_a_page_url();

	//if there is no pagination
	if(!get_option('permalink_structure')) {
		$category = '?';
		if(isset($wp_query->query_vars['wpsc_product_category']))
			$category = '?wpsc_product_category='.$wp_query->query_vars['wpsc_product_category'];
		if(isset($wp_query->query_vars['wpsc_product_category']) && is_string($wp_query->query_vars['wpsc_product_category'])){

			$page_link = get_option('blogurl').$category.'&amp;paged';
		}else{
			$page_link = get_option('product_list_url').$category.'&amp;paged';
		}

		$separator = '=';
	}else{
		// This will need changing when we get product categories sorted
		if(isset($wp_query->query_vars['wpsc_product_category']))
			$page_link = trailingslashit(get_option('product_list_url')).$wp_query->query_vars['wpsc_product_category'].'/';
		else
			$page_link = trailingslashit(get_option('product_list_url'));

		$separator = 'page/';
	}

	// If there's only one page, return now and don't bother
	if($totalpages == 1)
		return;
	// Pagination Prefix
	$output = '';

	if(get_option('permalink_structure')){

		// Should we show the PREVIOUS PAGE link?
		if($current_page > 1) {
			$previous_page = $current_page - 1;
			if( $previous_page == 1 )
				$output .= " <a class='previouspostslink' href=\"". esc_url( $page_link . $additional_links ) . "\" title=\"" . __('Previous Page', 'wpsc') . "\">" . __('Prev', 'wpsc') . "</a>";
			else
				$output .= " <a class='previouspostslink' href=\"". esc_url( $page_link .$separator. $previous_page . $additional_links ) . "\" title=\"" . __('Previous Page', 'wpsc') . "\">" . __('Prev', 'wpsc') . "</a>";
		}
		$i =$current_page - $num_paged_links;
		$count = 1;
		if($i <= 0) $i =1;
		while($i < $current_page){
			if($count <= $num_paged_links){
				if($count == 1)
					$output .= " <a href=\"". esc_url( $page_link . $additional_links ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), $i ) . " \">".$i."</a>";
				else
					$output .= " <a href=\"". esc_url( $page_link .$separator. $i . $additional_links ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), $i ) . " \">".$i."</a>";
			}
			$i++;
			$count++;
		}
		// Current Page Number
		if($current_page > 0)
			$output .= "<span class='current'>$current_page</span>";

		//Links after Current Page
		$i = $current_page + $num_paged_links;
		$count = 1;

		if($current_page < $totalpages){
			while(($i) > $current_page){

				if($count < $num_paged_links && ($count+$current_page) <= $totalpages){
						$output .= " <a href=\"". esc_url( $page_link .$separator. ($count+$current_page) .$additional_links ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), ($count+$current_page) ) . "\">".($count+$current_page)."</a>";
				$i++;
				}else{
				break;
				}
				$count ++;
			}
		}

		if($current_page < $totalpages) {
			$next_page = $current_page + 1;
			$output .= "<a class='nextpostslink' href=\"". esc_url( $page_link  .$separator. $next_page . $additional_links ) . "\" title=\"" . __('Next Page', 'wpsc') . "\">" . __('Next', 'wpsc') . "</a>";
		}
	} else {
		// Should we show the PREVIOUS PAGE link?
		if($current_page > 1) {
			$previous_page = $current_page - 1;
			if( $previous_page == 1 )
				$output .= " <a class='previouspostslink' href=\"". remove_query_arg( 'paged' ) . $additional_links . "\" title=\"" . __('Previous Page', 'wpsc') . "\">" . __('Prev', 'wpsc') . "</a>";
			else
				$output .= " <a class='previouspostslink' href=\"". add_query_arg( 'paged', ($current_page - 1) ) . $additional_links . "\" title=\"" . __('Previous Page', 'wpsc') . "\">" . __('Prev', 'wpsc') . "</a>";
		}
		$i =$current_page - $num_paged_links;
		$count = 1;
		if($i <= 0) $i =1;
		while($i < $current_page){
			if($count <= $num_paged_links){
				if($i == 1)
					$output .= " <a href=\"". remove_query_arg('paged' ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), $i ) . " \">".$i."</a>";
				else
					$output .= " <a href=\"". add_query_arg('paged', $i ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), $i ) . " \">".$i."</a>";
			}
			$i++;
			$count++;
		}
		// Current Page Number
		if($current_page > 0)
			$output .= "<span class='current'>$current_page</span>";

		//Links after Current Page
		$i = $current_page + $num_paged_links;
		$count = 1;

		if($current_page < $totalpages){
			while(($i) > $current_page){

				if($count < $num_paged_links && ($count+$current_page) <= $totalpages){
						$output .= " <a href=\"". add_query_arg( 'paged', ($count+$current_page) ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), ($count+$current_page) ) . "\">".($count+$current_page)."</a>";
				$i++;
				}else{
				break;
				}
				$count ++;
			}
		}

		if($current_page < $totalpages) {
			$next_page = $current_page + 1;
			$output .= "<a class='nextpostslink' href=\"". add_query_arg( 'paged', $next_page ) . "\" title=\"" . __('Next Page', 'wpsc') . "\">" . __('Next', 'wpsc') . "</a>";
		}
	}
	// Return the output.
	echo $output;
}

function storefrontal_theme_style($classes){

/*
	global $up_options;

	if( $up_options->color_scheme )
		$classes[] = $up_options->color_scheme;
*/
	return $classes;

}

add_filter('body_class','storefrontal_theme_style');

?>