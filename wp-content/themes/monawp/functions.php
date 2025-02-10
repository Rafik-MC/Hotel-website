<?php
/**
 * Mona functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Mona
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.5' );
}

require_once get_template_directory() . '/inc/resources.php'; // Generic resources
require_once get_template_directory() . '/inc/generator_elements.php'; // Single element settings
require_once get_template_directory() . '/inc/hooks.php'; //Various hooks
require_once get_template_directory() . '/inc/hook_constructor.php'; //Construct theme html/php layout based on theme mod set by admin builder form
require_once get_template_directory() . '/inc/css_constructor.php'; //Construct css based on generated hooks
require_once get_template_directory() . '/inc/css_filter.php'; //Final page based css filter after css is constructed 

use MonaWP\Builder\Elements as Elements;
use MonaWP\cssConstructor as cssConstructor;
use MonaWP\Resources\Helpers as Helpers; 
use MonaWP\Resources\Icons as Icons; 

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
 if ( ! function_exists( 'monawp_setup' ) ) {
	function monawp_setup() {
		/*
			* Make theme available for translation.
			* Translations can be filed in the /languages/ directory.
			* If you're building a theme based on Mona, use a find and replace
			* to change 'mona' to the name of your theme in all the template files.
			*/
		load_theme_textdomain( 'monawp', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
			* Let WordPress manage the document title.
			* By adding theme support, we declare that this theme does not use a
			* hard-coded <title> tag in the document head, and expect WordPress to
			* provide it for us.
			*/
		add_theme_support( 'title-tag' );

		/*
			* Enable support for Post Thumbnails on posts and pages.
			*
			* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			*/
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' ); // Enable support for responsive embedded
		add_image_size( 'monawp_small_thumbnail', 300, 200, true ); // Small thumbnail (300x300).
		add_image_size( 'monawp_medium_thumbnail', 720, 480, true ); // Medium thumbnail (720x480).
		add_image_size( 'monawp_large_thumbnail', 1280, 720, true ); 

		$monawp_register_menus = array();

		$monawp_register_menus['menu-horizontal-topbar'] = esc_html__('Horizontal (Topbar)', 'monawp');
		$monawp_register_menus['menu-horizontal-header'] = esc_html__('Horizontal (Header)', 'monawp');
		$monawp_register_menus['menu-horizontal-footer'] = esc_html__('Horizontal (Footer)', 'monawp');

		register_nav_menus($monawp_register_menus);

		/*
			* Switch default core markup for search form, comment form, and comments
			* to output valid HTML5.
			*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
	add_action( 'after_setup_theme', 'monawp_setup' );
}


if ( ! function_exists( 'monawp_custom_post_thumbnail_html' ) ) {
	
	function monawp_custom_post_thumbnail_html($size = 'monawp_medium_thumbnail', $lazy = true) {
		global $post;

		// Get the post thumbnail ID
		$post_thumbnail_id = get_post_thumbnail_id($post->ID);

		$post_thumbnail_url = $size === 'original' ? get_the_post_thumbnail_url($post->ID, 'full') : get_the_post_thumbnail_url($post->ID, $size);
		// Output custom HTML structure with post thumbnail
		if ($post_thumbnail_url) {
			// Start building the img tag
			$img_tag = '<img src="' . esc_url($post_thumbnail_url) . '" class="img-responsive wp-post-image"';

			// Add lazy loading attribute if $lazy is true
			if ($lazy) {
				$img_tag .= ' loading="lazy"';
			}

			// Get the width and height attributes of the post thumbnail
			$image_data = wp_get_attachment_image_src($post_thumbnail_id, $size);
			if ($image_data) {
				$width = $image_data[1];
				$height = $image_data[2];
				$img_tag .= sprintf(' width="%s" height="%s"', esc_attr($width), esc_attr($height));
			}

			// Get attachment metadata
			$alt_text = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);
			$title = get_the_title($post_thumbnail_id);
			$caption = wp_get_attachment_caption($post_thumbnail_id);
			$description = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);

			// Output alt text, title, caption, and description
			$img_tag .= sprintf(' alt="%s"', esc_attr($alt_text));
			$img_tag .= sprintf(' title="%s"', esc_attr($title));
			if ($caption) {
				$img_tag .= sprintf(' data-caption="%s"', esc_attr($caption));
			}
			if ($description) {
				$img_tag .= sprintf(' data-description="%s"', esc_attr($description));
			}

			// Close the image tag
			$img_tag .= '>';

			// Output the img tag
			echo $img_tag;
		}
	}
}

if ( ! function_exists( 'monawp_add_lazy_loading_attribute' ) ) {
	
	function monawp_add_lazy_loading_attribute($attr, $attachment, $size) {
		// Check if the attribute already exists
		if (!isset($attr['loading'])) {
			// Add the loading="lazy" attribute
			$attr['loading'] = 'lazy';
		}
		// Return the modified attributes
		return $attr;
	}

	// Hook the function to the wp_get_attachment_image_attributes filter
	add_filter('wp_get_attachment_image_attributes', 'monawp_add_lazy_loading_attribute', 10, 3);
}

if (get_theme_mod('monawp_disable_emojis', true)) {
	
	if ( ! function_exists( 'monawp_remove_wp_emoji' ) ) {
		function monawp_remove_wp_emoji() {
			// Remove emoji script
			remove_action('wp_head', 'print_emoji_detection_script', 7);
			remove_action('wp_print_styles', 'print_emoji_styles');
			remove_action('admin_print_scripts', 'print_emoji_detection_script');
			remove_action('admin_print_styles', 'print_emoji_styles');
		}
		add_action('init', 'monawp_remove_wp_emoji');
	}
	
}

$monawp_blocks_auto_enable_list = array(
'ultimate-addons-for-gutenberg/ultimate-addons-for-gutenberg.php',
'kadence-blocks/kadence-blocks.php',
'otter-blocks/otter-blocks.php',
'essential-blocks/essential-blocks.php',
'greenshift-animation-and-page-builder-blocks/plugin.php',
'coblocks/class-coblocks.php'
);

if (get_theme_mod('monawp_disable_block_styles', true) and !Helpers::arePluginsEnabled($monawp_blocks_auto_enable_list)) {
	if ( ! function_exists( 'monawp_defer_block_stylesheet' ) ) {
		function monawp_defer_block_stylesheet() {
			
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
			// Check if we are viewing a singular post
		}

		// Hook the function to the wp_enqueue_scripts action
		add_action('wp_enqueue_scripts', 'monawp_defer_block_stylesheet');
	}
}

if ( ! function_exists( 'monawp_widgets_init' ) ) {
	
	function monawp_widgets_init() {
		
			// Register topbar widgets
			$num_topbar_widgets = 3; // Number of topbar widgets
			for ( $i = 1; $i <= $num_topbar_widgets; $i++ ) {
				register_sidebar(
					array(
						'name'          => esc_html__( 'Topbar Widget', 'monawp' ),
						'id'            => 'topbar_widget_' . $i,
						'description'   => esc_html__( 'Select widgets to add to topbar.', 'monawp' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h4>',
						'after_title'   => '</h4>',
					)
				);
			}

			// Register header widgets
			$num_header_widgets = 3; // Number of header widgets
			for ( $i = 1; $i <= $num_header_widgets; $i++ ) {
				register_sidebar(
					array(
						'name'          => esc_html__( 'Header Widget', 'monawp' ),
						'id'            => 'header_widget_' . $i,
						'description'   => esc_html__( 'Select widgets to add to header.', 'monawp' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h4>',
						'after_title'   => '</h4>',
					)
				);
			}
			
			$sidebars = array(
				array(
					'name'          => esc_html__( 'Left Sidebar Widget', 'monawp' ),
					'id'            => 'left_sidebar_widget_one',
					'description'   => esc_html__( 'Select widgets to add to left sidebar (global).', 'monawp' ),
				),
				array(
					'name'          => esc_html__( 'Left Sidebar Widget Single Post', 'monawp' ),
					'id'            => 'left_sidebar_widget_single_post',
					'description'   => esc_html__( 'Select widgets to add to left sidebar for single posts (overrides global).', 'monawp' ),
				),
				array(
					'name'          => esc_html__( 'Left Sidebar Widget Archive', 'monawp' ),
					'id'            => 'left_sidebar_widget_archive',
					'description'   => esc_html__( 'Select widgets to add to left sidebar for archives (overrides global).', 'monawp' ),
				),
				array(
					'name'          => esc_html__( 'Left Sidebar Widget Search', 'monawp' ),
					'id'            => 'left_sidebar_widget_search',
					'description'   => esc_html__( 'Select widgets to add to left sidebar for search results (overrides global).', 'monawp' ),
				),
				array(
					'name'          => esc_html__( 'Right Sidebar Widget', 'monawp' ),
					'id'            => 'right_sidebar_widget_one',
					'description'   => esc_html__( 'Select widgets to add to right sidebar (global).', 'monawp' ),
				),
				array(
					'name'          => esc_html__( 'Right Sidebar Widget Single Post', 'monawp' ),
					'id'            => 'right_sidebar_widget_single_post',
					'description'   => esc_html__( 'Select widgets to add to right sidebar for single posts (overrides global).', 'monawp' ),
				),
				array(
					'name'          => esc_html__( 'Right Sidebar Widget Archive', 'monawp' ),
					'id'            => 'right_sidebar_widget_archive',
					'description'   => esc_html__( 'Select widgets to add to right sidebar for archives (overrides global).', 'monawp' ),
				),
				array(
					'name'          => esc_html__( 'Right Sidebar Widget Search', 'monawp' ),
					'id'            => 'right_sidebar_widget_search',
					'description'   => esc_html__( 'Select widgets to add to right sidebar for search results (overrides global).', 'monawp' ),
				),
			);

			foreach ($sidebars as $sidebar) {
				register_sidebar(
					array(
						'name'          => $sidebar['name'],
						'id'            => $sidebar['id'],
						'description'   => $sidebar['description'],
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h4>',
						'after_title'   => '</h4>',
					)
				);
			}

			// Register footer widgets
			$num_footer_widgets = 4; // Number of footer widgets
			for ( $i = 1; $i <= $num_footer_widgets; $i++ ) {
				register_sidebar(
					array(
						'name'          => esc_html__( 'Footer Widget', 'monawp' ),
						'id'            => 'footer_widget_' . $i,
						'description'   => esc_html__( 'Select widgets to add to footer.', 'monawp' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h4>',
						'after_title'   => '</h4>',
					)
				);
			}

	}
	
	add_action( 'widgets_init', 'monawp_widgets_init' );
	
}

if ( ! function_exists( 'monawp_add_sidebar_layout_meta_box' ) ) {

	function monawp_add_sidebar_layout_meta_box() {
		add_meta_box(
			'monawp_sidebar_layout',
			__( 'Layout', 'monawp' ),
			'monawp_sidebar_layout_meta_box_callback',
			['post', 'page'],
			'side',
			'default'
		);
	}
	add_action( 'add_meta_boxes', 'monawp_add_sidebar_layout_meta_box' );

}

if ( ! function_exists( 'monawp_sidebar_layout_meta_box_callback' ) ) {

	function monawp_sidebar_layout_meta_box_callback( $post ) {
		global $monawp_sidebar_layout_options;
		global $monawp_header_positions;
		
		// Retrieve the current meta values
		$selected_layout = get_post_meta( $post->ID, '_monawp_sidebar_layout', true );
		$disable_header = get_post_meta( $post->ID, '_monawp_disable_header', true );
		$disable_footer = get_post_meta( $post->ID, '_monawp_disable_footer', true );
		$enable_transparent_header = get_post_meta( $post->ID, '_monawp_enable_transparent_header', true );
		$header_position = get_post_meta( $post->ID, '_monawp_header_position', true );

		// Add a nonce field for security
		wp_nonce_field( 'monawp_save_sidebar_layout', 'monawp_sidebar_layout_nonce' );

		// Create the select control for sidebar layout
		echo '<p class="post-attributes-label-wrapper parent-id-label-wrapper"><label class="post-attributes-label">' . __( 'Select Sidebar Layout', 'monawp' ) . '</label></p>';
		echo '<select name="monawp_sidebar_layout" id="monawp_sidebar_layout">';
		foreach ( $monawp_sidebar_layout_options as $key => $value ) {
			echo '<option value="' . esc_attr( $key ) . '"' . selected( $selected_layout, $key, false ) . '>' . esc_html( $value ) . '</option>';
		}
		echo '</select>';

		// Create checkboxes for the additional options
		echo '<p style="margin-top:15px;"><label for="monawp_disable_header">';
		echo '<input type="checkbox" name="monawp_disable_header" id="monawp_disable_header" value="1"' . checked( $disable_header, '1', false ) . ' />';
		echo __( 'Disable Header & Topbar', 'monawp' ) . '</label></p>';

		echo '<p><label for="monawp_disable_footer">';
		echo '<input type="checkbox" name="monawp_disable_footer" id="monawp_disable_footer" value="1"' . checked( $disable_footer, '1', false ) . ' />';
		echo __( 'Disable Footer', 'monawp' ) . '</label></p>';

		echo '<p style="margin-bottom:15px;" ><label for="monawp_enable_transparent_header">';
		echo '<input type="checkbox" name="monawp_enable_transparent_header" id="monawp_enable_transparent_header" value="1"' . checked( $enable_transparent_header, '1', false ) . ' />';
		echo __( 'Enable Transparent Header', 'monawp' ) . '</label></p>';
		
		// Create the select control for header positions
		echo '<p style="margin-right:20px;" class="post-attributes-label-wrapper parent-id-label-wrapper"><label class="post-attributes-label">' . __( 'Header Position', 'monawp' ) . '</label></p>';
		echo '<select style="margin-bottom:5px;" name="monawp_header_position" id="monawp_header_position">';
		foreach ( $monawp_header_positions as $key => $value ) {
			echo '<option value="' . esc_attr( $key ) . '"' . selected( $header_position, $key, false ) . '>' . esc_html( $value ) . '</option>';
		}
		echo '</select>';
		
	}

}

if ( ! function_exists( 'monawp_save_sidebar_layout_meta_box_data' ) ) {

	function monawp_save_sidebar_layout_meta_box_data( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['monawp_sidebar_layout_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['monawp_sidebar_layout_nonce'], 'monawp_save_sidebar_layout' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		// Save the sidebar layout
		if ( isset( $_POST['monawp_sidebar_layout'] ) ) {
			$sidebar_layout = sanitize_text_field( $_POST['monawp_sidebar_layout'] );
			update_post_meta( $post_id, '_monawp_sidebar_layout', $sidebar_layout );
		}

		// Save the disable header option
		$disable_header = isset( $_POST['monawp_disable_header'] ) ? '1' : '';
		update_post_meta( $post_id, '_monawp_disable_header', $disable_header );

		// Save the disable footer option
		$disable_footer = isset( $_POST['monawp_disable_footer'] ) ? '1' : '';
		update_post_meta( $post_id, '_monawp_disable_footer', $disable_footer );

		// Save the enable transparent header option
		$enable_transparent_header = isset( $_POST['monawp_enable_transparent_header'] ) ? '1' : '';
		update_post_meta( $post_id, '_monawp_enable_transparent_header', $enable_transparent_header );
		
		// Save the header position option
		if ( isset( $_POST['monawp_header_position'] ) ) {
			$header_position = sanitize_text_field( $_POST['monawp_header_position'] );
			update_post_meta( $post_id, '_monawp_header_position', $header_position );
		}
	}
	add_action( 'save_post', 'monawp_save_sidebar_layout_meta_box_data' );

}

if ( ! function_exists( 'monawp_get_sidebar_layout' ) ) {

	function monawp_get_sidebar_layout( $post_id ) {
		$sidebar_layout = get_post_meta( $post_id, '_monawp_sidebar_layout', true );

		// If no layout is set or it's 'Inherit', use a default or global option.
		if ( ! $sidebar_layout || $sidebar_layout == 'Inherit' ) {
			// Define your default or global option here
			$sidebar_layout = 'default-layout';
		}

		return $sidebar_layout;
	}

}

/**
 * Sanitize color input as either RGBA or HEX.
 *
 * @param string $color Color value to sanitize.
 * @return string Sanitized color value.
 */
 
if ( ! function_exists( 'monawp_sanitize_rgba_color' ) ) {
	
	function monawp_sanitize_rgba_color( $color ) {
		// Check if the color is in RGBA format
		if ( preg_match( '/^rgba\(\s*\d+\s*,\s*\d+\s*,\s*\d+\s*,\s*(0|1|0?\.\d+)\s*\)$/', $color ) ) {
			return $color; // Return the validated RGBA color
		} else {
			// If not in RGBA format, sanitize as HEX using WordPress default function
			return sanitize_hex_color( $color );
		}
	}

}

/**
 * Enqueue scripts and styles.
 */
 
if ( ! function_exists( 'monawp_theme_scripts' ) ) {
	function monawp_theme_scripts() {
		wp_enqueue_script('monawp-javascript-min', get_template_directory_uri() . '/js/monawp-javascript.min.js', array(), _S_VERSION, true);
		
		if (!is_admin() and !is_customize_preview()) {
			wp_dequeue_script('jquery');
		}
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'monawp_theme_scripts' );
}

//print_r(get_theme_mods());

global $monawp_structure_prefixes_array;

foreach ($monawp_structure_prefixes_array as $prefix) {
	add_action('monawp_'.$prefix, function () use ($prefix) {
		\MonaWP\hookConstructor::constructWithSequence($prefix);
	});
}

$layout_id_singular = 'main_content_singular_1';

add_action('monawp_main_content_singular', function () use ($layout_id_singular) {
	\MonaWP\hookConstructor::constructPredefined($layout_id_singular, false);
});

global $monawp_customizer_defaults;

$layout_id = get_theme_mod('monawp_blog_panel_main_content_article_layout',$monawp_customizer_defaults['monawp_main_content_article_layout']);
add_action('monawp_main_content', function () use ($layout_id) {
	\MonaWP\hookConstructor::constructPredefined($layout_id, true);
});

require get_template_directory() . '/inc/Widgets/toc_widget.php';
require get_template_directory() . '/inc/Widgets/element_widget.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

function monawp_reset_theme_mods_to_defaults() {
    remove_theme_mods();
}
//add_action('init', 'monawp_reset_theme_mods_to_defaults');

require get_template_directory() . '/inc/block_patterns.php';

/**
 * Customizer additions.
 */

if ( is_customize_preview() ) {
	require_once get_template_directory() . '/inc/customizer_extensions.php';
}
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

?>