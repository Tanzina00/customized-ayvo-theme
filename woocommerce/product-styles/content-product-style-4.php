<?php
/**
 *
 * Name: Product Style 04
 * Slug: content-product-style-4
 * Shortcode: true
 * Theme Option: false
 **/
?>
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
    </div>
    <div class="product-info summary">
		<?php
		/**
		 * woocommerce_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );
		woocommerce_template_single_rating();
		woocommerce_template_single_add_to_cart();
		do_action( 'ovic_function_shop_loop_item_countdown' );
		?>
    </div>
</div>