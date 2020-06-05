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
$post_id = $post->ID; // current post ID
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?> <?php echo muvipro_itemtype_schema( 'CreativeWork' ); ?>>

	<div class="gmr-box-content gmr-single">
		<header class="entry-header">
			<?php gmr_posted_on(); ?>
		</header><!-- .entry-header -->
		
		<?php
			/* 
			 * Called player.php for custom movie player.
			 * Display content if have no embed code via player metaboxes
			 */ 
			$player_style = get_theme_mod( 'gmr_player_style', 'ajax' );
			if ( $player_style == 'subpage' ) {
				get_template_part( 'template-parts/player', '2' );
			} else {
				get_template_part( 'template-parts/player' );
			}
			
			echo '<div class="gmr-movie-data clearfix">';
				if ( $thumbnail === 0 ) {
					if ( has_post_thumbnail() ) {
						echo '<figure class="pull-left">';
							the_post_thumbnail( 'thumbnail', array( 'itemprop'=>'image' ) );
							
							if ( $caption = get_post( get_post_thumbnail_id() )->post_excerpt ) :
								echo '<figcaption class="wp-caption-text hidden">' . $caption . '</figcaption>';
							endif;
						echo '</figure>';
					} else {
						// do_action( 'funct', $size, $link, $classes = '', $echo = true );
						do_action( 'idmuvi_core_get_images', 'thumbnail', false, 'pull-left' );
					}
				}
				
				// Check if the custom field has a value.
				echo '<div class="gmr-movie-data-top">';
				
					the_title( '<h1 class="entry-title" ' . muvipro_itemprop_schema( 'name' ) . '>', '</h1>' );
					
					echo '<div class="gmr-movie-innermeta">';
						
						// Serie link
						$tmdbid = get_post_meta( $post->ID, 'IDMUVICORE_tmdbID', true );
						if ( ! empty( $tmdbid ) ) {
							
							$args = array(
								'post_type'     => 'tv',
								'posts_per_page' => 1,
								'meta_query' => array(
									array(
										'key'     => 'IDMUVICORE_tmdbID',
										'value'   => $tmdbid,
										'compare' => '=',
									)
								),
							);
								
							$posts = get_posts( $args );
							// get IDs of posts retrieved from get_posts
							$ids = array();
							foreach ( $posts as $thepost ) {
								$ids[] = $thepost->ID;
							}
							// get and echo previous and next post in the same category
							$thisindex = array_search( $post_id, $ids );
							$episode_id = isset($ids[ $thisindex ]) ? $ids[ $thisindex ] : null;
						
							if ( ! empty( $episode_id ) ) {
								echo '<span class="gmr-all-episode">';
								echo '<a href="' . get_permalink( $episode_id )  . '" class="gmr-all-serie">' . __( 'View All Episodes','muvipro' ) . '</a>';
								echo '</span>';
							}
						}
					echo '</div>';
					
					echo '<div class="gmr-movie-innermeta">';	
					
						// Quality
						if( !is_wp_error( get_the_term_list( $post->ID, 'muviquality' ) ) ) {
							$termlist = get_the_term_list( $post->ID, 'muviquality' );
							if ( !empty ($termlist) ) {
								echo '<span class="gmr-movie-quality">';
								echo __( 'Quality: ', 'muvipro' );
								echo get_the_term_list( $post->ID, 'muviquality', '', ', ', '' );
								echo '</span>';
							}
						}
						
						// View from view plugin
						if(function_exists('the_views')) { 
							echo '<span class="gmr-movie-view">';
								echo __( 'View: ', 'muvipro' );
								the_views(); 
							echo '</span>';
						}
					echo '</div>';
					

				echo '</div>';
			echo '</div>';
			
			// Rating
			$rating = get_post_meta( $post->ID, 'IDMUVICORE_tmdbRating', true );
			$user = get_post_meta( $post->ID, 'IDMUVICORE_tmdbVotes', true );
			// Check if the custom field has a value.
			if ( ! empty( $rating ) ) {
				$display = number_format_i18n( $rating, 1 );

				echo '<div class="clearfix gmr-rating" itemscope="itemscope" itemprop="aggregateRating" itemtype="//schema.org/AggregateRating">';
					echo '<meta itemprop="worstRating" content="1">';
					echo '<meta itemprop="bestRating" content="10">';
					echo '<div class="gmr-rating-content">';
						echo '<div class="gmr-rating-bar">';
						echo '<span style="width:'.($display*10).'%"></span>';
						echo '</div>';
						if ( ! empty( $user ) ) {
							echo '<div class="gmr-meta-rating">';
							echo '<span itemprop="ratingCount">' . $user . '</span>';
							echo __(' votes, ', 'muvipro');
							echo __(' average ', 'muvipro') . '<span itemprop="ratingValue">' . $display . '</span> '.__('out of 10', 'muvipro');
							echo '</div>';
						}
					echo '</div>';
					
				echo '</div>';
			}	
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
				
				// Prev and next Navigation
				do_action( 'gmr_get_prevnext_episode' );
			?>
		</footer><!-- .entry-footer -->
		
	</div><!-- .gmr-box-content -->

</article><!-- #post-## -->