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
 
if ( !class_exists('Idmuvi_Core_Settings_API' ) ):

class Idmuvi_Core_Settings_API {

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
        add_options_page( 'Idmuvi Core', 'Idmuvi Core', 'delete_posts', 'idmuvi-core-settings', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'idmuv_relpost',
                'title' => __( 'Related Post', 'idmuvi-core' )
            ),
            array(
                'id' => 'idmuv_breadcrumbs',
                'title' => __( 'Breadcrumbs', 'idmuvi-core' )
            ),
            array(
                'id' => 'idmuv_ads',
                'title' => __( 'Ads', 'idmuvi-core' )
            ),
			array(
                'id' => 'idmuv_social',
                'title' => __( 'Social', 'idmuvi-core' )
            ),
            array(
                'id' => 'idmuv_tmdb',
                'title' => __( 'TMDB Settings', 'idmuvi-core' )
            ),
            array(
                'id' => 'idmuv_ajax',
                'title' => __( 'Ajax & content', 'idmuvi-core' )
            ),
            array(
                'id' => 'idmuv_player',
                'title' => __( 'Player Integrated', 'idmuvi-core' )
            ),
            array(
                'id' => 'idmuv_other',
                'title' => __( 'Other', 'idmuvi-core' )
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
            'idmuv_relpost' => array(
                array(
                    'name'    => 'enable_relpost',
                    'label'   => __( 'Enable related post', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want enable related post in single post.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'on'
                ),
                array(
                    'name'              => 'relpost_number',
                    'label'             => __( 'Number post', 'idmuvi-core' ),
                    'desc'              => __( 'How much number post want to display on related post.', 'idmuvi-core' ),
                    'type'              => 'number',
                    'default'           => '5',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'    => 'relpost_taxonomy',
                    'label'   => __( 'Taxonomy', 'idmuvi-core' ),
                    'desc'    => __( 'Choice related movies by tags or category (genre)', 'idmuvi-core' ),
                    'type'    => 'radio',
                    'options' => array(
                        'tags' => 'Tags',
                        'category'  => 'Category (genre)'
                    ),
                    'default' => 'category'
                ),
                array(
					'name'  => '',
					'label' => __( 'Note', 'idmuvi-core' ),
                    'desc'  => __( 'This recent post support YARPP(Yet Another Related Posts Plugin) too. If you want change this related post with YARPP, just install YARPP and disable this Related Posts. Display using <strong>add_filter( \'the_content\', \'idmuvi_core_add_related_the_content\', 40 );</strong>', 'idmuvi-core' ),
                    'type'  => 'html'
                )
            ),
            'idmuv_breadcrumbs' => array(
                array(
                    'name'    => 'enable_breadcrumbs',
                    'label'   => __( 'Enable breadcrumbs', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want enable breadcrumbs.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'on'
                ),
                array(
                    'name'              => 'breadcrumbs_hometext',
                    'label'             => __( 'Homepage Text', 'idmuvi-core' ),
                    'desc'              => '',
                    'type'              => 'text',
                    'default'           => 'Homepage',
                ),
                array(
                    'name'              => 'breadcrumbs_blogtext',
                    'label'             => __( 'Blog Text', 'idmuvi-core' ),
                    'desc'              => __( 'Display only if you using blog page.', 'idmuvi-core' ),
                    'type'              => 'text',
                    'default'           => 'Blog',
                ),
                array(
                    'name'              => 'breadcrumbs_errortext',
                    'label'             => __( '404 Error Text', 'idmuvi-core' ),
                    'desc'              => '',
                    'type'              => 'text',
                    'default'           => '404 Not found',
                ),
                array(
					'name'  => '',
					'label' => __( 'Note', 'idmuvi-core' ),
                    'desc'  => __( 'This breadcrumbs support breadcrumb navxt or yoast breadcrumb too. If you want change this breadcrumb with that plugin, just install plugin breadcrumb navxt or wordpress SEO by seo. Display using <strong>do_action( \'idmuvi_core_view_breadcrumbs\' );</strong>', 'idmuvi-core' ),
                    'type'  => 'html'
                )
            ),
            'idmuv_ads' => array(
                array(
                    'name'  => 'ads_enable_antiadblock',
                    'label' => __( 'Enable Adblock', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want enable anti adblock. Anti adblock will display overlay notification when your visitor enable adblock for your website.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
                array(
                    'name'  => 'ads_antiadblock_message',
                    'label' => __( 'Adblock Message', 'idmuvi-core' ),
                    'desc'  => __( 'Insert message in your anti adblock.', 'idmuvi-core' ),
					'default' => __( 'Please disable your adblock for read our content.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'ads_topbanner',
                    'label' => __( 'Top Banner', 'idmuvi-core' ),
                    'desc'  => __( 'Display ads on very top. You can add adsense or manual banner.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'ads_topbanner_aftermenu',
                    'label' => __( 'Top Banner After Menu', 'idmuvi-core' ),
                    'desc'  => __( 'Display ads after menu. You can add adsense or manual banner.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'ads_topbanner_archive',
                    'label' => __( 'Top Banner Archive', 'idmuvi-core' ),
                    'desc'  => __( 'Display ads before post list in archive and index page. You can add adsense or manual banner.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'ads_before_content',
                    'label' => __( 'Before Single Content', 'idmuvi-core' ),
                    'desc'  => __( 'Display ads before single content. You can add adsense or manual banner.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'    => 'ads_before_content_position',
                    'label'   => '',
                    'desc'    => __( 'Position', 'idmuvi-core' ),
                    'type'    => 'select',
                    'default' => 'default',
                    'options' => array(
                        'default' => 'Default',
                        'left'  => 'Float left',
                        'right'  => 'Float right',
                        'center'  => 'Center'
                    )
                ),
                array(
                    'name'  => 'ads_after_content',
                    'label' => __( 'After Single Content', 'idmuvi-core' ),
                    'desc'  => __( 'Display ads after single content. You can add adsense or manual banner.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'    => 'ads_after_content_position',
                    'label'   => '',
                    'desc'    => __( 'Alignment', 'idmuvi-core' ),
                    'type'    => 'select',
                    'default' => 'default',
                    'options' => array(
                        'default' => 'Default',
                        'right'  => 'Right',
                        'center'  => 'Center'
                    )
                ),
                array(
                    'name'  => 'ads_inside_content',
                    'label' => __( 'Inside Single Content', 'idmuvi-core' ),
                    'desc'  => __( 'Display ads inside paragraph single content. You can add adsense or manual banner. Ads will not display if you have less than three paragraph in your post.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'    => 'ads_inside_content_position',
                    'label'   => '',
                    'desc'    => __( 'Alignment', 'idmuvi-core' ),
                    'type'    => 'select',
                    'default' => 'default',
                    'options' => array(
                        'default' => 'Default',
                        'right'  => 'Right',
                        'center'  => 'Center'
                    )
                ),
                array(
                    'name'  => 'ads_floatbanner_left',
                    'label' => __( 'Floating Banner Left', 'idmuvi-core' ),
                    'desc'  => __( 'Display floating banner in left side. You can add adsense or manual banner. Display only on desktop.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'ads_floatbanner_right',
                    'label' => __( 'Floating Banner Right', 'idmuvi-core' ),
                    'desc'  => __( 'Display floating banner in right side. You can add adsense or manual banner. Display only on desktop.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'ads_floatbanner_footer',
                    'label' => __( 'Floating Banner Footer', 'idmuvi-core' ),
                    'desc'  => __( 'Display floating banner in footer. You can add adsense or manual banner. Display only on desktop.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'ads_footerbanner',
                    'label' => __( 'Footer Banner', 'idmuvi-core' ),
                    'desc'  => __( 'Display banner in footer. You can add adsense or manual banner.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'ads_topplayer',
                    'label' => __( 'Before player Banner', 'idmuvi-core' ),
                    'desc'  => __( 'Display banner before player. You can add adsense or manual banner. Require player is active.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'ads_afterplayer',
                    'label' => __( 'After player banner', 'idmuvi-core' ),
                    'desc'  => __( 'Display banner after player. You can add adsense or manual banner. Require player is active.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'ads_popupbanner',
                    'label' => __( 'Popup banner', 'idmuvi-core' ),
                    'desc'  => __( 'Display popup banner in all page. You can add adsense or manual banner. Max width is 325px, and all image will resize to fullwidth (325px), so please using banner with width 325px. This banner will delay 3 seconds before load. Require theme muvipro.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
					'name'  => '',
					'label' => __( 'Note', 'idmuvi-core' ),
                    'desc'  => __( 'Some ad place maybe conflict with Term of Use ad provider like adsense. Please read TOS first before you insert the ads. Adsense TOS: https://www.google.com/adsense/policies. All field above support shortcode too.<br /> For anti adblock, will give overlay notification, effect will cause a drop visitors in your website.', 'idmuvi-core' ),
                    'type'  => 'html'
                )
            ),
            'idmuv_social' => array(
                array(
                    'name'    => 'enable_socialshare',
                    'label'   => __( 'Enable social share', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want enable social share in single post.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'on'
                ),
                array(
                    'name'    => 'enable_opengraph',
                    'label'   => __( 'Enable opengraph', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want enable Open Graph metadata to your posts and pages so that they look great when shared on sites like Twitter, Facebook and Google+.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'on'
                ),
                array(
                    'name'  => 'social_app_id_facebook',
                    'label' => __( 'Facebook App ID', 'idmuvi-core' ),
                    'desc'  => __( 'Enter your facebook App ID here, some function require app ID, better if you fill your own, or you can using default app ID from plugin.', 'idmuvi-core' ),
                    'type'  => 'text',
					'default' => '1703072823350490'
                ),
                array(
                    'name'  => 'social_username_twitter',
                    'label' => __( 'Username Twitter', 'idmuvi-core' ),
                    'desc'  => __( 'Enter your Username Twitter Without @.', 'idmuvi-core' ),
                    'type'  => 'text',
					'default' => 'gianmrdotcom'
                ),
                array(
                    'name'    => 'enable_author_username_twitter',
                    'label'   => __( 'Enable opengraph', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want enable twitter:creator meta.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'on'
                ),
                array(
                    'name'    => 'enable_fb_comment',
                    'label'   => __( 'Enable Facebook Comment', 'idmuvi-core' ),
                    'desc'  => __( 'Check this Facebook Comment, if you check this default comment will replace with Facebook Comment.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
                array(
					'name'  => '',
					'label' => __( 'Note', 'idmuvi-core' ),
                    'desc'  => __( 'This social support jetpack too. If you want change this share post with jetpack, just install jetpack and activated module Sharedaddy For Jetpack, sharedaddy will automatically replace default social share. Display using <strong>add_filter( \'the_content\', \'idmuvi_core_add_share_the_content\', 30 );</strong>. If you activated opengraph, opengraph from jetpack will disappear. So if you want using jetpack open graph, you can disable this opengraph. If you using another opengraph plugin, please disable opengraph. Do not using opengraph plugin more then one. Opengraph display using <strong>add_action( \'wp_head\', \'idmuvi_opengraph_meta_tags\', 1 );</strong>', 'idmuvi-core' ),
                    'type'  => 'html'
                )
            ),
            'idmuv_tmdb' => array(
                array(
                    'name'    => 'enable_tmdb_api',
                    'label'   => __( 'Enable TMDB API', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want enable tmdb data scrapping in movie metaboxes. Some metaboxes need this options.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
                array(
                    'name'              => 'tmdb_api',
                    'label'             => __( 'TMDB API Key', 'idmuvi-core' ),
                    'desc'              => __( 'Add API Key from themoviedb.org. Please config your api key in https://www.themoviedb.org/account/', 'idmuvi-core' ),
                    'type'              => 'text',
                    'default'           => '',
                ),            
				array(
                    'name'    => 'tmdb_lang',
                    'label'    => __( 'TMDB Languange', 'idmuvi-core' ),
                    'desc'   => '',
                    'type'    => 'select',
                    'default' => 'en',
                    'options' => array(
                        'en' => 'Default (English)',
                        'ar'  => 'Arabic',
                        'bg'  => 'Bulgarian',
                        'zh'  => 'Chinese',
                        'hr'  => 'Croatian',
                        'cs'  => 'Czech',
                        'da'  => 'Danish',
                        'nl'  => 'Dutch',
                        'fa'  => 'Farsi',
                        'fi'  => 'Finnish',
                        'fr'  => 'French',
                        'de'  => 'German',
                        'el'  => 'Greek',
                        'he'  => 'Hebrew',
                        'hu'  => 'Hungarian',
                        'id'  => 'Indonesian',
                        'it'  => 'Italian',
                        'ko'  => 'Korean',
                        'pl'  => 'Polish',
                        'pt'  => 'Portuguese',
                        'ro'  => 'Romanian',
                        'ru'  => 'Russian',
                        'sk'  => 'Slovak',
                        'es'  => 'Spanish',
                        'sv'  => 'Swedish',
                        'th'  => 'Thai',
                        'tr'  => 'Turkish'
                    )
                )
            ),
            'idmuv_ajax' => array(
                array(
                    'name'    => 'enable_ajax_navigation',
                    'label'   => __( 'Enable Ajax Navigation', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want enable ajax navigation. If you using infinite scroll from jetpack, please disable it, to enable this feature.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
                array(
                    'name'    => 'ajax_navigation_type',
                    'label'   => __( 'Type Navigation', 'idmuvi-core' ),
                    'desc'    => '',
                    'type'    => 'select',
                    'default' => 'infinite',
                    'options' => array(
                        'infinite' => 'Infinite Scroll',
                        'more'  => 'Button Click',
                    )
                ),
                array(
                    'name'    => 'content_orderby',
                    'label'   => __( 'Content Order By', 'idmuvi-core' ),
                    'desc'    => __( 'Select your order by in index and archive page. Note: if you select by year, you must edit all movie and insert year in Release Year in custom field. And for rating you must insert TMDB Rating in custom field.', 'idmuvi-core' ),
                    'type'    => 'select',
                    'default' => 'default',
                    'options' => array(
                        'default'  => 'Latest Post',
                        'byyear' => 'Order By Release Year',
                        'byrating'  => 'Order By Rating',
                        'bytitle'  => 'Order By Title',
                        'bymodified'  => 'Order By Modified',
                    )
                ),
                array(
                    'name'    => 'enable_ajax_search',
                    'label'   => __( 'Enable Ajax Search', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want enable ajax in search form.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
            ),
            'idmuv_player' => array(
                array(
                    'name'    => 'player_options',
                    'label'   => __( 'Select Provider', 'idmuvi-core' ),
                    'desc'    => 'This is third party, please ask provider if any bugs about video player. And all provider using popup ads in every player.',
                    'type'    => 'select',
                    'default' => 'disable',
                    'options' => array(
                        'disable' => 'Disable',
                        'gdriveplayer'  => 'gdriveplayer.us Embed',
                        'gdriveplayer_title'  => 'gdriveplayer.us Title',
                        'haxhits'  => 'haxhits.com Embed',
                    )
                ),
                array(
                    'name'              => 'haxhits_api',
                    'label'             => __( 'Haxhits API Key', 'idmuvi-core' ),
                    'desc'              => __( 'Add API Key from haxhits.com. Please login to https://haxhits.com/?p=dashboard to get API Key. For more information please contact provider https://haxhits.com', 'idmuvi-core' ),
                    'type'              => 'text',
                    'default'           => '',
                ),      
            ),
            'idmuv_other' => array(
                array(
                    'name'  => 'other_fbpixel_id',
                    'label' => __( 'Facebook Pixel ID', 'idmuvi-core' ),
                    'desc'  => __( 'If you want adding Facebook Conversion Pixel code to WordPress sites, enter your facebook pixel ID here or you can add complate code via Head Script.', 'idmuvi-core' ),
                    'type'  => 'text'
                ),
                array(
                    'name'  => 'other_analytics_code',
                    'label' => __( 'Google Analytics Code', 'idmuvi-core' ),
                    'desc'  => __( 'Enter your Google Analytics code (Ex: UA-XXXXX-X) or you can add complate code via Footer Script.', 'idmuvi-core' ),
                    'type'  => 'text'
                ),
                array(
                    'name'  => 'other_head_script',
                    'label' => __( 'Head script', 'idmuvi-core' ),
                    'desc'  => __( 'These scripts will be printed in the <code>&lt;head&gt;</code> section.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'other_footer_script',
                    'label' => __( 'Footer script', 'idmuvi-core' ),
                    'desc'  => __( 'These scripts will be printed above the <code>&lt;/body&gt;</code> tag.', 'idmuvi-core' ),
                    'type'  => 'textarea'
                ),
                array(
                    'name'  => 'other_remove_emoji_script',
                    'label' => __( 'Remove Emoji Script', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want remove emoji script from <code>&lt;head&gt;</code> section. This can improve your web performance.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
                array(
                    'name'  => 'other_remove_script_version',
                    'label' => __( 'Remove Script Version', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want remove script version from JS and CSS. This can improve your web performance.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
                array(
                    'name'  => 'other_remove_jquery_migrate',
                    'label' => __( 'Remove Jquery Migrate', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want remove jquery migrate, if this conflict with some plugin please do not activated. This can improve your web performance.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
                array(
                    'name'  => 'other_remove_oembed',
                    'label' => __( 'Remove WP Oembed', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want remove wp oembed feature, if this conflict with some plugin please do not activated. This can improve your web performance.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
                array(
                    'name'  => 'other_wp_head_tag',
                    'label' => __( 'Remove WP Head Meta Tag', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want remove wp head meta tag, if this conflict with some plugin please do not activated. This option can remove wp meta tag generator, rds, wlwmanifest, feed links, shortlink, comments feed so your head tag look simple and hope can fast your index.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
                array(
                    'name'  => 'other_remove_thumbphp',
                    'label' => __( 'Remove Auto Thumbnail Functions', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want remove thumb.php from idmuvi-core. For solutions, you must set featured image in every post.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
                array(
                    'name'  => 'other_remove_data_when_uninstall',
                    'label' => __( 'Remove data uninstaller', 'idmuvi-core' ),
                    'desc'  => __( 'Check this if you want remove data from database when plugin is uninstall.', 'idmuvi-core' ),
                    'type'  => 'checkbox',
                    'default' => 'off'
                ),
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

new Idmuvi_Core_Settings_API();