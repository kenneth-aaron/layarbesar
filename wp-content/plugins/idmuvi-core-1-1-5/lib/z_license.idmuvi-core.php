<?php
/**
 * WordPress settings API
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package Idmuvi Core
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
if ( !class_exists('Idmuvi_Core_Settings_API_for_license' ) ):

class Idmuvi_Core_Settings_API_for_license {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_options_page( 'Idmuvi Core', 'Idmuvi Core', 'delete_posts', 'idmuvi-core-licensekey', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'idmuv_licensekey',
                'title' => __( 'License Key Not Found', 'idmuvi-core' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'idmuv_licensekey' => array(
                array(
					'name'  => '',
					'label' => __( 'Note', 'idmuvi-core' ),
                    'desc'  => __( 'Please insert your own license key <a href="plugins.php?page=muvipro-license">here</a>.', 'idmuvi-core' ),
                    'type'  => 'html'
                )
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
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
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}

endif;

new Idmuvi_Core_Settings_API_for_license();