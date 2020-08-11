<?php
/*==========================================================================
FUNCTIONS
===========================================================================*/
// GET HEADER
if ( !function_exists( 'get_header_options' ) ) {
	function get_header_options()
	{
		$layoutDir      = get_template_directory() . '/templates/header/';
		$header_options = array();
		if ( is_dir( $layoutDir ) ) {
			$files = scandir( $layoutDir );
			if ( $files && is_array( $files ) ) {
				foreach ( $files as $file ) {
					if ( $file != '.' && $file != '..' ) {
						$fileInfo = pathinfo( $file );
						if ( $fileInfo['extension'] == 'php' && $fileInfo['basename'] != 'index.php' ) {
							$file_data                  = get_file_data( $layoutDir . $file, array( 'Name' => 'Name' ) );
							$file_name                  = str_replace( 'header-', '', $fileInfo['filename'] );
							$header_options[$file_name] = array(
								'title'   => $file_data['Name'],
								'preview' => get_theme_file_uri( '/templates/header/header-' . $file_name . '.jpg' ),
							);
						}
					}
				}
			}
		}

		return $header_options;
	}
}
/*==========================================================================
THEME OPTIONS
===========================================================================*/
if ( !function_exists( 'ayvo_customizer_options' ) ) {
	add_filter( 'ovic_config_customize_sections_v2', 'ayvo_customizer_options' );
	function ayvo_customizer_options( $sections )
	{
		// GENERAL
		$sections['general_main']['sections']['general']['fields'][] = array(
			'id'    => 'enable_back_to_top',
			'type'  => 'switcher',
			'title' => esc_html__( 'Enable Back To Top Button', 'ayvo' ),
		);
		// HEADER
		$sections['header_main']['sections']['header']['fields']['ayvo_used_header']     = array(
			'id'      => 'ayvo_used_header',
			'type'    => 'select_preview',
			'title'   => esc_html__( 'Header Layout', 'ayvo' ),
			'desc'    => esc_html__( 'Select a header layout', 'ayvo' ),
			'options' => get_header_options(),
			'default' => 'style-06',
		);
		$sections['header_main']['sections']['header']['fields']['ayvo_header_position'] = array(
			'id'         => 'ayvo_header_position',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Enable Header position absolute', 'ayvo' ),
			'dependency' => array( 'ayvo_used_header', 'any', 'style-02,style-03' ),
		);
		$sections['header_main']['sections']['header']['fields']['ovic_header_message']  = array(
			'id'         => 'ovic_header_message',
			'type'       => 'fieldset',
			'title'      => esc_html__( 'Group message', 'ayvo' ),
			'fields'     => array(
				array(
					'id'    => 'header_message_icon',
					'type'  => 'icon',
					'title' => esc_html__( 'Select icon', 'ayvo' ),
				),
				array(
					'id'    => 'header_message_text',
					'type'  => 'textarea',
					'title' => esc_html__( 'Enter text here', 'ayvo' ),
				),
			),
			'dependency' => array( 'ayvo_used_header', 'any', 'style-01,style-01-extend' ),
		);
		$sections['header_main']['sections']['header']['fields']['ovic_header_message2'] = array(
			'id'         => 'ovic_header_message2',
			'type'       => 'fieldset',
			'title'      => esc_html__( 'Group message', 'ayvo' ),
			'fields'     => array(
				array(
					'id'    => 'header_message_icon',
					'type'  => 'icon',
					'title' => esc_html__( 'Select icon', 'ayvo' ),
				),
				array(
					'id'    => 'header_message_text',
					'type'  => 'textarea',
					'title' => esc_html__( 'Enter text here', 'ayvo' ),
				),
			),
			'dependency' => array( 'ayvo_used_header', 'any', 'style-05' ),
		);
		array_unshift( $sections['blog_main']['sections']['blog']['fields'],
			array(
				'id'    => 'enable_blog_theme_container',
				'type'  => 'switcher',
				'title' => esc_html__( 'Enable "Theme container" in blog page', 'ayvo' ),
				'desc'  => esc_html__( '(max-width = 1800px)', 'ayvo' ),
			),
			array(
				'id'      => 'ovic_blog_pagination',
				'type'    => 'select',
				'title'   => esc_html__( 'Pagination', 'ayvo' ),
				'options' => array(
					'default'  => esc_html__( 'Default', 'ayvo' ),
					'loadmore' => esc_html__( 'Load More', 'ayvo' ),
				),
				'default' => 'default',
			)
		);
		$sections['blog_main']['sections']['blog']['fields']['ovic_blog_list_style'] = array(
			'id'      => 'ovic_blog_list_style',
			'type'    => 'select',
			'title'   => esc_html__( 'Blog Style', 'ayvo' ),
			'options' => array(
				'default'  => esc_html__( 'Default', 'ayvo' ),
				'standard' => esc_html__( 'Standard', 'ayvo' ),
				'masonry'  => esc_html__( 'Masonry', 'ayvo' ),
			),
			'default' => 'default',
		);
		$sections['blog_main']['sections']['portfolio']                              = array(
			'name'   => 'portfolio',
			'title'  => esc_html__( 'Portfolio', 'ayvo' ),
			'fields' => array(
				array(
					'id'    => 'ovic_portfolio_share_button',
					'type'  => 'switcher',
					'title' => esc_html__( 'Enable Share button', 'ayvo' ),
				),
				'ovic_portfolio_pagination'     => array(
					'id'      => 'ovic_portfolio_pagination',
					'type'    => 'select',
					'title'   => esc_html__( 'Pagination', 'ayvo' ),
					'options' => array(
						'default'  => esc_html__( 'Default', 'ayvo' ),
						'loadmore' => esc_html__( 'Load More', 'ayvo' ),
					),
					'default' => 'default',
				),
				'portfolio_items'               => array(
					'id'         => 'portfolio_items',
					'type'       => 'slider',
					'title'      => esc_html__( 'Column', 'ayvo' ),
					'options'    => array(
						'min'  => 2,
						'max'  => 6,
						'step' => 1,
						'unit' => esc_html__( 'item(s)', 'ayvo' ),
					),
					'default'    => '3',
					'dependency' => array( 'ovic_portfolio_list_style', '==', 'grid' ),
				),
				'ovic_portfolio_list_style'     => array(
					'id'      => 'ovic_portfolio_list_style',
					'type'    => 'select',
					'title'   => esc_html__( 'Portfolio Style', 'ayvo' ),
					'options' => array(
						'masonry' => esc_html__( 'Masonry', 'ayvo' ),
						'grid'    => esc_html__( 'Grid', 'ayvo' ),
					),
					'default' => 'masonry',
				),
				'ovic_sidebar_portfolio_layout' => array(
					'id'      => 'ovic_sidebar_portfolio_layout',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Sidebar Portfolio Layout', 'ayvo' ),
					'desc'    => esc_html__( 'Select sidebar position on Portfolio.', 'ayvo' ),
					'options' => array(
						'left'  => esc_attr( ' data:image/png;base64,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' ),
						'right' => esc_attr( ' data:image/png;base64,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' ),
						'full'  => esc_attr( ' data:image/png;base64,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' ),
					),
					'default' => 'left',
				),
				'ovic_portfolio_used_sidebar'   => array(
					'id'         => 'ovic_portfolio_used_sidebar',
					'type'       => 'select',
					'default'    => 'widget-area',
					'title'      => esc_html__( 'Portfolio Sidebar', 'ayvo' ),
					'options'    => apply_filters( 'ovic_sidebar_options', 10, 1 ),
					'dependency' => array( 'ovic_sidebar_portfolio_layout_full', '==', false ),
				),
				array(
					'id'         => 'ayvo_portfolio_cat',
					'type'       => 'select',
					'title'      => esc_html__( 'Portfolio Filter By Category', 'ayvo' ),
					'options'    => 'categories',
					'query_args' => array(
						'type'     => 'portfolio',
						'taxonomy' => 'portfolio_category',
						'orderby'  => 'post_date',
						'order'    => 'DESC',
					),
					'attributes' => array(
						'multiple' => 'multiple',
					),
					'class'      => 'chosen',
					'default'    => '',
					'dependency' => array( 'ovic_portfolio_list_style', '==', 'grid' ),
				),
			),
		);
		/* RELATED SINGLE POST */
		$sections['blog_main']['sections']['blog_realated'] = array(
			'name'   => 'blog_realated',
			'title'  => esc_html__( 'Blog Related', 'ayvo' ),
			'fields' => array(
				'ovic_enable_related_post'   => array(
					'id'    => 'ovic_enable_related_post',
					'type'  => 'switcher',
					'title' => esc_html__( 'Enable Related Blog', 'ayvo' ),
				),
				'ovic_related_post_per_page' => array(
					'id'         => 'ovic_related_post_per_page',
					'type'       => 'number',
					'title'      => esc_html__( 'Number Related Post', 'ayvo' ),
					'default'    => '6',
					'dependency' => array( 'ovic_enable_related_post', '==', true ),
				),
				'ovic_related_post_ls_items' => array(
					'id'         => 'ovic_related_post_ls_items',
					'type'       => 'select',
					'title'      => esc_html__( 'Related items per row on Desktop', 'ayvo' ),
					'desc'       => esc_html__( '(Screen resolution of device >= 1500px )', 'ayvo' ),
					'options'    => array(
						'1' => esc_html__( '1 item', 'ayvo' ),
						'2' => esc_html__( '2 items', 'ayvo' ),
						'3' => esc_html__( '3 items', 'ayvo' ),
						'4' => esc_html__( '4 items', 'ayvo' ),
						'5' => esc_html__( '5 items', 'ayvo' ),
						'6' => esc_html__( '6 items', 'ayvo' ),
					),
					'default'    => '4',
					'dependency' => array( 'ovic_enable_related_post', '==', true ),
				),
				'ovic_related_post_lg_items' => array(
					'id'         => 'ovic_related_post_lg_items',
					'type'       => 'select',
					'title'      => esc_html__( 'Related items per row on Desktop', 'ayvo' ),
					'desc'       => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'ayvo' ),
					'options'    => array(
						'1' => esc_html__( '1 item', 'ayvo' ),
						'2' => esc_html__( '2 items', 'ayvo' ),
						'3' => esc_html__( '3 items', 'ayvo' ),
						'4' => esc_html__( '4 items', 'ayvo' ),
						'5' => esc_html__( '5 items', 'ayvo' ),
						'6' => esc_html__( '6 items', 'ayvo' ),
					),
					'default'    => '4',
					'dependency' => array( 'ovic_enable_related_post', '==', true ),
				),
				'ovic_related_post_md_items' => array(
					'id'         => 'ovic_related_post_md_items',
					'type'       => 'select',
					'title'      => esc_html__( 'Related items per row on landscape tablet', 'ayvo' ),
					'desc'       => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'ayvo' ),
					'options'    => array(
						'1' => esc_html__( '1 item', 'ayvo' ),
						'2' => esc_html__( '2 items', 'ayvo' ),
						'3' => esc_html__( '3 items', 'ayvo' ),
						'4' => esc_html__( '4 items', 'ayvo' ),
						'5' => esc_html__( '5 items', 'ayvo' ),
						'6' => esc_html__( '6 items', 'ayvo' ),
					),
					'default'    => '3',
					'dependency' => array( 'ovic_enable_related_post', '==', true ),
				),
				'ovic_related_post_sm_items' => array(
					'id'         => 'ovic_related_post_sm_items',
					'type'       => 'select',
					'title'      => esc_html__( 'Related items per row on portrait tablet', 'ayvo' ),
					'desc'       => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'ayvo' ),
					'options'    => array(
						'1' => esc_html__( '1 item', 'ayvo' ),
						'2' => esc_html__( '2 items', 'ayvo' ),
						'3' => esc_html__( '3 items', 'ayvo' ),
						'4' => esc_html__( '4 items', 'ayvo' ),
						'5' => esc_html__( '5 items', 'ayvo' ),
						'6' => esc_html__( '6 items', 'ayvo' ),
					),
					'default'    => '2',
					'dependency' => array( 'ovic_enable_related_post', '==', true ),
				),
				'ovic_related_post_xs_items' => array(
					'id'         => 'ovic_related_post_xs_items',
					'type'       => 'select',
					'title'      => esc_html__( 'Related items per row on Mobile', 'ayvo' ),
					'desc'       => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'ayvo' ),
					'options'    => array(
						'1' => esc_html__( '1 item', 'ayvo' ),
						'2' => esc_html__( '2 items', 'ayvo' ),
						'3' => esc_html__( '3 items', 'ayvo' ),
						'4' => esc_html__( '4 items', 'ayvo' ),
						'5' => esc_html__( '5 items', 'ayvo' ),
						'6' => esc_html__( '6 items', 'ayvo' ),
					),
					'default'    => '1',
					'dependency' => array( 'ovic_enable_related_post', '==', true ),
				),
				'ovic_related_post_ts_items' => array(
					'id'         => 'ovic_related_post_ts_items',
					'type'       => 'select',
					'title'      => esc_html__( 'Related items per row on Mobile', 'ayvo' ),
					'desc'       => esc_html__( '(Screen resolution of device < 480px)', 'ayvo' ),
					'options'    => array(
						'1' => esc_html__( '1 item', 'ayvo' ),
						'2' => esc_html__( '2 items', 'ayvo' ),
						'3' => esc_html__( '3 items', 'ayvo' ),
						'4' => esc_html__( '4 items', 'ayvo' ),
						'5' => esc_html__( '5 items', 'ayvo' ),
						'6' => esc_html__( '6 items', 'ayvo' ),
					),
					'default'    => '1',
					'dependency' => array( 'ovic_enable_related_post', '==', true ),
				),
			),
		);
		array_unshift( $sections['blog_main']['sections']['blog_single']['fields'],
			array(
				'id'    => 'ovic_single_share_button',
				'type'  => 'switcher',
				'title' => esc_html__( 'Enable Share button', 'ayvo' ),
			),
			array(
				'id'      => 'ovic_single_blog_style',
				'type'    => 'select',
				'title'   => esc_html__( 'Single Style', 'ayvo' ),
				'options' => array(
					'classic' => esc_html__( 'Classic', 'ayvo' ),
					'modern'  => esc_html__( 'Modern', 'ayvo' ),
				),
				'default' => 'classic',
			)
		);
		if ( class_exists( 'WooCommerce' ) ) {
			array_unshift( $sections['woocommerce_main']['sections']['woocommerce']['fields'],
				array(
					'id'    => 'enable_shop_theme_container',
					'type'  => 'switcher',
					'title' => esc_html__( 'Enable Theme container in shop page', 'ayvo' ),
					'desc'  => esc_html__( '(max-width = 1800px)', 'ayvo' ),
				),
				array(
					'id'    => 'banner_shop_image',
					'type'  => 'image',
					'title' => esc_html__( 'Background Banner', 'ayvo' ),
				)
			);
			/* single product */
			array_unshift( $sections['woocommerce_main']['sections']['single_product']['fields'],
				array(
					'id'    => 'enable_share_product',
					'type'  => 'switcher',
					'title' => esc_html__( 'Enable Share Product', 'ayvo' ),
				)
			);
			$sections['woocommerce_main']['sections']['single_product']['fields']['ovic_single_product_thumbnail'] = array(
				'id'      => 'ovic_single_product_thumbnail',
				'type'    => 'select',
				'title'   => esc_html__( 'Single Product Thumbnail', 'ayvo' ),
				'options' => array(
					'vertical'   => esc_html__( 'Vertical', 'ayvo' ),
					'horizontal' => esc_html__( 'Horizontal', 'ayvo' ),
					'sticky'     => esc_html__( 'Sticky', 'ayvo' ),
					'slide'      => esc_html__( 'Slide', 'ayvo' ),
				),
				'default' => 'horizontal',
			);
			unset( $sections['header_main']['sections']['vertical'] );
			unset( $sections['woocommerce_main']['sections']['single_product']['fields']['ovic_position_summary_product'] );
		}

		return $sections;
	}
}
/*==========================================================================
META BOX OPTIONS
===========================================================================*/
if ( !function_exists( 'ayvo_metabox_options' ) ) {
	add_filter( 'ovic_options_metabox', 'ayvo_metabox_options' );
	function ayvo_metabox_options( $sections )
	{
		$option_footer = ( class_exists( 'Ovic_Footer_Builder' ) ) ? Ovic_Footer_Builder::ovic_get_footer_preview() : array();
		$sections[]    = array(
			'id'        => '_custom_metabox_theme_options',
			'title'     => esc_html__( 'Custom Theme Options', 'ayvo' ),
			'post_type' => 'page',
			'context'   => 'normal',
			'priority'  => 'high',
			'sections'  => array(
				'metabox_options' => array(
					'name'   => 'metabox_options',
					'icon'   => 'fa fa-toggle-off',
					'title'  => esc_html__( 'Meta Box Options', 'ayvo' ),
					'desc'   => esc_html__( 'Enable for using Themes setting on this page.', 'ayvo' ),
					'fields' => array(
						array(
							'id'    => 'page_banner',
							'type'  => 'image',
							'title' => esc_html__( 'Page Banner', 'ayvo' ),
							'desc'  => esc_html__( 'Setting Banner For this page', 'ayvo' ),
						),
						array(
							'id'    => 'metabox_disable_title',
							'type'  => 'switcher',
							'title' => esc_html__( 'Disable Title', 'ayvo' ),
						),
						array(
							'id'    => 'metabox_options_enable',
							'type'  => 'switcher',
							'title' => esc_html__( 'Meta Box Options', 'ayvo' ),
							'desc'  => esc_html__( 'Enable for using Themes setting on this page.', 'ayvo' ),
						),
						array(
							'id'         => 'metabox_logo',
							'type'       => 'image',
							'title'      => esc_html__( 'Logo', 'ayvo' ),
							'desc'       => esc_html__( 'Setting Logo For this page', 'ayvo' ),
							'dependency' => array( 'metabox_options_enable', '==', true ),
						),
						array(
							'id'         => 'metabox_ayvo_used_header',
							'type'       => 'select_preview',
							'title'      => esc_html__( 'Header Layout', 'ayvo' ),
							'desc'       => esc_html__( 'Select a header layout', 'ayvo' ),
							'options'    => get_header_options(),
							'default'    => 'style-06',
							'dependency' => array( 'metabox_options_enable', '==', true ),
						),
						array(
							'id'         => 'metabox_ayvo_header_position',
							'type'       => 'switcher',
							'title'      => esc_html__( 'Enable Header position absolute', 'ayvo' ),
							'dependency' => array( 'metabox_ayvo_used_header', 'any', 'style-02,style-03' ),
						),
						array(
							'id'         => 'metabox_ayvo_used_footer',
							'type'       => 'select_preview',
							'title'      => esc_html__( 'Footer Layout', 'ayvo' ),
							'desc'       => esc_html__( 'Select a footer layout', 'ayvo' ),
							'options'    => $option_footer,
							'dependency' => array( 'metabox_options_enable', '==', true ),
						),
					),
				),
			),
		);
		$sections[]    = array(
			'id'        => '_metabox_portfolio_options',
			'title'     => esc_html__( 'Portfolio Post Options', 'ayvo' ),
			'post_type' => 'portfolio',
			'context'   => 'side',
			'priority'  => 'high',
			'sections'  => array(
				'post' => array(
					'name'   => 'post',
					'title'  => esc_html__( 'Portfolio Settings', 'ayvo' ),
					'icon'   => 'fa fa-folder-open-o',
					'fields' => array(
						array(
							'id'      => 'portfolio_size',
							'type'    => 'select',
							'title'   => esc_html__( 'Post Size', 'ayvo' ),
							'options' => array(
								'height-1' => esc_html__( 'Size 1', 'ayvo' ),
								'height-2' => esc_html__( 'Size 2', 'ayvo' ),
								'height-3' => esc_html__( 'Size 3', 'ayvo' ),
								'custom'   => esc_html__( 'Custom', 'ayvo' ),
							),
							'default' => 'height-1',
						),
						array(
							'id'         => 'portfolio_width',
							'type'       => 'number',
							'title'      => esc_html__( 'Width', 'ayvo' ),
							'default'    => '370',
							'dependency' => array( 'portfolio_size', '==', 'custom' ),
						),
						array(
							'id'         => 'portfolio_height',
							'type'       => 'number',
							'title'      => esc_html__( 'Height', 'ayvo' ),
							'default'    => '270',
							'dependency' => array( 'portfolio_size', '==', 'custom' ),
						),
						array(
							'id'    => 'portfolio_gallery',
							'type'  => 'gallery',
							'title' => esc_html__( 'Post Gallery', 'ayvo' ),
						),
					),
				),
			),
		);
		$sections[]    = array(
			'id'        => '_metabox_post_options',
			'title'     => esc_html__( 'Post Options', 'ayvo' ),
			'post_type' => 'post',
			'context'   => 'side',
			'priority'  => 'high',
			'sections'  => array(
				'post' => array(
					'name'   => 'post',
					'title'  => esc_html__( 'Post Settings', 'ayvo' ),
					'icon'   => 'fa fa-folder-open-o',
					'fields' => array(
						array(
							'id'      => 'post_size',
							'type'    => 'select',
							'title'   => esc_html__( 'Post Size', 'ayvo' ),
							'options' => array(
								'width-1' => esc_html__( 'Size 1', 'ayvo' ),
								'width-2' => esc_html__( 'Size 2', 'ayvo' ),
							),
							'default' => 'width-1',
						),
					),
				),
			),
		);

		return $sections;
	}
}