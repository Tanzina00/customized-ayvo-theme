<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/*==========================================================================
HOOK TEMPLATE FUNCTIONS
===========================================================================*/
if ( !class_exists( 'Ovic_toolkit' ) ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
} else {
	remove_action( 'woocommerce_before_main_content', 'ovic_woocommerce_breadcrumb', 20 );
	add_action( 'woocommerce_before_main_content', 'ayvo_woocommerce_breadcrumb', 5 );
	/**
	 *
	 * SHOP CONTROL
	 */
	remove_action( 'ovic_control_before_content', 'woocommerce_catalog_ordering', 10 );
	remove_action( 'ovic_control_before_content', 'ovic_product_per_page_tmp', 20 );
	remove_action( 'ovic_control_after_content', 'woocommerce_result_count', 10 );
	add_action( 'ovic_control_before_content', 'ayvo_filter_sidebar_woocommerce', 5 );
	add_action( 'ovic_control_before_content', 'ayvo_woocommerce_catalog_ordering', 10 );
	add_filter( 'ovic_woocommerce_display_mode_button', 'ayvo_woocommerce_display_mode_button', 10, 2 );
}
add_action( 'yith_quick_view_custom_style_scripts',
	function () {
		wp_enqueue_style( 'product-attributes-swatches' );
		wp_enqueue_script( 'product-attributes-swatches' );
	}
);
/**
 *
 * MINI CART
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'ayvo_cart_link_fragment' );
add_action( 'woocommerce_before_mini_cart', 'ayvo_cart_view_count', 10 );
add_action( 'ayvo_header_mini_cart', 'ayvo_header_mini_cart' );
/**
 *
 * WISHLIST, COMPARE
 */
add_action( 'ayvo_compare', 'ayvo_compare' );
add_action( 'ayvo_wishlist', 'ayvo_wishlist' );
/**
 *
 * PRODUCT SINGLE WRAP
 */
add_action( 'woocommerce_before_single_product_summary', 'ayvo_before_single_product_summary', 5 );
add_action( 'woocommerce_after_single_product_summary', 'ayvo_after_single_product_summary', 5 );
/**
 *
 * PRODUCT SINGLE SHARE
 */
add_action( 'woocommerce_single_product_summary', 'ayvo_template_single_sharing', 55 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 56 );
if ( !function_exists( 'ayvo_template_single_sharing' ) ) {
	function ayvo_template_single_sharing()
	{
		$enable_share_product = Ayvo_Functions::get_option( 'enable_share_product' );
		if ( $enable_share_product == 1 )
			do_action( 'ayvo_share_button', get_the_ID() );
	}
}
// REMOVE DESCRIPTION HEADING, INFOMATION HEADING
add_filter( 'woocommerce_product_description_heading', 'ayvo_product_description_heading' );
if ( !function_exists( 'ayvo_product_description_heading' ) ) {
	function ayvo_product_description_heading()
	{
		return '';
	}
}
add_filter( 'woocommerce_product_additional_information_heading', 'ayvo_product_additional_information_heading' );
if ( !function_exists( 'ayvo_product_additional_information_heading' ) ) {
	function ayvo_product_additional_information_heading()
	{
		return '';
	}
}
if ( !function_exists( 'ayvo_woocommerce_breadcrumb' ) ) {
	function ayvo_woocommerce_breadcrumb()
	{
		$args = array(
			'delimiter'   => '',
			'wrap_before' => '<div class="breadcrumb-trail breadcrumbs"><ul class="woocommerce-breadcrumb breadcrumb">',
			'wrap_after'  => '</ul></div>',
			'before'      => '<li>',
			'after'       => '</li>',
		);
		woocommerce_breadcrumb( $args );
	}
}
if ( !function_exists( 'ayvo_filter_sidebar_woocommerce' ) ) {
	function ayvo_filter_sidebar_woocommerce()
	{
		$shop_layout  = Ayvo_Functions::get_option( 'ovic_sidebar_shop_layout', 'left' );
		$shop_sidebar = Ayvo_Functions::get_option( 'ovic_shop_used_sidebar', 'shop-widget-area' );
		if ( $shop_layout == 'full' ) : ?>
            <div class="filter-sidebar-content ovic-dropdown">
                <a href="#" data-ovic="ovic-dropdown" class="action-filter-sidebar">
					<?php echo esc_html__( 'Show Filters', 'ayvo' ); ?>
                </a>
				<?php if ( is_active_sidebar( $shop_sidebar ) ) : ?>
                    <div class="widget-area shop-sidebar">
						<?php dynamic_sidebar( $shop_sidebar ); ?>
                    </div>
				<?php endif; ?>
            </div>
		<?php endif;
	}
}
add_action( 'ayvo_share_button', 'ayvo_share_button' );
if ( !function_exists( 'ayvo_share_button' ) ) {
	function ayvo_share_button( $post_id )
	{
		$share_image_url  = wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'full' );
		$share_link_url   = get_permalink( $post_id );
		$share_link_title = get_the_title();
		$share_summary    = get_the_excerpt();
		$twitter          = 'https://twitter.com/share?url=' . $share_link_url . '&text=' . $share_summary;
		$facebook         = 'https://www.facebook.com/sharer.php?u=' . $share_link_url;
		$google           = 'https://plus.google.com/share?url=' . $share_link_url . '&title=' . $share_link_title;
		$pinterest        = 'http://pinterest.com/pin/create/button/?url=' . $share_link_url . '&description=' . $share_summary . '&media=' . $share_image_url;
		?>
        <div class="ovic-share-socials">
            <span><?php echo esc_html( 'Share: ', 'ayvo' ) ?></span>
            <a class="twitter"
               href="<?php echo esc_url( $twitter ); ?>"
               title="<?php echo esc_attr__( 'Twitter', 'ayvo' ) ?>"
               onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                <i class="abc icon-twitter"></i>
            </a>
            <a class="facebook"
               href="<?php echo esc_url( $facebook ); ?>"
               title="<?php echo esc_attr__( 'Facebook', 'ayvo' ) ?>"
               onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                <i class="abc icon-facebook2"></i>
            </a>
            <a class="googleplus"
               href="<?php echo esc_url( $google ); ?>"
               title="<?php echo esc_attr__( 'Google+', 'ayvo' ) ?>"
               onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                <i class="abc icon-google"></i>
            </a>
            <a class="pinterest"
               href="<?php echo esc_url( $pinterest ); ?>"
               title="<?php echo esc_attr__( 'Pinterest', 'ayvo' ) ?>"
               onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                <i class="abc icon-pinterest"></i>
            </a>
        </div>
		<?php
	}
}
// CUSTOM SIZE GALLERY THUMBNAIL
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'ayvo_woocommerce_get_image_size_gallery_thumbnail' );
if ( !function_exists( 'ayvo_woocommerce_get_image_size_gallery_thumbnail' ) ) {
	function ayvo_woocommerce_get_image_size_gallery_thumbnail( $size )
	{
		$size['width']  = 80;
		$size['height'] = 100;
		$size['crop']   = 1;

		return $size;
	}
}
/*==========================================================================
TEMPLATE FUNCTIONS
===========================================================================*/
if ( !function_exists( 'ayvo_before_single_product_summary' ) ) {
	function ayvo_before_single_product_summary()
	{
		echo '<div class="wrapper-single-product">';
	}
}
if ( !function_exists( 'ayvo_after_single_product_summary' ) ) {
	function ayvo_after_single_product_summary()
	{
		
		echo '</div>';
	}
}
if ( !function_exists( 'ayvo_template_single_available' ) ) {
	function ayvo_template_single_available()
	{
		global $product;
		if ( $product->is_in_stock() ) {
			$class = 'in-stock available-product';
			$text  = $product->get_stock_quantity() . ' In stock';
			?>
<a class="instock <?php echo esc_attr( $class ); ?>" href="#"><i class="fa fa-check-circle"></i> <?php echo esc_html( $text ); ?></a>
<?php
		} else {
			$class = 'out-stock available-product';
			$text  = 'Out of stock';
			?>
<a class="instock <?php echo esc_attr( $class ); ?>" href="#"><i class="fa fa-times-circle"></i> <?php echo esc_html( $text ); ?></a>
			
	<?php	} ?>
       
			
           
        
		<?php
	}
}
/* AJAX UPDATE WISH LIST */
if ( !function_exists( 'ayvo_update_wishlist_count' ) ) {
	function ayvo_update_wishlist_count()
	{
		if ( function_exists( 'YITH_WCWL' ) ) {
			wp_send_json( YITH_WCWL()->count_products() );
		}
		wp_die();
	}

	// Wishlist ajaxify update
	add_action( 'wp_ajax_ayvo_update_wishlist_count', 'ayvo_update_wishlist_count' );
	add_action( 'wp_ajax_nopriv_ayvo_update_wishlist_count', 'ayvo_update_wishlist_count' );
}
/* COMPARE */
if ( !function_exists( 'ayvo_compare' ) ) {
	function ayvo_compare()
	{
		if ( class_exists( 'YITH_Woocompare' ) ) :
			global $yith_woocompare; ?>
            <div class="block-compare">
                <a href="<?php echo add_query_arg( array( 'iframe' => 'true' ), $yith_woocompare->obj->view_table_url() ) ?>"
                   class="compare added" rel="nofollow">
                    <span class="fa fa-balance-scale top-icon"></span>
                    <span class="text"><?php echo esc_html__( 'Compare', 'ayvo' ); ?></span>
                </a>
            </div>
		<?php endif;
	}
}
/* WISHLIST */
if ( !function_exists( 'ayvo_wishlist' ) ) {
	function ayvo_wishlist()
	{
		if ( defined( 'YITH_WCWL' ) ) :
			$wishlist_url = YITH_WCWL()->get_wishlist_url();
			if ( $wishlist_url != '' ) : ?>
                <div class="block-wishlist">
                    <a class="woo-wishlist-link" href="<?php echo esc_url( $wishlist_url ); ?>">
						<span class="icon pe-7s-like">
                            <span class="count"><?php echo YITH_WCWL()->count_products(); ?></span>
                        </span>
                        <span class="text"><?php echo esc_html__( 'Wishlist', 'ayvo' ); ?></span>
                    </a>
                </div>
			<?php endif;
		endif;
	}
}
/* MINI CART */
if ( !function_exists( 'ayvo_header_cart_link' ) ) {
	function ayvo_header_cart_link()
	{
		?>
        <a class="link-dropdown cart-link" href="<?php echo wc_get_cart_url(); ?>">
            <span class="abc icon-cart3"></span>
            <span class="text"><?php echo esc_html__( 'cart', 'ayvo' ); ?></span>
            <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?>  </span>
        </a>
		<?php
	}
}
if ( !function_exists( 'ayvo_header_mini_cart' ) ) {
	function ayvo_header_mini_cart()
	{
		?>
        <div class="block-minicart ovic-mini-cart ovic-dropdown">
			<?php
			ayvo_header_cart_link();
			the_widget( 'WC_Widget_Cart', 'title=' );
			?>
        </div>
		<?php
	}
}
if ( !function_exists( 'ayvo_cart_link_fragment' ) ) {
	function ayvo_cart_link_fragment( $fragments )
	{
		ob_start();
		ayvo_header_cart_link();
		$fragments['a.cart-link'] = ob_get_clean();

		return $fragments;
	}
}
if ( !function_exists( 'ayvo_cart_view_count' ) ) {
	function ayvo_cart_view_count()
	{
		if ( WC()->cart->get_cart_contents_count() != 0 ) {
			echo sprintf( '<div class="">' . esc_html__( '', 'ayvo' ) . '</div>', WC()->cart->get_cart_contents_count() );
		}
	}
}
/**
 *
 * HOOK TEMPLATE BANNER
 */
if ( !function_exists( 'ayvo_woocommerce_banner' ) ) {
	function ayvo_woocommerce_banner()
	{
		$image = Ayvo_Functions::get_option( 'banner_shop_image' );
		if ( is_product_category() ) {
			global $wp_query;
			$cat       = $wp_query->get_queried_object();
			$image_cat = get_term_meta( $cat->term_id, 'thumbnail_id', true );
			if ( $image_cat )
				$image = $image_cat;
		}
		if ( !is_product() ): ?>
            <div class="banner-shop-page">
				<?php
				if ( $image )
					echo wp_get_attachment_image( $image, 'full' );
				?>
                <h1 class="woocommerce-products-header__title page-title">
                    <span><?php woocommerce_page_title(); ?></span></h1>
            </div>
		<?php
		endif;
	}

	add_action( 'woocommerce_before_main_content', 'ayvo_woocommerce_banner', 60 );
}
if ( !function_exists( 'ayvo_show_attributes' ) ) {
	add_action( 'ayvo_show_attributes', 'ayvo_show_attributes' );
	function ayvo_show_attributes( $option )
	{
		global $product;
		$attribute_name = Ayvo_Functions::get_option( $option, '' );
		if ( $product->get_type() == 'variable' ) : ?>
            <div class="product-attr">
                <div class="ovic_variations_form list-attribute">
                    <div class="variations">
						<?php
						$terms = wc_get_product_terms( $product->get_id(), 'pa_' . $attribute_name,
							array(
								'fields' => 'all',
							)
						);
						foreach ( $terms as $term ) {
							if ( !is_wp_error( $term ) ) {
								// For color attribute
								$data_type  = get_term_meta( $term->term_id, $term->taxonomy . '_attribute_swatch_type', true );
								$data_color = get_term_meta( $term->term_id, $term->taxonomy . '_attribute_swatch_color', true );
								$data_photo = get_term_meta( $term->term_id, $term->taxonomy . '_attribute_swatch_photo', true );
								$photo_url  = wp_get_attachment_image_url( $data_photo, 'thumbnail' );
								if ( $data_type == 'color' ) {
									echo '<span class="attribute color" style="background:' . esc_attr( $data_color ) . '"></span>';
								} elseif ( $data_type == 'photo' ) {
									echo '<span class="attribute photo" style="background:' . esc_attr( $photo_url ) . '"></span>';
								} elseif ( $data_type == 'label' ) {
									echo '<span class="attribute label">' . esc_html( $term->name ) . '</span>';
								} else {
									echo '<span class="attribute label">' . esc_html( $term->name ) . '</span>';
								}
							}
						}
						?>
                    </div>
                </div>
            </div>
		<?php
		endif;
	}
}
add_filter( 'ovic_woocommerce_before_main_content', 'ayvo_shop_page_container' );
if ( !function_exists( 'ayvo_shop_page_container' ) ) {
	function ayvo_shop_page_container()
	{
		$container            = Ayvo_Functions::get_option( 'enable_shop_theme_container' );
		$option_layout        = ovic_woocommerce_options_sidebar();
		$html                 = '';
		$main_container_class = array();
		if ( is_product() ) {
			$thumbnail_layout       = Ayvo_Functions::get_option( 'ovic_single_product_thumbnail', 'vertical' );
			$main_container_class[] = 'single-thumb-' . $thumbnail_layout;
		}
		$shop_layout            = $option_layout['layout'];
		$main_container_class[] = 'main-container shop-page';
		if ( $shop_layout == 'full' ) {
			$main_container_class[] = 'no-sidebar';
		} else {
			$main_container_class[] = $shop_layout . '-sidebar';
		}
		$main_container_class = apply_filters( 'ovic_class_before_main_content_product', $main_container_class, $shop_layout );
		$html                 .= '<div class="' . esc_attr( implode( ' ', $main_container_class ) ) . '">';
		if ( $container == 1 ) {
			$html .= '<div class="theme-container">';
		} else {
			$html .= '<div class="container">';
		}
		$html .= '<div class="row">';

		return $html;
	}
}
if ( !function_exists( 'ayvo_woocommerce_catalog_ordering' ) ) {
	function ayvo_woocommerce_catalog_ordering()
	{
		?>
        <div class="wrapper-catalog-ordering">
            <span class="title"></span>
			<?php woocommerce_catalog_ordering(); ?>
        </div>
		<?php
	}
}
if ( !function_exists( 'ayvo_woocommerce_display_mode_button' ) ) {
	function ayvo_woocommerce_display_mode_button( $html, $shop_display_mode )
	{
		ob_start(); ?>
        <span class="title control-title"></span>
        <div class="wrap-display-mode">
            <button type="submit"
                    class="modes-mode mode-grid display-mode <?php if ( $shop_display_mode == 'grid' ): ?>active<?php endif; ?>"
                    value="grid"
                    name="ovic_shop_list_style">
                <span class="button-inner">
                   
                </span>
            </button>
            <button class="grid-number item-2" value="2">
                <span class="button-inner">
                    <?php echo esc_html__( '2', 'ayvo' ); ?>
                </span>
            </button>
            <button class="grid-number item-3" value="3">
                <span class="button-inner">
                    <?php echo esc_html__( '3', 'ayvo' ); ?>
                </span>
            </button>
            <button class="grid-number item-4" value="4">
                <span class="button-inner">
                    <?php echo esc_html__( '4', 'ayvo' ); ?>
                </span>
            </button>
            <button class="grid-number item-5" value="5">
                <span class="button-inner">
                    <?php echo esc_html__( '5', 'ayvo' ); ?>
                </span>
            </button>
            <button class="grid-number item-6" value="6">
                <span class="button-inner">
                    <?php echo esc_html__( '6', 'ayvo' ); ?>
                </span>
            </button>
            <button type="submit"
                    class="modes-mode mode-list display-mode <?php if ( $shop_display_mode == 'list' ): ?>active<?php endif; ?>"
                    value="list"
                    name="ovic_shop_list_style">
                <span class="button-inner">
                    
                </span>
            </button>
        </div>
		<?php
		return ob_get_clean();
	}
}
if ( !function_exists( 'ayvo_gallery_image_product' ) ) {
	function ayvo_gallery_image_product( $image, $attachment_id )
	{
		$product_thumb = Ayvo_Functions::get_option( 'ovic_single_product_thumbnail', 'vertical' );
		if ( $product_thumb == 'slide' )
			$image = wc_get_gallery_image_html( $attachment_id, true );

		return $image;
	}

	add_filter( 'woocommerce_single_product_image_thumbnail_html', 'ayvo_gallery_image_product', 10, 2 );
}
// PRODUCT RATING
add_filter( 'woocommerce_product_get_rating_html', 'ayvo_product_get_rating_html', 10, 3 );
if ( !function_exists( 'ayvo_product_get_rating_html' ) ) {
	function ayvo_product_get_rating_html( $html, $rating, $count )
	{
		{
			global $product;
			$rating_count = isset( $product ) ? $product->get_rating_count() : 0;
			$html         = '<div class="rating-wapper"><div class="star-rating">';
			$html         .= wc_get_star_rating_html( $rating, $count );
			$html         .= '</div>';
			$html         .= '<span class="review">' . $rating_count . ' ' . esc_html__( '', 'ayvo' ) . '</span>';
			$html         .= '</div>';

			return $html;
		}
	}
}
if ( !function_exists( 'ayvo_product_loadmore' ) ) {
	function ayvo_product_loadmore()
	{
		$response   = array(
			'html'     => '',
			'loop_id'  => array(),
			'out_post' => 'no',
			'message'  => '',
			'success'  => 'no',
		);
		$out_post   = 'no';
		$args       = isset( $_POST['loop_query'] ) ? $_POST['loop_query'] : array();
		$class      = isset( $_POST['loop_class'] ) ? $_POST['loop_class'] : array();
		$loop_id    = isset( $_POST['loop_id'] ) ? $_POST['loop_id'] : array();
		$loop_style = isset( $_POST['loop_style'] ) ? $_POST['loop_style'] : '';
		$loop_thumb = isset( $_POST['loop_thumb'] ) ? explode( 'x', $_POST['loop_thumb'] ) : '';
		if ( isset( $args['post__in'] ) )
			unset( $args['post__in'] );
		$args['post__not_in'] = $loop_id;
		add_filter( 'ovic_shop_pruduct_thumb_width', create_function( '', 'return ' . $loop_thumb[0] . ';' ) );
		add_filter( 'ovic_shop_pruduct_thumb_height', create_function( '', 'return ' . $loop_thumb[1] . ';' ) );
		$loop_posts = new WP_Query( $args );
		ob_start();
		if ( $loop_posts->have_posts() ) {
			while ( $loop_posts->have_posts() ) : $loop_posts->the_post(); ?>
				<?php $loop_id[] = get_the_ID(); ?>
                <div <?php wc_product_class( $class ); ?>>
					<?php wc_get_template_part( 'product-styles/content-product', 'style-' . $loop_style ); ?>
                </div>
			<?php
			endwhile;
			wp_reset_postdata();
			wp_reset_query();
		} else {
			$out_post = 'yes';
		}
		$response['html']     = ob_get_clean();
		$response['loop_id']  = $loop_id;
		$response['out_post'] = $out_post;
		$response['success']  = 'yes';
		wp_send_json( $response );
		die();
	}
}
/**
 *
 * CUSTOM PRODUCT THUMB
 */
if ( !function_exists( 'ayvo_template_loop_product_thumbnail' ) && class_exists( 'Ovic_Toolkit' ) ) {
	function ayvo_template_loop_product_thumbnail()
	{
		global $product;
		// GET SIZE IMAGE SETTING
		$width  = 300;
		$height = 300;
		$crop   = true;
		$size   = wc_get_image_size( 'shop_catalog' );
		if ( $size ) {
			$width  = $size['width'];
			$height = $size['height'];
			if ( !$size['crop'] ) {
				$crop = false;
			}
		}
		$lazy_load          = true;
		$thumbnail_id       = $product->get_image_id();
		$attachment_ids     = $product->get_gallery_image_ids();
		$default_attributes = $product->get_default_attributes();
		$width              = apply_filters( 'ovic_shop_product_thumb_width', $width );
		$height             = apply_filters( 'ovic_shop_product_thumb_height', $height );
		if ( !empty( $default_attributes ) )
			$lazy_load = false;
		$image_thumb = apply_filters( 'ovic_resize_image', $thumbnail_id, $width, $height, $crop, $lazy_load );
		?>
         <a class="thumb-link woocommerce-product-gallery__image  not-active" href="<?php the_permalink(); ?>">
			 <div class="slider owl-carousel" >			
            
			<figure>
				<?php echo wp_specialchars_decode( $image_thumb['img'] ); ?>
            </figure>
			<?php if ( $attachment_ids && isset( $attachment_ids[0] ) && has_post_thumbnail() ): 
				$image_gallery = apply_filters( 'ovic_resize_image', $attachment_ids[0], $width, $height, $crop, $lazy_load );
				?>
                <figure>
					<?php echo wp_specialchars_decode( $image_gallery['img'] ); ?>
                </figure>
			<?php endif; ?>
			<?php if ( $attachment_ids && isset( $attachment_ids[1] ) && has_post_thumbnail() ): 
				$image_gallery = apply_filters( 'ovic_resize_image', $attachment_ids[1], $width, $height, $crop, $lazy_load );
				?>
                <figure>
					<?php echo wp_specialchars_decode( $image_gallery['img'] ); ?>
                </figure>
			<?php endif; ?>
			<?php if ( $attachment_ids && isset( $attachment_ids[2] ) && has_post_thumbnail() ): 
				$image_gallery = apply_filters( 'ovic_resize_image', $attachment_ids[2], $width, $height, $crop, $lazy_load );
				?>
                <figure>
					<?php echo wp_specialchars_decode( $image_gallery['img'] ); ?>
                </figure>
			<?php endif; ?>
			</div>
        </a>
		<?php
	}

	remove_action( 'woocommerce_before_shop_loop_item_title', 'ovic_template_loop_product_thumbnail', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'ayvo_template_loop_product_thumbnail', 10 );
}
/**
 *
 * CUSTOM ACCOUNT PAGE
 */
add_action( 'woocommerce_after_customer_login_form', 'ayvo_after_customer_login_form', 10 );
if ( !function_exists( 'ayvo_after_customer_login_form' ) ) {
	function ayvo_after_customer_login_form()
	{
		if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ): ?>
            <div class="ayvo-footer-account">
                <a href="#"
                   data-page="register"
                   data-register="<?php echo esc_attr__( 'Or Create an Account', 'ayvo' ); ?>"
                   data-login="<?php echo esc_attr__( 'Or Login', 'ayvo' ); ?>">
					<?php echo esc_html__( 'Or Create an Account', 'ayvo' ); ?>
                </a>
            </div>
		<?php
		endif;
	}
}