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
	
// layout masonry base sidebar options
if ( $sidebar_layout == 'fullwidth' ) {
	$classes = array(
		'col-md-2',
		'item'
	);
} else {
	$classes = array(
		'col-md-20',
		'item'
	);
}
	
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?> <?php echo muvipro_itemtype_schema( 'Movie' ); ?>>
	
	<div class="gmr-box-content gmr-box-archive text-center">
		<?php
			// Add thumnail
			echo '<div class="content-thumbnail text-center">';
				if ( has_post_thumbnail() ) :
						echo '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">';
							if ( $sidebar_layout == 'fullwidth' ) {
								the_post_thumbnail( 'large', array( 'itemprop'=>'image' ) );
							} else {
								the_post_thumbnail( 'medium', array( 'itemprop'=>'image' ) );
							}
						echo '</a>';
				else :
					if ( $sidebar_layout == 'fullwidth' ) {
						// do_action( 'funct', $size, $link, $classes = '', $echo = true );
						do_action( 'idmuvi_core_get_images', 'large', true );
					} else {
						// do_action( 'funct', $size, $link, $classes = '', $echo = true );
						do_action( 'idmuvi_core_get_images', 'medium', true );
					}
				endif; // endif; has_post_thumbnail()
				$rating = get_post_meta( $post->ID, 'IDMUVICORE_tmdbRating', true ); 
				if ( ! empty( $rating ) ) {
					echo '<div class="gmr-rating-item">' . __( 'Rating: ','muvipro' ) . $rating . '</div>';
				}
				$duration = get_post_meta( $post->ID, 'IDMUVICORE_Runtime', true ); 
				if ( ! empty( $duration ) ) {
					echo '<div class="gmr-duration-item" property="duration">' . $duration . __( ' min','muvipro' ) . '</div>';
				}
				if ( is_sticky() ) {
					echo '<div class="kbd-sticky">' . __( 'Sticky', 'muvipro' ) . '</div>';
				}
				if( !is_wp_error( get_the_term_list( $post->ID, 'muviquality' ) ) ) {
					$termlist = get_the_term_list( $post->ID, 'muviquality' );
					if ( !empty ($termlist) ) {
						echo '<div class="gmr-quality-item">';
						echo get_the_term_list( $post->ID, 'muviquality', '', ', ', '' );
						echo '</div>';
					}
				}
				if ( 'tv' == get_post_type() ) {
					echo '<div class="gmr-posttype-item">';
					echo __( 'TV Show','muvipro' );
					echo '</div>';
				}
			echo '</div>';
		?>
	
		<div class="item-article">
			<header class="entry-header">
				<h2 class="entry-title" <?php echo muvipro_itemprop_schema( 'headline' ); ?>>
					<a href="<?php the_permalink(); ?>" <?php echo muvipro_itemprop_schema( 'url' ); ?> title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<?php gmr_movie_on(); ?>
				<?php
					$release = get_post_meta( $post->ID, 'IDMUVICORE_Released', true );
					// Check if the custom field has a value.
					if ( ! empty( $release ) ) {
						if ( gmr_checkIsAValidDate($release) == true ) {
							$datetime = new DateTime( $release );
							echo '<span class="screen-reader-text"><time itemprop="dateCreated" datetime="'.$datetime->format('c').'">'.$release.'</time></span>';
						}
					}
					if( !is_wp_error( get_the_term_list( $post->ID, 'muvidirector' ) ) ) {
						$termlist = get_the_term_list( $post->ID, 'muvidirector' );
						if ( !empty ($termlist) ) {
							echo '<span class="screen-reader-text">';
							echo get_the_term_list( $post->ID, 'muvidirector', '<span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>, <span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>' );
							echo '</span>';
						}
					}
				?>
				<?php 
					$trailer = get_post_meta( $post->ID, 'IDMUVICORE_Trailer', true );
					// Check if the custom field has a value.
					if ( ! empty( $trailer ) ) {
						echo '<div class="gmr-popup-button">';
						echo '<a href="https://www.youtube.com/watch?v=' . $trailer . '" class="button gmr-trailer-popup" title="' . the_title_attribute( array( 'before' => __( 'Trailer for ','muvipro' ), 'after' => '', 'echo' => 0 ) ) . '" rel="nofollow"><span class="icon_film" aria-hidden="true"></span><span class="text-trailer">' . __( 'Trailer','muvipro' ) . '</span></a>';
						echo '</div>';
					}
				?>
				<div class="gmr-watch-movie">
					<a href="<?php the_permalink(); ?>" class="button" <?php echo muvipro_itemprop_schema( 'url' ); ?> title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '' ) ); ?>" rel="bookmark"><?php echo __( 'Watch','muvipro' ); ?></a>
				</div>
			</header><!-- .entry-header -->
		</div><!-- .item-article -->
		
	</div><!-- .gmr-box-content -->

</article><!-- #post-## -->