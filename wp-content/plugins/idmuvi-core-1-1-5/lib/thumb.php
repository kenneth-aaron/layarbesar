<?php
/*
 * Thumbnail solution, display from various resource
 *
 * Author: Gian MR - http://www.gianmr.com
 * 
 * @since 1.0.0
 * @package Idmuvi Core
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !function_exists('idmuvi_core_get_attachment_id') ) :
	/**
	 * Get an attachment ID given a URL.
	 *
	 * @link https://wpscholar.com/blog/get-attachment-id-from-wp-image-url/
	 * 
	 * @param string $url
	 *
	 * @since 1.0.0
	 * @return int Attachment ID on success, 0 on failure
	 */
	function idmuvi_core_get_attachment_id( $url ) {
		$attachment_id = 0;
		$dir = wp_upload_dir();
		if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
			$file = basename( $url );
			$query_args = array(
				'post_type'   => 'attachment',
				'post_status' => 'inherit',
				'fields'      => 'ids',
				'meta_query'  => array(
					array(
						'value'   => $file,
						'compare' => 'LIKE',
						'key'     => '_wp_attachment_metadata',
					),
				)
			);
			$query = new WP_Query( $query_args );
			if ( $query->have_posts() ) {
				foreach ( $query->posts as $post_id ) {
					$meta = wp_get_attachment_metadata( $post_id );
					$original_file       = basename( $meta['file'] );
					$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
					if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
						$attachment_id = $post_id;
						break;
					}
				}
			}
		}
		return $attachment_id;
	}
endif;

if ( !function_exists('idmuvi_core_get_images') ) :
	/**
	 * Get image from various source.
	 * 
	 * @param string $size
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_get_images( $size = 'full', $link = false, $classes = '', $echo = true ) {
		global $post;
		/* Get the post content. */
		$post_content = get_post_field( 'post_content', get_the_ID() );
		/* Get image from movie meta */
		$poster = get_post_meta( $post->ID, 'IDMUVICORE_Poster', true );
		// Search the post's content for the <img /> tag and get its URL.
		preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $post_content, $matches );
		// No post thumbnail, try attachments instead.
		$images = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'post_parent'    => $post->ID,
				'posts_per_page' => 1, /* Save memory, only need one */
			)
		);
		$content = '';
		if ( isset( $matches ) && !empty( $matches[1][0] ) ) {
			$url = idmuvi_core_get_attachment_id( $matches[1][0] );
			if ( !empty ( $url ) ) {
				if ( !empty ( $classes ) ) {
					$content .= '<div class="'.$classes.'">';
				}
					if ( $link ) {
						$content .= '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','idmuvi-core' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">';
					}
						$content .= wp_get_attachment_image( idmuvi_core_get_attachment_id($matches[1][0] ), $size, '', array( 'itemprop'=>'image' ) );
					if ( $link ) {
						$content .= '</a>';
					}
				if ( !empty ( $classes ) ) {
					$content .= '</div>';
				}
			} else {
				if ( !empty ( $classes ) ) {
					$content .= '<div class="'.$classes.'">';
				}
					if ( $link ) {
						$content .= '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','idmuvi-core' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">';
					}
						$content .= '<img src="'. $matches[1][0] .'" alt="' . get_the_title() . '" itemprop="image" />';
					if ( $link ) {
						$content .= '</a>';
					}
				if ( !empty ( $classes ) ) {
					$content .= '</div>';
				}
			}
		} elseif ( $images ) {
			if ( !empty ( $classes ) ) {
				$content .= '<div class="'.$classes.'">';
			}
				if ( $link ) {
					$content .= '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','idmuvi-core' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">';
				}
					$content .= wp_get_attachment_image( $images[0]->ID, $size, '', array( 'itemprop'=>'image' ) );
				if ( $link ) {
					$content .= '</a>';
				}
			if ( !empty ( $classes ) ) {
				$content .= '</div>';
			}
		} elseif ( ! empty( $poster ) ) {
			if ( !empty ( $classes ) ) {
				$content .= '<div class="'.$classes.'">';
			}
				if ( $link ) {
					$content .= '<a href="' . get_permalink() . '" itemprop="url" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ','idmuvi-core' ), 'after' => '', 'echo' => false ) ) . '" rel="bookmark">';
				}
					$content .= '<img src="'. $poster .'" alt="' . get_the_title() . '" itemprop="image" />';
				if ( $link ) {
					$content .= '</a>';
				}
				
			if ( !empty ( $classes ) ) {
				$content .= '</div>';
			}
		}
		if ( $echo ) {
			echo $content;
		} else {
			return $content;
		}
	}
endif;
add_action( 'idmuvi_core_get_images', 'idmuvi_core_get_images', 20, 3 );

if ( !function_exists( 'idmuvi_core_get_images_addclass' ) ) :
	/**
	 * add class to post_class() when get image from various source.
	 * 
	 * @param string $classes
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function idmuvi_core_get_images_addclass( $classes ) {
		global $post;
		/* Get the post content. */
		$post_content = get_post_field( 'post_content', get_the_ID() );
		/* Get image from movie meta */
		$poster = get_post_meta( $post->ID, 'IDMUVICORE_Poster', true );
		// Search the post's content for the <img /> tag and get its URL.
		preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $post_content, $matches );
		// No post thumbnail, try attachments instead.
		$images = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'post_parent'    => $post->ID,
				'posts_per_page' => 1, /* Save memory, only need one */
			)
		);
		if ( isset( $matches ) && !empty( $matches[1][0] ) ) {
			$url = idmuvi_core_get_attachment_id( $matches[1][0] );
			if ( !empty ( $url ) ) {
				$classes[] = 'has-post-thumbnail';
			} else {
				$classes[] = 'has-post-thumbnail';
			}
		} elseif ( ! empty( $poster ) ) {
			$classes[] = 'has-post-thumbnail';
		} elseif ( $images ) {
			$classes[] = 'has-post-thumbnail';
		}
		return $classes;
	}
endif;
add_filter( 'post_class', 'idmuvi_core_get_images_addclass' );