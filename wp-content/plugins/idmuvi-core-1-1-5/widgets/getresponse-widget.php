<?php
/**
 * Widget API: Idmuvi_Getresponse_form class
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @package Idmuvi Core
 * @subpackage Widgets
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Add the Getresponse widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Idmuvi_Getresponse_form extends WP_Widget {
	/**
	 * Sets up a Getresponse widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array( 'classname' => 'idmuvi-form', 'description' => __( 'Add simple getresponse form in your widget.','idmuvi-core' ) );
		parent::__construct( 'idmuvi-getresponse', __( 'Getresponse Form (Idmuvi)','idmuvi-core' ), $widget_ops );

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
	 * Outputs the content for Getresponse Form.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Getresponse Form.
	 */
    public function widget($args, $instance) {
		
		// Title
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		// Base Id Widget
		$idmuv_widget_ID = $this->id_base . '-' . $this->number;
		// Getresponse Campaign Token
        $idmuv_campaign_token       = empty( $instance['idmuv_campaign_token'] ) ? '' : strip_tags( $instance['idmuv_campaign_token'] );
		// Redirect thankyou link
        $idmuv_thx_link       		= empty( $instance['idmuv_thx_link'] ) ? '' : strip_tags( $instance['idmuv_thx_link'] );
		// Activated name input
        $idmuv_name_check          	= empty( $instance['idmuv_name_check'] ) ? '0' : '1';
		// Force input 100%
        $idmuv_force_100          	= empty( $instance['idmuv_force_100'] ) ? '0' : '1';
		// Name placeholder
        $idmuv_placeholder_name    	= empty( $instance['idmuv_placeholder_name'] ) ? 'Enter Your Name' : strip_tags( $instance['idmuv_placeholder_name'] );
		// Email placeholder
        $idmuv_placeholder_email    = empty( $instance['idmuv_placeholder_email'] ) ? 'Enter Your Email Address' : strip_tags( $instance['idmuv_placeholder_email'] );
		// Button placeholder
        $idmuv_placeholder_btn     	= empty( $instance['idmuv_placeholder_btn'] ) ? 'Subscribe Now' : strip_tags( $instance['idmuv_placeholder_btn'] );
		// Intro text
        $idmuv_introtext    		= empty( $instance['idmuv_introtext'] ) ? '' : strip_tags( $instance['idmuv_introtext'] );
		// Spam Text
        $idmuv_spamtext    			= empty( $instance['idmuv_spamtext'] ) ? '' : strip_tags( $instance['idmuv_spamtext'] );
		// Style
		$bgcolor = ( ! empty( $instance['bgcolor'] ) ) ? strip_tags( $instance['bgcolor'] ) : '';
		$color_text = ( ! empty( $instance['color_text'] ) ) ? strip_tags( $instance['color_text'] ) : '#222';
		$color_button = ( ! empty( $instance['color_button'] ) ) ? strip_tags( $instance['color_button'] ) : '#fff';
		$bgcolor_button = ( ! empty( $instance['bgcolor_button'] ) ) ? strip_tags( $instance['bgcolor_button'] ) : '#34495e';
		?>

			<div class="idmuvi-form-widget<?php if ( $idmuv_force_100 ) { echo ' force-100'; } ?>"<?php if ( $bgcolor ) { echo ' style="padding:20px;background-color:'.$bgcolor.'"'; } ?>>
				<?php if ( $idmuv_introtext ) { ?>
					<p class="intro-text" style="color:<?php echo esc_attr( $color_text ); ?>;"><?php echo $idmuv_introtext; ?></p>
				<?php } ?>
				<form class="idmuvi-form-wrapper" id="<?php echo esc_attr( $idmuv_widget_ID ); ?>" method="post" name="<?php echo esc_attr( $idmuv_widget_ID ); ?>" action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8">
					
					<div style="display: none;">
						<input type="hidden" name="campaign_token" value="<?php echo esc_attr( $idmuv_campaign_token ); ?>" />
						<?php if ( $idmuv_thx_link ) { ?>
							<input type="hidden" name="thankyou_url" value="<?php echo esc_url( $idmuv_thx_link ); ?>"/>
							<input type="hidden" name="forward_data" value="" />
						<?php } ?>	
					</div>
					
					<?php if ( $idmuv_name_check ) { ?>
						<input type="text" name="name" id="" class="idmuvi-form-name" placeholder="<?php echo esc_attr( $idmuv_placeholder_name ); ?>" value="" />
					<?php } ?>
					<input type="email" name="email" id="" class="idmuvi-form-email" placeholder="<?php echo esc_attr( $idmuv_placeholder_email ); ?>" />
					<input type="submit" name="submit" style="border-color:<?php echo esc_attr( $bgcolor_button ); ?>;background-color:<?php echo esc_attr( $bgcolor_button ); ?>;color:<?php echo esc_attr( $color_button ); ?>;" value="<?php echo esc_attr( $idmuv_placeholder_btn ); ?>" />
				
				</form>				
				<?php if ( $idmuv_spamtext ) { ?>
					<p class="spam-text" style="color:<?php echo esc_attr( $color_text ); ?>;"><?php echo $idmuv_spamtext; ?></p>
				<?php } ?>	
			</div>
			
		<?php
		echo $args['after_widget'];
    }
	
	/**
	 * Handles updating settings for the current Getresponse widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            Idmuvi_Getresponse_form::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
    public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, 
			array( 
				'title' => '', 
				'idmuv_campaign_token' => '', 
				'idmuv_thx_link' => '',
				'idmuv_name_check' => '0',
				'idmuv_force_100' => '0',
				'idmuv_placeholder_name' => 'Enter Your Name',
				'idmuv_placeholder_email' => 'Enter Your Email Address',
				'idmuv_placeholder_btn' => 'Subscribe Now',
				'idmuv_introtext' => '',
				'idmuv_spamtext' => '',
				'bgcolor' => '',
				'color_text' => '#222',
				'color_button' => '#fff',
				'bgcolor_button' => '#34495e'
			) 
		);
		// Title
		$instance['title'] 								= sanitize_text_field( $new_instance['title'] );
		// list ID option
        $instance['idmuv_campaign_token']           	= strip_tags( $new_instance['idmuv_campaign_token'] );
		// Redirect thankyou link
        $instance['idmuv_thx_link']            			= strip_tags( $new_instance['idmuv_thx_link'] );
		// Activated name input
        $instance['idmuv_name_check']          			= strip_tags( $new_instance['idmuv_name_check'] ? '1' : '0' );
		// Force
        $instance['idmuv_force_100']          			= strip_tags( $new_instance['idmuv_force_100'] ? '1' : '0' );
		// Name placeholder
        $instance['idmuv_placeholder_name']        		= strip_tags( $new_instance['idmuv_placeholder_name'] );
		// Email placeholder
        $instance['idmuv_placeholder_email']            = strip_tags( $new_instance['idmuv_placeholder_email'] );
		// Button placeholder
        $instance['idmuv_placeholder_btn']              = strip_tags( $new_instance['idmuv_placeholder_btn'] );
		// Intro Text
        $instance['idmuv_introtext']             	 	= strip_tags( $new_instance['idmuv_introtext'] );
		// Spam Text
        $instance['idmuv_spamtext']             	 	= strip_tags( $new_instance['idmuv_spamtext'] );
		// Style
		$instance['bgcolor']							= strip_tags( $new_instance['bgcolor'] );
		$instance['color_text']							= strip_tags( $new_instance['color_text'] );
		$instance['color_button']						= strip_tags( $new_instance['color_button'] );
		$instance['bgcolor_button']						= strip_tags( $new_instance['bgcolor_button'] );
		
        return $instance;
    }
	
	/**
	 * Outputs the settings form for the Getresponse widget.
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
				'idmuv_campaign_token' => '', 
				'idmuv_thx_link' => '',
				'idmuv_name_check' => '0',
				'idmuv_force_100' => '1',
				'idmuv_placeholder_name' => 'Enter Your Name',
				'idmuv_placeholder_email' => 'Enter Your Email Address',
				'idmuv_placeholder_btn' => 'Subscribe Now',
				'idmuv_introtext' => '',
				'idmuv_spamtext' => '',
				'bgcolor' => '',
				'color_text' => '#222',
				'color_button' => '#fff',
				'bgcolor_button' => '#34495e'
			) 
		);
		// Title
		$title 							= sanitize_text_field( $instance['title'] );
		// Getresponse Campaign Token
        $idmuv_campaign_token           = strip_tags( $instance['idmuv_campaign_token'] );
		// Redirect thankyou link
        $idmuv_thx_link             	= strip_tags( $instance['idmuv_thx_link'] );
		// Activated name input
        $idmuv_name_check          		= strip_tags( $instance['idmuv_name_check'] ? '1' : '0' );
		// Force 100%
        $idmuv_force_100          		= strip_tags( $instance['idmuv_force_100'] ? '1' : '0' );
		// Name placeholder
        $idmuv_placeholder_name        	= strip_tags( $instance['idmuv_placeholder_name'] );
		// Email placeholder
        $idmuv_placeholder_email       	= strip_tags( $instance['idmuv_placeholder_email'] );
		// Button placeholder
        $idmuv_placeholder_btn        	= strip_tags( $instance['idmuv_placeholder_btn'] );
		// Intro text
        $idmuv_introtext        		= strip_tags( $instance['idmuv_introtext'] );
		// Spam text
        $idmuv_spamtext        			= strip_tags( $instance['idmuv_spamtext'] );
		// Style
		$bgcolor						= strip_tags( $instance['bgcolor'] );
		$color_text						= strip_tags( $instance['color_text'] );
		$color_button					= strip_tags( $instance['color_button'] );
		$bgcolor_button					= strip_tags( $instance['bgcolor_button'] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_campaign_token'); ?>"><?php _e( 'Getresponse Campaign Token *(Required)','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('idmuv_campaign_token'); ?>" name="<?php echo $this->get_field_name('idmuv_campaign_token'); ?>" type="text" value="<?php echo esc_attr($idmuv_campaign_token); ?>" />
			<br />
            <small><?php _e( 'Getresponse Campaign Token <a target="_blank" href="https://support.getresponse.com/faq/how-do-i-create-html-web-form-code-from-scratch">Click Here to see where to find it.</a>','idmuvi-core' ); ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_thx_link'); ?>"><?php _e( 'Link to the Thank you page','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('idmuv_thx_link'); ?>" name="<?php echo $this->get_field_name('idmuv_thx_link'); ?>" type="text" value="<?php echo esc_url($idmuv_thx_link); ?>" />
			<br />
            <small><?php _e( 'Leave empty if you want to use Getresponse\'s default thank you page.','idmuvi-core' ); ?></small>
		</p>
		<p>
			<input class="checkbox" value="1" type="checkbox"<?php checked( $instance['idmuv_name_check'], 1 ); ?> id="<?php echo $this->get_field_id('idmuv_name_check'); ?>" name="<?php echo $this->get_field_name('idmuv_name_check'); ?>" /> 
			<label for="<?php echo $this->get_field_id('idmuv_name_check'); ?>"><?php _e( 'Enable Full Name Field','idmuvi-core' ); ?></label>
		</p>
		<p>
			<input class="checkbox" value="1" type="checkbox"<?php checked( $instance['idmuv_force_100'], 1 ); ?> id="<?php echo $this->get_field_id('idmuv_force_100'); ?>" name="<?php echo $this->get_field_name('idmuv_force_100'); ?>" /> 
			<label for="<?php echo $this->get_field_id('idmuv_force_100'); ?>"><?php _e( 'Force Input 100%','idmuvi-core' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_placeholder_name'); ?>"><?php _e( 'Placeholder For Name Field','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('idmuv_placeholder_name'); ?>" name="<?php echo $this->get_field_name('idmuv_placeholder_name'); ?>" type="text" value="<?php echo esc_attr($idmuv_placeholder_name); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_placeholder_email'); ?>"><?php _e( 'Placeholder For Email Address Field','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('idmuv_placeholder_email'); ?>" name="<?php echo $this->get_field_name('idmuv_placeholder_email'); ?>" type="text" value="<?php echo esc_attr($idmuv_placeholder_email); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('idmuv_placeholder_btn'); ?>"><?php _e( 'Submit Button Text','idmuvi-core' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('idmuv_placeholder_btn'); ?>" name="<?php echo $this->get_field_name('idmuv_placeholder_btn'); ?>" type="text" value="<?php echo esc_attr($idmuv_placeholder_btn); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'idmuv_introtext' ); ?>"><?php _e( 'Intro Text:' ); ?></label>
			<textarea class="widefat" rows="6" id="<?php echo $this->get_field_id('idmuv_introtext'); ?>" name="<?php echo $this->get_field_name('idmuv_introtext'); ?>"><?php echo esc_textarea( $instance['idmuv_introtext'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'idmuv_spamtext' ); ?>"><?php _e( 'Spam Text:' ); ?></label>
			<textarea class="widefat" rows="6" id="<?php echo $this->get_field_id('idmuv_spamtext'); ?>" name="<?php echo $this->get_field_name('idmuv_spamtext'); ?>"><?php echo esc_textarea( $instance['idmuv_spamtext'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('bgcolor'); ?>"><?php _e( 'Background Color','idmuvi-core' ); ?></label><br /> 
			<input class="widefat color-picker" id="<?php echo $this->get_field_id('bgcolor'); ?>" name="<?php echo $this->get_field_name('bgcolor'); ?>" type="text" value="<?php echo esc_attr($bgcolor); ?>" data-default-color="" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('color_text'); ?>"><?php _e( 'Text Color','idmuvi-core' ); ?></label><br /> 
			<input class="widefat color-picker" id="<?php echo $this->get_field_id('color_text'); ?>" name="<?php echo $this->get_field_name('color_text'); ?>" type="text" value="<?php echo esc_attr($color_text); ?>" data-default-color="#222" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('color_button'); ?>"><?php _e( 'Button Text Color','idmuvi-core' ); ?></label><br /> 
			<input class="widefat color-picker" id="<?php echo $this->get_field_id('color_button'); ?>" name="<?php echo $this->get_field_name('color_button'); ?>" type="text" value="<?php echo esc_attr($color_button); ?>" data-default-color="#fff" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('bgcolor_button'); ?>"><?php _e( 'Button Background Color','idmuvi-core' ); ?></label><br /> 
			<input class="widefat color-picker" id="<?php echo $this->get_field_id('bgcolor_button'); ?>" name="<?php echo $this->get_field_name('bgcolor_button'); ?>" type="text" value="<?php echo esc_attr($bgcolor_button); ?>" data-default-color="#34495e" />
		</p>
		<?php
    }
}

add_action( 'widgets_init', function() {
    register_widget( 'Idmuvi_Getresponse_form' );
} );