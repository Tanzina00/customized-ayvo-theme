<?php
if ( !class_exists( 'Ovic_Shortcode_Iconbox' ) ) {
	class Ovic_Shortcode_Iconbox extends Ovic_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'iconbox';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_iconbox', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css = '';
			return apply_filters( 'Ovic_Shortcode_Iconbox_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_iconbox', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css_class    = array( 'ovic-iconbox' );
			$css_class[]  = isset( $atts['style'] ) ? $atts['style'] : '';
			$css_class[]  = $atts['el_class'];
			$class_editor = isset( $atts['css'] ) ? vc_shortcode_custom_css_class( $atts['css'], ' ' ) : '';
			$css_class[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_iconbox', $atts );
			$icon         = '';
			if ( isset( $atts['type'] ) ) {
				$icon = $atts['icon_' . $atts['type']];
				// Enqueue needed icon font.
				vc_icon_element_fonts_enqueue( $atts['type'] );
			}
			$icon_image        = $atts['icon_image'];
			$enable_icon_image = $atts['enable_icon_image'];
			ob_start();
			$link_icon           = vc_build_link( $atts['link'] );
			$link_icon['target'] = ( $link_icon['target'] ) ? $link_icon['target'] : '_self';
			?>
			<div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<div class="iconbox-inner">
					<?php if ( $enable_icon_image == 'no' ): ?>
						<?php if ( $icon ): ?>
							<?php if ( $link_icon['url'] ) : ?>
								<div class="icon">
									<a href="<?php echo esc_url( $link_icon['url'] ); ?>"
									   target="<?php echo esc_attr( $link_icon['target'] ); ?>">
										<span class="<?php echo esc_attr( $icon ) ?>"></span>
									</a>
								</div>
							<?php else: ?>
								<div class="icon">
									<span class="<?php echo esc_attr( $icon ) ?>"></span>
								</div>
							<?php endif; ?>
						<?php endif; ?>

					<?php elseif ( $icon_image ): ?>
						<?php if ( $link_icon['url'] ) : ?>
							<div class="icon image-icon" style="max-width:<?php echo $atts['width'];?>px;max-height:<?php echo $atts['height'];?>px;">
								<a href="<?php echo esc_url( $link_icon['url'] ); ?>"
								   target="<?php echo esc_attr( $link_icon['target'] ); ?>">
									<?php
									echo wp_get_attachment_image( $atts['icon_image'], 'full' );
									?>
								</a>
							</div>
						<?php else: ?>
							<div class="icon image-icon" style="max-width:<?php echo $atts['width'];?>px;max-height:<?php echo $atts['height'];?>px;">
								<figure>
									<?php
									echo wp_get_attachment_image( $atts['icon_image'], 'full' );
									?>
								</figure>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<div class="content">
						<?php if ( $atts['title'] ):
							if ( $link_icon['url'] ) : ?>
								<h4 class="title">
									<a href="<?php echo esc_url( $link_icon['url'] ); ?>"
									   target="<?php echo esc_attr( $link_icon['target'] ); ?>">
										<?php echo esc_html( $atts['title'] ); ?>
									</a>
								</h4>
							<?php else: ?>
								<h4 class="title"><?php echo esc_html( $atts['title'] ); ?></h4>
							<?php endif;
						endif;
						if ( $atts['text_content'] ): ?>
							<p class="text"><?php echo wp_specialchars_decode( $atts['text_content'] ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
			$html = ob_get_clean();
			return apply_filters( 'Ovic_Shortcode_Iconbox', $html, $atts, $content );
		}
	}

	new Ovic_Shortcode_Iconbox();
}