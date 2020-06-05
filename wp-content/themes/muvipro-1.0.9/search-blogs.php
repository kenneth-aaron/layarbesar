<?php
/**
 * The template for displaying a single blog
 *
 *
 * @package muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();

?>

<div id="primary" class="content-area col-md-9 gmr-grid">

	<?php 
		echo '<h1 class="page-title" itemprop="headline">';
			the_archive_title();
		echo '</h1>';
		
		// display description archive page
		the_archive_description( '<div class="taxonomy-description">', '</div>' );
	?>		
	
	<main id="main" class="site-main" role="main">
	
	<?php do_action( 'idmuvi_core_topbanner_archive' ); ?>

	<?php
	if ( have_posts() ) :

		echo '<div id="gmr-main-load" class="row grid-container">';
		
		/* Start the Loop */
		while ( have_posts() ) : the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', 'blogs' );
			
		endwhile;
		
		echo '</div>';
		
		echo gmr_get_pagination();
		
	else :
		echo __( 'No Blog', 'muvipro' );

	endif; 
	
	// Reset Query
	wp_reset_query();
	
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php 
	get_sidebar('blogs'); 

	get_footer();