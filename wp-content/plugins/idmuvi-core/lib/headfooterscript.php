<?php
/**
 * Displaying function for head and footer section
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package Idmuvi Core
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'idmuvi_core_head_script' ) ) :
	/**
	 * Insert script in head section
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_head_script() {
		$idmuv_other = get_option( 'idmuv_other' );
		if ( isset( $idmuv_other['other_head_script'] ) && ! empty( $idmuv_other['other_head_script'] ) ) {
			echo htmlspecialchars_decode( $idmuv_other['other_head_script'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif; // endif idmuvi_core_head_script.
add_action( 'wp_head', 'idmuvi_core_head_script' );

if ( ! function_exists( 'idmuvi_core_footer_script' ) ) :
	/**
	 * Insert script in footer section
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_footer_script() {
		$idmuv_other = get_option( 'idmuv_other' );
		if ( isset( $idmuv_other['other_footer_script'] ) && ! empty( $idmuv_other['other_footer_script'] ) ) {
			echo htmlspecialchars_decode( $idmuv_other['other_footer_script'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif; // endif idmuvi_core_footer_script.
add_action( 'wp_footer', 'idmuvi_core_footer_script' );

if ( ! function_exists( 'idmuvi_core_facebook_pixel' ) ) :
	/**
	 * Insert facebook pixel script via wp_head hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_facebook_pixel() {
		$idmuv_other = get_option( 'idmuv_other' );
		if ( isset( $idmuv_other['other_fbpixel_id'] ) && ! empty( $idmuv_other['other_fbpixel_id'] ) ) {
			echo '
			<!-- Facebook Pixel -->
			<script>
			!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			n.push=n;n.loaded=!0;n.version=\'2.0\';n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
			document,\'script\',\'https://connect.facebook.net/en_US/fbevents.js\');

			fbq(\'init\', \'' . esc_attr( $idmuv_other['other_fbpixel_id'] ) . '\');
			fbq(\'track\', "PageView");</script>
			<noscript><img height="1" width="1" style="display:none"
			src="https://www.facebook.com/tr?id=' . esc_attr( $idmuv_other['other_fbpixel_id'] ) . '&ev=PageView&noscript=1"
			/></noscript>';
		}
	}
endif; // endif idmuvi_core_facebook_pixel.
add_action( 'wp_head', 'idmuvi_core_facebook_pixel', 10 );
