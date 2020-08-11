<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Category"
 */
if ( !class_exists( 'Ovic_Shortcode_Category' ) ) {
	class Ovic_Shortcode_Category extends Ovic_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'category';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_category', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			if ( $atts['bg_content_color'] != "" ):
				$css = '.ovic-category.' . $atts['ovic_custom_id'] . ' .category-content {
			    background-color: ' . $atts['bg_content_color'] . '
			}';
			endif;

			return apply_filters( 'Ovic_Shortcode_Category_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_category', $atts ) : $atts;
			extract( $atts );
			$css_class    = array( 'ovic-category' );
			$css_class[]  = $atts['el_class'];
			$css_class[]  = $atts['style'];
			$class_editor = isset( $atts['css'] ) ? vc_shortcode_custom_css_class( $atts['css'], ' ' ) : '';
			$css_class[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_category', $atts );
			ob_start();
			if ( $atts['style'] !== 'style-2' ) : ?>
                <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
                    <div class="category-thumb">
						<?php if ( $atts['image'] ) : ?>
							<?php
							$width  = 640;
							$height = 640;
							if ( $atts['style'] == 'style-3' ) {
								$width  = 313;
								$height = 313;
							}
							?>
                            <div class="image">
								<?php
								$image_thumb = apply_filters( 'ovic_resize_image', $atts['image'], $width, $height, true, true );
								echo wp_specialchars_decode( $image_thumb['img'] );
								?>
                            </div>
						<?php endif; ?>
						<?php $categories = explode( ',', $atts['taxonomy'] ); ?>
						<?php foreach ( $categories as $category ) :
							$term = get_term_by( 'slug', $category, 'product_cat' );
							if ( !empty( $term ) && !is_wp_error( $term ) ) :
								$term_link = get_term_link( $term->term_id, 'product_cat' );
								?>
                                <a class="cate-filter" href="<?php echo esc_url( $term_link ); ?>">
								<span><?php echo esc_html( $term->name ); ?>
                                    <span class="count"><?php echo esc_html( '(' . ( $term->count ) . ')' ); ?></span>
								</span>
                                </a>
							<?php endif;
						endforeach; ?>
                    </div>
                </div>
			<?php else : ?>
                <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
                    <div class="category-thumb">
						<?php if ( $atts['image'] ) : ?>
                            <div class="image">
								<?php
								$image_thumb = apply_filters( 'ovic_resize_image', $atts['image'], 640, 640, true, true );
								echo wp_specialchars_decode( $image_thumb['img'] );
								?>
                            </div>
						<?php endif; ?>
                        <div class="category-content">
                            <a href="<?php echo esc_url( $atts['cate_link'] ); ?>" class="button-category button">
								<?php if ( $atts['button_text'] ) : ?>
                                    <span>
									<?php echo esc_html( $atts['button_text'] ); ?>
								</span>
								<?php endif; ?>
                            </a>
                        </div>
                    </div>
                </div>
			<?php endif; ?>
			<?php
			wp_reset_postdata();
			$html = ob_get_clean();

			return apply_filters( 'Ovic_Shortcode_Category', $html, $atts, $content );
		}
	}

	new Ovic_Shortcode_Category();
}