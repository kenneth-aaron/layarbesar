<?php
/**
 * Plugin Name: Idmuvi Core
 * Plugin URI: http://www.idtheme.com
 * Description: Idmuvi Core - Add functionally to movie theme for easy maintenance. This plugin using only for theme with movie type from idtheme.com
 * Author: Gian Mokhammad R
 *
 * @package Idmuvi Core
 * Version: 2.0.2
 * Author URI: http://www.gianmr.com
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define.
define( 'IDMUVI_CORE_VER', '1.1.3' );
define( 'IDMUVI_CORE_DIRNAME', plugin_dir_path( __FILE__ ) );
define( 'IDMUVI_CORE_URL', plugin_dir_url( __FILE__ ) );

// this is the URL our updater / license checker pings. This should be the URL of the site.
define( 'IDMUVI_API_URL_CHECK', 'http://member.kentooz.com/softsale/api/check-license' );
define( 'IDMUVI_API_URL', 'http://member.kentooz.com/softsale/api/activate' );
define( 'IDMUVI_API_URL_DEACTIVATED', 'http://member.kentooz.com/softsale/api/deactivate' );

// the name of the settings page for the license input to be displayed.
define( 'IDMUVI_PLUGIN_LICENSE_PAGE', 'muvipro-license' );

if ( ! class_exists( 'Idmuvi_Core_Init' ) ) {
	/**
	 * Main Plugin Class
	 */
	class Idmuvi_Core_Init {

		/**
		 * Contract
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function __construct() {

			// Include widget.
			include_once IDMUVI_CORE_DIRNAME . 'widgets/feedburner-widget.php';
			include_once IDMUVI_CORE_DIRNAME . 'widgets/custom-form-widget.php';
			include_once IDMUVI_CORE_DIRNAME . 'widgets/recent-posts-widget.php';
			include_once IDMUVI_CORE_DIRNAME . 'widgets/search-widget.php';
			include_once IDMUVI_CORE_DIRNAME . 'lib/external/class.settings-api.php';

			// Include library.
			include_once IDMUVI_CORE_DIRNAME . 'lib/banner.php';
			include_once IDMUVI_CORE_DIRNAME . 'lib/headfooterscript.php';
			include_once IDMUVI_CORE_DIRNAME . 'lib/jetpack.php';
			include_once IDMUVI_CORE_DIRNAME . 'lib/faster.php';

			$idmuv_ajax = get_option( 'idmuv_ajax' );

			if ( isset( $idmuv_ajax['enable_ajax_search'] ) && ! empty( $idmuv_ajax['enable_ajax_search'] ) ) {
				// option, section, default.
				$option_search_ajax = $idmuv_ajax['enable_ajax_search'];
			} else {
				$option_search_ajax = 'off';
			}

			if ( 'on' === $option_search_ajax ) {
				include_once IDMUVI_CORE_DIRNAME . 'lib/ajax_search.php';
			}

			// Include Movie Custom.
			include_once IDMUVI_CORE_DIRNAME . 'lib/movie/movie.php';

			// Include Custom Post type.
			include_once IDMUVI_CORE_DIRNAME . 'lib/blog/blog.cpt.php';

			// Include Amember HTTP API.
			// Load only if dashboard.
			if ( is_admin() ) {
				include_once IDMUVI_CORE_DIRNAME . 'lib/amember_http_api.php';
			}

			// Action.
			add_action( 'plugins_loaded', array( $this, 'idmuvi_core_load_textdomain' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'wp_footer', array( $this, 'idmuvi_core_jscript' ), 20 );
			add_filter( 'script_loader_tag', array( $this, 'idmuvi_core_async_scripts' ), 10, 2 );

			// Enable the use of shortcodes in text widgets.
			add_filter( 'widget_text', 'do_shortcode' );

			$status = trim( get_option( 'newidmuvi_core_license_status' . md5( home_url() ) ) );

			if ( ! empty( $status ) && 'ok' === $status ) {
				include_once IDMUVI_CORE_DIRNAME . 'lib/z_setting.idmuvi-core.php';
				// Other functionally.
				include_once IDMUVI_CORE_DIRNAME . 'lib/update/plugin-update-checker.php';
				$MyUpdateChecker = PucFactory::buildUpdateChecker(
					'http://www.kentooz.com/files/idmuvi-core/idmuvisenseiformovie.json',
					__FILE__,
					'idmuvi-core'
				);
			} else {
				include_once IDMUVI_CORE_DIRNAME . 'lib/z_license.idmuvi-core.php';
			}
		}

		/**
		 * Activated plugin
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public static function idmuvi_core_activate() {
			flush_rewrite_rules();
		}

		/**
		 * Deativated plugin
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public static function idmuvi_core_deactivate() {
			flush_rewrite_rules();
		}

		/**
		 * Enqueue assets
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function register_scripts() {
			if ( ! is_single() ) {
				$idmuv_ajax = get_option( 'idmuv_ajax' );

				if ( isset( $idmuv_ajax['enable_ajax_navigation'] ) && ! empty( $idmuv_ajax['enable_ajax_navigation'] ) ) {
					// option, section, default.
					$option_ajax = $idmuv_ajax['enable_ajax_navigation'];
				} else {
					$option_ajax = 'off';
				}
				if ( 'on' === $option_ajax ) {
					if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
						/* If jetpack enable, disable this feature */
					} else {
						if ( isset( $idmuv_ajax['ajax_navigation_type'] ) && 'infinite' === $idmuv_ajax['ajax_navigation_type'] ) {
							$type = 'infinite';
						} elseif ( isset( $idmuv_ajax['ajax_navigation_type'] ) && 'more' === $idmuv_ajax['ajax_navigation_type'] ) {
							$type = 'more';
						} else {
							$type = 'infinite';
						}

						wp_enqueue_script( 'gmr-ajax-loadmore-lib', IDMUVI_CORE_URL . 'js/jquery-ajax-loadmore.js', array( 'jquery' ), '1.0.0', true );
						wp_enqueue_script( 'gmr-ajax-loadmore', IDMUVI_CORE_URL . 'js/ajax-loadmore.js', array( 'jquery', 'gmr-ajax-loadmore-lib' ), '1.0.0', true );
						wp_localize_script(
							'gmr-ajax-loadmore',
							'gmr_infiniteload',
							array(
								'navSelector'         => '.site-main .page-numbers',
								'contentSelector'     => '#gmr-main-load',
								'nextSelector'        => '.site-main .page-numbers .next',
								'itemSelector'        => '.item',
								'paginationType'      => $type,
								'loadingImage'        => IDMUVI_CORE_URL . 'img/loader.gif',
								'loadingText'         => __( 'Movie data loaded. Wait a second.', 'idmuvi-core' ),
								'loadingButtonLabel'  => __( 'Load More', 'idmuvi-core' ),
								'loadingButtonClass'  => '',
								'loadingFinishedText' => __( 'No more movie.', 'idmuvi-core' ),
							)
						);
					}
				}
			}

			wp_register_script( 'idmuvi_ajax_search', IDMUVI_CORE_URL . 'js/jquery-autocomplete-min.js', array( 'jquery' ), '1.0.0', true );

			wp_register_style( 'idmuvi-core', IDMUVI_CORE_URL . 'css/idmuvi-core.css', '', '1.0.0' );
			wp_enqueue_style( 'idmuvi-core' );

			$idmuv_ajax = get_option( 'idmuv_ajax' );

			if ( isset( $idmuv_ajax['enable_ajax_search'] ) && ! empty( $idmuv_ajax['enable_ajax_search'] ) ) {
				// option, section, default.
				$option_search_ajax = $idmuv_ajax['enable_ajax_search'];
			} else {
				$option_search_ajax = 'off';
			}

			if ( 'on' === $option_search_ajax ) {

				wp_enqueue_script( 'idmuvi_ajax_search' );
				wp_localize_script(
					'idmuvi_ajax_search',
					'mvpro_ajaxsearch_params',
					array(
						'loading'  => IDMUVI_CORE_URL . 'img/ajax-loader.gif',
						'ajax_url' => admin_url( 'admin-ajax.php' ),
					)
				);
			}

			$idmuv_other = get_option( 'idmuv_other' );
			if ( isset( $idmuv_other['other_analytics_code'] ) && ! empty( $idmuv_other['other_analytics_code'] ) ) {
				wp_register_script( 'gmr-google-analytics', 'https://www.googletagmanager.com/gtag/js?id=' . esc_attr( $idmuv_other['other_analytics_code'] ), array( 'jquery' ), '1.0.0', true );
				wp_enqueue_script( 'gmr-google-analytics' );
			}
		}

		/**
		 * Add an aysnc attribute to an enqueued script
		 *
		 * @param string $tag Tag for the enqueued script.
		 * @param string $handle The script's registered handle.
		 * @return string Script tag for the enqueued script
		 */
		public function idmuvi_core_async_scripts( $tag, $handle ) {
			// Just return the tag normally if this isn't one we want to async.
			if ( 'gmr-google-analytics' !== $handle ) {
				return $tag;
			}
			return str_replace( ' src', ' async src', $tag );
		}

		/**
		 * Load languange
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function idmuvi_core_load_textdomain() {
			load_plugin_textdomain( 'idmuvi-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
			/**
			 * Class_exists on plugin working if using plugins_loaded filter
			 * Most view widget exist if wp postview plugin installed
			 */
			if ( class_exists( 'WP_Widget_PostViews' ) ) {
				include_once IDMUVI_CORE_DIRNAME . 'widgets/mostview-posts-widget.php';
			}
		}

		/**
		 * Crap Core Idmuvi
		 *
		 * @param string $action select action.
		 * @param string $string String Output.
		 * @since 1.0.0
		 * @access public
		 */
		public function idmuvi_core_crap( $action, $string ) {
			$output         = false;
			$encrypt_method = 'AES-256-CBC';
			$secret_key     = 'maniac';
			$secret_iv      = 'maniac';
			// hash.
			$key = hash( 'sha256', $secret_key );

			// Iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning.
			$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
			if ( 'e' === $action ) {
				$output = openssl_encrypt( $string, $encrypt_method, $key, 0, $iv );
				$output = base64_encode( $output );

			} elseif ( 'd' === $action ) {
				$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );

			}
			return $output;
		}

		/**
		 * New Options For L
		 */
		public function idmuvi_de_newopsi() {
			return $this->idmuvi_core_crap( 'e', 'newidmuvi_core_license_status' . md5( home_url() ) );
		}

		/**
		 * Displaying Javascript In FrontEnd.
		 */
		public function idmuvi_core_jscript() {

			if ( wp_script_is( 'idmuvi_ajax_search', 'done' ) ) {

				echo '<script type=\'text/javascript\'>';
				echo '
					var $ = jQuery.noConflict();
					(function( $ ) {
						"use strict";
						jQuery(function($) {

							var search_loader_url = mvpro_ajaxsearch_params.loading;

							$(\'#s\').autocomplete({
								minChars: 3,
								appendTo: \'.gmr-searchform\',
								serviceUrl: mvpro_ajaxsearch_params.ajax_url + \'?action=muvipro_core_ajax_search_movie\',
								onSearchStart: function(){
									$(this).css(\'background\', \'url(\'+search_loader_url+\') no-repeat right center\');
								},
								onSearchComplete: function(){
									$(this).css(\'background\', \'transparent\');
								},
								onSelect: function (suggestion) {
									if( suggestion.id != -1 ) {
										window.location.href = suggestion.url;
									}
								}
							});
						});
					})(jQuery);';
				echo '</script>';

			}
			$idmuv_other = get_option( 'idmuv_other' );
			if ( isset( $idmuv_other['other_analytics_code'] ) && ! empty( $idmuv_other['other_analytics_code'] ) ) {
				echo '<!-- Google analytics -->
				<script>
					  window.dataLayer = window.dataLayer || [];
					  function gtag(){dataLayer.push(arguments);}
					  gtag(\'js\', new Date());

					  gtag(\'config\', \'' . esc_attr( $idmuv_other['other_analytics_code'] ) . '\');
				</script>';
			}
			/*
			$idmuv_ads = get_option( 'idmuv_ads' );
			if ( isset( $idmuv_ads['ads_banner_player'] ) && ! empty( $idmuv_ads['ads_banner_player'] ) ) {
				if ( is_single() ) {
					echo '<script type="text/javascript">
						function removeidplayer() {
							var x = document.getElementById("idbannerplayer");
							if(typeof x !== \'undefined\' && x !== null) {
								if (x.style.display === "none") {
									x.style.display = "block";
								} else {
									x.style.display = "none";
								}
							}
						}
						var seconds = "5";
						function DelayRedirect(){
							var x = document.getElementById("timeloading");
							if(typeof x !== \'undefined\' && x !== null) {
								if ( seconds <= 0 ) {
									x.innerHTML = \'<button id="timeloading-button" onclick="removeidplayer()">' . esc_html__( 'Play Now', 'dlpro' ) . '</button>\';
								} else {
									seconds--;
									x.innerHTML = \'<div id="timeloading-wrap">\' + seconds + \'' . esc_html__( ' Wait Time', 'dlpro' ) . '</div>\';
									setTimeout("DelayRedirect()", 1000);
								}
							}
						}
						window.onload = function () {
							DelayRedirect();
						}
					</script>';
				}
			}
			*/
		}
	}
}


if ( class_exists( 'Idmuvi_Core_Init' ) ) {
	// Installation and uninstallation hooks.
	register_activation_hook( __FILE__, array( 'Idmuvi_Core_Init', 'idmuvi_core_activate' ) );
	register_deactivation_hook( __FILE__, array( 'Idmuvi_Core_Init', 'idmuvi_core_deactivate' ) );

	// Initialise Class.
	$idmuvi_core_init_by_gianmr = new Idmuvi_Core_Init();

}
