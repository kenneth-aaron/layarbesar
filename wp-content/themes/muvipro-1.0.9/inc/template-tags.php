<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'gmr_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_posted_on() {
		$time_string = '<time class="entry-date published updated" ' . muvipro_itemprop_schema( 'dateModified' ) . ' datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" ' . muvipro_itemprop_schema( 'datePublished' ) . ' datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf( __( 'Posted on %s', 'muvipro' ), $time_string );

		$posted_by = sprintf(
			__( 'By %s', 'muvipro' ),
			'<span class="entry-author vcard" ' . muvipro_itemprop_schema( 'author' ) . ' ' . muvipro_itemtype_schema( 'person' ) . '><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . __( 'Permalink to: ','muvipro' ) . esc_html( get_the_author() ) . '" ' . muvipro_itemprop_schema( 'url' ) . '><span ' . muvipro_itemprop_schema( 'name' ) . '>' . esc_html( get_the_author() ) . '</span></a></span>'
		);
		if ( is_single() ) :
			echo '<span class="byline"> ' . $posted_by . '</span><span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
		else :
			echo '<div class="gmr-metacontent"><span class="byline"> ' . $posted_by . '</span><span class="posted-on">' . $posted_on . '</span></div>'; // WPCS: XSS OK.
		endif;
	}
endif; // endif gmr_posted_on

if ( ! function_exists( 'gmr_movie_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_movie_on() {
		global $post;
		echo '<div class="gmr-movie-on">';
		$categories_list = get_the_category_list( esc_html__( ', ','muvipro' ) );
		if ( $categories_list ) {
			echo $categories_list;
			echo ', ';
		}
		if( !is_wp_error( get_the_term_list( $post->ID, 'muvicountry' ) ) ) {
			$termlist = get_the_term_list( $post->ID, 'muvicountry' );
			if ( !empty ( $termlist ) ) {
				echo get_the_term_list( $post->ID, 'muvicountry', '<span itemprop="contentLocation" itemscope="itemscope" itemtype="http://schema.org/Place">', '</span>, <span itemprop="contentLocation" itemscope="itemscope" itemtype="http://schema.org/Place">', '</span>' );
			}
		}
		echo '</div>';
	}
endif; // endif gmr_movie_on

if ( ! function_exists( 'gmr_moviemeta_after_content' ) ) :
	/**
	 * Prints HTML with meta information for the cast and other movie meta
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_moviemeta_after_content( $content ) {
		global $post;
		
		if ( is_singular() && in_the_loop() ) {
			$content .= '<table style="border:1px;width:100%;">';
				$tagline = get_post_meta( $post->ID, 'IDMUVICORE_Tagline', true );
				if ( ! empty( $tagline ) ) {
					$content .= '<tr>';
						$content .= '<td width="20%"><strong>' . __( 'Tagline:', 'muvipro' ) . '</strong></td>';
						$content .= '<td>' . $tagline . '</td>';
					$content .= '</tr>';
				}
				
				$seriename = get_post_meta( $post->ID, 'IDMUVICORE_Title_Episode', true );
				if ( ! empty( $seriename ) ) {
					$content .= '<tr>';
						$content .= '<tr><td width="20%"><strong>' . __( 'Episode Name:', 'muvipro' ) . '</strong></td>';
						$content .= '<td>' . $seriename . '</td>';
					$content .= '</tr>';
				}
				
				if( !is_wp_error( get_the_term_list( $post->ID, 'muvicast' ) ) ) {
					$termlist = get_the_term_list( $post->ID, 'muvicast' );
					if ( !empty ( $termlist ) ) {
						$content .= '<tr>';
							$content .= '<td width="20%"><strong>' . __( 'Cast:', 'muvipro' ) . '</strong></td>';
							$content .= get_the_term_list( $post->ID, 'muvicast', '<td><span itemprop="actors" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>, <span itemprop="actors" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span></td>' );
						$content .= '</tr>';
					}
				}
				
				if( !is_wp_error( get_the_term_list( $post->ID, 'muvidirector' ) ) ) {
					$termlist = get_the_term_list( $post->ID, 'muvidirector' );
					if ( !empty ( $termlist ) ) {
						$content .= '<tr>';
							$content .= '<td width="20%"><strong>' . __( 'Director:', 'muvipro' ) . '</strong></td>';
							$content .= get_the_term_list( $post->ID, 'muvidirector', '<td><span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span>, <span itemprop="director" itemscope="itemscope" itemtype="http://schema.org/Person"><span itemprop="name">', '</span></span></td>' );
						$content .= '</tr>';
					}
				}
				
				if( !is_wp_error( get_the_term_list( $post->ID, 'muvicountry' ) ) ) {
					$termlist = get_the_term_list( $post->ID, 'muvicountry' );
					if ( !empty ( $termlist ) ) {
						$content .= '<tr>';
							$content .= '<td width="20%"><strong>' . __( 'Country:', 'muvipro' ) . '</strong></td>';
							$content .= get_the_term_list( $post->ID, 'muvicountry', '<td><span itemprop="contentLocation" itemscope="itemscope" itemtype="http://schema.org/Place">', '</span>, <span itemprop="contentLocation" itemscope="itemscope" itemtype="http://schema.org/Place">', '</span></td>' );
						$content .= '</tr>';
					}
				}
				
				$release = get_post_meta( $post->ID, 'IDMUVICORE_Released', true );
				// Check if the custom field has a value.
				if ( ! empty( $release ) ) {
					if ( gmr_checkIsAValidDate($release) == true ) {
						$datetime = new DateTime( $release );
						$content .= '<tr>';
							$content .= '<td width="20%"><strong>' . __( 'Release:', 'muvipro' ) . '</strong></td>';
							$content .= '<td><span><time itemprop="dateCreated" datetime="'.$datetime->format('c').'">'.$release.'</time></span></td>';
						$content .= '</tr>';
					}
				}
				
				$airdate = get_post_meta( $post->ID, 'IDMUVICORE_Lastdate', true );
				// Check if the custom field has a value.
				if ( ! empty( $airdate ) ) {
					$content .= '<tr>';
						$content .= '<td width="20%"><strong>' . __( 'Last Air Date:', 'muvipro' ) . '</strong></td>';
						$content .= '<td><span>';
						$content .= $airdate;
						$content .= '</span></td>';
					$content .= '</tr>';
				}
				
				$episodes = get_post_meta( $post->ID, 'IDMUVICORE_Numbepisode', true );
				// Check if the custom field has a value.
				if ( ! empty( $episodes ) ) {
					$content .= '<tr>';
						$content .= '<td width="20%"><strong>' . __( 'Number Of Episode:', 'muvipro' ) . '</strong></td>';
						$content .= '<td><span>';
						$content .= $episodes;
						$content .= '</span></td>';
					$content .= '</tr>';
				}
				
				if( !is_wp_error( get_the_term_list( $post->ID, 'muvinetwork' ) ) ) {
					$termlist = get_the_term_list( $post->ID, 'muvinetwork' );
					if ( !empty ( $termlist ) ) {
						$content .= '<tr>';
							$content .= '<td width="20%"><strong>' . __( 'Network:', 'muvipro' ) . '</strong></td>';
							$content .= get_the_term_list( $post->ID, 'muvinetwork', '<td><span>', '</span>, <span>', '</span></td>' );
						$content .= '</tr>';
					}
				}
				
				$language = get_post_meta( $post->ID, 'IDMUVICORE_Language', true );
				// Check if the custom field has a value.
				if ( ! empty( $language ) ) {
					$content .= '<tr>';
						$content .= '<td width="20%"><strong>' . __( 'Language:', 'muvipro' ) . '</strong></td>';
						$content .= '<td><span property="inLanguage">';
						$content .= $language;
						$content .= '</span></td>';
					$content .= '</tr>';
				}
				
				$budget = get_post_meta( $post->ID, 'IDMUVICORE_Budget', true );
				// Check if the custom field has a value.
				if ( ! empty( $budget ) ) {
					$content .= '<tr>';
						$content .= '<td width="20%"><strong>' . __( 'Budget:', 'muvipro' ) . '</strong></td>';
						$content .= '<td>';
						$content .= '$ ' . number_format((float)$budget, 2, ',', '.');
						$content .= '</td>';
					$content .= '</tr>';
				}	
				
				$revenue = get_post_meta( $post->ID, 'IDMUVICORE_Revenue', true );
				// Check if the custom field has a value.
				if ( ! empty( $revenue ) ) {
					$content .= '<tr>';
					$content .= '<td width="20%"><strong>' . __( 'Revenue:', 'muvipro' ) . '</strong></td>';
					$content .= '<td>';
					$content .= '$ ' . number_format((float)$revenue, 2, ',', '.');
					$content .= '</td>';
					$content .= '</tr>';
				}
				
			$content .= '</table><br/>'; // add br for prevent paragraph error
			
			return $content;
		}
		return $content;
	}
endif;
add_filter( 'the_content', 'gmr_moviemeta_after_content', 3 );

if ( ! function_exists( 'gmr_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_entry_footer() {
		global $post;
		// Hide category and tag text for pages.
		if ( is_singular( array( 'post', 'tv' ) ) ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'muvipro' ) );
			echo '<span class="cat-links">';
			echo __( 'Posted in ', 'muvipro' );
				$categories_list = get_the_category_list( esc_html__( ', ','muvipro' ) );
				if ( $categories_list ):
					echo $categories_list;
					echo ', ';
				endif; 
				if( !is_wp_error( get_the_term_list( $post->ID, 'muviquality' ) ) ) {
					$termlist = get_the_term_list( $post->ID, 'muviquality' );
					if ( !empty ( $termlist ) ) {
						echo get_the_term_list( $post->ID, 'muviquality', '<span>', '</span>, <span>', '</span>' );
						echo ', ';
					}
				}
				if( !is_wp_error( get_the_term_list( $post->ID, 'muvicountry' ) ) ) {
					$termlist = get_the_term_list( $post->ID, 'muvicountry' );
					if ( !empty ( $termlist ) ) {
						echo get_the_term_list( $post->ID, 'muvicountry', '<span itemprop="contentLocation" itemscope="itemscope" itemtype="http://schema.org/Place">', '</span>, <span itemprop="contentLocation" itemscope="itemscope" itemtype="http://schema.org/Place">', '</span>' );
					}
				}
			echo '</span>';
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'muvipro' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'muvipro' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'muvipro' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
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
	}
endif; // endif gmr_entry_footer

if ( ! function_exists( 'gmr_categorized_blog' ) ) :
	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	function gmr_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'muvipro_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'muvipro_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so gmr_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so gmr_categorized_blog should return false.
			return false;
		}
	}
endif; // endif gmr_categorized_blog

if ( ! function_exists( 'gmr_category_transient_flusher' ) ) :
	/**
	 * Flush out the transients used in gmr_categorized_blog.
	 *
	 * @since 1.0.0
	 */
	function gmr_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'muvipro_categories' );
	}
endif; // endif gmr_category_transient_flusher
add_action( 'edit_category', 'gmr_category_transient_flusher' );
add_action( 'save_post',     'gmr_category_transient_flusher' );

if ( ! function_exists( 'gmr_custom_excerpt_length' ) ) :
	/**
	 * Filter the except length to 20 characters.
	 *
	 * @since 1.0.0
	 *
	 * @param int $length Excerpt length.
	 * @return int (Maybe) modified excerpt length.
	 */
	function gmr_custom_excerpt_length( $length ) {
		  $length = get_theme_mod('gmr_excerpt_number', '20');
		  // absint sanitize int non minus
		  return absint($length);
	}
endif; // endif gmr_custom_excerpt_length
add_filter( 'excerpt_length', 'gmr_custom_excerpt_length', 999 );

if ( ! function_exists( 'gmr_custom_readmore' ) ) :
	/**
	 * Filter the except length to 20 characters.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more
	 * @return string read more.
	 */
	function gmr_custom_readmore( $more ) {
		$more = get_theme_mod('gmr_read_more');
		if ($more == '') {
			return '&nbsp;[&hellip;]';
		} else {
			return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) . '" title="' .get_the_title( get_the_ID() ). '" ' . muvipro_itemprop_schema( 'url' ) . '>' . esc_html( $more ) . '</a>';
		}
	}
endif; // endif gmr_custom_readmore
add_filter( 'excerpt_more', 'gmr_custom_readmore' );

if ( ! function_exists( 'gmr_get_pagination' ) ) :
	/**
	 * Retrieve paginated link for archive post pages.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function gmr_get_pagination(){
		global $wp_rewrite;
		global $wp_query;
		return paginate_links( apply_filters('gmr_get_pagination_args', array(
			'base'      => str_replace('99999', '%#%', esc_url(get_pagenum_link(99999))),
			'format'    => $wp_rewrite->using_permalinks() ? 'page/%#%' : '?paged=%#%',
			'current'   => max(1, get_query_var('paged')),
			'total'     => $wp_query->max_num_pages,
			'prev_text' => '<span class="gmr-icon arrow_carrot-2left"></span>',
			'next_text' => '<span class="gmr-icon arrow_carrot-2right"></span>',
			'type'      => 'list'
		)));
	}
endif; // endif gmr_get_pagination

if ( !function_exists( 'gmr_top_searchbutton' ) ) :
	/**
	 * This function add search button in header
	 *
	 * @since 1.0.0
	 */
	function gmr_top_searchbutton() {
		echo '<div class="gmr-search pull-right">';
			echo '<form method="get" class="gmr-searchform searchform" action="' . esc_url( home_url( '/' ) ) . '">'; 
				echo '<input type="text" name="s" id="s" placeholder="' . __( 'Search Movie', 'muvipro' ) . '" />';
				echo '<input type="hidden" name="post_type[]" value="post">';
				echo '<input type="hidden" name="post_type[]" value="tv">';
			echo '</form>';
		echo '</div>';
	}
endif; // endif gmr_top_searchbutton
add_action( 'gmr_top_searchbutton', 'gmr_top_searchbutton', 5 );

if ( !function_exists( 'gmr_nav_mobile_close' ) ) :
	/**
	 * This function add close button in mobile menu.
	 *
	 * @since 1.0.0
	 *
	 * @param string $items 
	 * @param array $args
	 * @param bool $ajax default false
	 * @return string
	 */
	function gmr_nav_mobile_close( $items, $args, $ajax = false ) {
		
		// Primary Navigation Area Only
		if ( ( isset( $ajax ) && $ajax ) || ( property_exists( $args, 'theme_location' ) && $args->theme_location === 'primary' ) ) {
			$css_class = 'menu-item menu-item-type-close-btn gmr-close-btn';
			$items .= '<li class="' . esc_attr( $css_class ) . '">';
				$items .= '<a id="close-menu-button" ' . muvipro_itemprop_schema( 'url' ) . ' href="#">'; 
				$items .= __( 'Close Menu', 'muvipro' ); 
				$items .= '</a>';
			$items .= '</li>';
		}
		// Secondary Navigation Area Only
		if ( ( isset( $ajax ) && $ajax ) || ( property_exists( $args, 'theme_location' ) && $args->theme_location === 'secondary' ) ) {
			$css_class = 'menu-item menu-item-type-close-btn gmr-close-btn';
			$items .= '<li class="' . esc_attr( $css_class ) . '">';
				$items .= '<a id="close-secondmenu-button" ' . muvipro_itemprop_schema( 'url' ) . ' href="#">'; 
				$items .= __( 'Close Menu', 'muvipro' ); 
				$items .= '</a>';
			$items .= '</li>';
		}
		// Top Navigation Area Only
		if ( ( isset( $ajax ) && $ajax ) || ( property_exists( $args, 'theme_location' ) && $args->theme_location === 'topnav' ) ) {
			$css_class = 'menu-item menu-item-type-close-btn gmr-close-btn';
			$items .= '<li class="' . esc_attr( $css_class ) . '">';
				$items .= '<a id="close-topnavmenu-button" ' . muvipro_itemprop_schema( 'url' ) . ' href="#">'; 
				$items .= __( 'Close Menu', 'muvipro' ); 
				$items .= '</a>';
			$items .= '</li>';
		}
		return apply_filters('gmr_nav_close_mobile_filter', $items);
	}
endif; // endif gmr_nav_mobile_close
add_filter( 'wp_nav_menu_items', 'gmr_nav_mobile_close', 20, 2 );

if ( !function_exists( 'muvipro_add_menu_attribute' ) ) :
	/**
	 * Add attribute itemprop="url" to menu link
	 *
	 * @since 1.0.0
	 *
	 * @param string $atts
	 * @param string $item
	 * @param array $args
	 * @return string
	 */
	function muvipro_add_menu_attribute( $atts, $item, $args ) {
	  $atts['itemprop'] = 'url';
	  return $atts;
	}
endif; // endif muvipro_add_menu_attribute
add_filter( 'nav_menu_link_attributes', 'muvipro_add_menu_attribute', 10, 3 );

if ( ! function_exists( 'gmr_the_custom_logo' ) ) :
	/**
	 * Print custom logo.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_the_custom_logo() {
		echo '<div class="gmr-logo">';
		// if get value from customizer gmr_logoimage
		$setting = 'gmr_logoimage';
		$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		
		if ( $mod ) {
			// get url image from value gmr_logoimage
			$image = esc_url_raw ( $mod );
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" ' . muvipro_itemprop_schema( 'url' ) . ' title="' . get_bloginfo( 'name' ) . '">';
					echo '<img src="' . $image . '" alt="' . get_bloginfo( 'name' ) . '" title="' . get_bloginfo( 'name' ) . '" ' . muvipro_itemprop_schema( 'image' ) . ' />';
			echo '</a>';

		} else {
			// if get value from customizer blogname
			if ( get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) ) {
				echo '<div class="site-title" ' . muvipro_itemprop_schema( 'headline' ) . '>';
					echo '<a href="' . esc_url( home_url( '/' ) ) . '" ' . muvipro_itemprop_schema( 'url' ) . ' title="' . get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) . '">'; 
					echo get_theme_mod( 'blogname', get_bloginfo('name') );
					echo '</a>';
				echo '</div>';
				
			}
			// if get value from customizer blogdescription
			if ( get_theme_mod( 'blogdescription', get_bloginfo( 'description' ) ) ) {
				echo '<span class="site-description" ' . muvipro_itemprop_schema( 'description' ) . '>'; 
					echo get_theme_mod( 'blogdescription', get_bloginfo( 'description' ) );
				echo '</span>';
				
			}
		}
		echo '</div>';
	}
endif; // endif gmr_the_custom_logo
add_action( 'gmr_the_custom_logo', 'gmr_the_custom_logo', 5 );

if ( ! function_exists( 'gmr_move_post_navigation' ) ) :
	/**
	 * Move post navigation in top after content.
	 *
	 * @since 1.0.0
	 *
	 * @return string $content
	 */
	function gmr_move_post_navigation( $content ) {
		if ( is_singular() && in_the_loop() ) {
			$pagination = wp_link_pages( array(
						'before' => '<div class="page-links"><span class="page-text">' . esc_html__( 'Pages:', 'muvipro' ) . '</span>',
						'after'  => '</div>',
						'link_before' => '<span class="page-link-number">', 
						'link_after' => '</span>',
						'echo'        => 0,
					) );
			$content .= $pagination;
			return $content;
		}
		return $content;
	}
endif; // endif gmr_move_post_navigation
add_filter( 'the_content', 'gmr_move_post_navigation', 1 );

if ( ! function_exists( 'gmr_embed_oembed_html' ) ) :
/**
 * Add responsive oembed class only for youtube and vimeo.
 * @add_filter embed_oembed_html
 * @class gmr_embed_oembed_html
 * @link https://developer.wordpress.org/reference/hooks/embed_oembed_html/
 */
function gmr_embed_oembed_html($html, $url, $attr, $post_id) {
    $classes = array();

    // Add these classes to all embeds.
    $classes_all = array(
        'gmr-video-responsive',
    );

    // Check for different providers and add appropriate classes.

    if ( false !== strpos( $url, 'vimeo.com' ) ) {
        $classes[] = 'gmr-embed-responsive gmr-embed-responsive-16by9';
    }

    if ( false !== strpos( $url, 'youtube.com' ) ) {
        $classes[] = 'gmr-embed-responsive gmr-embed-responsive-16by9';
    }
	
	$classes = array_merge( $classes, $classes_all );

	return '<div class="' . esc_attr( implode( $classes, ' ' ) ) . '">' . $html . '</div>';
}
endif; // endif gmr_embed_oembed_html
add_filter('embed_oembed_html', 'gmr_embed_oembed_html', 99, 4);

if ( ! function_exists( 'muvipro_prepend_attachment' ) ) :
	/**
	 * Callback for WordPress 'prepend_attachment' filter.
	 * 
	 * Change the attachment page image size to 'full'
	 * 
	 * @package WordPress
	 * @category Attachment
	 * @see wp-includes/post-template.php
	 * 
	 * @param string $attachment_content the attachment html
	 * @return string $attachment_content the attachment html
	 */
	function muvipro_prepend_attachment( $attachment_content ){
			
		$post = get_post();
		if ( wp_attachment_is( 'image', $post ) ) {
			// set the attachment image size to 'full'
			$attachment_content = sprintf( '<p>%s</p>', wp_get_attachment_link(0, 'full', false) );
			
			// return the attachment content
			return $attachment_content;
			
		} else {
			// return the attachment content
			return $attachment_content;
		}
			
	}
endif; // endif muvipro_prepend_attachment
add_filter( 'prepend_attachment', 'muvipro_prepend_attachment' );

if ( ! function_exists( 'gmr_video_download' ) ) :
	/**
	 * Print video download link
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_video_download( $content ) {
		global $post;
		if ( is_singular( array( 'post','episode' ) ) && in_the_loop() ) {
			$download1 = get_post_meta( $post->ID, 'IDMUVICORE_Download1', true );
			$titledownload1 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Download1', true );
		
			$download2 = get_post_meta( $post->ID, 'IDMUVICORE_Download2', true );
			$titledownload2 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Download2', true );
			
			$download3 = get_post_meta( $post->ID, 'IDMUVICORE_Download3', true );
			$titledownload3 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Download3', true );
			
			$download4 = get_post_meta( $post->ID, 'IDMUVICORE_Download4', true );
			$titledownload4 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Download4', true );
			
			$download5 = get_post_meta( $post->ID, 'IDMUVICORE_Download5', true );
			$titledownload5 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Download5', true );
			
			$download6 = get_post_meta( $post->ID, 'IDMUVICORE_Download6', true );
			$titledownload6 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Download6', true );
			
			$download7 = get_post_meta( $post->ID, 'IDMUVICORE_Download7', true );
			$titledownload7 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Download7', true );
			
			$download8 = get_post_meta( $post->ID, 'IDMUVICORE_Download8', true );
			$titledownload8 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Download8', true );
			
			$download9 = get_post_meta( $post->ID, 'IDMUVICORE_Download9', true );
			$titledownload9 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Download9', true );
			
			$download10 = get_post_meta( $post->ID, 'IDMUVICORE_Download10', true );
			$titledownload10 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Download10', true );
		
			if ( ! empty( $download1 ) ) {

				$content .= '<div id="download" class="gmr-download-wrap clearfix">';
					$content .= '<h3 class="widget-title title-synopsis">'.__('Download Links', 'muvipro').'</h3>';
					$content .= '<ul class="list-inline gmr-download-list clearfix">';
						if ( ! empty( $download1 ) ) {
							$content .= '<li><a href="' . $download1 . '" class="button" rel="nofollow" target="_blank" title="'.__('Download link 1', 'muvipro') .' ' . get_the_title() .'"><span class="icon_download" aria-hidden="true"></span>'; 
							if( ! empty( $titledownload1 ) ) {
								$content .= $titledownload1; 
							} else { 
								$content .= __('Download Link 1', 'muvipro'); 
							} 
							$content .= '</a></li>';
						}
						
						if ( ! empty( $download2 ) ) {
							$content .= '<li><a href="' . $download2 . '" class="button" rel="nofollow" target="_blank" title="'.__('Download link 2', 'muvipro') .' ' . get_the_title() .'"><span class="icon_download" aria-hidden="true"></span>'; 
							if( ! empty( $titledownload2 ) ) {
								$content .= $titledownload2; 
							} else { 
								$content .= __('Download Link 2', 'muvipro'); 
							} 
							$content .= '</a></li>';
						}
						
						if ( ! empty( $download3 ) ) {
							$content .= '<li><a href="' . $download3 . '" class="button" rel="nofollow" target="_blank" title="'.__('Download link 3', 'muvipro') .' ' . get_the_title() .'"><span class="icon_download" aria-hidden="true"></span>'; 
							if( ! empty( $titledownload3 ) ) {
								$content .= $titledownload3; 
							} else { 
								$content .= __('Download Link 3', 'muvipro'); 
							} 
							$content .= '</a></li>';
						}
						
						if ( ! empty( $download4 ) ) {
							$content .= '<li><a href="' . $download4 . '" class="button" rel="nofollow" target="_blank" title="'.__('Download link 4', 'muvipro') .' ' . get_the_title() .'"><span class="icon_download" aria-hidden="true"></span>'; 
							if( ! empty( $titledownload4 ) ) {
								$content .= $titledownload4; 
							} else { 
								$content .= __('Download Link 4', 'muvipro'); 
							} 
							$content .= '</a></li>';
						}
						
						if ( ! empty( $download5 ) ) {
							$content .= '<li><a href="' . $download5 . '" class="button" rel="nofollow" target="_blank" title="'.__('Download link 5', 'muvipro') .' ' . get_the_title() .'"><span class="icon_download" aria-hidden="true"></span>'; 
							if( ! empty( $titledownload5 ) ) {
								$content .= $titledownload5; 
							} else { 
								$content .= __('Download Link 5', 'muvipro'); 
							} 
							$content .= '</a></li>';
						}
						
						if ( ! empty( $download6 ) ) {
							$content .= '<li><a href="' . $download6 . '" class="button" rel="nofollow" target="_blank" title="'.__('Download link 6', 'muvipro') .' ' . get_the_title() .'"><span class="icon_download" aria-hidden="true"></span>'; 
							if( ! empty( $titledownload6 ) ) {
								$content .= $titledownload6; 
							} else { 
								$content .= __('Download Link 6', 'muvipro'); 
							} 
							$content .= '</a></li>';
						}
						
						if ( ! empty( $download7 ) ) {
							$content .= '<li><a href="' . $download7 . '" class="button" rel="nofollow" target="_blank" title="'.__('Download link 7', 'muvipro') .' ' . get_the_title() .'"><span class="icon_download" aria-hidden="true"></span>'; 
							if( ! empty( $titledownload7 ) ) {
								$content .= $titledownload7; 
							} else { 
								$content .= __('Download Link 7', 'muvipro'); 
							} 
							$content .= '</a></li>';
						}
						
						if ( ! empty( $download8 ) ) {
							$content .= '<li><a href="' . $download8 . '" class="button" rel="nofollow" target="_blank" title="'.__('Download link 8', 'muvipro') .' ' . get_the_title() .'"><span class="icon_download" aria-hidden="true"></span>'; 
							if( ! empty( $titledownload8 ) ) {
								$content .= $titledownload8; 
							} else { 
								$content .= __('Download Link 8', 'muvipro'); 
							} 
							$content .= '</a></li>';
						}
						
						if ( ! empty( $download9 ) ) {
							$content .= '<li><a href="' . $download9 . '" class="button" rel="nofollow" target="_blank" title="'.__('Download link 9', 'muvipro') .' ' . get_the_title() .'"><span class="icon_download" aria-hidden="true"></span>'; 
							if( ! empty( $titledownload9 ) ) {
								$content .= $titledownload9; 
							} else { 
								$content .= __('Download Link 9', 'muvipro'); 
							} 
							$content .= '</a></li>';
						}
						
						if ( ! empty( $download10 ) ) {
							$content .= '<li><a href="' . $download10 . '" class="button" rel="nofollow" target="_blank" title="'.__('Download link 10', 'muvipro') .' ' . get_the_title() .'"><span class="icon_download" aria-hidden="true"></span>'; 
							if( ! empty( $titledownload10 ) ) {
								$content .= $titledownload10; 
							} else { 
								$content .= __('Download Link 10', 'muvipro'); 
							} 
							$content .= '</a></li>';
						}
					$content .= '</ul>';
				$content .= '</div>';
			}
			
			return $content;
		}
		return $content;
	}
endif; // endif gmr_video_download
add_filter( 'the_content', 'gmr_video_download', 4 );

if ( ! function_exists( 'gmr_tvshow_serie_list' ) ) :
	/**
	 * Print Series list
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_tvshow_serie_list( $content ) {
		global $post;
		if ( is_singular('tv') && in_the_loop() ) {
			$post_id = $post->ID; // current post ID
			$tmdbid = get_post_meta( $post->ID, 'IDMUVICORE_tmdbID', true );
			if ( ! empty( $tmdbid ) ) {
				$args = array(
					'post_type'     => 'episode',
					'posts_per_page' => -1,
					// fix title with number
					'orderby'		=> 'wp_posts.post_title+0',
					'order'			=> 'ASC',
					'meta_query' => array(
						array(
							'key'     => 'IDMUVICORE_tmdbID',
							'value'   => $tmdbid,
							'compare' => '=',
						)
					),
				);
				$episode = new WP_Query( $args );
				if( $episode->have_posts() ) {
					$content .= '<ul class="gmr-listseries">';
						$content .= '<li class="gmr-listseries-title">' . __('All Episodes','muvipro') . '</li>';
						while ( $episode->have_posts() ) : $episode->the_post();
							$content .= '<li><a href="' . get_permalink() . '" title="' . __('Permalink to','muvipro') . ' ' . get_the_title() . '">' . get_the_title() . '</a><a class="pull-right" href="' . get_permalink() . '" title="' . __('Permalink to','muvipro') . ' ' . get_the_title() . '">'. __('Watch Now','muvipro') .'</a></li>';
						endwhile;
					$content .= '</ul>';
				}
				wp_reset_postdata();
			}
		}
		return $content;
	}
endif;
add_filter( 'the_content', 'gmr_tvshow_serie_list', 3 );

if ( ! function_exists( 'gmr_get_prevnext_episode' ) ) :
	/**
	 * Retrieve prev and next episode
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function gmr_get_prevnext_episode() {
		global $post;	
		if ( is_singular('episode') && in_the_loop() ) {
			$post_id = $post->ID; // current post ID
			
			$tmdbid = get_post_meta( $post->ID, 'IDMUVICORE_tmdbID', true );
			if ( ! empty( $tmdbid ) ) {
				
				$args = array(
					'post_type'     => 'episode',
					'posts_per_page' => -1,
					// fix title with number
					'orderby'		=> 'wp_posts.post_title+0',
					'order'			=> 'ASC',
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
				$previd = isset($ids[ $thisindex - 1 ]) ? $ids[ $thisindex - 1 ] : null;
				$nextid = isset($ids[ $thisindex + 1 ]) ? $ids[ $thisindex + 1 ] : null;

				if ( ! empty( $previd ) || ! empty( $nextid ) ) {
					echo '<nav class="navigation post-navigation" role="navigation">';
				}
					if ( ! empty( $previd ) ) {
						echo '<div class="nav-links">';
							echo '<div class="nav-previous">';
							echo '<a rel="prev" href="' . get_permalink($previd) . '" title="' . __( 'Permalink to: ','muvipro' ) . get_the_title($previd) . '" rel="previous"><span>' . __( 'Prev Episode', 'muvipro' ) .'</span>'. get_the_title($previd) . '</a>';
							echo '</div>';
						echo '</div>';
					}

					if ( ! empty( $nextid ) ) {
						echo '<div class="nav-links">';
							echo '<div class="nav-next">';
							echo '<a rel="next" href="' . get_permalink($nextid) . '" title="' . __( 'Permalink to: ','muvipro' ) . get_the_title($previd) . '" rel="next"><span>' . __( 'Next Episode', 'muvipro' ) .'</span>'. get_the_title($nextid) . '</a>';
							echo '</div>';
						echo '</div>';
					}
				if ( ! empty( $previd ) || ! empty( $nextid ) ) {
					echo '</nav>';
				}
			}
		}
	}
endif; // endif gmr_get_prevnext_episode
add_action( 'gmr_get_prevnext_episode', 'gmr_get_prevnext_episode', 5 );