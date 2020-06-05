<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<section class="no-results not-found">
	<div class="gmr-box-content">
		<header class="entry-header">
			<h2 class="page-title" <?php echo muvipro_itemprop_schema( 'headline' ); ?>><?php esc_html_e( 'Nothing Found', 'muvipro' ); ?></h2>
		</header><!-- .page-header -->

		<div class="entry-content" <?php echo muvipro_itemprop_schema( 'text' ); ?>>
			<?php
			if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

				<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'muvipro' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

			<?php elseif ( is_search() ) : ?>

				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'muvipro' ); ?></p>
				<?php
					get_search_form();

			else : ?>

				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'muvipro' ); ?></p>
				<?php
					get_search_form();

			endif; ?>
		</div><!-- .page-content -->
	</div><!-- .gmr-box-content -->
</section><!-- .no-results -->
