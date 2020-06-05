<?php
/**
 * Blog Functions
 *
 * @package Idmuvi Core
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'idmuvi_core_get_the_blog_tags' ) ) :
	/**
	 * Retrieve the tags for a blog formatted as a string.
	 *
	 * @since v.1.0.0
	 *
	 * @param int    $post_id Optional. Defaults to the current post.
	 * @param string $before Optional. Before tags.
	 * @param string $sep Optional. Between tags.
	 * @param string $after Optional. After tags.
	 *
	 * @return string|false|WP_Error A list of tags on success, false if there are no terms, WP_Error on failure.
	 */
	function idmuvi_core_get_the_blog_tags( $post_id, $before = '', $sep = '', $after = '' ) {
		return get_the_term_list( $post_id, 'blog_tag', $before, $sep, $after );
	}
endif;

if ( ! function_exists( 'idmuvi_core_get_the_blog_category' ) ) :
	/**
	 * Retrieve the category for a blog formatted as a string.
	 *
	 * @since v.1.0.0
	 *
	 * @param int    $post_id Optional. Post ID. Defaults to the current post.
	 * @param string $before Optional. Before tags.
	 * @param string $sep Optional. Between tags.
	 * @param string $after Optional. After tags.
	 *
	 * @return string|false|WP_Error A list of tags on success, false if there are no terms, WP_Error on failure.
	 */
	function idmuvi_core_get_the_blog_category( $post_id, $before = '', $sep = '', $after = '' ) {
		return get_the_term_list( $post_id, 'blog_category', $before, $sep, $after );
	}
endif;

if ( ! function_exists( 'idmuvi_core_blog_widgets_init' ) ) :
	/**
	 * Register widget area.
	 *
	 * @since v.1.0.0
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function idmuvi_core_blog_widgets_init() {
		// Sidebar widget areas.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Blog Sidebar', 'idmuvi-core' ),
				'id'            => 'sidebar-blog',
				'description'   => esc_html__( 'Add widgets for blog here.', 'idmuvi-core' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
endif; // endif gmr_widgets_init.
add_action( 'widgets_init', 'idmuvi_core_blog_widgets_init' );
