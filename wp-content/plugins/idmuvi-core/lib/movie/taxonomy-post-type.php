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

if ( ! function_exists( 'idmuvi_core_post_menu_label' ) ) {
	/**
	 * Change post menu label
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_post_menu_label() {
		global $menu;
		global $submenu;
		$menu[5][0]                 = __( 'Movies', 'idmuvi-core' );
		$submenu['edit.php'][5][0]  = __( 'All Movies', 'idmuvi-core' );
		$submenu['edit.php'][10][0] = __( 'Add Movie', 'idmuvi-core' );
		echo '';
	}
}
add_action( 'admin_menu', 'idmuvi_core_post_menu_label' );

if ( ! function_exists( 'idmuvi_core_post_object_label' ) ) {
	/**
	 * Change post object label
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_post_object_label() {
		global $wp_post_types;
		$labels                = &$wp_post_types['post']->labels;
		$labels->name          = __( 'Movies', 'idmuvi-core' );
		$labels->singular_name = __( 'Movie', 'idmuvi-core' );
		$labels->add_new       = __( 'Add Movie', 'idmuvi-core' );
		$labels->add_new_item  = __( 'Add New movie', 'idmuvi-core' );
		$labels->edit_item     = __( 'Edit Movie', 'idmuvi-core' );
		$labels->new_item      = __( 'Movie', 'idmuvi-core' );
	}
}
add_action( 'init', 'idmuvi_core_post_object_label' );

if ( ! function_exists( 'idmuvi_core_admin_post_menu_icons_css' ) ) {
	/**
	 * Add css
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_admin_post_menu_icons_css() {
		?>
		<style>
			.dashicons-admin-post:before,
			.dashicons-format-standard:before{content:"\f219"}
		</style>
		<?php
	}
}
add_action( 'admin_head', 'idmuvi_core_admin_post_menu_icons_css' );

if ( ! function_exists( 'idmuvi_core_category_to_genre' ) ) {
	/**
	 * The list of labels we can modify comes from
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 * @link http://core.trac.wordpress.org/browser/branches/3.0/wp-includes/taxonomy.php#L350
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_category_to_genre() {
		global $wp_taxonomies;

		$cat                            = $wp_taxonomies['category'];
		$cat->label                     = __( 'Genres', 'idmuvi-core' );
		$cat->labels->singular_name     = __( 'Genre', 'idmuvi-core' );
		$cat->labels->name              = $cat->label;
		$cat->labels->menu_name         = $cat->label;
		$cat->labels->search_items      = __( 'Search', 'idmuvi-core' ) . ' ' . $cat->label;
		$cat->labels->popular_items     = __( 'Popular', 'idmuvi-core' ) . ' ' . $cat->label;
		$cat->labels->all_items         = __( 'All', 'idmuvi-core' ) . ' ' . $cat->label;
		$cat->labels->parent_item       = __( 'Parent', 'idmuvi-core' ) . ' ' . $cat->labels->singular_name;
		$cat->labels->parent_item_colon = __( 'Parent', 'idmuvi-core' ) . ' ' . $cat->labels->singular_name . ':';
		$cat->labels->edit_item         = __( 'Edit', 'idmuvi-core' ) . ' ' . $cat->labels->singular_name;
		$cat->labels->update_item       = __( 'Update', 'idmuvi-core' ) . ' ' . $cat->labels->singular_name;
		$cat->labels->add_new_item      = __( 'Add new', 'idmuvi-core' ) . ' ' . $cat->labels->singular_name;
		$cat->labels->new_item_name     = __( 'New', 'idmuvi-core' ) . ' ' . $cat->labels->singular_name;

	}
}
add_action( 'init', 'idmuvi_core_category_to_genre' );

if ( ! function_exists( 'idmuvi_core_create_movie_tax' ) ) {
	/**
	 * Add new taxonomy in post movie
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_create_movie_tax() {
		// Add new taxonomy, NOT hierarchical (like tags).
		$labels = array(
			'name'                       => _x( 'Directors', 'taxonomy general name', 'idmuvi-core' ),
			'singular_name'              => _x( 'Director', 'taxonomy singular name', 'idmuvi-core' ),
			'search_items'               => __( 'Search Directors', 'idmuvi-core' ),
			'popular_items'              => __( 'Popular Directors', 'idmuvi-core' ),
			'all_items'                  => __( 'All Directors', 'idmuvi-core' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Director', 'idmuvi-core' ),
			'update_item'                => __( 'Update Director', 'idmuvi-core' ),
			'add_new_item'               => __( 'Add New Director', 'idmuvi-core' ),
			'new_item_name'              => __( 'New Director Name', 'idmuvi-core' ),
			'separate_items_with_commas' => __( 'Separate directors with commas', 'idmuvi-core' ),
			'add_or_remove_items'        => __( 'Add or remove directors', 'idmuvi-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used directors', 'idmuvi-core' ),
			'not_found'                  => __( 'No directors found.', 'idmuvi-core' ),
			'menu_name'                  => __( 'Directors', 'idmuvi-core' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'show_in_rest'          => true,
			'rewrite'               => array( 'slug' => 'director' ),
		);
		register_taxonomy( 'muvidirector', array( 'post', 'tv' ), $args );

		unset( $args );
		unset( $labels );

		// Add new taxonomy, NOT hierarchical (like tags).
		$labels = array(
			'name'                       => _x( 'Casts', 'taxonomy general name', 'idmuvi-core' ),
			'singular_name'              => _x( 'Cast', 'taxonomy singular name', 'idmuvi-core' ),
			'search_items'               => __( 'Search Casts', 'idmuvi-core' ),
			'popular_items'              => __( 'Popular Casts', 'idmuvi-core' ),
			'all_items'                  => __( 'All Casts', 'idmuvi-core' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Cast', 'idmuvi-core' ),
			'update_item'                => __( 'Update Cast', 'idmuvi-core' ),
			'add_new_item'               => __( 'Add New Cast', 'idmuvi-core' ),
			'new_item_name'              => __( 'New Cast Name', 'idmuvi-core' ),
			'separate_items_with_commas' => __( 'Separate casts with commas', 'idmuvi-core' ),
			'add_or_remove_items'        => __( 'Add or remove casts', 'idmuvi-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used casts', 'idmuvi-core' ),
			'not_found'                  => __( 'No casts found.', 'idmuvi-core' ),
			'menu_name'                  => __( 'Casts', 'idmuvi-core' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'show_in_rest'          => true,
			'rewrite'               => array( 'slug' => 'cast' ),
		);
		register_taxonomy( 'muvicast', array( 'post', 'tv' ), $args );

		unset( $args );
		unset( $labels );

		// Add new taxonomy, NOT hierarchical (like tags).
		$labels = array(
			'name'                       => _x( 'Years', 'taxonomy general name', 'idmuvi-core' ),
			'singular_name'              => _x( 'Year', 'taxonomy singular name', 'idmuvi-core' ),
			'search_items'               => __( 'Search Years', 'idmuvi-core' ),
			'popular_items'              => __( 'Popular Years', 'idmuvi-core' ),
			'all_items'                  => __( 'All Years', 'idmuvi-core' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Year', 'idmuvi-core' ),
			'update_item'                => __( 'Update Year', 'idmuvi-core' ),
			'add_new_item'               => __( 'Add New Year', 'idmuvi-core' ),
			'new_item_name'              => __( 'New Year Name', 'idmuvi-core' ),
			'separate_items_with_commas' => __( 'Separate years with commas', 'idmuvi-core' ),
			'add_or_remove_items'        => __( 'Add or remove years', 'idmuvi-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used years', 'idmuvi-core' ),
			'not_found'                  => __( 'No years found.', 'idmuvi-core' ),
			'menu_name'                  => __( 'Years', 'idmuvi-core' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'show_in_rest'          => true,
			'rewrite'               => array( 'slug' => 'year' ),
		);
		register_taxonomy( 'muviyear', array( 'post', 'tv' ), $args );

		unset( $args );
		unset( $labels );

		// Add new taxonomy, NOT hierarchical (like tags).
		$labels = array(
			'name'                       => _x( 'Countries', 'taxonomy general name', 'idmuvi-core' ),
			'singular_name'              => _x( 'Country', 'taxonomy singular name', 'idmuvi-core' ),
			'search_items'               => __( 'Search Countries', 'idmuvi-core' ),
			'popular_items'              => __( 'Popular Countries', 'idmuvi-core' ),
			'all_items'                  => __( 'All Countries', 'idmuvi-core' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Country', 'idmuvi-core' ),
			'update_item'                => __( 'Update Country', 'idmuvi-core' ),
			'add_new_item'               => __( 'Add New Country', 'idmuvi-core' ),
			'new_item_name'              => __( 'New Country Name', 'idmuvi-core' ),
			'separate_items_with_commas' => __( 'Separate countries with commas', 'idmuvi-core' ),
			'add_or_remove_items'        => __( 'Add or remove countries', 'idmuvi-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used countries', 'idmuvi-core' ),
			'not_found'                  => __( 'No countries found.', 'idmuvi-core' ),
			'menu_name'                  => __( 'Countries', 'idmuvi-core' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'country' ),
		);
		register_taxonomy( 'muvicountry', array( 'post', 'tv' ), $args );

		unset( $args );
		unset( $labels );

		// Add new taxonomy, NOT hierarchical (like tags).
		$labels = array(
			'name'                       => _x( 'Networks', 'taxonomy general name', 'idmuvi-core' ),
			'singular_name'              => _x( 'Network', 'taxonomy singular name', 'idmuvi-core' ),
			'search_items'               => __( 'Search Networks', 'idmuvi-core' ),
			'popular_items'              => __( 'Popular Networks', 'idmuvi-core' ),
			'all_items'                  => __( 'All Networks', 'idmuvi-core' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Network', 'idmuvi-core' ),
			'update_item'                => __( 'Update Network', 'idmuvi-core' ),
			'add_new_item'               => __( 'Add New Network', 'idmuvi-core' ),
			'new_item_name'              => __( 'New Network Name', 'idmuvi-core' ),
			'separate_items_with_commas' => __( 'Separate networks with commas', 'idmuvi-core' ),
			'add_or_remove_items'        => __( 'Add or remove networks', 'idmuvi-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used networks', 'idmuvi-core' ),
			'not_found'                  => __( 'No networks found.', 'idmuvi-core' ),
			'menu_name'                  => __( 'Networks', 'idmuvi-core' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'network' ),
		);
		register_taxonomy( 'muvinetwork', array( 'tv' ), $args );

		unset( $args );
		unset( $labels );

		// Add new taxonomy, NOT hierarchical (like tags).
		$labels = array(
			'name'                       => _x( 'Qualities', 'taxonomy general name', 'idmuvi-core' ),
			'singular_name'              => _x( 'Quality', 'taxonomy singular name', 'idmuvi-core' ),
			'search_items'               => __( 'Search Qualities', 'idmuvi-core' ),
			'popular_items'              => __( 'Popular Qualities', 'idmuvi-core' ),
			'all_items'                  => __( 'All Qualities', 'idmuvi-core' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Quality', 'idmuvi-core' ),
			'update_item'                => __( 'Update Quality', 'idmuvi-core' ),
			'add_new_item'               => __( 'Add New Quality', 'idmuvi-core' ),
			'new_item_name'              => __( 'New Quality Name', 'idmuvi-core' ),
			'separate_items_with_commas' => __( 'Separate qualities with commas', 'idmuvi-core' ),
			'add_or_remove_items'        => __( 'Add or remove qualities', 'idmuvi-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used qualities', 'idmuvi-core' ),
			'not_found'                  => __( 'No qualities found.', 'idmuvi-core' ),
			'menu_name'                  => __( 'Qualities', 'idmuvi-core' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'quality' ),
		);
		register_taxonomy( 'muviquality', array( 'post', 'episode' ), $args );

		unset( $args );
		unset( $labels );

		// Order by alphabetic.
		$args = array(
			'hierarchical'      => false,
			'label'             => __( 'Index', 'idmuvi-core' ),
			'show_ui'           => false,
			'query_var'         => true,
			'show_in_rest'      => true,
			'show_admin_column' => false,
			'rewrite'           => array( 'slug' => 'index' ),
		);
		register_taxonomy( 'muviindex', array( 'post', 'tv' ), $args );

		/**
		Unset( $args );
		unset( $labels );

		Add new taxonomy, NOT hierarchical (like tags)
		$labels = array(
			'name'                       => _x( 'Series', 'taxonomy general name', 'idmuvi-core' ),
			'singular_name'              => _x( 'Serie', 'taxonomy singular name', 'idmuvi-core' ),
			'search_items'               => __( 'Search Serie', 'idmuvi-core' ),
			'popular_items'              => __( 'Popular Series', 'idmuvi-core' ),
			'all_items'                  => __( 'All Series', 'idmuvi-core' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Serie', 'idmuvi-core' ),
			'update_item'                => __( 'Update Serie', 'idmuvi-core' ),
			'add_new_item'               => __( 'Add New Serie', 'idmuvi-core' ),
			'new_item_name'              => __( 'New Serie Name', 'idmuvi-core' ),
			'separate_items_with_commas' => __( 'Separate Series with commas', 'idmuvi-core' ),
			'add_or_remove_items'        => __( 'Add or remove Series', 'idmuvi-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used Series', 'idmuvi-core' ),
			'not_found'                  => __( 'No series found.', 'idmuvi-core' ),
			'menu_name'                  => __( 'Series', 'idmuvi-core' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'serie' ),
		);
		register_taxonomy( 'muviserie', array ( 'episode' ), $args ); */

	}
}
add_action( 'init', 'idmuvi_core_create_movie_tax', 0 );

if ( ! function_exists( 'idmuvi_core_create_tvshow_post_type' ) ) {
	/**
	 * Register the post type
	 *
	 * @return void
	 */
	function idmuvi_core_create_tvshow_post_type() {

		$labels = array(
			'name'               => _x( 'Tv Shows', 'Post Type General Name', 'idmuvi-core' ),
			'singular_name'      => _x( 'Tv Show', 'Post Type Singular Name', 'idmuvi-core' ),
			'menu_name'          => __( 'Tv Show', 'idmuvi-core' ),
			'parent_item_colon'  => __( 'Parent Tv Show', 'idmuvi-core' ),
			'all_items'          => __( 'All Tv Shows', 'idmuvi-core' ),
			'view_item'          => __( 'View Tv Show', 'idmuvi-core' ),
			'add_new_item'       => __( 'Add Tv Show', 'idmuvi-core' ),
			'add_new'            => __( 'Add New', 'idmuvi-core' ),
			'edit_item'          => __( 'Edit Tv Show', 'idmuvi-core' ),
			'update_item'        => __( 'Update Tv Show', 'idmuvi-core' ),
			'search_items'       => __( 'Search Tv Show', 'idmuvi-core' ),
			'not_found'          => __( 'Not Tv Show found', 'idmuvi-core' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'idmuvi-core' ),
		);

		$rewrite = array(
			'slug'       => 'tv',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'comments', 'author', 'publicize' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-editor-video',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			// This is where we add taxonomies to our CPT.
			'taxonomies'          => array( 'category', 'post_tag' ),
		);

		register_post_type( 'tv', $args );
	}
}
add_action( 'init', 'idmuvi_core_create_tvshow_post_type' );

if ( ! function_exists( 'idmuvi_core_create_episode_post_type' ) ) {
	/**
	 * Register the post type
	 *
	 * @return void
	 */
	function idmuvi_core_create_episode_post_type() {

		$labels = array(
			'name'               => _x( 'Episodes', 'Post Type General Name', 'idmuvi-core' ),
			'singular_name'      => _x( 'Episode', 'Post Type Singular Name', 'idmuvi-core' ),
			'menu_name'          => __( 'Episode', 'idmuvi-core' ),
			'parent_item_colon'  => __( 'Parent Episode', 'idmuvi-core' ),
			'all_items'          => __( 'All Episodes', 'idmuvi-core' ),
			'view_item'          => __( 'View Episode', 'idmuvi-core' ),
			'add_new_item'       => __( 'Add Episode', 'idmuvi-core' ),
			'add_new'            => __( 'Add New', 'idmuvi-core' ),
			'edit_item'          => __( 'Edit Episode', 'idmuvi-core' ),
			'update_item'        => __( 'Update Episode', 'idmuvi-core' ),
			'search_items'       => __( 'Search Episode', 'idmuvi-core' ),
			'not_found'          => __( 'Not Episode found', 'idmuvi-core' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'idmuvi-core' ),
		);

		$rewrite = array(
			'slug'       => 'eps',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'comments', 'author', 'publicize' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_rest'        => true,
			'show_in_menu'        => 'edit.php?post_type=tv',
			'menu_position'       => 9,
			'menu_icon'           => 'dashicons-editor-video',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
		);

		register_post_type( 'episode', $args );
	}
}
add_action( 'init', 'idmuvi_core_create_episode_post_type' );

if ( ! function_exists( 'idmuvi_core_save_first_letter' ) ) {
	/**
	 * When the post is saved, saves our custom data for muviindex taxonomy
	 *
	 * @param Int $post_id Post ID.
	 * @return void
	 */
	function idmuvi_core_save_first_letter( $post_id ) {
		// verify if this is an auto save routine.
		// If it is our form has not been submitted, so we dont want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// check location (only run for posts).
		$limit_post_types = array( 'post', 'tv' );
		if ( isset( $_POST['post_type'] ) && ( ! in_array( $_POST['post_type'], $limit_post_types ) ) ) {
			return;
		}

		// Check permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// OK, we're authenticated: we need to find and save the data.
		$taxonomy = 'muviindex';
		if ( isset( $_POST['post_type'] ) ) {
			// set term as first letter of post title, lower case.
			wp_set_post_terms( $post_id, strtolower( substr( $_POST['post_title'], 0, 1) ), $taxonomy );
		}
	}
}
add_action( 'save_post', 'idmuvi_core_save_first_letter' );

/* create array from existing posts remove when done
function idmuvi_core_run_once(){
	if ( false === get_transient( 'idmuvi_core_run_once' ) ) {
		$taxonomy = 'muviindex';

		$alphabet = array();
		$posts = get_posts(array('numberposts' => -1, 'post_type'        => array( 'post', 'tv' )) );

		foreach($posts as $p) :
			//set term as first letter of post title, lower case
			wp_set_post_terms( $p->ID, strtolower(substr($p->post_title, 0, 1)), $taxonomy );
		endforeach;
		set_transient( 'idmuvi_core_run_once', 'true' );
	}
}
add_action('init','idmuvi_core_run_once');

// this automatic add year to meta when post load. So after using this, please delete for improve performance
function idmuvi_core_run_once_year(){
	if ( false === get_transient( 'idmuvi_core_run_wew' ) ) {

		$posts = get_posts(array('numberposts' => -1, 'post_type'        => array( 'post', 'tv' )) );

		foreach($posts as $p) :
			$terms = wp_get_object_terms( $p->ID,  'muviyear' );
			if ( ! empty( $terms ) ) {
				if ( ! is_wp_error( $terms ) ) {
						foreach( $terms as $term ) {
							update_post_meta( $p->ID, 'IDMUVICORE_Year', intval( $term->name ) );
						}
				}
			}
		endforeach;
		set_transient( 'idmuvi_core_run_wew', 'true' );
	}
}
add_action('init','idmuvi_core_run_once_year');
*/
