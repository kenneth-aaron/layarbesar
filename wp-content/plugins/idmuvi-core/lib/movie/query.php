<?php
/**
 * Custom taxonomy for movie post
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

if ( ! function_exists( 'idmuvi_core_get_archive_post_type' ) ) {
	/**
	 * Displaying custom post type in archive WordPress
	 *
	 * @param Array $query WP Query.
	 * @return array
	 */
	function idmuvi_core_get_archive_post_type( $query ) {
		// Do not affect queries for admin pages.
		if ( ! is_admin() ) {
			$idmuv_ajax = get_option( 'idmuv_ajax' );

			if ( $query->is_main_query() ) {
				if ( ( $query->is_author() ) || ( $query->is_category() || $query->is_tag() || $query->is_tax( 'muvidirector', 'muvicast', 'muviyear', 'muvicountry', 'muvinetwork', 'muviquality' ) && empty( $query->query_vars['suppress_filters'] ) ) || ( $query->is_home() ) ) {
					$query->set( 'post_type', array( 'post', 'tv' ) );
					if ( isset( $idmuv_ajax['content_orderby'] ) && 'byyear' === $idmuv_ajax['content_orderby'] ) { // Order by year.
						$query->set( 'orderby', 'meta_value_num post_date' );
						$query->set( 'meta_key', 'IDMUVICORE_Year' );
					} elseif ( isset( $idmuv_ajax['content_orderby'] ) && 'byrating' === $idmuv_ajax['content_orderby'] ) { // Order by rating.
						$query->set( 'orderby', 'meta_value_num' );
						$query->set( 'meta_key', 'IDMUVICORE_tmdbRating' );
					} elseif ( isset( $idmuv_ajax['content_orderby'] ) && 'bytitle' === $idmuv_ajax['content_orderby'] ) { // Order by title.
						$query->set( 'orderby', 'title' );
						$query->set( 'order', 'ASC' );
					} elseif ( isset( $idmuv_ajax['content_orderby'] ) && 'bymodified' === $idmuv_ajax['content_orderby'] ) {
						$query->set( 'orderby', 'modified' );
					}
				}
			}
			return $query;
		}
	}
}
add_filter( 'pre_get_posts', 'idmuvi_core_get_archive_post_type' );

/**
if ( ! function_exists( 'muvipro_custom_rewrite_rule' ) ) {

	function muvipro_custom_rewrite_rule() {
		add_rewrite_endpoint( 'download', EP_PERMALINK );
	}
}
add_action( 'init', 'muvipro_custom_rewrite_rule', 10, 0 );


if ( ! function_exists( 'muvipro_filter_request' ) ) {
	/**
	 * Filter Request
	 *
	 * @link https://wordpress.stackexchange.com/questions/42279/custom-post-type-permalink-endpoint/42288
	 * @param Array $vars Variable.
	 * @return array
	 *
	function muvipro_filter_request( $vars ) {
		if ( isset( $vars['download'] ) && empty( $vars['download'] ) ) {
			$vars['download'] = true;
		} elseif ( isset( $vars['download'] ) && ! empty( $vars['download'] ) ) {
			$vars['download'] = 'notempty';
		}
		return $vars;
	}
}
add_filter( 'request', 'muvipro_filter_request' );

if ( ! function_exists( 'muvipro_catch_vars' ) ) {
	/**
	 * Catch Variable
	 *
	function muvipro_catch_vars() {
		global $wp_query;
		if ( is_singular( 'post' ) && ( 'notempty' === get_query_var( 'download' ) ) ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			get_template_part( 404 );
			exit();
		} elseif ( is_singular( 'post' ) && ( true === get_query_var( 'download' ) ) ) {
			?>
			<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
			<head <?php echo muvipro_itemtype_schema( 'WebSite' ); ?>>
			<meta charset="<?php bloginfo( 'charset' ); ?>">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="profile" href="http://gmpg.org/xfn/11">
			<meta name="robots" content="noindex, nofollow">
			<?php wp_head(); ?>
			<style type='text/css'>
			html {
				margin-top: 0 !important;
			}
			.header-download {
				padding: 10px;
				text-align: center;
				background: #fff;
				margin-bottom: 20px;
			}
			.header-download a {
				color: #333;
				text-transform: uppercase !important;
				font-size: 18px;
				font-weight: 600;
			}
			</style>
			<body>
				<?php
				// if get value from customizer blogname.
				if ( get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) ) {
					echo '<div class="header-download">';
						echo '<div class="container">';
						echo '<a href="' . esc_url( home_url( '/' ) ) . '" ' . muvipro_itemprop_schema( 'url' ) . ' title="' . esc_html( get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo esc_html( get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) );
						echo '</a>';
						echo '</div>';
					echo '</div>';
				}
				echo '<div class="container">';
				echo '<div class="row">';
				echo '<div class="col-md-12">';
					echo '<div id="download" class="gmr-download-wrap clearfix ' . $class . '">';
						echo '<h3 class="widget-title title-synopsis">'.__('Start Download...', 'dlpro').'</h3>';
						echo '<p>' . __( 'Download of', 'dlpro' ) . ' <a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a> ' . __( 'will start in', 'dlpro' ) . ' <label id="lblTime" style="font-weight:bold;"></label> ' . __( 'seconds', 'dlpro' ) . '.</p>';
					echo '</div>';
				echo '</div>';
				echo '</div>';
				?>
			</body>
			</html>
			<?php
			exit();
		}
	}
}
add_action( 'template_redirect', 'muvipro_catch_vars' );
*/
