<?php
/**
 * Muvipro functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'gmr_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since v.1.0.0
	 */
	function gmr_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Muvipro, use a find and replace
		 * to change 'muvipro' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'muvipro', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * See https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		
		add_image_size( 'blog-large', 430, 250, true );
		add_image_size( 'blog-small', 60, 60, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'muvipro' ),
			'secondary' => esc_html__( 'Secondary', 'muvipro' ),
			'topnav' => esc_html__( 'Top Navigation', 'muvipro' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		
		/*
		 * RECOMMENDED: No reference to add_editor_style()
		 * Not usefull in theme, just pass theme checker plugin
		 */
		add_editor_style( 'editor-style.css' );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'muvipro_custom_background_args', array(
			'default-color' => 'eeeeee',
			'default-image' => '',
		) ) );
		
		/**
		 * Sample implementation of the Custom Header feature.
		 *
		 * You can add an optional custom header image to header.php like so ...
		 *
			<?php if ( get_header_image() ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
			</a>
			<?php endif; // End header image check. ?>
		 *
		 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
		 *
		 * @since v.1.0.0
		 */

		add_theme_support( 'custom-header', apply_filters( 'muvipro_custom_header_args', array(
			'width'                  => 1400,
			'height'                 => 100,
			'flex-height'            => true,
			'flex-width'             => true,
			'uploads'       		 => true,
			'header-text' 			 => false
		) ) );
	}
endif; // endif gmr_setup
add_action( 'after_setup_theme', 'gmr_setup' );
		
if ( ! function_exists( 'gmr_width_size_image' ) ) :
	/**
	 * Improve performance, it's mean, only when switch theme this functions is active.
	 *
	 * @since v.1.0.0
	 */
	function gmr_width_size_image() {
		// Thumbnail Size Thumbnail
		update_option( 'thumbnail_size_w', 60 );
		update_option( 'thumbnail_size_h', 90 );	
		// force hard crop medium size thumbnail
		update_option( 'thumbnail_crop', 1 );

		// Medium Size Thumbnail
		update_option( 'medium_size_w', 152 );
		update_option( 'medium_size_h', 228 );
		// force hard crop medium size thumbnail
		update_option( 'medium_crop', '1' );
		
		// Large Size Thumbnail
		update_option( 'large_size_w', 170 );
		update_option( 'large_size_h', 255 );
		// force hard crop large size thumbnail
		update_option( 'large_crop', '1' );
	}
endif; // endif gmr_width_size_image
add_action( 'after_switch_theme', 'gmr_width_size_image' );

if ( ! function_exists( 'gmr_content_width' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @since v.1.0.0
	 *
	 * @global int $content_width
	 */
	function gmr_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'gmr_content_width', 1140 );
	}
endif; // endif gmr_content_width
add_action( 'after_setup_theme', 'gmr_content_width', 0 );

if ( ! function_exists( 'gmr_widgets_init' ) ) :
	/**
	 * Register widget area.
	 *
	 * @since v.1.0.0
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function gmr_widgets_init() {
		//Sidebar widget areas
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'muvipro' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'muvipro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		//Homepage module
		register_sidebar( array(
			'name'          => esc_html__( 'Home Module', 'muvipro' ),
			'id'            => 'home-module',
			'description'   => esc_html__( 'Add module here.', 'muvipro' ),
			'before_widget' => '<div id="%1$s" class="home-widget widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="homemodule-title">',
			'after_title'   => '</h3>',
		) );
		//Footer widget areas
		$mod = get_theme_mod( 'gmr_footer_column', '3' );
		
		for ( $i=1; $i<=$mod; $i++ ) {
			register_sidebar( array(
				'name'          => esc_html__( 'Footer ', 'muvipro' ) . $i,
				'id'            => 'footer-' . $i,
				'description'   => '',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}	
		
	}
endif; // endif gmr_widgets_init
add_action( 'widgets_init', 'gmr_widgets_init' );

if ( ! function_exists( 'gmr_scripts' ) ) :
	/**
	 * Enqueue scripts and styles.
	 */
	function gmr_scripts() {
		// Font options
		$fonts = array(
			get_theme_mod( 'gmr_primary-font', customizer_library_get_default( 'gmr_primary-font' ) ),
			get_theme_mod( 'gmr_secondary-font', customizer_library_get_default( 'gmr_secondary-font' ) )
		);
		$font_uri = customizer_library_get_google_font_uri( $fonts );
		
		// Load Google Fonts
		wp_enqueue_style( 'muvipro-fonts', $font_uri, array(), null, 'all' );
		
		// Call if only woocommerce actived
		if ( class_exists( 'WooCommerce' ) ) {
			// Custom Woocommerce CSS
			wp_enqueue_style( 'muvipro-woocommerce', get_template_directory_uri() . '/css/woocommerce.css' );
		}
		
		// Add stylesheet
		wp_enqueue_style( 'muvipro-style', get_stylesheet_uri() );
		
		global $is_IE;
		if ( $is_IE ) {
			// Modernizr Jquery
			wp_enqueue_script( 'muvipro-modernizr', get_template_directory_uri() . '/js/modernizr-custom.js', array('jquery') );
		}
		
		// Jquery Plugin
		wp_enqueue_script( 'muvipro-jqueryplugin', get_template_directory_uri() . '/js/jquery-plugin-min.js', array('jquery'), '', true );
		
		// Custom script
		wp_enqueue_script( 'muvipro-customscript', get_template_directory_uri() . '/js/customscript.js', array('jquery'), '', true );
		
		// Ajax player
		if ( is_singular() ) {
			$player_style = get_theme_mod( 'gmr_player_style', 'ajax' );
			if ( $player_style == 'subpage' ) {
			} else {
				global $post;
				$player1 = get_post_meta( $post->ID, 'IDMUVICORE_Player1', true );
				$player2 = get_post_meta( $post->ID, 'IDMUVICORE_Player2', true );
				$player3 = get_post_meta( $post->ID, 'IDMUVICORE_Player3', true );
				$player4 = get_post_meta( $post->ID, 'IDMUVICORE_Player4', true );
				$player5 = get_post_meta( $post->ID, 'IDMUVICORE_Player5', true );
				$player6 = get_post_meta( $post->ID, 'IDMUVICORE_Player6', true );
				$player7 = get_post_meta( $post->ID, 'IDMUVICORE_Player7', true );
				$player8 = get_post_meta( $post->ID, 'IDMUVICORE_Player8', true );
				$player9 = get_post_meta( $post->ID, 'IDMUVICORE_Player9', true );
				$player10 = get_post_meta( $post->ID, 'IDMUVICORE_Player10', true );
				if ( 
				   ! empty( $player1 ) 
				|| ! empty( $player2 ) 
				|| ! empty( $player3 )
				|| ! empty( $player4 )
				|| ! empty( $player5 )
				|| ! empty( $player6 )
				|| ! empty( $player7 )
				|| ! empty( $player8 )
				|| ! empty( $player9 )
				|| ! empty( $player10 )
				) { 
					wp_enqueue_script( 'muvipro-ajax-player', get_template_directory_uri() . '/js/ajax-player.js', array('jquery'), '', true );
					wp_localize_script( 'muvipro-ajax-player', 'mvpp',   
						array( 'ajax_url' => admin_url( 'admin-ajax.php' )) 
					);  
				}
			}
		}
		if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
			// add this javascript if infinite scroll from jetpack is enable
			wp_enqueue_script( 'muvipro-infinite-matchheight', get_template_directory_uri() . '/js/infinite-matchheight.js', array('jquery'), '', true );
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
endif; // endif gmr_scripts
add_action( 'wp_enqueue_scripts', 'gmr_scripts' );

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 *
 * @since v.1.0.0
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'muvipro_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10
 *
 * @since v.1.0.0
 */
function muvipro_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Include One Click Demo Import from the WordPress Plugin Repository.
		array(
			'name'      => 'One Click Demo Import',
			'slug'      => 'one-click-demo-import',
			'required'  => true,
		),
		
		// This is an include a plugin bundled with a theme.
		array(
			'name'               => 'Idmuvi Core', // The plugin name.
			'slug'               => 'idmuvi-core', // The plugin slug (typically the folder name).
			'source'             => 'https://www.dropbox.com/s/frggtnz73uonp22/idmuvi-core.zip?dl=1', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
		),
		
		// This is an include a plugin bundled with a theme.
		array(
			'name'             	=> 'WP PostViews', // The plugin name.
			'slug'      		=> 'wp-postviews',
			'required'  		=> true,
		),
		
		// This is an include a plugin bundled with a theme.
		array(
			'name'             	=> 'Auto Regenerate Thumbnail', // The plugin name.
			'slug'      		=> 'otf-regenerate-thumbnails',
			'required'  		=> true,
		),
		
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 */
	$config = array(
		'id'           => 'muvipro',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

/**
 * Custom template tags for this theme.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/customizer-library/customizer-library.php';
/* Custom options customizer */
require get_template_directory() . '/inc/customizer-library/gmrtheme-customizer.php';

/**
 * Load Jetpack compatibility file.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Theme Update Checker.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/theme-update-checker.php';

/**
 * Call only if woocommerce actived
 *
 * @since v.1.0.0
 */
if ( class_exists( 'WooCommerce' ) ) {
	/**
	 * Load Woocommerce compatibility file.
	 *
	 * @since v.1.0.0
	 */
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Call only if One Click Demo Import actived
 *
 * @since v.1.0.0
 */
if ( class_exists( 'OCDI_Plugin' ) ) {
	/**
	 * load One Click Demo Import
	 *
	 * @since v.1.0.0
	 */
	require get_template_directory() . '/inc/importer.php';
}

if ( class_exists( 'bbPress' ) ) {
	/**
	 * load BBpress function
	 *
	 * @since v.1.0.0
	 */
	require get_template_directory() . '/inc/bbpress.php';
}

/**
 * Load All Widget For module homepage
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/widgets/module-posts-widget.php';
require get_template_directory() . '/inc/widgets/module-episodes-widget.php';