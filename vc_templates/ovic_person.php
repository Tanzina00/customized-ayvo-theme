<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Person"
 */
if ( !class_exists( 'Ovic_Shortcode_Person' ) ) {
	class Ovic_Shortcode_Person extends Ovic_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'person';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_person', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css = '';
			return apply_filters( 'Ovic_Shortcode_Person_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_person', $atts ) : $atts;
			extract( $atts );
			$css_class    = array( 'ovic-person' );
			$css_class[]  = $atts['el_class'];
			$css_class[]  = $atts['style'];
			$class_editor = isset( $atts['css'] ) ? vc_shortcode_custom_css_class( $atts['css'], ' ' ) : '';
			$css_class[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_person', $atts );
			$person_link  = vc_build_link( $atts['link'] );
			if ( $person_link['url'] ) {
				$link_url    = $person_link['url'];
				$link_target = $person_link['target'];
			} else {
				$link_target = '_blank';
				$link_url    = '#';
			}
			ob_start();
			if ( $atts['style'] == 'style-1' ) : ?>
				<div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
					<?php if ( $atts['avatar'] ) : ?>
						<div class="thumb-avatar">
							<a href="<?php echo esc_url( $link_url ); ?>"
							   target="<?php echo esc_url( $link_target ); ?>">
								<?php
								$thumb_avatar = apply_filters( 'ovic_resize_image', $atts['avatar'], false, false, true, true );
								echo wp_specialchars_decode( $thumb_avatar['img'] );
								?>
							</a>
						</div>
					<?php endif; ?>
					<div class="content-person">
						<?php if ( $atts['desc'] ) : ?>
							<p class="desc"><?php echo wp_specialchars_decode( $atts['desc'] ); ?></p>
						<?php endif; ?>
						<?php if ( ( $atts['name'] ) || ( $atts['positions'] ) ) : ?>
							<div class="author">
								<?php if ( $atts['name'] ) : ?>
									<span class="name">
										<a href="<?php echo esc_url( $link_url ); ?>"
										   target="<?php echo esc_url( $link_target ); ?>">
											<?php echo esc_html( $atts['name'] ); ?>
										</a>
									</span>
								<?php endif; ?>
								<?php if ( $atts['positions'] ) : ?>
									<span class="line"> - </span>
									<span class="positions"><?php echo esc_html( $atts['positions'] ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php elseif ( $atts['style'] == 'style-2' ) : ?>
				<div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
					<?php if ( $atts['avatar'] ) : ?>
						<div class="thumb-avatar">
							<?php
							$thumb_avatar = apply_filters( 'ovic_resize_image', $atts['avatar'], 450, 615, true, true );
							echo wp_specialchars_decode( $thumb_avatar['img'] );
							?>
							<div class="content-person">
								<div class="author">
									<?php if ( $atts['name'] ) : ?>
										<span class="name">
											<a href="<?php echo esc_url( $link_url ); ?>"
											   target="<?php echo esc_url( $link_target ); ?>">
												<?php echo esc_html( $atts['name'] ); ?>
											</a>
										</span>
									<?php endif; ?>
									<?php if ( $atts['positions'] ) : ?>
										<span class="positions"><?php echo esc_html( $atts['positions'] ); ?></span>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php
			$html = ob_get_clean();
			return apply_filters( 'Ovic_Shortcode_Person', $html, $atts, $content );
		}
	}

	new Ovic_Shortcode_Person();
}