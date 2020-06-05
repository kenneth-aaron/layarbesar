<?php
/**
 * Widget API: MuviPro_Episodes_Widget class
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @package Muvipro
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
class MuviPro_Episodes_Widget extends WP_Widget {
	/**
	 * Sets up a Recent Episodes widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array( 'classname' => 'muvipro-episodes-module', 'description' => __( 'Module episodes for module home.','muvipro' ) );
		parent::__construct( 'muvipro-episodes', __( 'Module Episodes (Muvipro)','muvipro' ), $widget_ops );
	}
	
	/**
	 * Outputs the content for Mailchimp Form.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Mailchimp Form.
	 */
    public function widget($args, $instance) {
		
		global $post;
		
		// Title
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		// Link Title
		$link_title 		= ( ! empty( $instance[ 'link_title' ] ) ) ? esc_url( $instance[ 'link_title' ] ) : '';
		
		echo $args['before_widget'];
		if ( $title ) {
			if ( !empty ( $link_title ) ) {
				echo '<div class="row">';
					echo '<div class="col-md-10">';
			}
						echo $args['before_title'] . $title . $args['after_title'];
			if ( !empty ( $link_title ) ) {
					echo '</div>';
					echo '<div class="col-md-2"><div class="module-linktitle"><h4><a href="'.$link_title.'" title="'.__( 'Permalink to: ','muvipro' ). $title .'">'.__( 'More Movie','muvipro' ).'</a></h4></div></div>';
				echo '</div>';
			}
		}
		// Base Id Widget
		$idmuv_widget_ID = $this->id_base . '-' . $this->number;
		// Excerpt Length
        $idmuv_number_posts 		= ( ! empty( $instance[ 'idmuv_number_posts' ] ) ) ? absint( $instance[ 'idmuv_number_posts' ] ) : absint( 8 );
		// Title Length
        $idmuv_title_length 		= ( ! empty( $instance[ 'idmuv_title_length' ] ) ) ? absint( $instance[ 'idmuv_title_length' ] ) : absint( 40 );
		
		// filter the arguments for the Recent Posts widget:
		
		// standard params
		$query_args = array(
			'post_type'           => array ( 'episode' ),
			'posts_per_page'      => $idmuv_number_posts,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			// make it fast withour update term cache and cache results
			// https://thomasgriffin.io/optimize-wordpress-queries/
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		);
		
		$query_args[ 'ignore_sticky_posts' ] = true;
		
		// set order of posts in widget
		$query_args[ 'orderby' ] = 'date';
		$query_args[ 'order' ] = 'DESC';

		// run the query: get the latest posts
		$rp = new WP_Query( apply_filters( 'idmuv_rp_widget_episodes_args', $query_args ) );
		
		?>

			<div class="row grid-container gmr-module-posts">
				<?php while ( $rp->have_posts() ) : $rp->the_post(); ?>
					<div class="col-md-125" <?php echo muvipro_itemtype_schema( 'Movie' ); ?>>
						<div class="gmr-item-modulepost">
							<?php
								// Add thumnail
								if ( has_post_thumbnail() ) :
										echo '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">';
											the_post_thumbnail( 'medium', array( 'itemprop'=>'image' ) );
										echo '</a>';
								else :
									// do_action( 'funct', $size, $link, $classes = '', $echo = true );
									do_action( 'idmuvi_core_get_images', 'medium', true );
								endif; // endif; has_post_thumbnail()
							?>
							
							<header class="entry-header text-center">
								<div class="gmr-button-widget">
									<?php 
										$trailer = get_post_meta( $post->ID, 'IDMUVICORE_Trailer', true );
										// Check if the custom field has a value.
										if ( ! empty( $trailer ) ) {
											echo '<div class="clearfix gmr-popup-button-widget">';
											echo '<a href="https://www.youtube.com/watch?v=' . $trailer . '" class="button gmr-trailer-popup" title="' . the_title_attribute( array( 'before' => __( 'Trailer for ','muvipro' ), 'after' => '', 'echo' => 0 ) ) . '">' . __( 'Trailer','muvipro' ) . '</a>';
											echo '</div>';
										}
									?>
									<div class="clearfix">
										<a href="<?php the_permalink(); ?>" class="button" <?php echo muvipro_itemprop_schema( 'url' ); ?> title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '' ) ); ?>" rel="bookmark"><?php echo __( 'Watch Movie','muvipro' ); ?></a>
									</div>
								</div>
								<h2 class="entry-title" <?php echo muvipro_itemprop_schema( 'headline' ); ?>>
									<a href="<?php the_permalink(); ?>" <?php echo muvipro_itemprop_schema( 'url' ); ?> title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '' ) ); ?>" rel="bookmark">
										<?php 
											if ( $post_title = $this->get_the_trimmed_post_title( $idmuv_title_length ) ) { 
												echo $post_title; 
											} else { 
												the_title(); 
											} 										
										?>									
									</a>
								</h2>
							</header><!-- .entry-header -->
							
							<?php
								$rating = get_post_meta( $post->ID, 'IDMUVICORE_tmdbRating', true ); 
								if ( ! empty( $rating ) ) {
									echo '<div class="gmr-rating-item">' . __( 'Rating: ','muvipro' ) . $rating . '</div>';
								}
								
								$release = get_post_meta( $post->ID, 'IDMUVICORE_Released', true );
								// Check if the custom field has a value.
								if ( ! empty( $release ) ) {
									if ( gmr_checkIsAValidDate($release) == true ) {
										$datetime = new DateTime( $release );
										echo '<span class="screen-reader-text"><time itemprop="dateCreated" datetime="'.$datetime->format('c').'">'.$release.'</time></span>';
									}
								}

								if( !is_wp_error( get_the_term_list( $post->ID, 'muvidirector' ) ) ) {
									$muvidir = get_the_term_list( $post->ID, 'muvidirector' );
									if ( !empty ( $muvidir ) ) {
										echo '<span class="screen-reader-text">';
										echo get_the_term_list( $post->ID, 'muvidirector', '<span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>, <span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>' );
										echo '</span>';
									}
								}
								
							?>
								
						</div>
					</div>
				<?php endwhile; ?>
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
	 *                            MuviPro_Episodes_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
    public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, 
			array( 
				'title' => '', 
				'link_title' => '', 
				'idmuv_number_posts' => 8,
				'idmuv_title_length' => 40
			) 
		);
		// Title
		$instance['title'] 								= sanitize_text_field( $new_instance['title'] );
		// Link Title
		$instance['link_title']							= esc_url( $new_instance[ 'link_title' ] );
		// Number Episodes
        $instance['idmuv_number_posts']          		= absint( $new_instance[ 'idmuv_number_posts' ] );
		// Title Length
        $instance['idmuv_title_length']          		= absint( $new_instance[ 'idmuv_title_length' ] );
		
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
				'title' => 'Recent Episode', 
				'link_title' => '',
				'idmuv_number_posts' => 8,
				'idmuv_title_length' => 40
			) 
		);
		// Title
		$title 							= sanitize_text_field( $instance['title'] );
		// Link Title
		$link_title 					= esc_url( $instance[ 'link_title' ] );
		// Number episodes
        $idmuv_number_posts          	= absint( $instance[ 'idmuv_number_posts' ] );
		// Title Length
        $idmuv_title_length          	= absint( $instance[ 'idmuv_title_length' ] );
		
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:','muvipro' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('link_title'); ?>"><?php _e( 'Link Title:','muvipro' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('link_title'); ?>" name="<?php echo $this->get_field_name('link_title'); ?>" type="url" value="<?php echo esc_attr($link_title); ?>" />
			<br />
            <small><?php _e( 'Target url for title (example: http://www.domain.com/target), leave blank if you want using title without link.','muvipro' ); ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_number_posts'); ?>"><?php _e( 'Number post','muvipro' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('idmuv_number_posts'); ?>" name="<?php echo $this->get_field_name('idmuv_number_posts'); ?>" type="number" value="<?php echo esc_attr($idmuv_number_posts); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_title_length'); ?>"><?php _e( 'Maximum length of title','muvipro' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('idmuv_title_length'); ?>" name="<?php echo $this->get_field_name('idmuv_title_length'); ?>" type="number" value="<?php echo esc_attr($idmuv_title_length); ?>" />
		</p>
		<?php
    }
	
	/**
	 * Returns the shortened episode title, must use in a loop.
	 *
	 * @since 1.0.0
	 */
	private function get_the_trimmed_post_title( $len = 40, $more = '&hellip;' ) {
		
		// get current episode's post_title
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
	
}

add_action( 'widgets_init', function() {
    register_widget( 'MuviPro_Episodes_Widget' );
} );