<?php
/**
 * Widget API: Idmuvi_Feedburner_form class
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @package Idmuvi Core
 * @subpackage Widgets
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Add the Feedburner widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Idmuvi_Feedburner_form extends WP_Widget {
	/**
	 * Sets up a Feedburner widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array( 'classname' => 'Idmuvi-form', 'description' => __( 'Add simple feedburner form in your widget.','Idmuvi-core' ) );
		parent::__construct( 'Idmuvi-feedburner', __( 'Feedburner Form (Idmuvi)','Idmuvi-core' ), $widget_ops );

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
    public function widget($args, $instance) {
		
		// Title
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		// Base Id Widget
		$Idmuv_widget_ID = $this->id_base . '-' . $this->number;
		// Feedburner ID option
        $Idmuv_feed_id        	 	= empty( $instance['Idmuv_feed_id'] ) ? '' : strip_tags( $instance['Idmuv_feed_id'] );
		// Email placeholder
        $Idmuv_placeholder_email    = empty( $instance['Idmuv_placeholder_email'] ) ? 'Enter Your Email Address' : strip_tags( $instance['Idmuv_placeholder_email'] );
		// Button placeholder
        $Idmuv_placeholder_btn     	= empty( $instance['Idmuv_placeholder_btn'] ) ? 'Subscribe Now' : strip_tags( $instance['Idmuv_placeholder_btn'] );
		// Force input 100%
        $Idmuv_force_100          	= empty( $instance['Idmuv_force_100'] ) ? '0' : '1';
		// Intro text
        $Idmuv_introtext    		= empty( $instance['Idmuv_introtext'] ) ? '' : strip_tags( $instance['Idmuv_introtext'] );
		// Spam Text
        $Idmuv_spamtext    			= empty( $instance['Idmuv_spamtext'] ) ? '' : strip_tags( $instance['Idmuv_spamtext'] );
		// Style
		$bgcolor = ( ! empty( $instance['bgcolor'] ) ) ? strip_tags( $instance['bgcolor'] ) : '';
		$color_text = ( ! empty( $instance['color_text'] ) ) ? strip_tags( $instance['color_text'] ) : '#222';
		$color_button = ( ! empty( $instance['color_button'] ) ) ? strip_tags( $instance['color_button'] ) : '#fff';
		$bgcolor_button = ( ! empty( $instance['bgcolor_button'] ) ) ? strip_tags( $instance['bgcolor_button'] ) : '#34495e';
		?>

			<div class="Idmuvi-form-widget<?php if ( $Idmuv_force_100 ) { echo ' force-100'; } ?>"<?php if ( $bgcolor ) { echo ' style="padding:20px;background-color:'.$bgcolor.'"'; } ?>>
				<?php if ( $Idmuv_introtext ) { ?>
					<p class="intro-text" style="color:<?php echo esc_attr( $color_text ); ?>;"><?php echo $Idmuv_introtext; ?></p>
				<?php } ?>
				<form class="Idmuvi-form-wrapper" id="<?php echo esc_attr( $Idmuv_widget_ID ); ?>" name="<?php echo esc_attr( $Idmuv_widget_ID ); ?>" action="https://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open( 'http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr( $Idmuv_feed_id ); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
					
					<input type="email" name="email" id="" class="Idmuvi-form-email" placeholder="<?php echo esc_attr( $Idmuv_placeholder_email ); ?>" />
					<input type="submit" name="submit" style="border-color:<?php echo esc_attr( $bgcolor_button ); ?>;background-color:<?php echo esc_attr( $bgcolor_button ); ?>;color:<?php echo esc_attr( $color_button ); ?>;" value="<?php echo esc_attr( $Idmuv_placeholder_btn ); ?>" />
					
					<input type="hidden" value="<?php echo esc_attr( $Idmuv_feed_id ); ?>" name="uri" />
					<input type="hidden" name="loc" value="en_US" />
					
				</form>
						
				<?php if ( $Idmuv_spamtext ) { ?>
					<p class="spam-text" style="color:<?php echo esc_attr( $color_text ); ?>;"><?php echo $Idmuv_spamtext; ?></p>
				<?php } ?>	
			</div>
			
		<?php
		echo $args['after_widget'];
    }
	
	/**
	 * Handles updating settings for the current Feedburner widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            Idmuvi_Feedburner_form::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
    public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, 
			array( 
				'title' => '', 
				'Idmuv_feed_id' => '', 
				'Idmuv_placeholder_email' => 'Enter Your Email Address',
				'Idmuv_placeholder_btn' => 'Subscribe Now',
				'Idmuv_force_100' => '0',
				'Idmuv_introtext' => '',
				'Idmuv_spamtext' => '',
				'bgcolor' => '',
				'color_text' => '#222',
				'color_button' => '#fff',
				'bgcolor_button' => '#34495e'
			) 
		);
		// Title
		$instance['title'] 								= sanitize_text_field( $new_instance['title'] );
		// Feed ID option
        $instance['Idmuv_feed_id']           			= strip_tags($new_instance['Idmuv_feed_id']);
		// Email placeholder
        $instance['Idmuv_placeholder_email']            = strip_tags($new_instance['Idmuv_placeholder_email']);
		// Button placeholder
        $instance['Idmuv_placeholder_btn']              = strip_tags($new_instance['Idmuv_placeholder_btn']);
		// Force
        $instance['Idmuv_force_100']          			= strip_tags( $new_instance['Idmuv_force_100'] ? '1' : '0' );
		// Intro Text
        $instance['Idmuv_introtext']             	 	= strip_tags( $new_instance['Idmuv_introtext'] );
		// Spam Text
        $instance['Idmuv_spamtext']             	 	= strip_tags( $new_instance['Idmuv_spamtext'] );
		// Style
		$instance['bgcolor']							= strip_tags( $new_instance['bgcolor'] );
		$instance['color_text']							= strip_tags( $new_instance['color_text'] );
		$instance['color_button']						= strip_tags( $new_instance['color_button'] );
		$instance['bgcolor_button']						= strip_tags( $new_instance['bgcolor_button'] );

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
        $instance = wp_parse_args( (array) $instance, 
			array( 
				'title' => '', 
				'Idmuv_feed_id' => 'gianmr', 
				'Idmuv_placeholder_email' => 'Enter Your Email Address',
				'Idmuv_placeholder_btn' => 'Subscribe Now',
				'Idmuv_force_100' => '1',
				'Idmuv_introtext' => '',
				'Idmuv_spamtext' => '',
				'bgcolor' => '',
				'color_text' => '#222',
				'color_button' => '#fff',
				'bgcolor_button' => '#34495e'
			) 
		);
		// Title
		$title 							= sanitize_text_field( $instance['title'] );
		// Feed ID option
        $Idmuv_feed_id           		= strip_tags( $instance['Idmuv_feed_id'] );
		// Email placeholder
        $Idmuv_placeholder_email       	= strip_tags( $instance['Idmuv_placeholder_email'] );
		// Button placeholder
        $Idmuv_placeholder_btn        	= strip_tags( $instance['Idmuv_placeholder_btn'] );
		// Force 100%
        $Idmuv_force_100          		= strip_tags( $instance['Idmuv_force_100'] ? '1' : '0' );
		// Intro text
        $Idmuv_introtext        		= strip_tags( $instance['Idmuv_introtext'] );
		// Spam text
        $Idmuv_spamtext        			= strip_tags( $instance['Idmuv_spamtext'] );
		// Style
		$bgcolor						= strip_tags( $instance['bgcolor'] );
		$color_text						= strip_tags( $instance['color_text'] );
		$color_button					= strip_tags( $instance['color_button'] );
		$bgcolor_button					= strip_tags( $instance['bgcolor_button'] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:','Idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('Idmuv_feed_id'); ?>"><?php _e( 'Feedburner ID *(Required)','Idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('Idmuv_feed_id'); ?>" name="<?php echo $this->get_field_name('Idmuv_feed_id'); ?>" type="text" value="<?php echo esc_attr($Idmuv_feed_id); ?>" />
			<br />
            <small><?php _e( 'Example: gianmr for http://feeds.feedburner.com/gianmr feed address.','Idmuvi-core' ); ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('Idmuv_placeholder_email'); ?>"><?php _e( 'Placeholder For Email Address Field','Idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('Idmuv_placeholder_email'); ?>" name="<?php echo $this->get_field_name('Idmuv_placeholder_email'); ?>" type="text" value="<?php echo esc_attr($Idmuv_placeholder_email); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('Idmuv_placeholder_btn'); ?>"><?php _e( 'Submit Button Text','Idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('Idmuv_placeholder_btn'); ?>" name="<?php echo $this->get_field_name('Idmuv_placeholder_btn'); ?>" type="text" value="<?php echo esc_attr($Idmuv_placeholder_btn); ?>" />
		</p>
		<p>
			<input class="checkbox" value="1" type="checkbox"<?php checked( $instance['Idmuv_force_100'], 1 ); ?> id="<?php echo $this->get_field_id('Idmuv_force_100'); ?>" name="<?php echo $this->get_field_name('Idmuv_force_100'); ?>" /> 
			<label for="<?php echo $this->get_field_id('Idmuv_force_100'); ?>"><?php _e( 'Force Input 100%','Idmuvi-core' ); ?></label>
		</p>
			<label for="<?php echo $this->get_field_id( 'Idmuv_introtext' ); ?>"><?php _e( 'Intro Text:' ); ?></label>
			<textarea class="widefat" rows="6" id="<?php echo $this->get_field_id('Idmuv_introtext'); ?>" name="<?php echo $this->get_field_name('Idmuv_introtext'); ?>"><?php echo esc_textarea( $instance['Idmuv_introtext'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'Idmuv_spamtext' ); ?>"><?php _e( 'Spam Text:' ); ?></label>
			<textarea class="widefat" rows="6" id="<?php echo $this->get_field_id('Idmuv_spamtext'); ?>" name="<?php echo $this->get_field_name('Idmuv_spamtext'); ?>"><?php echo esc_textarea( $instance['Idmuv_spamtext'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('bgcolor'); ?>"><?php _e( 'Background Color','Idmuvi-core' ); ?></label><br /> 
			<input class="widefat color-picker" id="<?php echo $this->get_field_id('bgcolor'); ?>" name="<?php echo $this->get_field_name('bgcolor'); ?>" type="text" value="<?php echo esc_attr($bgcolor); ?>" data-default-color="" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('color_text'); ?>"><?php _e( 'Text Color','Idmuvi-core' ); ?></label><br /> 
			<input class="widefat color-picker" id="<?php echo $this->get_field_id('color_text'); ?>" name="<?php echo $this->get_field_name('color_text'); ?>" type="text" value="<?php echo esc_attr($color_text); ?>" data-default-color="#222" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('color_button'); ?>"><?php _e( 'Button Text Color','Idmuvi-core' ); ?></label><br /> 
			<input class="widefat color-picker" id="<?php echo $this->get_field_id('color_button'); ?>" name="<?php echo $this->get_field_name('color_button'); ?>" type="text" value="<?php echo esc_attr($color_button); ?>" data-default-color="#fff" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('bgcolor_button'); ?>"><?php _e( 'Button Background Color','Idmuvi-core' ); ?></label><br /> 
			<input class="widefat color-picker" id="<?php echo $this->get_field_id('bgcolor_button'); ?>" name="<?php echo $this->get_field_name('bgcolor_button'); ?>" type="text" value="<?php echo esc_attr($bgcolor_button); ?>" data-default-color="#34495e" />
		</p>
		
		<?php
    }
}

add_action( 'widgets_init', function() {
    register_widget( 'Idmuvi_Feedburner_form' );
} );