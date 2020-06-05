<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'gmr_checkIsAValidDate' ) ) :
	/**
	 * check if date true or false
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	function gmr_checkIsAValidDate($myDateString){
		return (bool)strtotime($myDateString);
	}
endif;

if ( ! function_exists( 'gmr_body_classes' ) ) :
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function gmr_body_classes( $classes ) {
		
		$classes[] = 'gmr-theme idtheme kentooz';
		
		$sticky_menu = get_theme_mod('gmr_sticky_menu' ,'nosticky');
		
		$layout = get_theme_mod('gmr_layout' ,'box-layout');
		
		$btnstyle = get_theme_mod('gmr_button_style' ,'default');

		if ( $sticky_menu == 'sticky' ) {
			$classes[] = 'gmr-sticky';
		} else {
			$classes[] = 'gmr-no-sticky';
		}
		
		if ( $layout == 'box-layout' ) {
			$classes[] = 'gmr-box-layout';
		} else {
			$classes[] = 'gmr-fullwidth-layout';
		}
		
		if ( $btnstyle == 'lk' ) {
			$classes[] = 'gmr-button-lk';
		}
		
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}
endif; // endif gmr_body_classes
add_filter( 'body_class', 'gmr_body_classes' );

if ( ! function_exists( 'gmr_pingback_header' ) ) :
	/**
	 * Add a pingback url auto-discovery header for singularly identifiable articles.
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
		}
	}
endif;
add_action( 'wp_head', 'gmr_pingback_header' );

if ( ! function_exists( 'gmr_add_img_title' ) ) :
	/**
	 * Add a image title tag.
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function gmr_add_img_title( $attr, $attachment = null ) {
		$attr['title'] = trim( strip_tags( $attachment->post_title ) );
		return $attr;
	}
endif;
add_filter( 'wp_get_attachment_image_attributes','gmr_add_img_title', 10, 2 );

if ( ! function_exists( 'gmr_add_title_alt_gravatar' ) ) :
	/**
	 * Add a gravatar title and alt tag.
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function gmr_add_title_alt_gravatar( $text ) {
		$text = str_replace('alt=\'\'', 'alt=\'' . __( 'Gravatar Image', 'muvipro' ) . '\' title=\'' . __( 'Gravatar', 'muvipro' ) . '\'',$text);
		return $text;
	}
endif;
add_filter('get_avatar','gmr_add_title_alt_gravatar');

if ( ! function_exists( 'gmr_thumbnail_upscale' ) ) :
	/** 
	 * Thumbnail upscale
	 *
	 * @since 1.0.0
	 *
	 * @Source http://wordpress.stackexchange.com/questions/50649/how-to-scale-up-featured-post-thumbnail 
	 * @param array $default, $orig_w, $orig_h, $new_w, $new_h, $crop for image sizes
	 * @return array
	 */ 
	function gmr_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ) {
		if ( !$crop ) return null; // let the wordpress default function handle this
	 
		$aspect_ratio = $orig_w / $orig_h;
		$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
	 
		$crop_w = round($new_w / $size_ratio);
		$crop_h = round($new_h / $size_ratio);
	 
		$s_x = floor( ($orig_w - $crop_w) / 2 );
		$s_y = floor( ($orig_h - $crop_h) / 2 );
	 
		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
	}
endif; // endif gmr_thumbnail_upscale
add_filter( 'image_resize_dimensions', 'gmr_thumbnail_upscale', 10, 6 );

if ( ! function_exists( 'muvipro_itemtype_schema' ) ) :
	/** 
	 * Figure out which schema tags to apply to the <article> element
	 * The function determines the itemtype: muvipro_itemtype_schema( 'Movie' )
	 * @since 1.0.0
	 * @return void
	 */
	function muvipro_itemtype_schema( $type = 'Movie' ) {
		$schema = 'http://schema.org/';
		
		// Get the itemtype
		$itemtype = apply_filters( 'muvipro_article_itemtype', $type );
		
		// Print the results
		$scope = 'itemscope="itemscope" itemtype="' . $schema . $itemtype . '"';
		return $scope;
	}
endif;

if ( ! function_exists( 'muvipro_itemprop_schema' ) ) :
	/** 
	 * Figure out which schema tags itemprop=""
	 * The function determines the itemprop: muvipro_itemprop_schema( 'headline' )
	 * @since 1.0.0
	 * @return void
	 */
	function muvipro_itemprop_schema( $type = 'headline' ) {
		// Get the itemprop
		$itemprop = apply_filters( 'muvipro_itemprop_filter', $type );
		
		// Print the results
		$scope = 'itemprop="' . $itemprop . '"';
		return $scope;
	}
endif;

if ( ! function_exists( 'muvipro_the_archive_title' ) ) :
	/**
	 * Change category text with genre text.
	 * @since 1.0.0
	 * @return string
	 */
	function muvipro_the_archive_title($title) {
		if ( is_category() ) {
			$title = sprintf( __( 'Genre: %s', 'muvipro' ), single_cat_title( '', false ) );
		}
		return $title;
	}
endif;
add_filter( 'get_the_archive_title', 'muvipro_the_archive_title' );

if ( ! function_exists( 'muvipro_remove_p_archive_description' ) ) :
	/**
	 * remove auto p in archive description
	 * @since 1.0.0
	 * @return string
	 */
	function muvipro_remove_p_archive_description($description) {
		$remove = array( '<p>', '</p>' );
		$description = str_replace( $remove, "", $description );
		return $description;
	}
endif;
add_filter( 'get_the_archive_description', 'muvipro_remove_p_archive_description' );

if ( ! function_exists( 'muvipro_template_search_blogs' ) ) :
	/**
	 * Search blog post type template redirect
	 * @since 1.0.0
	 * @return string
	 */
	function muvipro_template_search_blogs($template) {
		global $wp_query;
		$post_type = get_query_var('post_type');
		if( $wp_query->is_search && $post_type == 'blogs' ) {
			return locate_template('search-blogs.php');
		}
		return $template;
	}
endif;
add_filter('template_include', 'muvipro_template_search_blogs');

if ( ! function_exists( 'muvipro_player_content' ) ) :
	/**
	 * Ajax functions for player tab
	 * @since 1.0.5
	 * @return string
	 */
	function muvipro_player_content() {
		$tab = $_POST['tab'];
		$post_id = $_POST['post_id'];
		$player1 = get_post_meta( $post_id, 'IDMUVICORE_Player1', true );
		$player2 = get_post_meta( $post_id, 'IDMUVICORE_Player2', true );
		$player3 = get_post_meta( $post_id, 'IDMUVICORE_Player3', true );
		$player4 = get_post_meta( $post_id, 'IDMUVICORE_Player4', true );
		$player5 = get_post_meta( $post_id, 'IDMUVICORE_Player5', true );
		$player6 = get_post_meta( $post_id, 'IDMUVICORE_Player6', true );
		$player7 = get_post_meta( $post_id, 'IDMUVICORE_Player7', true );
		$player8 = get_post_meta( $post_id, 'IDMUVICORE_Player8', true );
		$player9 = get_post_meta( $post_id, 'IDMUVICORE_Player9', true );
		$player10 = get_post_meta( $post_id, 'IDMUVICORE_Player10', true );
		
		switch ( $tab ) { 
			case "player1":      
				if ( ! empty( $player1 ) ) : ?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player1 ); ?></div>
				<?php endif;
				break;        
			case "player2":      
				if ( ! empty( $player2 ) ) : ?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player2 ); ?></div>
				<?php endif;
				break;      
			case "player3":      
				if ( ! empty( $player3 ) ) : ?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player3 ); ?></div>
				<?php endif;
				break;      
			case "player4":      
				if ( ! empty( $player4 ) ) : ?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player4 ); ?></div>
				<?php endif;
				break;      
			case "player5":      
				if ( ! empty( $player5 ) ) : ?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player5 ); ?></div>
				<?php endif;
				break;      
			case "player6":      
				if ( ! empty( $player6 ) ) : ?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player6 ); ?></div>
				<?php endif;
				break;      
			case "player7":      
				if ( ! empty( $player7 ) ) : ?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player7 ); ?></div>
				<?php endif;
				break;      	
			case "player8":      
				if ( ! empty( $player8 ) ) : ?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player8 ); ?></div>
				<?php endif;
				break;      	
			case "player9":      
				if ( ! empty( $player9 ) ) : ?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player9 ); ?></div>
				<?php endif;
			break;     	
				case "player10":      
				if ( ! empty( $player10 ) ) : ?>
					<div class="gmr-embed-responsive clearfix"><?php echo do_shortcode( $player10 ); ?></div>
				<?php endif;
			break;       		
		}              
		die(); // required to return a proper result  
	}
endif;
// ajax functions
add_action( 'wp_ajax_muvipro_player_content', 'muvipro_player_content' );
add_action( 'wp_ajax_nopriv_muvipro_player_content', 'muvipro_player_content' );

if ( !function_exists( 'muviproifnolicense' ) ) :
	/**
	 * Insert text design by if no license
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function muviproifnolicense() {
		$status = trim( get_option( 'idmuvi_core_license_status' ) );
		
		if( $status == 'ok' ) {
		} else {
			echo '<div class="nolicense">';
				echo '<div class="container">';
					echo __( 'Theme <a href="https://www.idtheme.com/muvipro/">Muvipro</a> Design by <a href="http://www.gianmr.com/">Gian MR</a>','muvipro' );
				echo '</div>';
			echo '</div>';
		}
	}
endif; // endif muviproifnolicense
add_action( 'wp_footer', 'muviproifnolicense', 5 );

if ( ! function_exists( 'gmr_remove_hentry' ) ) :
	/**
	 * Remove hentry for prevent error snippet in some page.
	 * @since 1.0.8
	 * @return string
	 */
	function gmr_remove_hentry( $classes ) {
		if ( is_page() || is_archive() || is_home() || is_front_page() ) {
			$classes = array_diff( $classes, array( 'hentry' ) );
		}
		return $classes;
	}
endif;
add_filter( 'post_class','gmr_remove_hentry' );