<?php
/**
 * IdmuviCoreBlogs class
 *
 * @class IdmuviCoreBlogs The class that holds the entire Salespro Core plugin
 *
 * @package Idmuvi Core
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blog Post Type Class
 *
 * @since 1.0.0
 */
class IdmuviCoreBlogs {
	/**
	 * Post Type.
	 *
	 * @var $post_type Post Type.
	 */
	private $post_type = 'blogs';

	/**
	 * Initializes the IdmuviCoreBlogs() class
	 *
	 * Checks for an existing IdmuviCoreBlogs() instance
	 * and if it doesn't find one, creates it.
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new IdmuviCoreBlogs();
			$instance->plugin_init();
		}

		return $instance;
	}

	/**
	 * Init Plugin
	 */
	public function plugin_init() {
		$this->file_includes();

		// custom post types and taxonomies.
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
	}

	/**
	 * Load the required files
	 *
	 * @return void
	 */
	public function file_includes() {
		include_once dirname( __FILE__ ) . '/includes/functions.php';
		include_once dirname( __FILE__ ) . '/widgets/search-blogs-widget.php';
		include_once dirname( __FILE__ ) . '/widgets/categories-blogs-widget.php';
		include_once dirname( __FILE__ ) . '/widgets/recent-blogs-widget.php';
	}

	/**
	 * Register the post type
	 *
	 * @return void
	 */
	public function register_post_type() {

		$labels = array(
			'name'               => _x( 'Blogs', 'Post Type General Name', 'idmuvi-core' ),
			'singular_name'      => _x( 'Blog', 'Post Type Singular Name', 'idmuvi-core' ),
			'menu_name'          => __( 'Blog', 'idmuvi-core' ),
			'parent_item_colon'  => __( 'Parent Blog', 'idmuvi-core' ),
			'all_items'          => __( 'All Blogs', 'idmuvi-core' ),
			'view_item'          => __( 'View Blog', 'idmuvi-core' ),
			'add_new_item'       => __( 'Add Blog', 'idmuvi-core' ),
			'add_new'            => __( 'Add New', 'idmuvi-core' ),
			'edit_item'          => __( 'Edit Blog', 'idmuvi-core' ),
			'update_item'        => __( 'Update Blog', 'idmuvi-core' ),
			'search_items'       => __( 'Search Blog', 'idmuvi-core' ),
			'not_found'          => __( 'Not blog found', 'idmuvi-core' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'idmuvi-core' ),
		);

		$rewrite = array(
			'slug'       => 'blog',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'comments' ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-portfolio',
			'can_export'          => true,
			'show_in_rest'        => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
		);

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Register doc tags taxonomy
	 *
	 * @return void
	 */
	public function register_taxonomy() {

		// Add new taxonomy, make it hierarchical (like categories).
		$labels = array(
			'name'              => _x( 'Categories', 'taxonomy general name', 'idmuvi-core' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'idmuvi-core' ),
			'search_items'      => __( 'Search Categories', 'idmuvi-core' ),
			'all_items'         => __( 'All Categories', 'idmuvi-core' ),
			'parent_item'       => __( 'Parent Category', 'idmuvi-core' ),
			'parent_item_colon' => __( 'Parent Category:', 'idmuvi-core' ),
			'edit_item'         => __( 'Edit Category', 'idmuvi-core' ),
			'update_item'       => __( 'Update Category', 'idmuvi-core' ),
			'add_new_item'      => __( 'Add New Category', 'idmuvi-core' ),
			'new_item_name'     => __( 'New Category Name', 'idmuvi-core' ),
			'menu_name'         => __( 'Categories', 'idmuvi-core' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'blog-category' ),
		);

		register_taxonomy( 'blog_category', array( 'blogs' ), $args );

		$labels = array(
			'name'                       => _x( 'Tags', 'Taxonomy General Name', 'idmuvi-core' ),
			'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'idmuvi-core' ),
			'menu_name'                  => __( 'Tags', 'idmuvi-core' ),
			'all_items'                  => __( 'All Tags', 'idmuvi-core' ),
			'parent_item'                => __( 'Parent Tag', 'idmuvi-core' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'idmuvi-core' ),
			'new_item_name'              => __( 'New Tag Tag', 'idmuvi-core' ),
			'add_new_item'               => __( 'Add New Item', 'idmuvi-core' ),
			'edit_item'                  => __( 'Edit Tag', 'idmuvi-core' ),
			'update_item'                => __( 'Update Tag', 'idmuvi-core' ),
			'view_item'                  => __( 'View Tag', 'idmuvi-core' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'idmuvi-core' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'idmuvi-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'idmuvi-core' ),
			'popular_items'              => __( 'Popular Tags', 'idmuvi-core' ),
			'search_items'               => __( 'Search Tags', 'idmuvi-core' ),
			'not_found'                  => __( 'Not Found', 'idmuvi-core' ),
			'no_terms'                   => __( 'No items', 'idmuvi-core' ),
			'items_list'                 => __( 'Tags list', 'idmuvi-core' ),
			'items_list_navigation'      => __( 'Tags list navigation', 'idmuvi-core' ),
		);

		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'rewrite'           => array( 'slug' => 'blog-tag' ),
		);

		register_taxonomy( 'blog_tag', array( 'blogs' ), $args );
	}
} // IdmuviCoreBlogs

/**
 * Initialize the plugin
 *
 * @return \IdmuviCoreBlogs
 */
function idmuvipro_core_func() {
	return IdmuviCoreBlogs::init();
}

// kick it off.
idmuvipro_core_func();
