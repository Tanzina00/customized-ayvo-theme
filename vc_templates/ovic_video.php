<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Video"
 */
if ( !class_exists( 'Ovic_Shortcode_Video' ) ) {
	class Ovic_Shortcode_Video extends Ovic_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'video';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_video', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css = '';

			return apply_filters( 'Ovic_Shortcode_Video_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_video', $atts ) : $atts;
			extract( $atts );
			$css_class = array( 'ovic-video' );
			if ( $atts['background'] ) {
				$css_class[] = 'has-bg';
			}
			$css_class[]  = $atts['el_class'];
			$class_editor = isset( $atts['css'] ) ? vc_shortcode_custom_css_class( $atts['css'], ' ' ) : '';
			$css_class[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_video', $atts );
			/* START */
			$html = '';
			$html .= '<div class="video-inner">';
			if ( $atts['background'] ) {
				$html .= '<figure>' . wp_get_attachment_image( $atts['background'], 'full' ) . '</figure>';
			}
			if ( $atts['url'] ) {
				$html .= '<a href="' . esc_url( $atts['url'] ) . '" class="video-button"><span class="abc icon-play-circle"></span></a>';
			}
			$html .= '</div>';
			ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<?php echo wp_specialchars_decode( $html ); ?>
            </div>
			<?php
			$html = ob_get_clean();

			return apply_filters( 'Ovic_Shortcode_Video', $html, $atts, $content );
		}
	}

	new Ovic_Shortcode_Video();
}