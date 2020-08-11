<?php
/**
 * Name:  Header style 04
 **/
?>
<header id="header" class="header style-1 style-4">
	<div class="main-header">
		<div class="header-wrap-stick">
			<div class="theme-container ">
				<div class="left-main-header">
					<div class="ovic-dropdown header-nav">
						<?php if ( has_nav_menu( 'primary' ) ) { ?>
						<a class="menu-bar open-menu menu-mobile" href="#" data-ovic="ovic-dropdown">
							<span class="icon"><i class="abc icon-menu"></i></span>
							<span class="text"><?php echo esc_html__( 'Menu', 'ayvo' ) ?></span>
						</a>
						<a class="menu-bar menu-toggle menu-mobile" href="#">
							<span class="icon"><i class="abc icon-menu"></i></span>
							<span class="text"><?php echo esc_html__( 'Menu', 'ayvo' ) ?></span>
						</a>
						<div class="menu-content">
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
							); ?>
							<a href="#" class="close-menu"><span class="abc icon-x"></span></a>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="middle-main-header">
					<div class="logo">
						<?php Ayvo_Functions::get_logo(); ?>
					</div>
				</div>
				<div class="right-main-header">
					<?php
					ayvo_user_link();
					ayvo_search_form();
					do_action( 'ayvo_header_mini_cart' );
					?>
				</div>
			</div>
		</div>
	</div>
	<?php do_action( 'ayvo_header_mobile' ); ?>
</header>
