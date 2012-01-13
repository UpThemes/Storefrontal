<?php query_posts(array('post_type' => 'wpsc-product', 'showposts' => 4)); ?>
<div class="products-block">
	<?php if (wpsc_have_products()) : ?>
	<ul class="products-list products-list-h">
	<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
		<li>
			<h3 class="prodtitle entry-title">
				<?php if(get_option('hide_name_link') == 1) : ?>
					<?php echo wpsc_the_product_title(); ?>
				<?php else: ?> 
					<a class="wpsc_product_title" href="<?php echo wpsc_the_product_permalink(); ?>"><?php echo wpsc_the_product_title(); ?></a>
				<?php endif; ?>
			</h3>
			<?php if(wpsc_show_thumbnails()) :?>
					<?php if(wpsc_the_product_thumbnail()) :
					?>
						<a rel="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?> img-holder" href="<?php echo wpsc_the_product_image(); ?>">
							<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(); ?>" width="200" height="200" />

						</a>
					<?php else: ?>
						<a href="<?php echo wpsc_the_product_permalink(); ?>" class="img-holder">
							<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="200" height="200" />	
						</a>
					<?php endif; ?>
					<?php
					if(gold_cart_display_gallery()) :					
						echo gold_shpcrt_display_gallery(wpsc_the_product_id(), true);
					endif;
					?>	
			<?php endif; ?>
					<?php							
						do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post);
						do_action('wpsc_product_addons', wpsc_the_product_id());
					?>
			
					<?php if(wpsc_the_product_additional_description()) : ?>
					<div class="additional_description_container">
						
							<img class="additional_description_button"  src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/icon_window_expand.gif" alt="Additional Description" /><a href="<?php echo wpsc_the_product_permalink(); ?>" class="additional_description_link"><?php _e('More Details', 'wpsc'); ?>
						</a>
						<div class="additional_description">
							<p><?php echo wpsc_the_product_additional_description(); ?></p>
						</div><!--close additional_description-->
					</div><!--close additional_description_container-->
					<?php endif; ?>
					
					<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
						<?php $action =  wpsc_product_external_link(wpsc_the_product_id()); ?>
					<?php else: ?>
					<?php $action = htmlentities(wpsc_this_page_url(), ENT_QUOTES, 'UTF-8' ); ?>					
					<?php endif; ?>					
					<form class="product_form"  enctype="multipart/form-data" action="<?php echo $action; ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_<?php echo wpsc_the_product_id(); ?>" >
					<?php do_action ( 'wpsc_product_form_fields_begin' ); ?>
					<?php /** the variation group HTML and loop */?>
		<?php if (wpsc_have_variation_groups()) { ?>
		<fieldset><legend><?php _e('Product Options', 'wpsc'); ?></legend>
					<div class="wpsc_variation_forms">
			<table>
						<?php while (wpsc_have_variation_groups()) : wpsc_the_variation_group(); ?>
							<tr><td class="col1"><label for="<?php echo wpsc_vargrp_form_id(); ?>"><?php echo wpsc_the_vargrp_name(); ?>:</label></td>
							<?php /** the variation HTML and loop */?>
							<td class="col2"><select class="wpsc_select_variation" name="variation[<?php echo wpsc_vargrp_id(); ?>]" id="<?php echo wpsc_vargrp_form_id(); ?>">
							<?php while (wpsc_have_variations()) : wpsc_the_variation(); ?>
								<option value="<?php echo wpsc_the_variation_id(); ?>" <?php echo wpsc_the_variation_out_of_stock(); ?>><?php echo wpsc_the_variation_name(); ?></option>
							<?php endwhile; ?>
							</select></td></tr> 
						<?php endwhile; ?>
		    </table>
					</div><!--close wpsc_variation_forms-->
		</fieldset>
					<?php } ?>
					<?php /** the variation group HTML and loop ends here */?>
						
						<!-- THIS IS THE QUANTITY OPTION MUST BE ENABLED FROM ADMIN SETTINGS -->
						<?php if(wpsc_has_multi_adding()): ?>
			<fieldset><legend><?php _e('Quantity', 'wpsc'); ?></legend>
							<div class="wpsc_quantity_update">
			<?php /*<label for="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>"><?php _e('Quantity', 'wpsc'); ?>:</label>*/ ?>
							<input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" />
							<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
							<input type="hidden" name="wpsc_update_quantity" value="true" />
			</div><!--close wpsc_quantity_update-->
			</fieldset>
						<?php endif ;?>

							<?php if( wpsc_show_stock_availability() ): ?>
								<?php if(wpsc_product_has_stock()) : ?>
									<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="in_stock"><?php _e('Product in stock', 'wpsc'); ?></div>
								<?php else: ?>
									<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="out_of_stock"><?php _e('Product not in stock', 'wpsc'); ?></div>
								<?php endif; ?>
							<?php endif; ?>
							<?php if(wpsc_product_is_donation()) : ?>
								<label for="donation_price_<?php echo wpsc_the_product_id(); ?>"><?php _e('Donation', 'wpsc'); ?>: </label>
								<input type="text" id="donation_price_<?php echo wpsc_the_product_id(); ?>" name="donation_price" value="<?php echo wpsc_calculate_price(wpsc_the_product_id()); ?>" size="6" />

							<?php else : ?>
								<?php if(wpsc_product_on_special()) : ?>
									<span class="price" id="old_product_price_<?php echo wpsc_the_product_id(); ?>"><?php _e('Old Price', 'wpsc'); ?>: <?php echo wpsc_product_normal_price(); ?></span>
								<?php endif; ?>
									<span id='product_price_<?php echo wpsc_the_product_id(); ?>' class="currentprice pricedisplay price"><?php _e('Price', 'wpsc'); ?>: <?php echo wpsc_the_product_price(); ?></span>
								<?php if(wpsc_product_on_special()) : ?>
									<span class="price yousave" id="yousave_<?php echo wpsc_the_product_id(); ?>"><?php _e('You save', 'wpsc'); ?>: <?php echo wpsc_currency_display(wpsc_you_save('type=amount'), array('html' => false)); ?>! (<?php echo wpsc_you_save(); ?>%)</span>
								<?php endif; ?>
								
								<!-- multi currency code -->
								<?php if(wpsc_product_has_multicurrency()) : ?>
					<?php echo wpsc_display_product_multicurrency(); ?>
			    <?php endif; ?>
								
								<?php if(wpsc_show_pnp()) : ?>
									<span class="pp_price price"><?php _e('Shipping', 'wpsc'); ?>: <?php echo wpsc_product_postage_and_packaging(); ?></span>
								<?php endif; ?>							
							<?php endif; ?>
						
						<input type="hidden" value="add_to_cart" name="wpsc_ajax_action"/>
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id"/>
				
						<!-- END OF QUANTITY OPTION -->
						<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
							<?php if(wpsc_product_has_stock()) : ?>
								<div class="wpsc_buy_button_container">
									<div class="wpsc_loading_animation">
										<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
										<?php _e('Updating cart...', 'wpsc'); ?>
									</div><!--close wpsc_loading_animation-->
										<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
										<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
										<input class="wpsc_buy_button" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'wpsc' ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>')">
										<?php else: ?>
									<input type="submit" value="<?php _e('Add To Cart +', 'wpsc'); ?>" name="Buy" class="wpsc_buy_button" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"/>
										<?php endif; ?>
								</div><!--close wpsc_buy_button_container-->
							<?php endif ; ?>
						<?php endif ; ?>
						<div class="entry-utility wpsc_product_utility">
							<?php edit_post_link( __( 'Edit', 'wpsc' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
						<?php do_action ( 'wpsc_product_form_fields_end' ); ?>
					</form><!--close product_form-->
					
					<?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow')=='1')) : ?>
						<?php echo wpsc_buy_now_button(wpsc_the_product_id()); ?>
					<?php endif ; ?>
					
					<?php echo wpsc_product_rater(); ?>
					
					
				<?php // */ ?>
		<?php if(wpsc_product_on_special()) : ?><span class="sale"><?php _e('Sale', 'wpsc'); ?></span><?php endif; ?>
		</li>
	<?php endwhile; ?>
	</ul>
	<?php else : ?>
		<?php the_404_content(); ?>
	<?php endif; wp_reset_query(); ?>
</div>