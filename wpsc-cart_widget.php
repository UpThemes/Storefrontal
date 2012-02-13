<?php if(isset($cart_messages) && count($cart_messages) > 0) { ?>
	<?php foreach((array)$cart_messages as $cart_message) { ?>
	  <span class="cart_message"><?php echo $cart_message; ?></span>
	<?php } ?>
<?php } ?>

<?php if(wpsc_cart_item_count() > 0): ?>
	<ul class="items">
		<li class="heading">
			<span class="col-1" id="product"><?php _e('Product', 'wpsc'); ?></span>
			<span class="col-2" id="quantity"><?php _e('Qty', 'wpsc'); ?></span>
			<span class="col-3" id="price"><?php _e('Price', 'wpsc'); ?></span>
		</li>
		<?php while(wpsc_have_cart_items()): wpsc_the_cart_item(); ?>
		<li>
			<span class="col-1">
				<?php if(wpsc_cart_item_image()) : ?>
					<a rel="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo wpsc_the_product_image(); ?>">
						<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_cart_item_image(40, 40); ?>"  width="40" height="40" />
					</a>
				<?php else: ?>
					<a href="<?php echo wpsc_the_product_permalink(); ?>">
						<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="40" height="40" />	
					</a>
				<?php endif; ?>
				<a href="<?php echo wpsc_cart_item_url(); ?>"><?php echo wpsc_cart_item_name(); ?></a>
			</span>
			<span class="col-2" ><?php echo wpsc_cart_item_quantity(); ?></span>
			<span class="col-3"><?php echo wpsc_cart_item_price(); ?></span>
		</li>	
		<?php endwhile; ?>
		</ul>
		<strong class="subtotal">
			<?php _e('Subtotal', 'wpsc'); ?>: <?php echo wpsc_cart_total_widget( false, false ,false ); ?>
		</strong>
		<div class="links-holder">
			<form action="" method="post" class="wpsc_empty_the_cart">
				<input type="hidden" name="wpsc_ajax_action" value="empty_cart" />
				<a target="_parent" href="<?php echo htmlentities(add_query_arg('wpsc_ajax_action', 'empty_cart', remove_query_arg('ajax')), ENT_QUOTES, 'UTF-8'); ?>" class="emptycart" title="<?php _e('Empty Your Cart', 'wpsc'); ?>"><?php _e('Empty Cart', 'wpsc'); ?></a>                                                                                    
			</form>
			<a target="_parent" href="<?php echo get_option('shopping_cart_url'); ?>" title="<?php _e('Checkout', 'wpsc'); ?>" class="gocheckout checkout"><?php _e('Checkout', 'wpsc'); ?></a>
		</div>	
<?php else: ?>
	<p class="empty">
		<?php _e('Your shopping cart is empty', 'wpsc'); ?><br />
		<a target="_parent" href="<?php echo get_option('product_list_url'); ?>" class="visitshop" title="<?php _e('Visit Shop', 'wpsc'); ?>"><?php _e('Visit the shop', 'wpsc'); ?></a>	
	</p>
<?php endif; ?>

<?php
wpsc_google_checkout();


?>