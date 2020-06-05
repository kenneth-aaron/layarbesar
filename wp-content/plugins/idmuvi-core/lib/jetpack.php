<?php
/**
 * Jetpack Functionally
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

if ( ! function_exists( 'idmuvi_core_remove_jetpack_rp' ) ) :
	/**
	 * Remove jetpack related post and we use functionally using shortcode
	 *
	 * @since 1.0.0
	 * @link https://jetpack.com/support/related-posts/customize-related-posts/#delete
	 */
	function idmuvi_core_remove_jetpack_rp() {
		if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
			$jprp     = Jetpack_RelatedPosts::init();
			$callback = array( $jprp, 'filter_add_target_to_dom' );
			remove_filter( 'the_content', $callback, 40 );
		}
	}
endif; // endif idmuvi_core_remove_jetpack_rp.
add_filter( 'wp', 'idmuvi_core_remove_jetpack_rp', 20 );

if ( ! function_exists( 'idmuvi_core_remove_jetpack_share' ) ) :
	/**
	 * Remove jetpack sharing and we use functionally using add manually via plugin
	 *
	 * @since 1.0.0
	 * @link https://jetpack.com/2013/06/10/moving-sharing-icons/
	 */
	function idmuvi_core_remove_jetpack_share() {
		remove_filter( 'the_content', 'sharing_display', 19 );
		remove_filter( 'the_excerpt', 'sharing_display', 19 );
		if ( class_exists( 'Jetpack_Likes' ) ) {
			remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
		}
	}
endif; // endif idmuvi_core_remove_jetpack_share.
add_action( 'loop_start', 'idmuvi_core_remove_jetpack_share' );
