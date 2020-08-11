<?php get_header(); ?>
<?php
/*Default  page layout*/
$ayvo_page_layout       = Ayvo_Functions::get_post_meta( get_the_ID(), 'ovic_page_layout', 'left' );
$ayvo_page_used_sidebar = Ayvo_Functions::get_post_meta( get_the_ID(), 'ovic_page_used_sidebar', 'widget-area' );
$ayvo_meta              = Ayvo_Functions::get_post_meta( get_the_ID(), '_custom_metabox_theme_options', array() );
if ( !is_active_sidebar( $ayvo_page_used_sidebar ) ) {
	$ayvo_page_layout = 'full';
}
/*Main container class*/
$ayvo_main_container_class   = array();
$ayvo_main_container_class[] = 'main-container';
if ( $ayvo_page_layout == 'full' ) {
	$ayvo_main_container_class[] = 'no-sidebar';
} else {
	$ayvo_main_container_class[] = $ayvo_page_layout . '-sidebar';
}
$ayvo_main_content_class   = array();
$ayvo_main_content_class[] = 'main-content';
if ( $ayvo_page_layout == 'full' ) {
	$ayvo_main_content_class[] = 'col-sm-12';
} else {
	$ayvo_main_content_class[] = 'col-lg-9 col-md-9';
}
$ayvo_sidebar_class   = array();
$ayvo_sidebar_class[] = 'sidebar';
if ( $ayvo_page_layout != 'full' ) {
	$ayvo_sidebar_class[] = 'col-lg-3 col-md-3';
}
$disable_title = 0;
if ( isset( $ayvo_meta['metabox_disable_title'] ) && $ayvo_meta['metabox_disable_title'] == 1 ) {
	$disable_title = 1;
}
?>
<?php if ( isset( $ayvo_meta['page_banner'] ) && $ayvo_meta['page_banner'] != '' ): ?>
    <div class="page-banner"
         style="background-image:url(<?php echo wp_get_attachment_image_url( $ayvo_meta['page_banner'], 'full' ); ?>);">
        <div class="page-banner-content">
            <h1 class="page-title">
				<?php single_post_title(); ?>
            </h1>
			<?php do_action( 'ovic_breadcrumb' ); ?>
        </div>
    </div>
<?php else: ?>
	<?php do_action( 'ovic_breadcrumb' ); ?>
	<?php if ( $disable_title == 0 ): ?>
        <h1 class="page-title">
			<?php single_post_title(); ?>
        </h1>
	<?php endif; ?>
<?php endif; ?>
<?php do_action( 'ayvo_before_content_wrapper' ); ?>
    <main class="site-main <?php echo esc_attr( implode( ' ', $ayvo_main_container_class ) ); ?>">
        <div class="container">
			<?php do_action( 'ayvo_before_content_inner' ); ?>
            <div class="row">
                <div class="<?php echo esc_attr( implode( ' ', $ayvo_main_content_class ) ); ?>">
					<?php
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							?>
                            <div class="page-main-content">
								<?php
								the_content();
								wp_link_pages(
									array(
										'before' => '<div class="page-links">' . __( 'Pages:', 'ayvo' ),
										'after'  => '</div>',
									)
								);
								?>
                            </div>
							<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
							?>
							<?php
						}
					}
					?>
                </div>
				<?php if ( $ayvo_page_layout != "full" ): ?>
                    <div class="<?php echo esc_attr( implode( ' ', $ayvo_sidebar_class ) ); ?>">
						<?php get_sidebar( 'page' ); ?>
                    </div>
				<?php endif; ?>
            </div>
			<?php do_action( 'ayvo_after_content_inner' ); ?>
        </div>
    </main>
<?php do_action( 'ayvo_after_content_wrapper' ); ?>
<?php get_footer(); ?>