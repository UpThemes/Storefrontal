<?php global $up_options; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php echo up_title(); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<link rel="stylesheet" media="screen" href="<?php echo get_template_directory_uri(); ?>/css/all.css" type="text/css"/>
	<link rel="stylesheet" media="print" href="<?php echo get_template_directory_uri(); ?>/css/print.css" type="text/css"/>
	<link rel="stylesheet" media="screen" href="<?php echo get_template_directory_uri(); ?>/css/form.css" type="text/css"/>
	<link href='http://fonts.googleapis.com/css?family=Neuton' rel='stylesheet' type='text/css'/>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/style.css"  />
	<?php if ( is_singular() ) wp_enqueue_script( 'theme-comment-reply', get_template_directory_uri()."/js/comment-reply.js" ); ?>
	<?php wp_enqueue_script("jquery"); ?>
	<?php wp_head(); ?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.main.js"></script>
</head>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<div id="header">
			<?php if( get_header_image() ): ?>
				<img class="print-logo" src="<?php header_image(); ?>" width="253" height="57" alt="<?php bloginfo('description') ?>" />
				<h1 class="logo"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
			<?php else: ?>
			<div class="header-text">
				<h1 class="logo"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
				<p class="desc"><?php bloginfo('description'); ?></p>			
			</div>
			<?php endif; ?>
			<div class="nav-holder">
				<div class="link-holder">
					<?php if( function_exists('wpsc_cart_item_count') ): ?>
					<a href="#" class="cart"><?php _e("Cart","storefrontal"); ?><span><?php printf( _n('%d', '%d', wpsc_cart_item_count(), 'wpsc'), wpsc_cart_item_count() ); ?></span></a>
					<?php endif; ?>
				</div>
				<?php wp_nav_menu(array('container' => false,
							'theme_location' => 'primary',
							'menu_id' => 'nav',
							'menu_class' => '') ); ?>
			</div>
		</div>
		<div id="main">