<?php $up_options = upfw_get_options(); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php 

	if( class_exists('All_in_One_SEO_Pack') ):
		wp_title(); 
	else:
		if( is_front_page() ) 
			echo get_bloginfo('name') . " / " . get_bloginfo('description'); 
		wp_title('',true,'left'); 
	endif;

	?></title>

	<?php
	if( isset($up_options->favicon ))
		echo '<link rel="shortcut icon" href="' . $up_options->favicon . '">';
	
	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );

	wp_head(); ?>

</head>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<div id="header">
			<?php if( get_header_image() ): ?>
				<img class="print-logo" src="<?php header_image(); ?>" width="253" height="57" alt="<?php bloginfo('description') ?>" />
				<h1 class="logo"><a href="<?php bloginfo('url'); ?>"><img src="<?php header_image(); ?>" width="253" height="57" alt="<?php bloginfo('description') ?>" /></a></h1>
			<?php else: ?>
			<div class="header-text">
				<h1 class="logo"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
				<p class="desc"><?php bloginfo('description'); ?></p>			
			</div>
			<?php endif; ?>
			<div class="nav-holder">
				<div class="link-holder">
					<?php if( function_exists('wpsc_cart_item_count') ): ?>
					<a href="<?php echo get_option('shopping_cart_url'); ?>"" class="cart"><?php _e("Cart","storefrontal"); ?><span><?php printf( _n('%d', '%d', wpsc_cart_item_count(), 'wpsc'), wpsc_cart_item_count() ); ?></span></a>
					<?php endif; ?>
				</div>
				<?php wp_nav_menu(array('container' => false,
							'theme_location' => 'primary',
							'menu_id' => 'nav',
							'menu_class' => '') ); ?>
			</div>
		</div>
		<div id="main">