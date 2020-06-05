<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Muvipro
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head <?php echo muvipro_itemtype_schema( 'WebSite' ); ?>>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php echo muvipro_itemtype_schema( 'WebPage' ); ?>>
	
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'muvipro' ); ?></a>
	
			<?php
				// Disable top navigation via customizer
				$topnav = get_theme_mod( 'gmr_active-topnavigation', 0 );
			?>
			
			<?php if ( $topnav === 0 ) : ?>
				<div class="gmr-topnavmenuwrap clearfix">
					<div class="container">
						<?php // Second top menu
							if ( has_nav_menu( 'topnav' ) ) {
						?>
							<nav id="site-navigation" class="gmr-topnavmenu" role="navigation" <?php echo muvipro_itemtype_schema( 'SiteNavigationElement' ); ?>>
								<?php wp_nav_menu( array( 'theme_location' => 'topnav', 'container' => 'ul', 'fallback_cb' => '', 'menu_id' => 'primary-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>' ) ); ?>
							</nav><!-- #site-navigation -->
						<?php 
							} 
						?>							
						<nav id="site-navigation" class="gmr-social-icon" role="navigation" <?php echo muvipro_itemtype_schema( 'SiteNavigationElement' ); ?>>
							<ul class="pull-right">
								<?php 
									$fb_url = get_theme_mod( 'gmr_fb_url_icon' );  
									if ( $fb_url ) :
										echo '<li><a href="' . esc_url($fb_url) . '" title="' . __( 'Facebook','muvipro' ) . '" rel="nofollow"><span class="social_facebook"></span></a></li>';
									endif;

									$twitter_url = get_theme_mod( 'gmr_twitter_url_icon' );  
									if ( $twitter_url ) :
										echo '<li><a href="' . esc_url($twitter_url) . '" title="' . __( 'Twitter','muvipro' ) . '" rel="nofollow"><span class="social_twitter"></span></a></li>';
									endif;
									
									$pinterest_url = get_theme_mod( 'gmr_pinterest_url_icon' );  
									if ( $pinterest_url ) :
										echo '<li><a href="' . esc_url($pinterest_url) . '" title="' . __( 'Pinterest','muvipro' ) . '" rel="nofollow"><span class="social_pinterest"></span></a></li>';
									endif;
									
									$googleplus_url = get_theme_mod( 'gmr_googleplus_url_icon' );  
									if ( $googleplus_url ) :
										echo '<li><a href="' . esc_url($googleplus_url) . '" title="' . __( 'Google Plus','muvipro' ) . '" rel="nofollow"><span class="social_googleplus"></span></a></li>';
									endif;
									
									$tumblr_url = get_theme_mod( 'gmr_tumblr_url_icon' );  
									if ( $tumblr_url ) :
										echo '<li><a href="' . esc_url($tumblr_url) . '" title="' . __( 'Tumblr','muvipro' ) . '" rel="nofollow"><span class="social_tumblr"></span></a></li>';
									endif;
									
									$stumbleupon_url = get_theme_mod( 'gmr_stumbleupon_url_icon' );  
									if ( $stumbleupon_url ) :
										echo '<li><a href="' . esc_url($stumbleupon_url) . '" title="' . __( 'Stumbleupon','muvipro' ) . '" rel="nofollow"><span class="social_tumbleupon"></span></a></li>';
									endif;
									
									$wordpress_url = get_theme_mod( 'gmr_wordpress_url_icon' );  
									if ( $wordpress_url ) :
										echo '<li><a href="' . esc_url($wordpress_url) . '" title="' . __( 'Wordpress','muvipro' ) . '" rel="nofollow"><span class="social_wordpress"></span></a></li>';
									endif;
									
									$instagram_url = get_theme_mod( 'gmr_instagram_url_icon' );  
									if ( $instagram_url ) :
										echo '<li><a href="' . esc_url($instagram_url) . '" title="' . __( 'Instagram','muvipro' ) . '" rel="nofollow"><span class="social_instagram"></span></a></li>';
									endif;
									
									$dribbble_url = get_theme_mod( 'gmr_dribbble_url_icon' );  
									if ( $dribbble_url ) :
										echo '<li><a href="' . esc_url($dribbble_url) . '" title="' . __( 'Dribbble','muvipro' ) . '" rel="nofollow"><span class="social_dribbble"></span></a></li>';
									endif;
									
									$vimeo_url = get_theme_mod( 'gmr_vimeo_url_icon' );  
									if ( $vimeo_url ) :
										echo '<li><a href="' . esc_url($vimeo_url) . '" title="' . __( 'Vimeo','muvipro' ) . '" rel="nofollow"><span class="social_vimeo"></span></a></li>';
									endif;
									
									$linkedin_url = get_theme_mod( 'gmr_linkedin_url_icon' );  
									if ( $linkedin_url ) :
										echo '<li><a href="' . esc_url($linkedin_url) . '" title="' . __( 'Linkedin','muvipro' ) . '" rel="nofollow"><span class="social_linkedin"></span></a></li>';
									endif;
									
									$deviantart_url = get_theme_mod( 'gmr_deviantart_url_icon' );  
									if ( $deviantart_url ) :
										echo '<li><a href="' . esc_url($deviantart_url) . '" title="' . __( 'Deviantart','muvipro' ) . '" rel="nofollow"><span class="social_deviantart"></span></a></li>';
									endif;
									
									$myspace_url = get_theme_mod( 'gmr_myspace_url_icon' );  
									if ( $myspace_url ) :			
										echo '<li><a href="' . esc_url($myspace_url) . '" title="' . __( 'Myspace','muvipro' ) . '" rel="nofollow"><span class="social_myspace"></span></a></li>';
									endif;
									
									$skype_url = get_theme_mod( 'gmr_skype_url_icon' );  
									if ( $skype_url ) :
										echo '<li><a href="' . esc_url($skype_url) . '" title="' . __( 'Skype','muvipro' ) . '" rel="nofollow"><span class="social_skype"></span></a></li>';
									endif;
									
									$youtube_url = get_theme_mod( 'gmr_youtube_url_icon' );  
									if ( $youtube_url ) :
										echo '<li><a href="' . esc_url($youtube_url) . '" title="' . __( 'Youtube','muvipro' ) . '" rel="nofollow"><span class="social_youtube"></span></a></li>';
									endif;
									
									$picassa_url = get_theme_mod( 'gmr_picassa_url_icon' );  
									if ( $picassa_url ) :	
										echo '<li><a href="' . esc_url($picassa_url) . '" title="' . __( 'Picassa','muvipro' ) . '" rel="nofollow"><span class="social_picassa"></span></a></li>';
									endif;
									
									$flickr_url = get_theme_mod( 'gmr_flickr_url_icon' );  
									if ( $flickr_url ) :	
										echo '<li><a href="' . esc_url($flickr_url) . '" title="' . __( 'Flickr','muvipro' ) . '" rel="nofollow"><span class="social_flickr"></span></a></li>';
									endif;
									
									$blogger_url = get_theme_mod( 'gmr_blogger_url_icon' );  
									if ( $blogger_url ) :	
										echo '<li><a href="' . esc_url($blogger_url) . '" title="' . __( 'Blogger','muvipro' ) . '" rel="nofollow"><span class="social_blogger"></span></a></li>';
									endif;
									
									$spotify_url = get_theme_mod( 'gmr_spotify_url_icon' );  
									if ( $spotify_url ) :	
										echo '<li><a href="' . esc_url($spotify_url) . '" title="' . __( 'Spotify','muvipro' ) . '" rel="nofollow"><span class="social_spotify"></span></a></li>';
									endif;
									
									$delicious_url = get_theme_mod( 'gmr_delicious_url_icon' );  
									if ( $delicious_url ) :
										echo '<li><a href="' . esc_url($delicious_url) . '" title="' . __( 'Delicious','muvipro' ) . '" rel="nofollow"><span class="social_delicious"></span></a></li>';
									endif;
			
									// Disable rss icon via customizer
									$rssicon = get_theme_mod( 'gmr_active-rssicon', 0 );
									if ( $rssicon === 0 ) :
										echo '<li><a href="' . get_bloginfo('rss2_url') . '" title="' . __( 'RSS','muvipro' ) . '" rel="nofollow"><span class="social_rss"></span></a></li>';
									endif;
									
									if ( has_nav_menu( 'topnav' ) ) {
										echo '<li id="gmr-topnavresponsive-menu"><a href="#topnavmenus" title="' . __( 'Menus','muvipro' ) . '" rel="nofollow"><span class="icon_menu-square_alt2"></span> ' . __( 'Menu','muvipro' ) . '</a></li>';
									}
								?>
							</ul>
						</nav><!-- #site-navigation -->	
					</div>
				</div>
			<?php endif; ?>

<div class="site inner-wrap" id="site-container">
	
	<?php 
		// Top banner
		do_action( 'idmuvi_core_top_banner' );
	?>
	
	<?php 
		global $post;
	?>
		<header id="masthead" class="site-header" role="banner" <?php echo muvipro_itemtype_schema( 'WPHeader' ); ?>>
		<?php
			$enable_logo = get_theme_mod( 'gmr_active-logosection', 0 );
			if ( $enable_logo === 0 ) {
		?>
				<div class="container">
					<div class="clearfix gmr-headwrapper">
						<?php 
							do_action( 'gmr_the_custom_logo' );
							do_action( 'gmr_top_searchbutton' );
						?>
					</div>
				</div>
				
		<?php 	
			}
		?>
				
			<?php
			// Menu style via customizer
			$menu_style = get_theme_mod( 'gmr_menu_style', 'gmr-fluidmenu' );
			?>
			
			<div class="top-header">
				<?php if ( $menu_style == 'gmr-boxmenu' ) : ?>
				<div class="container">
				<?php endif; ?>
					<?php // first top menu	?>
						<div class="gmr-menuwrap clearfix">
							<?php if ( $menu_style == 'gmr-fluidmenu' ) : ?>
							<div class="container">
							<?php endif; ?>
								<a id="gmr-responsive-menu" href="#menus">
									<?php esc_html_e( 'MENU', 'muvipro' ); ?>
								</a>
								<nav id="site-navigation" class="gmr-mainmenu" role="navigation" <?php echo muvipro_itemtype_schema( 'SiteNavigationElement' ); ?>>
									<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'ul', 'menu_id' => 'primary-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>' ) ); ?>
								</nav><!-- #site-navigation -->	
							<?php if ( $menu_style == 'gmr-fluidmenu' ) : ?>
							</div>
							<?php endif; ?>
						</div>
				<?php if ( $menu_style == 'gmr-boxmenu' ) : ?>
				</div>
				<?php endif; ?>
			</div><!-- .top-header -->
			
			<div class="second-header">
				<?php if ( $menu_style == 'gmr-boxmenu' ) : ?>
				<div class="container">
				<?php endif; ?>
					<?php // Second top menu
					if ( has_nav_menu( 'secondary' ) ) {
					?>
						<div class="gmr-secondmenuwrap clearfix">
							<?php if ( $menu_style == 'gmr-fluidmenu' ) : ?>
								<div class="container">
							<?php endif; ?>
								<a id="gmr-secondaryresponsive-menu" href="#secondmenus">
									<?php esc_html_e( 'MENU', 'muvipro' ); ?>
								</a>
								<nav id="site-navigation" class="gmr-secondmenu" role="navigation" <?php echo muvipro_itemtype_schema( 'SiteNavigationElement' ); ?>>
									<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => 'ul', 'fallback_cb' => '', 'menu_id' => 'primary-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>' ) ); ?>
								</nav><!-- #site-navigation -->	
							<?php if ( $menu_style == 'gmr-fluidmenu' ) : ?>
								</div>
							<?php endif; ?>
						</div>
					<?php 
					} 
					?>
				<?php if ( $menu_style == 'gmr-boxmenu' ) : ?>
				</div>
				<?php endif; ?>
			</div><!-- .top-header -->
			
			<?php 
				$setting = 'gmr_text_notification';
				$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
				if ( isset($mod) && !empty($mod) && is_front_page() ) {
			?>
				<?php if ( $menu_style == 'gmr-boxmenu' ) : ?>
					<div class="container">
				<?php endif; ?>
						<div class="gmr-notification">
							<div class="container">
								<?php echo do_shortcode($mod); ?>
							</div>
						</div>
				<?php if ( $menu_style == 'gmr-boxmenu' ) : ?>
					</div>
				<?php endif; ?>
			<?php
				}
			?>
		</header><!-- #masthead -->

		<div id="content" class="gmr-content">
		
			<?php do_action( 'idmuvi_core_top_banner_after_menu' ); ?>
			<div class="container">
				<div class="row">