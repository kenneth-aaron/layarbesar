<?php
/*
 * Ajax Search
 *
 * Author: Gian MR - http://www.gianmr.com
 * 
 * @since 1.0.6
 * @package Idmuvi Core
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !function_exists('muvipro_core_search_movie') ) {
	/**
	 * Ajax search movie
	 *
	 * @since 1.0.8
	 * @return string
	 */
	function muvipro_core_search_movie() {
		$movie = array();
		$search_keyword = esc_attr( $_REQUEST['query'] );
		
		$args = array(
			's'      				=> $search_keyword,
			'post_type'				=> array( 'post','tv', 'episode' ),
			'post_status' 			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'orderby' 				=> 'title',
			'order' 				=> 'asc',
			'posts_per_page' 		=> 10
		);
		
		$search_query = new WP_Query( $args );
		if ( $search_query->have_posts() ) {
			while ( $search_query->have_posts() ) {
				$search_query->the_post();
				$movie[] = array(
					'id' => get_the_ID(),
					'value' => strip_tags( get_the_title() ),
					'url' => get_permalink()
				);
			}
		} else {
			$movie[] = array(
				'id' => -1,
				'value' => __('No results', 'muvipro_core' ),
				'url' => ''
			);
		}
		
		wp_reset_postdata();
		
		$movie = array(
			'suggestions' => $movie
		);
		
		echo json_encode( $movie );
		die();
	}        
} 
add_action( 'wp_ajax_muvipro_core_ajax_search_movie', 'muvipro_core_search_movie' );
add_action( 'wp_ajax_nopriv_muvipro_core_ajax_search_movie', 'muvipro_core_search_movie' );

/* fungsi ini memberatkan...
if ( !function_exists('muvipro_core_search_by_title_only') ) {
	/**
	 * Search only by title
	 *
	 * @since 1.0.9
	 * @return string
	 
	function muvipro_core_search_by_title_only( $search, $wp_query ) {
		global $wpdb;
		if(empty($search)) {
			return $search; // skip processing - no search term in query
		}
		$q = $wp_query->query_vars;
		$n = !empty($q['exact']) ? '' : '%';
		$search =
		$searchand = '';
		foreach ((array)$q['search_terms'] as $term) {
			$term = esc_sql($wpdb->esc_like($term));
			$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
			$searchand = ' AND ';
		}
		if (!empty($search)) {
			$search = " AND ({$search}) ";
			if (!is_user_logged_in())
				$search .= " AND ($wpdb->posts.post_password = '') ";
		}
		return $search;
	}
}
add_filter('posts_search', 'muvipro_core_search_by_title_only', 500, 2); */