<?php
/**
 * Widget API: Idmuvi_RPSP_Form class
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @package Idmuvi Core
 * @subpackage Widgets
 * @since 1.0.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the RPSL widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Idmuvi_RPSP_Form extends WP_Widget {
	/**
	 * Sets up a Recent Movies widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'idmuvi-rp-widget',
			'description' => __( 'Recent movies with thumbnails widget.', 'idmuvi-core' ),
		);
		parent::__construct( 'idmuvi-rp', __( 'Recent Movies (Idmuvi)', 'idmuvi-core' ), $widget_ops );

		// Add action for admin_register_scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_register_scripts' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'admin_print_scripts' ), 9999 );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0
	 *
	 * @param string $hook_suffix Hook Suffix.
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
				jQuery('#' + id).suggest("<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>?action=ajax-tag-search&tax=category", {multiple:true, multipleSep: ","});
			}
			function setSuggest_tag_recent(id) {
				jQuery('#' + id).suggest("<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>?action=ajax-tag-search&tax=post_tag", {multiple:true, multipleSep: ","});
			}
		</script>
		<?php
	}

	/**
	 * Outputs the content for Recent Movies Form.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Recent Movies.
	 */
	public function widget( $args, $instance ) {

		global $post;

		// Title.
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		// Base Id Widget.
		$idmuv_widget_id = $this->id_base . '-' . $this->number;
		// Category Name.
		$idmuv_category = ( ! empty( $instance['idmuv_category'] ) ) ? wp_strip_all_tags( $instance['idmuv_category'] ) : '';
		// Tag Name.
		$idmuv_tag = ( ! empty( $instance['idmuv_tag'] ) ) ? wp_strip_all_tags( $instance['idmuv_tag'] ) : '';
		// orderby.
		$idmuv_orderby = ( ! empty( $instance['idmuv_orderby'] ) ) ? wp_strip_all_tags( $instance['idmuv_orderby'] ) : wp_strip_all_tags( 'date' );
		// Excerpt Length.
		$idmuv_number_posts = ( ! empty( $instance['idmuv_number_posts'] ) ) ? absint( $instance['idmuv_number_posts'] ) : absint( 5 );
		// Title Length.
		$idmuv_title_length = ( ! empty( $instance['idmuv_title_length'] ) ) ? absint( $instance['idmuv_title_length'] ) : absint( 40 );
		// Hide current post.
		$idmuv_hide_current_post = ( isset( $instance['idmuv_hide_current_post'] ) ) ? (bool) $instance['idmuv_hide_current_post'] : false;
		$idmuv_show_meta         = ( isset( $instance['idmuv_show_meta'] ) ) ? (bool) $instance['idmuv_show_meta'] : true;
		$idmuv_show_thumb        = ( isset( $instance['idmuv_show_thumb'] ) ) ? (bool) $instance['idmuv_show_thumb'] : true;

		// standard params.
		$query_args = array(
			'post_type'              => array( 'post', 'tv' ),
			'posts_per_page'         => $idmuv_number_posts,
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			// make it fast withour update term cache and cache results
			// https://thomasgriffin.io/optimize-wordpress-queries/.
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'cache_results'          => false,
			'fields'                 => 'ids',
		);

		$query_args['ignore_sticky_posts'] = true;

		// set order of posts in widget.
		$query_args['orderby'] = $idmuv_orderby;
		$query_args['order']   = 'DESC';

		// Add categories param only if 'all categories' was not selected.
		$cat_id_array = $this->generate_cat_id_from_name( $idmuv_category );
		if ( count( $cat_id_array ) > 0 ) {
			$query_args['category__in'] = $cat_id_array;
		}

		// Add tags param only if 'all tags' was not selected.
		$tag_id_array = $this->generate_tag_id_from_name( $idmuv_tag );
		if ( count( $tag_id_array ) > 0 ) {
			$query_args['tag__in'] = $tag_id_array;
		}

		// exclude current displayed post.
		if ( $idmuv_hide_current_post ) {
			if ( get_the_ID() && is_singular() ) {
				$query_args['post__not_in'] = array( get_the_ID() );
			}
		}

		// run the query: get the latest posts.
		$rp = new WP_Query( apply_filters( 'idmuv_rp_widget_posts_args', $query_args ) );

		?>

			<div class="idmuvi-rp-widget">
				<div class="idmuvi-rp">
					<ul>
						<?php
						while ( $rp->have_posts() ) :
							$rp->the_post();
							echo '<li';
							if ( is_sticky() ) {
								echo ' class="idmuvi-rp-sticky"';
							}
							echo '>';
							?>
								<div class="idmuvi-rp-link clearfix">
									<a href="<?php the_permalink(); ?>" itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'idmuvi-core' ), 'after' => '' ) ); ?>"><?php
									if ( $idmuv_show_thumb ) :
										// look for featured image.
										if ( has_post_thumbnail() ) :
											the_post_thumbnail( 'thumbnail', array( 'itemprop' => 'image' ) );

										endif; // has_post_thumbnail.
									endif; // show_thumb.
									?>

										<span class="idmuvi-rp-title">
										<?php
										if ( $post_title = $this->get_the_trimmed_post_title( $idmuv_title_length ) ) {
											echo esc_html( $post_title );
										} else {
											the_title();
										}
										?>
										</span>
									</a>
									<?php if ( $idmuv_show_meta ) : ?>
										<div class="idmuvi-rp-meta idmuvi-rp-author">
											<?php
											$categories_list = get_the_category_list( esc_html__( ', ', 'idmuvi-core' ) );
											if ( $categories_list ) {
												echo $categories_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												echo ', ';
											}
											if ( ! is_wp_error( get_the_term_list( get_the_ID(), 'muvicountry' ) ) ) {
												$muvidir = get_the_term_list( get_the_ID(), 'muvidirector' );
												if ( ! empty( $muvidir ) ) {
													echo get_the_term_list( get_the_ID(), 'muvicountry', '<span itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">', '</span>, <span itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">', '</span>' );
												}
											}
											?>
										</div>
									<?php endif; ?>
								</div>
							<?php
							echo '</li>';
						endwhile;
						?>
						<?php wp_reset_postdata(); ?>
					</ul>
				</div>
			</div>

		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current Recent Movies widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            Idmuvi_RPSP_Form::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance     = $old_instance;
		$new_instance = wp_parse_args(
			(array) $new_instance,
			array(
				'title'              => '',
				'idmuv_category'     => '',
				'idmuv_tag'          => '',
				'idmuv_orderby'      => 'date',
				'idmuv_number_posts' => 5,
				'idmuv_title_length' => 40,
			)
		);
		// Title.
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		// Category Name.
		$instance['idmuv_category'] = wp_strip_all_tags( $new_instance['idmuv_category'] );
		// Tag Name.
		$instance['idmuv_tag'] = wp_strip_all_tags( $new_instance['idmuv_tag'] );
		// Order by.
		$instance['idmuv_orderby'] = wp_strip_all_tags( $new_instance['idmuv_orderby'] );
		// Number posts.
		$instance['idmuv_number_posts'] = absint( $new_instance['idmuv_number_posts'] );
		// Title Length.
		$instance['idmuv_title_length'] = absint( $new_instance['idmuv_title_length'] );
		// Hide current post.
		$instance['idmuv_hide_current_post'] = (bool) $new_instance['idmuv_hide_current_post'];
		// Show element.
		$instance['idmuv_show_meta']  = (bool) $new_instance['idmuv_show_meta'];
		$instance['idmuv_show_thumb'] = (bool) $new_instance['idmuv_show_thumb'];

		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Movies widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'                   => 'Recent Movies',
				'idmuv_category'          => '',
				'idmuv_tag'               => '',
				'idmuv_orderby'           => 'date',
				'idmuv_number_posts'      => 5,
				'idmuv_title_length'      => 40,
				'idmuv_hide_current_post' => false,
				'idmuv_show_meta'         => true,
				'idmuv_show_thumb'        => true,
			)
		);
		// Title.
		$title = sanitize_text_field( $instance['title'] );
		// Category Name.
		$idmuv_category = wp_strip_all_tags( $instance['idmuv_category'] );
		// Tag Name.
		$idmuv_tag = wp_strip_all_tags( $instance['idmuv_tag'] );
		// Order by.
		$idmuv_orderby = wp_strip_all_tags( $instance['idmuv_orderby'] );
		// Number posts.
		$idmuv_number_posts = absint( $instance['idmuv_number_posts'] );
		// Title Length.
		$idmuv_title_length = absint( $instance['idmuv_title_length'] );
		// Hide current post.
		$idmuv_hide_current_post = (bool) $instance['idmuv_hide_current_post'];
		// Show element.
		$idmuv_show_meta  = (bool) $instance['idmuv_show_meta'];
		$idmuv_show_thumb = (bool) $instance['idmuv_show_thumb'];

		?>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'idmuvi-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_category' ) ); ?>"><?php esc_html_e( 'Selected categories', 'idmuvi-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_category' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_category' ) ); ?>" type="text" value="<?php echo esc_html( $idmuv_category ); ?>" onfocus ="setSuggest_cat_recent('<?php echo esc_html( $this->get_field_id( 'idmuv_category' ) ); ?>');" />
			<br />
			<small><?php esc_html_e( 'Category Names, separated by commas. Eg: News, Home Design, Technology.', 'idmuvi-core' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_tag' ) ); ?>"><?php esc_html_e( 'Selected tags', 'idmuvi-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_tag' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_tag' ) ); ?>" type="text" value="<?php echo esc_html( $idmuv_tag ); ?>" onfocus ="setSuggest_tag_recent('<?php echo esc_html( $this->get_field_id( 'idmuv_tag' ) ); ?>');" />
			<br />
			<small><?php esc_html_e( 'Tag Names, separated by commas. Eg: Tag 1, Tag 2, etc.', 'idmuvi-core' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_orderby' ) ); ?>"><?php esc_html_e( 'Orderby', 'idmuvi-core' ); ?></label>
			<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_orderby', 'idmuvi-core' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_orderby' ) ); ?>">
				<option value="date" <?php echo selected( $instance['idmuv_orderby'], 'date', false ); ?>><?php esc_html_e( 'Date', 'idmuvi-core' ); ?></option>
				<option value="rand" <?php echo selected( $instance['idmuv_orderby'], 'rand', false ); ?>><?php esc_html_e( 'Random', 'idmuvi-core' ); ?></option>
				<option value="modified" <?php echo selected( $instance['idmuv_orderby'], 'modified', false ); ?>><?php esc_html_e( 'Modified', 'idmuvi-core' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_number_posts' ) ); ?>"><?php esc_html_e( 'Number post', 'idmuvi-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_number_posts' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_number_posts' ) ); ?>" type="number" value="<?php echo esc_attr( $idmuv_number_posts ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_title_length' ) ); ?>"><?php esc_html_e( 'Maximum length of title', 'idmuvi-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_title_length' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_title_length' ) ); ?>" type="number" value="<?php echo esc_attr( $idmuv_title_length ); ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $idmuv_hide_current_post ); ?> id="<?php echo esc_html( $this->get_field_id( 'idmuv_hide_current_post' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_hide_current_post' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_hide_current_post' ) ); ?>"><?php esc_html_e( 'Do not list the current post?', 'idmuvi-core' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $idmuv_show_meta, true ); ?> id="<?php echo esc_html( $this->get_field_id( 'idmuv_show_meta' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_show_meta' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_show_meta' ) ); ?>"><?php esc_html_e( 'Show movie meta?', 'idmuvi-core' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $idmuv_show_thumb, true ); ?> id="<?php echo esc_html( $this->get_field_id( 'idmuv_show_thumb' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_show_thumb' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_show_thumb' ) ); ?>"><?php esc_html_e( 'Show Thumbnail?', 'idmuvi-core' ); ?></label>
		</p>
		<?php
	}

	/**
	 * Return the array index of a given ID
	 *
	 * @param Array  $arr Arr.
	 * @param Number $id Post ID.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function get_parent_index( $arr, $id ) {
		$len = count( $arr );
		if ( 0 === $len ) {
			return false;
		}
		$id = absint( $id );
		for ( $i = 0; $i < $len; $i++ ) {
			if ( $id === $arr[ $i ]['id'] ) {
				return $i;
			}
		}
		return false;
	}

	/**
	 * Returns the shortened post title, must use in a loop.
	 *
	 * @param Number $len Number text to show.
	 * @param String $more Text.
	 * @since 1.0.0
	 */
	private function get_the_trimmed_post_title( $len = 40, $more = '&hellip;' ) {

		// get current post's post_title.
		$post_title = get_the_title();

		// if post_title is longer than desired.
		if ( mb_strlen( $post_title ) > $len ) {
			// get post_title in desired length.
			$post_title = mb_substr( $post_title, 0, $len );
			// append ellipses.
			$post_title .= $more;
		}
		// return text.
		return $post_title;
	}

	/**
	 * Generate Tag id from Tag name
	 *
	 * @param Array $tags Array ID Tags.
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @return array List of tag ids.
	 */
	private function generate_tag_id_from_name( $tags ) {
		global $post;

		$tag_id_array = array();

		if ( ! empty( $tags ) ) {
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
	 * @param Array $cats Array ID Cat.
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @return array List of cat ids
	 */
	private function generate_cat_id_from_name( $cats ) {
		global $post;

		$cat_id_array = array();

		if ( ! empty( $cats ) ) {
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
	 * @param string $tag_name Tag name or slug.
	 * @return int Term id. 0 if not found
	 */
	private function get_tag_ID( $tag_name ) {
		// Try tag name first.
		$tag = get_term_by( 'name', $tag_name, 'post_tag' );
		if ( $tag ) {
			return $tag->term_id;
		} else {
			// if Tag name is not found, try tag slug.
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
	 * @param string $cat_name cat name or slug.
	 * @return int Term id. 0 if not found
	 */
	private function get_cat_ID( $cat_name ) {
		// Try cat name first.
		$cat = get_term_by( 'name', $cat_name, 'category' );
		if ( $cat ) {
			return $cat->term_id;
		} else {
			// if cat name is not found, try cat slug.
			$cat = get_term_by( 'slug', $cat_name, 'category' );
			if ( $cat ) {
				return $cat->term_id;
			}
			return 0;
		}
	}

}

add_action(
	'widgets_init',
	function() {
		register_widget( 'Idmuvi_RPSP_Form' );
	}
);
