<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
			</div><!-- .row -->
		</div><!-- .container -->
		<div id="stop-container"></div>
		<?php do_action( 'idmuvi_core_banner_footer' ); ?>
	</div><!-- .gmr-content -->
</div><!-- #site-container -->

<div id="footer-container">

	<div class="gmr-bgstripes">
		<span class="gmr-bgstripe gmr-color1"></span><span class="gmr-bgstripe gmr-color2"></span>
		<span class="gmr-bgstripe gmr-color3"></span><span class="gmr-bgstripe gmr-color4"></span>
		<span class="gmr-bgstripe gmr-color5"></span><span class="gmr-bgstripe gmr-color6"></span>
		<span class="gmr-bgstripe gmr-color7"></span><span class="gmr-bgstripe gmr-color8"></span>
		<span class="gmr-bgstripe gmr-color9"></span><span class="gmr-bgstripe gmr-color10"></span>
		<span class="gmr-bgstripe gmr-color11"></span><span class="gmr-bgstripe gmr-color12"></span>
		<span class="gmr-bgstripe gmr-color13"></span><span class="gmr-bgstripe gmr-color14"></span>
		<span class="gmr-bgstripe gmr-color15"></span><span class="gmr-bgstripe gmr-color16"></span>
		<span class="gmr-bgstripe gmr-color17"></span><span class="gmr-bgstripe gmr-color18"></span>
		<span class="gmr-bgstripe gmr-color19"></span><span class="gmr-bgstripe gmr-color20"></span>
	</div>

	<?php
	$mod = get_theme_mod( 'gmr_footer_column', '3' );
	if ( $mod == '4' ) {
		$class = 'col-md-3';
	} elseif ( $mod == '3' ) {
		$class = 'col-md-4';
	} elseif ( $mod == '2' ) {
		$class = 'col-md-6';
	} else {
		$class = 'col-md-12';
	}
	
	if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' )	|| is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
		<div id="footer-sidebar" class="widget-footer" role="complementary">
			<div class="container">
				<div class="row">
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<div class="footer-column <?php echo $class; ?>">
							<?php dynamic_sidebar( 'footer-1'); ?>
						</div>
					<?php endif; ?>	
					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<div class="footer-column <?php echo $class; ?>">
							<?php dynamic_sidebar( 'footer-2'); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<div class="footer-column <?php echo $class; ?>">
							<?php dynamic_sidebar( 'footer-3'); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
						<div class="footer-column <?php echo $class; ?>">
							<?php dynamic_sidebar( 'footer-4'); ?>
						</div>
					<?php endif; ?>
				</div>	
			</div>	
		</div>
	<?php endif; ?>
	
	<footer id="colophon" class="text-center site-footer" role="contentinfo" <?php muvipro_itemtype_schema( 'WPFooter' ); ?>>
		<div class="container">
			<div class="site-info">
			<?php $copyright = get_theme_mod( 'gmr_copyright' ); 
			if ( $copyright ) :
				// sanitize html output than convert it again using htmlspecialchars_decode
				echo htmlspecialchars_decode( esc_html ( $copyright ) );
			else :
			?>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'muvipro' ) ); ?>" title="<?php printf( esc_html__( 'Proudly powered by %s', 'muvipro' ), 'WordPress' ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'muvipro' ), 'WordPress' ); ?></a>
				<span class="sep"> / </span>
				<a href="<?php echo esc_url( __( 'http://www.gianmr.com/', 'muvipro' ) ); ?>" title="<?php printf( esc_html__( 'Theme: %s', 'muvipro' ), 'Muvipro' ); ?>"><?php printf( esc_html__( 'Theme: %s', 'muvipro' ), 'Muvipro' ); ?></a>
			<?php endif; ?>
			</div><!-- .site-info -->
			<?php do_action( 'idmuvi_core_floating_footer' ) ?>
		</div><!-- .container -->
	</footer><!-- #colophon -->

</div><!-- #footer-container -->

<div class="gmr-ontop gmr-hide"><span class="arrow_carrot-up"></span></div>

<?php wp_footer(); ?>

</body>
</html>