<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
				while ( have_posts() ) :
					the_post();
					
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile; // End of the loop.
				?>

			</main><!-- #main -->
		</div>
		<?php get_sidebar('right'); ?>
	</div>
<?php
get_footer();
?>