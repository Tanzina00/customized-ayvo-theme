<?php
if ( class_exists( 'Ovic_Toolkit' ) ) {
	add_filter( 'ovic_main_custom_css', 'Ayvo_Custom_Css' );
} else {
	add_action( 'wp_enqueue_scripts', 'Ayvo_custom_inline_css', 999 );
}
if ( !function_exists( 'Ayvo_custom_inline_css' ) ) {
	function Ayvo_custom_inline_css()
	{
		$css     = '';
		$css     = Ayvo_Custom_Css( $css );
		$content = preg_replace( '/\s+/', ' ', $css );
		wp_add_inline_style( 'ayvo-custom-css', $content );
	}
}
if ( !function_exists( 'Ayvo_Custom_Css' ) ) {
	function Ayvo_Custom_Css( $css )
	{
		$main_color   = Ayvo_Functions::get_option( 'ovic_main_color', '#c61a32' );
		$active_color = Ayvo_Functions::get_option( 'ovic_active_color', '#c61a32' );
		$css .= '
        a:hover,
		a:focus,
		.post-item .readmore-button,
		.product-item .product-name a:hover,
		.product-item .product-metas .category a:hover,
		.footer .menu li a:hover,
		.breadcrumbs .breadcrumb li a:hover,
		.blog-portfolio .post-item .post-categories a:hover,
		.blog-portfolio .post-item .post-title a:hover,
		.blog-single .group-bottom a:hover,
		.header-mobile .block-menu-bar .menu-bar:hover,
		.header-mobile .block-search .open-search:hover,
		.header-mobile .block-minicart .cart-link:hover,
		.header-mobile .block-menu-bar .menu-bar:focus,
		.header-mobile .block-search .open-search:focus,
		.header-mobile .block-minicart .cart-link:focus,
		.widget_archive ul li a:hover,
		.widget_archive ul li a:hover:before,
		.widget_categories ul li a:hover,
		.widget_products .product_list_widget li a:hover,
		.widget_recent_reviews .product_list_widget li a:hover,
		.widget_top_rated_products .product_list_widget li a:hover,
		.shop_table td.product-name a:hover,
		.ovic-video .video-inner .video-button:hover,
		.ovic-person.style-2 .content-person .name a:hover,
		.woocommerce .woocommerce-MyAccount-navigation.is-active a,
		.shop-button.style-4:hover,
		.footer .buytheme:hover,
		.footer-mobile .footer-mobile-inner > .item a:hover,
		.footer-mobile .footer-mobile-inner > .item a:focus,
		.ovic-custommenu .menu-item-has-children.open-submenu > a,
		.woocommerce-product-gallery__trigger:hover::before,
		.header.style-6 .main-menu > li > a:hover,
		.header.style-6 .main-menu > li:hover > a,
		.header.style-6 .main-menu > li.current-menu-item > a,
		.header.style-6 .main-menu > li.current_page_item > a,
		.header.style-7 .main-menu > li > a:hover,
		.header.style-7 .main-menu > li:hover > a,
		.header.style-7 .main-menu > li.current-menu-item > a,
		.header.style-7 .main-menu > li.current_page_item > a,
		.ovic-tabs .tab-head .tab-link li.active > a,
		.shop-button.style-6:hover,
		.banner-button .shop-button.style-7:hover,
		.coppy-right a:hover,
		.ovic-category.style-3 .cate-filter:hover {
			color: ' . $main_color . ';
		}
		.blog-portfolio .post-item .view-more .view-button:hover,
		.comments-area .form-submit input[type="submit"],
		.wc-proceed-to-checkout a,
		.filter-button-group .filter-list a.active,
		.ovic-newsletter .newsletter-form-wrap .button,
		.mfp-close-btn-in .mfp-close:hover,
		.block-search.style-2 .form-search .btn-submit:hover,
		.shop-button:not(.style-1):hover,
		.ovic-countdown-sc .button:hover,
		.header.style-6 .block-minicart .cart-link .count,
		.ovic-tabs .tab-head .tab-link li.active > a::after,
		.shop-button.style-6:hover::after,
		.shop-button.style-7:hover::before,
		.header.style-7 .main-menu > li > a:hover::before,
		.header.style-7 .main-menu > li:hover > a::before,
		.header.style-7 .main-menu > li.current-menu-item > a::before,
		.header.style-7 .main-menu > li.current_page_item > a::before,
		.main-menu > li > .desc {
			background-color: ' . $main_color . ';
		}
		.header-mobile .block-search .open-search:hover,
		.header-mobile .block-minicart .cart-link:hover,
		.header-mobile .block-menu-bar .menu-bar:focus,
		.header-mobile .block-search .open-search:focus,
		.header-mobile .block-minicart .cart-link:focus {
			border-color: ' . $main_color . ';
		}

		';
		return $css;
	}
}