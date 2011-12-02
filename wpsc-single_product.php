<?php
	// Setup globals
	// @todo: Get these out of template
	global $wp_query;

	// Setup image width and height variables
	// @todo: Investigate if these are still needed here
	$image_width  = get_option( 'single_view_image_width' );
	$image_height = get_option( 'single_view_image_height' );
?>
	<?php
		// Breadcrumbs
		wpsc_output_breadcrumbs();

		// Plugin hook for adding things to the top of the products page, like the live search
		do_action( 'wpsc_top_of_products_page' );
	?>
	
	<div class="single-holder">
		<div class="single-frame">
<?php
		/**
		 * Start the product loop here.
		 * This is single products view, so there should be only one
		 */

		while ( wpsc_have_products() ) : wpsc_the_product(); ?>
		<?php
			$current_product = wpsc_the_product_id();
			$product_terms = get_the_terms($current_product, 'wpsc_product_category');
			$terms_slug = array();
			foreach($product_terms as $term){
				$terms_slug[] = $term -> slug;
			}
		?>
					<?php if ( wpsc_the_product_thumbnail() ) : ?>
							<a rel="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?> img-holder" href="<?php echo wpsc_the_product_image(); ?>">
								<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(get_option('product_image_width'),get_option('product_image_height'),'','single'); ?>"/>
							</a>
							<?php 
							if ( function_exists( 'gold_shpcrt_display_gallery' ) )
								echo gold_shpcrt_display_gallery( wpsc_the_product_id() );
							?>
					<?php else: ?>
								<a href="<?php echo wpsc_the_product_permalink(); ?>" class="img-holder">
								<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="<?php echo get_option('product_image_width'); ?>" height="<?php echo get_option('product_image_height'); ?>" />
								</a>
					<?php endif; ?>

					<div class="text-holder">			
						<?php do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post); ?>
						<div class="product_description">
							<?php echo wpsc_the_product_description(); ?>
						</div><!--close product_description -->
						<?php do_action( 'wpsc_product_addons', wpsc_the_product_id() ); ?>		
						<?php if ( wpsc_the_product_additional_description() ) : ?>
							<div class="single_additional_description">
								<p><?php echo wpsc_the_product_additional_description(); ?></p>
							</div><!--close single_additional_description-->
						<?php endif; ?>		
						<?php do_action( 'wpsc_product_addon_after_descr', wpsc_the_product_id() ); ?>
						<?php
						/**
						 * Custom meta HTML and loop
						 */
						?>
                        <?php if (wpsc_have_custom_meta()) : ?>
						<div class="custom_meta">
							<?php while ( wpsc_have_custom_meta() ) : wpsc_the_custom_meta(); ?>
								<strong><?php echo wpsc_custom_meta_name(); ?>: </strong><?php echo wpsc_custom_meta_value(); ?><br />
							<?php endwhile; ?>
						</div><!--close custom_meta-->
                        <?php endif; ?>
						<?php
						/**
						 * Form data
						 */
						?>
						
						<form class="product_form" enctype="multipart/form-data" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="1" id="product_<?php echo wpsc_the_product_id(); ?>">
							<?php do_action ( 'wpsc_product_form_fields_begin' ); ?>
							<?php if ( wpsc_product_has_personal_text() ) : ?>
								<fieldset class="custom_text">
									<legend><?php _e( 'Personalize Your Product', 'wpsc' ); ?></legend>
									<p><?php _e( 'Complete this form to include a personalized message with your purchase.', 'wpsc' ); ?></p>
									<textarea cols='55' rows='5' name="custom_text"></textarea>
								</fieldset>
							<?php endif; ?>
						
							<?php if ( wpsc_product_has_supplied_file() ) : ?>

								<fieldset class="custom_file">
									<legend><?php _e( 'Upload a File', 'wpsc' ); ?></legend>
									<p><?php _e( 'Select a file from your computer to include with this purchase.', 'wpsc' ); ?></p>
									<input type="file" name="custom_file" />
								</fieldset>
							<?php endif; ?>	
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

							<?php
							/**
							 * Quantity options - MUST be enabled in Admin Settings
							 */
							?>
							<?php if(wpsc_has_multi_adding()): ?>
                            	<fieldset><legend><?php _e('Quantity', 'wpsc'); ?></legend>
								<div class="wpsc_quantity_update">
								<input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" />
								<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
								<input type="hidden" name="wpsc_update_quantity" value="true" />
                                </div><!--close wpsc_quantity_update-->
                                </fieldset>
							<?php endif ;?>
							<div class="wpsc_product_price">
								<?php if(wpsc_show_stock_availability()): ?>
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
										<span class="price <?php echo wpsc_the_product_id(); ?>"><?php _e('Old Price', 'wpsc'); ?>: <span class="oldprice" id="old_product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_product_normal_price(); ?></span></span>
									<?php endif; ?>
										<span class="price <?php echo wpsc_the_product_id(); ?>"><?php _e('Price', 'wpsc'); ?>: <span id='product_price_<?php echo wpsc_the_product_id(); ?>' class="currentprice pricedisplay"><?php echo wpsc_the_product_price(); ?></span></span>
									<?php if(wpsc_product_on_special()) : ?>
										<span class="price product_<?php echo wpsc_the_product_id(); ?>"><?php _e('You save', 'wpsc'); ?>: <span class="yousave" id="yousave_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_currency_display(wpsc_you_save('type=amount'), array('html' => false)); ?>! (<?php echo wpsc_you_save(); ?>%)</span></span>
									<?php endif; ?>
									 <!-- multi currency code -->
                                    <?php if(wpsc_product_has_multicurrency()) : ?>
	                                    <?php echo wpsc_display_product_multicurrency(); ?>
                                    <?php endif; ?>
									<?php if(wpsc_show_pnp()) : ?>
										<span class="price"><?php _e('Shipping', 'wpsc'); ?>:<span class="pp_price"><?php echo wpsc_product_postage_and_packaging(); ?></span></p>
									<?php endif; ?>							
								<?php endif; ?>
							</div><!--close wpsc_product_price-->
							<!--sharethis-->
							<?php if ( get_option( 'wpsc_share_this' ) == 1 ): ?>
							<div class="st_sharethis" displayText="ShareThis"></div>
							<?php endif; ?>
							<!--end sharethis-->
							<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
							<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id" />					
							<?php if( wpsc_product_is_customisable() ) : ?>
								<input type="hidden" value="true" name="is_customisable"/>
							<?php endif; ?>
					
							<?php
							/**
							 * Cart Options
							 */
							?>

							<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
								<?php if(wpsc_product_has_stock()) : ?>
									<div class="wpsc_buy_button_container">
											<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
											<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
											<input class="wpsc_buy_button" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'wpsc' ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>')">
											<?php else: ?>
										<input type="submit" value="<?php _e('Add To Cart +', 'wpsc'); ?>" name="Buy" class="wpsc_buy_button" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"/>
											<?php endif; ?>
										<div class="wpsc_loading_animation">
											<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
											<?php _e('Updating cart...', 'wpsc'); ?>
										</div><!--close wpsc_loading_animation-->
									</div><!--close wpsc_buy_button_container-->
								<?php else : ?>
									<p class="soldout"><?php _e('This product has sold out.', 'wpsc'); ?></p>
								<?php endif ; ?>
							<?php endif ; ?>
							<?php do_action ( 'wpsc_product_form_fields_end' ); ?>
						</form><!--close product_form-->
					
						<?php
							if ( (get_option( 'hide_addtocart_button' ) == 0 ) && ( get_option( 'addtocart_or_buynow' ) == '1' ) )
								echo wpsc_buy_now_button( wpsc_the_product_id() );
					
							echo wpsc_product_rater();

							echo wpsc_also_bought( wpsc_the_product_id() );
						
						if(wpsc_show_fb_like()): ?>
	                        <div class="FB_like">
	                        <iframe src="https://www.facebook.com/plugins/like.php?href=<?php echo wpsc_the_product_permalink(); ?>&amp;layout=standard&amp;show_faces=true&amp;width=435&amp;action=like&amp;font=arial&amp;colorscheme=light" frameborder="0"></iframe>
	                        </div><!--close FB_like-->
                        <?php endif; ?>
					</div><!--close productcol-->
		
					<form onsubmit="submitform(this);return false;" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_extra_<?php echo wpsc_the_product_id(); ?>">
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="prodid"/>
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="item"/>
					</form>
		
		<?php echo wpsc_product_comments(); ?>

<?php endwhile;

    do_action( 'wpsc_theme_footer' ); ?> 	
	</div>
</div>
<?php
	query_posts(array('post_type' => 'wpsc-product',
			  'showposts' => -1,
			  'post__not_in' => array($current_product),
			  'tax_query' => array(
						array(
							'taxonomy' => 'wpsc_product_category',
							'terms' => $terms_slug,
							'field' => 'slug',
							'operator' => 'IN'
						))
			  ));
?>
<?php if(wpsc_have_products()):?>
<div class="related-block">
	<h3>Related Items</h3>
	<ul class="products-list">
	<?php while ( wpsc_have_products() ) : wpsc_the_product(); ?>
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
						<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(); ?>" height="166" width="166" />

					</a>
				<?php else: ?>
					<a href="<?php echo wpsc_the_product_permalink(); ?>" class="img-holder">
					<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="<?php echo get_option('product_image_width'); ?>" height="<?php echo get_option('product_image_height'); ?>" />	
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
								<input type="submit" value="<?php _e('Add To Cart', 'wpsc'); ?>" name="Buy" class="wpsc_buy_button" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"/>
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
</div>
<?php endif; wp_reset_query(); ?>