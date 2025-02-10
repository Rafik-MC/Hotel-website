<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Mona
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>
	<div class="main-site-wrapper">
		<?php get_sidebar('left'); ?>
		<div class="main-content-wrapper">
			<main id="primary" class="site-main" role="main">
				<section class="error-404 not-found">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'monawp' ); ?></h1>
					</header><!-- .page-header -->
				</section><!-- .error-404 -->
				<?php get_search_form(); ?>
			</main><!-- #main -->
		</div>
		<?php get_sidebar('right'); ?>
	</div>
<?php
get_footer();
?>