<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Shortcode_Call_To_Action"
 */
if ( !class_exists( 'Ovic_Shortcode_Call_To_Action' ) ) {
	class Ovic_Shortcode_Call_To_Action extends Ovic_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'call_to_action';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_call_to_action', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css = '';
			return apply_filters( 'Ovic_Shortcode_Call_To_Action_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_call_to_action', $atts ) : $atts;
			extract( $atts );
			$css_class    = array( 'ovic-call-to-action' );
			$css_class[]  = $atts['style'];
			$class_editor = isset( $atts['css'] ) ? vc_shortcode_custom_css_class( $atts['css'], ' ' ) : '';
			$css_class[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_call_to_action', $atts );
			/* START */
			$galleries = array();
			if ( $atts['gallery'] ) {
				$galleries = explode( ',', $atts['gallery'] );
			}
			$html       = '';
			$button     = '';
			$text_title = '';
			$html .= '<div class="' . esc_attr( implode( ' ', $css_class ) ) . '">';
			if ( !empty( $galleries ) ) {
				$image_thumb = apply_filters( 'ovic_resize_image', $galleries[0], $atts['width'], $atts['height'], true, true );
				$html .= '<div class="action-content"><div class="main-banner">';
				$html .= '<figure>' . wp_specialchars_decode( $image_thumb['img'] ) . '</figure>';
				$html .= '</div>';
			}
			$html .= '<div class="call-to-action-inner">';
			if ( $atts['sub'] ) {
				$html .= '<p class="subtitle">' . esc_html( $atts['sub'] ) . '</p>';
			}
			if ( $atts['title'] ) {
				$text_title .= '<h2 class="title">' . wp_specialchars_decode( $atts['title'] ) . '</h2>';
			}
			if ( $atts['style'] == 'style-1' ) {
				$html .= $text_title;
			}
			if ( $atts['desc'] ) {
				$html .= '<p class="desc">' . wp_specialchars_decode( $atts['desc'] ) . '</p>';
			}
			if ( $atts['button'] ) {
				$link   = vc_build_link( $atts['button'] );
				$target = $link['target'] !== '' ? $link['target'] : '#';
				$button = '<a class="button" href="' . esc_url( $link['url'] ) . '" target="' . $target . '">' . esc_html( $link['title'] ) . '</a>';
			}
			if ( $atts['style'] == 'style-1' ) {
				$html .= $button;
			}
			if ( !empty( $galleries ) ) {
				$data_slick   = array(
					'owl_loop'         => 'false',
					'owl_ts_items'     => 2,
					'owl_xs_items'     => 3,
					'owl_sm_items'     => 3,
					'owl_md_items'     => 3,
					'owl_lg_items'     => 4,
					'owl_ls_items'     => 5,
					'owl_slide_margin' => 10,
				);
				$owl_settings = apply_filters( 'ovic_carousel_data_attributes', 'owl_', $data_slick );
				$html .= '<div class="gallery owl-slick" ' . esc_attr( $owl_settings ) . '>';
				foreach ( $galleries as $key => $gallery ) {
					$class = '';
					if ( $key == 0 )
						$class = 'active';
					$thumb       = wp_get_attachment_image( $gallery, array( 170, 220 ) );
					$image_thumb = apply_filters( 'ovic_resize_image', $gallery, $atts['width'], $atts['height'], true, true );
					$html .= '<a href="' . esc_url( $image_thumb['url'] ) . '" class="' . esc_attr( $class ) . '">' . wp_specialchars_decode( $thumb ) . '</a>';
				}
				$html .= '</div>';
			}
			$html .= '</div></div>';
			if ( $atts['style'] == 'style-2' ) {
				$html .= $button;
			}
			if ( $atts['style'] == 'style-3' ) {
				$html .= $text_title;
				$html .= $button;
			}
			$html .= '</div>';
			return apply_filters( 'Ovic_Shortcode_Call_To_Action', $html, $atts, $content );
		}
	}

	new Ovic_Shortcode_Call_To_Action();
}