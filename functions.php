<?php
if ( !isset( $content_width ) ) $content_width = 900;
if ( !class_exists( 'Ayvo_Functions' ) ) {
	class  Ayvo_Functions
	{
		/**
		 * @var Ayvo_Functions The one true Ayvo_Functions
		 * @since 1.0
		 */
		private static $instance;

		public static function instance()
		{
			if ( !isset( self::$instance ) && !( self::$instance instanceof Ayvo_Functions ) ) {
				self::$instance = new Ayvo_Functions;
			}
			define( 'OVIC_ACTIVE_VER', true );
			add_action( 'after_setup_theme', array( self::$instance, 'setups' ) );
			add_action( 'wp_enqueue_scripts', array( self::$instance, 'scripts' ) ); // Enqueue Frontend
			add_action( 'admin_enqueue_scripts', array( self::$instance, 'admin_scripts' ) );
			add_filter( 'get_default_comment_status', array( self::$instance, 'open_default_comments_for_page' ), 10, 3 );
			add_filter( 'comment_form_fields', array( self::$instance, 'ayvo_move_comment_field_to_bottom' ), 10, 3 );
			add_action( 'widgets_init', array( self::$instance, 'register_widgets' ) );
			if ( !has_filter( 'ovic_resize_image' ) ) {
				add_filter( 'ovic_resize_image', array( self::$instance, 'ovic_resize_image' ), 10, 5 );
			}
			add_filter( 'body_class', array( self::$instance, 'body_class' ) );
			self::includes();

			return self::$instance;
		}

		function ayvo_move_comment_field_to_bottom( $fields )
		{
			$comment_field = $fields['comment'];
			unset( $fields['comment'] );
			$fields['comment'] = $comment_field;

			return $fields;
		}

		function body_class( $classes )
		{
			$my_theme  = wp_get_theme();
			$classes[] = $my_theme->get( 'Name' ) . "-" . $my_theme->get( 'Version' );
			if ( !class_exists( 'Ovic_Toolkit' ) )
				$classes[] = 'no-toolkit';

			return $classes;
		}

		public function setups()
		{
			$this->load_theme_textdomain();
			$this->theme_support();
			$this->register_nav_menus();
		}

		public function theme_support()
		{
			$product_thumb = $this->get_option( 'ovic_single_product_thumbnail', 'vertical' );
			add_theme_support( 'html5',
				array(
					'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'video',
				)
			);
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'post-thumbnails' );
			set_post_thumbnail_size( 870, 540, true );
			/*Support woocommerce*/
			add_theme_support( 'woocommerce' );
			if ( $product_thumb != 'slide' ) {
				add_theme_support( 'wc-product-gallery-lightbox' );
				add_theme_support( 'wc-product-gallery-slider' );
				add_theme_support( 'wc-product-gallery-zoom' );
			}
			add_theme_support( 'ovic-theme-option' );
			add_theme_support( 'ovic-footer-builder' );
			// Add support for Block Styles.
			add_theme_support( 'wp-block-styles' );
			// Add support for full and wide align images.
			add_theme_support( 'align-wide' );
			// Add support for editor styles.
			add_theme_support( 'editor-styles' );
			// Enqueue editor styles.
			add_editor_style(
				array(
					'style-editor.css',
					$this->google_fonts(),
				)
			);
			// Add support for responsive embedded content.
			add_theme_support( 'responsive-embeds' );
		}

		public function load_theme_textdomain()
		{
			load_theme_textdomain( 'ayvo', get_template_directory() . '/languages' );
		}

		public function register_nav_menus()
		{
			register_nav_menus( array(
					'primary'         => esc_html__( 'Primary Menu', 'ayvo' ),
					'left-primary-2'  => esc_html__( 'Left Primary Menu', 'ayvo' ),
					'right-primary-2' => esc_html__( 'Right Primary Menu', 'ayvo' ),
					'topbar_menu'     => esc_html__( 'Topbar Menu', 'ayvo' ),
				)
			);
		}

		public function register_widgets()
		{
			register_sidebar( array(
					'name'          => esc_html__( 'Widget Area', 'ayvo' ),
					'id'            => 'widget-area',
					'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'ayvo' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="widgettitle">',
					'after_title'   => '<span class="arrow"></span></h2>',
				)
			);
		}

		public function google_fonts()
		{
			$font_families   = array();
			$font_families[] = 'Lato:700|Tajawal:400,500,700,800';
			$query_args      = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			$fonts_url       = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

			return esc_url_raw( $fonts_url );
		}

		public function admin_scripts()
		{
			wp_enqueue_style( 'ayvo-admin-abcicon', get_theme_file_uri( '/assets/fonts/abcicon/style.css' ), array(), '1.0' );
		}

		// Enqueue Frontend
		public function scripts()
		{
			// Load fonts
			wp_enqueue_style( 'ayvo-googlefonts', $this->google_fonts(), array(), null );
			wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/assets/css/bootstrap.min.css' ), array(), '1.0' );
			wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/assets/fonts/font-awesome/font-awesome.min.css' ), array(), '1.0' );
			wp_enqueue_style( 'owl-carousel', get_theme_file_uri( '/assets/css/owl.carousel.min.css' ), array(), '1.0' );
			wp_enqueue_style( 'scrollbar-css', get_theme_file_uri( '/assets/css/scrollbar.min.css' ), array(), '1.0' );
			wp_enqueue_style( 'icon-helper-css', get_theme_file_uri( '/assets/css/helper.css' ), array(), '1.0' );
			wp_enqueue_style( 'icon-css', get_theme_file_uri( '/assets/css/pe-icon-7-stroke.css' ), array(), '1.0' );
			wp_enqueue_style( 'abcicon', get_theme_file_uri( '/assets/fonts/abcicon/style.css' ), array(), '1.0' );
			wp_enqueue_style( 'ayvo-custom-css', get_theme_file_uri( '/assets/css/style.min.css' ), array(), '1.0' );
			wp_style_add_data( 'ayvo-custom-css', 'rtl', 'replace' );
			wp_enqueue_style( 'ayvo-main', get_stylesheet_uri() );
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			/* REGISTER SCRIPT */
			wp_register_style( 'fullpage', get_theme_file_uri( '/assets/css/fullpage.min.css' ), array(), '1.0', true );
			wp_register_script( 'isotope', get_theme_file_uri( '/assets/js/libs/isotope.pkgd.min.js' ), array(), '1.0', true );
			wp_register_script( 'packery', get_theme_file_uri( '/assets/js/libs/packery-mode.pkgd.min.js' ), array(), '1.0', true );
			wp_register_script( 'fullpage', get_theme_file_uri( '/assets/js/libs/fullpage.js' ), array(), '1.0', true );
			wp_register_script( 'ayvo-fullpage', get_theme_file_uri( '/assets/js/fullpage.js' ), array( 'fullpage' ), '1.0', true );
			wp_register_script( 'ayvo-isotope', get_theme_file_uri( '/assets/js/isotope.js' ), array( 'imagesloaded', 'isotope', 'packery' ), '1.0', true );
			/* ENQUEUE SCRIPT */
			wp_enqueue_script( 'owl-js', get_theme_file_uri( '/assets/js/libs/owl.carousel.min.js' ), array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'scrollbar', get_theme_file_uri( '/assets/js/libs/scrollbar.min.js' ), array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'ayvo-script', get_theme_file_uri( '/assets/js/functions.min.js' ), array(), '1.0', true );
			$enable_sticky_menu = $this->get_option( 'ovic_sticky_menu' );
			wp_localize_script( 'ayvo-script', 'ayvo_ajax_frontend', array(
					'ajaxurl'          => admin_url( 'admin-ajax.php' ),
					'security'         => wp_create_nonce( 'ayvo_ajax_frontend' ),
					'day_text'         => esc_html__( 'Days', 'ayvo' ),
					'hrs_text'         => esc_html__( 'Hrs', 'ayvo' ),
					'mins_text'        => esc_html__( 'Mins', 'ayvo' ),
					'secs_text'        => esc_html__( 'Secs', 'ayvo' ),
					'ovic_sticky_menu' => $enable_sticky_menu,
				)
			);
		}

		public static function get_logo()
		{
			$logo_url = get_theme_file_uri( '/assets/images/logo.png' );
			$logo     = self::get_option( 'ovic_logo' );
			if ( $logo != '' ) {
				$logo_url = wp_get_attachment_image_url( $logo, 'full' );
			}
			$data_meta           = get_post_meta( get_the_ID(), '_custom_metabox_theme_options', true );
			$enable_theme_option = isset( $data_meta['metabox_options_enable'] ) ? $data_meta['metabox_options_enable'] : 0;
			if ( $enable_theme_option == 1 && isset( $data_meta['metabox_logo'] ) && $data_meta['metabox_logo'] !== '' )
				$logo_url = wp_get_attachment_image_url( $data_meta['metabox_logo'], 'full' );
			$html = '<a href="' . esc_url( home_url( '/' ) ) . '"><img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $logo_url ) . '" class="_rw" /></a>';
			echo apply_filters( 'ayvo_site_logo', $html );
		}

		public static function get_option( $key, $default = '' )
		{
			if ( has_filter( 'ovic_get_option' ) ) {
				return apply_filters( 'ovic_get_option', $key, $default );
			}

			return $default;
		}

		public static function get_post_meta( $post_id, $key, $default )
		{
			$value = get_post_meta( $post_id, $key, true );
			if ( $value != "" ) {
				return $value;
			}

			return $default;
		}

		function ovic_resize_image( $attach_id, $width, $height, $crop = false, $use_lazy = false )
		{
			if ( $attach_id ) {
				$size = array( $width, $height );
				if ( $width == false && $height == false ) {
					$size = 'full';
				}
				$image_src = wp_get_attachment_image_src( $attach_id, $size );
				$image_alt = get_post_meta( $attach_id, '_wp_attachment_image_alt', true );
				$vt_image  = array(
					'url'    => $image_src[0],
					'width'  => $image_src[1],
					'height' => $image_src[2],
					'img'    => '<img class="img-responsive" src="' . esc_url( $image_src[0] ) . '" ' . image_hwstring( $image_src[1], $image_src[2] ) . ' alt="' . esc_attr( $image_alt ) . '">',
				);
			} else {
				return false;
			}

			return $vt_image;
		}

		/**
		 * Filter whether comments are open for a given post type.
		 *
		 * @param string $status Default status for the given post type,
		 *                             either 'open' or 'closed'.
		 * @param string $post_type Post type. Default is `post`.
		 * @param string $comment_type Type of comment. Default is `comment`.
		 * @return string (Maybe) filtered default status for the given post type.
		 */
		function open_default_comments_for_page( $status, $post_type, $comment_type )
		{
			if ( 'page' == $post_type ) {
				return 'open';
			}

			return $status;
			/*You could be more specific here for different comment types if desired*/
		}

		public static function includes()
		{
			require_once get_parent_theme_file_path( '/framework/classes/class-tgm-plugin-activation.php' );
			require_once get_parent_theme_file_path( '/framework/settings/theme-options.php' );
			require_once get_parent_theme_file_path( '/framework/settings/plugins-load.php' );
			require_once get_parent_theme_file_path( '/framework/settings/custom-css.php' );
			require_once get_parent_theme_file_path( '/framework/theme-functions.php' );
			require_once get_parent_theme_file_path( '/framework/blog-functions.php' );
			require_once get_parent_theme_file_path( '/framework/widgets/widget-ovic-archive.php' );
			require_once get_parent_theme_file_path( '/import/import.php' );
			if ( class_exists( 'Ovic_Toolkit' ) ) {
				require_once get_parent_theme_file_path( '/framework/widgets/widget-recent-post.php' );
				if ( class_exists( 'Vc_Manager' ) ) {
					require_once get_parent_theme_file_path( '/framework/visual-composer.php' );
				}
			}
			if ( class_exists( 'WooCommerce' ) ) {
				require_once get_parent_theme_file_path( '/framework/woo-functions.php' );
			}
			/* ADMIN */
			//			require_once get_parent_theme_file_path( '/framework/admin/license.php' );
		}
	}
}
if ( !function_exists( 'Ayvo_Functions' ) ) {
	function Ayvo_Functions()
	{
		return Ayvo_Functions::instance();
	}

	Ayvo_Functions();
}
add_filter( 'woocommerce_product_subcategories_hide_empty', 'hide_empty_categories', 10, 1 );
function hide_empty_categories ( $hide_empty ) {
    $hide_empty  =  FALSE;
    // You can add other logic here too
    return $hide_empty;
}