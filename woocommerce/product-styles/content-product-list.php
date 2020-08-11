<?php
/**
 *
 * Name: Product List Style
 * Slug: content-product-list
 * Shortcode: false
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
		<div class="group-button">
			<?php
			do_action( 'ovic_function_shop_loop_item_wishlist' );
			do_action( 'ovic_function_shop_loop_item_compare' );
			?>
			<div class="quickview">
				<?php do_action( 'ovic_function_shop_loop_item_quickview' ); ?>
			</div>
		</div>
		<?php do_action( 'ayvo_show_attributes', 'ovic_attr_top' ); ?>
		<div class="add-to-cart">
			<?php
			/**
			 * woocommerce_after_shop_loop_item hook.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
			?>
		</div>
	</div>
	<div class="product-info">
        <div class="top-info">
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
        </div>
        <div class="bottom-info">
            <div class="product-metas">
				<?php do_action( 'ayvo_show_attributes', 'ovic_attr_bottom' ); ?>
            </div>
            <div class="product-des">
				<?php
				echo wp_trim_words( apply_filters( 'the_excerpt', get_the_excerpt() ), 30 );
				?>
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
        </div>
	</div>
</div>
