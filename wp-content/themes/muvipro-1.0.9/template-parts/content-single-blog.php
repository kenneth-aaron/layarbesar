<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php echo muvipro_itemtype_schema( 'CreativeWork' ); ?>>

	<div class="gmr-box-content gmr-single gmr-blog">
	
		<header class="entry-header">
			<?php gmr_posted_on(); ?>
		</header><!-- .entry-header -->
	
		<?php
		if ( has_post_thumbnail() ) { ?>
			<figure class="wp-caption alignnone gmr-thumbnail-blog">
				<?php the_post_thumbnail(); ?>
				
				<?php if ( $caption = get_post( get_post_thumbnail_id() )->post_excerpt ) : ?>
					<figcaption class="wp-caption-text"><?php echo $caption; ?></figcaption>
				<?php endif; ?>
			</figure>	
		<?php 
		}
		?>
	
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title" ' . muvipro_itemprop_schema( 'name' ) . '>', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'muvipro' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Blogs:', 'muvipro' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		
		<footer class="entry-footer">
		<?php
			$tags_list = idmuvi_core_get_the_blog_tags( $post->ID, '', ', ' );
			$cats_list = idmuvi_core_get_the_blog_category( $post->ID, '', ', ' );
			
			if ( $cats_list ) {
				printf( '<span class="cat-links">%1$s %2$s</span>',
					_x( 'Posted in', 'Used before categories names.', 'muvipro' ),
					$cats_list
				);
			}
			
			if ( $tags_list ) {
				printf( '<span class="tags-links">%1$s %2$s</span>',
					_x( 'Tagged', 'Used before tag names.', 'muvipro' ),
					$tags_list
				);
			}
			
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'muvipro' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
			
			// Post navigation
			the_post_navigation(array(
				'prev_text'                  => __( '<span>Previous post</span> %title', 'muvipro' ),
				'next_text'                  => __( '<span>Next post</span> %title', 'muvipro' )
			)); 
		?>
		</footer><!-- .entry-footer -->
		
	</div><!-- .gmr-box-content -->
	
	<?php 
		// Authorbox this function from action in idmuvi core plugin
		do_action( 'idmuvi_core_author_box' ); 
	?>

</article><!-- #post-## -->