<?php get_header(); ?>
<?php
/* Get Blog Settings */
$portfolio_list_style   = Ayvo_Functions::get_option( 'ovic_portfolio_list_style', 'masonry' );
$portfolio_layout       = Ayvo_Functions::get_option( 'ovic_sidebar_portfolio_layout', 'full' );
$portfolio_used_sidebar = Ayvo_Functions::get_option( 'ovic_portfolio_used_sidebar', 'widget-area' );
if ( is_single() ) {
	/*Single post layout*/
	$portfolio_layout       = Ayvo_Functions::get_option( 'ovic_sidebar_single_layout', 'full' );
	$portfolio_used_sidebar = Ayvo_Functions::get_option( 'ovic_single_used_sidebar', 'custom-sidebar-portfoliopagesidebar' );
}
if ( !is_active_sidebar( $portfolio_used_sidebar ) ) {
	$portfolio_layout = 'full';
}
/*Main container class*/
$ayvo_main_container_class   = array();
$ayvo_main_container_class[] = 'main-container';
if ( $portfolio_layout == 'full' ) {
	$ayvo_main_container_class[] = 'no-sidebar';
} else {
	$ayvo_main_container_class[] = $portfolio_layout . '-sidebar';
}
$ayvo_main_content_class   = array();
$ayvo_main_content_class[] = 'main-content';
if ( $portfolio_layout == 'full' ) {
	$ayvo_main_content_class[] = 'col-sm-12';
} else {
	if ( is_single() ) {
		$ayvo_main_content_class[] = 'col-lg-8 col-md-8';
	} else {
		$ayvo_main_content_class[] = 'col-lg-9 col-md-9';
	}
}
$ayvo_sidebar_class   = array();
$ayvo_sidebar_class[] = 'sidebar';
if ( $portfolio_layout != 'full' ) {
	if ( is_single() ) {
		$ayvo_sidebar_class[] = 'col-lg-4 col-md-4';
	} else {
		$ayvo_sidebar_class[] = 'col-lg-3 col-md-3';
	}
}
?>
<?php
do_action( 'ovic_breadcrumb' );
do_action( 'ayvo_before_content_wrapper' );
?>
    <div class="<?php echo esc_attr( implode( ' ', $ayvo_main_container_class ) ); ?>">
        <div class="container">
			<?php do_action( 'ayvo_before_content_inner' ); ?>
            <div class="row">
                <div class="<?php echo esc_attr( implode( ' ', $ayvo_main_content_class ) ); ?>">
                    <!-- Main content -->
					<?php if ( !is_single() ) : ?>
						<?php if ( is_search() ) : ?>
							<?php if ( have_posts() ) : ?>
                                <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'ayvo' ), '&quot;<span class="result">' . get_search_query() . '</span>&quot;' ); ?></h1>
							<?php endif; ?>
						<?php elseif ( is_home() ) : ?>
							<?php if ( is_front_page() ) : ?>
                                <h1 class="page-title portfolio-title"><?php esc_html_e( 'Latest Posts', 'ayvo' ); ?></h1>
							<?php endif; ?>
						<?php elseif ( is_page() ) : ?>
                            <h1 class="page-title"><?php single_post_title(); ?></h1>
						<?php else: ?>
                            <h1 class="page-title"><?php the_archive_title( '', '' );; ?></h1>
							<?php
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
							?>
						<?php endif; ?>
					<?php endif; ?>
					<?php
					if ( is_single() ) {
						while ( have_posts() ): the_post();
							get_template_part( 'templates/portfolio/portfolio', 'single' );
							/*If comments are open or we have at least one comment, load up the comment template.*/
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						endwhile;
						wp_reset_postdata();
					} else {
						get_template_part( 'templates/portfolio/portfolio', $portfolio_list_style );
					} ?>
                </div>
				<?php if ( $portfolio_layout != "full" ): ?>
                    <div class="<?php echo esc_attr( implode( ' ', $ayvo_sidebar_class ) ); ?>">
						<?php dynamic_sidebar( $portfolio_used_sidebar ); ?>
                    </div>
				<?php endif; ?>
            </div>
			<?php do_action( 'ayvo_after_content_inner' ); ?>
        </div>
    </div>
<?php do_action( 'ayvo_after_content_wrapper' ); ?>
<?php get_footer(); ?>