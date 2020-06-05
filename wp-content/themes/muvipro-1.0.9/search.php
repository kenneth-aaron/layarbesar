<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

<?php 

// Sidebar layout options via customizer
$sidebar_layout = get_theme_mod( 'gmr_blog_sidebar', 'sidebar' );

if ( $sidebar_layout == 'fullwidth' ) {
	$class_sidebar = ' col-md-12';
	
} else {
	$class_sidebar = ' col-md-9';
	
}
	
?>

<div id="primary" class="content-area<?php echo esc_attr($class_sidebar); ?> gmr-grid">

	<?php 
		echo '<h1 class="page-title" ' . muvipro_itemprop_schema( 'headline' ) . '>';
			echo __('Search Results For: ', 'muvipro') . " " . esc_attr( apply_filters('the_search_query', get_search_query(false)) );
		echo '</h1>';
	?>
	
	<main id="main" class="site-main" role="main">
	
	<?php do_action( 'idmuvi_core_topbanner_archive' ); ?>

	<?php
	if ( have_posts() ) :
		
		echo '<div id="gmr-main-load" class="row grid-container">';
		
		/* Start the Loop */
		while ( have_posts() ) : the_post();

			/**
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-__.php and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );

		endwhile;
		
		echo '</div>';

		echo gmr_get_pagination();

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif; ?>

	</main><!-- #main -->
	
</div><!-- #primary -->

<?php 
if ( $sidebar_layout == 'sidebar' ) {
	get_sidebar(); 
}

get_footer();