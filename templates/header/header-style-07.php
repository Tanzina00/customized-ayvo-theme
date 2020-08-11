<?php
/**
 * Name:  Header style 07
 **/
?>
<header id="header" class="header style-6 style-7">
    <div class="main-header ovic-dropdown open">
        <div class="header-wrap-stick">
            <div class="theme-container ">
                <div class="header-main-content">
                    <div class="logo">
						<?php Ayvo_Functions::get_logo(); ?>
                    </div>
                    <div class="header-nav">
						<?php if ( has_nav_menu( 'primary' ) ) { ?>
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
                        </div>
						<?php } ?>
                    </div>
                    <div class="right-main-header">
						<?php
						ayvo_user_link();
						ayvo_search_form();
						do_action( 'ayvo_header_mini_cart' );
						?>
						<?php if ( has_nav_menu( 'primary' ) ) { ?>
                        <a class="open-menu menu-bar" href="#" data-ovic="ovic-dropdown"></a>
                        <a class="menu-bar menu-toggle menu-mobile" href="#"></a>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php do_action( 'ayvo_header_mobile' ); ?>
</header>
