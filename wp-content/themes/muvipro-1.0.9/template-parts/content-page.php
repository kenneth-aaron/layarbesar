<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php echo muvipro_itemtype_schema( 'CreativeWork' ); ?>>

	<div class="gmr-box-content gmr-single">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title page-title" ' . muvipro_itemprop_schema( 'headline' ) . '>', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content entry-content-page" <?php echo muvipro_itemprop_schema( 'text' ); ?>>
			<?php
				the_content();
			?>
		</div><!-- .entry-content -->

		<?php edit_post_link( __( 'Edit', 'muvipro' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>
		
	</div><!-- .gmr-box-content -->
	
</article><!-- #post-## -->