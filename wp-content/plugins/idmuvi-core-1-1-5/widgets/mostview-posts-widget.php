<?php
/**
 * Widget API: Idmuvi_Mostview_Posts class
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @package Idmuvi Core
 * @subpackage Widgets
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Add the RPSL widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Idmuvi_Mostview_Posts extends WP_Widget {
	/**
	 * Sets up a Recent Posts widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array( 'classname' => 'idmuvi-mostview-widget', 'description' => __( 'Most view movies with thumbnails widget. Require wp postview plugin.','idmuvi-core' ) );
		parent::__construct( 'idmuvi-mostview', __( 'Most View Movies (Idmuvi)','idmuvi-core' ), $widget_ops );
		// add action for admin_register_scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_register_scripts' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'admin_print_scripts' ), 9999 );
		
	}
	
	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0
	 *
	 * @param string $hook_suffix
	 */
	public function admin_register_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}
		wp_enqueue_script( 'suggest' );
	}
	
	/**
	 * Print scripts.
	 *
	 * @since 1.0
	 */
	public function admin_print_scripts() {
		?>
		<script>
			function setSuggest_cat_recent(id) {
				jQuery('#' + id).suggest("<?php echo admin_url('admin-ajax.php'); ?>?action=ajax-tag-search&tax=category", {multiple:true, multipleSep: ","});
			}
			function setSuggest_tag_recent(id) {
				jQuery('#' + id).suggest("<?php echo admin_url('admin-ajax.php'); ?>?action=ajax-tag-search&tax=post_tag", {multiple:true, multipleSep: ","});
			}
		</script>
		<?php
	}
	
	/**
	 * Outputs the content for Most View Posts.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Most View Posts.
	 */
    public function widget($args, $instance) {
		
		global $post;
		
		// Title
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		// Base Id Widget
		$idmuv_widget_ID = $this->id_base . '-' . $this->number;
		// Category Name
        $idmuv_category 					= ( ! empty( $instance[ 'idmuv_category' ] ) ) ? strip_tags( $instance[ 'idmuv_category' ] ) : '';
		// Tag Name
        $idmuv_tag 							= ( ! empty( $instance[ 'idmuv_tag' ] ) ) ? strip_tags( $instance[ 'idmuv_tag' ] ) : '';
		// Excerpt Length
        $idmuv_number_posts 				= ( ! empty( $instance[ 'idmuv_number_posts' ] ) ) 		? absint( $instance[ 'idmuv_number_posts' ] ) 				: absint( 5 );
		// Title Length
        $idmuv_title_length 				= ( ! empty( $instance[ 'idmuv_title_length' ] ) ) 		? absint( $instance[ 'idmuv_title_length' ] ) 				: absint( 40 );
		// Popular by date
		$idmuv_popular_date					= ( isset( $instance[ 'idmuv_popular_date' ] ) ) 		? esc_attr( $instance[ 'idmuv_popular_date' ] ) 			: esc_attr( 'alltime' );
		// Hide current post
		$idmuv_hide_current_post			= ( isset( $instance[ 'idmuv_hide_current_post' ] ) ) 	? (bool) $instance[ 'idmuv_hide_current_post' ]				: false;
		$idmuv_show_view_data				= ( isset( $instance[ 'idmuv_show_view_data' ] ) ) 		? (bool) $instance[ 'idmuv_show_view_data' ]				: true;
		$idmuv_show_meta					= ( isset( $instance[ 'idmuv_show_meta' ] ) )			? (bool) $instance[ 'idmuv_show_meta' ]						: true;
		$idmuv_show_thumb					= ( isset( $instance[ 'idmuv_show_thumb' ] ) )			? (bool) $instance[ 'idmuv_show_thumb' ]					: true;
		
		// filter the arguments for the Recent Posts widget:
		
		// standard params
		$query_args = array(
			'post_type'         	=> array( 'post', 'tv' ),
			'posts_per_page'      	=> $idmuv_number_posts,
			'no_found_rows'       	=> true,
			'post_status'         	=> 'publish',
			// make it fast withour update term cache and cache results
			// https://thomasgriffin.io/optimize-wordpress-queries/
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'cache_results'          => false,
		);
		
		$query_args[ 'ignore_sticky_posts' ] = true;
		$query_args[ 'meta_key' ] = 'views'; 
		$query_args[ 'orderby' ] = 'meta_value_num'; 
		
		// set order of posts in widget
		$query_args[ 'order' ] = 'DESC';
		
		if ( $idmuv_popular_date == 'weekly' ) {
			// Get posts last week
			$query_args[ 'date_query' ] = array(
				array(
					'after' => '1 week ago',
				),
			);
		} elseif ( $idmuv_popular_date == 'mountly' ) {
			// Get posts last mount
			$query_args[ 'date_query' ] = array(
				array(
					'after' => '1 month ago',
				),
			);
		} elseif ( $idmuv_popular_date == 'secondmountly' ) {
			// Get posts last mount
			$query_args[ 'date_query' ] = array(
				array(
					'after' => '2 months ago',
				),
			);
		} elseif ( $idmuv_popular_date == 'yearly' ) {
			// Get posts last mount
			$query_args[ 'date_query' ] = array(
				array(
					'after' => '1 year ago',
				),
			);
		}
		
		// add categories param only if 'all categories' was not selected
		$cat_id_array = $this->generate_cat_id_from_name( $idmuv_category );
		if ( count( $cat_id_array ) > 0 ) {
			$query_args[ 'category__in' ] = $cat_id_array;
		}
		
		// add tags param only if 'all tags' was not selected
		$tag_id_array = $this->generate_tag_id_from_name( $idmuv_tag );
		if ( count( $tag_id_array ) > 0 ) {
			$query_args[ 'tag__in' ] = $tag_id_array;
		}
		
		// exclude current displayed post
		if ( $idmuv_hide_current_post ) {
			if ( isset( $post->ID ) and is_singular() ) {
				$query_args[ 'post__not_in' ] = array( $post->ID );
			}
		}

		// run the query: get the latest posts
		$rp = new WP_Query( apply_filters( 'idmuv_rp_widget_posts_args', $query_args ) );
		
		?>

			<div class="idmuvi-rp-widget">
				<div class="idmuvi-rp">
					<ul>
						<?php while ( $rp->have_posts() ) : $rp->the_post();
							echo '<li';
								if ( is_sticky() ) { 
									echo ' class="idmuvi-rp-sticky"';
								}
							echo '>'; ?>
								<div class="idmuvi-rp-link clearfix">
									<a href="<?php the_permalink(); ?>" itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ','idmuvi-core' ), 'after' => '' ) ); ?>"><?php 
										if ( $idmuv_show_thumb ) : 
											// look for featured image
											if ( has_post_thumbnail() ) : 
												the_post_thumbnail( 'thumbnail', array( 'itemprop'=>'image' ) );
												
											else :
												// do_action( 'funct', $size, $link, $classes = '', $echo = true );
												do_action( 'idmuvi_core_get_images', 'thumbnail', false );
												
											endif; // has_post_thumbnail
										endif; // show_thumb ?>
											
										<span class="idmuvi-rp-title">
											<?php 
												if ( $post_title = $this->get_the_trimmed_post_title( $idmuv_title_length ) ) { 
													echo $post_title; 
												} else { 
													the_title(); 
												} 
											?>
										</span>
									</a>
									<?php if ( $idmuv_show_meta ) : ?>
										<div class="idmuvi-rp-meta idmuvi-rp-author">
											<?php
											$categories_list = get_the_category_list( esc_html__( ', ','idmuvi-core' ) );
											if ( $categories_list ) {
												echo $categories_list;
												echo ', ';
											}
											if( !is_wp_error( get_the_term_list( $post->ID, 'muvicountry' ) ) ) {
												$muvidir = get_the_term_list( $post->ID, 'muvidirector' );
												if ( !empty ($muvidir) ) {
													echo get_the_term_list( $post->ID, 'muvicountry', '<span itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">', '</span>, <span itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">', '</span>' );
												}
											} ?>
											<?php 
												if ( $idmuv_show_view_data ) {
													if(function_exists('the_views')) { 
														echo '<div>';
														the_views(); 
														echo '</div>';
													} 
												} 
											?>
										</div>
									<?php endif; ?>
								</div>
								<?php 
							echo '</li>';
						endwhile; ?>
					</ul>
				</div>
			</div>
			
		<?php
		echo $args['after_widget'];
    }
	
	/**
	 * Handles updating settings for the current Most View Posts widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            Idmuvi_Mostview_Posts::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
    public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, 
			array( 
				'title' 					=> '', 
				'idmuv_category' => '', 
				'idmuv_tag' => '', 
				'idmuv_number_posts' 		=> 5,
				'idmuv_title_length' 		=> 40,
				'idmuv_popular_date' 		=> 'alltime'
			) 
		);
		// Title
		$instance['title'] 								= sanitize_text_field( $new_instance['title'] );
		// Category Name
        $instance['idmuv_category']           			= strip_tags( $new_instance[ 'idmuv_category' ] );
		// Tag Name
        $instance['idmuv_tag']           				= strip_tags( $new_instance[ 'idmuv_tag' ] );
		// Number posts
        $instance['idmuv_number_posts']          		= absint( $new_instance[ 'idmuv_number_posts' ] );
		// Title Length
        $instance['idmuv_title_length']          		= absint( $new_instance[ 'idmuv_title_length' ] );
		// Popular range
        $instance['idmuv_popular_date']          		= esc_attr( $new_instance[ 'idmuv_popular_date' ] );
		// Hide current post
        $instance['idmuv_hide_current_post']          	= (bool) $new_instance[ 'idmuv_hide_current_post' ];
		// Show element
		$instance[ 'idmuv_show_meta' ]					= (bool) $new_instance[ 'idmuv_show_meta' ];
		$instance[ 'idmuv_show_view_data' ]				= (bool) $new_instance[ 'idmuv_show_view_data' ];
		$instance[ 'idmuv_show_thumb' ] 				= (bool) $new_instance[ 'idmuv_show_thumb' ];
		
        return $instance;
    }
	
	/**
	 * Outputs the settings form for the Most View Posts widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, 
			array( 
				'title' 					=> 'Most View Movies', 
				'idmuv_category' 			=> '', 
				'idmuv_tag' 				=> '', 
				'idmuv_number_posts' 		=> 5,
				'idmuv_title_length' 		=> 40,
				'idmuv_popular_date' 		=> 'alltime',
				'idmuv_hide_current_post' 	=> false,
				'idmuv_show_meta' 			=> true,
				'idmuv_show_view_data' 		=> true,
				'idmuv_show_thumb' 			=> true
			) 
		);
		// Title
		$title 							= sanitize_text_field( $instance['title'] );
		// Category Name
        $idmuv_category          		= strip_tags( $instance[ 'idmuv_category' ] );
		// Tag Name
        $idmuv_tag          			= strip_tags( $instance[ 'idmuv_tag' ] );
		// Number posts
        $idmuv_number_posts          	= absint( $instance[ 'idmuv_number_posts' ] );
		// Title Length
        $idmuv_title_length          	= absint( $instance[ 'idmuv_title_length' ] );
		// Hide current post
		$idmuv_hide_current_post		= (bool) $instance[ 'idmuv_hide_current_post' ];
		// Popular range
        $idmuv_popular_date          	= esc_attr( $instance[ 'idmuv_popular_date' ] );
		// Show element
		$idmuv_show_meta				= (bool) $instance[ 'idmuv_show_meta' ];
		$idmuv_show_view_data			= (bool) $instance[ 'idmuv_show_view_data' ];
		$idmuv_show_thumb				= (bool) $instance[ 'idmuv_show_thumb' ];
		
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_category'); ?>"><?php _e( 'Selected categories','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'idmuv_category' ); ?>" name="<?php echo $this->get_field_name( 'idmuv_category' ); ?>" type="text" value="<?php echo $idmuv_category; ?>" onfocus ="setSuggest_cat_recent('<?php echo $this->get_field_id( 'idmuv_category' ); ?>');" />
			<br />
            <small><?php _e( 'Category Names, separated by commas. Eg: News, Home Design, Technology.','idmuvi-core' ); ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_tag'); ?>"><?php _e( 'Selected tags','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'idmuv_tag' ); ?>" name="<?php echo $this->get_field_name( 'idmuv_tag' ); ?>" type="text" value="<?php echo $idmuv_tag; ?>" onfocus ="setSuggest_tag_recent('<?php echo $this->get_field_id( 'idmuv_tag' ); ?>');" />
			<br />
            <small><?php _e( 'Tag Names, separated by commas. Eg: Tag 1, Tag 2, etc.','idmuvi-core' ); ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_number_posts'); ?>"><?php _e( 'Number post','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('idmuv_number_posts'); ?>" name="<?php echo $this->get_field_name('idmuv_number_posts'); ?>" type="number" value="<?php echo esc_attr($idmuv_number_posts); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_title_length'); ?>"><?php _e( 'Maximum length of title','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('idmuv_title_length'); ?>" name="<?php echo $this->get_field_name('idmuv_title_length'); ?>" type="number" value="<?php echo esc_attr($idmuv_title_length); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('idmuv_popular_date'); ?>"><?php _e( 'Popular range:','idmuvi-core' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('idmuv_popular_date','idmuvi-core'); ?>" name="<?php echo $this->get_field_name('idmuv_popular_date'); ?>">
				<option value="alltime" <?php selected( $instance['idmuv_popular_date'], 'alltime' ); ?>><?php _e( 'Alltime','idmuvi-core' ); ?></option>
				<option value="yearly" <?php selected( $instance['idmuv_popular_date'], 'yearly' ); ?>><?php _e( '1 Year','idmuvi-core' ); ?></option>
				<option value="secondmountly" <?php selected( $instance['idmuv_popular_date'], 'secondmountly' ); ?>><?php _e( '2 Mounts','idmuvi-core' ); ?></option>
				<option value="mountly" <?php selected( $instance['idmuv_popular_date'], 'mountly' ); ?>><?php _e( '1 Mount','idmuvi-core' ); ?></option>
				<option value="weekly" <?php selected( $instance['idmuv_popular_date'], 'weekly' ); ?>><?php _e( '7 Days','idmuvi-core' ); ?></option>
            </select>
            <br/>
            <small><?php _e( 'Select popular by most view.','idmuvi-core' ); ?></small>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $idmuv_hide_current_post ); ?> id="<?php echo $this->get_field_id('idmuv_hide_current_post'); ?>" name="<?php echo $this->get_field_name( 'idmuv_hide_current_post' ); ?>" />
			<label for="<?php echo $this->get_field_id('idmuv_hide_current_post'); ?>"><?php _e( 'Do not list the current post?', 'idmuvi-core' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $idmuv_show_meta, true ); ?> id="<?php echo $this->get_field_id('idmuv_show_meta'); ?>" name="<?php echo $this->get_field_name( 'idmuv_show_meta' ); ?>" />
			<label for="<?php echo $this->get_field_id('idmuv_show_meta'); ?>"><?php _e( 'Show movie meta?', 'idmuvi-core' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $idmuv_show_view_data, true ); ?> id="<?php echo $this->get_field_id('idmuv_show_view_data'); ?>" name="<?php echo $this->get_field_name( 'idmuv_show_view_data' ); ?>" />
			<label for="<?php echo $this->get_field_id('idmuv_show_view_data'); ?>"><?php _e( 'Show view data?', 'idmuvi-core' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $idmuv_show_thumb, true ); ?> id="<?php echo $this->get_field_id('idmuv_show_thumb'); ?>" name="<?php echo $this->get_field_name( 'idmuv_show_thumb' ); ?>" />
			<label for="<?php echo $this->get_field_id('idmuv_show_thumb'); ?>"><?php _e( 'Show Thumbnail?', 'idmuvi-core' ); ?></label>
		</p>
		<?php
    }
	
	/**
	 * Return the array index of a given ID
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function get_parent_index( $arr, $id ) {
		$len = count( $arr );
		if ( 0 == $len ) {
			return false;
		}
		$id = absint( $id );
		for ( $i = 0; $i < $len; $i++ ) {
			if ( $id == $arr[ $i ][ 'id' ] ) {
				return $i;
			}
		}
		return false; 
	}
	
	/**
	 * Returns the shortened post title, must use in a loop.
	 *
	 * @since 1.0.0
	 */
	private function get_the_trimmed_post_title( $len = 40, $more = '&hellip;' ) {
		
		// get current post's post_title
		$post_title = get_the_title();

		// if post_title is longer than desired
		if ( mb_strlen( $post_title ) > $len ) {
			// get post_title in desired length
			$post_title = mb_substr( $post_title, 0, $len );
			// append ellipses
			$post_title .= $more;
		}
		// return text
		return $post_title;
	}
	
	/**
	 * Generate Tag id from Tag name
	 *
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @return array List of tag ids
	 */
	private function generate_tag_id_from_name( $tags ) {
		global $post;

		$tag_id_array = array();

		if ( '' != $tags ) {
			$tag_array = explode( ',', $tags );

			foreach ( $tag_array as $tag ) {
				$tag_id_array[] = $this->get_tag_ID( trim( $tag ) );
			}
		}

		return $tag_id_array;
	}
	
	/**
	 * Generate Cat id from Cat name
	 *
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @return array List of cat ids
	 */
	private function generate_cat_id_from_name( $cats ) {
		global $post;

		$cat_id_array = array();

		if ( '' != $cats ) {
			$cat_array = explode( ',', $cats );

			foreach ( $cat_array as $cat ) {
				$cat_id_array[] = $this->get_cat_ID( trim( $cat ) );
			}
		}

		return $cat_id_array;
	}
	
	/**
	 * Get tag id from tag name or slug
	 *
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @param string  $tag_name Tag name or slug
	 * @return int Term id. 0 if not found
	 */
	private function get_tag_ID( $tag_name ) {
		// Try tag name first
		$tag = get_term_by( 'name', $tag_name, 'post_tag' );
		if ( $tag ) {
			return $tag->term_id;
		} else {
			// if Tag name is not found, try tag slug
			$tag = get_term_by( 'slug', $tag_name, 'post_tag' );
			if ( $tag ) {
				return $tag->term_id;
			}
			return 0;
		}
	}
	
	/**
	 * Get cat id from cat name or slug
	 *
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @param string  $cat_name cat name or slug
	 * @return int Term id. 0 if not found
	 */
	private function get_cat_ID( $cat_name ) {
		// Try cat name first
		$cat = get_term_by( 'name', $cat_name, 'category' );
		if ( $cat ) {
			return $cat->term_id;
		} else {
			// if cat name is not found, try cat slug
			$cat = get_term_by( 'slug', $cat_name, 'category' );
			if ( $cat ) {
				return $cat->term_id;
			}
			return 0;
		}
	}
	
}

add_action( 'widgets_init', function() {
    register_widget( 'Idmuvi_Mostview_Posts' );
} );