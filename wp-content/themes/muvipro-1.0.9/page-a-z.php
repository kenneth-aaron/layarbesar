<?php
/*
 * Template Name: A-Z Pages
 *
 * A WordPress template to list page titles by first letter.
 *
 * You should modify the CSS to suit your theme and place it in its proper file.
 * Be sure to set the $posts_per_row and $posts_per_page variables.
 *
 * Thanks to https://www.facebook.com/irviana.irvan
 *
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

$posts_per_row = 1;
$posts_per_page = -1;

?>
 
<div id="primary" class="content-area<?php echo esc_attr($class_sidebar); ?> gmr-grid">

	<?php the_title( '<h1 class="page-title" ' . muvipro_itemprop_schema( 'headline' ) . '>', '</h1>' ); ?>
	
	<main id="main" class="site-main" role="main">
	
	<?php do_action( 'idmuvi_core_topbanner_archive' ); ?>
 
	<?php

	$i = 1;
	
	if ( have_posts() ) {
		echo '<ul class="page-numbers">';
			wp_list_categories( array(
			'taxonomy' => 'muviindex',
			'title_li' => ''
			) );
		echo '</ul>';
				
		echo '<div class="row">';
		
		$arg = array( 
			'taxonomy' => 'muviindex',
			'post_type' => array ( 'post', 'tv' ),
		);
		
		$categories = get_categories( $arg );
		
		/* Start the Loop */
		foreach ($categories as $cat) {
			
			echo '<div class="col-md-6 gmr-az-list">';
		
				$paged = ( get_query_var('paged') ) ? get_query_var( 'paged' ) : 1;
				
				// get term by id custom taxonomy
				$cat_id = $cat->term_id;
				
					echo '<div class="az-list-header">';
				
					echo '<h2><a href="'.esc_url( get_category_link( $cat->term_id ) ).'" title="'.esc_html( $cat->name ).'">'.esc_html( $cat->name ).'</a></h2>';
					
					echo '<span class="gmr-movie-on">' .intval( $cat->count ).' ' . __( 'Movies', 'muvipro' ) . '</span>';
					
					echo term_description( $cat_id, 'muviindex' );
					
					echo '</div>';
					
					// create a custom wordpress query
					query_posts( array (
						'post_type' => array ( 'post', 'tv' ),
						'post_status' => 'publish',
						'posts_per_page' => 5,
						'tax_query' => array(
							array(
								'taxonomy' => 'muviindex',
								'field' => 'term_id',
								'terms' => $cat_id,
							)
						),
						'paged' => $paged 
						) 
					);
					
					echo '<ul>';
					/* Start the Loop */
					while ( have_posts() ) : the_post();
						?>
						<li>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo _e( 'Permanent Link to', 'muvipro' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</li>
						<?php
					endwhile;
					echo '</ul>';
			
				echo '</div>';
			
			if ( $i%2 == 0 ) :
				echo '<div class="clearfix"></div>';
			endif;
			$i++;
			
		}
		
		echo '</div><!-- .row -->';

	} else {
		echo '<h2>' . __( 'Sorry, no movie were found!', 'muvipro' ) . '</h2>';
	}
	?>
	</main><!-- #main -->
</div><!-- #primary -->
 
<?php 
if ( $sidebar_layout == 'sidebar' ) {
	get_sidebar(); 
}
	
get_footer();