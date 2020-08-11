<?php
$html         = '';
$enable_share = Ayvo_Functions::get_option( 'ovic_portfolio_share_button' );
$meta         = get_post_meta( get_the_ID(), '_metabox_portfolio_options', true );
$galleries    = isset( $meta['portfolio_gallery'] ) ? explode( ',', $meta['portfolio_gallery'] ) : array();
if ( !empty( $galleries ) && $galleries[0] != '' ) {
	$class           = 'owl-slick';
	$data_slick      = array(
		'slidesToShow'  => 2,
		'centerMode'    => true,
		'infinite'      => true,
		'variableWidth' => true,
		'centerPadding' => '530px',
	);
	$data_responsive = array(
		array(
			'breakpoint' => 1199,
			'settings'   => array(
				'slidesMargin'  => 20,
				'variableWidth' => false,
				'centerPadding' => '30px',
			),
		),
		array(
			'breakpoint' => 991,
			'settings'   => array(
				'slidesToShow'  => 1,
				'slidesMargin'  => 0,
				'centerMode'    => false,
				'variableWidth' => false,
			),
		),
	);
	$html            .= '<div class="gallery-item">' . wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), array( '770', '770' ) ) . '</div>';
	foreach ( $galleries as $gallery ) {
		$html .= '<div class="gallery-item">' . wp_get_attachment_image( $gallery, array( '770', '770' ) ) . '</div>';
	}
} else {
	$data_slick      = array();
	$data_responsive = array();
	$class           = 'thumb-portfolio';
	$html            .= '<div class="gallery-item">' . wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'full' ) . '</div>';
}
?>
    <div class="portfolio-single blog-single">
        <div <?php post_class( 'post-item single-post' ); ?>>
            <h4 class="post-title"><?php the_title(); ?></h4>
            <div class="post-thumb">
                <div class="<?php echo esc_attr( $class ); ?>"
                     data-slick="<?php echo esc_attr( json_encode( $data_slick ) ); ?>"
                     data-responsive="<?php echo esc_attr( json_encode( $data_responsive ) ); ?>">
					<?php echo wp_specialchars_decode( $html ); ?>
                </div>
            </div>
            <div class="post-info">
				<?php
				ayvo_post_single_content();
				?>
                <div class="group-bottom">
					<?php
					ayvo_share_post( $enable_share );
					?>
                </div>
            </div>
        </div>
    </div>
<?php
get_template_part( 'templates/blog/blog', 'related' );