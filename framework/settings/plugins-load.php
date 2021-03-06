<?php
if ( !class_exists( 'Ayvo_PluginLoad' ) ) {
	class Ayvo_PluginLoad
	{
		public $plugins = array();
		public $config  = array();

		public function __construct()
		{
			$this->plugins();
			$this->config();
			if ( !class_exists( 'TGM_Plugin_Activation' ) ) {
				return false;
			}
			if ( function_exists( 'tgmpa' ) ) {
				tgmpa( $this->plugins, $this->config );
			}
		}

		public function plugins()
		{
			$this->plugins = array(
				array(
					'name'               => 'Ovic Toolkit', // The plugin name
					'slug'               => 'ovic-toolkit', // The plugin slug (typically the folder name)
					'source'                => 'http://plugins.kutethemes.net/ovic-toolkit.zip', // The plugin source
//					'source'             => get_template_directory() . '/plugins/ovic-toolkit.zip', // The plugin source
					'required'           => true, // If false, the plugin is only 'recommended' instead of required
					'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url'       => '', // If set, overrides default API URL and points to an external URL
				),
				array(
					'name'               => 'Ovic Import', // The plugin name
					'slug'               => 'ovic-import', // The plugin slug (typically the folder name)
					'source'                => 'http://plugins.kutethemes.net/ovic-import.zip', // The plugin source
//					'source'             => get_template_directory() . '/plugins/ovic-import.zip', // The plugin source
					'required'           => true, // If false, the plugin is only 'recommended' instead of required
					'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url'       => '', // If set, overrides default API URL and points to an external URL
				),
				array(
					'name'               => 'Revolution Slider', // The plugin name
					'slug'               => 'revslider', // The plugin slug (typically the folder name)
					'source'                => esc_url('http://plugins.kutethemes.net/revslider.zip'), // The plugin source
					//'source'             => get_template_directory() . '/plugins/revslider.zip', // The plugin source
					'required'           => true, // If false, the plugin is only 'recommended' instead of required
					'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url'       => '', // If set, overrides default API URL and points to an external URL
				),
				array(
					'name'               => 'WPBakery Visual Composer', // The plugin name
					'slug'               => 'js_composer', // The plugin slug (typically the folder name)
					'source'             => esc_url('http://plugins.kutethemes.net/js_composer.zip'), // The plugin source
//					'source'             => get_template_directory() . '/plugins/js_composer.zip', // The plugin source
					'required'           => true, // If false, the plugin is only 'recommended' instead of required
					'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url'       => '', // If set, overrides default API URL and points to an external URL
				),
				array(
					'name'     => 'WooCommerce',
					'slug'     => 'woocommerce',
					'required' => true,
				),
				array(
					'name'     => 'YITH WooCommerce Compare',
					'slug'     => 'yith-woocommerce-compare',
					'required' => false,
				),
				array(
					'name'     => 'YITH WooCommerce Wishlist', // The plugin name
					'slug'     => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
					'required' => false, // If false, the plugin is only 'recommended' instead of required
				),
				array(
					'name'     => 'YITH WooCommerce Quick View', // The plugin name
					'slug'     => 'yith-woocommerce-quick-view', // The plugin slug (typically the folder name)
					'required' => false, // If false, the plugin is only 'recommended' instead of required
				),
				array(
					'name'     => 'Contact Form 7',
					'slug'     => 'contact-form-7',
					'required' => false,
				),
			);
		}

		public function config()
		{
			$this->config = array(
				'id'           => 'ayvo',                 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'ayvo-install-plugins', // Menu slug.
				'parent_slug'  => 'themes.php',            // Parent menu slug.
				'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => true,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.
			);
		}
	}
}
if ( !function_exists( 'Ayvo_PluginLoad' ) ) {
	function Ayvo_PluginLoad()
	{
		new  Ayvo_PluginLoad();
	}
}
add_action( 'tgmpa_register', 'Ayvo_PluginLoad' );