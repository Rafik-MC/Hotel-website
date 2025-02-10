<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Mona
 */

get_header();
?>
	<div class="main-site-wrapper">
		<?php get_sidebar('left'); ?>
		<div class="main-content-wrapper">
			<main id="primary" class="site-main" role="main">

				<?php if ( have_posts() ) : ?>
					
					<div class="page-header-wrapper">
						<header class="page-header">
							<h1 class="page-title">
								<?php
								// Retrieve the customizer setting value
								$custom_title = get_theme_mod('monawp_search_panel_layout_page_title', $monawp_item_titles['search_page']);
								
								/* translators: 1. Custom title from the customizer, 2. Search query */
								printf(esc_html__('%1$s %2$s', 'monawp'), esc_html($custom_title), '<span>' . esc_html(get_search_query()) . '</span>');
								?>
							</h1>
						</header><!-- .page-header -->
					</div>
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
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