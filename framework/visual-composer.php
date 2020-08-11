<?php
/*==========================================================================
FUNCTIONS
===========================================================================*/
if ( !function_exists( 'ayvo_change_params_shortcode' ) ) {
	function ayvo_change_params_shortcode()
	{
		$param                                       = WPBMap::getParam( 'vc_btn', 'style' );
		$param_blog                                  = WPBMap::getParam( 'ovic_blog', 'blog_style' );
		$param_tabs                                  = WPBMap::getParam( 'ovic_tabs', 'style' );
		$param_iconbox                               = WPBMap::getParam( 'ovic_iconbox', 'style' );
		$param_person                                = WPBMap::getParam( 'ovic_person', 'desc' );
		$param['value'][__( 'Ovic Button', 'ayvo' )] = 'ovic-button';
		$param_tabs['value']                         = array(
			'default' => array(
				'title'   => esc_html__( 'Default', 'ayvo' ),
				'preview' => get_theme_file_uri( '/assets/images/preview/tabs/style1.jpg' ),
			),
		);
		$param_person['dependency']                  = array(
			'element' => "style",
			'value'   => array( 'style-1' ),
		);
		$param_blog['value']                         = array(
			'style-1' => array(
				'title'   => 'Style 01',
				'preview' => get_theme_file_uri( '/templates/blog/blog-style/content-blog-style-1.jpg' ),
			),
			'style-2' => array(
				'title'   => 'Style 02',
				'preview' => get_theme_file_uri( '/templates/blog/blog-style/content-blog-style-2.jpg' ),
			),
			'style-3' => array(
				'title'   => 'Style 03',
				'preview' => get_theme_file_uri( '/templates/blog/blog-style/content-blog-style-3.jpg' ),
			),
		);
		$param_iconbox['value']                      = array(
			'style-1' => array(
				'title'   => esc_html__( 'Style 01', 'ayvo' ),
				'preview' => get_theme_file_uri( '/assets/images/preview/iconbox/style-1.jpg' ),
			),
			'style-2' => array(
				'title'   => esc_html__( 'Style 02', 'ayvo' ),
				'preview' => get_theme_file_uri( '/assets/images/preview/iconbox/style-2.jpg' ),
			),
			'style-3' => array(
				'title'   => esc_html__( 'Style 03', 'ayvo' ),
				'preview' => get_theme_file_uri( '/assets/images/preview/iconbox/style-3.jpg' ),
			),
			'style-4' => array(
				'title'   => esc_html__( 'Style 04', 'ayvo' ),
				'preview' => get_theme_file_uri( '/assets/images/preview/iconbox/style-4.jpg' ),
			),
		);
		vc_update_shortcode_param( 'vc_btn', $param );
		vc_update_shortcode_param( 'ovic_blog', $param_blog );
		vc_update_shortcode_param( 'ovic_tabs', $param_tabs );
		vc_update_shortcode_param( 'ovic_iconbox', $param_iconbox );
		vc_update_shortcode_param( 'ovic_person', $param_person );
	}

	add_action( 'vc_after_init', 'ayvo_change_params_shortcode' );
}
if ( !function_exists( 'ayvo_vc_fonts' ) ) {
	function ayvo_vc_fonts( $fonts_list )
	{
		$Poppins              = new stdClass();
		$Poppins->font_family = 'Poppins';
		$Poppins->font_types  = '300 light :300:normal,300 italic :300:italic,400 regular:400:normal,400 italic :400:italic,500 medium:500:normal,500 italic :500:italic,600 semibold :600:normal,600 italic :600:italic,700 bold :700:normal,700 italic :700:italic';
		$Poppins->font_styles = 'regular';
		$fonts_list[]         = $Poppins;

		return $fonts_list;
	}

	add_filter( 'vc_google_fonts_get_fonts_filter', 'ayvo_vc_fonts' );
}
/*==========================================================================
VISUAL COMPOSER
===========================================================================*/
if ( !function_exists( 'Ayvo_VC_Functions_Param' ) ) {
	function Ayvo_VC_Functions_Param( $param )
	{
		vc_add_params(
			'vc_single_image',
			array(
				array(
					'param_name' => 'image_effect',
					'heading'    => esc_html__( 'Effect', 'ayvo' ),
					'group'      => esc_html__( 'Image Effect', 'ayvo' ),
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'None', 'ayvo' )                      => 'none',
						esc_html__( 'Normal Effect', 'ayvo' )             => 'effect normal-effect',
						esc_html__( 'Normal Effect Dark Color', 'ayvo' )  => 'effect normal-effect dark-bg',
						esc_html__( 'Normal Effect Light Color', 'ayvo' ) => 'effect normal-effect light-bg',
						esc_html__( 'Bounce In', 'ayvo' )                 => 'effect bounce-in',
						esc_html__( 'Plus Zoom', 'ayvo' )                 => 'effect plus-zoom',
						esc_html__( 'Border Zoom', 'ayvo' )               => 'effect border-zoom',
						esc_html__( 'Border ScaleUp', 'ayvo' )            => 'effect border-scale',
					),
					'sdt'        => 'none',
				),
			)
		);
		vc_add_params(
			'vc_row',
			array(
				array(
					'param_name' => 'row_full_page',
					'heading'    => esc_html__( 'Enable Row Full Page', 'ayvo' ),
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Yes', 'ayvo' ) => 'section',
						esc_html__( 'No', 'ayvo' )  => 'no-section',
					),
					'std'        => 'no-section',
				),
			)
		);
		array_unshift( $param['ovic_person']['params'],
			array(
				'type'        => 'select_preview',
				'heading'     => esc_html__( 'Select style', 'ayvo' ),
				'value'       => array(
					'style-1' => array(
						'title'   => esc_html__( 'Style 01', 'ayvo' ),
						'preview' => get_theme_file_uri( '/assets/images/preview/person/style-1.jpg' ),
					),
					'style-2' => array(
						'title'   => esc_html__( 'Style 02', 'ayvo' ),
						'preview' => get_theme_file_uri( '/assets/images/preview/person/style-2.jpg' ),
					),
				),
				'default'     => 'style-1',
				'admin_label' => true,
				'param_name'  => 'style',
			)
		);
		$param['ovic_category']       = array(
			'name'        => esc_html__( 'Ovic: Category', 'ayvo' ),
			'base'        => 'ovic_category',
			'category'    => esc_html__( 'Ovic Shortcode', 'ayvo' ),
			'description' => esc_html__( 'Display a Category.', 'ayvo' ),
			'params'      => array(
				array(
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Select style', 'ayvo' ),
					'value'       => array(
						'style-1' => array(
							'title'   => esc_html__( 'Style 01', 'ayvo' ),
							'preview' => get_theme_file_uri( '/assets/images/preview/category/style-1.jpg' ),
						),
						'style-2' => array(
							'title'   => esc_html__( 'Style 02', 'ayvo' ),
							'preview' => get_theme_file_uri( '/assets/images/preview/category/style-2.jpg' ),
						),
						'style-3' => array(
							'title'   => esc_html__( 'Style 03', 'ayvo' ),
							'preview' => get_theme_file_uri( '/assets/images/preview/category/style-3.jpg' ),
						),
					),
					'default'     => 'style-1',
					'admin_label' => true,
					'param_name'  => 'style',
				),
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__( 'Banner Category', 'ayvo' ),
					'param_name' => 'image',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Button text', 'ayvo' ),
					'param_name'  => 'button_text',
					'description' => esc_html__( 'The text in top of shortcode', 'ayvo' ),
					'dependency'  => array(
						'element' => "style",
						'value'   => array( 'style-2' ),
					),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Button Link', 'ayvo' ),
					'param_name'  => 'cate_link',
					'description' => esc_html__( 'The Link in top of shortcode', 'ayvo' ),
					'dependency'  => array(
						'element' => "style",
						'value'   => array( 'style-2' ),
					),
				),
				array(
					'type'        => 'taxonomy',
					'heading'     => esc_html__( 'Product Category', 'ayvo' ),
					'param_name'  => 'taxonomy',
					'options'     => array(
						'multiple'   => false,
						'hide_empty' => true,
						'taxonomy'   => 'product_cat',
					),
					'dependency'  => array(
						'element' => "style",
						'value'   => array( 'style-1', 'style-3' ),
					),
					'placeholder' => esc_html__( 'Choose category', 'ayvo' ),
					'description' => esc_html__( 'Note: If you want to narrow output, select category(s) above. Only selected categories will be displayed.', 'ayvo' ),
				),
			),
		);
		$param['ovic_video']          = array(
			'base'        => 'ovic_video',
			'name'        => esc_html__( 'Ovic: Video Popup', 'ayvo' ),
			'category'    => esc_html__( 'Ovic Shortcode', 'ayvo' ),
			'description' => esc_html__( 'Display Video Popup', 'ayvo' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Url Video', 'ayvo' ),
					'param_name'  => 'url',
					'admin_label' => true,
				),
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__( 'Background', 'ayvo' ),
					'param_name' => 'background',
				),
			),
		);
		$param['ovic_call_to_action'] = array(
			'base'        => 'ovic_call_to_action',
			'name'        => esc_html__( 'Ovic: Call To Action', 'ayvo' ),
			'category'    => esc_html__( 'Ovic Shortcode', 'ayvo' ),
			'description' => esc_html__( 'Display Call To Action', 'ayvo' ),
			'params'      => array(
				array(
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Select style', 'ayvo' ),
					'value'       => array(
						'style-1' => array(
							'title'   => esc_html__( 'Style 01', 'ayvo' ),
							'preview' => get_theme_file_uri( '/assets/images/preview/actions/style1.jpg' ),
						),
						'style-2' => array(
							'title'   => esc_html__( 'Style 02', 'ayvo' ),
							'preview' => get_theme_file_uri( '/assets/images/preview/actions/style2.jpg' ),
						),
						'style-3' => array(
							'title'   => esc_html__( 'Style 03', 'ayvo' ),
							'preview' => get_theme_file_uri( '/assets/images/preview/actions/style3.jpg' ),
						),
					),
					'default'     => 'style-1',
					'admin_label' => true,
					'param_name'  => 'style',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Sub Title', 'ayvo' ),
					'param_name' => 'sub',
					'dependency' => array(
						'element' => 'style',
						'value'   => 'style-1',
					),
				),
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Title', 'ayvo' ),
					'param_name'  => 'title',
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'style',
						'value'   => array( 'style-1', 'style-3' ),
					),
				),
				array(
					'type'       => 'textarea',
					'heading'    => esc_html__( 'Descriptions', 'ayvo' ),
					'param_name' => 'desc',
					'dependency' => array(
						'element' => 'style',
						'value'   => 'style-1',
					),
				),
				array(
					'type'       => 'vc_link',
					'heading'    => esc_html__( 'Button', 'ayvo' ),
					'param_name' => 'button',
				),
				array(
					'type'       => 'attach_images',
					'heading'    => esc_html__( 'Gallery', 'ayvo' ),
					'param_name' => 'gallery',
				),
				array(
					'type'        => 'number',
					'heading'     => esc_html__( 'Image Width to show', 'ayvo' ),
					'param_name'  => 'width',
					'admin_label' => true,
				), array(
					'type'        => 'number',
					'heading'     => esc_html__( 'Image Height to show', 'ayvo' ),
					'param_name'  => 'height',
					'admin_label' => true,
				),
			),
		);
		$param['ovic_countdown']      = array(
			'base'        => 'ovic_countdown',
			'name'        => esc_html__( 'Ovic: Countdown', 'ayvo' ),
			'category'    => esc_html__( 'Ovic Shortcode', 'ayvo' ),
			'description' => esc_html__( 'Display Countdown', 'ayvo' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'ayvo' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'The title of shortcode', 'ayvo' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Button text', 'ayvo' ),
					'param_name'  => 'button_text',
					'description' => esc_html__( 'The text in top of shortcode', 'ayvo' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Button Link', 'ayvo' ),
					'param_name'  => 'button_link',
					'description' => esc_html__( 'The Link in top of shortcode', 'ayvo' ),
				),
				array(
					'type'       => 'datepicker',
					'heading'    => esc_html__( 'Date', 'ayvo' ),
					'param_name' => 'date',
				),
			),
		);
		$param['ovic_newsletter']     = array(
			'base'        => 'ovic_newsletter',
			'name'        => esc_html__( 'Ovic: Newsletter', 'ayvo' ),
			'icon'        => OVIC_FRAMEWORK_URI . 'assets/images/newsletter.svg',
			'category'    => esc_html__( 'Ovic Shortcode', 'ayvo' ),
			'description' => esc_html__( 'Display Newsletter', 'ayvo' ),
			'params'      => array(
				array(
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Select style', 'ayvo' ),
					'value'       => array(
						'style-1' => array(
							'title'   => esc_html__( 'Style 01', 'ayvo' ),
							'preview' => get_theme_file_uri( 'assets/images/preview/newsletter/style1.jpg' ),
						),
						'style-2' => array(
							'title'   => esc_html__( 'Style 02', 'ayvo' ),
							'preview' => get_theme_file_uri( 'assets/images/preview/newsletter/style2.jpg' ),
						),
						'style-3' => array(
							'title'   => esc_html__( 'Style 03', 'ayvo' ),
							'preview' => get_theme_file_uri( 'assets/images/preview/newsletter/style3.jpg' ),
						),
					),
					'default'     => 'default',
					'admin_label' => true,
					'param_name'  => 'style',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'ayvo' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'The title of shortcode', 'ayvo' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Subtitle', 'ayvo' ),
					'param_name'  => 'subtitle',
					'description' => esc_html__( 'The subtitle of shortcode', 'ayvo' ),
					'admin_label' => true,
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Show Mailchimp List', 'ayvo' ),
					'param_name' => 'show_list',
					'value'      => array(
						esc_html__( 'Yes', 'ayvo' ) => 'yes',
						esc_html__( 'No', 'ayvo' )  => 'no',
					),
					'std'        => 'no',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Show Field Name', 'ayvo' ),
					'param_name' => 'field_name',
					'value'      => array(
						esc_html__( 'Yes', 'ayvo' ) => 'yes',
						esc_html__( 'No', 'ayvo' )  => 'no',
					),
					'std'        => 'no',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'First Name Text', 'ayvo' ),
					'param_name' => 'fname_text',
					'std'        => esc_html__( 'First Name', 'ayvo' ),
					'dependency' => array(
						'element' => 'field_name',
						'value'   => 'yes',
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Last Name Text', 'ayvo' ),
					'param_name' => 'lname_text',
					'std'        => esc_html__( 'Last Name', 'ayvo' ),
					'dependency' => array(
						'element' => 'field_name',
						'value'   => 'yes',
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Placeholder Text', 'ayvo' ),
					'param_name' => 'placeholder',
					'std'        => esc_html__( 'Your email letter', 'ayvo' ),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Button Text', 'ayvo' ),
					'param_name' => 'button_text',
					'std'        => esc_html__( 'Subscribe', 'ayvo' ),
				),
			),
		);
		array_splice( $param['ovic_blog']['params'], 3, 0,
			array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Endable Blog Thumbnail Position', 'ayvo' ),
					'param_name'  => 'position_thumb',
					'admin_label' => true,
					'value'       => array(
						esc_html__( 'Auto', 'ayvo' )  => 'auto',
						esc_html__( 'Left', 'ayvo' )  => 'position_left',
						esc_html__( 'Right', 'ayvo' ) => 'position_right',
					),
					'dependency'  => array(
						'element' => "blog_style",
						'value'   => array( 'style-3' ),
					),
				),
			)
		);
		array_splice( $param['ovic_iconbox']['params'], 3, 0,
			array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon by image', 'ayvo' ),
					'param_name'  => 'enable_icon_image',
					'admin_label' => true,
					'value'       => array(
						esc_html__( 'No', 'ayvo' )  => 'no',
						esc_html__( 'Yes', 'ayvo' ) => 'yes',
					),
					'default'     => 'no',
				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Select image', 'ayvo' ),
					'param_name'  => 'icon_image',
					'admin_label' => true,
					'dependency'  => array(
						'element' => "enable_icon_image",
						'value'   => array( 'yes' ),
					),
				),
				array(
					'type'        => 'number',
					'heading'     => esc_html__( 'Image Width to show', 'ayvo' ),
					'param_name'  => 'width',
					'admin_label' => true,
					'dependency'  => array(
						'element' => "enable_icon_image",
						'value'   => array( 'yes' ),
					),
				),
				array(
					'type'        => 'number',
					'heading'     => esc_html__( 'Image Height to show', 'ayvo' ),
					'param_name'  => 'height',
					'admin_label' => true,
					'dependency'  => array(
						'element' => "enable_icon_image",
						'value'   => array( 'yes' ),
					),
				),
			)
		);
		if ( class_exists( 'WooCommerce' ) ) {
			array_splice( $param['ovic_products']['params'], 1, 0,
				array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Subtitle', 'ayvo' ),
						'param_name'  => 'subtitle',
						'admin_label' => true,
						'dependency'  => array(
							'element' => "box_layout",
							'value'   => array( 'box-layout-1' ),
						),
					),
				)
			);
			array_splice( $param['ovic_products']['params'], 0, 0,
				array(
					array(
						'type'        => 'select_preview',
						'heading'     => esc_html__( 'Select box product layout', 'ayvo' ),
						'value'       => array(
							'box-layout-1' => array(
								'title'   => esc_html__( 'Layout 01', 'ayvo' ),
								'preview' => get_theme_file_uri( '/assets/images/preview/boxproduct/style1.jpg' ),
							),
							'box-layout-2' => array(
								'title'   => esc_html__( 'Layout 02', 'ayvo' ),
								'preview' => get_theme_file_uri( '/assets/images/preview/boxproduct/style2.jpg' ),
							),
						),
						'default'     => 'box-layout-1',
						'admin_label' => true,
						'param_name'  => 'box_layout',
					),
				)
			);
			array_splice( $param['ovic_products']['params'], 5, 0,
				array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Product loadmore', 'ayvo' ),
						'param_name'  => 'loadmore',
						'value'       => array(
							esc_html__( 'Disable', 'ayvo' ) => 'disable',
							esc_html__( 'Enable', 'ayvo' )  => 'enable',
						),
						'group'       => esc_html__( 'Products options', 'ayvo' ),
						'description' => esc_html__( 'Enable or disable loadmore', 'ayvo' ),
						'std'         => 'disable',
					),
				)
			);
		}

		return $param;
	}

	add_filter( 'ovic_add_param_visual_composer', 'Ayvo_VC_Functions_Param' );
}
if ( !function_exists( 'ayvo_template_blog_class' ) ) {
	function ayvo_template_blog_class( $class_item, $atts )
	{
		$class_item[] = $atts['position_thumb'];

		return $class_item;
	}

	add_filter( 'ovic_template_blog_class', 'ayvo_template_blog_class', 10, 2 );
}
add_filter( 'vc_shortcodes_css_class', 'ayvo_change_element_class_name', 10, 3 );
function ayvo_change_element_class_name( $class_string, $tag, $atts )
{
	;
	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $tag, $atts ) : $atts;
	// Extract shortcode parameters.
	extract( $atts );
	if ( strpos( $tag, 'vc_row' ) !== false && isset( $atts['row_full_page'] ) ) {
		$class_string .= ' ' . $atts['row_full_page'] . ' ';
	}

	return $class_string;
}

