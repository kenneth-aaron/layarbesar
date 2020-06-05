<?php
/**
 * Widget API: Idmuvi_Categories_Blogs class
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
 * Add the Idmuvi_Categories_Blogs widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Idmuvi_Categories_Blogs extends WP_Widget {
	/**
	 * Sets up a Idmuvi_Categories_Blogs widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_categories',
			'description'                 => __( 'A list or dropdown of categories blog.', 'idmuvi-core' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'idmuvi-categories-blogs', __( 'Categories Blog (Idmuvi)', 'idmuvi-core' ), $widget_ops );
	}

	/**
	 * Outputs the content for Idmuvi_Categories_Blogs widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Idmuvi_Categories_Blogs widget.
	 */
	public function widget( $args, $instance ) {
		static $first_dropdown = true;
		// Title.
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		global $wp_query;

		$cat_args = array(
			'orderby'      => 'name',
			'show_count'   => $c,
			'taxonomy'     => 'blog_category',
			'post_type'    => 'blogs',
			'hierarchical' => $h,
		);

		if ( $d ) {
			$dropdown_id = "{$this->id_base}-dropdown-{$this->number}";

			echo '<label class="screen-reader-text" for="' . esc_attr( $dropdown_id ) . '">' . $title . '</label>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			$cat_args['show_option_none'] = __( 'Select Category', 'idmuvi-core' );
			$cat_args['name']             = 'category' === 'blog_category' ? 'category_name' : 'blog_category';
			$cat_args['id']               = $dropdown_id;
			$cat_args['value_field']      = 'slug';
			?>
			<form action="<?php bloginfo( 'url' ); ?>" method="get">
						<?php
						wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
						?>
			<script>
			(function() {
			/* <![CDATA[ */
				var dropdown = document.getElementById( "<?php echo esc_js( $dropdown_id ); ?>" );
				function onCatChange() {
					if ( dropdown.options[dropdown.selectedIndex].value ) {
						return dropdown.form.submit();
					}
				}
				dropdown.onchange = onCatChange;
			})();
			/* ]]> */
			</script>
			</form>
			<?php
		} else {
			?>
			<ul>
				<?php
				$cat_args['title_li'] = '';
				wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
				?>
			</ul>
			<?php
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current Categories widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['title']        = sanitize_text_field( $new_instance['title'] );
		$instance['count']        = ! empty( $new_instance['count'] ) ? 1 : 0;
		$instance['hierarchical'] = ! empty( $new_instance['hierarchical'] ) ? 1 : 0;
		$instance['dropdown']     = ! empty( $new_instance['dropdown'] ) ? 1 : 0;

		return $instance;
	}

	/**
	 * Outputs the settings form for the Categories widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		// Defaults.
		$instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title        = sanitize_text_field( $instance['title'] );
		$count        = isset( $instance['count'] ) ? (bool) $instance['count'] : false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		$dropdown     = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
		?>
		<p><label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'idmuvi-core' ); ?></label>
		<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo esc_html( $this->get_field_id( 'dropdown' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'dropdown' ) ); ?>"<?php checked( $dropdown ); ?> />
		<label for="<?php echo esc_html( $this->get_field_id( 'dropdown' ) ); ?>"><?php esc_html_e( 'Display as dropdown', 'idmuvi-core' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo esc_html( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'count' ) ); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo esc_html( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Show post counts', 'idmuvi-core' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo esc_html( $this->get_field_id( 'hierarchical' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'hierarchical' ) ); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo esc_html( $this->get_field_id( 'hierarchical' ) ); ?>"><?php esc_html_e( 'Show hierarchy', 'idmuvi-core' ); ?></label></p>
		<?php
	}
}

add_action(
	'widgets_init',
	function() {
		register_widget( 'Idmuvi_Categories_Blogs' );
	}
);
