<?php
/*
YARPP Template: Muvipro Template
Description: Only support for muvipro
Author: Gian Mokhammad R
*/ 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<?php if ( have_posts() ) : ?>
	<div class="gmr-grid muvipro yarpp-muvipro">
		<h3 class="widget-title gmr-related-title"><?php echo __( 'Related Movies','muvipro' ); ?></h3>
		<div class="row grid-container">
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="col-md-20 item" <?php echo muvipro_itemtype_schema( 'Movie' ); ?>>
				<div class="gmr-box-content gmr-box-archive text-center">
					<div class="content-thumbnail text-center">
						<?php
							// Add thumnail
							if ( has_post_thumbnail() ) :
									echo '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">';
										the_post_thumbnail( 'medium', array( 'itemprop'=>'image' ) );
									echo '</a>';
							else :
								// do_action( 'funct', $size, $link, $classes = '', $echo = true );
								do_action( 'idmuvi_core_get_images', 'medium', true, '' );
						endif; // endif; has_post_thumbnail()
						?>
						<?php
							$rating = get_post_meta( $post->ID, 'IDMUVICORE_tmdbRating', true ); 
							if ( ! empty( $rating ) ) {
								echo '<div class="gmr-rating-item">' . __( 'Rating: ','muvipro' ) . $rating . '</div>';
							}
							$duration = get_post_meta( $post->ID, 'IDMUVICORE_Runtime', true ); 
							if ( ! empty( $duration ) ) {
								echo '<div class="gmr-duration-item" property="duration">' . $duration . __( ' min','muvipro' ) . '</div>';
							}
						
							if( !is_wp_error( get_the_term_list( $post->ID, 'muviquality' ) ) ) {
								$muviqu = get_the_term_list( $post->ID, 'muviquality' );
								if ( !empty ( $muviqu ) ) {
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
						
						?>
					</div>
					
					<div class="item-article">
						<h2 class="entry-title" <?php echo muvipro_itemprop_schema( 'headline' ); ?>>
							<a href="<?php the_permalink(); ?>" <?php echo muvipro_itemprop_schema( 'url' ); ?> title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h2>
						<div class="gmr-movie-on">
							<?php 
							
								$categories_list = get_the_category_list( esc_html__( ', ','muvipro' ) );
								if ( $categories_list ):
									echo $categories_list;
								endif; 
							
								if( !is_wp_error( get_the_term_list( $post->ID, 'muvicountry' ) ) ) {
									$muvico = get_the_term_list( $post->ID, 'muvicountry' );
									if ( !empty ( $muvico ) ) {
										echo ', ';
										echo get_the_term_list( $post->ID, 'muvicountry', '<span itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">', '</span>, <span itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">', '</span>' );
									}
								}
							?>
						</div>
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
								$muvidir = get_the_term_list( $post->ID, 'muvidirector' );
								if ( !empty ( $muvidir ) ) {
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
								echo '<a href="https://www.youtube.com/watch?v=' . $trailer . '" class="button gmr-trailer-popup" title="' . the_title_attribute( array( 'before' => __( 'Trailer for ','muvipro' ), 'after' => '', 'echo' => false ) ) . '" rel="nofollow"><span class="icon_film" aria-hidden="true"></span><span class="text-trailer">' . __( 'Trailer','muvipro' ) . '</span></a>';
								echo '</div>';
							}
							echo '<div class="gmr-watch-movie">';
								echo '<a href="' . get_permalink() . '" class="button" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','muvipro' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">' . __( 'Watch','muvipro' ) . '</a>';
							echo '</div>';						
						?>
					</div><!-- .item-article -->
					
				</div><!-- .gmr-box-content -->
			</article><!-- #post-## -->
		<?php endwhile; ?>
		</div>
	</div>
<?php endif;