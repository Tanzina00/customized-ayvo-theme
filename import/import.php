<?php
// Prevent direct access to this file
defined( 'ABSPATH' ) || die( 'Direct access to this file is not allowed.' );
/**
 * Core class.
 *
 * @package  Ovic
 * @since    1.0
 */
if ( !class_exists( 'Ovic_theme_Import' ) ) {
	class Ovic_theme_Import
	{
		/**
		 * Define theme version.
		 *
		 * @var  string
		 */
		const VERSION = '1.0.0';

		public function __construct()
		{
			add_filter( 'ovic_import_config', array( $this, 'ovic_import_config' ) );
			add_filter( 'ovic_import_wooCommerce_attributes', array( $this, 'ovic_import_wooCommerce_attributes' ) );
		}

		function ovic_import_wooCommerce_attributes()
		{
			$attributes = array(
				array(
					'attribute_label'   => 'Color',
					'attribute_name'    => 'color',
					'attribute_type'    => 'box_style', // text, box_style, select
					'attribute_orderby' => 'menu_order',
					'attribute_public'  => '0',
				),
				array(
					'attribute_label'   => 'Size',
					'attribute_name'    => 'size',
					'attribute_type'    => 'select', // text, box_style, select
					'attribute_orderby' => 'menu_order',
					'attribute_public'  => '0',
				),
			);

			return $attributes;
		}

		function ovic_import_config( $data_filter )
		{
			$registed_menu                = array(
				'primary'         => esc_html__( 'Primary Menu', 'ayvo' ),
				'left-primary-2'  => esc_html__( 'Left Primary Menu', 'ayvo' ),
				'right-primary-2' => esc_html__( 'Right Primary Menu', 'ayvo' ),
				'topbar_menu'     => esc_html__( 'Topbar Menu', 'ayvo' ),
			);
			$menu_location                = array(
				'primary'         => 'Primary Menu',
				'left-primary-2'  => 'Left Primary Menu',
				'right-primary-2' => 'Right Primary Menu',
				'topbar_menu'     => 'Topbar Menu',
			);
			$data_filter['data_advanced'] = array(
				'att' => esc_html__( 'Demo Attachments', 'ayvo' ),
				'wid' => esc_html__( 'Import Widget', 'ayvo' ),
				'rev' => esc_html__( 'Slider Revolution', 'ayvo' ),
			);
			$data_filter['data_import']   = array(
				'main_demo'      => 'https://ayvo.kutethemes.net/',
				'theme_option'   => get_template_directory() . '/import/data/theme-options.txt',
				'setting_option' => get_template_directory() . '/import/data/setting-options.txt',
				'content_path'   => get_template_directory() . '/import/data/content.xml',
				'widget_path'    => get_template_directory() . '/import/data/widgets.wie',
				'revslider_path' => get_template_directory() . '/import/revsliders/',
			);
			$home                         = array();

			for ( $i = 1; $i <= 12; $i++ ) {
				$home[] = array(
					'name'           => esc_html__( 'Demo ' .  zeroise($i,2), 'ayvo' ),
					'slug'           => 'home-' . zeroise($i,2),
					'menus'          => $registed_menu,
					'homepage'       => 'Home ' . zeroise($i,2),
					'blogpage'       => 'Blog',
					'preview'        => get_theme_file_uri( 'assets/images/preview/home' . zeroise($i,2) . '.jpg' ),
					'demo_link'      => 'https://ayvo.kutethemes.net/home-' . zeroise($i,2),
					'menu_locations' => $menu_location,
				);
			}
			$data_filter['data_demos']  = $home;
			$data_filter['woo_single']  = 760;
			$data_filter['woo_catalog'] = 760;
			$data_filter['woo_ratio']   = '760:989';

			return $data_filter;
		}
	}

	new Ovic_theme_Import();
}