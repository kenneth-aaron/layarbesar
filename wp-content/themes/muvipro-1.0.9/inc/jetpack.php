<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'gmr_jetpack_setup' ) ) :
	/**
	 * Jetpack setup function.
	 *
	 * @since 1.0.0
	 *
	 * See: https://jetpack.com/support/infinite-scroll/
	 * See: https://jetpack.com/support/responsive-videos/
	 */
	function gmr_jetpack_setup() {
		// Add theme support for Infinite Scroll.
		add_theme_support( 'infinite-scroll', array(
			'container' => 'gmr-main-load',
			'render'    => 'gmr_infinite_scroll_render',
			'footer'    => false,
			'wrapper'   => false,
			'posts_per_page' => 10,
		) );
	}
endif; // endif gmr_jetpack_setup
add_action( 'after_setup_theme', 'gmr_jetpack_setup' );

if ( ! function_exists( 'gmr_infinite_scroll_render' ) ) :
	/**
	 * Custom render function for Infinite Scroll.
	 *
	 * @since 1.0.0
	 */
	function gmr_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', get_post_format() );
		}
	}
endif; // endif gmr_infinite_scroll_render

if ( !function_exists( 'gmr_custom_infinite_support' ) ) :
	/**
	 * Support infinite scroll only on post type "post" other post type return false
	 *
	 * @since  1.0.0
	 * 
	 * @return bool
	 */
	function gmr_custom_infinite_support() {
		$supported = current_theme_supports( 'infinite-scroll' ) &&  in_array(get_post_type(), array('tv','post'));
		 
		return $supported;
	}
endif; // endif gmr_custom_infinite_support
add_filter( 'infinite_scroll_archive_supported', 'gmr_custom_infinite_support' );

if ( !function_exists( 'gmr_change_infinite_scroll_click_button_text' ) ) :
	/**
	 * Change default jetpack infinite text button
	 *
	 * @since  1.0.0
	 * 
	 * @return string
	 */
	function gmr_change_infinite_scroll_click_button_text( $js_settings ) {
		$js_settings['text'] = esc_js( __( 'Load more...', 'muvipro') );
		return $js_settings;
	}
endif; // endif gmr_change_infinite_scroll_click_button_text
add_filter( 'infinite_scroll_js_settings', 'gmr_change_infinite_scroll_click_button_text', 10, 1 );