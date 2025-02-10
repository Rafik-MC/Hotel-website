<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</header><!-- .page-header -->

					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'excerpt' );

					endwhile;

					echo MonaWP\Builder\Elements::html_wrapper(MonaWP\Builder\Elements::monawp_custom_pagination_element()['html'], 'monawp_custom_pagination_element');

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>

			</main><!-- #main -->
		</div>
		<?php get_sidebar('right'); ?>
	</div>
<?php
get_footer();
?>