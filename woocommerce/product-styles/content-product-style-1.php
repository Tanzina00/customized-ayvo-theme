<?php
/**
 *
 * Name: Product Style 01
 * Slug: content-product-style-1
 * Shortcode: true
 * Theme Option: true
 **/
?>
<?php
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
?>
<?php global $product; ?>
<div class="product-inner">
	<div class="product-thumb">
		<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		<div class="group-button">
			<?php
			do_action( 'ovic_function_shop_loop_item_wishlist' );
			do_action( 'ovic_function_shop_loop_item_compare' );
			?>
			<div class="quickview">
				<?php do_action( 'ovic_function_shop_loop_item_quickview' ); ?>
			</div>
		</div>
		
	</div>
	<div class="product-info equal-elem">
		<div class="product-metas">
			<div class="category">
				<?php echo wc_get_product_category_list( $product->get_id(), ', ' ); ?>
			</div>
			
		</div>
		<?php
		/**
		 * woocommerce_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );
		/**
		 * woocommerce_after_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
		<div class="single-shop-add-to-cart">
			<?php 
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 7 );
			remove_action('woocommerce_before_add_to_cart_button', 'ayvo_template_single_available');
			remove_action( 'woocommerce_product_meta_end', 'add_content_after_addtocart_button_func' );
			
do_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
 ?>
		</div>
	</div>
</div>
<?php
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
?>
