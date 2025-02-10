<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Mona
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
 
if ( ! function_exists( 'monawp_jetpack_setup' ) ) :
	function monawp_jetpack_setup() {
		// Add theme support for Infinite Scroll.
		add_theme_support(
			'infinite-scroll',
			array(
				'container' => 'primary',
				'render'    => 'monawp_infinite_scroll_render',
				'footer'    => 'colophon',
			)
		);

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );

		// Add theme support for Content Options.
		add_theme_support(
			'jetpack-content-options',
			array(
				'post-details' => array(
					'stylesheet' => 'monawp-style',
					'date'       => '.posted-on',
					'categories' => '.cat-links',
					'tags'       => '.tags-links',
					'author'     => '.byline',
					'comment'    => '.comments-link',
				),
				'featured-images' => array(
					'archive' => true,
					'post'    => true,
					'page'    => true,
				),
			)
		);
	}
	add_action( 'after_setup_theme', 'monawp_jetpack_setup' );
endif;

if ( ! function_exists( 'monawp_infinite_scroll_render' ) ) :
	/**
	 * Custom render function for Infinite Scroll.
	 */
	function monawp_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', 'excerpt' );
		}
	}
endif;
?>