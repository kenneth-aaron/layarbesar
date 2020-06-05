<?php
/**
 * Widget API: Idmuvi_Advance_Search class
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
class Idmuvi_Advance_Search extends WP_Widget {
	/**
	 * Sets up a Advance Search widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array( 'classname' => 'idmuvi-advance-search', 'description' => __( 'Advance Movie Search widget.','idmuvi-core' ) );
		parent::__construct( 'idmuvi-search', __( 'Movie Search (Idmuvi)','idmuvi-core' ), $widget_ops );
		
		// add action pre_get_posts
		add_action( 'pre_get_posts', array( $this, 'advanced_search_query' ) );
	}
	
	/**
	 * Outputs the content for Movie Search Form.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Movie Search.
	 */
    public function widget($args, $instance) {
		
		global $post;
		
		// Title
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		?>

		<div class="gmr-filter-search">
			<form method="get" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			 
				<!-- This is telling the form submit it is going to be search -->
				<input type="text" name="s" value="" placeholder="<?php echo __( 'Enter Movie', 'idmuvi-core' ); ?>"/>
				<!-- This is adding an extra 'advanced' string to the URL so we can make difference between normal and this custom search -->
				<input type="hidden" name="search" value="advanced"/>
				
				<select name="post_type">
					<option value=""><?php echo __('All Type','idmuvi-core'); ?></option>
					<option value="movie"<?php if( ( !empty( $_GET['post_type'] ) && $_GET['post_type'] == 'movie' ) ) echo ' selected="selected"'; ?>><?php echo __('Movie','idmuvi-core'); ?></option>
					<option value="tv"<?php if( ( !empty( $_GET['post_type'] ) && $_GET['post_type'] == 'tv' ) ) echo ' selected="selected"'; ?>><?php echo __('TV Show','idmuvi-core'); ?></option>
				</select>
				
				<?php $index = get_terms( 'muviindex' );
				if( !empty( $index ) && !is_wp_error( $index ) ):
				?>
					<select name="index">
						<option value=""><?php echo __('By Index','idmuvi-core'); ?></option>
						<?php foreach( $index as $term ): ?>
							<option value="<?php echo $term->slug; ?>"<?php if( ( !empty( $_GET['index'] ) && $_GET['index'] == $term->slug ) ) echo ' selected="selected"'; ?>><?php echo __('By Index','idmuvi-core'); ?> <?php echo $term->name; ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
				
				<select name="orderby">
					<option value=""><?php echo __('Order','idmuvi-core'); ?></option>
					<option value="title"<?php if( ( !empty( $_GET['orderby'] ) && $_GET['orderby'] == 'title' ) ) echo ' selected="selected"'; ?>><?php echo __('Order By Title','idmuvi-core'); ?></option>
					<option value="date"<?php if( ( !empty( $_GET['orderby'] ) && $_GET['orderby'] == 'date' ) ) echo ' selected="selected"'; ?>><?php echo __('Order By Date','idmuvi-core'); ?></option>
					<option value="rating"<?php if( ( !empty( $_GET['orderby'] ) && $_GET['orderby'] == 'rating' ) ) echo ' selected="selected"'; ?>><?php echo __('Order By Rating','idmuvi-core'); ?></option>
				</select>
				
				<?php $categories = get_categories();
				if( !empty( $categories ) && !is_wp_error( $categories ) ):
				?>
					<select name="genre">
						<option value=""><?php echo __('All Genres','idmuvi-core'); ?></option>
						<?php foreach( $categories as $term ) : ?>
							<option value="<?php echo $term->slug; ?>"<?php if( ( !empty( $_GET['genre'] ) && $_GET['genre'] == $term->slug ) ) echo ' selected="selected"'; ?>><?php echo $term->name; ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
				
				<?php $year = get_terms( 'muviyear' );
				if(!empty($year) && !is_wp_error($year)):
				?>
					<select name="movieyear">
						<option value=""><?php echo __('All Years','idmuvi-core'); ?></option>
						<?php foreach($year as $term): ?>
							<option value="<?php echo $term->slug; ?>"<?php if( ( !empty( $_GET['movieyear'] ) && $_GET['movieyear'] == $term->slug ) ) echo ' selected="selected"'; ?>><?php echo $term->name; ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
				
				<?php $country = get_terms( 'muvicountry' );
				if(!empty($country) && !is_wp_error($country)):
				?>
					<select name="country">
						<option value=""><?php echo __('All Countries','idmuvi-core'); ?></option>
						<?php foreach($country as $term): ?>
							<option value="<?php echo $term->slug; ?>"<?php if( ( !empty( $_GET['country'] ) && $_GET['country'] == $term->slug ) ) echo ' selected="selected"'; ?>><?php echo $term->name; ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
				
				<?php $quality = get_terms( 'muviquality' );
				if( !empty( $quality ) && !is_wp_error( $quality ) ):
				?>
					<select name="quality">
						<option value=""><?php echo __('All Qualities','idmuvi-core'); ?></option>
						<?php foreach( $quality as $term ): ?>
							<option value="<?php echo $term->slug; ?>"<?php if( ( !empty( $_GET['quality'] ) && $_GET['quality'] == $term->slug ) ) echo ' selected="selected"'; ?>><?php echo $term->name; ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
				
				<input type="submit" value="Search"/>
			 
			</form>
		</div>
			
		<?php
		echo $args['after_widget'];
    }
	
	/**
	 * Handles updating settings for the current Mailchimp widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            Idmuvi_Mailchimp_form::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
    public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, 
			array( 
				'title' => ''
			) 
		);
		// Title
		$instance['title'] 								= sanitize_text_field( $new_instance['title'] );
		
        return $instance;
    }
	
	/**
	 * Outputs the settings form for the Mailchimp widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, 
			array( 
				'title' => 'Search Movie'
			) 
		);
		// Title
		$title 							= sanitize_text_field( $instance['title'] );
		
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<?php
    }
	
	public function advanced_search_query( $query ) {
		// set up execution conditions to only run when its submitted from our Advanced Search form
		// Do not affect queries for admin pages
		if( !is_admin() ) {
			// Do not affect queries if not in main query
			if ( $query->is_main_query() ) {
				if ( isset( $_REQUEST['search'] ) && $_REQUEST['search'] == 'advanced' && $query->is_search ) {

					// limit queery for custom post type
					$posttype 		= !empty($_GET['post_type']) ? $_GET['post_type'] : '';
					if( !empty( $posttype ) ) {
						if ( $posttype == 'tv' ) {
							$query->set( 'post_type', array( 'tv' ) );
						} elseif ( $posttype == 'movie' ) {
							$query->set( 'post_type', array( 'post' ) );
						}
					} else {
						$query->set( 'post_type', array( 'post', 'tv' ) );
					}
					$query->set( 'post_status', 'publish' );

					// Get query strings from URL and store the min a variable
					$order 		= !empty($_GET['orderby']) ? $_GET['orderby'] : '';
					$genre 		= !empty($_GET['genre']) ? $_GET['genre'] : '';
					$year 		= !empty($_GET['movieyear']) ? $_GET['movieyear'] : '';
					$index 		= !empty($_GET['index']) ? $_GET['index'] : '';
					$country 	= !empty($_GET['country']) ? $_GET['country'] : '';
					$quality 	= !empty($_GET['quality']) ? $_GET['quality'] : '';
					
					if( !empty($order) ) {
						if ( $order == 'title' ) {
							$query->set( 'orderby', 'title' );
						} elseif ( $order == 'date' ) {
							$query->set( 'orderby', 'date' );
						} elseif ( $order == 'rating' ) {
							$query->set( 'meta_key', 'IDMUVICORE_tmdbRating' );
							$query->set( 'orderby', 'meta_value_num' );
						} else {
							$query->set( 'orderby', 'date' );
						}
					}
					
					$taxquery = array();
					$taxquery['relation'] = 'AND';
					if( !empty($genre) ) {
						$taxquery[] = array(
							'taxonomy' => 'category',
							'field' => 'slug',
							'terms' =>  array( $genre ),
							'operator'=> 'IN'
						);
					}
					
					if( !empty($year) ) {
						$taxquery[] = array(
							'taxonomy' => 'muviyear',
							'field' => 'slug',
							'terms' => array( $year ),
							'operator'=> 'IN'
						);
					}
					
					if( !empty($index) ) {
						$taxquery[] = array(
							'taxonomy' => 'muviindex',
							'field' => 'slug',
							'terms' => array( $index ),
							'operator'=> 'IN'
						);
					}
					
					if( !empty($country) ) {
						$taxquery[] = array(
							'taxonomy' => 'muvicountry',
							'field' => 'slug',
							'terms' => array( $country ),
							'operator'=> 'IN'
						);
					}
					
					if( !empty($quality) ) {
						$taxquery[] = array(
							'taxonomy' => 'muviquality',
							'field' => 'slug',
							'terms' => array( $quality ),
							'operator'=> 'IN'
						);
					}
					$query->set( 'tax_query', $taxquery );

					return; // always return
				}
			}
		}
	}

	
}

add_action( 'widgets_init', function() {
    register_widget( 'Idmuvi_Advance_Search' );
} );