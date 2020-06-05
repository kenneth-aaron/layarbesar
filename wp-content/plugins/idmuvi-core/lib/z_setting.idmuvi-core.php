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

if ( ! class_exists( 'Idmuvi_Core_Settings_API' ) ) :
	/**
	 * Class Options.
	 */
	class Idmuvi_Core_Settings_API {
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
			// Set the settings.
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );

			// Initialize settings.
			$this->settings_api->admin_init();
		}

		/**
		 * Admin Menu
		 */
		public function admin_menu() {
			add_options_page( 'Idmuvi Core', 'Idmuvi Core', 'manage_options', 'idmuvi-core-settings', array( $this, 'plugin_page' ) );
		}

		/**
		 * Get Settings Sections
		 */
		public function get_settings_sections() {
			$sections = array(
				array(
					'id'    => 'idmuv_ads',
					'title' => __( 'Ads', 'idmuvi-core' ),
				),
				array(
					'id'    => 'idmuv_tmdb',
					'title' => __( 'TMDB Settings', 'idmuvi-core' ),
				),
				array(
					'id'    => 'idmuv_ajax',
					'title' => __( 'Ajax & content', 'idmuvi-core' ),
				),
				array(
					'id'    => 'idmuv_other',
					'title' => __( 'Other', 'idmuvi-core' ),
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
				'idmuv_ads'    => array(
					array(
						'name'  => 'ads_topbanner',
						'label' => __( 'Top Banner', 'idmuvi-core' ),
						'desc'  => __( 'Display ads on very top. You can add adsense or manual banner.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'ads_topbanner_aftermenu',
						'label' => __( 'Top Banner After Menu', 'idmuvi-core' ),
						'desc'  => __( 'Display ads after menu. You can add adsense or manual banner.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'ads_topbanner_archive',
						'label' => __( 'Top Banner Archive', 'idmuvi-core' ),
						'desc'  => __( 'Display ads before post list in archive and index page. You can add adsense or manual banner.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'ads_before_content',
						'label' => __( 'Before Single Content', 'idmuvi-core' ),
						'desc'  => __( 'Display ads before single content. You can add adsense or manual banner.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'    => 'ads_before_content_position',
						'label'   => '',
						'desc'    => __( 'Position', 'idmuvi-core' ),
						'type'    => 'select',
						'default' => 'default',
						'options' => array(
							'default' => 'Default',
							'left'    => 'Float left',
							'right'   => 'Float right',
							'center'  => 'Center',
						),
					),
					array(
						'name'  => 'ads_after_content',
						'label' => __( 'After Single Content', 'idmuvi-core' ),
						'desc'  => __( 'Display ads after single content. You can add adsense or manual banner.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'    => 'ads_after_content_position',
						'label'   => '',
						'desc'    => __( 'Alignment', 'idmuvi-core' ),
						'type'    => 'select',
						'default' => 'default',
						'options' => array(
							'default' => 'Default',
							'right'   => 'Right',
							'center'  => 'Center',
						),
					),
					array(
						'name'  => 'ads_inside_content',
						'label' => __( 'Inside Single Content', 'idmuvi-core' ),
						'desc'  => __( 'Display ads inside paragraph single content. You can add adsense or manual banner. Ads will not display if you have less than three paragraph in your post.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'    => 'ads_inside_content_position',
						'label'   => '',
						'desc'    => __( 'Alignment', 'idmuvi-core' ),
						'type'    => 'select',
						'default' => 'default',
						'options' => array(
							'default' => 'Default',
							'right'   => 'Right',
							'center'  => 'Center',
						),
					),
					array(
						'name'  => 'ads_floatbanner_left',
						'label' => __( 'Floating Banner Left', 'idmuvi-core' ),
						'desc'  => __( 'Display floating banner in left side. You can add adsense or manual banner. Display only on desktop.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'ads_floatbanner_right',
						'label' => __( 'Floating Banner Right', 'idmuvi-core' ),
						'desc'  => __( 'Display floating banner in right side. You can add adsense or manual banner. Display only on desktop.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'ads_floatbanner_footer',
						'label' => __( 'Floating Banner Footer', 'idmuvi-core' ),
						'desc'  => __( 'Display floating banner in footer. You can add adsense or manual banner. Display only on desktop.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'ads_footerbanner',
						'label' => __( 'Footer Banner', 'idmuvi-core' ),
						'desc'  => __( 'Display banner in footer. You can add adsense or manual banner.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'ads_topplayer',
						'label' => __( 'Before player Banner', 'idmuvi-core' ),
						'desc'  => __( 'Display banner before player. You can add adsense or manual banner. Require player is active.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'ads_afterplayer',
						'label' => __( 'After player banner', 'idmuvi-core' ),
						'desc'  => __( 'Display banner after player. You can add adsense or manual banner. Require player is active.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'ads_popupbanner',
						'label' => __( 'Popup banner', 'idmuvi-core' ),
						'desc'  => __( 'Display popup banner in all page. You can add adsense or manual banner. Max width is 325px, and all image will resize to fullwidth (325px), so please using banner with width 325px. This banner will delay 3 seconds before load. Require theme muvipro.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'ads_banner_player',
						'label' => __( 'Banner In Player (336x200)', 'idmuvi-core' ),
						'desc'  => __( 'Display banner in player. You can add adsense or manual banner.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => '',
						'label' => __( 'Note', 'idmuvi-core' ),
						'desc'  => __( 'Some ad place maybe conflict with Term of Use ad provider like adsense. Please read TOS first before you insert the ads. Adsense TOS: https://www.google.com/adsense/policies. All field above support shortcode too.<br /> For anti adblock, will give overlay notification, effect will cause a drop visitors in your website.', 'idmuvi-core' ),
						'type'  => 'html',
					),
				),

				'idmuv_tmdb'   => array(
					array(
						'name'    => 'enable_tmdb_api',
						'label'   => __( 'Enable TMDB API', 'idmuvi-core' ),
						'desc'    => __( 'Check this if you want enable tmdb data scrapping in movie metaboxes. Some metaboxes need this options.', 'idmuvi-core' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name'    => 'tmdb_api',
						'label'   => __( 'TMDB API Key', 'idmuvi-core' ),
						'desc'    => __( 'Add API Key from themoviedb.org. Please config your api key in https://www.themoviedb.org/account/', 'idmuvi-core' ),
						'type'    => 'text',
						'default' => '',
					),
					array(
						'name'    => 'tmdb_lang',
						'label'   => __( 'TMDB Languange', 'idmuvi-core' ),
						'desc'    => '',
						'type'    => 'select',
						'default' => 'en',
						'options' => array(
							'en' => 'Default (English)',
							'ar' => 'Arabic',
							'bg' => 'Bulgarian',
							'zh' => 'Chinese',
							'hr' => 'Croatian',
							'cs' => 'Czech',
							'da' => 'Danish',
							'nl' => 'Dutch',
							'fa' => 'Farsi',
							'fi' => 'Finnish',
							'fr' => 'French',
							'de' => 'German',
							'el' => 'Greek',
							'he' => 'Hebrew',
							'hu' => 'Hungarian',
							'id' => 'Indonesian',
							'it' => 'Italian',
							'ko' => 'Korean',
							'pl' => 'Polish',
							'pt' => 'Portuguese',
							'ro' => 'Romanian',
							'ru' => 'Russian',
							'sk' => 'Slovak',
							'es' => 'Spanish',
							'sv' => 'Swedish',
							'th' => 'Thai',
							'tr' => 'Turkish',
						),
					),
				),

				'idmuv_ajax'   => array(
					array(
						'name'    => 'enable_ajax_navigation',
						'label'   => __( 'Enable Ajax Navigation', 'idmuvi-core' ),
						'desc'    => __( 'Check this if you want enable ajax navigation. If you using infinite scroll from jetpack, please disable it, to enable this feature.', 'idmuvi-core' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name'    => 'ajax_navigation_type',
						'label'   => __( 'Type Navigation', 'idmuvi-core' ),
						'desc'    => '',
						'type'    => 'select',
						'default' => 'infinite',
						'options' => array(
							'infinite' => 'Infinite Scroll',
							'more'     => 'Button Click',
						),
					),
					array(
						'name'    => 'content_orderby',
						'label'   => __( 'Content Order By', 'idmuvi-core' ),
						'desc'    => __( 'Select your order by in index and archive page. Note: if you select by year, you must edit all movie and insert year in Release Year in custom field. And for rating you must insert TMDB Rating in custom field.', 'idmuvi-core' ),
						'type'    => 'select',
						'default' => 'default',
						'options' => array(
							'default'    => 'Latest Post',
							'byyear'     => 'Order By Release Year',
							'byrating'   => 'Order By Rating',
							'bytitle'    => 'Order By Title',
							'bymodified' => 'Order By Modified',
						),
					),
					array(
						'name'    => 'enable_ajax_search',
						'label'   => __( 'Enable Ajax Search', 'idmuvi-core' ),
						'desc'    => __( 'Check this if you want enable ajax in search form.', 'idmuvi-core' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
				),

				'idmuv_other'  => array(
					array(
						'name'  => 'other_fbpixel_id',
						'label' => __( 'Facebook Pixel ID', 'idmuvi-core' ),
						'desc'  => __( 'If you want adding Facebook Conversion Pixel code to WordPress sites, enter your facebook pixel ID here or you can add complate code via Head Script.', 'idmuvi-core' ),
						'type'  => 'text',
					),
					array(
						'name'  => 'other_analytics_code',
						'label' => __( 'Google Analytics Code', 'idmuvi-core' ),
						'desc'  => __( 'Enter your Google Analytics code (Ex: UA-XXXXX-X) or you can add complate code via Footer Script.', 'idmuvi-core' ),
						'type'  => 'text',
					),
					array(
						'name'  => 'other_head_script',
						'label' => __( 'Head script', 'idmuvi-core' ),
						'desc'  => __( 'These scripts will be printed in the <code>&lt;head&gt;</code> section.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'  => 'other_footer_script',
						'label' => __( 'Footer script', 'idmuvi-core' ),
						'desc'  => __( 'These scripts will be printed above the <code>&lt;/body&gt;</code> tag.', 'idmuvi-core' ),
						'type'  => 'textarea',
					),
					array(
						'name'    => 'other_remove_emoji_script',
						'label'   => __( 'Remove Emoji Script', 'idmuvi-core' ),
						'desc'    => __( 'Check this if you want remove emoji script from <code>&lt;head&gt;</code> section. This can improve your web performance.', 'idmuvi-core' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name'    => 'other_remove_script_version',
						'label'   => __( 'Remove Script Version', 'idmuvi-core' ),
						'desc'    => __( 'Check this if you want remove script version from JS and CSS. This can improve your web performance.', 'idmuvi-core' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name'    => 'other_remove_jquery_migrate',
						'label'   => __( 'Remove Jquery Migrate', 'idmuvi-core' ),
						'desc'    => __( 'Check this if you want remove jquery migrate, if this conflict with some plugin please do not activated. This can improve your web performance.', 'idmuvi-core' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name'    => 'other_remove_oembed',
						'label'   => __( 'Remove WP Oembed', 'idmuvi-core' ),
						'desc'    => __( 'Check this if you want remove wp oembed feature, if this conflict with some plugin please do not activated. This can improve your web performance.', 'idmuvi-core' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name'    => 'other_wp_head_tag',
						'label'   => __( 'Remove WP Head Meta Tag', 'idmuvi-core' ),
						'desc'    => __( 'Check this if you want remove wp head meta tag, if this conflict with some plugin please do not activated. This option can remove wp meta tag generator, rds, wlwmanifest, feed links, shortlink, comments feed so your head tag look simple and hope can fast your index.', 'idmuvi-core' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
					array(
						'name'    => 'other_remove_data_when_uninstall',
						'label'   => __( 'Remove data uninstaller', 'idmuvi-core' ),
						'desc'    => __( 'Check this if you want remove data from database when plugin is uninstall.', 'idmuvi-core' ),
						'type'    => 'checkbox',
						'default' => 'off',
					),
				),
			);

			return $settings_fields;
		}

		/**
		 * Plugin Page.
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

new Idmuvi_Core_Settings_API();
