<?php get_header(); ?>
<?php
/* Get Blog Settings */
$ayvo_single_style      = '';
$ayvo_blog_list_style   = Ayvo_Functions::get_option( 'ovic_blog_list_style', 'default' );
$ayvo_blog_layout       = Ayvo_Functions::get_option( 'ovic_sidebar_blog_layout', 'left' );
$ayvo_blog_used_sidebar = Ayvo_Functions::get_option( 'ovic_blog_used_sidebar', 'widget-area' );
$container              = Ayvo_Functions::get_option( 'enable_blog_theme_container' );
if ( is_single() ) {
	/*Single post layout*/
	$ayvo_blog_layout       = Ayvo_Functions::get_option( 'ovic_sidebar_single_layout', 'left' );
	$ayvo_blog_used_sidebar = Ayvo_Functions::get_option( 'ovic_single_used_sidebar', '' );
	$ayvo_single_style      = Ayvo_Functions::get_option( 'ovic_single_blog_style', 'classic' );
}
if ( !is_active_sidebar( $ayvo_blog_used_sidebar ) ) {
	$ayvo_blog_layout = 'full';
}
/*Main container class*/
$ayvo_main_container_class   = array();
$ayvo_main_container_class[] = 'main-container';
$ayvo_main_container_class[] = $ayvo_single_style;
if ( $ayvo_blog_layout == 'full' ) {
	$ayvo_main_container_class[] = 'no-sidebar';
} else {
	$ayvo_main_container_class[] = $ayvo_blog_layout . '-sidebar';
}
$ayvo_main_content_class   = array();
$ayvo_main_content_class[] = 'main-content';
if ( $ayvo_blog_layout == 'full' ) {
	$ayvo_main_content_class[] = 'col-sm-12';
} else {
	if ( is_single() ) {
		$ayvo_main_content_class[] = 'col-lg-9 col-md-9';
	} else {
		$ayvo_main_content_class[] = 'col-lg-9 col-md-9';
	}
}
$ayvo_sidebar_class   = array();
$ayvo_sidebar_class[] = 'sidebar';
if ( $ayvo_blog_layout != 'full' ) {
	if ( is_single() ) {
		$ayvo_sidebar_class[] = 'col-lg-3 col-md-3';
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
<?php if ( $container == 1 ) { ?>
    <div class="theme-container">
	<?php } else { ?>
    <div class="container">
<?php }; ?>
<?php do_action( 'ayvo_before_content_inner' ); ?>
<?php if ( is_home() ) : ?>
    <h1 class="page-title blog-title"><?php esc_html_e( 'The Blog', 'ayvo' ); ?></h1>
<?php elseif ( is_search() ) : ?>
	<?php if ( have_posts() ) : ?>
        <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'ayvo' ), '&quot;<span class="result">' . get_search_query() . '</span>&quot;' ); ?></h1>
	<?php endif; ?>
<?php elseif ( is_page() || is_single() ) : ?>
    <h1 class="page-title"><?php single_post_title(); ?></h1>
<?php else: ?>
    <h1 class="page-title"><?php the_archive_title( '', '' ); ?></h1>
	<?php
	the_archive_description( '<div class="taxonomy-description">', '</div>' );
	?>
<?php endif; ?>
    <div class="row">

        <div class="<?php echo esc_attr( implode( ' ', $ayvo_main_content_class ) ); ?>">
            <!-- Main content -->

			<?php
			if ( is_single() ) {
				while ( have_posts() ): the_post();
					get_template_part( 'templates/blog/blog', 'single' );
					/*If comments are open or we have at least one comment, load up the comment template.*/
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile;
			} else {
				get_template_part( 'templates/blog/blog', $ayvo_blog_list_style );
			} ?>
        </div>
		<?php if ( $ayvo_blog_layout != "full" ): ?>
            <div class="<?php echo esc_attr( implode( ' ', $ayvo_sidebar_class ) ); ?>">
				<?php get_sidebar(); ?>
            </div>
		<?php endif; ?>
    </div>
<?php do_action( 'ayvo_after_content_inner' ); ?>
    </div>
    </div>
<?php do_action( 'ayvo_after_content_wrapper' ); ?>
<?php get_footer(); ?>