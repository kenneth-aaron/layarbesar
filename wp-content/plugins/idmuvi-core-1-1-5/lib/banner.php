<?php
/*
 * Banner features
 *
 * Author: Gian MR - http://www.gianmr.com
 * 
 * @since 1.0.0
 * @package Idmuvi Core
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !function_exists( 'idmuvi_core_top_banner' ) ) {

	/**
	 * Adding banner at top via hook
	 *
	 * @since 1.0.0
	 * @return string
	 */
    function idmuvi_core_top_banner() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_topbanner'] ) && !empty ( $idmuv_ads['ads_topbanner'] ) ) {
			echo '<div class="idmuvi-topbanner">';
				echo '<div class="container">';
					echo do_shortcode( $idmuv_ads['ads_topbanner'] );
				echo '</div>';
			echo '</div>';
		}
	}
}
add_action( 'idmuvi_core_top_banner', 'idmuvi_core_top_banner', 10 );

if( !function_exists( 'idmuvi_core_top_banner_after_menu' ) ) {

	/**
	 * Adding banner at top via hook
	 *
	 * @since 1.0.0
	 * @return string
	 */
    function idmuvi_core_top_banner_after_menu() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_topbanner_aftermenu'] ) && !empty ( $idmuv_ads['ads_topbanner_aftermenu'] ) ) {
			echo '<div class="container">';
				echo '<div class="idmuvi-topbanner-aftermenu">';
				echo do_shortcode( $idmuv_ads['ads_topbanner_aftermenu'] );
				echo '</div>';
			echo '</div>';
		}
	}
}
add_action( 'idmuvi_core_top_banner_after_menu', 'idmuvi_core_top_banner_after_menu', 10 );

if( !function_exists( 'idmuvi_core_banner_before_content' ) ) {

	/**
	 * Adding banner at before content via hook
	 *
	 * @since 1.0.0
	 * @return string
	 */
    function idmuvi_core_banner_before_content() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_before_content'] ) && !empty ( $idmuv_ads['ads_before_content'] ) ) {
			if ( isset ( $idmuv_ads['ads_before_content_position'] ) && $idmuv_ads['ads_before_content_position'] == 'left' ) {
				$class = ' pull-left';
			} elseif ( isset ( $idmuv_ads['ads_before_content_position'] ) && $idmuv_ads['ads_before_content_position'] == 'right' ) {
				$class = ' pull-right';
			} elseif ( isset ( $idmuv_ads['ads_before_content_position'] ) && $idmuv_ads['ads_before_content_position'] == 'center' ) {
				$class = ' idmuvi-center-ads';
			} else {
				$class = '';
			}
			echo '<div class="idmuvi-banner-beforecontent'.$class.'">';
			echo do_shortcode( $idmuv_ads['ads_before_content'] );
			echo '</div>';
		}
	}
}

if ( !function_exists( 'idmuvi_core_add_banner_before_content' ) ) :
	/**
	 * Insert content after box content single
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function idmuvi_core_add_banner_before_content( $content ) {
		if( is_singular(array( 'post', 'tv', 'episode', 'blogs' )) && in_the_loop() ) {
			$content = idmuvi_core_banner_before_content() . $content;
		}
		return $content;
	}
endif; // endif idmuvi_core_add_banner_before_content
add_filter( 'the_content', 'idmuvi_core_add_banner_before_content', 30, 1 );

if( !function_exists( 'idmuvi_core_banner_after_content' ) ) {

	/**
	 * Adding banner at before content via hook
	 *
	 * @since 1.0.0
	 * @return string
	 */
    function idmuvi_core_banner_after_content() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		$banner = '';
		if ( isset ( $idmuv_ads['ads_after_content'] ) && !empty ( $idmuv_ads['ads_after_content'] ) ) {
			if ( isset ( $idmuv_ads['ads_after_content_position'] ) && $idmuv_ads['ads_after_content_position'] == 'right' ) {
				$class = ' idmuvi-center-right';
			} elseif ( isset ( $idmuv_ads['ads_after_content_position'] ) && $idmuv_ads['ads_after_content_position'] == 'center' ) {
				$class = ' idmuvi-center-ads';
			} else {
				$class = '';
			}
			$banner .= '<div class="idmuvi-banner-aftercontent'.$class.'">';
			$banner .= do_shortcode( $idmuv_ads['ads_after_content'] );
			$banner .= '</div>';
		}
		return $banner;
	}
}

if ( !function_exists( 'idmuvi_core_add_banner_after_content' ) ) :
	/**
	 * Insert content after box content single
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function idmuvi_core_add_banner_after_content( $content ) {
		if( is_singular(array( 'post', 'tv', 'episode', 'blogs' )) && in_the_loop() ) {
			$content = $content . idmuvi_core_banner_after_content();
		}
		return $content;
	}
endif; // endif idmuvi_core_add_banner_after_content
add_filter( 'the_content', 'idmuvi_core_add_banner_after_content', 30 );

if ( !function_exists( 'idmuvi_core_helper_after_paragraph' ) ) :
	/**
	 * Helper add content after paragprah
	 *
	 * @since 1.0.0
	 * @link http://stackoverflow.com/questions/25888630/place-ads-in-between-text-only-paragraphs
	 * @return string
	 */
	function idmuvi_core_helper_after_paragraph( $insertion, $paragraph_id, $content ) { 
		if( is_singular(array( 'post', 'tv', 'episode', 'blogs' )) && in_the_loop() ) {
			
			$closing_p = '</p>';
			$paragraphs = explode( $closing_p, wptexturize($content) );
			$count = count( $paragraphs );
			
			foreach ( $paragraphs as $index => $paragraph ) { 
				$word_count = count(explode(' ', $paragraph));
				if ( trim( $paragraph ) && $paragraph_id == $index + 1 ) {
					$paragraphs[$index] .= $closing_p; 
				} 
				if ( $paragraph_id == $index + 1 && $count >= 4 ) {
					$paragraphs[$index] .= $insertion; 
				}
			}
		}
		return implode( '', $paragraphs ); 
	}
endif; // endif idmuvi_core_helper_after_paragraph

if ( !function_exists( 'idmuvi_core_add_banner_inside_content' ) ) :
	/**
	 * Insert content inside content single
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function idmuvi_core_add_banner_inside_content( $content ) {
		$idmuv_ads = get_option( 'idmuv_ads' );
		if ( isset ( $idmuv_ads['ads_inside_content'] ) && !empty ( $idmuv_ads['ads_inside_content'] ) ) {
			if ( isset ( $idmuv_ads['ads_inside_content_position'] ) && $idmuv_ads['ads_inside_content_position'] == 'right' ) {
				$class = ' idmuvi-center-right';
			} elseif ( isset ( $idmuv_ads['ads_inside_content_position'] ) && $idmuv_ads['ads_inside_content_position'] == 'center' ) {
				$class = ' idmuvi-center-ads';
			} else {
				$class = '';
			}
			$ad_code = '<div class="idmuvi-banner-insidecontent'.$class.'">' . do_shortcode( $idmuv_ads['ads_inside_content'] ) . '</div>'; 
			if( is_singular(array( 'post', 'tv', 'episode', 'blogs' )) && in_the_loop() ) {
				return idmuvi_core_helper_after_paragraph( $ad_code, 2, $content ); 
			} 
		}
		return $content; 
	}
endif; // endif idmuvi_core_add_banner_inside_content
add_filter( 'the_content', 'idmuvi_core_add_banner_inside_content' ); 

if( !function_exists( 'idmuvi_core_floating_banner_left' ) ) {

	/**
	 * Adding banner at top via hook
	 *
	 * @since 1.0.0
	 * @return string
	 */
    function idmuvi_core_floating_banner_left() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_floatbanner_left'] ) && !empty ( $idmuv_ads['ads_floatbanner_left'] ) ) {
			echo '<div class="idmuvi-floatbanner idmuvi-floatbanner-left">';
			echo '<button onclick="parentNode.remove()" title="' . __( 'close','idmuvi-core' ) . '">' . __( 'close','idmuvi-core' ) . '</button>';
			echo do_shortcode( $idmuv_ads['ads_floatbanner_left'] );
			echo '</div>';
		}
	}
}
add_action( 'idmuvi_core_floating_footer', 'idmuvi_core_floating_banner_left', 10 );

if( !function_exists( 'idmuvi_core_floating_banner_right' ) ) {

	/**
	 * Adding floating banner
	 *
	 * @since 1.0.0
	 * @return string
	 */
    function idmuvi_core_floating_banner_right() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_floatbanner_right'] ) && !empty ( $idmuv_ads['ads_floatbanner_right'] ) ) {
			echo '<div class="idmuvi-floatbanner idmuvi-floatbanner-right">';
			echo '<button onclick="parentNode.remove()" title="' . __( 'close','idmuvi-core' ) . '">' . __( 'close','idmuvi-core' ) . '</button>';
			echo do_shortcode( $idmuv_ads['ads_floatbanner_right'] );
			echo '</div>';
		}
	}
}
add_action( 'idmuvi_core_floating_footer', 'idmuvi_core_floating_banner_right', 15 );

if( !function_exists( 'idmuvi_core_floating_banner_footer' ) ) {

	/**
	 * Adding floating banner
	 *
	 * @since 1.0.0
	 * @return string
	 */
    function idmuvi_core_floating_banner_footer() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_floatbanner_footer'] ) && !empty ( $idmuv_ads['ads_floatbanner_footer'] ) ) {

			echo '<div class="idmuvi-floatbanner idmuvi-floatbanner-footer">';
				echo '<div class="container">';
					echo '<div class="inner-floatbanner-bottom">';
					echo '<button onclick="parentNode.remove()" title="' . __( 'close','idmuvi-core' ) . '">' . __( 'close','idmuvi-core' ) . '</button>';
					echo do_shortcode( $idmuv_ads['ads_floatbanner_footer'] );
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}
	}
}
add_action( 'idmuvi_core_floating_footer', 'idmuvi_core_floating_banner_footer', 20 );

if( !function_exists( 'idmuvi_core_banner_footer' ) ) {

	/**
	 * Adding banner at footer via hook
	 *
	 * @since 1.0.0
	 * @return string
	 */
    function idmuvi_core_banner_footer() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_footerbanner'] ) && !empty ( $idmuv_ads['ads_footerbanner'] ) ) {
			echo '<div class="container">';
				echo '<div class="idmuvi-footerbanner">';
				echo do_shortcode( $idmuv_ads['ads_footerbanner'] );
				echo '</div>';
			echo '</div>';
		}
	}
}
add_action( 'idmuvi_core_banner_footer', 'idmuvi_core_banner_footer', 10 );

if( !function_exists( 'idmuvi_core_topbanner_archive' ) ) {

	/**
	 * Adding top banner in archive page
	 *
	 * @since 1.0.0
	 * @return string
	 */
    function idmuvi_core_topbanner_archive() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_topbanner_archive'] ) && !empty ( $idmuv_ads['ads_topbanner_archive'] ) ) {
				echo '<div class="idmuvi-topbanner-archive">';
				echo do_shortcode( $idmuv_ads['ads_topbanner_archive'] );
				echo '</div>';
		}
	}
}
add_action( 'idmuvi_core_topbanner_archive', 'idmuvi_core_topbanner_archive', 10 );

if( !function_exists( 'idmuvi_core_top_player' ) ) {

	/**
	 * Adding banner at top player
	 *
	 * @since 1.0.4
	 * @return string
	 */
    function idmuvi_core_top_player() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_topplayer'] ) && !empty ( $idmuv_ads['ads_topplayer'] ) ) {
			echo '<div class="idmuvi-topplayer">';
			echo do_shortcode( $idmuv_ads['ads_topplayer'] );
			echo '</div>';
		}
	}
}
add_action( 'idmuvi_core_top_player', 'idmuvi_core_top_player', 10 );

if( !function_exists( 'idmuvi_core_after_player' ) ) {

	/**
	 * Adding banner at top player
	 *
	 * @since 1.0.4
	 * @return string
	 */
    function idmuvi_core_after_player() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_afterplayer'] ) && !empty ( $idmuv_ads['ads_afterplayer'] ) ) {
			echo '<div class="idmuvi-afterplayer">';
			echo do_shortcode( $idmuv_ads['ads_afterplayer'] );
			echo '</div>';
		}
	}
}
add_action( 'idmuvi_core_after_player', 'idmuvi_core_after_player', 10 );

if( !function_exists( 'idmuvi_core_popup_banner' ) ) {

	/**
	 * Adding popup banner
	 *
	 * @since 1.0.5
	 * @return string
	 */
    function idmuvi_core_popup_banner() {
		$idmuv_ads = get_option( 'idmuv_ads' );
		
		if ( isset ( $idmuv_ads['ads_popupbanner'] ) && !empty ( $idmuv_ads['ads_popupbanner'] ) ) {
			echo '<div id="idmuvi-popup" class="white-popup-block mfp-hide">';
			echo do_shortcode( $idmuv_ads['ads_popupbanner'] );
			echo '</div>';
			echo '<script type=\'text/javascript\'>';
			echo '
				var $ = jQuery.noConflict();
				(function( $ ) {
					"use strict";
					jQuery(function($) {
						$(window).load(function () {
							setTimeout(function() {
								$.magnificPopup.open({
									items: {
										src: \'#idmuvi-popup\'
									},
									mainClass: \'mfp-img-mobile mfp-no-margins mfp-with-zoom\',
									type: \'inline\'
								});
							}, 3000);
						});
					});
				})(jQuery);';
			echo '</script>';
		}
	}
}
add_action( 'wp_footer', 'idmuvi_core_popup_banner', 20 );