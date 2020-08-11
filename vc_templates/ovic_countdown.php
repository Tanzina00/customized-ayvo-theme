<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Countdown"
 */
if ( !class_exists( 'Ovic_Shortcode_Countdown' ) ) {
	class Ovic_Shortcode_Countdown extends Ovic_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'countdown';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_countdown', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css = '';
			return apply_filters( 'Ovic_Shortcode_Countdown_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_countdown', $atts ) : $atts;
			extract( $atts );
			$css_class    = array( 'ovic-countdown-sc' );
			$css_class[]  = $atts['el_class'];
			$class_editor = isset( $atts['css'] ) ? vc_shortcode_custom_css_class( $atts['css'], ' ' ) : '';
			$css_class[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_countdown', $atts );
			$button_link  = vc_build_link( $atts['button_link'] );
			$button_link  = $button_link['url'] ? $button_link['url'] : '#';
			/* START */
			ob_start(); ?>
			<div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<div class="head">
					<?php if ( $atts['title'] ) : ?>
						<h4 class="title">
							<?php echo esc_html( $atts['title'] ); ?>
						</h4>
					<?php endif; ?>
					<a href="<?php echo esc_url( $button_link ); ?>" class="button">
						<?php if ( $atts['button_text'] ) : ?>
							<span>
								<?php echo esc_html( $atts['button_text'] ); ?>
							</span>
						<?php endif; ?>
					</a>
				</div>
				<div class="ovic-countdown"
					 data-datetime="<?php echo esc_attr( $atts['date'] ); ?>">
				</div>
			</div>
			<?php
			$html = ob_get_clean();
			return apply_filters( 'Ovic_Shortcode_Countdown', $html, $atts, $content );
		}
	}

	new Ovic_Shortcode_Countdown();
}