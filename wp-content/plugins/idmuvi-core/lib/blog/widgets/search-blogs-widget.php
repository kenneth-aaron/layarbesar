<?php
/**
 * Widget API: Idmuvi_Core_Search_Blogs class
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
 * Add the Idmuvi_Core_Search_Blogs widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Idmuvi_Core_Search_Blogs extends WP_Widget {
	/**
	 * Sets up a Idmuvi_Core_Search_Blogs widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_search',
			'description'                 => __( 'Add search for documentation.', 'idmuvi-core' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'idmuvi-core-search-blogs', __( 'Search Blogs (Idmuvi)', 'idmuvi-core' ), $widget_ops );
	}

	/**
	 * Outputs the content for Idmuvi_Core_Search_Blogs widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Idmuvi_Core_Search_Blogs widget.
	 */
	public function widget( $args, $instance ) {
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

			echo '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
					<label>
						<span class="screen-reader-text">' . esc_html__( 'Search for:', 'idmuvi-core' ) . '</span>
						<input type="search" class="search-field" placeholder="' . esc_html__( 'Search blogs &hellip;', 'idmuvi-core' ) . '" value="' . get_search_query() . '" name="s" />
					</label>
					<input type="hidden" name="post_type" value="blogs" />
					<input type="submit" class="search-submit" value="' . esc_html__( 'Search', 'idmuvi-core' ) . '" />
				</form>';

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current Search widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$new_instance      = wp_parse_args( (array) $new_instance, array( 'title' => '' ) );
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}

	/**
	 * Outputs the settings form for the Search widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title    = $instance['title'];
		?>
		<p><label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'idmuvi-core' ); ?> <input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		<?php
	}
}

add_action(
	'widgets_init',
	function() {
		register_widget( 'Idmuvi_Core_Search_Blogs' );
	}
);
