<?php
/**
 * Name:  Header style 05
 **/
?>
<header id="header" class="header style-5">
	<div class="topbar">
		<div class="container-fluid">
			<div class="toprightnav">
				<?php ayvo_user_link();
				if ( has_nav_menu( 'topbar_menu' ) ) {
				wp_nav_menu( array(
						'menu'            => 'topbar_menu',
						'theme_location'  => 'topbar_menu',
						'depth'           => 3,
						'container'       => '',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => ' topbar-menu left-topbar-menu',
					)
				);}
				?>
			</div>
			<div class="right-top-nav">
			<?php if ( has_nav_menu( 'topbar_menu' ) ) { ?>
				<?php wp_nav_menu( array(
						'menu'            => 'topbar_menu',
						'theme_location'  => 'topbar_menu',
						'depth'           => 3,
						'container'       => '',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => ' topbar-menu',
					)
				);
			} ?>
				<div class="blocklanguage" style="margin:0; padding:0; width:auto; ">
					<ul style="margin:0; padding:0">
						<?php do_action( 'ovic_header_language' ); ?>
					</ul>
					
				</div>
				
				<?php
				do_action( 'ayvo_wishlist');
				do_action( 'ayvo_header_mini_cart' );
			
						?>
			<div class="custom-search-form">
					<?php ayvo_search_form(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="main-header">
		<figure></figure>
		<div class="container-fluid">
			<div class="row">
				<div class=" col-lg-12 col-md-12 col-sm-12">
					<div class="logo">
						<?php Ayvo_Functions::get_logo(); ?>
					</div>
				</div>
				<div class="col-bg-0 col-lg-0 col-md-12 col-sm-12">
					<?php if ( has_nav_menu( 'primary' ) ) { ?>
						<a class="menu-bar menu-toggle menu-mobile" href="#">
							<span class="icon"><i class="abc icon-menu"></i></span>
							
						</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="header-wrap-stick">
		<div class="header-nav">
			<div class="container">
                <div class="row">
					<div class="mainlogo">
						<?php Ayvo_Functions::get_logo(); ?>
					</div>
                    <div class="col-md-12">
				<?php if ( has_nav_menu( 'primary' ) ) { ?>
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
            </div>
			</div>
		</div>
	</div>
	<?php do_action( 'ayvo_header_mobile' ); ?>
</header>