<?php
/**
 * Widget API: Idmuvi_Feedburner_Form class
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
 * Add the Feedburner widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Idmuvi_Feedburner_Form extends WP_Widget {
	/**
	 * Sets up a Feedburner widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'idmuvi-form',
			'description' => __( 'Add simple feedburner form in your widget.', 'idmuvi-core' ),
		);
		parent::__construct( 'idmuvi-feedburner', __( 'Feedburner Form (Idmuvi)', 'idmuvi-core' ), $widget_ops );

		// Add action for admin_register_scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_register_scripts' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'admin_print_scripts' ), 9999 );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0
	 *
	 * @param string $hook_suffix Hook suffix.
	 */
	public function admin_register_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'underscore' );
	}

	/**
	 * Print scripts.
	 *
	 * @since 1.0
	 */
	public function admin_print_scripts() {
		?>
		<script>
			( function( $ ){
				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
						change: _.throttle( function() { // For Customizer
							$(this).trigger( 'change' );
						}, 3000 )
					});
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );
				} );
			}( jQuery ) );
		</script>
		<?php
	}

	/**
	 * Outputs the content for Feedburner Form.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Feedburner Form.
	 */
	public function widget( $args, $instance ) {
		// Title.
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		// Base Id Widget.
		$idmuv_widget_id = $this->id_base . '-' . $this->number;
		// Feedburner ID option.
		$idmuv_feed_id = empty( $instance['idmuv_feed_id'] ) ? '' : wp_strip_all_tags( $instance['idmuv_feed_id'] );
		// Email placeholder.
		$idmuv_placeholder_email = empty( $instance['idmuv_placeholder_email'] ) ? 'Enter Your Email Address' : wp_strip_all_tags( $instance['idmuv_placeholder_email'] );
		// Button placeholder.
		$idmuv_placeholder_btn = empty( $instance['idmuv_placeholder_btn'] ) ? 'Subscribe Now' : wp_strip_all_tags( $instance['idmuv_placeholder_btn'] );
		// Force input 100%.
		$idmuv_force_100 = empty( $instance['idmuv_force_100'] ) ? '0' : '1';
		// Intro text.
		$idmuv_introtext = empty( $instance['idmuv_introtext'] ) ? '' : wp_strip_all_tags( $instance['idmuv_introtext'] );
		// Spam Text.
		$idmuv_spamtext = empty( $instance['idmuv_spamtext'] ) ? '' : wp_strip_all_tags( $instance['idmuv_spamtext'] );
		// Style.
		$bgcolor        = ( ! empty( $instance['bgcolor'] ) ) ? wp_strip_all_tags( $instance['bgcolor'] ) : '';
		$color_text     = ( ! empty( $instance['color_text'] ) ) ? wp_strip_all_tags( $instance['color_text'] ) : '#222';
		$color_button   = ( ! empty( $instance['color_button'] ) ) ? wp_strip_all_tags( $instance['color_button'] ) : '#fff';
		$bgcolor_button = ( ! empty( $instance['bgcolor_button'] ) ) ? wp_strip_all_tags( $instance['bgcolor_button'] ) : '#34495e';
		if ( $idmuv_force_100 ) {
			$force = ' force-100';
		} else {
			$force = '';
		}
		if ( $bgcolor ) {
			$color = ' style="padding:20px;background-color:' . esc_html( $bgcolor ) . '"';
		} else {
			$color = '';
		}
		?>

			<div class="idmuvi-form-widget<?php echo $force; ?>"<?php echo $color; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php if ( $idmuv_introtext ) { ?>
					<p class="intro-text" style="color:<?php echo esc_attr( $color_text ); ?>;"><?php echo esc_html( $idmuv_introtext ); ?></p>
				<?php } ?>
				<form class="idmuvi-form-wrapper" id="<?php echo esc_attr( $idmuv_widget_id ); ?>" name="<?php echo esc_attr( $idmuv_widget_id ); ?>" action="https://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open( 'http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr( $idmuv_feed_id ); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">

					<input type="email" name="email" id="" class="idmuvi-form-email" placeholder="<?php echo esc_attr( $idmuv_placeholder_email ); ?>" />
					<input type="submit" name="submit" style="border-color:<?php echo esc_attr( $bgcolor_button ); ?>;background-color:<?php echo esc_attr( $bgcolor_button ); ?>;color:<?php echo esc_attr( $color_button ); ?>;" value="<?php echo esc_attr( $idmuv_placeholder_btn ); ?>" />

					<input type="hidden" value="<?php echo esc_attr( $idmuv_feed_id ); ?>" name="uri" />
					<input type="hidden" name="loc" value="en_US" />

				</form>

				<?php if ( $idmuv_spamtext ) { ?>
					<p class="spam-text" style="color:<?php echo esc_attr( $color_text ); ?>;"><?php echo esc_html( $idmuv_spamtext ); ?></p>
				<?php } ?>
			</div>

		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current Feedburner widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            Idmuvi_Feedburner_Form::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance     = $old_instance;
		$new_instance = wp_parse_args(
			(array) $new_instance,
			array(
				'title'                   => '',
				'idmuv_feed_id'           => '',
				'idmuv_placeholder_email' => 'Enter Your Email Address',
				'idmuv_placeholder_btn'   => 'Subscribe Now',
				'idmuv_force_100'         => '0',
				'idmuv_introtext'         => '',
				'idmuv_spamtext'          => '',
				'bgcolor'                 => '',
				'color_text'              => '#222',
				'color_button'            => '#fff',
				'bgcolor_button'          => '#34495e',
			)
		);
		// Title.
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		// Feed ID option.
		$instance['idmuv_feed_id'] = wp_strip_all_tags( $new_instance['idmuv_feed_id'] );
		// Email placeholder.
		$instance['idmuv_placeholder_email'] = wp_strip_all_tags( $new_instance['idmuv_placeholder_email'] );
		// Button placeholder.
		$instance['idmuv_placeholder_btn'] = wp_strip_all_tags( $new_instance['idmuv_placeholder_btn'] );
		// Force.
		$instance['idmuv_force_100'] = wp_strip_all_tags( $new_instance['idmuv_force_100'] ? '1' : '0' );
		// Intro Text.
		$instance['idmuv_introtext'] = wp_strip_all_tags( $new_instance['idmuv_introtext'] );
		// Spam Text.
		$instance['idmuv_spamtext'] = wp_strip_all_tags( $new_instance['idmuv_spamtext'] );
		// Style.
		$instance['bgcolor']        = wp_strip_all_tags( $new_instance['bgcolor'] );
		$instance['color_text']     = wp_strip_all_tags( $new_instance['color_text'] );
		$instance['color_button']   = wp_strip_all_tags( $new_instance['color_button'] );
		$instance['bgcolor_button'] = wp_strip_all_tags( $new_instance['bgcolor_button'] );

		return $instance;
	}

	/**
	 * Outputs the settings form for the Feedburner widget.
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
				'title'                   => '',
				'idmuv_feed_id'           => 'gianmr',
				'idmuv_placeholder_email' => 'Enter Your Email Address',
				'idmuv_placeholder_btn'   => 'Subscribe Now',
				'idmuv_force_100'         => '1',
				'idmuv_introtext'         => '',
				'idmuv_spamtext'          => '',
				'bgcolor'                 => '',
				'color_text'              => '#222',
				'color_button'            => '#fff',
				'bgcolor_button'          => '#34495e',
			)
		);
		// Title.
		$title = sanitize_text_field( $instance['title'] );
		// Feed ID option.
		$idmuv_feed_id = wp_strip_all_tags( $instance['idmuv_feed_id'] );
		// Email placeholder.
		$idmuv_placeholder_email = wp_strip_all_tags( $instance['idmuv_placeholder_email'] );
		// Button placeholder.
		$idmuv_placeholder_btn = wp_strip_all_tags( $instance['idmuv_placeholder_btn'] );
		// Force 100%.
		$idmuv_force_100 = wp_strip_all_tags( $instance['idmuv_force_100'] ? '1' : '0' );
		// Intro text.
		$idmuv_introtext = wp_strip_all_tags( $instance['idmuv_introtext'] );
		// Spam text.
		$idmuv_spamtext = wp_strip_all_tags( $instance['idmuv_spamtext'] );
		// Style.
		$bgcolor        = wp_strip_all_tags( $instance['bgcolor'] );
		$color_text     = wp_strip_all_tags( $instance['color_text'] );
		$color_button   = wp_strip_all_tags( $instance['color_button'] );
		$bgcolor_button = wp_strip_all_tags( $instance['bgcolor_button'] );
		?>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'idmuvi-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_feed_id' ) ); ?>"><?php esc_html_e( 'Feedburner ID *(Required)', 'idmuvi-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_feed_id' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_feed_id' ) ); ?>" type="text" value="<?php echo esc_attr( $idmuv_feed_id ); ?>" />
			<br />
			<small><?php esc_html_e( 'Example: gianmr for http://feeds.feedburner.com/gianmr feed address.', 'idmuvi-core' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_placeholder_email' ) ); ?>"><?php esc_html_e( 'Placeholder For Email Address Field', 'idmuvi-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_placeholder_email' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_placeholder_email' ) ); ?>" type="text" value="<?php echo esc_attr( $idmuv_placeholder_email ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_placeholder_btn' ) ); ?>"><?php esc_html_e( 'Submit Button Text', 'idmuvi-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'idmuv_placeholder_btn' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_placeholder_btn' ) ); ?>" type="text" value="<?php echo esc_attr( $idmuv_placeholder_btn ); ?>" />
		</p>
		<p>
			<input class="checkbox" value="1" type="checkbox"<?php checked( $instance['idmuv_force_100'], 1 ); ?> id="<?php echo esc_html( $this->get_field_id( 'idmuv_force_100' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_force_100' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_force_100' ) ); ?>"><?php esc_html_e( 'Force Input 100%', 'idmuvi-core' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_introtext' ) ); ?>"><?php esc_html_e( 'Intro Text:', 'idmuvi-core' ); ?></label>
			<textarea class="widefat" rows="6" id="<?php echo esc_html( $this->get_field_id( 'idmuv_introtext' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_introtext' ) ); ?>"><?php echo esc_textarea( $instance['idmuv_introtext'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'idmuv_spamtext' ) ); ?>"><?php esc_html_e( 'Spam Text:', 'idmuvi-core' ); ?></label>
			<textarea class="widefat" rows="6" id="<?php echo esc_html( $this->get_field_id( 'idmuv_spamtext' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'idmuv_spamtext' ) ); ?>"><?php echo esc_textarea( $instance['idmuv_spamtext'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'bgcolor' ) ); ?>"><?php esc_html_e( 'Background Color', 'idmuvi-core' ); ?></label><br />
			<input class="widefat color-picker" id="<?php echo esc_html( $this->get_field_id( 'bgcolor' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'bgcolor' ) ); ?>" type="text" value="<?php echo esc_attr( $bgcolor ); ?>" data-default-color="" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'color_text' ) ); ?>"><?php esc_html_e( 'Text Color', 'idmuvi-core' ); ?></label><br />
			<input class="widefat color-picker" id="<?php echo esc_html( $this->get_field_id( 'color_text' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'color_text' ) ); ?>" type="text" value="<?php echo esc_attr( $color_text ); ?>" data-default-color="#222" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'color_button' ) ); ?>"><?php esc_html_e( 'Button Text Color', 'idmuvi-core' ); ?></label><br />
			<input class="widefat color-picker" id="<?php echo esc_html( $this->get_field_id( 'color_button' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'color_button' ) ); ?>" type="text" value="<?php echo esc_attr( $color_button ); ?>" data-default-color="#fff" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'bgcolor_button' ) ); ?>"><?php esc_html_e( 'Button Background Color', 'idmuvi-core' ); ?></label><br />
			<input class="widefat color-picker" id="<?php echo esc_html( $this->get_field_id( 'bgcolor_button' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'bgcolor_button' ) ); ?>" type="text" value="<?php echo esc_attr( $bgcolor_button ); ?>" data-default-color="#34495e" />
		</p>

		<?php
	}
}

add_action(
	'widgets_init',
	function() {
		register_widget( 'Idmuvi_Feedburner_Form' );
	}
);
