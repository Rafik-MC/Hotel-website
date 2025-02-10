<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mona
 */
 
use MonaWP\Resources\Helpers as Helpers; 
use MonaWP\Builder\Elements as Elements; 
 
global $monawp_sidebar_ids;
$show_sidebar = false;

foreach ($monawp_sidebar_ids['right'] as $name => $sidebar_id) {
	if ( Helpers::showSidebar($sidebar_id) ) {
		$show_sidebar = true;
	}
}

if (!$show_sidebar) {
	return;
}


// Retrieve the current post/page ID
$post_id = get_the_ID();

// Retrieve the sidebar layout setting for the current post/page
$singular_layout_option = get_post_meta($post_id, '_monawp_sidebar_layout', true);

// Check if the layout option is set to inherit
if (!$singular_layout_option || $singular_layout_option == 'Inherit') {
    // Use the global or default sidebar layout if inherited
    $layout_option = Helpers::getSidebarLayout();
} else {
	$layout_option = $singular_layout_option;
}

if ($layout_option == "2 Columns - Right Sidebar" or $layout_option == "3 Columns") : ?>

	<div class="right-sidebar-wrapper">
		<aside role="complementary" <?php echo MonaWP\Resources\Schema::getPart('sidebar'); ?> id="monawp-right-sidebar" class="widget-area">
				<?php echo Elements::html_wrapper(Elements::monawp__sidebar_widget__element('right')['html'], 'widget__element'); ?>
		</aside><!-- #secondary -->
	</div>

<?php endif; ?>