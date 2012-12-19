<?php

function storefrontal_get_theme_plugin_list(){

	return array(
		'MediaElement.js' => array(
			'location' 	=> 'media-element-html5-video-and-audio-player/mediaelement-js-wp.php',
			'name' 		=> 'MediaElement.js',
			'required'	=> true
		),
		'Widget Logic' => array(
			'location' 	=> 'widget-logic/widget_logic.php',
			'name' 		=> 'Widget Logic',
			'required'	=> false
		),
		'Typecase' => array(
			'location' 	=> 'typecase/typecase.php',
			'name' 		=> 'Typecase',
			'required'	=> false
		),
		'WP e-Commerce' => array(
			'location' 	=> 'wp-e-commerce/wp-shopping-cart.php',
			'name' 		=> 'WP e-Commerce',
			'required'	=> false
		)
	);

}

// Installed Plugin Check
function storefrontal_check_plugins(){

	$plugins = storefrontal_get_theme_plugin_list();

	if ( current_user_can('edit_theme_options') ):

		foreach($plugins as $plugin):
		
			extract($plugin);

			if ( is_plugin_active( $location ) )
				$active = true;
			else
				$active = false;
			
			if( file_exists( trailingslashit( WP_PLUGIN_DIR ) . $location ) )
				$installed = true;
			else
				$installed = false;
	
			$args = array(
				'isPluginInstalled' => $installed,
				'isPluginActive' => $active,
				'isPluginRequired' => $required,
				'pluginName' => $name,
				'pluginSearchURI' => admin_url() . "/plugin-install.php?tab=search&type=term&s=$name",
				'pluginActivationURI' => admin_url("plugins.php")
			);
	
			storefrontal_active_plugin_notice( $args );
			
		endforeach;

	endif;
	
}

add_action('admin_notices', 'storefrontal_check_plugins');

function storefrontal_active_plugin_notice( $args ){
	
	if ( isset($args) && is_array($args) ):

		extract($args);
		
		if( $isPluginRequired ):
			$class = 'error';
			$activateText  = 'must be activated for your current theme to work properly';
			$installText  = 'must be installed for your current theme to work properly';
		else:
			$class = 'updated';
			$activateText  = 'is a recommended plugin that works well with your current theme';
			$installText  = 'is a recommended plugin that works well with your current theme';
		endif;

		if( !$isPluginActive )
			$message = "<p>$pluginName $activateText. You can <a href='$pluginActivationURI'>activate it on the plugins page</a>.</p>";

		if( !$isPluginInstalled )
			$message = "<p>$pluginName $installText. Please <a href='$pluginSearchURI'>install it here</a>.</p>";

		if( !empty($message) ):
			echo '<div class="' . $class . '">';
			echo $message;
			echo '</div>';
		endif;
		
	endif;
	
}

/**
* PressTrends Theme API
*/
function presstrends_theme() {

		// PressTrends Account API Key
		$api_key = 'ijd5r0ywkki9akgl0foy7msb30ibm201d508';
		$auth = '9h45dlpty2aeabc6nqv3mfuofo47syup7';

		// Start of Metrics
		global $wpdb;
		$data = get_transient( 'presstrends_theme_cache_data' );
		if ( !$data || $data == '' ) {
			$api_base = 'http://api.presstrends.io/index.php/api/sites/add/auth/';
			$url      = $api_base . $auth . '/api/' . $api_key . '/';

			$count_posts    = wp_count_posts();
			$count_pages    = wp_count_posts( 'page' );
			$comments_count = wp_count_comments();

			// wp_get_theme was introduced in 3.4, for compatibility with older versions.
			if ( function_exists( 'wp_get_theme' ) ) {
				$theme_data    = wp_get_theme();
				$theme_name    = urlencode( $theme_data->Name );
				$theme_version = $theme_data->Version;
			} else {
				$theme_data = get_theme_data( get_stylesheet_directory() . '/style.css' );
				$theme_name = $theme_data['Name'];
				$theme_versino = $theme_data['Version'];
			}

			$plugin_name = '&';
			foreach ( get_plugins() as $plugin_info ) {
				$plugin_name .= $plugin_info['Name'] . '&';
			}
			$posts_with_comments = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type='post' AND comment_count > 0" );
			$data                = array(
				'url'             => stripslashes( str_replace( array( 'http://', '/', ':' ), '', site_url() ) ),
				'posts'           => $count_posts->publish,
				'pages'           => $count_pages->publish,
				'comments'        => $comments_count->total_comments,
				'approved'        => $comments_count->approved,
				'spam'            => $comments_count->spam,
				'pingbacks'       => $wpdb->get_var( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_type = 'pingback'" ),
				'post_conversion' => ( $count_posts->publish > 0 && $posts_with_comments > 0 ) ? number_format( ( $posts_with_comments / $count_posts->publish ) * 100, 0, '.', '' ) : 0,
				'theme_version'   => $theme_version,
				'theme_name'      => $theme_name,
				'site_name'       => str_replace( ' ', '', get_bloginfo( 'name' ) ),
				'plugins'         => count( get_option( 'active_plugins' ) ),
				'plugin'          => urlencode( $plugin_name ),
				'wpversion'       => get_bloginfo( 'version' ),
				'api_version'	  => '2.4',
			);

			foreach ( $data as $k => $v ) {
				$url .= $k . '/' . $v . '/';
			}
			wp_remote_get( $url );
			set_transient( 'presstrends_theme_cache_data', $data, 60 * 60 * 24 );
		}
}

// PressTrends WordPress Action
add_action('admin_init', 'presstrends_theme');