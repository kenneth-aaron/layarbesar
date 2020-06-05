<?php
/*
Plugin Name: Idmuvi Core
Plugin URI: http://www.idtheme.com
Description: Idmuvi Core - Add functionally to movie theme for easy maintenance. This plugin using only for theme with movie type from idtheme.com
Author: Gian Mokhammad R
Version: 1.1.5
Author URI: http://www.gianmr.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*----------------------------------------------------------------------------------------------------------
    Main Plugin Class
-----------------------------------------------------------------------------------------------------------*/

if( !class_exists( 'Idmuvi_Core_Init' ) ) {

    class Idmuvi_Core_Init {

		/**
		 * Contract
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function __construct() {
			// Define
			define( 'IDMUVI_CORE_VER', '1.1.3' );
			define( 'IDMUVI_CORE_DIRNAME', plugin_dir_path( __FILE__ ) );
			define( 'IDMUVI_CORE_URL', plugin_dir_url( __FILE__ ) );
			
			// this is the URL our updater / license checker pings. This should be the URL of the site
			define( 'IDMUVI_API_URL_CHECK', 'http://member.kentooz.com/softsale/api/check-license' );
			define( 'IDMUVI_API_URL', 'http://member.kentooz.com/softsale/api/activate' );
			define( 'IDMUVI_API_URL_DEACTIVATED', 'http://member.kentooz.com/softsale/api/deactivate' );

			// the name of the settings page for the license input to be displayed
			define( 'IDMUVI_PLUGIN_LICENSE_PAGE', 'muvipro-license' );
			
			// Include widget
			include_once  IDMUVI_CORE_DIRNAME . 'widgets/aweber-widget.php';
			include_once  IDMUVI_CORE_DIRNAME . 'widgets/feedburner-widget.php';
			include_once  IDMUVI_CORE_DIRNAME . 'widgets/getresponse-widget.php';
			include_once  IDMUVI_CORE_DIRNAME . 'widgets/mailchimp-widget.php';
			include_once  IDMUVI_CORE_DIRNAME . 'widgets/custom-form-widget.php';
			include_once  IDMUVI_CORE_DIRNAME . 'widgets/recent-posts-widget.php';
			include_once  IDMUVI_CORE_DIRNAME . 'widgets/search-widget.php';
			
			include_once  IDMUVI_CORE_DIRNAME . 'lib/external/class.settings-api.php';

			// Include library
			include_once  IDMUVI_CORE_DIRNAME . 'lib/breadcrumbs.php';
			include_once  IDMUVI_CORE_DIRNAME . 'lib/banner.php';
			include_once  IDMUVI_CORE_DIRNAME . 'lib/share.php';
			include_once  IDMUVI_CORE_DIRNAME . 'lib/relatedpost.php';
			include_once  IDMUVI_CORE_DIRNAME . 'lib/headfooterscript.php';
			include_once  IDMUVI_CORE_DIRNAME . 'lib/jetpack.php';
			include_once  IDMUVI_CORE_DIRNAME . 'lib/opengraph.php';
			include_once  IDMUVI_CORE_DIRNAME . 'lib/faster.php';
			
			$idmuv_other = get_option( 'idmuv_other' );

			if ( isset ( $idmuv_other['other_remove_thumbphp'] ) && $idmuv_other['other_remove_thumbphp'] != '' ) {
				// option, section, default
				$option = $idmuv_other['other_remove_thumbphp'];
			} else {
				$option = 'off';
			}

			// Auto thumbnail, if you no need and your resource high, please disable it.
			if ( $option != 'on' ) {
				include_once  IDMUVI_CORE_DIRNAME . 'lib/thumb.php';
			}
			
			$idmuv_ajax = get_option( 'idmuv_ajax' );
			
			if ( isset ( $idmuv_ajax['enable_ajax_search'] ) && $idmuv_ajax['enable_ajax_search'] != '' ) {
				// option, section, default
				$option_search_ajax = $idmuv_ajax['enable_ajax_search'];
			} else {
				$option_search_ajax = 'off';
			}
			
			if ( $option_search_ajax == 'on' ) {
				include_once  IDMUVI_CORE_DIRNAME . 'lib/ajax_search.php';
			}
			
			// Include Movie Custom
			include_once  IDMUVI_CORE_DIRNAME . 'lib/movie/movie.php';
			
			// Include Custom Post type
			include_once  IDMUVI_CORE_DIRNAME . 'lib/blog/blog.cpt.php';
			
			// Include Amember HTTP API
			// Load only if dashboard
			if ( is_admin() ) {
				include_once  IDMUVI_CORE_DIRNAME . 'lib/amember_http_api.php';
			}
			
			// Action
			add_action( 'plugins_loaded', array( $this, 'idmuvi_core_load_textdomain' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'wp_footer', array( $this, 'idmuvi_core_jscript' ), 20 );
			add_action( 'wp_head', array( $this, 'idmuvi_core_headjs' ), 20 );
			
			// Enable the use of shortcodes in text widgets.
			add_filter( 'widget_text', 'do_shortcode' );
			
			$idmuv_social = get_option( 'idmuv_social' );
			
            if ( isset ( $idmuv_social['enable_fb_comment'] ) && $idmuv_social['enable_fb_comment'] != '' ) {
				// option, section, default
                $option = $idmuv_social['enable_fb_comment'];
            } else {
                $option = 'off';
            }
			
			// if option on then using fb comment
			if ( $option == 'on' ) {
				add_filter( 'comments_template', array( $this, 'fb_comments_template' ), 20 );
			}
			
			$status = trim( get_option( 'idmuvi_core_license_status' ) );
			
			if( $status == 'ok' ) {
				include_once  IDMUVI_CORE_DIRNAME . 'lib/z_setting.idmuvi-core.php';
				// Other functionally
				include_once  IDMUVI_CORE_DIRNAME . 'lib/update/plugin-update-checker.php';
				$MyUpdateChecker = PucFactory::buildUpdateChecker(
					'http://www.kentooz.com/files/idmuvi-core/idmuvisenseiformovie.json',
					__FILE__,
					'idmuvi-core'
				);
			} else {
				include_once  IDMUVI_CORE_DIRNAME . 'lib/z_license.idmuvi-core.php';
			}
			
		}
		
		/**
		 * Activated plugin
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public static function idmuvi_core_activate() {
			// nothing to do yet
		}

		/**
		 * Deativated plugin
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public static function idmuvi_core_deactivate() {
			// nothing to do yet
		}
		
		/**
		 * Fb comment
		 *
		 * @since 1.0.2
		 * @access public
		 */
		public function fb_comments_template() {
			return IDMUVI_CORE_DIRNAME . 'lib/fb-comment.php';
		}
		
		/**
		 * Enqueue assets
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function register_scripts() {
			
			$idmuv_ads = get_option( 'idmuv_ads' );
			
            if ( isset ( $idmuv_ads['ads_enable_antiadblock'] ) && $idmuv_ads['ads_enable_antiadblock'] != '' ) {
				// option, section, default
                $option = $idmuv_ads['ads_enable_antiadblock'];
            } else {
                $option = 'off';
            }
			
			if ( !is_single() ) {
			
				$idmuv_ajax = get_option( 'idmuv_ajax' );
				
				if ( isset ( $idmuv_ajax['enable_ajax_navigation'] ) && $idmuv_ajax['enable_ajax_navigation'] != '' ) {
					// option, section, default
					$option_ajax = $idmuv_ajax['enable_ajax_navigation'];
				} else {
					$option_ajax = 'off';
				}
				if ( $option_ajax == 'on' ) {
					
					if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
						// If jetpack enable, disable this feature
					} else {
					
						if ( isset ( $idmuv_ajax['ajax_navigation_type'] ) && $idmuv_ajax['ajax_navigation_type'] == 'infinite' ) {
							$type = 'infinite';
						} elseif ( isset ( $idmuv_ajax['ajax_navigation_type'] ) && $idmuv_ajax['ajax_navigation_type'] == 'more' ) {
							$type = 'more';
						} else {
							$type = 'infinite';
						}
						
						wp_enqueue_script( 'gmr-ajax-loadmore-lib', IDMUVI_CORE_URL . 'js/jquery-ajax-loadmore.js', array('jquery'),false,true);
						wp_enqueue_script( 'gmr-ajax-loadmore', IDMUVI_CORE_URL . 'js/ajax-loadmore.js', array('jquery','gmr-ajax-loadmore-lib'),false,true);
						wp_localize_script( 'gmr-ajax-loadmore', 'gmr_infiniteload', 
							array(
								'navSelector' => '.site-main .page-numbers',
								'contentSelector' => '#gmr-main-load',
								'nextSelector' => '.site-main .page-numbers .next',
								'itemSelector' => '.item',
								'paginationType' => $type,
								'loadingImage' => IDMUVI_CORE_URL . 'img/loader.gif',
								'loadingText' => __('Movie data loaded. Wait a second.','idmuvi-core'),
								'loadingButtonLabel' => __('Load More','idmuvi-core'),
								'loadingButtonClass' => '',
								'loadingFinishedText' => __('No more movie.','idmuvi-core')
							) 
						);
					}
				}
			
			}
			
			wp_register_script( 'idmuvi_adblock', IDMUVI_CORE_URL . 'js/fuckadblock.js', array( 'jquery' ), '', true );
			wp_register_script( 'idmuvi_ajax_search', IDMUVI_CORE_URL . 'js/jquery-autocomplete-min.js', array( 'jquery' ), '', true );
			
			wp_register_style( 'idmuvi-core', IDMUVI_CORE_URL . 'css/idmuvi-core.css' );
			wp_enqueue_style( 'idmuvi-core' );
			if ( $option == 'on' ) {
				wp_enqueue_script( 'idmuvi_adblock' );
			}
			
			$idmuv_ajax = get_option( 'idmuv_ajax' );
			
			if ( isset ( $idmuv_ajax['enable_ajax_search'] ) && $idmuv_ajax['enable_ajax_search'] != '' ) {
				// option, section, default
				$option_search_ajax = $idmuv_ajax['enable_ajax_search'];
			} else {
				$option_search_ajax = 'off';
			}
			
			if ( $option_search_ajax == 'on' ) {
			
				wp_enqueue_script( 'idmuvi_ajax_search' );
				wp_localize_script( 'idmuvi_ajax_search', 'mvpro_ajaxsearch_params', array(
					'loading' => IDMUVI_CORE_URL . 'img/ajax-loader.gif',
					'ajax_url' => admin_url( 'admin-ajax.php' )
				));
			
			}
			
		}
		
		/**
		 * Load languange
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function idmuvi_core_load_textdomain() {
			load_plugin_textdomain( 'idmuvi-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
			/* 
			 * class_exists on plugin working if using plugins_loaded filter
			 * Most view widget exist if wp postview plugin installed
			 */
			if( class_exists( 'WP_Widget_PostViews' ) ) {
				include_once  IDMUVI_CORE_DIRNAME . 'widgets/mostview-posts-widget.php';
			}
		}
		
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
									$(this).css(\'background\', \'#f8f8f8\');
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
			
			if ( wp_script_is( 'idmuvi_adblock', 'done' ) ) {
				
				$idmuv_ads = get_option( 'idmuv_ads' );
				
				if ( isset ( $idmuv_ads['ads_antiadblock_message'] ) && $idmuv_ads['ads_antiadblock_message'] != '' ) {
					// option, section, default
					$message = do_shortcode(htmlspecialchars_decode( $idmuv_ads['ads_antiadblock_message'] ));
				} else {
					$message = __( 'Please disable your adblock for read our content.','idmuvi-core' );
				}
				
				echo '<div id="idmuvi-adb-enabled" class="gmr-hidden"><div id="id-overlay-box">'. $message .'<div><a href="" class="button refresh-button" rel="noindex" title="'. __('Refresh','idmuvi-core') .'">'. __('Refresh','idmuvi-core') .'</a></div></div></div>';
				
				echo '<script type=\'text/javascript\'>';
				echo '
						var adBlockDetected = function() {
							$(\'#idmuvi-adb-enabled\').addClass(\'gmr-hidden\');
						}
						var adBlockUndetected = function() {
							$(\'#idmuvi-adb-enabled\').removeClass(\'gmr-hidden\');
						}
						
						if(typeof FuckAdBlock === \'undefined\') {
							$(document).ready(adBlockDetected);
						} else {
							var myFuckAdBlock = new FuckAdBlock;
							myFuckAdBlock.on(true, adBlockDetected).on(false, adBlockUndetected);
						}
					';
				echo '</script>';
			}
		}
		
		public function idmuvi_core_headjs() {
			$idmuv_ads = get_option( 'idmuv_ads' );
			
			if ( isset ( $idmuv_ads['ads_enable_antiadblock'] ) && $idmuv_ads['ads_enable_antiadblock'] != '' ) {
				// option, section, default
				$option = $idmuv_ads['ads_enable_antiadblock'];
			} else {
				$option = 'off';
			}
				
			if ( $option == 'on' ) {
				echo '<script type=\'text/javascript\'>var fuckAdBlock = false, FuckAdBlock = undefined;</script>';
			}

		}

    }
}


if( class_exists( 'Idmuvi_Core_Init' ) ) {

    // Installation and uninstallation hooks
    register_activation_hook( __FILE__, array( 'Idmuvi_Core_Init', 'idmuvi_core_activate' ) );
    register_deactivation_hook( __FILE__, array( 'Idmuvi_Core_Init', 'idmuvi_core_deactivate' ) );

    // Initialise Class
    $idmuvi_core_init_by_gianmr = new Idmuvi_Core_Init();
	
}