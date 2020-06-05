<?php
/**
 * WordPress settings API
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package Idmuvi Core
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Idmuvi_Core_Settings_API_For_License' ) ) :
	/**
	 * Class Setting Api License
	 */
	class Idmuvi_Core_Settings_API_For_License {
		/**
		 * Setting API
		 *
		 * @var $settings_api Setting API
		 */
		private $settings_api;

		/**
		 * Construct Class
		 */
		public function __construct() {
			$this->settings_api = new WeDevs_Settings_API;

			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}

		/**
		 * Admin Init
		 */
		public function admin_init() {
			// set the settings.
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );

			// initialize settings.
			$this->settings_api->admin_init();
		}

		/**
		 * Admin Menu
		 */
		public function admin_menu() {
			add_options_page( 'Idmuvi Core', 'Idmuvi Core', 'manage_options', 'idmuvi-core-licensekey', array( $this, 'plugin_page' ) );
		}

		/**
		 * Get Settings Sections
		 */
		public function get_settings_sections() {
			$sections = array(
				array(
					'id'    => 'idmuv_licensekey',
					'title' => __( 'License Key Not Found', 'idmuvi-core' ),
				),
			);
			return $sections;
		}

		/**
		 * Returns all the settings fields
		 *
		 * @return array settings fields
		 */
		public function get_settings_fields() {
			$settings_fields = array(
				'idmuv_licensekey' => array(
					array(
						'name'  => '',
						'label' => __( 'Note', 'idmuvi-core' ),
						'desc'  => __( 'Please insert your own license key <a href="plugins.php?page=muvipro-license">here</a>.', 'idmuvi-core' ),
						'type'  => 'html',
					),
				),
			);

			return $settings_fields;
		}

		/**
		 * Plugin Page
		 */
		public function plugin_page() {
			echo '<div class="wrap">';

			$this->settings_api->show_navigation();
			$this->settings_api->show_forms();

			echo '</div>';
		}

		/**
		 * Get all the pages
		 *
		 * @return array page names with key value pairs
		 */
		public function get_pages() {
			$pages         = get_pages();
			$pages_options = array();
			if ( $pages ) {
				foreach ( $pages as $page ) {
					$pages_options[ $page->ID ] = $page->post_title;
				}
			}

			return $pages_options;
		}

	}

endif;

new Idmuvi_Core_Settings_API_For_License();
