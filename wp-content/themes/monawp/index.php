<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

				<?php
				if ( have_posts() ) :

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


				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>

			</main><!-- #main -->
			
			<?php echo MonaWP\Builder\Elements::html_wrapper(MonaWP\Builder\Elements::monawp_custom_pagination_element()['html'], 'monawp_custom_pagination_element'); ?>
		</div>
		<?php get_sidebar('right'); ?>
	</div>
<?php
get_footer();
?>