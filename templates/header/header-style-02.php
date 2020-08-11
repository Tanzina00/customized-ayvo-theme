<?php
/**
 * Name:  Header style 02
 **/
?>
<?php
$data_meta               = get_post_meta( get_the_ID(), '_custom_metabox_theme_options', true );
$enable_theme_option     = isset( $data_meta['metabox_options_enable'] ) ? $data_meta['metabox_options_enable'] : 0;
$header_position_options = Ayvo_Functions::get_option( 'ayvo_header_position', '0' );
$header_position_options = $enable_theme_option == 1 && isset( $data_meta['metabox_ayvo_header_position'] ) ? $data_meta['metabox_ayvo_header_position'] : $header_position_options;
?>
<header id="header" class="header style-2 <?php if ( $header_position_options == 1 ) {
	echo esc_html__( 'header-absolute', 'ayvo' );
} ?>">
	<div class="main-header">
		<div class="header-wrap-stick">
			<div class="theme-container">
				<div class="row">
					<div class="left-main-header col-lg-2 col-md-2 col-sm-3">
						<div class="logo">
							<?php Ayvo_Functions::get_logo(); ?>
						</div>
					</div>
					<div class="right-main-header col-lg-10 col-md-10 col-sm-9">
						<div class="header-nav">
							<?php if ( has_nav_menu( 'primary' ) ) { ?>
								<a class="menu-bar menu-toggle menu-mobile" href="#">
									<span class="icon"><i class="abc icon-menu"></i></span>
									<span class="text"><?php echo esc_html__( 'Menu', 'ayvo' ) ?></span>
								</a>
								<?php wp_nav_menu( array(
										'menu'            => 'primary',
										'theme_location'  => 'primary',
										'depth'           => 3,
										'container'       => '',
										'container_class' => '',
										'container_id'    => '',
										'menu_class'      => 'ayvo-nav clone-main-menu main-menu',
										'mobile_enable'   => true,
									)
								);
							} ?>
						</div>
						<div class="header-options">
							<?php
							ayvo_user_link();
							ayvo_search_form();
							do_action( 'ayvo_header_mini_cart' );
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php do_action( 'ayvo_header_mobile' ); ?>
</header>
