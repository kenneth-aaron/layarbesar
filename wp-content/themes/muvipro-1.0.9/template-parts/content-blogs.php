<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Sidebar layout options via customizer
$sidebar_layout = get_theme_mod( 'gmr_blog_sidebar', 'sidebar' );
	
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-6 item'); ?> <?php echo muvipro_itemtype_schema( 'CreativeWork' ); ?>>
	
	<div class="gmr-box-blog">
	
		<?php
			// Add thumnail
			echo '<div class="content-thumbnail">';
				if ( has_post_thumbnail() ) :
					echo '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">';
							the_post_thumbnail( 'blog-large', array( 'itemprop'=>'image' ) );
					echo '</a>';
				else :
					// do_action( 'funct', $size, $link, $classes = '', $echo = true );
					do_action( 'idmuvi_core_get_images', 'blog-large', true );

				endif; // endif; has_post_thumbnail()
				if ( is_sticky() ) {
					echo '<div class="kbd-sticky">' . __( 'Sticky', 'muvipro' ) . '</div>';
				}
			echo '</div>';
		?>
	
		<header class="entry-header">
			<h2 class="entry-title" <?php echo muvipro_itemprop_schema( 'headline' ); ?>>
				<a href="<?php the_permalink(); ?>" <?php echo muvipro_itemprop_schema( 'url' ); ?> title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
		</header><!-- .entry-header -->		
		<?php the_excerpt(); ?>
		
	</div><!-- .gmr-box-content -->

</article><!-- #post-## -->