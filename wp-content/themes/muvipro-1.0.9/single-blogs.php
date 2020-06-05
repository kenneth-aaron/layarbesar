<?php
/**
 * The template for displaying a single doc
 *
 * To customize this template, create a folder in your current theme named "muvipro" and copy it there.
 *
 * @package muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); 

?>

<div id="primary" class="content-area col-md-9">

	<?php do_action( 'idmuvi_core_view_breadcrumbs' ); ?>

	<main id="main" class="site-main" role="main">
	
	<?php 
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'single-blog' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			
		endwhile; // End of the loop.
	?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php 
	get_sidebar('blogs'); 

	get_footer();