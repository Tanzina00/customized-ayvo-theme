<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( !function_exists( 'ayvo_ajax_event_register' ) ) {
	function ayvo_ajax_event_register( $ajax_events )
	{
		$ajax_events['ayvo_ajax_gallery']     = true;
		$ajax_events['ayvo_product_loadmore'] = true;

		return $ajax_events;
	}

	add_filter( 'ovic_ajax_event_register', 'ayvo_ajax_event_register' );
}
/*==========================================================================
HOOK TEMPLATE FUNCTIONS
===========================================================================*/
add_filter( 'ovic_load_icon_json', 'ayvo_add_icon' );
/**
 *
 * TEMPLATE THEME
 */
if ( !function_exists( 'ayvo_add_icon' ) ) {
	function ayvo_add_icon( $icon )
	{
		$icon[] = array(
			'name'  => 'Abcicon',
			'icons' => array(
				'abc icon-phone_in_talk',
				'abc icon-phone-call',
				'abc icon-twitter',
				'abc icon-vimeo',
				'abc icon-instagram',
				'abc icon-behance',
				'abc icon-pinterest',
				'abc icon-linkedin2',
				'abc icon-mail',
				'abc icon-paperplane',
				'abc icon-user3',
				'abc icon-youtube',
			),
		);

		return $icon;
	}
}
// GET HEADER
add_action( 'ayvo_header_content', 'ayvo_header_content' );
add_action( 'ayvo_header_mobile', 'ayvo_header_mobile' );
add_action( 'ayvo_footer_mobile', 'ayvo_footer_mobile' );
/*==========================================================================
TEMPLATE FUNCTIONS
===========================================================================*/
// GET HEADER
if ( !function_exists( 'ayvo_header_content' ) ) {
	function ayvo_header_content()
	{
		$data_meta           = get_post_meta( get_the_ID(), '_custom_metabox_theme_options', true );
		$enable_theme_option = isset( $data_meta['metabox_options_enable'] ) ? $data_meta['metabox_options_enable'] : 0;
		$header_options      = Ayvo_Functions::get_option( 'ayvo_used_header', 'style-06' );
		$header_options      = $enable_theme_option == 1 && isset( $data_meta['metabox_ayvo_used_header'] ) && $data_meta['metabox_ayvo_used_header'] != '' ? $data_meta['metabox_ayvo_used_header'] : $header_options;
		get_template_part( 'templates/header/header', $header_options );
	}
}
// GET FOOTER
add_filter( 'ovic_overide_footer_template', 'ayvo_overide_footer_template' );
if ( !function_exists( 'ayvo_overide_footer_template' ) ) {
	function ayvo_overide_footer_template()
	{
		$data_meta           = get_post_meta( get_the_ID(), '_custom_metabox_theme_options', true );
		$enable_theme_option = isset( $data_meta['metabox_options_enable'] ) ? $data_meta['metabox_options_enable'] : 0;
		$footer_options      = Ayvo_Functions::get_option( 'ovic_footer_template', '' );
		$footer_options      = $enable_theme_option == 1 && isset( $data_meta['metabox_ayvo_used_footer'] ) && $data_meta['metabox_ayvo_used_footer'] != '' ? $data_meta['metabox_ayvo_used_footer'] : $footer_options;

		return $footer_options;
	}
}
if ( !function_exists( 'ayvo_header_mobile' ) ) {
	function ayvo_header_mobile()
	{
		?>
        <div class="header-mobile">
            <div class="container">
                <div class="header-mobile-inner">
					<div class="block-menu-bar">
                            <a class="menu-bar menu-toggle menu-mobile" href="#">
                              MENU
                            </a>
                        </div>
                    <div class="logos">
						<?php Ayvo_Functions::get_logo(); ?>
                    </div>
					
					<?php ayvo_search_form(); ?>
					<?php do_action( 'ayvo_header_mini_cart' ); ?>
                </div>
				
            </div>
			
        </div>
		<?php
	}
}
add_action( 'woocommerce_before_main_content','ayvo_footer_mobile', 10 );
if ( !function_exists( 'ayvo_footer_mobile' ) ) {
	function ayvo_footer_mobile()
	{
		?>
        <div class="footer-mobile">
            <div class="footer-mobile-inner">
               
                
				<?php
				$sidebar_layout        = Ayvo_Functions::get_option( 'ovic_sidebar_blog_layout', '' );
				$shop_layout           = Ayvo_Functions::get_option( 'ovic_sidebar_shop_layout', '' );
				$blog_single_layout    = Ayvo_Functions::get_option( 'ovic_sidebar_single_layout', '' );
				$product_single_layout = Ayvo_Functions::get_option( 'ovic_sidebar_single_product_layout', '' );
				$ayvo_page_layout      = Ayvo_Functions::get_post_meta( get_the_ID(), 'ovic_page_layout', '' );
				if ( is_page() ) {
					$ayvo_page_used_sidebar = Ayvo_Functions::get_post_meta( get_the_ID(), 'ovic_page_used_sidebar', 'widget-area' );
					if ( !is_active_sidebar( $ayvo_page_used_sidebar ) ) {
						$ayvo_page_layout = 'full';
					}
					$sidebar_layout = $ayvo_page_layout;
				} elseif ( is_single() ) {
					$ayvo_blog_used_sidebar = Ayvo_Functions::get_option( 'ovic_single_used_sidebar', '' );
					if ( !is_active_sidebar( $ayvo_blog_used_sidebar ) ) {
						$blog_single_layout = 'full';
					}
					$sidebar_layout = $blog_single_layout;
				} elseif ( function_exists( 'is_product' ) && is_product() ) {
					$ovic_single_product_used_sidebar = Ayvo_Functions::get_option( 'ovic_single_product_used_sidebar', '' );
					if ( !is_active_sidebar( $ovic_single_product_used_sidebar ) ) {
						$product_single_layout = 'full';
					}
					$sidebar_layout = $product_single_layout;
				} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
					$ovic_shop_used_sidebar = Ayvo_Functions::get_option( 'ovic_shop_used_sidebar', '' );
					if ( !is_active_sidebar( $ovic_shop_used_sidebar ) ) {
						$shop_layout = 'full';
					}
					$sidebar_layout = $shop_layout;
				}
				if ( $sidebar_layout != 'full' ) { ?>
                    <div class="item sidebar-item">
                        <a href="#" class="sidebar-open-btn">
                            <span class=""><?php echo esc_html__( 'Refine Your Search', 'ayvo' ); ?></span>
                        </a>
                    </div>
				<?php } ?>
				<?php $ovic_sidebar_shop_layout = Ayvo_Functions::get_option( 'ovic_sidebar_shop_layout', '' );
				if ( $ovic_sidebar_shop_layout == 'full' ) { ?>
                    <div class="item filter-item">
                        <a href="#" class="shop-open-filter action-filter-sidebar">
                            <span class="fa fa-filter"></span>
                            <span class="text"><?php echo esc_html__( 'REFINE', 'ayvo' ); ?></span>
                        </a>
                    </div>
				<?php } ?>
                
            </div>
        </div>
		<?php
	}
}
if ( !function_exists( 'ayvo_search_form' ) ) {
	function ayvo_search_form()
	{
		$class               = array( 'block-search ovic-dropdown' );
		$data_meta           = get_post_meta( get_the_ID(), '_custom_metabox_theme_options', true );
		$enable_theme_option = isset( $data_meta['metabox_options_enable'] ) ? $data_meta['metabox_options_enable'] : 0;
		$header_options      = Ayvo_Functions::get_option( 'ayvo_used_header', 'style-01' );
		$header_options      = $enable_theme_option == 1 && isset( $data_meta['metabox_ayvo_used_header'] ) && $data_meta['metabox_ayvo_used_header'] != '' ? $data_meta['metabox_ayvo_used_header'] : $header_options;
		if ( $header_options == 'style-05' ) {
			$class[] = 'style-2';
		}
		?>
        <div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
            <a href="#" class="open-search" data-ovic="ovic-dropdown"><span class="abc icon-search5"></span></a>
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>"
                  class="form-search">
				<?php if ( class_exists( 'WooCommerce' ) ): ?>
                    <input type="hidden" name="post_type" value="product"/>
                    <input type="hidden" name="taxonomy" value="product_cat">
				<?php else: ?>
                    <input type="hidden" name="post_type" value="post"/>
				<?php endif; ?>
                <div class="search-box results-search">
					<?php if ( $header_options != 'style-05' ): ?>
                    <div class="container"><?php endif; ?>
                        <div class="inner">
                            <input autocomplete="off" type="text" class="searchfield txt-livesearch input-info" name="s"
                                   value="<?php echo esc_attr( get_search_query() ); ?>"
                                   >
                            <button type="submit" class="btn-submit">
								<?php echo esc_html__( '', 'ayvo' ); ?>
                            </button>
                            <a href="#" class="close-search"><span class="abc icon-x"></span></a>
                        </div>
						<?php if ( $header_options != 'style-05' ): ?></div><?php endif; ?>
                </div>
            </form>
        </div>
		<?php
	}
}
if ( !function_exists( 'ayvo_user_link' ) ) {
	function ayvo_user_link()
	{
		$myaccount_link = wp_login_url();
		if ( class_exists( 'WooCommerce' ) ) {
			$myaccount_link = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		}
		?>
        <div class="block-user login-register-form ovic-dropdown">
			<?php if ( is_user_logged_in() ): ?>
                <a data-ovic="ovic-dropdown" class="user-link"
                   href="<?php echo esc_url( $myaccount_link ); ?>">
                    <span class="abc icon pe-7s-user"> </span>
                    <span class="ulogin text"></span>
                </a>
				<?php if ( function_exists( 'wc_get_account_menu_items' ) ): ?>
                    <ul class="sub-menu">
						<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                            <li class="menu-item <?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
                            </li>
						<?php endforeach; ?>
                    </ul>
				<?php else: ?>
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="<?php echo wp_logout_url( get_permalink() ); ?>"><?php esc_html_e( 'Logout', 'ayvo' ); ?></a>
                        </li>
                    </ul>
				<?php endif;
			else: ?>
                 <a class="user-link out-login woo-login-popup-sc-open" href="#woo-login-popup-sc-login">
                    <span class="abc icon pe-7s-user"></span>
                    <span class="loginreg text"></span>
                </a>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    
				<?php endif; ?>
			<?php endif; ?>
        </div>
		<?php
	}
}
/**
 * add icon for shortcode
 */
if ( !function_exists( 'ayvo_iconpicker_type' ) ) {
	add_filter( 'ovic_add_icon_field', 'ayvo_iconpicker_type' );
	function ayvo_iconpicker_type()
	{
		$fonts = array(
			array( 'abc icon-laptop' => esc_html__( 'Icon laptop', 'ayvo' ) ),
			array( 'abc icon-desktop2' => esc_html__( 'Icon desktop2', 'ayvo' ) ),
			array( 'abc icon-tablet' => esc_html__( 'Icon tablet', 'ayvo' ) ),
			array( 'abc icon-phone' => esc_html__( 'Icon phone', 'ayvo' ) ),
			array( 'abc icon-camera' => esc_html__( 'Icon camera', 'ayvo' ) ),
			array( 'abc icon-printer' => esc_html__( 'Icon printer', 'ayvo' ) ),
			array( 'abc icon-wallet' => esc_html__( 'Icon wallet', 'ayvo' ) ),
			array( 'abc icon-basket' => esc_html__( 'Icon basket', 'ayvo' ) ),
			array( 'abc icon-tools-2' => esc_html__( 'Icon tools 2', 'ayvo' ) ),
			array( 'abc icon-bike' => esc_html__( 'Icon bike', 'ayvo' ) ),
			array( 'abc icon-facebook' => esc_html__( 'Icon facebook', 'ayvo' ) ),
			array( 'abc icon-twitter2' => esc_html__( 'Icon twitter2', 'ayvo' ) ),
			array( 'abc icon-googleplus' => esc_html__( 'Icon googleplus', 'ayvo' ) ),
			array( 'abc icon-rss' => esc_html__( 'Icon rss', 'ayvo' ) ),
			array( 'abc icon-tumblr' => esc_html__( 'Icon tumblr', 'ayvo' ) ),
			array( 'abc icon-linkedin' => esc_html__( 'Icon linkedin', 'ayvo' ) ),
			array( 'abc icon-dribbble2' => esc_html__( 'Icon dribbble2', 'ayvo' ) ),
			array( 'abc icon-quote' => esc_html__( 'Icon quote', 'ayvo' ) ),
			array( 'abc icon-quote2' => esc_html__( 'Icon quote2', 'ayvo' ) ),
			array( 'abc icon-phone2' => esc_html__( 'Icon phone2', 'ayvo' ) ),
			array( 'abc icon-window' => esc_html__( 'Icon window', 'ayvo' ) ),
			array( 'abc icon-monitor' => esc_html__( 'Icon monitor', 'ayvo' ) ),
			array( 'abc icon-ipod' => esc_html__( 'Icon ipod', 'ayvo' ) ),
			array( 'abc icon-camera2' => esc_html__( 'Icon camera2', 'ayvo' ) ),
			array( 'abc icon-film' => esc_html__( 'Icon film', 'ayvo' ) ),
			array( 'abc icon-film2' => esc_html__( 'Icon film2', 'ayvo' ) ),
			array( 'abc icon-drink' => esc_html__( 'Icon drink', 'ayvo' ) ),
			array( 'abc icon-cog' => esc_html__( 'Icon cog', 'ayvo' ) ),
			array( 'abc icon-time' => esc_html__( 'Icon time', 'ayvo' ) ),
			array( 'abc icon-chart' => esc_html__( 'Icon chart', 'ayvo' ) ),
			array( 'abc icon-gamepad' => esc_html__( 'Icon gamepad', 'ayvo' ) ),
			array( 'abc icon-mouse' => esc_html__( 'Icon mouse', 'ayvo' ) ),
			array( 'abc icon-lamp' => esc_html__( 'Icon lamp', 'ayvo' ) ),
			array( 'abc icon-lamp2' => esc_html__( 'Icon lamp2', 'ayvo' ) ),
			array( 'abc icon-comments' => esc_html__( 'Icon comments', 'ayvo' ) ),
			array( 'abc icon-justice' => esc_html__( 'Icon justice', 'ayvo' ) ),
			array( 'abc icon-stats' => esc_html__( 'Icon stats', 'ayvo' ) ),
			array( 'abc icon-pig' => esc_html__( 'Icon pig', 'ayvo' ) ),
			array( 'abc icon-heart2' => esc_html__( 'Icon heart2', 'ayvo' ) ),
			array( 'abc icon-shipping' => esc_html__( 'Icon shipping', 'ayvo' ) ),
			array( 'abc icon-heart3' => esc_html__( 'Icon heart3', 'ayvo' ) ),
			array( 'abc icon-star2' => esc_html__( 'Icon star2', 'ayvo' ) ),
			array( 'abc icon-user2' => esc_html__( 'Icon user2', 'ayvo' ) ),
			array( 'abc icon-search2' => esc_html__( 'Icon search2', 'ayvo' ) ),
			array( 'abc icon-settings' => esc_html__( 'Icon settings', 'ayvo' ) ),
			array( 'abc icon-camera3' => esc_html__( 'Icon camera3', 'ayvo' ) ),
			array( 'abc icon-lock' => esc_html__( 'Icon lock', 'ayvo' ) ),
			array( 'abc icon-display' => esc_html__( 'Icon display', 'ayvo' ) ),
			array( 'abc icon-location3' => esc_html__( 'Icon location3', 'ayvo' ) ),
			array( 'abc icon-eye2' => esc_html__( 'Icon eye2', 'ayvo' ) ),
			array( 'abc icon-bubble' => esc_html__( 'Icon bubble', 'ayvo' ) ),
			array( 'abc icon-phone3' => esc_html__( 'Icon phone3', 'ayvo' ) ),
			array( 'abc icon-mail' => esc_html__( 'Icon mail', 'ayvo' ) ),
			array( 'abc icon-clock2' => esc_html__( 'Icon clock2', 'ayvo' ) ),
			array( 'abc icon-paperplane' => esc_html__( 'Icon paperplane', 'ayvo' ) ),
			array( 'abc icon-banknote' => esc_html__( 'Icon banknote', 'ayvo' ) ),
			array( 'abc icon-shop' => esc_html__( 'Icon shop', 'ayvo' ) ),
			array( 'abc icon-calendar' => esc_html__( 'Icon calendar', 'ayvo' ) ),
			array( 'abc icon-wallet2' => esc_html__( 'Icon wallet2', 'ayvo' ) ),
			array( 'abc icon-truck2' => esc_html__( 'Icon truck2', 'ayvo' ) ),
			array( 'abc icon-world' => esc_html__( 'Icon world', 'ayvo' ) ),
			array( 'abc icon-loop' => esc_html__( 'Icon loop', 'ayvo' ) ),
			array( 'abc icon-loop-alt2' => esc_html__( 'Icon loop alt2', 'ayvo' ) ),
			array( 'abc icon-loop-alt3' => esc_html__( 'Icon loop alt3', 'ayvo' ) ),
			array( 'abc icon-lock-stroke' => esc_html__( 'Icon lock stroke', 'ayvo' ) ),
			array( 'abc icon-search3' => esc_html__( 'Icon search3', 'ayvo' ) ),
			array( 'abc icon-envelope2' => esc_html__( 'Icon envelope2', 'ayvo' ) ),
			array( 'abc icon-compose' => esc_html__( 'Icon compose', 'ayvo' ) ),
			array( 'abc icon-envelope3' => esc_html__( 'Icon envelope3', 'ayvo' ) ),
			array( 'abc icon-cart2' => esc_html__( 'Icon cart2', 'ayvo' ) ),
			array( 'abc icon-monitor2' => esc_html__( 'Icon monitor2', 'ayvo' ) ),
			array( 'abc icon-headphones' => esc_html__( 'Icon headphones', 'ayvo' ) ),
			array( 'abc icon-gift' => esc_html__( 'Icon gift', 'ayvo' ) ),
			array( 'abc icon-book' => esc_html__( 'Icon book', 'ayvo' ) ),
			array( 'abc icon-cart' => esc_html__( 'Icon cart', 'ayvo' ) ),
			array( 'abc icon-credit-card' => esc_html__( 'Icon credit card', 'ayvo' ) ),
			array( 'abc icon-lifebuoy' => esc_html__( 'Icon lifebuoy', 'ayvo' ) ),
			array( 'abc icon-address-book' => esc_html__( 'Icon address book', 'ayvo' ) ),
			array( 'abc icon-location' => esc_html__( 'Icon location', 'ayvo' ) ),
			array( 'abc icon-location2' => esc_html__( 'Icon location2', 'ayvo' ) ),
			array( 'abc icon-map2' => esc_html__( 'Icon map2', 'ayvo' ) ),
			array( 'abc icon-clock' => esc_html__( 'Icon clock', 'ayvo' ) ),
			array( 'abc icon-user' => esc_html__( 'Icon user', 'ayvo' ) ),
			array( 'abc icon-stats-bars' => esc_html__( 'Icon stats bars', 'ayvo' ) ),
			array( 'abc icon-sphere' => esc_html__( 'Icon sphere', 'ayvo' ) ),
			array( 'abc icon-eye' => esc_html__( 'Icon eye', 'ayvo' ) ),
			array( 'abc icon-checkmark' => esc_html__( 'Icon checkmark', 'ayvo' ) ),
			array( 'abc icon-checkmark2' => esc_html__( 'Icon checkmark2', 'ayvo' ) ),
			array( 'abc icon-pause' => esc_html__( 'Icon pause', 'ayvo' ) ),
			array( 'abc icon-loop2' => esc_html__( 'Icon loop2', 'ayvo' ) ),
			array( 'abc icon-instagram' => esc_html__( 'Icon instagram', 'ayvo' ) ),
			array( 'abc icon-twitter' => esc_html__( 'Icon twitter', 'ayvo' ) ),
			array( 'abc icon-vimeo' => esc_html__( 'Icon vimeo', 'ayvo' ) ),
			array( 'abc icon-flickr' => esc_html__( 'Icon flickr', 'ayvo' ) ),
			array( 'abc icon-dribbble' => esc_html__( 'Icon dribbble', 'ayvo' ) ),
			array( 'abc icon-behance' => esc_html__( 'Icon behance', 'ayvo' ) ),
			array( 'abc icon-linkedin2' => esc_html__( 'Icon linkedin2', 'ayvo' ) ),
			array( 'abc icon-pinterest' => esc_html__( 'Icon pinterest', 'ayvo' ) ),
			array( 'abc icon-pinterest2' => esc_html__( 'Icon pinterest2', 'ayvo' ) ),
			array( 'abc icon-truck3' => esc_html__( 'Icon truck3', 'ayvo' ) ),
			array( 'abc icon-star3' => esc_html__( 'Icon star3', 'ayvo' ) ),
			array( 'abc icon-lock-closed' => esc_html__( 'Icon lock closed', 'ayvo' ) ),
			array( 'abc icon-arrow-sync' => esc_html__( 'Icon arrow sync', 'ayvo' ) ),
			array( 'abc icon-arrow-shuffle' => esc_html__( 'Icon arrow shuffle', 'ayvo' ) ),
			array( 'abc icon-arrow-repeat' => esc_html__( 'Icon arrow repeat', 'ayvo' ) ),
			array( 'abc icon-home-outline' => esc_html__( 'Icon home outline', 'ayvo' ) ),
			array( 'abc icon-location-outline' => esc_html__( 'Icon location outline', 'ayvo' ) ),
			array( 'abc icon-star-outline' => esc_html__( 'Icon star outline', 'ayvo' ) ),
			array( 'abc icon-mail2' => esc_html__( 'Icon mail2', 'ayvo' ) ),
			array( 'abc icon-heart-outline' => esc_html__( 'Icon heart outline', 'ayvo' ) ),
			array( 'abc icon-lock-closed-outline' => esc_html__( 'Icon lock closed outline', 'ayvo' ) ),
			array( 'abc icon-eye-outline' => esc_html__( 'Icon eye outline', 'ayvo' ) ),
			array( 'abc icon-camera-outline' => esc_html__( 'Icon camera outline', 'ayvo' ) ),
			array( 'abc icon-support' => esc_html__( 'Icon support', 'ayvo' ) ),
			array( 'abc icon-tag' => esc_html__( 'Icon tag', 'ayvo' ) ),
			array( 'abc icon-edit' => esc_html__( 'Icon edit', 'ayvo' ) ),
			array( 'abc icon-contacts' => esc_html__( 'Icon contacts', 'ayvo' ) ),
			array( 'abc icon-credit-card3' => esc_html__( 'Icon credit card3', 'ayvo' ) ),
			array( 'abc icon-coffee' => esc_html__( 'Icon coffee', 'ayvo' ) ),
			array( 'abc icon-tree' => esc_html__( 'Icon tree', 'ayvo' ) ),
			array( 'abc icon-shopping-cart' => esc_html__( 'Icon shopping cart', 'ayvo' ) ),
			array( 'abc icon-card_travel' => esc_html__( 'Icon card travel', 'ayvo' ) ),
			array( 'abc icon-date_range' => esc_html__( 'Icon date range', 'ayvo' ) ),
			array( 'abc icon-done_all' => esc_html__( 'Icon done all', 'ayvo' ) ),
			array( 'abc icon-markunread' => esc_html__( 'Icon markunread', 'ayvo' ) ),
			array( 'abc icon-equalizer' => esc_html__( 'Icon equalizer', 'ayvo' ) ),
			array( 'abc icon-favorite' => esc_html__( 'Icon favorite', 'ayvo' ) ),
			array( 'abc icon-favorite_border' => esc_html__( 'Icon favorite border', 'ayvo' ) ),
			array( 'abc icon-headset_mic' => esc_html__( 'Icon headset mic', 'ayvo' ) ),
			array( 'abc icon-help_outline' => esc_html__( 'Icon help outline', 'ayvo' ) ),
			array( 'abc icon-lock2' => esc_html__( 'Icon lock2', 'ayvo' ) ),
			array( 'abc icon-laptop_mac' => esc_html__( 'Icon laptop mac', 'ayvo' ) ),
			array( 'abc icon-linked_camera' => esc_html__( 'Icon linked camera', 'ayvo' ) ),
			array( 'abc icon-shopping_cart' => esc_html__( 'Icon shopping cart', 'ayvo' ) ),
			array( 'abc icon-local_mall' => esc_html__( 'Icon local mall', 'ayvo' ) ),
			array( 'abc icon-local_shipping' => esc_html__( 'Icon local shipping', 'ayvo' ) ),
			array( 'abc icon-lock_outline' => esc_html__( 'Icon lock outline', 'ayvo' ) ),
			array( 'abc icon-mail_outline' => esc_html__( 'Icon mail outline', 'ayvo' ) ),
			array( 'abc icon-phone_in_talk' => esc_html__( 'Icon phone in talk', 'ayvo' ) ),
			array( 'abc icon-visibility' => esc_html__( 'Icon visibility', 'ayvo' ) ),
			array( 'abc icon-repeat' => esc_html__( 'Icon repeat', 'ayvo' ) ),
			array( 'abc icon-settings_phone' => esc_html__( 'Icon settings phone', 'ayvo' ) ),
			array( 'abc icon-sort' => esc_html__( 'Icon sort', 'ayvo' ) ),
			array( 'abc icon-subject' => esc_html__( 'Icon subject', 'ayvo' ) ),
			array( 'abc icon-verified_user' => esc_html__( 'Icon verified user', 'ayvo' ) ),
			array( 'abc icon-align-center' => esc_html__( 'Icon align center', 'ayvo' ) ),
			array( 'abc icon-align-justify' => esc_html__( 'Icon align justify', 'ayvo' ) ),
			array( 'abc icon-align-left' => esc_html__( 'Icon align left', 'ayvo' ) ),
			array( 'abc icon-align-right' => esc_html__( 'Icon align right', 'ayvo' ) ),
			array( 'abc icon-aperture' => esc_html__( 'Icon aperture', 'ayvo' ) ),
			array( 'abc icon-bar-chart' => esc_html__( 'Icon bar chart', 'ayvo' ) ),
			array( 'abc icon-bar-chart-2' => esc_html__( 'Icon bar chart 2', 'ayvo' ) ),
			array( 'abc icon-briefcase' => esc_html__( 'Icon briefcase', 'ayvo' ) ),
			array( 'abc icon-calendar2' => esc_html__( 'Icon calendar2', 'ayvo' ) ),
			array( 'abc icon-camera4' => esc_html__( 'Icon camera4', 'ayvo' ) ),
			array( 'abc icon-credit-card4' => esc_html__( 'Icon credit card4', 'ayvo' ) ),
			array( 'abc icon-database' => esc_html__( 'Icon database', 'ayvo' ) ),
			array( 'abc icon-edit2' => esc_html__( 'Icon edit2', 'ayvo' ) ),
			array( 'abc icon-eye3' => esc_html__( 'Icon eye3', 'ayvo' ) ),
			array( 'abc icon-facebook2' => esc_html__( 'Icon facebook2', 'ayvo' ) ),
			array( 'abc icon-gift2' => esc_html__( 'Icon gift2', 'ayvo' ) ),
			array( 'abc icon-headphones2' => esc_html__( 'Icon headphones2', 'ayvo' ) ),
			array( 'abc icon-heart4' => esc_html__( 'Icon heart4', 'ayvo' ) ),
			array( 'abc icon-help-circle' => esc_html__( 'Icon help circle', 'ayvo' ) ),
			array( 'abc icon-home2' => esc_html__( 'Icon home2', 'ayvo' ) ),
			array( 'abc icon-instagram2' => esc_html__( 'Icon instagram2', 'ayvo' ) ),
			array( 'abc icon-life-buoy' => esc_html__( 'Icon life buoy', 'ayvo' ) ),
			array( 'abc icon-linkedin3' => esc_html__( 'Icon linkedin3', 'ayvo' ) ),
			array( 'abc icon-list' => esc_html__( 'Icon list', 'ayvo' ) ),
			array( 'abc icon-lock3' => esc_html__( 'Icon lock3', 'ayvo' ) ),
			array( 'abc icon-mail3' => esc_html__( 'Icon mail3', 'ayvo' ) ),
			array( 'abc icon-map' => esc_html__( 'Icon map', 'ayvo' ) ),
			array( 'abc icon-map-pin' => esc_html__( 'Icon map pin', 'ayvo' ) ),
			array( 'abc icon-menu' => esc_html__( 'Icon menu', 'ayvo' ) ),
			array( 'abc icon-message-circle' => esc_html__( 'Icon message circle', 'ayvo' ) ),
			array( 'abc icon-minus' => esc_html__( 'Icon minus', 'ayvo' ) ),
			array( 'abc icon-minus-circle' => esc_html__( 'Icon minus circle', 'ayvo' ) ),
			array( 'abc icon-monitor3' => esc_html__( 'Icon monitor3', 'ayvo' ) ),
			array( 'abc icon-percent' => esc_html__( 'Icon percent', 'ayvo' ) ),
			array( 'abc icon-phone4' => esc_html__( 'Icon phone4', 'ayvo' ) ),
			array( 'abc icon-phone-call' => esc_html__( 'Icon phone call', 'ayvo' ) ),
			array( 'abc icon-phone-forwarded' => esc_html__( 'Icon phone forwarded', 'ayvo' ) ),
			array( 'abc icon-phone-incoming' => esc_html__( 'Icon phone incoming', 'ayvo' ) ),
			array( 'abc icon-phone-outgoing' => esc_html__( 'Icon phone outgoing', 'ayvo' ) ),
			array( 'abc icon-pie-chart' => esc_html__( 'Icon pie chart', 'ayvo' ) ),
			array( 'abc icon-play-circle' => esc_html__( 'Icon play circle', 'ayvo' ) ),
			array( 'abc icon-plus' => esc_html__( 'Icon plus', 'ayvo' ) ),
			array( 'abc icon-plus-circle' => esc_html__( 'Icon plus circle', 'ayvo' ) ),
			array( 'abc icon-pocket' => esc_html__( 'Icon pocket', 'ayvo' ) ),
			array( 'abc icon-power' => esc_html__( 'Icon power', 'ayvo' ) ),
			array( 'abc icon-printer2' => esc_html__( 'Icon printer2', 'ayvo' ) ),
			array( 'abc icon-refresh-ccw' => esc_html__( 'Icon refresh ccw', 'ayvo' ) ),
			array( 'abc icon-refresh-cw' => esc_html__( 'Icon refresh cw', 'ayvo' ) ),
			array( 'abc icon-repeat2' => esc_html__( 'Icon repeat2', 'ayvo' ) ),
			array( 'abc icon-rotate-ccw' => esc_html__( 'Icon rotate ccw', 'ayvo' ) ),
			array( 'abc icon-rss2' => esc_html__( 'Icon rss2', 'ayvo' ) ),
			array( 'abc icon-search4' => esc_html__( 'Icon search4', 'ayvo' ) ),
			array( 'abc icon-send' => esc_html__( 'Icon send', 'ayvo' ) ),
			array( 'abc icon-settings2' => esc_html__( 'Icon settings2', 'ayvo' ) ),
			array( 'abc icon-shopping-bag' => esc_html__( 'Icon shopping bag', 'ayvo' ) ),
			array( 'abc icon-shopping-cart2' => esc_html__( 'Icon shopping cart2', 'ayvo' ) ),
			array( 'abc icon-speaker' => esc_html__( 'Icon speaker', 'ayvo' ) ),
			array( 'abc icon-star4' => esc_html__( 'Icon star4', 'ayvo' ) ),
			array( 'abc icon-thumbs-up' => esc_html__( 'Icon thumbs up', 'ayvo' ) ),
			array( 'abc icon-trash-2' => esc_html__( 'Icon trash 2', 'ayvo' ) ),
			array( 'abc icon-truck4' => esc_html__( 'Icon truck4', 'ayvo' ) ),
			array( 'abc icon-tv' => esc_html__( 'Icon tv', 'ayvo' ) ),
			array( 'abc icon-twitter3' => esc_html__( 'Icon twitter3', 'ayvo' ) ),
			array( 'abc icon-umbrella' => esc_html__( 'Icon umbrella', 'ayvo' ) ),
			array( 'abc icon-unlock' => esc_html__( 'Icon unlock', 'ayvo' ) ),
			array( 'abc icon-user3' => esc_html__( 'Icon user3', 'ayvo' ) ),
			array( 'abc icon-users' => esc_html__( 'Icon users', 'ayvo' ) ),
			array( 'abc icon-volume-1' => esc_html__( 'Icon volume 1', 'ayvo' ) ),
			array( 'abc icon-watch' => esc_html__( 'Icon watch', 'ayvo' ) ),
			array( 'abc icon-x' => esc_html__( 'Icon x', 'ayvo' ) ),
			array( 'abc icon-x-circle' => esc_html__( 'Icon x circle', 'ayvo' ) ),
			array( 'abc icon-youtube' => esc_html__( 'Icon youtube', 'ayvo' ) ),
			array( 'abc icon-zoom-in' => esc_html__( 'Icon zoom in', 'ayvo' ) ),
			array( 'abc icon-search' => esc_html__( 'Icon search', 'ayvo' ) ),
			array( 'abc icon-envelope-o' => esc_html__( 'Icon envelope o', 'ayvo' ) ),
			array( 'abc icon-heart' => esc_html__( 'Icon heart', 'ayvo' ) ),
			array( 'abc icon-star' => esc_html__( 'Icon star', 'ayvo' ) ),
			array( 'abc icon-star-o' => esc_html__( 'Icon star o', 'ayvo' ) ),
			array( 'abc icon-home' => esc_html__( 'Icon home', 'ayvo' ) ),
			array( 'abc icon-heart-o' => esc_html__( 'Icon heart o', 'ayvo' ) ),
			array( 'abc icon-credit-card2' => esc_html__( 'Icon credit card2', 'ayvo' ) ),
			array( 'abc icon-truck' => esc_html__( 'Icon truck', 'ayvo' ) ),
			array( 'abc icon-envelope' => esc_html__( 'Icon envelope', 'ayvo' ) ),
			array( 'abc icon-desktop' => esc_html__( 'Icon desktop', 'ayvo' ) ),
			array( 'abc icon-paper-plane-o' => esc_html__( 'Icon paper plane o', 'ayvo' ) ),
			array( 'abc icon-send-o' => esc_html__( 'Icon send o', 'ayvo' ) ),
			array( 'abc icon-cc-visa' => esc_html__( 'Icon cc visa', 'ayvo' ) ),
			array( 'abc icon-cc-mastercard' => esc_html__( 'Icon cc mastercard', 'ayvo' ) ),
			array( 'abc icon-cc-discover' => esc_html__( 'Icon cc discover', 'ayvo' ) ),
			array( 'abc icon-cc-amex' => esc_html__( 'Icon cc amex', 'ayvo' ) ),
			array( 'abc icon-cc-paypal' => esc_html__( 'Icon cc paypal', 'ayvo' ) ),
			array( 'abc icon-cc-stripe' => esc_html__( 'Icon cc stripe', 'ayvo' ) ),
			array( 'abc icon-user-circle' => esc_html__( 'Icon user circle', 'ayvo' ) ),
			array( 'abc icon-user-circle-o' => esc_html__( 'Icon user circle o', 'ayvo' ) ),
			array( 'abc icon-user-o' => esc_html__( 'Icon user o', 'ayvo' ) ),
			array( 'abc icon-chevron-down' => esc_html__( 'Icon chevron down', 'ayvo' ) ),
			array( 'abc icon-chevron-left' => esc_html__( 'Icon chevron left', 'ayvo' ) ),
			array( 'abc icon-chevron-right' => esc_html__( 'Icon chevron right', 'ayvo' ) ),
			array( 'abc icon-chevron-thin-down' => esc_html__( 'Icon chevron thin down', 'ayvo' ) ),
			array( 'abc icon-chevron-thin-left' => esc_html__( 'Icon chevron thin left', 'ayvo' ) ),
			array( 'abc icon-chevron-thin-right' => esc_html__( 'Icon chevron thin right', 'ayvo' ) ),
			array( 'abc icon-chevron-thin-up' => esc_html__( 'Icon chevron thin up', 'ayvo' ) ),
			array( 'abc icon-chevron-up' => esc_html__( 'Icon chevron up', 'ayvo' ) ),
			array( 'abc icon-chevron-with-circle-left' => esc_html__( 'Icon chevron with circle left', 'ayvo' ) ),
			array( 'abc icon-chevron-with-circle-right' => esc_html__( 'Icon chevron with circle right', 'ayvo' ) ),
			array( 'abc icon-heart-outlined' => esc_html__( 'Icon heart outlined', 'ayvo' ) ),
			array( 'abc icon-lifebuoy2' => esc_html__( 'Icon lifebuoy2', 'ayvo' ) ),
			array( 'abc icon-list2' => esc_html__( 'Icon list2', 'ayvo' ) ),
			array( 'abc icon-menu2' => esc_html__( 'Icon menu2', 'ayvo' ) ),
			array( 'abc icon-old-mobile' => esc_html__( 'Icon old mobile', 'ayvo' ) ),
			array( 'abc icon-shopping-bag2' => esc_html__( 'Icon shopping bag2', 'ayvo' ) ),
			array( 'abc icon-shopping-basket' => esc_html__( 'Icon shopping basket', 'ayvo' ) ),
			array( 'abc icon-wallet3' => esc_html__( 'Icon wallet3', 'ayvo' ) ),
			array( 'abc icon-google' => esc_html__( 'Icon google', 'ayvo' ) ),
			array( 'abc icon-add-outline' => esc_html__( 'Icon add outline', 'ayvo' ) ),
			array( 'abc icon-arrow-down' => esc_html__( 'Icon arrow down', 'ayvo' ) ),
			array( 'abc icon-arrow-left' => esc_html__( 'Icon arrow left', 'ayvo' ) ),
			array( 'abc icon-arrow-right' => esc_html__( 'Icon arrow right', 'ayvo' ) ),
			array( 'abc icon-arrow-thin-up' => esc_html__( 'Icon arrow thin up', 'ayvo' ) ),
			array( 'abc icon-chart-bar' => esc_html__( 'Icon chart bar', 'ayvo' ) ),
			array( 'abc icon-cog2' => esc_html__( 'Icon cog2', 'ayvo' ) ),
			array( 'abc icon-copy' => esc_html__( 'Icon copy', 'ayvo' ) ),
			array( 'abc icon-credit-card5' => esc_html__( 'Icon credit card5', 'ayvo' ) ),
			array( 'abc icon-envelope4' => esc_html__( 'Icon envelope4', 'ayvo' ) ),
			array( 'abc icon-indent-increase' => esc_html__( 'Icon indent increase', 'ayvo' ) ),
			array( 'abc icon-keyboard' => esc_html__( 'Icon keyboard', 'ayvo' ) ),
			array( 'abc icon-list3' => esc_html__( 'Icon list3', 'ayvo' ) ),
			array( 'abc icon-location-shopping' => esc_html__( 'Icon location shopping', 'ayvo' ) ),
			array( 'abc icon-search5' => esc_html__( 'Icon search5', 'ayvo' ) ),
			array( 'abc icon-shopping-cart3' => esc_html__( 'Icon shopping cart3', 'ayvo' ) ),
			array( 'abc icon-shuffle' => esc_html__( 'Icon shuffle', 'ayvo' ) ),
			array( 'abc icon-tablet2' => esc_html__( 'Icon tablet2', 'ayvo' ) ),
			array( 'abc icon-user-solid-circle' => esc_html__( 'Icon user solid circle', 'ayvo' ) ),
			array( 'abc icon-view-show' => esc_html__( 'Icon view show', 'ayvo' ) ),
			array( 'abc icon-wallet4' => esc_html__( 'Icon wallet4', 'ayvo' ) ),
			array( 'abc icon-watch2' => esc_html__( 'Icon watch2', 'ayvo' ) ),
			array( 'abc icon-write' => esc_html__( 'Icon write', 'ayvo' ) ),
			array( 'abc icon-clock3' => esc_html__( 'Icon clock3', 'ayvo' ) ),
			array( 'abc icon-forward' => esc_html__( 'Icon forward', 'ayvo' ) ),
			array( 'abc icon-search6' => esc_html__( 'Icon search6', 'ayvo' ) ),
			array( 'abc icon-trash' => esc_html__( 'Icon trash', 'ayvo' ) ),
			array( 'abc icon-envelope5' => esc_html__( 'Icon envelope5', 'ayvo' ) ),
			array( 'abc icon-user4' => esc_html__( 'Icon user4', 'ayvo' ) ),
			array( 'abc icon-sound' => esc_html__( 'Icon sound', 'ayvo' ) ),
			array( 'abc icon-camera5' => esc_html__( 'Icon camera5', 'ayvo' ) ),
			array( 'abc icon-image' => esc_html__( 'Icon image', 'ayvo' ) ),
			array( 'abc icon-cog3' => esc_html__( 'Icon cog3', 'ayvo' ) ),
			array( 'abc icon-book2' => esc_html__( 'Icon book2', 'ayvo' ) ),
			array( 'abc icon-map-marker' => esc_html__( 'Icon map marker', 'ayvo' ) ),
			array( 'abc icon-support2' => esc_html__( 'Icon support2', 'ayvo' ) ),
			array( 'abc icon-tag2' => esc_html__( 'Icon tag2', 'ayvo' ) ),
			array( 'abc icon-heart5' => esc_html__( 'Icon heart5', 'ayvo' ) ),
			array( 'abc icon-cart3' => esc_html__( 'Icon cart3', 'ayvo' ) ),
			array( 'abc icon-eye4' => esc_html__( 'Icon eye4', 'ayvo' ) ),
			array( 'abc icon-chart2' => esc_html__( 'Icon chart2', 'ayvo' ) ),
			array( 'abc icon-bookmark' => esc_html__( 'Icon bookmark', 'ayvo' ) ),
			array( 'abc icon-cross' => esc_html__( 'Icon cross', 'ayvo' ) ),
			array( 'abc icon-plus2' => esc_html__( 'Icon plus2', 'ayvo' ) ),
			array( 'abc icon-windows' => esc_html__( 'Icon windows', 'ayvo' ) ),
			array( 'abc icon-switch' => esc_html__( 'Icon switch', 'ayvo' ) ),
			array( 'abc icon-refresh' => esc_html__( 'Icon refresh', 'ayvo' ) ),
			array( 'abc icon-film3' => esc_html__( 'Icon film3', 'ayvo' ) ),
		);

		return $fonts;
	}
}