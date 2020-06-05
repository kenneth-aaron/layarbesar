<?php
/**
 * Template Name: Best rating
*/ 
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();

// Sidebar layout options via customizer
$sidebar_layout = get_theme_mod( 'gmr_blog_sidebar', 'sidebar' );

if ( $sidebar_layout == 'fullwidth' ) {
	$class_sidebar = ' col-md-12';
	
} else {
	$class_sidebar = ' col-md-9';
	
}
	
?>

<div id="primary" class="content-area<?php echo esc_attr($class_sidebar); ?> gmr-grid">

	<?php the_title( '<h1 class="page-title" ' . muvipro_itemprop_schema( 'headline' ) . '>', '</h1>' ); ?>
	
	<main id="main" class="site-main" role="main">
	
	<?php do_action( 'idmuvi_core_topbanner_archive' ); ?>

	<?php
	
	global $paged;	
	
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	
	$args = array(
		'paged' => $paged,
		'post_type' => array( 'post', 'tv' ),
		'ignore_sticky_posts' => 1,
		'orderby'   => 'meta_value_num',
		'meta_key'  => 'IDMUVICORE_tmdbRating',
	);

	$the_query = new WP_Query( $args );
	
	global $wp_query;
	// Put default query object in a temp variable
	$tmp_query = $wp_query;
	// Now wipe it out completely
	$wp_query = null;
	// Re-populate the global with our custom query
	$wp_query = $the_query;
	
	if ( $the_query->have_posts() ) : 

		echo '<div id="gmr-main-load" class="row grid-container">';
		
		/* Start the Loop */
		while ( $the_query->have_posts() ) : $the_query->the_post();
			
			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );

		endwhile;
		
		echo '</div>';

		echo gmr_get_pagination();

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif; 
	// Restore original query object
	$wp_query = null;
	$wp_query = $tmp_query;
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php 
if ( $sidebar_layout == 'sidebar' ) {
	get_sidebar(); 
}
	
get_footer();