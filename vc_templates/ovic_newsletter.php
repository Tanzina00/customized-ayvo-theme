<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Newsletter"
 * @version 1.0.0
 */
if ( !class_exists( 'Ovic_Shortcode_Newsletter' ) ) {
	class Ovic_Shortcode_Newsletter extends Ovic_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'newsletter';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_newsletter', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css = '';
			return apply_filters( 'Ovic_Shortcode_Newsletter_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_newsletter', $atts ) : $atts;
			extract( $atts );
			$css_class    = array( 'widget-ovic-mailchimp ovic-newsletter' );
			$css_class[]  = $atts['el_class'];
			$css_class[]  = isset( $atts['style'] ) ? $atts['style'] : '';
			$class_editor = isset( $atts['css'] ) ? vc_shortcode_custom_css_class( $atts['css'], ' ' ) : '';
			$css_class[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_newsletter', $atts );
			$shortcode    = '';
			$default      = array(
				'title'       => $atts['title'],
				'subtitle'    => $atts['subtitle'],
				'show_list'   => $atts['show_list'],
				'field_name'  => $atts['field_name'],
				'fname_text'  => $atts['fname_text'],
				'lname_text'  => $atts['lname_text'],
				'placeholder' => $atts['placeholder'],
				'button_text' => $atts['button_text'],
			);
			foreach ( $default as $key => $value ) {
				$shortcode .= ' ' . $key . '="' . $value . '" ';
			}
			ob_start(); ?>
			<div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<?php if ( ( $atts['title'] ) || ( $atts['subtitle'] ) ) : ?>
					<div class="head">
						<?php if ( $atts['title'] ) : ?>
							<h4 class="title">
								<?php echo esc_html( $atts['title'] ); ?>
							</h4>
						<?php endif; ?>
						<?php if ( $atts['subtitle'] ) : ?>
							<h5 class="subtitle">
								<?php echo esc_html( $atts['subtitle'] ); ?>
							</h5>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php echo do_shortcode( '[ovic_mailchimp' . $shortcode . ']' ); ?>
			</div>
			<?php
			$html = ob_get_clean();
			return apply_filters( 'Ovic_Shortcode_Newsletter', $html, $atts, $content );
		}
	}

	new Ovic_Shortcode_Newsletter();
}