<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
				
// Disable thumbnail options via customizer
$thumbnail = get_theme_mod( 'gmr_active-singlethumb', 0 );
// layout masonry base sidebar options
if ( $thumbnail === 0 ) {
	$classes = array(
		'single-thumb'
	);
} else {
	$classes = array(
		'no-single-thumb'
	);
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?> <?php echo muvipro_itemtype_schema( 'CreativeWork' ); ?>>

	<div class="gmr-box-content gmr-single">
		<header class="entry-header">
			<?php gmr_posted_on(); ?>
		</header><!-- .entry-header -->
		
		<?php	
			
			echo '<div class="gmr-movie-data clearfix">';
				
				// Check if the custom field has a value.
				echo '<div class="gmr-movie-data-top">';
					the_title( '<h1 class="entry-title" ' . muvipro_itemprop_schema( 'name' ) . '>', '</h1>' );
				echo '</div>';
			echo '</div>';

		?>
		<div class="entry-content entry-content-single" <?php echo muvipro_itemprop_schema( 'description' ); ?>>
			<?php
				// Content
				the_content();
			?>
		</div><!-- .entry-content -->
		
		<footer class="entry-footer">
			<div class="gmr-footer-posted-on">
				<?php gmr_posted_on(); ?>
			</div>
			<?php 
				// entry footer
				gmr_entry_footer();
	
			?>
		</footer><!-- .entry-footer -->
		
	</div><!-- .gmr-box-content -->

</article><!-- #post-## -->