<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Mona
 */

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