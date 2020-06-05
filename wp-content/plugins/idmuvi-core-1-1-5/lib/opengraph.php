<?php
/*
 * Solution for opengraph
 *
 * @link http://wordpress.org/plugins/opengraph
 * 
 * @since 1.0.0
 * @package Idmuvi Core
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !function_exists( 'idmuvi_opengraph_doctype' ) ) {
	/**
	 * Add Open Graph XML prefix to <html> element.
	 *
	 * @uses apply_filters calls 'idmuvi_opengraph_prefixes' filter on RDFa prefix array
	 */
	function idmuvi_opengraph_doctype( $output ) {
		$prefixes = array(
			'og' => 'http://ogp.me/ns#'
		);
		$prefixes = apply_filters('idmuvi_opengraph_prefixes', $prefixes);

		$prefix_str = '';
		foreach ( $prefixes as $k => $v ) {
			$prefix_str .= $k . ': ' . $v . ' ';
		}
		$prefix_str = trim($prefix_str);

		if ( preg_match( '/(prefix\s*=\s*[\"|\'])/i', $output ) ) {
			$output = preg_replace('/(prefix\s*=\s*[\"|\'])/i', '${1}' . $prefix_str, $output);
		} else {
			$output .= ' prefix="' . $prefix_str . '"';
		}
		return $output;
	}
}
add_filter('language_attributes', 'idmuvi_opengraph_doctype');

if( !function_exists( 'idmuvi_opengraph_additional_prefixes' ) ) {
	/**
	 * Add additional prefix namespaces that are supported by the opengraph plugin.
	 */
	function idmuvi_opengraph_additional_prefixes( $prefixes ) {
		if ( is_author() ) {
			$prefixes['profile'] = 'http://ogp.me/ns/profile#';
		}
		if ( is_singular() ) {
			$prefixes['article'] = 'http://ogp.me/ns/article#';
		}
		return $prefixes;
	}
}

if( !function_exists( 'idmuvi_twitter_opengraph_metadata' ) ) {
	/*
	 * add twitter card meta data
	 */
	function idmuvi_twitter_opengraph_metadata() {
		
		$metadata = array();

		// defualt properties defined at http://ogp.me/
		$properties = array(
			// required
			'title', 'card', 'image', 'url',

			// optional
			'description', 'site', 'creator',
		);

		foreach ( $properties as $property ) {
			$filter = 'twitter_opengraph_' . $property;
			$metadata["twitter:$property"] = apply_filters($filter, '');
		}
		
		return apply_filters('idmuvi_twitter_opengraph_metadata', $metadata);
	}
}

if( !function_exists( 'idmuvi_twitter_opengraph_creator' ) ) {
	/**
	 * Add twitter creator meta data
	 */
	function idmuvi_twitter_opengraph_creator( $metadata ) {
		
		$idmuv_social = get_option( 'idmuv_social' );
		
		if ( isset ( $idmuv_social['social_username_twitter'] ) && $idmuv_social['social_username_twitter'] != '' ) {
			// option, section, default
			$option = $idmuv_social['social_username_twitter'];
		} else {
			$option = '';
		}
		
		if ( isset ( $idmuv_social['enable_author_username_twitter'] ) && $idmuv_social['enable_author_username_twitter'] != '' ) {
			// option, section, default
			$enable = $idmuv_social['enable_author_username_twitter'];
		} else {
			$enable = 'on';
		}
		
		if ( $option != '' ) {
			$metadata['twitter:site'] = '@'. $option;
			if ( $enable == 'on' ) {
				$metadata['twitter:creator'] = '@'. $option;
			}
		}

	  return $metadata;
	}
}

if( !function_exists( 'idmuvi_opengraph_metadata' ) ) {
	/**
	 * Get the Open Graph metadata for the current page.
	 *
	 * @uses apply_filters() Calls 'opengraph_{$name}' for each property name
	 * @uses apply_filters() Calls 'idmuvi_opengraph_metadata' before returning metadata array
	 */
	function idmuvi_opengraph_metadata() {
		$metadata = array();

		// defualt properties defined at http://ogp.me/
		$properties = array(
			// required
			'title', 'type', 'url',

			// optional
			'audio', 'description', 'determiner', 'locale', 'site_name', 'video',
		);

		foreach ( $properties as $property ) {
			$filter = 'opengraph_' . $property;
			$metadata["og:$property"] = apply_filters($filter, '');
		}

		return apply_filters('idmuvi_opengraph_metadata', $metadata);
	}
}

if( !function_exists( 'idmuvi_opengraph_default_title' ) ) {
	/**
	 * Default title property, using the page title.
	 */
	function idmuvi_opengraph_default_title( $title ) {
		if ( empty($title) ) {
			if ( is_singular() ) {
				$title = get_the_title( get_queried_object_id() );
			} else if ( is_author() ) {
				$author = get_queried_object();
				$title = $author->display_name;
			} else if ( is_category() && single_cat_title( '', false ) ) {
				$title = single_cat_title( '', false );
			} else if ( is_tag() && single_tag_title( '', false ) ) {
				$title = single_tag_title( '', false );
			} else if ( is_archive() && get_post_format()) {
				$title = get_post_format_string( get_post_format() );
			} else if ( is_archive() && function_exists ("get_the_archive_title") && get_the_archive_title() ) { // new in version 4.1 to get all other archive titles
				$title = get_the_archive_title();
			}
		}
	  return $title;
	}
}

if( !function_exists( 'idmuvi_opengraph_default_type' ) ) {
	/**
	 * Default type property.
	 */
	function idmuvi_opengraph_default_type( $type ) {
		if ( is_front_page() ) {
			$type = 'website';
		} else if ( is_home() ) {
			$type = 'blog';
		} else {
			$type = 'article';
		}
		return $type;
	}
}

if( !function_exists( 'idmuvi_opengraph_default_image' ) ) {
	/**
	 * Default image property, using the post-thumbnail and any attached images.
	 */
	function idmuvi_opengraph_default_image( $image ) {
		if ( is_singular() ) {
			global $post;
			
			$idmuv_other = get_option( 'idmuv_other' );
			
			if ( isset ( $idmuv_other['other_remove_thumbphp'] ) && $idmuv_other['other_remove_thumbphp'] != '' ) {
				// option, section, default
				$option = $idmuv_other['other_remove_thumbphp'];
			} else {
				$option = 'off';
			}

			// Auto thumbnail, if you no need and your resource high, please disable it.
			if ( $option != 'on' ) {
			
				/* Get the post content. */
				$post_content = get_post_field( 'post_content', get_the_ID() );
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
				if ( isset( $post->post_type ) && post_type_supports( $post->post_type, 'thumbnail' ) && has_post_thumbnail() ) {
					@list( $src, $width, $height ) = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					if ( ! empty( $src ) ) {
						$image['og:image'] = $src;
						if ( ! empty( $width ) ) {
							$image['og:image:width'] = intval( $width );
						}
						if ( ! empty( $height ) ) {
							$image['og:image:height'] = intval( $height );
						}
					}
				} elseif ( isset( $matches ) && !empty( $matches[1][0] ) ) {
					/* 
					 * function idmuvi_core_get_attachment_id
					 * get attachment id from first post
					 * @see inc/thumb.php
					 */
					 
					$url = idmuvi_core_get_attachment_id( $matches[1][0] );
					if ( !empty ( $url ) ) {
						@list( $src, $width, $height ) = wp_get_attachment_image_src( idmuvi_core_get_attachment_id($matches[1][0] ), 'full' );
						if ( ! empty( $src ) ) {
							$image['og:image'] = $src;
							if ( ! empty( $width ) ) {
								$image['og:image:width'] = intval( $width );
							}
							if ( ! empty( $height ) ) {
								$image['og:image:height'] = intval( $height );
							}
						}
					} else {
						$src = $matches[1][0];
						if ( ! empty( $src ) ) {
							$image['og:image'] = $src;
						}
					}
				} elseif ( $images ) {
					@list( $src, $width, $height ) = wp_get_attachment_image_src( $images[0]->ID, 'full' );
					if ( ! empty( $src ) ) {
						$image['og:image'] = $src;
						if ( ! empty( $width ) ) {
							$image['og:image:width'] = intval( $width );
						}
						if ( ! empty( $height ) ) {
							$image['og:image:height'] = intval( $height );
						}
					}
				}
				
			} else {		
				if ( isset( $post->post_type ) && post_type_supports( $post->post_type, 'thumbnail' ) && has_post_thumbnail() ) {
					@list( $src, $width, $height ) = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					if ( ! empty( $src ) ) {
						$image['og:image'] = $src;
						if ( ! empty( $width ) ) {
							$image['og:image:width'] = intval( $width );
						}
						if ( ! empty( $height ) ) {
							$image['og:image:height'] = intval( $height );
						}
					}
				}
			}
		}
		return $image;
	}
}

if( !function_exists( 'idmuvi_twitter_opengraph_default_image' ) ) {
	/**
	 * Default image property, using the post-thumbnail and any attached images.
	 */
	function idmuvi_twitter_opengraph_default_image( $image ) {
		if ( is_singular() ) {
			global $post;
			
			$idmuv_other = get_option( 'idmuv_other' );
			if ( isset ( $idmuv_other['other_remove_thumbphp'] ) && $idmuv_other['other_remove_thumbphp'] != '' ) {
				// option, section, default
				$option = $idmuv_other['other_remove_thumbphp'];
			} else {
				$option = 'off';
			}

			// Auto thumbnail, if you no need and your resource high, please disable it.
			if ( $option != 'on' ) {
			
				/* Get the post content. */
				$post_content = get_post_field( 'post_content', get_the_ID() );
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
				if ( isset( $post->post_type ) && post_type_supports( $post->post_type, 'thumbnail' ) && has_post_thumbnail() ) {
					@list( $src, $width, $height ) = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					if ( ! empty( $src ) ) {
						$image['og:image'] = $src;
						if ( ! empty( $width ) ) {
							$image['og:image:width'] = intval( $width );
						}
						if ( ! empty( $height ) ) {
							$image['og:image:height'] = intval( $height );
						}
					}
				} elseif ( isset( $matches ) && !empty( $matches[1][0] ) ) {
					/* 
					 * function idmuvi_core_get_attachment_id
					 * get attachment id from first post
					 * @see inc/thumb.php
					 */
					 
					$url = idmuvi_core_get_attachment_id( $matches[1][0] );
					if ( !empty ( $url ) ) {
						@list( $src, $width, $height ) = wp_get_attachment_image_src( idmuvi_core_get_attachment_id($matches[1][0] ), 'full' );
						if ( ! empty( $src ) ) {
							$image['og:image'] = $src;
							if ( ! empty( $width ) ) {
								$image['og:image:width'] = intval( $width );
							}
							if ( ! empty( $height ) ) {
								$image['og:image:height'] = intval( $height );
							}
						}
					} else {
						$src = $matches[1][0];
						if ( ! empty( $src ) ) {
							$image['og:image'] = $src;
						}
					}
				} elseif ( $images ) {
					@list( $src, $width, $height ) = wp_get_attachment_image_src( $images[0]->ID, 'full' );
					if ( ! empty( $src ) ) {
						$image['og:image'] = $src;
						if ( ! empty( $width ) ) {
							$image['og:image:width'] = intval( $width );
						}
						if ( ! empty( $height ) ) {
							$image['og:image:height'] = intval( $height );
						}
					}
				}
				
			} else {
				if ( isset( $post->post_type ) && post_type_supports( $post->post_type, 'thumbnail' ) && has_post_thumbnail() ) {
					@list( $src, $width, $height ) = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					if ( ! empty( $src ) ) {
						$image['og:image'] = $src;
						if ( ! empty( $width ) ) {
							$image['og:image:width'] = intval( $width );
						}
						if ( ! empty( $height ) ) {
							$image['og:image:height'] = intval( $height );
						}
					}
				}
			}
		}
		return $image;
	}
}

if( !function_exists( 'idmuvi_opengraph_default_url' ) ) {
	/**
	 * Default url property, using the permalink for the page.
	 */
	function idmuvi_opengraph_default_url( $url ) {
		$url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		return $url;
	}
}

if( !function_exists( 'idmuvi_opengraph_default_sitename' ) ) {
	/**
	 * Default site_name property, using the bloginfo name.
	 */
	function idmuvi_opengraph_default_sitename( $name ) {
		if ( empty($name) ) {
			$name = get_bloginfo('name');
		}
		return $name;
	}
}

if( !function_exists( 'idmuvi_flatten' ) ) {
	/**
	 * Reduces content to flat text only.
	 * 
	 * @param string $content
	 * @return string
	 */
	function idmuvi_flatten( $content ) {
		// Add space between potential adjacent tags so the content
		// isn't glued together after applying wp_strip_all_tags().
		$content = str_replace( '><', '> <', $content );
		$content = wp_strip_all_tags( $content, true );
		$content = preg_replace('/\n+|\t+|\s+/', ' ', $content );
		$content = trim( $content );
		return $content;
	}
}

if( !function_exists( 'idmuvi_opengraph_default_description' ) ) {
	/**
	 * Default description property, using the excerpt or content for posts, or the
	 * bloginfo description.
	 */
	function idmuvi_opengraph_default_description( $description ) {
		if ( $description ) {
			return $description;
		}

		if ( is_singular() ) {
			$post = get_queried_object();
			if ( ! empty( $post->post_excerpt ) ) {
				$description = $post->post_excerpt;
			} else {
				$description = $post->post_content;
			}
		} else if ( is_author() ) {
			$id = get_queried_object_id();
			$description = get_user_meta( $id, 'description', true );
		} else if ( is_category() && category_description() ) {
			$description = category_description();
		} else if ( is_tag() && tag_description() ) {
			$description = tag_description();
		} else if ( is_archive() && function_exists( 'get_the_archive_description' ) && get_the_archive_description() ) { // new in version 4.1 to get all other archive descriptions
			$description = get_the_archive_description();
		} else {
			$description = get_bloginfo( 'description' );
		}

		// strip description to first 55 words.
		$description = strip_tags( strip_shortcodes( $description ) );
		$description = idmuvi_opengraph_trim_text( $description );

		return $description;
	}
}

if( !function_exists( 'idmuvi_twitter_default_card' ) ) {
	/**
	 * Default twitter-card type.
	 */
	function idmuvi_twitter_default_card( $card ) {
		$post_type = apply_filters('opengraph_type', null);
		if ( $post_type == 'article' ) {
			return "summary";
		}
		return '';
	}
}

if( !function_exists( 'idmuvi_opengraph_default_locale' ) ) {
	/**
	 * Default locale property, using the WordPress locale.
	 */
	function idmuvi_opengraph_default_locale( $locale ) {
		if ( empty($locale) ) {
			$locale = get_locale();
		}
		return $locale;
	}
}

if( !function_exists( 'idmuvi_opengraph_profile_metadata' ) ) {
	/**
	 * Include profile metadata for author pages.
	 */
	function idmuvi_opengraph_profile_metadata( $metadata ) {
		if ( is_author() ) {
			$id = get_queried_object_id();
			$metadata['profile:first_name'] = get_the_author_meta('first_name', $id);
			$metadata['profile:last_name'] = get_the_author_meta('last_name', $id);
			$metadata['profile:username'] = get_the_author_meta('nicename', $id);
		}
		return $metadata;
	}
}

if( !function_exists( 'idmuvi_opengraph_article_metadata' ) ) {
	/**
	 * Include profile metadata for author pages.
	 *
	 * @link http://ogp.me/#type_article
	 */
	function idmuvi_opengraph_article_metadata( $metadata ) {
		if ( is_singular() ) {
			$post = get_queried_object();

			$tags = wp_get_post_tags($post->ID);

			// check if page/post has tags
			if ( $tags ) {
				foreach ( $tags as $tag ) {
					$metadata['article:tag'][] = $tag->name;
				}
			}

			$metadata['article:published_time'] = date( 'c', strtotime($post->post_date_gmt) );
			$metadata['article:modified_time'] = date( 'c', strtotime( $post->post_modified_gmt ) );
			$metadata['article:author:first_name'] = get_the_author_meta('first_name', $post->post_author);
			$metadata['article:author:last_name'] = get_the_author_meta('last_name', $post->post_author);
			$metadata['article:author:username'] = get_the_author_meta('nicename', $post->post_author);
		}
	  return $metadata;
	}
}

if( !function_exists( 'idmuvi_opengraph_appid' ) ) {
	/**
	 * Add FB app ID in header
	 * @kentooz
	 */
	function idmuvi_opengraph_appid( $metadata ) {
		
		$idmuv_social = get_option( 'idmuv_social' );
		
		if ( isset ( $idmuv_social['social_app_id_facebook'] ) && $idmuv_social['social_app_id_facebook'] != '' ) {
			// option, section, default
			$option = $idmuv_social['social_app_id_facebook'];
		} else {
			$option = '1703072823350490';
		}
		
		if ( $option != '' ) {
			$metadata['fb:app_id'] = $option;
		}

	  return $metadata;
	}
}

if( !function_exists( 'idmuvi_opengraph_default_metadata' ) ) {
	/**
	 * Register filters for default Open Graph metadata.
	 */
	function idmuvi_opengraph_default_metadata() {
		// core metadata attributes
		add_filter('opengraph_title', 'idmuvi_opengraph_default_title', 5);
		add_filter('opengraph_type', 'idmuvi_opengraph_default_type', 5);
		add_filter('opengraph_url', 'idmuvi_opengraph_default_url', 5);

		add_filter('opengraph_description', 'idmuvi_opengraph_default_description', 5);
		add_filter('opengraph_locale', 'idmuvi_opengraph_default_locale', 5);
		add_filter('opengraph_site_name', 'idmuvi_opengraph_default_sitename', 5);
		add_filter('idmuvi_opengraph_metadata', 'idmuvi_opengraph_default_image' );

		// additional prefixes
		add_filter('idmuvi_opengraph_prefixes', 'idmuvi_opengraph_additional_prefixes');

		// additional profile metadata
		add_filter('idmuvi_opengraph_metadata', 'idmuvi_opengraph_profile_metadata');

		// additional article metadata
		add_filter('idmuvi_opengraph_metadata', 'idmuvi_opengraph_article_metadata');
		
		// aplication facebook ID
		add_filter('idmuvi_opengraph_metadata', 'idmuvi_opengraph_appid', 5);

		// twitter card metadata
		add_filter('twitter_opengraph_title', 'idmuvi_opengraph_default_title', 5);
		add_filter('twitter_opengraph_url', 'idmuvi_opengraph_default_url', 5);
		add_filter('twitter_opengraph_description', 'idmuvi_opengraph_default_description', 5);
		add_filter('twitter_opengraph_card', 'idmuvi_twitter_default_card', 5);
		add_filter('idmuvi_twitter_opengraph_metadata', 'idmuvi_twitter_opengraph_default_image' );
		add_filter('idmuvi_twitter_opengraph_metadata', 'idmuvi_twitter_opengraph_creator' );
	}
}
add_filter('wp', 'idmuvi_opengraph_default_metadata');

if( !function_exists( 'idmuvi_opengraph_meta_tags' ) ) {
	/**
	 * Output Open Graph <meta> tags in the page header.
	 */
	function idmuvi_opengraph_meta_tags() {
		$idmuv_social = get_option( 'idmuv_social' );
		
		if ( isset ( $idmuv_social['enable_opengraph'] ) && $idmuv_social['enable_opengraph'] != '' ) {
			// option, section, default
			$option = $idmuv_social['enable_opengraph'];
		} else {
			$option = 'on';
		}
		
		if ( $option == 'on' ) :
			
			// Remove functionally jetpack opengraph if plugin opengraph enable
			add_filter( 'jetpack_enable_open_graph', '__return_false' );
		
			printf( '<!-- Start meta data from idtheme.com core plugin -->' . "\n" );
			
				$metadata = idmuvi_opengraph_metadata();
				foreach ( $metadata as $key => $value ) {
					if ( empty($key) || empty($value) ) {
						continue;
					}
					$value = (array) $value;
					foreach ( $value as $v ) {
						printf('<meta property="%1$s" name="%1$s" content="%2$s" />' . "\n",
							esc_attr($key), esc_attr($v));
					}
				}
				
				$metadata_twitter = idmuvi_twitter_opengraph_metadata();
				foreach ( $metadata_twitter as $key => $value ) {
					if ( empty($key) || empty($value) ) {
						continue;
					}
					$value = (array) $value;
					foreach ( $value as $v ) {
						printf('<meta name="%1$s" content="%2$s" />' . "\n",
							esc_attr($key), esc_attr($v));
					}
				}
				
			printf( '<!-- End meta data from idtheme.com core plugin -->' . "\n" );
		
		endif;
	}
}
add_action( 'wp_head', 'idmuvi_opengraph_meta_tags', 1 );

/**
 * Helper function to trim text using the same default values for length and
 * 'more' text as wp_trim_excerpt.
 */
function idmuvi_opengraph_trim_text( $text ) {
	$excerpt_length = apply_filters( 'excerpt_length', 55 );
	$excerpt_more = apply_filters( 'excerpt_more', ' [...]' );

	return wp_trim_words( $text, $excerpt_length, $excerpt_more );
}