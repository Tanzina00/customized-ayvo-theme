<?php
/**
 * Name:  Header style 01 extend
 **/
?>
<header id="header" class="header style-1 header-innerpage">
	<div class="main-header">
		<div class="header-wrap-stick">
			<div class="theme-container ">
				<div class="left-main-header">
					<?php
					$header_message = Ayvo_Functions::get_option( 'ovic_header_message' );
					if ( !empty( $header_message ) ): ?>
						<div class="header-message">
						<span class="message-item">
                            <?php if ( $header_message['header_message_icon'] != "" ): ?>
								<span class="icon">
                                    <span
										class="<?php echo esc_attr( $header_message['header_message_icon'] ); ?>"></span>
                                </span>
							<?php endif; ?>
							<?php if ( $header_message['header_message_text'] != "" ): ?>
								<span
									class="text"><?php echo wp_specialchars_decode( $header_message['header_message_text'] ); ?></span>
							<?php endif; ?>
                        </span>
						</div>
					<?php endif; ?>
					<a class="menu-bar menu-toggle menu-mobile" href="#">
						<span class="icon"><i class="abc icon-menu"></i></span>
						<span class="text"><?php echo esc_html__( 'Menu', 'ayvo' ) ?></span>
					</a>
				</div>
				<div class="middle-main-header header-nav">
					<?php if ( has_nav_menu( 'left-primary-2' ) ) { ?>
						<?php wp_nav_menu( array(
								'menu'            => 'left-primary-2',
								'theme_location'  => 'left-primary-2',
								'depth'           => 3,
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'ayvo-nav clone-main-menu main-menu left',
								'mobile_enable'   => true,
							)
						);
					}
					?>
					<div class="logo">
						<?php Ayvo_Functions::get_logo(); ?>
					</div>
					<?php if ( has_nav_menu( 'right-primary-2' ) ) { ?>
						<?php wp_nav_menu( array(
								'menu'            => 'right-primary-2',
								'theme_location'  => 'right-primary-2',
								'depth'           => 3,
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'ayvo-nav clone-main-menu main-menu right',
								'mobile_enable'   => true,
							)
						);
					}
					?>
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
	<?php do_action( 'ovic_breadcrumb' ); ?>
</header>

