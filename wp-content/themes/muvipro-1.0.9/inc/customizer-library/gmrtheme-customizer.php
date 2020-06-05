<?php
/**
 * Defines customizer options
 *
 * @package muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Option array customizer library
 *
 * @since 1.0.0
 */
function gmr_library_options_customizer() {
	
	// Prefix_option
	$gmrprefix = 'gmr';
	
	/*
	 * Theme defaults
	 *
	 * @since v.1.0.0
	 */
	// General
	$color_scheme = '#e50a4a';
	$second_color_scheme = '#5cb85c';
	
	/* 
	 * Header Default Options
	 */
	$header_bgcolor = '#ffffff';
	$sitetitle_color = '#e50a4a';
	$sitedesc_color = '#999999';
	// first menu
	$menu_bgcolor = '#e50a4a';
	$menu_hoverbgcolor = '#99cc00';
	$menu_color = '#ffffff';
	$menu_hovercolor = '#ffffff';
	// Second menu
	$secondmenu_bgcolor = '#FCBB23';
	$secondmenu_hoverbgcolor = '#f7b519';
	$secondmenu_color = '#212121';
	$secondmenu_hovercolor = '#ffffff';
	// Top menu
	$topnav_bgcolor = '#ffffff';
	$topnav_color = '#e50a4a';
	$topnav_hovercolor = '#212121';
	
	$default_logo = get_template_directory_uri() .'/images/logo.png';
	
	// content
	$content_bgcolor = '#ffffff';
	$content_color = '#212121';
	
	// Footer
	$footer_bgcolor = '#ffffff';
	$footer_fontcolor = '#212121';
	$footer_linkcolor = '#E91E63';
	$footer_hoverlinkcolor = '#E91E63';
	$copyright_bgcolor = '#f5f5f5';
	$copyright_fontcolor = '#212121';
	$copyright_linkcolor = '#E91E63';
	$copyright_hoverlinkcolor = '#E91E63';
	
	// Stores all the controls that will be added
	$options = array();
	
	// Stores all the sections to be added
	$sections = array();
	
	// Stores all the panels to be added
	$panels = array();
	
	// Adds the sections to the $options array
	$options['sections'] = $sections;
	
	/*
	 * General Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_general = 'panel-general';
	$panels[] = array(
		'id' => $panel_general,
		'title' => __( 'General', 'muvipro' ),
		'priority' => '30'
	);
	
	$section = 'layout_options';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'General Layout', 'muvipro' ),
		'priority' => 35,
		'panel' => $panel_general
	);
	
	$layout = array(
		'box-layout' => __( 'Box', 'muvipro' ),
		'full-layout' => __( 'Fullwidth', 'muvipro' ),
	);
	$options[$gmrprefix . '_layout'] = array(
		'id' => $gmrprefix . '_layout',
		'label'   => __( 'Select Layout', 'muvipro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $layout,
		'default' => 'box-layout'
	);
	
	$options[$gmrprefix . '_active-logosection'] = array(
		'id' => $gmrprefix . '_active-logosection',
		'label'   => __( 'Disable logo section', 'muvipro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
		'description' => __( 'If you disable logo section, ads side logo will not display.', 'muvipro' )
	);
	
	$btnlayout = array(
		'default' => __( 'Default Muvipro', 'muvipro' ),
		'lk' => __( 'LK21 Button Style', 'muvipro' )
	);
	$options[$gmrprefix . '_button_style'] = array(
		'id' => $gmrprefix . '_button_style',
		'label'   => __( 'Button Style', 'muvipro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $btnlayout,
		'default' => 'default'
	);

	$options[$gmrprefix . '_texttitlehomepage'] = array(
		'id' => $gmrprefix . '_texttitlehomepage',
		'label'   => __( 'Text Home Page.', 'muvipro' ),
		'section' => $section,
		'type'    => 'text',
		'description' => __( 'Allow you add text before list movie in homepage. Default is "Latest Movie".', 'muvipro' )
	);
	
	// Colors
	$section = 'colors';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'General Colors', 'muvipro' ),
		'panel' => $panel_general,
		'priority' => 40
	);
	
	$options[$gmrprefix . '_scheme-color'] = array(
		'id' => $gmrprefix . '_scheme-color',
		'label'   => __( 'Base Color Scheme', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $color_scheme
	);
	
	$options[$gmrprefix . '_second-scheme-color'] = array(
		'id' => $gmrprefix . '_second-scheme-color',
		'label'   => __( 'Second Color Scheme', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $second_color_scheme
	);
	
	$options[$gmrprefix . '_content-bgcolor'] = array(
		'id' => $gmrprefix . '_content-bgcolor',
		'label'   => __( 'Background Color - Content', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $content_bgcolor,
		'priority' => 40
	);
	
	$options[$gmrprefix . '_content-color'] = array(
		'id' => $gmrprefix . '_content-color',
		'label'   => __( 'Font Color - Body', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $content_color,
		'priority' => 40
	);
	
	// Colors
	$section = 'background_image';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Background Image', 'muvipro' ),
		'panel' => $panel_general,
		'description' => __( 'Background Image only display, if using box layout.', 'muvipro' ),
		'priority' => 45
	);
	
	// Typography
	$section = 'typography';
	$font_choices = customizer_library_get_font_choices();
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Typography', 'muvipro' ),
		'panel' => $panel_general,
		'priority' => 50
	);
	
	$options[$gmrprefix . '_primary-font'] = array(
		'id' => $gmrprefix . '_primary-font',
		'label'   => __( 'Heading Font', 'muvipro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $font_choices,
		'default' => 'Source Sans Pro'
	);
	
	$options[$gmrprefix . '_secondary-font'] = array(
		'id' => $gmrprefix . '_secondary-font',
		'label'   => __( 'Body Font', 'muvipro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $font_choices,
		'default' => 'Source Sans Pro'
	);
	
	$primaryweight = array(
		'300' => '300',
		'400' => '400',
		'500' => '500',
		'600' => '600',
		'700' => '700',
	);
	
	$options[$gmrprefix . '_body_size'] = array(
		'id' => $gmrprefix . '_body_size',
		'label'   => __( 'Body font size', 'muvipro' ),
		'section' => $section,
		'type'    => 'number',
		'default'       => '15',
		'input_attrs' => array(
			'min'   => 12,
			'max'   => 50,
			'step'  => 1
		)
	);
	$options[$gmrprefix . '_secondary-font-weight'] = array(
		'id' => $gmrprefix . '_secondary-font-weight',
		'label'   => __( 'Body font weight', 'muvipro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $primaryweight,
		'description' => __( 'Note: some font maybe not display properly, if not display properly try to change this font weight.', 'muvipro' ),
		'default' => '500'
	);
	
	$options[$gmrprefix . '_h1_size'] = array(
		'id' => $gmrprefix . '_h1_size',
		'label'   => __( 'h1 font size', 'muvipro' ),
		'section' => $section,
		'type'    => 'number',
		'default'       => '26',
		'input_attrs' => array(
			'min'   => 12,
			'max'   => 50,
			'step'  => 1
		)
	);
	
	$options[$gmrprefix . '_h2_size'] = array(
		'id' => $gmrprefix . '_h2_size',
		'label'   => __( 'h2 font size', 'muvipro' ),
		'section' => $section,
		'type'    => 'number',
		'default'       => '22',
		'input_attrs' => array(
			'min'   => 12,
			'max'   => 50,
			'step'  => 1
		)
	);
	
	$options[$gmrprefix . '_h3_size'] = array(
		'id' => $gmrprefix . '_h3_size',
		'label'   => __( 'h3 font size', 'muvipro' ),
		'section' => $section,
		'type'    => 'number',
		'default'       => '20',
		'input_attrs' => array(
			'min'   => 12,
			'max'   => 50,
			'step'  => 1
		)
	);
	
	$options[$gmrprefix . '_h4_size'] = array(
		'id' => $gmrprefix . '_h4_size',
		'label'   => __( 'h4 font size', 'muvipro' ),
		'section' => $section,
		'type'    => 'number',
		'default'       => '18',
		'input_attrs' => array(
			'min'   => 12,
			'max'   => 50,
			'step'  => 1
		)
	);
	
	$options[$gmrprefix . '_h5_size'] = array(
		'id' => $gmrprefix . '_h5_size',
		'label'   => __( 'h5 font size', 'muvipro' ),
		'section' => $section,
		'type'    => 'number',
		'default'       => '16',
		'input_attrs' => array(
			'min'   => 12,
			'max'   => 50,
			'step'  => 1
		)
	);
	
	$options[$gmrprefix . '_h6_size'] = array(
		'id' => $gmrprefix . '_h6_size',
		'label'   => __( 'h6 font size', 'muvipro' ),
		'section' => $section,
		'type'    => 'number',
		'default'       => '14',
		'input_attrs' => array(
			'min'   => 12,
			'max'   => 50,
			'step'  => 1
		)
	);
	
	/*
	 * Header Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_header = 'panel-header';
	$panels[] = array(
		'id' => $panel_header,
		'title' => __( 'Header', 'muvipro' ),
		'priority' => '40'
	);
	
	// Logo
	$section = 'title_tagline';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Site Identity', 'muvipro' ),
		'priority' => 30,
		'panel' => $panel_header,
		'description' => __( 'Allow you to add icon, logo, change site-title and tagline to your website.', 'muvipro' )
	);
	
	$options[$gmrprefix . '_logoimage'] = array(
		'id' => $gmrprefix . '_logoimage',
		'label'   => __( 'Logo', 'muvipro' ),
		'section' => $section,
		'type'    => 'image',
		'default' => $default_logo,
		'description' => __( 'If using logo, Site Title and Tagline automatic disappear.', 'muvipro' )
	);
	
	$options[$gmrprefix . '_logo_margintop'] = array(
		'id' => $gmrprefix . '_logo_margintop',
		'label'   => __( 'Logo Margin Top', 'muvipro' ),
		'section' => $section,
		'type'    => 'number',
		'default'       => '0',
		'description' => '',
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 40,
			'step'  => 1
		)
	);
	
	$section = 'header_image';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Header Image', 'muvipro' ),
		'priority' => 40,
		'panel' => $panel_header,
		'description' => __( 'Allow you customize header sections in home page.', 'muvipro' )
	);
	
	$options[$gmrprefix . '_active-headerimage'] = array(
		'id' => $gmrprefix . '_active-headerimage',
		'label'   => __( 'Disable header image', 'muvipro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
		'priority' => 25,
		'description' => __( 'If you disable header image, header section will replace with header color.', 'muvipro' )
	);
	
	$bgsize = array(
		'auto' => 'Auto',
		'cover' => 'Cover',
		'contain' => 'Contain',
		'initial' => 'Initial',
		'inherit' => 'Inherit',
	);
	$options[$gmrprefix . '_headerimage_bgsize'] = array(
		'id' => $gmrprefix . '_headerimage_bgsize',
		'label'   => __( 'Background Size', 'muvipro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $bgsize,
		'priority' => 30,
		'description' => __( 'The background-size property specifies the size of the header images.', 'muvipro' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/css3_pr_background-size.asp', 'muvipro' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'muvipro' ) . '</a>',
		'default' => 'auto'
	);
	
	$bgrepeat = array(
		'repeat' => 'Repeat',
		'repeat-x' => 'Repeat X',
		'repeat-y' => 'Repeat Y',
		'initial' => 'Initial',
		'inherit' => 'Inherit',
	);
	$options[$gmrprefix . '_headerimage_bgrepeat'] = array(
		'id' => $gmrprefix . '_headerimage_bgrepeat',
		'label'   => __( 'Background Repeat', 'muvipro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $bgrepeat,
		'priority' => 35,
		'description' => __( 'The background-repeat property sets if/how a header image will be repeated.', 'muvipro' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/pr_background-repeat.asp', 'muvipro' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'muvipro' ) . '</a>',		
		'default' => 'repeat'
	);
	
	$bgposition = array(
		'left top' => 'left top',
		'left center' => 'left center',
		'left bottom' => 'left bottom',
		'right top' => 'right top',
		'right center' => 'right center',
		'right bottom' => 'right bottom',
		'center top' => 'center top',
		'center center' => 'center center',
		'center bottom' => 'center bottom',
	);
	$options[$gmrprefix . '_headerimage_bgposition'] = array(
		'id' => $gmrprefix . '_headerimage_bgposition',
		'label'   => __( 'Background Position', 'muvipro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $bgposition,
		'priority' => 40,
		'description' => __( 'The background-position property sets the starting position of a header image.', 'muvipro' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/pr_background-position.asp', 'muvipro' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'muvipro' ) . '</a>',			
		'default' => 'center top'
	);
	
	$bgattachment = array(
		'scroll' => 'Scroll',
		'fixed' => 'Fixed',
		'local' => 'Local',
		'initial' => 'Initial',
		'inherit' => 'Inherit',
	);
	$options[$gmrprefix . '_headerimage_bgattachment'] = array(
		'id' => $gmrprefix . '_headerimage_bgattachment',
		'label'   => __( 'Background Attachment', 'muvipro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $bgattachment,
		'priority' => 45,
		'description' => __( 'The background-attachment property sets whether a header image is fixed or scrolls with the rest of the page.', 'muvipro' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/pr_background-attachment.asp', 'muvipro' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'muvipro' ) . '</a>',
		'default' => 'scroll'
	);
	
	$section = 'header_color';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Header Color', 'muvipro' ),
		'priority' => 40,
		'panel' => $panel_header,
		'description' => __( 'Allow you customize header color style.', 'muvipro' )
	);
	
	$options[$gmrprefix . '_header-bgcolor'] = array(
		'id' => $gmrprefix . '_header-bgcolor',
		'label'   => __( 'Background Color - Header', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $header_bgcolor,
	);
	
	$options[$gmrprefix . '_sitetitle-color'] = array(
		'id' => $gmrprefix . '_sitetitle-color',
		'label'   => __( 'Site title color', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $sitetitle_color,
	);
	
	$options[$gmrprefix . '_sitedesc-color'] = array(
		'id' => $gmrprefix . '_sitedesc-color',
		'label'   => __( 'Header color', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $sitedesc_color,
	);
	
	$options[$gmrprefix . '_mainmenu-bgcolor'] = array(
		'id' => $gmrprefix . '_mainmenu-bgcolor',
		'label'   => __( 'Background Menu', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_bgcolor,
	);
	
	$options[$gmrprefix . '_mainmenu-hoverbgcolor'] = array(
		'id' => $gmrprefix . '_mainmenu-hoverbgcolor',
		'label'   => __( 'Background Menu Hover and Active', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_hoverbgcolor,
	);
	
	$options[$gmrprefix . '_mainmenu-color'] = array(
		'id' => $gmrprefix . '_mainmenu-color',
		'label'   => __( 'Text color - Menu', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_color,
	);
	
	$options[$gmrprefix . '_hovermenu-color'] = array(
		'id' => $gmrprefix . '_hovermenu-color',
		'label'   => __( 'Text hover color - Menu', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_hovercolor,
	);
	
	$options[$gmrprefix . '_secondmainmenu-bgcolor'] = array(
		'id' => $gmrprefix . '_secondmainmenu-bgcolor',
		'label'   => __( 'Background Menu', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondmenu_bgcolor,
	);
	
	$options[$gmrprefix . '_secondmainmenu-hoverbgcolor'] = array(
		'id' => $gmrprefix . '_secondmainmenu-hoverbgcolor',
		'label'   => __( 'Background Menu Hover and Active', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondmenu_hoverbgcolor,
	);
	
	$options[$gmrprefix . '_secondmainmenu-color'] = array(
		'id' => $gmrprefix . '_secondmainmenu-color',
		'label'   => __( 'Text color - Menu', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondmenu_color,
	);
	
	$options[$gmrprefix . '_secondhovermenu-color'] = array(
		'id' => $gmrprefix . '_secondhovermenu-color',
		'label'   => __( 'Text hover color - Menu', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondmenu_hovercolor,
	);
	
	$options[$gmrprefix . '_topnav-bgcolor'] = array(
		'id' => $gmrprefix . '_topnav-bgcolor',
		'label'   => __( 'Background Top Navigation', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $topnav_bgcolor,
	);
	
	$options[$gmrprefix . '_topnav-color'] = array(
		'id' => $gmrprefix . '_topnav-color',
		'label'   => __( 'Text color - Top Navigation', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $topnav_color,
	);
	
	$options[$gmrprefix . '_hovertopnav-color'] = array(
		'id' => $gmrprefix . '_hovertopnav-color',
		'label'   => __( 'Text hover color - Top Navigation', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $topnav_hovercolor,
	);
	
	$section = 'social';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Social & Top Navigation', 'muvipro' ),
		'priority' => 40,
		'panel' => $panel_header,
		'description' => __( 'Allow you add social icon and disable top navigation.', 'muvipro' )
	);
	
	$options[$gmrprefix . '_active-topnavigation'] = array(
		'id' => $gmrprefix . '_active-topnavigation',
		'label'   => __( 'Disable top navigation', 'muvipro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);
	
	$options[$gmrprefix . '_active-rssicon'] = array(
		'id' => $gmrprefix . '_active-rssicon',
		'label'   => __( 'Disable RSS icon in social', 'muvipro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);
	
	$options[$gmrprefix . '_fb_url_icon'] = array(
		'id' => $gmrprefix . '_fb_url_icon',
		'label'   => __( 'FB Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_twitter_url_icon'] = array(
		'id' => $gmrprefix . '_twitter_url_icon',
		'label'   => __( 'Twitter Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_pinterest_url_icon'] = array(
		'id' => $gmrprefix . '_pinterest_url_icon',
		'label'   => __( 'Pinterest Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_googleplus_url_icon'] = array(
		'id' => $gmrprefix . '_googleplus_url_icon',
		'label'   => __( 'Google Plus Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_tumblr_url_icon'] = array(
		'id' => $gmrprefix . '_tumblr_url_icon',
		'label'   => __( 'Tumblr Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_stumbleupon_url_icon'] = array(
		'id' => $gmrprefix . '_stumbleupon_url_icon',
		'label'   => __( 'Stumbleupon Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_wordpress_url_icon'] = array(
		'id' => $gmrprefix . '_wordpress_url_icon',
		'label'   => __( 'Wordpress Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_instagram_url_icon'] = array(
		'id' => $gmrprefix . '_instagram_url_icon',
		'label'   => __( 'Instagram Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_dribbble_url_icon'] = array(
		'id' => $gmrprefix . '_dribbble_url_icon',
		'label'   => __( 'Dribbble Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_vimeo_url_icon'] = array(
		'id' => $gmrprefix . '_vimeo_url_icon',
		'label'   => __( 'Vimeo Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_linkedin_url_icon'] = array(
		'id' => $gmrprefix . '_linkedin_url_icon',
		'label'   => __( 'Linkedin Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_deviantart_url_icon'] = array(
		'id' => $gmrprefix . '_deviantart_url_icon',
		'label'   => __( 'Deviantart Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_myspace_url_icon'] = array(
		'id' => $gmrprefix . '_myspace_url_icon',
		'label'   => __( 'Myspace Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_skype_url_icon'] = array(
		'id' => $gmrprefix . '_skype_url_icon',
		'label'   => __( 'Skype Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_youtube_url_icon'] = array(
		'id' => $gmrprefix . '_youtube_url_icon',
		'label'   => __( 'Youtube Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_picassa_url_icon'] = array(
		'id' => $gmrprefix . '_picassa_url_icon',
		'label'   => __( 'Picassa Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_flickr_url_icon'] = array(
		'id' => $gmrprefix . '_flickr_url_icon',
		'label'   => __( 'Flickr Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_blogger_url_icon'] = array(
		'id' => $gmrprefix . '_blogger_url_icon',
		'label'   => __( 'Blogger Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_spotify_url_icon'] = array(
		'id' => $gmrprefix . '_spotify_url_icon',
		'label'   => __( 'Spotify Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$options[$gmrprefix . '_delicious_url_icon'] = array(
		'id' => $gmrprefix . '_delicious_url_icon',
		'label'   => __( 'Delicious Url', 'muvipro' ),
		'section' => $section,
		'type'    => 'url',
		'description' => __( 'Fill using http:// or https://', 'muvipro' ),
		'priority' => 90
	);
	
	$section = 'menu_style';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Menu Style', 'muvipro' ),
		'priority' => 40,
		'panel' => $panel_header,
		'description' => __( 'Allow you customize menu style.', 'muvipro' )
	);

	$sticky = array(
		'sticky' => __( 'Sticky', 'muvipro' ),
		'nosticky' => __( 'Static', 'muvipro' ),
	);
	$options[$gmrprefix . '_sticky_menu'] = array(
		'id' => $gmrprefix . '_sticky_menu',
		'label'   => __( 'Sticky Menu', 'muvipro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $sticky,
		'default' => 'nosticky'
	);
	
	$menustyle = array(
		'gmr-boxmenu' => __( 'Box Menu', 'muvipro' ),
		'gmr-fluidmenu' => __( 'Fluid Menu', 'muvipro' ),
	);
	$options[$gmrprefix . '_menu_style'] = array(
		'id' => $gmrprefix . '_menu_style',
		'label'   => __( 'Menu Style', 'muvipro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $menustyle,
		'default' => 'gmr-fluidmenu'
	);
	
	$section = 'notification_options';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Home Notification', 'muvipro' ),
		'priority' => 50,
		'panel' => $panel_header,
		'description' => __( 'Allow you add text notification after menu, and display it in front page.', 'muvipro' )
	);
	
	$options[$gmrprefix . '_text_notification'] = array(
		'id' => $gmrprefix . '_text_notification',
		'label'   => __( 'Text Notification.', 'muvipro' ),
		'section' => $section,
		'type'    => 'textarea',
		'priority' => 30,
		'description' => __( 'Please insert your text notification here.', 'muvipro' )
	);
	
	/*
	 * Blog Section Options
	 *
	 * @since v.1.0.0
	 */
	 
	$panel_blog = 'panel-blog';
	$panels[] = array(
		'id' => $panel_blog,
		'title' => __( 'Movie', 'muvipro' ),
		'priority' => '50'
	);

	$section = 'bloglayout';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Movie Layout', 'muvipro' ),
		'priority' => 50,
		'panel' => $panel_blog
	);
	$sidebar = array(
		'sidebar' => __( 'Sidebar', 'muvipro' ),
		'fullwidth' => __( 'Fullwidth', 'muvipro' )
	);
	$options[$gmrprefix . '_blog_sidebar'] = array(
		'id' => $gmrprefix . '_blog_sidebar',
		'label'   => __( 'Movie Sidebar', 'muvipro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $sidebar,
		'default' => 'sidebar'
	);
	
	$options[$gmrprefix . '_single_sidebar'] = array(
		'id' => $gmrprefix . '_single_sidebar',
		'label'   => __( 'Single Movie Sidebar', 'muvipro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $sidebar,
		'default' => 'sidebar'
	);
	
	$section = 'blogcontent';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Movie Content', 'muvipro' ),
		'priority' => 50,
		'panel' => $panel_blog
	);
	
	$options[$gmrprefix . '_active-singlethumb'] = array(
		'id' => $gmrprefix . '_active-singlethumb',
		'label'   => __( 'Disable Single Thumbnail', 'muvipro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);
	
	$player_style = array(
		'ajax' => __( 'Using Ajax Tab', 'muvipro' ),
		'subpage' => __( 'Using Sub Page Tab', 'muvipro' ),
	);
	$options[$gmrprefix . '_player_style'] = array(
		'id' => $gmrprefix . '_player_style',
		'label'   => __( 'Player Style', 'muvipro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $player_style,
		'default' => 'ajax'
	);
	
	$player = array(
		'trailer' => __( 'Display trailer if have not embed code', 'muvipro' ),
		'text' => __( 'Display comming soon text if have not embed code(Not display on TV Show)', 'muvipro' ),
		'nodisplay' => __( 'Do not display anything', 'muvipro' ),
	);
	$options[$gmrprefix . '_player_appear'] = array(
		'id' => $gmrprefix . '_player_appear',
		'label'   => __( 'Player', 'muvipro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $player,
		'default' => 'trailer'
	);
	$options[$gmrprefix . '_textplayer'] = array(
		'id' => $gmrprefix . '_textplayer',
		'label'   => __( 'Comming Soon Text.', 'muvipro' ),
		'section' => $section,
		'type'    => 'textarea',
		'description' => __( 'If you choose "Display text" in player above, you can fill text for display your own text.', 'muvipro' )
	);
	$options[$gmrprefix . '_notifplayer'] = array(
		'id' => $gmrprefix . '_notifplayer',
		'label'   => __( 'Player Notification.', 'muvipro' ),
		'section' => $section,
		'type'    => 'textarea',
		'description' => __( 'Allow you add text notification before player, you can add another player notification via custom field in player settings.', 'muvipro' )
	);
	
	/*
	 * Footer Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_footer = 'panel-footer';
	$panels[] = array(
		'id' => $panel_footer,
		'title' => __( 'Footer', 'muvipro' ),
		'priority' => '50'
	);
	
	$section = 'widget_section';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Widgets Footer', 'muvipro' ),
		'priority' => 50,
		'panel' => $panel_footer,
		'description' => __( 'Footer widget columns.', 'muvipro' )
	);
	
	$columns = array(
		'1' => __( '1 Column', 'muvipro' ),
		'2' => __( '2 Columns', 'muvipro' ),
		'3' => __( '3 Columns', 'muvipro' ),
		'4' => __( '4 Columns', 'muvipro' ),
	);
	$options[$gmrprefix . '_footer_column'] = array(
		'id' => $gmrprefix . '_footer_column',
		'label'   => __( 'Widgets Footer', 'muvipro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $columns,
		'default' => '3'
	);
	
	$section = 'copyright_section';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Copyright', 'muvipro' ),
		'priority' => 60,
		'panel' => $panel_footer
	);
	
	$options[$gmrprefix . '_copyright'] = array(
		'id' => $gmrprefix . '_copyright',
		'label'   => __( 'Footer Copyright.', 'muvipro' ),
		'section' => $section,
		'type'    => 'textarea',
		'priority' => 60,
		'description' => __( 'Display your own copyright text in footer.', 'muvipro' )
	);
	
	$section = 'footer_color';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Footer Color', 'muvipro' ),
		'priority' => 60,
		'panel' => $panel_footer,
		'description' => __( 'Allow you customize footer color style.', 'muvipro' )
	);
	
	$options[$gmrprefix . '_footer-bgcolor'] = array(
		'id' => $gmrprefix . '_footer-bgcolor',
		'label'   => __( 'Background Color - Footer', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_bgcolor,
	);
	
	$options[$gmrprefix . '_footer-fontcolor'] = array(
		'id' => $gmrprefix . '_footer-fontcolor',
		'label'   => __( 'Font Color - Footer', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_fontcolor,
	);
	
	$options[$gmrprefix . '_footer-linkcolor'] = array(
		'id' => $gmrprefix . '_footer-linkcolor',
		'label'   => __( 'Link Color - Footer', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_linkcolor,
	);
	
	$options[$gmrprefix . '_footer-hoverlinkcolor'] = array(
		'id' => $gmrprefix . '_footer-hoverlinkcolor',
		'label'   => __( 'Hover Link Color - Footer', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_hoverlinkcolor,
	);
	
	$options[$gmrprefix . '_copyright-bgcolor'] = array(
		'id' => $gmrprefix . '_copyright-bgcolor',
		'label'   => __( 'Background Color - Copyright', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_bgcolor,
	);
	
	$options[$gmrprefix . '_copyright-fontcolor'] = array(
		'id' => $gmrprefix . '_copyright-fontcolor',
		'label'   => __( 'Font Color - Copyright', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_fontcolor,
	);
	
	$options[$gmrprefix . '_copyright-linkcolor'] = array(
		'id' => $gmrprefix . '_copyright-linkcolor',
		'label'   => __( 'Link Color - Copyright', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_linkcolor,
	);
	
	$options[$gmrprefix . '_copyright-hoverlinkcolor'] = array(
		'id' => $gmrprefix . '_copyright-hoverlinkcolor',
		'label'   => __( 'Hover Link Color - Copyright', 'muvipro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_hoverlinkcolor,
	);
	
	/* 
	 * Call if only woocommerce actived
	 *
	 * @since v.1.0.0
	 */
	if ( class_exists( 'WooCommerce' ) ) {
		
		// Woocommerce options
		$section = 'woocommerce';
		$sections[] = array(
			'id' => $section,
			'title' => __( 'Woocommerce', 'muvipro' ),
			'priority' => 100
		);
		$columns = array(
			'2' => __( '2 Columns', 'muvipro' ),
			'3' => __( '3 Columns', 'muvipro' ),
			'4' => __( '4 Columns', 'muvipro' ),
			'5' => __( '5 Columns', 'muvipro' ),
			'6' => __( '6 Columns', 'muvipro' ),
		);
		$options[$gmrprefix . '_wc_column'] = array(
			'id' => $gmrprefix . '_wc_column',
			'label'   => __( 'Product Columns', 'muvipro' ),
			'section' => $section,
			'type'    => 'select',
			'choices' => $columns,
			'default' => '3'
		);
		$sidebar = array(
			'sidebar' => __( 'Sidebar', 'muvipro' ),
			'fullwidth' => __( 'Fullwidth', 'muvipro' ),
		);
		$options[$gmrprefix . '_wc_sidebar'] = array(
			'id' => $gmrprefix . '_wc_sidebar',
			'label'   => __( 'Woocommerce Sidebar', 'muvipro' ),
			'section' => $section,
			'type'    => 'radio',
			'choices' => $sidebar,
			'default' => 'sidebar'
		);
		$product_per_page = array(
			'6' => __( '6 Products', 'muvipro' ),
			'7' => __( '7 Products', 'muvipro' ),
			'8' => __( '8 Products', 'muvipro' ),
			'9' => __( '9 Products', 'muvipro' ),
			'10' => __( '10 Products', 'muvipro' ),
			'11' => __( '11 Products', 'muvipro' ),
			'12' => __( '12 Products', 'muvipro' ),
			'13' => __( '13 Products', 'muvipro' ),
			'14' => __( '14 Products', 'muvipro' ),
			'15' => __( '15 Products', 'muvipro' ),
			'16' => __( '16 Products', 'muvipro' ),
			'17' => __( '17 Products', 'muvipro' ),
			'18' => __( '18 Products', 'muvipro' ),
			'19' => __( '19 Products', 'muvipro' ),
			'20' => __( '20 Products', 'muvipro' ),
			'21' => __( '21 Products', 'muvipro' ),
			'22' => __( '22 Products', 'muvipro' ),
			'23' => __( '23 Products', 'muvipro' ),
			'24' => __( '24 Products', 'muvipro' ),
			'25' => __( '25 Products', 'muvipro' ),
			'26' => __( '26 Products', 'muvipro' ),
			'27' => __( '27 Products', 'muvipro' ),
			'28' => __( '28 Products', 'muvipro' ),
			'29' => __( '29 Products', 'muvipro' ),
			'30' => __( '30 Products', 'muvipro' ),
		);
		$options[$gmrprefix . '_wc_productperpage'] = array(
			'id' => $gmrprefix . '_wc_productperpage',
			'label'   => __( 'Woocommerce Product Per Page', 'muvipro' ),
			'section' => $section,
			'type'    => 'select',
			'choices' => $product_per_page,
			'default' => '9'
		);
		
		$options[$gmrprefix . '_active-cartbutton'] = array(
			'id' => $gmrprefix . '_active-cartbutton',
			'label'   => __( 'Remove Cart button from menu', 'muvipro' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => 0,
		);
		
	}
	
	// Adds the sections to the $options array
	$options['sections'] = $sections;
	// Adds the panels to the $options array
	$options['panels'] = $panels;
	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );
	// To delete custom mods use: customizer_library_remove_theme_mods();
}
add_action( 'init', 'gmr_library_options_customizer' );

if ( ! function_exists( 'customizer_library_demo_build_styles' ) && class_exists( 'Customizer_Library_Styles' ) ) :
/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * @since 1.0.0
 *
 * @return void
 */
function gmr_library_customizer_build_styles() {
	
	// Content Background Color
	$setting = 'gmr_content-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'body'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// Color scheme
	$setting = 'gmr_scheme-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'kbd',
				'a.button',
				'button',
				'.button',
				'button.button',
				'input[type="button"]',
				'input[type="reset"]',
				'input[type="submit"]',
				'ul.page-numbers li span.page-numbers',
				'ul.page-numbers li a:hover',
				'.widget-title:before',
				'.widget-title:after',
				'.page-title:before',
				'.page-title:after',
				'.tagcloud a',
				'.page-links a .page-link-number:hover',
				'.homemodule-title',
				'.module-linktitle a',
				'.post-navigation .nav-previous span',
				'.post-navigation .nav-next span',
				'.gmr-grid .item .gmr-box-content .content-thumbnail .gmr-posttype-item'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
		
		if ( class_exists( 'WooCommerce' ) ) {

			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add( array(
				'selectors' => array(
					'.woocommerce #respond input#submit', 
					'.woocommerce a.button', 
					'.woocommerce button.button', 
					'.woocommerce input.button',
					'.woocommerce #respond input#submit.alt', 
					'.woocommerce a.button.alt', 
					'.woocommerce button.button.alt', 
					'.woocommerce input.button.alt',
					'.woocommerce #respond input#submit:hover', 
					'.woocommerce a.button:hover', 
					'.woocommerce button.button:hover', 
					'.woocommerce input.button:hover',
					'.woocommerce #respond input#submit:focus', 
					'.woocommerce a.button:focus', 
					'.woocommerce button.button:focus', 
					'.woocommerce input.button:focus',
					'.woocommerce #respond input#submit:active', 
					'.woocommerce a.button:active', 
					'.woocommerce button.button:active', 
					'.woocommerce input.button:active',
					'.woocommerce #respond input#submit.alt:hover',
					'.woocommerce a.button.alt:hover',
					'.woocommerce button.button.alt:hover',
					'.woocommerce input.button.alt:hover',
					'.woocommerce #respond input#submit.alt:focus',
					'.woocommerce a.button.alt:focus',
					'.woocommerce button.button.alt:focus',
					'.woocommerce input.button.alt:focus',
					'.woocommerce #respond input#submit.alt:active',
					'.woocommerce a.button.alt:active',
					'.woocommerce button.button.alt:active',
					'.woocommerce input.button.alt:active'
				),
				'declarations' => array(
					'background-color' => $color
				)
			) );
		
		}
		
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'a',
				'a:hover',
				'a:focus',
				'a:active'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
		
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'a.button',
				'button',
				'.button',
				'button.button',
				'input[type="button"]',
				'input[type="reset"]',
				'input[type="submit"]',
				'.sticky .gmr-box-content',
				'.gmr-theme div.sharedaddy h3.sd-title:before',
				'.bypostauthor > .comment-body',
				'.gmr-movie-data'
			),
			'declarations' => array(
				'border-color' => $color
			)
		) );
		
	}
	
	// Color scheme
	$setting = 'gmr_second-scheme-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-popup-button-widget a',
				'.gmr-popup-button a',
				'.module-linktitle a',
				'.gmr-grid .item .gmr-box-content .content-thumbnail .gmr-quality-item a'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-popup-button-widget a',
				'.gmr-popup-button a',
			),
			'declarations' => array(
				'border-color' => $color
			)
		) );
		
	}

	// Header Background image
	$url = has_header_image() ? get_header_image() : get_theme_support( 'custom-header', 'default-image' );
	$setting = 'gmr_active-headerimage';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod === 0 ) {
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header'
			),
			'declarations' => array(
				'background-image' => 'url(' . $url . ')',
			)
		) );
	}
	
	// Header Background Size
	$setting = 'gmr_headerimage_bgsize';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$bgsize = wp_filter_nohtml_kses( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header'
			),
			'declarations' => array(
				'-webkit-background-size' => $bgsize,
				'-moz-background-size' => $bgsize,
				'-o-background-size' => $bgsize,
				'background-size' => $bgsize
			)
		) );
	}
	
	// Header Background Repeat
	$setting = 'gmr_headerimage_bgrepeat';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$bgrepeat = wp_filter_nohtml_kses( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header'
			),
			'declarations' => array(
				'background-repeat' => $bgrepeat
			)
		) );
	}
	
	// Header Background Position
	$setting = 'gmr_headerimage_bgposition';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$bgposition = wp_filter_nohtml_kses( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header'
			),
			'declarations' => array(
				'background-position' => $bgposition
			)
		) );
	}

	// Header Background Position
	$setting = 'gmr_headerimage_bgattachment';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$bgattachment = wp_filter_nohtml_kses( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header'
			),
			'declarations' => array(
				'background-attachment' => $bgattachment
			)
		) );
	}
	
	// Header Background Color
	$setting = 'gmr_header-bgcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}

	// site title
	$setting = 'gmr_sitetitle-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-title a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// site description
	$setting = 'gmr_sitedesc-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-description',
				'.gmr-search input[type="text"]'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// body size
	$setting = 'gmr_logo_margintop';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$size = absint( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-logo'
			),
			'declarations' => array(
				'margin-top' => $size . 'px'
			)
		) );
	}
	
	//primary menu
	$setting = 'gmr_mainmenu-bgcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-menuwrap'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	
	// Menu text color
	$setting = 'gmr_mainmenu-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#gmr-responsive-menu',
				'#primary-menu > li > a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
		
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#primary-menu > li.menu-border > a span'
			),
			'declarations' => array(
				'border-color' => $color
			)
		) );
		
		
	}
	
	// Hover text color
	$setting = 'gmr_hovermenu-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#gmr-responsive-menu:hover',
				'.gmr-mainmenu #primary-menu > li:hover > a',
				'.gmr-mainmenu #primary-menu .current-menu-item > a',
				'.gmr-mainmenu #primary-menu .current-menu-ancestor > a',
				'.gmr-mainmenu #primary-menu .current_page_item > a',
				'.gmr-mainmenu #primary-menu .current_page_ancestor > a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
		
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-mainmenu #primary-menu > li.menu-border:hover > a span',
				'.gmr-mainmenu #primary-menu > li.menu-border.current-menu-item > a span',
				'.gmr-mainmenu #primary-menu > li.menu-border.current-menu-ancestor > a span',
				'.gmr-mainmenu #primary-menu > li.menu-border.current_page_item > a span',
				'.gmr-mainmenu #primary-menu > li.menu-border.current_page_ancestor > a span'
			),
			'declarations' => array(
				'border-color' => $color
			)
		) );
		
	}
	
	$setting = 'gmr_mainmenu-hoverbgcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-mainmenu #primary-menu > li:hover > a',
				'.gmr-mainmenu #primary-menu .current-menu-item > a',
				'.gmr-mainmenu #primary-menu .current-menu-ancestor > a',
				'.gmr-mainmenu #primary-menu .current_page_item > a',
				'.gmr-mainmenu #primary-menu .current_page_ancestor > a'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	
	// secondary menu
	$setting = 'gmr_secondmainmenu-bgcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-secondmenuwrap'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	
	// Menu text color
	$setting = 'gmr_secondmainmenu-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#gmr-secondaryresponsive-menu',
				'.gmr-secondmenu #primary-menu > li > a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
		
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-secondmenu #primary-menu > li.menu-border > a span'
			),
			'declarations' => array(
				'border-color' => $color
			)
		) );
		
		
	}
	
	// Hover text color
	$setting = 'gmr_secondhovermenu-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#gmr-secondaryresponsive-menu:hover',
				'.gmr-secondmenu #primary-menu > li:hover > a',
				'.gmr-secondmenu #primary-menu .current-menu-item > a',
				'.gmr-secondmenu #primary-menu .current-menu-ancestor > a',
				'.gmr-secondmenu #primary-menu .current_page_item > a',
				'.gmr-secondmenu #primary-menu .current_page_ancestor > a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
		
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-secondmenu #primary-menu > li.menu-border:hover > a span',
				'.gmr-secondmenu #primary-menu > li.menu-border.current-menu-item > a span',
				'.gmr-secondmenu #primary-menu > li.menu-border.current-menu-ancestor > a span',
				'.gmr-secondmenu #primary-menu > li.menu-border.current_page_item > a span',
				'.gmr-secondmenu #primary-menu > li.menu-border.current_page_ancestor > a span'
			),
			'declarations' => array(
				'border-color' => $color
			)
		) );
		
	}
	
	$setting = 'gmr_secondmainmenu-hoverbgcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-secondmenu #primary-menu > li:hover > a',
				'.gmr-secondmenu #primary-menu .current-menu-item > a',
				'.gmr-secondmenu #primary-menu .current-menu-ancestor > a',
				'.gmr-secondmenu #primary-menu .current_page_item > a',
				'.gmr-secondmenu #primary-menu .current_page_ancestor > a'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	
	// Top navigation background color
	$setting = 'gmr_topnav-bgcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-topnavmenuwrap'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	
	// Menu text color
	$setting = 'gmr_topnav-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#gmr-topnavresponsive-menu',
				'.gmr-topnavmenu #primary-menu > li > a',
				'.gmr-social-icon ul > li > a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
		
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-topnavmenu #primary-menu > li.menu-border > a span'
			),
			'declarations' => array(
				'border-color' => $color
			)
		) );
		
		
	}
	
	// Hover text color
	$setting = 'gmr_hovertopnav-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#gmr-topnavresponsive-menu:hover',
				'.gmr-topnavmenu #primary-menu > li:hover > a',
				'.gmr-topnavmenu #primary-menu .current-menu-item > a',
				'.gmr-topnavmenu #primary-menu .current-menu-ancestor > a',
				'.gmr-topnavmenu #primary-menu .current_page_item > a',
				'.gmr-topnavmenu #primary-menu .current_page_ancestor > a',
				'.gmr-social-icon ul > li > a:hover'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
		
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-topnavmenu #primary-menu > li.menu-border:hover > a span',
				'.gmr-topnavmenu #primary-menu > li.menu-border.current-menu-item > a span',
				'.gmr-topnavmenu #primary-menu > li.menu-border.current-menu-ancestor > a span',
				'.gmr-topnavmenu #primary-menu > li.menu-border.current_page_item > a span',
				'.gmr-topnavmenu #primary-menu > li.menu-border.current_page_ancestor > a span'
			),
			'declarations' => array(
				'border-color' => $color
			)
		) );
		
	}
	
	// Content Background Color
	$setting = 'gmr_content-bgcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.gmr-content',
				'.idmuvi-topbanner'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}

	// Primary Font
	$setting = 'gmr_primary-font';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$stack = customizer_library_get_font_stack( $mod );
	if ( $mod ) {
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
				'.h1',
				'.h2',
				'.h3',
				'.h4',
				'.h5',
				'.h6',
				'.site-title',
				'#gmr-responsive-menu',
				'#primary-menu > li > a'
			),
			'declarations' => array(
				'font-family' => $stack
			)
		) );
	}
	
	// Secondary Font
	$setting = 'gmr_secondary-font';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$stack = customizer_library_get_font_stack( $mod );
	if ( $mod ) {
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'body',
			),
			'declarations' => array(
				'font-family' => $stack
			)
		) );
	}
	
	$setting = 'gmr_secondary-font-weight';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$size = absint( $mod );	
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'body',
			),
			'declarations' => array(
				'font-weight' => $size
			)
		) );
	}
	
	// body size
	$setting = 'gmr_body_size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$size = absint( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'body'
			),
			'declarations' => array(
				'font-size' => $size . 'px'
			)
		) );
	}
	
	// h1 size
	$setting = 'gmr_h1_size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$size = absint( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h1'
			),
			'declarations' => array(
				'font-size' => $size . 'px'
			)
		) );
	}
	
	// h2 size
	$setting = 'gmr_h2_size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$size = absint( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h2'
			),
			'declarations' => array(
				'font-size' => $size . 'px'
			)
		) );
	}
	
	// h3 size
	$setting = 'gmr_h3_size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$size = absint( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h3'
			),
			'declarations' => array(
				'font-size' => $size . 'px'
			)
		) );
	}
	
	// h4 size
	$setting = 'gmr_h4_size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$size = absint( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h4'
			),
			'declarations' => array(
				'font-size' => $size . 'px'
			)
		) );
	}
	
	// h5 size
	$setting = 'gmr_h5_size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$size = absint( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h5'
			),
			'declarations' => array(
				'font-size' => $size . 'px'
			)
		) );
	}
	
	// h6 size
	$setting = 'gmr_h6_size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$size = absint( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h6'
			),
			'declarations' => array(
				'font-size' => $size . 'px'
			)
		) );
	}
	
	// Footer Background Color
	$setting = 'gmr_footer-bgcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.widget-footer'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	
	// Footer Font Color
	$setting = 'gmr_footer-fontcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.widget-footer'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// Footer Link Color
	$setting = 'gmr_footer-linkcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.widget-footer a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// Footer Hover Link Color
	$setting = 'gmr_footer-hoverlinkcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.widget-footer a:hover'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// Copyright Background Color
	$setting = 'gmr_copyright-bgcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-footer'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	
	// Copyright Font Color
	$setting = 'gmr_copyright-fontcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-footer'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// Copyright Link Color
	$setting = 'gmr_copyright-linkcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-footer a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// copyright Hover Link Color
	$setting = 'gmr_copyright-hoverlinkcolor';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	if ( $mod ) {
		$color = sanitize_hex_color( $mod );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-footer a:hover'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
}
endif; // endif gmr_library_customizer_build_styles
add_action( 'customizer_library_styles', 'gmr_library_customizer_build_styles' );

if ( ! function_exists( 'customizer_library_demo_styles' ) ) :
/**
 * Generates the style tag and CSS needed for the theme options.
 *
 * By using the "Customizer_Library_Styles" filter, different components can print CSS in the header.
 * It is organized this way to ensure there is only one "style" tag.
 *
 * @since 1.0.0
 *
 * @return void
 */
function gmr_library_customizer_styles() {
	do_action( 'customizer_library_styles' );
	// Echo the rules
	$css = Customizer_Library_Styles()->build();
	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'muvipro-style', $css );
	}
}
endif; // endif gmr_library_customizer_styles
add_action( 'wp_enqueue_scripts', 'gmr_library_customizer_styles' );

if ( ! function_exists( 'gmr_remove_customizer_register' ) ) :
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function gmr_remove_customizer_register( $wp_customize ) {
    $wp_customize->remove_control( 'display_header_text' );
}
endif; // endif gmr_remove_customizer_register
add_action( 'customize_register', 'gmr_remove_customizer_register' );