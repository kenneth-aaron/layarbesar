<?php
/*
 * Related Post Features
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package Idmuvi Core
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'idmuvi_core_checkIsAValidDate' ) ) :
	/**
	 * check if date true or false
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	function idmuvi_core_checkIsAValidDate($myDateString){
		return (bool)strtotime($myDateString);
	}
endif;
 
if ( !function_exists('idmuvi_related_post') ) {
	/**
	 * Adding the related post to the end of your single post
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function idmuvi_related_post() {
		global $post;
		$orig_post = $post;
		
		$idmuv_relpost = get_option( 'idmuv_relpost' );
		
		if ( isset ( $idmuv_relpost['relpost_number'] ) && $idmuv_relpost['relpost_number'] != '' ) {
			// option, section, default
			$number = intval( $idmuv_relpost['relpost_number'] );
		} else {
			$number = 5;
		}
		
		if ( isset ( $idmuv_relpost['relpost_taxonomy'] ) && $idmuv_relpost['relpost_taxonomy'] == 'tags' ) {
			$tags = wp_get_post_tags($post->ID);
			if ( $tags ) {
				$tag_ids = array();
				foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
				$args = array(
					'post_type' => array( 'post','tv' ),
					'tag__in' => $tag_ids,
					'post__not_in' => array($post->ID),
					'posts_per_page'=> $number,
					'ignore_sticky_posts'=>1,
					// make it fast withour update term cache and cache results
					// https://thomasgriffin.io/optimize-wordpress-queries/
					'no_found_rows'       => true,
					'update_post_term_cache' => false,
					'update_post_meta_cache' => false
				);
				
			}
			
		} else {
			$categories = get_the_category($post->ID);
			if ( $categories ) {
				$category_ids = array();
				foreach( $categories as $individual_category ) $category_ids[] = $individual_category->term_id;
				$args = array(
					'post_type' => array( 'post','tv' ),
					'category__in' => $category_ids,
					'post__not_in' => array($post->ID),
					'posts_per_page'=> $number,
					'ignore_sticky_posts'=>1,
					// make it fast withour update term cache and cache results
					// https://thomasgriffin.io/optimize-wordpress-queries/
					'no_found_rows'       => true,
					'update_post_term_cache' => false,
					'update_post_meta_cache' => false
				);
			}
			
		}
		
		if ( !isset( $args ) ) $args = '';
		
		$idmuvi_query = new WP_Query($args);
			
		$content = '';
		$i = 1;
		if( $idmuvi_query->have_posts() ) {
			
			$content .= '<div class="gmr-grid idmuvi-core">';
			
			$content .= '<h3 class="widget-title gmr-related-title">' . __( 'Related Movies','idmuvi-core' ) . '</h3>';
			
			$content .= '<div class="row grid-container">';
			
			while ( $idmuvi_query->have_posts() ) : $idmuvi_query->the_post();
			
				$content .= '<article class="item col-md-20" itemscope="itemscope" itemtype="http://schema.org/Movie">';
					$content .= '<div class="gmr-box-content gmr-box-archive text-center">';
						$content .= '<div class="content-thumbnail text-center">';
						
							if ( has_post_thumbnail() ) {
								$content .= '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','idmuvi-core' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">';
								$content .= get_the_post_thumbnail( $post->ID, 'medium', array( 'itemprop'=>'image' ) );
								$content .= '</a>';
								
							} else {
								//function idmuvi_core_get_images( $size = 'full', $link = false, $classes = '', $echo = true ) {
								$content .= idmuvi_core_get_images( 'medium', true, '', false );
								
							}
							
							$rating = get_post_meta( $post->ID, 'IDMUVICORE_tmdbRating', true ); 
							if ( ! empty( $rating ) ) {
								$content .= '<div class="gmr-rating-item">' . __( 'Rating: ','idmuvi-core' ) . $rating . '</div>';
							}
							$duration = get_post_meta( $post->ID, 'IDMUVICORE_Runtime', true ); 
							if ( ! empty( $duration ) ) {
								$content .= '<div class="gmr-duration-item" property="duration">' . $duration . __( ' min','idmuvi-core' ) . '</div>';
							}
						
							if( !is_wp_error( get_the_term_list( $post->ID, 'muviquality' ) ) ) {
								$muviqu = get_the_term_list( $post->ID, 'muviquality' );
								if ( !empty ( $muviqu ) ) {
									$content .= '<div class="gmr-quality-item">';
									$content .= get_the_term_list( $post->ID, 'muviquality', '', ', ', '' );
									$content .= '</div>';
								}
							}
							
							if ( 'tv' == get_post_type() ) {
								$content .= '<div class="gmr-posttype-item">';
								$content .= __( 'TV Show','muvipro' );
								$content .= '</div>';
							}
						
						$content .= '</div>';
					
						$content .= '<div class="item-article">';
								$content .= '<h2 class="entry-title" itemprop="headline">';
								$content .= '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','idmuvi-core' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">' . get_the_title() . '</a>';
								$content .= '</h2>';
								$content .= '<div class="gmr-movie-on">';
								$categories_list = get_the_category_list( esc_html__( ', ','idmuvi-core' ) );
								if ( $categories_list ):
									$content .= $categories_list;
								endif; 
								if( !is_wp_error( get_the_term_list( $post->ID, 'muvicountry' ) ) ) {
									$muvico = get_the_term_list( $post->ID, 'muvicountry' );
									if ( !empty ( $muvico ) ) {
										$content .= ', ';
										$content .= get_the_term_list( $post->ID, 'muvicountry', '<span itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">', '</span>, <span itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">', '</span>' );
									}
								}
								$content .= '</div>';
								

								$release = get_post_meta( $post->ID, 'IDMUVICORE_Released', true );
								// Check if the custom field has a value.
								if ( ! empty( $release ) ) {
									if ( idmuvi_core_checkIsAValidDate($release) == true ) {
										$datetime = new DateTime( $release );
										$content .= '<span class="screen-reader-text"><time itemprop="dateCreated" datetime="'.$datetime->format('c').'">'.$release.'</time></span>';	
									}
								}
								if( !is_wp_error( get_the_term_list( $post->ID, 'muvidirector' ) ) ) {
									$muvidir = get_the_term_list( $post->ID, 'muvidirector' );
									if ( !empty ( $muvidir ) ) {
										$content .= '<span class="screen-reader-text">';
										$content .= get_the_term_list( $post->ID, 'muvidirector', '<span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>, <span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>' );
										$content .= '</span>';
									}
								}
								
								$trailer = get_post_meta( $post->ID, 'IDMUVICORE_Trailer', true );
								// Check if the custom field has a value.
								if ( ! empty( $trailer ) ) {
									$content .= '<div class="gmr-popup-button">';
									$content .= '<a href="https://www.youtube.com/watch?v=' . $trailer . '" class="button gmr-trailer-popup" title="' . the_title_attribute( array( 'before' => __( 'Trailer for ','idmuvi-core' ), 'after' => '', 'echo' => false ) ) . '" rel="nofollow"><span class="icon_film" aria-hidden="true"></span><span class="text-trailer">' . __( 'Trailer','idmuvi-core' ) . '</span></a>';
									$content .= '</div>';
								}
								$content .= '<div class="gmr-watch-movie">';
									$content .= '<a href="' . get_permalink() . '" class="button" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','idmuvi-core' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">' . __( 'Watch','idmuvi-core' ) . '</a>';
								$content .= '</div>';
						$content .= '</div>';
						
					$content .= '</div><!-- .gmr-box-content -->';
					
				$content .= '</article>';
				if($i%5 == 0) :
					$content .= '<div class="clearfix"></div>';
				endif;
			
			$i++;
			endwhile;
			
			$content .= '</div>';
			
			$content .= '</div>';
		} // if have posts
		$post = $orig_post; 
		wp_reset_postdata();
		return $content;
	}
}

if ( !function_exists( 'idmuvi_core_related_post' ) ) :
	function idmuvi_core_related_post() {
		if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
			$related = '<div class="salespro-core gmr-box-content">';
				$related .= do_shortcode( '[jetpack-related-posts]' );
			$related .= '</div>';
		} else {
			$related = idmuvi_related_post();
		}
		return $related;
	}
endif; // endif idmuvi_core_related_post

if ( !function_exists( 'idmuvi_core_add_related_the_content' ) ) :
	/**
	 * Insert content after box content single
	 *
	 * @since 1.0.0
	 * @link https://jetpack.com/support/related-posts/customize-related-posts/#delete
	 * @return void
	 */
	function idmuvi_core_add_related_the_content( $content ) {
		if( is_single() && in_the_loop() ) {
			$idmuv_relpost = get_option( 'idmuv_relpost' );
			if ( isset ( $idmuv_relpost['enable_relpost'] ) && $idmuv_relpost['enable_relpost'] != '' ) {
				// option, section, default
				$option = $idmuv_relpost['enable_relpost'];
			} else {
				$option = 'on';
			}
			
			if ( $option == 'on' ) :
				$content = $content . idmuvi_core_related_post();
			else :
				$content = $content;
			endif;
		}
		return $content;
	}
endif; // endif idmuvi_core_add_related_the_content
add_filter( 'the_content', 'idmuvi_core_add_related_the_content', 40 );