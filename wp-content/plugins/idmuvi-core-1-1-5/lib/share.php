<?php
/*
 * Social share fearures.
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package Idmuvi Core
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !function_exists( 'idmuvi_core_share_default' ) ) :
	/**
	 * Insert social share from plugin
	 *
	 * @since 1.0.0
	 * @return string @output
	 */
	function idmuvi_core_share_default( $output = null ) {
		
		$idmuv_social = get_option( 'idmuv_social' );
		
		if ( isset ( $idmuv_social['enable_socialshare'] ) && $idmuv_social['enable_socialshare'] != '' ) {
			// option, section, default
			$option = $idmuv_social['enable_socialshare'];
		} else {
			$option = 'on';
		}
		
		if ( $option == 'on' ) {
		
			$FilterTitle = str_replace( ' ', '%20', get_the_title());
			$output = '';
			$output .= '<div class="idmuvi-social-share">';
			$output .= '<ul class="idmuvi-socialicon-share">';
				$output .= '<li class="facebook">';
					$output .= '<a href="#" class="idmuvi-sharebtn idmuvi-facebook" onclick="popUp=window.open(\'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink() . '\', \'popupwindow\', \'scrollbars=yes,height=300,width=550\');popUp.focus();return false" rel="nofollow" title="' . __( 'Share this', 'idmuvi-core' ) . '">';
						$output .= __( 'Sharer', 'idmuvi-core' );
					$output .= '</a>';
				$output .= '</li>';
				$output .= '<li class="twitter">';
					$output .= '<a href="#" class="idmuvi-sharebtn idmuvi-twitter" onclick="popUp=window.open(\'https://twitter.com/share?url=' . get_the_permalink() . '&amp;text=' . $FilterTitle . '\', \'popupwindow\', \'scrollbars=yes,height=300,width=550\');popUp.focus();return false" rel="nofollow" title="' . __( 'Tweet this', 'idmuvi-core' ) . '">';
						$output .= __( 'Tweet', 'idmuvi-core' );
					$output .= '</a>';
				$output .= '</li>';
				$output .= '<li class="google">';
					$output .= '<a href="#" class="idmuvi-sharebtn idmuvi-gplus" onclick="popUp=window.open(\'https://plus.google.com/share?url=' . get_the_permalink() . '\', \'popupwindow\', \'scrollbars=yes,height=300,width=550\');popUp.focus();return false" rel="nofollow" title="' . __( 'Share this', 'idmuvi-core' ) . '">';
						$output .= __( 'Add +1', 'idmuvi-core' );
					$output .= '</a>';
				$output .= '</li>';
			$output .= '</ul>';
			$output .= '</div>';
		
		}

		return $output;
		
	}
endif; // endif idmuvi_core_share_default

if ( !function_exists( 'idmuvi_core_share_jetpack' ) ) :
	function idmuvi_core_share_jetpack() {
		if ( function_exists( 'sharing_display' ) ) {
			$share = sharing_display( '', false );
		} else {
			$share = idmuvi_core_share_default();
		}
		 
		if ( class_exists( 'Jetpack_Likes' ) ) {
			$custom_likes = new Jetpack_Likes;
			$share = $custom_likes->post_likes( '' );
		}
		return $share;
	}
endif; // endif idmuvi_core_share_jetpack

if ( !function_exists( 'idmuvi_core_add_share_the_content' ) ) :
	/**
	 * Insert content after box content single
	 *
	 * @since 1.0.0
	 * @link https://jetpack.com/support/related-posts/customize-related-posts/#delete
	 * @return void
	 */
	function idmuvi_core_add_share_the_content( $content ) {
		if( is_single() && in_the_loop() ) {
			$content = $content . idmuvi_core_share_jetpack();
		}
		return $content;
	}
endif; // endif idmuvi_core_add_share_the_content
add_filter( 'the_content', 'idmuvi_core_add_share_the_content', 30 );

if ( !function_exists( 'idmuvi_core_share_action' ) ) :
	/**
	 * Add action for share display
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_share_action() {
		echo idmuvi_core_share_jetpack();
	}
endif;
add_action( 'idmuvi_core_share_action', 'idmuvi_core_share_action' ,5 );