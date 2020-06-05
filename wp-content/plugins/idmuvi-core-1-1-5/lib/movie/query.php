<?php
/**
 * Custom taxonomy for movie post
 *
 * Author: Gian MR - http://www.gianmr.com
 * 
 * @since 1.0.0
 * @package Idmuvi Core
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !function_exists( 'idmuvi_core_get_archive_post_type' ) ) {
    /**
     * Displaying custom post type in archive wordpress
     *
     * @return void
     */
	function idmuvi_core_get_archive_post_type( $query ) {
		// Do not affect queries for admin pages
		if( !is_admin() ) {
			$idmuv_ajax = get_option( 'idmuv_ajax' );
			
			if ( $query->is_main_query() ) {
				if ( ( $query->is_author() ) || 
					 ( $query->is_category() || $query->is_tag() || $query->is_tax( 'muvidirector', 'muvicast', 'muviyear', 'muvicountry', 'muvinetwork', 'muviquality' ) && empty( $query->query_vars['suppress_filters'] ) ) || 
					 ( $query->is_home() )
					) 
				{
					$query->set( 'post_type', array( 'post', 'tv' ) );
					
					// Order by year
					if ( isset ( $idmuv_ajax['content_orderby'] ) && $idmuv_ajax['content_orderby'] == 'byyear' ) {
						$query->set( 'orderby', 'meta_value_num post_date' );
						$query->set( 'meta_key', 'IDMUVICORE_Year' );
					
					// Order by rating
					} elseif ( isset ( $idmuv_ajax['content_orderby'] ) && $idmuv_ajax['content_orderby'] == 'byrating' ) {
						$query->set( 'orderby', 'meta_value_num' );
						$query->set( 'meta_key', 'IDMUVICORE_tmdbRating' );
					
					// Order by title
					} elseif ( isset ( $idmuv_ajax['content_orderby'] ) && $idmuv_ajax['content_orderby'] == 'bytitle' ) {
						$query->set( 'orderby', 'title' );
						$query->set( 'order', 'ASC' );
					} elseif ( isset ( $idmuv_ajax['content_orderby'] ) && $idmuv_ajax['content_orderby'] == 'bymodified' ) {
						$query->set( 'orderby', 'modified' );
					}
				}
			}
			return $query;
		}
	}
}
add_filter( 'pre_get_posts', 'idmuvi_core_get_archive_post_type' );