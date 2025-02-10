<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Mona Theme Customizer
 *
 * @package Mona
 */

use MonaWP\Customizer\RGBA_Color_Picker as RGBA_Color_Picker;
use MonaWP\Resources\Helpers as Helpers; 
use MonaWP\Resources\Icons as Icons; 
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
 
if ( ! function_exists( 'monawp_customize_preview_addons' ) ) {
	function monawp_customize_preview_addons() {
		wp_enqueue_script('monawp-rgb-color-picker-js', get_template_directory_uri() . '/js/alpha-color-picker.js', array('jquery', 'wp-color-picker'), _S_VERSION, true);
		wp_enqueue_style('monawp-rgb-color-picker-css', get_template_directory_uri() . '/css/alpha-color-picker.css', array('wp-color-picker'), _S_VERSION);
		wp_enqueue_script( 'monawp-customize-controls-js', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
		
		// Pass template directory URI to frontend script
		wp_localize_script('monawp-customize-controls-js', 'monawp_customizer_vars', array(
			'templateDirectoryUri' => get_template_directory_uri()
		));
		
	}
	add_action('customize_controls_enqueue_scripts', 'monawp_customize_preview_addons');
}

if (is_customize_preview()) {
	if (!function_exists('monawp_enqueue_customizer_css_in_footer')) {
		function monawp_enqueue_customizer_css_in_footer() {
			wp_enqueue_style('monawp-customizer-css', get_template_directory_uri() . '/css/customizer.css', array(), null, 'all');
		}

		add_action('wp_footer', 'monawp_enqueue_customizer_css_in_footer');
	}
}

if (!function_exists('monawp_customize_register_panels')) {
	function monawp_customize_register_panels( $wp_customize ) {
		
		/**
		 * Customizer Panels
		 *
		 * This array defines the customizer panels.
		*/
		 
		$customizer_panels = array(
			array('id' => 'presets', 'label' => __( 'Presets', 'monawp' ), 'description' => __( 'Premade customizer options.', 'monawp' ), 'priority' => 1),
			array('id' => 'global', 'label' => __( 'Global', 'monawp' ), 'description' => __( 'Global customizer settings.', 'monawp' ), 'priority' => 1),
			array('id' => 'socials', 'label' => __( 'Socials', 'monawp' ), 'description' => __( 'Personal info settings.', 'monawp' ), 'priority' => 1),
			array('id' => 'elements', 'label' => __( 'Elements', 'monawp' ), 'description' => __( 'Element settings.', 'monawp' ), 'priority' => 1),
			array('id' => 'topbar', 'label' => __( 'Topbar', 'monawp' ), 'description' => __( 'Topbar customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'header', 'label' => __( 'Header', 'monawp' ), 'description' => __( 'Header customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'left_sidebar', 'label' => __( 'Left Sidebar', 'monawp' ), 'description' => __( 'Left sidebar customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'main_content', 'label' => __( 'Main Content', 'monawp' ), 'description' => __( 'Main content customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'right_sidebar', 'label' => __( 'Right Sidebar', 'monawp' ), 'description' => __( 'Right sidebar customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'blog', 'label' => __( 'Blog', 'monawp' ), 'description' => __( 'Blog customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'single_post', 'label' => __( 'Single Post', 'monawp' ), 'description' => __( 'Single Post customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'page', 'label' => __( 'Page', 'monawp' ), 'description' => __( 'Page customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'archive', 'label' => __( 'Archive', 'monawp' ), 'description' => __( 'Archive customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => '404', 'label' => __( '404 Page', 'monawp' ), 'description' => __( '404 Page customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'search', 'label' => __( 'Search', 'monawp' ), 'description' => __( 'Search customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'footer', 'label' => __( 'Footer', 'monawp' ), 'description' => __( 'Footer customizer settings.', 'monawp' ), 'priority' => 100),
			array('id' => 'plugins', 'label' => __( 'Plugins', 'monawp' ), 'description' => __( 'Plugin custom CSS & more.', 'monawp' ), 'priority' => 100),
		);
		
		/**
		 * Customizer sections
		 *
		 * This array defines the customizer sections.
		*/
		
		$sections = array(
			array('slug' => 'global', 'label' => __( 'Global', 'monawp' ), 'description' => __( 'Global settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'social_media', 'label' => __( 'Social Media Profiles', 'monawp' ), 'description' => __( 'Add social media profiles.', 'monawp' ), 'priority' => 100),
			array('slug' => 'generic_info', 'label' => __( 'Phone & Email', 'monawp' ), 'description' => __( 'Add personal/business information.', 'monawp' ), 'priority' => 100),
			array('slug' => 'header', 'label' => __( 'Header', 'monawp' ), 'description' => __( 'Header settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'colors', 'label' => __( 'Colors & Style', 'monawp' ), 'description' => __( 'Color customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'typography', 'label' => __( 'Typography', 'monawp' ), 'description' => __( 'Typography customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'layout', 'label' => __( 'Layout', 'monawp' ), 'description' => __( 'Layout customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'builder', 'label' => __( 'Builder', 'monawp' ), 'description' => __( 'Section builder.', 'monawp' ), 'priority' => 100),
			array('slug' => 'breadcrumbs', 'label' => __( 'Breadcrumbs', 'monawp' ), 'description' => __( 'Breadcrumb customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'post_meta', 'label' => __( 'Post meta', 'monawp' ), 'description' => __( 'Post meta customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'share_box', 'label' => __( 'Share Box', 'monawp' ), 'description' => __( 'Share box customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'body', 'label' => __( 'Body', 'monawp' ), 'description' => __( 'Body customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'related_posts', 'label' => __( 'Related Posts', 'monawp' ), 'description' => __( 'Related posts customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'article', 'label' => __( 'Article', 'monawp' ), 'description' => __( 'Article customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'main_site_wrapper', 'label' => __( 'Main Site Wrapper', 'monawp' ), 'description' => __( 'Site wrapper customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'buttons', 'label' => __( 'Buttons', 'monawp' ), 'description' => __( 'Button customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'inputs', 'label' => __( 'Inputs & Textarea', 'monawp' ), 'description' => __( 'Input customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'element_wrapper', 'label' => __( 'Element Wrapper', 'monawp' ), 'description' => __( 'Element wrapper customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'a_tag', 'label' => __( 'Links', 'monawp' ), 'description' => __( 'Link customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'body', 'label' => __( 'Body', 'monawp' ), 'description' => __( 'Body customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'horizontal_menu', 'label' => __( 'Horizontal Menu', 'monawp' ), 'description' => __( 'Horizontal menu customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'widget', 'label' => __( 'Sidebar & Footer Widgets', 'monawp' ), 'description' => __( 'Sidebar & footer widget customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'scroll_to_top', 'label' => __( 'Scroll To Top', 'monawp' ), 'description' => __( 'Scroll to top button customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'table_head', 'label' => __( 'Table Head (thead)', 'monawp' ), 'description' => __( 'Table head customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'table', 'label' => __( 'Table', 'monawp' ), 'description' => __( 'Table customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'blockquote', 'label' => __( 'Blockquote', 'monawp' ), 'description' => __( 'Blockquote customizer settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'comments', 'label' => __( 'Comments', 'monawp' ), 'description' => __( 'Comments settings.', 'monawp' ), 'priority' => 100),
			array('slug' => 'custom_css', 'label' => __( 'Custom CSS', 'monawp' ), 'description' => __( 'Custom CSS.', 'monawp' ), 'priority' => 100)
		);

		foreach ( $customizer_panels as $panel ) {
			$panel_id = 'monawp_'.$panel['id'].'_panel';

			// Add panel
			$wp_customize->add_panel(
				$panel_id,
				array(
					'title' => $panel['label'],
					'description' => $panel['description'],
					'priority' => $panel['priority'],
				)
			);

			// Add sections to panel
			foreach ($sections as $section) {
				$section_id = $panel_id . '_' . $section['slug'];

				// Add section
				$wp_customize->add_section(
					$section_id,
					array(
						'title' => $section['label'],
						'description' => $section['description'],
						'priority' => $section['priority'],
						'panel' => $panel_id,
					)
				);
			}
		}
		
		$wp_customize->add_section('monawp_performance_section', array(
			'title' => __('Performance & SEO', 'monawp'),
			'description' => __('Website loading speed & performance settings.', 'monawp'),
			'priority' => 100,
		));
		
	}
	add_action( 'customize_register', 'monawp_customize_register_panels' );
}
if (!function_exists('monawp_customize_register')) {
	function monawp_customize_register($wp_customize)
	{

		global $monawp_customizer_defaults;
		global $monawp_system_fonts;
		global $monawp_color_visited_profiles;
		global $monawp_color_background_profiles;
		global $monawp_color_css_variables;
		global $monawp_border_style_profiles;
		global $monawp_border_bottom_style_profiles;
		global $monawp_box_shadow_style_profiles;
		global $monawp_structure_defaults;
		global $monawp_structure_prefixes_array;
		global $monawp_default_layouts_array;
		global $monawp_pages_with_sidebars, $monawp_sidebar_layout_options;
		global $monawp_sharebox_defaults;
		global $monawp_page_slugs;
		global $monawp_flex_direction_options;
		global $monawp_justify_content_options;
		global $monawp_custom_plugin_default_css;
		global $monawp_only_background_profiles;
		
		// Define default color settings
		$default_colors = array(
			'monawp-main-color' => $monawp_customizer_defaults["monawp-main-color"],
			'monawp-secondary-color' => $monawp_customizer_defaults["monawp-secondary-color"],
			'monawp-special-color' => $monawp_customizer_defaults["monawp-special-color"],
			'monawp-special-secondary-color' => $monawp_customizer_defaults["monawp-special-secondary-color"],
			'monawp-special-contrast-color' => $monawp_customizer_defaults["monawp-special-contrast-color"],
			'monawp-main-contrast-color' => $monawp_customizer_defaults["monawp-main-contrast-color"],
			'monawp-secondary-contrast-color' => $monawp_customizer_defaults["monawp-secondary-contrast-color"],
			'monawp-tertiary-contrast-color' => $monawp_customizer_defaults["monawp-tertiary-contrast-color"]
		);
		
		// Add setting for color palette select input
		$wp_customize->add_setting('monawp_global_color_palette_select', array(
			'default' => 'default',
			'sanitize_callback' => 'sanitize_text_field', // Sanitize function for the select input
		));

		$color_choices = array(
			'default' => '0',
		);

		for ($i = 1; $i <= 250; $i++) {
			$color_choices[$i] = (string)$i;
		}

		$wp_customize->add_control('monawp_global_color_palette_select', array(
			'type' => 'select',
			'label' => 'Color Palette',
			'section' => 'monawp_global_panel_colors',
			'choices' => $color_choices,
		));
		
		$options_preset_choices = array(
			'0' => '0',
		);
		
		for ($i = 0; $i <= 180; $i++) {
			$options_preset_choices[$i] = (string)$i;
		}
		
		// Add setting for color palette select input
		$wp_customize->add_setting('monawp_presets_panel_global_preset_select', array(
			'default' => '0',
			'sanitize_callback' => 'sanitize_text_field', // Sanitize function for the select input
		));

		$wp_customize->add_control('monawp_presets_panel_global_preset_select', array(
			'type' => 'select',
			'label' => __('Options Preset', 'monawp'),
			'description' => __('Choose from premade set of customizer options. Each option has optimal color combinations with contrast scores above 5.0, unique spacing, fonts, & other settings.', 'monawp'),
			'section' => 'monawp_presets_panel_global',
			'choices' => $options_preset_choices,
		));
		
		$header_preset_choices = array(
			'0' => '0',
		);
		
		for ($i = 0; $i <= 11; $i++) {
			$header_preset_choices[$i] = (string)$i;
		}
		
		// Add setting for color palette select input
		$wp_customize->add_setting('monawp_presets_panel_header_preset_select', array(
			'default' => '0',
			'sanitize_callback' => 'sanitize_text_field', // Sanitize function for the select input
		));

		$wp_customize->add_control('monawp_presets_panel_header_preset_select', array(
			'type' => 'select',
			'label' => __('Header Preset', 'monawp'),
			'description' => __('Select a header layout preset.', 'monawp'),
			'section' => 'monawp_presets_panel_header',
			'choices' => $header_preset_choices,
		));

		// Loop through default colors to add settings and controls
		foreach ($default_colors as $setting_name => $default_value) {
			// Add setting
			$wp_customize->add_setting($setting_name, array(
				'default' => $default_value,
				'type'        => 'theme_mod',
				'capability'  => 'edit_theme_options',
				'sanitize_callback' => 'monawp_sanitize_rgba_color',
			));

			// Add control
			$wp_customize->add_control(new RGBA_Color_Picker($wp_customize, $setting_name, array(
				'label' => ucwords(str_replace('-', ' ', $setting_name)),
				'section' => 'monawp_global_panel_colors',
				'settings' => $setting_name,
				'show_opacity'  => true, // Optional.
				'palette'	=> array(
					$monawp_customizer_defaults["monawp-main-color"], 
					$monawp_customizer_defaults["monawp-secondary-color"],
					$monawp_customizer_defaults["monawp-special-color"], 
					$monawp_customizer_defaults["monawp-main-contrast-color"] 
				),
			)));
		}
		
		
		
		// Unregister default color settings and controls
		$wp_customize->remove_setting('background_color');
		$wp_customize->remove_control('background_color');
		// Remove default "Colors" section
		$wp_customize->remove_section('colors');
		
		// Add select controls for main font and headers font
		$wp_customize->add_setting('monawp-html-font-family', array(
			'default' => $monawp_customizer_defaults["monawp-html-font-family"],
			'sanitize_callback' => 'sanitize_text_field',
		));
		
		$wp_customize->add_control('monawp-html-font-family', array(
			'type' => 'select',
			'label' => __('HTML Font', 'monawp'),
			'section' => 'monawp_global_panel_typography', // Change to appropriate section
			'choices' => $monawp_system_fonts,
			'priority' => 30, // Adjust the priority as needed
		));
		
		// Add range control for font size
		$wp_customize->add_setting('monawp-html-font-size', array(
			'default' => $monawp_customizer_defaults["monawp-html-font-size"],
			'sanitize_callback' => array( 'MonaWP\Resources\Sanitize', 'float' ),
		));

		$wp_customize->add_control('monawp-html-font-size', array(
			'type' => 'range',
			'label' => __('HTML Font Size', 'monawp'),
			'section' => 'monawp_global_panel_typography', // Change to appropriate section
			'input_attrs' => array(
				'min' => 16,
				'max' => 30,
				'step' => 0.1,
			),
			'priority' => 30, // Adjust the priority as needed
		));
		
		// Add range control for font size
		$wp_customize->add_setting('monawp-html-line-height', array(
			'default' => $monawp_customizer_defaults["monawp-html-line-height"],
			'sanitize_callback' => array( 'MonaWP\Resources\Sanitize', 'float' ), // Sanitize as integer
		));

		$wp_customize->add_control('monawp-html-line-height', array(
			'type' => 'range',
			'label' => __('HTML Line Height', 'monawp'),
			'section' => 'monawp_global_panel_typography', // Change to appropriate section
			'input_attrs' => array(
				'min' => 1.2,
				'max' => 1.8,
				'step' => 0.01,
			),
			'priority' => 30, // Adjust the priority as needed
		));

		$wp_customize->add_setting('monawp-headers-font-family', array(
			'default' => $monawp_customizer_defaults["monawp-headers-font-family"],
			'sanitize_callback' => 'sanitize_text_field',
		));
		
		$wp_customize->add_control('monawp-headers-font-family', array(
			'type' => 'select',
			'label' => __('Headers Font', 'monawp'),
			'section' => 'monawp_global_panel_typography', // Change to appropriate section
			'choices' => $monawp_system_fonts,
			'priority' => 40, // Adjust the priority as needed
		));
		
		$wp_customize->add_setting('monawp-headers-line-height', array(
			'default' => $monawp_customizer_defaults["monawp-headers-line-height"],
			'sanitize_callback' => array( 'MonaWP\Resources\Sanitize', 'float' ), // Sanitize as integer
		));

		$wp_customize->add_control('monawp-headers-line-height', array(
			'type' => 'range',
			'label' => __('Headers Line Height', 'monawp'),
			'section' => 'monawp_global_panel_typography', // Change to appropriate section
			'input_attrs' => array(
				'min' => 1.1,
				'max' => 1.2,
				'step' => 0.01,
			),
			'priority' => 40, // Adjust the priority as needed
		));

		foreach ($monawp_customizer_defaults["monawp_header_defaults"] as $heading => $settings) {
			// Letter Spacing Control
			$letter_spacing_setting_id = "monawp_global_{$heading}_letter_spacing";
			$wp_customize->add_setting($letter_spacing_setting_id, array(
				'default'           => $settings['letter-spacing'],
				'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'float'),
			));
			$wp_customize->add_control($letter_spacing_setting_id, array(
				'type'        => 'range',
				'section'     => 'monawp_global_panel_typography',
				'label'       => $settings['label'] . ' ' . __('Letter Spacing', 'monawp'),
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 1,
					'step' => 0.01,
				),
				'priority' => 40, // Adjust the priority as needed
			));

			// Font Size Control
			$font_size_setting_id = "monawp_global_{$heading}_font_size";
			$wp_customize->add_setting($font_size_setting_id, array(
				'default'           => $settings['font-size'],
				'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'float'),
			));
			$wp_customize->add_control($font_size_setting_id, array(
				'type'        => 'range',
				'section'     => 'monawp_global_panel_typography',
				'label'       => $settings['label'] . ' ' . __('Font Size', 'monawp'),
				'input_attrs' => array(
					'min'  => 1.2,
					'max'  => 5,
					'step' => 0.05,
				),
				'priority' => 40, // Adjust the priority as needed
			));
		}
		
		foreach ($monawp_structure_prefixes_array as $prefix) {
			$items = array_filter($monawp_structure_defaults, function($item) use ($prefix) {
				return $item['panel'] === $prefix;
			});

			$item_keys = array_keys($items);
			$key_count = 0;
			foreach ($item_keys as $key) {
				$title = $monawp_structure_defaults[$key]['title'];
				for ($i = 1; $i <= 2; $i++) {
					if (isset($monawp_default_layouts_array[$prefix][$key_count])) {
						$default_value = $monawp_default_layouts_array[$prefix][$key_count];
					} else {
						$default_value = '';
					}
					$wp_customize->add_setting('monawp_' . $prefix . '_panel_builder_' . $key_count, array(
						'default' => $default_value,
						'sanitize_callback' => 'sanitize_text_field',
					));

					$choices = array(
						'' => __('None', 'monawp'),
						'row-start' => __('Wrapper row', 'monawp'),
						'col-start' => __('Wrapper column', 'monawp'),
						'wrapper-end' => __('Wrapper end', 'monawp')
					);

					foreach ($item_keys as $item_key) {
						$choices[$item_key] = $monawp_structure_defaults[$item_key]['title'];
					}

					$wp_customize->add_control('monawp_' . $prefix . '_panel_builder_' . $key_count, array(
						'label' => __('Item', 'monawp'),
						'type' => 'select',
						'section' => 'monawp_' . $prefix . '_panel_builder',
						'choices' => $choices,
					));
					
					$key_count++;
				}
			}
		}
		
		// Get the social media icons array
		$social_icons = Icons::getIconArray('generic_social');

		// Loop through the social media icons array and add a setting for each
		foreach ($social_icons as $social_name => $social_icon) {
			$wp_customize->add_setting('monawp_social_profile_url_' . strtolower($social_name), array(
				'default' => '',
				'sanitize_callback' => 'sanitize_url',
			));

			// Add a control for each social media icon
			$wp_customize->add_control('monawp_social_profile_url_' . strtolower($social_name), array(
				'label' => $social_name,
				'section' => 'monawp_socials_panel_social_media',
				'type' => 'url',
			));
		}
		
		// Create sharebox settings
		foreach ($monawp_sharebox_defaults as $label => $default) {
			$setting_name = 'monawp_elements_panel_share_box_' . strtolower($label);
			$wp_customize->add_setting($setting_name, array(
				'default' => $default,
				'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
			));

			$wp_customize->add_control(new WP_Customize_Control($wp_customize, $setting_name, array(
				'label' => $label,
				'section' => 'monawp_elements_panel_share_box',
				'type' => 'checkbox',
			)));
		}
		
		foreach ( $monawp_pages_with_sidebars as $panel => $panel_name ) {
			$setting_name = 'monawp_' . $panel . '_panel_layout_sidebar_layout';
			
			if ($panel != 'global') {
				$wp_customize->add_setting( $setting_name, array(
					'default' => 'Inherit', // Default value is 'Inherit'
					'sanitize_callback' => 'sanitize_text_field',
				) );
			} else {
				$wp_customize->add_setting( $setting_name, array(
					'default' => $monawp_customizer_defaults['monawp_default_sidebar_layout'], // Default value is 'Inherit'
					'sanitize_callback' => 'sanitize_text_field',
				) );
			}
			
			if ($panel == 'global') {
				
				$monawp_sidebar_layout_options_global = array_slice($monawp_sidebar_layout_options, 1);
				
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $setting_name, array(
					'label' => __( 'Sidebar Layout', 'monawp' ) ,
					'section' => 'monawp_' . $panel . '_panel_layout',
					'settings' => $setting_name,
					'type' => 'select',
					'choices' => $monawp_sidebar_layout_options_global,
				) ) );
			} else {
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $setting_name, array(
					'label' => __( 'Sidebar Layout', 'monawp' ) ,
					'section' => 'monawp_' . $panel . '_panel_layout',
					'settings' => $setting_name,
					'type' => 'select',
					'choices' => $monawp_sidebar_layout_options,
				) ) );
			}
		}

		$wp_customize->add_setting('monawp_generic_info_email', array(
			'default' => $monawp_customizer_defaults["monawp_generic_info_email"],
			'sanitize_callback' => 'sanitize_email',
		));
		$wp_customize->add_control('monawp_generic_info_email', array(
			'label' => __('Email', 'monawp'),
			'section' => 'monawp_socials_panel_generic_info',
			'type' => 'text',
		));

		$wp_customize->add_setting('monawp_generic_info_phone', array(
			'default' => $monawp_customizer_defaults["monawp_generic_info_phone"],
			'sanitize_callback' => 'sanitize_text_field',
		));
		$wp_customize->add_control('monawp_generic_info_phone', array(
			'label' => __('Phone', 'monawp'),
			'section' => 'monawp_socials_panel_generic_info',
			'type' => 'text',
		));
		
		// Add setting to disable emojis
		$wp_customize->add_setting('monawp_disable_emojis', array(
			'default' => true,
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));
		// Add control to disable emojis
		$wp_customize->add_control('monawp_disable_emojis', array(
			'type' => 'checkbox',
			'label' => __('Disable Emojis', 'monawp'),
			'section' => 'monawp_performance_section',
			'priority' => 5,
		));

		// Add setting to disable block styles
		$wp_customize->add_setting('monawp_disable_block_styles', array(
			'default' => true,
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));
		// Add control to disable block styles
		$wp_customize->add_control('monawp_disable_block_styles', array(
			'type' => 'checkbox',
			'label' => __('Disable Block Styles', 'monawp'),
			'description' => __('This option will be set to false if "Spectra", "Kadence Blocks", and/or others are enabled.', 'monawp'),
			'section' => 'monawp_performance_section',
			'priority' => 10,
		));
		
		$wp_customize->add_setting('monawp_performance_section_enable_schema', array(
			'default' => false,
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));

		$wp_customize->add_control('monawp_performance_section_enable_schema', array(
			'label' => __('Enable SEO Schema', 'monawp'),
			'section' => 'monawp_performance_section',
			'type' => 'checkbox',
		));
		
		// Add setting for color profile select
		$wp_customize->add_setting('monawp_global_panel_a_tag_color_profile', array(
			'default' => $monawp_customizer_defaults["monawp_color_visited_profiles"], // Set default color profile
			'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
		));

		// Add control for color profile select
		$wp_customize->add_control('monawp_global_panel_a_tag_color_profile', array(
			'type' => 'select',
			'label' => __('Color Profile', 'monawp'),
			'section' => 'monawp_global_panel_a_tag',
			'choices' => array_keys($monawp_color_visited_profiles),
			'priority' => 20, // Adjust the priority as needed
		));
		
		$color_background_items = array(
			'horizontal_menu' => array (
				'panel' => 'global',
				'section' => 'horizontal_menu',
				'default' => $monawp_customizer_defaults['monawp_color_background_profiles_2'],
				'default_hover' => $monawp_customizer_defaults['monawp_color_background_profiles_hover_focus'],
			),
			'buttons' => array (
				'panel' => 'global',
				'section' => 'buttons',
				'default' => $monawp_customizer_defaults['monawp_color_background_profiles'],
				'default_hover' => $monawp_customizer_defaults['monawp_color_background_profiles_hover_focus'],
			),
			'table_head' => array (
				'panel' => 'global',
				'section' => 'table_head',
				'no_hover' => true,
				'default' => $monawp_customizer_defaults['monawp_color_background_profiles'],
				'default_hover' => $monawp_customizer_defaults['monawp_color_background_profiles_hover_focus'],
			),
			'blockquote' => array (
				'panel' => 'global',
				'section' => 'blockquote',
				'no_hover' => true,
				'default' => $monawp_customizer_defaults['monawp_color_background_profiles'],
				'default_hover' => $monawp_customizer_defaults['monawp_color_background_profiles_hover_focus'],
			),
			'inputs' => array (
				'panel' => 'global',
				'section' => 'inputs',
				'default' => $monawp_customizer_defaults['monawp_color_background_profiles'],
				'default_hover' => $monawp_customizer_defaults['monawp_color_background_profiles_hover_focus'],
			),
			'socials' => array (
				'panel' => 'socials',
				'section' => 'colors',
				'default' => $monawp_customizer_defaults['monawp_color_background_profiles_2'],
				'default_hover' => $monawp_customizer_defaults['monawp_color_background_profiles_hover_focus_2']
			),
			'topbar' => array (
				'panel' => 'topbar',
				'section' => 'colors',
				'no_hover' => true,
				'no_color' => true,
				'default' => $monawp_customizer_defaults['monawp_topbar_background_color_profile'],
			),
			'header' => array (
				'panel' => 'header',
				'section' => 'colors',
				'no_hover' => true,
				'no_color' => true,
				'default' => $monawp_customizer_defaults['monawp_header_background_color_profile'],
			),
			'footer' => array (
				'panel' => 'footer',
				'section' => 'colors',
				'no_hover' => true,
				'no_color' => true,
				'default' => $monawp_customizer_defaults['monawp_footer_background_color_profile'],
			),
			'left_sidebar' => array (
				'panel' => 'left_sidebar',
				'section' => 'colors',
				'no_hover' => true,
				'no_color' => true,
				'default' => $monawp_customizer_defaults['monawp_left_sidebar_background_color_profile'],
			),
			'right_sidebar' => array (
				'panel' => 'right_sidebar',
				'section' => 'colors',
				'no_hover' => true,
				'no_color' => true,
				'default' => $monawp_customizer_defaults['monawp_right_sidebar_background_color_profile'],
			),
			'main_content' => array (
				'panel' => 'main_content',
				'section' => 'colors',
				'no_hover' => true,
				'no_color' => true,
				'default' => $monawp_customizer_defaults['monawp_main_content_background_color_profile'],
			),
			'body' => array (
				'panel' => 'global',
				'section' => 'body',
				'no_hover' => true,
				'no_color' => true,
				'default' => $monawp_customizer_defaults['monawp_body_background_color_profile'],
			),
		);

		foreach ($color_background_items as $item => $array) {

			// Add setting for link color profile
			$wp_customize->add_setting('monawp_'.$array['panel'].'_panel_'.$item.'_color_background_profile', array(
				'default' => $array['default'],
				'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
			));
			
			if (!isset($array['no_color'])) {
				$label = __('Color & Background Color', 'monawp');
			} else {
				$label = __('Background Color', 'monawp');
			}

			if (!isset($array['no_color'])) {
				$wp_customize->add_control('monawp_'.$array['panel'].'_panel_'.$item.'_color_background_profile', array(
					'type' => 'select',
					'label' => $label,
					'section' => 'monawp_'.$array['panel'].'_panel_'.$array['section'],
					'choices' => array_keys($monawp_color_background_profiles),
					'priority' => 20, // Adjust the priority as needed
					
				));
			} else {
				$wp_customize->add_control('monawp_'.$array['panel'].'_panel_'.$item.'_color_background_profile', array(
					'type' => 'select',
					'label' => $label,
					'section' => 'monawp_'.$array['panel'].'_panel_'.$array['section'],
					'choices' => $monawp_only_background_profiles,
					'priority' => 20, // Adjust the priority as needed
					
				));
			}
			
			if (!isset($array['no_hover'])) {
			
				// Add setting for link color profile
				$wp_customize->add_setting('monawp_'.$array['panel'].'_panel_'.$item.'_color_background_profile_hover_focus', array(
					'default' => $array['default_hover'],
					'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
				));

				// Add control for link color profile select
				$wp_customize->add_control('monawp_'.$array['panel'].'_panel_'.$item.'_color_background_profile_hover_focus', array(
					'type' => 'select',
					'label' => __('Color/Background Style (Hover/Focus)', 'monawp'),
					'section' => 'monawp_'.$array['panel'].'_panel_'.$array['section'],
					'choices' => array_keys($monawp_color_background_profiles),
					'priority' => 20, // Adjust the priority as needed
				));

				// Add setting for enabling/disabling hover effect
				$wp_customize->add_setting('monawp_'.$array['panel'].'_panel_'.$item.'_hover_effect', array(
					'default' => $monawp_customizer_defaults['monawp_'.$array['panel'].'_panel_'.$item.'_hover_effect'], // Set default value to 1 (enabled)
					'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
				));

				// Add control for enabling/disabling hover effect
				$wp_customize->add_control('monawp_'.$array['panel'].'_panel_'.$item.'_hover_effect', array(
					'type' => 'checkbox',
					'label' => __('Enable Hover/Focus Effect', 'monawp'),
					'section' => 'monawp_'.$array['panel'].'_panel_'.$array['section'],
					'priority' => 30, // Adjust the priority as needed
				));
			
			}
			
		}
		
		//global $monawp_border_style_profiles;
		//global $monawp_border_bottom_style_profiles;

		$border_style_items = array(
			'buttons' => array(
				'panel' => 'global',
				'section' => 'buttons',
				'default' => $monawp_customizer_defaults['monawp_border_style_profiles'],
				'default_radius' => array(
					'top-left' => $monawp_customizer_defaults['monawp_buttons_border_radius'],
					'top-right' => $monawp_customizer_defaults['monawp_buttons_border_radius'],
					'bottom-left' => $monawp_customizer_defaults['monawp_buttons_border_radius'],
					'bottom-right' => $monawp_customizer_defaults['monawp_buttons_border_radius'],
				),
				'radius' => true,
			),
			'inputs' => array(
				'panel' => 'global',
				'section' => 'inputs',
				'default' => $monawp_customizer_defaults['monawp_border_style_profiles'],
				'default_radius' => array(
					'top-left' => $monawp_customizer_defaults['monawp_inputs_border_radius'],
					'top-right' => $monawp_customizer_defaults['monawp_inputs_border_radius'],
					'bottom-left' => $monawp_customizer_defaults['monawp_inputs_border_radius'],
					'bottom-right' => $monawp_customizer_defaults['monawp_inputs_border_radius'],
				),
				'radius' => true,
			),
			'body' => array(
				'panel' => 'global',
				'section' => 'body',
				'default' => $monawp_customizer_defaults['monawp_body_border_style_profiles'],
				'radius' => false,
			),
			'table' => array(
				'panel' => 'global',
				'section' => 'table',
				'default' => $monawp_customizer_defaults['monawp_body_border_style_profiles'],
				'radius' => false,
			),
			'socials' => array(
				'panel' => 'socials',
				'section' => 'colors',
				'default' => $monawp_customizer_defaults['monawp_border_style_profiles'],
				'default_radius' => array(
					'top-left' => $monawp_customizer_defaults['monawp_socials_border_radius'],
					'top-right' => $monawp_customizer_defaults['monawp_socials_border_radius'],
					'bottom-left' => $monawp_customizer_defaults['monawp_socials_border_radius'],
					'bottom-right' => $monawp_customizer_defaults['monawp_socials_border_radius'],
				),
				'radius' => true,
			),
		);

		foreach ($border_style_items as $item => $array) {

			// Add setting for border style profile
			$wp_customize->add_setting('monawp_' . $array['panel'] . '_panel_' . $item . '_border_style_profile', array(
				'default' => $array['default'], // Set default color profile to monawp_color_background_profiles
				'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
			));

			// Add control for border style profile select
			$wp_customize->add_control('monawp_' . $array['panel'] . '_panel_' . $item . '_border_style_profile', array(
				'type' => 'select',
				'label' => __('Border Style', 'monawp'),
				'description' => __('0 = no styling', 'monawp'),
				'section' => 'monawp_' . $array['panel'] . '_panel_' . $array['section'],
				'choices' => array_keys($monawp_border_style_profiles),
				'priority' => 30, // Adjust the priority as needed
			));

			if ($array['radius']) {

			// Add settings and controls for individual border radius
				foreach (array('top-left', 'top-right', 'bottom-left', 'bottom-right') as $side) {
					//echo 'monawp_' . $array['panel'] . '_panel_' . $item . '_border_radius_' . $side;
					// Add setting for border radius
					$wp_customize->add_setting('monawp_' . $array['panel'] . '_panel_' . $item . '_border_radius_' . $side, array(
						'default' => $array['default_radius'][$side], // Set default value for border radius
						'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'float'),
					));

					// Add control for border radius
					$wp_customize->add_control('monawp_' . $array['panel'] . '_panel_' . $item . '_border_radius_' . $side, array(
						'type' => 'range',
						// translators: %s is the position of the border radius (e.g., top-left, top-right, bottom-left, bottom-right)
						'label'       => sprintf(__('Border Radius %s', 'monawp'), str_replace('-', ' ', ucwords($side, '-'))),
						'section' => 'monawp_' . $array['panel'] . '_panel_' . $array['section'],
						'input_attrs' => array(
							'min' => 0,
							'max' => 2.5,
							'step' => 0.1,
						),
						'priority' => 31, // Adjust the priority as needed
					));
				}
			}
		}

		
		$border_bottom_style_items = array(
			'buttons' => array (
				'panel' => 'global',
				'section' => 'buttons',
				'default' => $monawp_customizer_defaults['monawp_border_bottom_style_profiles'],
			),
			'inputs' => array (
				'panel' => 'global',
				'section' => 'inputs',
				'default' => $monawp_customizer_defaults['monawp_border_bottom_style_profiles'],
			),
			'socials' => array (
				'panel' => 'socials',
				'section' => 'colors',
				'default' => $monawp_customizer_defaults['monawp_border_bottom_style_profiles'],
			),
		);
		
		foreach ($border_bottom_style_items as $item => $array) {

			// Add setting for link color profile
			$wp_customize->add_setting('monawp_'.$array['panel'].'_panel_'.$item.'_border_bottom_style_profile', array(
				'default' => $array['default'], // Set default color profile to monawp_color_background_profiles
				'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
			));

			// Add control for link color profile select
			$wp_customize->add_control('monawp_'.$array['panel'].'_panel_'.$item.'_border_bottom_style_profile', array(
				'type' => 'select',
				'label' => __('Bottom Border Style', 'monawp'),
				'description' => __('0 = no styling', 'monawp'),
				'section' => 'monawp_'.$array['panel'].'_panel_'.$array['section'],
				'choices' => array_keys($monawp_border_bottom_style_profiles),
				'priority' => 30, // Adjust the priority as needed
			));
			
		}
		
		$box_shadow_style_items = array(
			'buttons' => array (
				'panel' => 'global',
				'section' => 'buttons',
				'default' => $monawp_customizer_defaults['monawp_buttons_box_shadow_style_profiles'],
				'default_hover' => $monawp_customizer_defaults['monawp_buttons_box_shadow_style_profiles']
			),
			'inputs' => array (
				'panel' => 'global',
				'section' => 'inputs',
				'default' => $monawp_customizer_defaults['monawp_inputs_box_shadow_style_profiles'],
				'default_hover' => $monawp_customizer_defaults['monawp_inputs_box_shadow_style_profiles']
			),
			'socials' => array (
				'panel' => 'socials',
				'section' => 'colors',
				'default' => $monawp_customizer_defaults['monawp_socials_box_shadow_style_profiles'],
				'default_hover' => $monawp_customizer_defaults['monawp_buttons_box_shadow_style_profiles']
			),
		);
		
		foreach ($box_shadow_style_items as $item => $array) {

			// Add setting for link color profile
			$wp_customize->add_setting('monawp_'.$array['panel'].'_panel_'.$item.'_box_shadow_style_profile', array(
				'default' => $array['default'], // Set default color profile to monawp_color_background_profiles
				'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
			));

			// Add control for link color profile select
			$wp_customize->add_control('monawp_'.$array['panel'].'_panel_'.$item.'_box_shadow_style_profile', array(
				'type' => 'select',
				'label' => __('Box Shadow Style', 'monawp'),
				'description' => __('0 = no styling', 'monawp'),
				'section' => 'monawp_'.$array['panel'].'_panel_'.$array['section'],
				'choices' => array_keys($monawp_box_shadow_style_profiles),
				'priority' => 30, // Adjust the priority as needed
			));
			
			if (!isset($array['no_hover'])) {
				// Add setting for link color profile
				$wp_customize->add_setting('monawp_'.$array['panel'].'_panel_'.$item.'_box_shadow_hover_focus_style_profile', array(
					'default' => $array['default_hover'], // Set default color profile to monawp_color_background_profiles
					'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
				));

				// Add control for link color profile select
				$wp_customize->add_control('monawp_'.$array['panel'].'_panel_'.$item.'_box_shadow_hover_focus_style_profile', array(
					'type' => 'select',
					'label' => __('Box Shadow Hover/Focus Style', 'monawp'),
					'description' => __('0 = no styling', 'monawp'),
					'section' => 'monawp_'.$array['panel'].'_panel_'.$array['section'],
					'choices' => array_keys($monawp_box_shadow_style_profiles),
					'priority' => 30, // Adjust the priority as needed
				));
			}
			
		}

		$spacing_style_items = array(
			'horizontal_menu' => array(
				'panel' => 'global',
				'section' => 'horizontal_menu',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_horizontal_menu_padding'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_horizontal_menu_padding'],
				),
				'_horizontal_margin' => array(
					'enabled' => false,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_horizontal_menu_padding'],
				),
				'_vertical_margin' => array(
					'enabled' => false,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_horizontal_menu_padding'],
				),
			),
			'article' => array(
				'panel' => 'global',
				'section' => 'article',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_article_spacing_horizontal'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_article_spacing_vertical'],
				),
				'_row_gap' => array(
					'enabled' => true,
					'label' => __('Row Gap', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_article_spacing_vertical'],
				),
				'_column_gap' => array(
					'enabled' => true,
					'label' => __('Column Gap', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_article_spacing_horizontal'],
				),
			),
			'widget' => array(
				'panel' => 'global',
				'section' => 'widget',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_widget_spacing_horizontal'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_widget_spacing_vertical'],
				),
				'_horizontal_margin' => array(
					'enabled' => true,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_widget_spacing_horizontal'],
				),
				'_vertical_margin' => array(
					'enabled' => true,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_widget_spacing_vertical'],
				),
			),
			'element_wrapper' => array(
				'panel' => 'global',
				'section' => 'element_wrapper',
				'min' => 0,
				'max' => 0.5,
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_element_wrapper_spacing'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_element_wrapper_spacing'],
				),
				'_horizontal_margin' => array(
					'enabled' => true,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_element_wrapper_spacing'],
				),
				'_vertical_margin' => array(
					'enabled' => true,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_element_wrapper_spacing'],
				),
			),
			'buttons' => array(
				'panel' => 'global',
				'section' => 'buttons',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_buttons_padding'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_buttons_padding'],
				),
				'_horizontal_margin' => array(
					'enabled' => false,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_buttons_padding'],
				),
				'_vertical_margin' => array(
					'enabled' => false,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_buttons_padding'],
				),
			),
			'inputs' => array(
				'panel' => 'global',
				'section' => 'inputs',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_inputs_padding'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_inputs_padding'],
				),
				'_horizontal_margin' => array(
					'enabled' => false,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_inputs_padding'],
				),
				'_vertical_margin' => array(
					'enabled' => false,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_inputs_padding'],
				),
			),
			'socials' => array(
				'panel' => 'socials',
				'section' => 'layout',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_socials_padding'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_socials_padding'],
				),
				'_gap' => array(
					'enabled' => true,
					'label' => __('Gap', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_socials_padding'],
				),
			),
			'topbar' => array(
				'panel' => 'topbar',
				'section' => 'layout',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_topbar_padding'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_topbar_padding'],
				),
				'_horizontal_margin' => array(
					'enabled' => false,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_socials_padding'],
				),
				'_vertical_margin' => array(
					'enabled' => false,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_socials_padding'],
				),
			),
			'header' => array(
				'panel' => 'header',
				'section' => 'layout',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_header_padding'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_header_padding'],
				),
				'_horizontal_margin' => array(
					'enabled' => false,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_header_padding'],
				),
				'_vertical_margin' => array(
					'enabled' => false,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_header_padding'],
				),
			),
			'main_site_wrapper' => array(
				'panel' => 'global',
				'section' => 'main_site_wrapper',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_main_site_wrapper_padding'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_main_site_wrapper_padding_v'],
				),
				'_horizontal_margin' => array(
					'enabled' => false,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_main_site_wrapper_padding'],
				),
				'_vertical_margin' => array(
					'enabled' => false,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_main_site_wrapper_padding_v'],
				),
			),
			'left_sidebar' => array(
				'panel' => 'left_sidebar',
				'section' => 'layout',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
				'_horizontal_margin' => array(
					'enabled' => true,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
				'_vertical_margin' => array(
					'enabled' => true,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
			),
			'main_content' => array(
				'panel' => 'main_content',
				'section' => 'layout',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
				'_horizontal_margin' => array(
					'enabled' => true,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
				'_vertical_margin' => array(
					'enabled' => true,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
			),
			'right_sidebar' => array(
				'panel' => 'right_sidebar',
				'section' => 'layout',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
				'_horizontal_margin' => array(
					'enabled' => true,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
				'_vertical_margin' => array(
					'enabled' => true,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_sidebar_content_spacing'],
				),
			),
			'footer' => array(
				'panel' => 'footer',
				'section' => 'layout',
				'_horizontal_padding' => array(
					'enabled' => true,
					'label' => __('Horizontal Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_footer_padding'],
				),
				'_vertical_padding' => array(
					'enabled' => true,
					'label' => __('Vertical Padding', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_footer_padding'],
				),
				'_horizontal_margin' => array(
					'enabled' => false,
					'label' => __('Horizontal Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_socials_padding'],
				),
				'_vertical_margin' => array(
					'enabled' => false,
					'label' => __('Vertical Margin', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_socials_padding'],
				),
			),
		);
		
		foreach ($spacing_style_items as $item => $array) {
			foreach ($array as $spacing_item => $settings) {
				if (is_array($settings) && $settings['enabled']) {
					// Add setting for spacing
					$wp_customize->add_setting('monawp_' . $array['panel'] . '_panel_' . $item . $spacing_item, array(
						'default' => $settings['default'], // Set default padding or margin
						'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'float'),
					));

					if (!isset($array['max'])) {
						$wp_customize->add_control('monawp_' . $array['panel'] . '_panel_' . $item . $spacing_item, array(
							'type' => 'range',
							'label' => $settings['label'],
							'section' => 'monawp_' . $array['panel'] . '_panel_' . $array['section'],
							'input_attrs' => array(
								'min' => 0,
								'max' => 2.5,
								'step' => 0.05,
							),
							'priority' => 30, // Adjust the priority as needed
						));
					} else {
						$wp_customize->add_control('monawp_' . $array['panel'] . '_panel_' . $item . $spacing_item, array(
							'type' => 'range',
							'label' => $settings['label'],
							'section' => 'monawp_' . $array['panel'] . '_panel_' . $array['section'],
							'input_attrs' => array(
								'min' => $array['min'],
								'max' => $array['max'],
								'step' => 0.05,
							),
							'priority' => 30, // Adjust the priority as needed
						));
					}
				}
			}
		}
		
		$header_and_footer_panels = [
			'topbar' => 'monawp_topbar_panel_layout',
			'header' => 'monawp_header_panel_layout',
			'footer' => 'monawp_footer_panel_layout'
		];

		foreach ($header_and_footer_panels as $panel => $section) {
			$justify_setting = "monawp_{$panel}_panel_layout_justify_content";
			$direction_setting = "monawp_{$panel}_panel_layout_flex_direction";

			$wp_customize->add_setting($direction_setting, array(
				'default' => $monawp_customizer_defaults["monawp_{$panel}_flex_direction"],
				'sanitize_callback' => 'sanitize_text_field',
			));

			$wp_customize->add_control($direction_setting, array(
				'label' => __("Flex Direction", 'monawp'),
				'section' => $section,
				'settings' => $direction_setting,
				'type' => 'select',
				'choices' => $monawp_flex_direction_options,
			));

			$wp_customize->add_setting($justify_setting, array(
				'default' => $monawp_customizer_defaults["monawp_{$panel}_justify_content"],
				'sanitize_callback' => 'sanitize_text_field',
			));

			$wp_customize->add_control($justify_setting, array(
				'label' => __("Flex Justify Content", 'monawp'),
				'section' => $section,
				'settings' => $justify_setting,
				'type' => 'select',
				'choices' => $monawp_justify_content_options,
			));
		}

		

		$wp_customize->add_setting('monawp_logo_max_width', array(
			'default'           => $monawp_customizer_defaults['monawp_logo_max_width'], // Default value
			'sanitize_callback' => 'absint', // Sanitize callback to ensure integer value
		));

		$wp_customize->add_control('monawp_logo_max_width', array(
			'label'       => __('Logo Max Width', 'monawp'), // Label for the control
			'description' => __('Adjust the maximum width of the logo (in pixels)', 'monawp'), // Description for the control
			'section'     => 'title_tagline', // Customize section
			'type'        => 'range', // Type of control
			'input_attrs' => array(
				'min'  => 50, // Minimum value
				'max'  => 650, // Maximum value
				'step' => 1, // Step value
			),
		));
		
		
		$max_width_label = __('Max Width', 'monawp');
		
		$max_width_style_items = array(
			'topbar' => array(
				'panel' => 'topbar',
				'section' => 'layout',
				'_max_width' => array(
					'enabled' => true,
					'label' => $max_width_label,
					'default' => $monawp_customizer_defaults['monawp_topbar_max_width'],
				),
			),
			'header' => array(
				'panel' => 'header',
				'section' => 'layout',
				'_max_width' => array(
					'enabled' => true,
					'label' => $max_width_label,
					'default' => $monawp_customizer_defaults['monawp_header_max_width'],
				),
			),
			'main_site_wrapper' => array(
				'panel' => 'global',
				'section' => 'main_site_wrapper',
				'_max_width' => array(
					'enabled' => true,
					'label' => $max_width_label,
					'default' => $monawp_customizer_defaults['monawp_main_site_wrapper_max_width'],
				),
			),
			'footer' => array(
				'panel' => 'footer',
				'section' => 'layout',
				'_max_width' => array(
					'enabled' => true,
					'label' => $max_width_label,
					'default' => $monawp_customizer_defaults['monawp_footer_max_width'],
				),
			),
		);
		
		foreach ($max_width_style_items as $item => $array) {
			foreach ($array as $spacing_item => $settings) {
				if (is_array($settings) && $settings['enabled']) {
					// Add setting for spacing
					$wp_customize->add_setting('monawp_' . $array['panel'] . '_panel_' . $item . $spacing_item, array(
						'default' => $settings['default'], // Set default padding or margin
						'sanitize_callback' => 'absint',
					));

					// Add control for spacing
					$wp_customize->add_control('monawp_' . $array['panel'] . '_panel_' . $item . $spacing_item, array(
						'type' => 'range',
						'label' => $settings['label'],
						'section' => 'monawp_' . $array['panel'] . '_panel_' . $array['section'],
						'input_attrs' => array(
							'min' => 1200,
							'max' => 2000,
							'step' => 1,
						),
						'priority' => 30, // Adjust the priority as needed
					));
				}
			}
		}
		
		$width_label = __('Width', 'monawp');
		
		$width_style_items = array(
			'left_sidebar' => array(
				'panel' => 'left_sidebar',
				'section' => 'layout',
				'_width' => array(
					'enabled' => true,
					'label' => $width_label,
					'default' => $monawp_customizer_defaults['monawp_left_sidebar_width'],
				),
			),
			'main_content' => array(
				'panel' => 'main_content',
				'section' => 'layout',
				'_width' => array(
					'enabled' => true,
					'label' => $width_label,
					'default' => $monawp_customizer_defaults['monawp_main_content_width'],
				),
			),
			'blog_main_content' => array(
				'panel' => 'blog',
				'section' => 'layout',
				'_width' => array(
					'enabled' => true,
					'label' => __('Blog Main Content Width', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_main_content_width'],
				),
			),
			'page_main_content' => array(
				'panel' => 'page',
				'section' => 'layout',
				'_width' => array(
					'enabled' => true,
					'label' => __('Page Main Content Width', 'monawp'),
					'default' => $monawp_customizer_defaults['monawp_main_content_width'],
				),
			),
			'right_sidebar' => array(
				'panel' => 'right_sidebar',
				'section' => 'layout',
				'_width' => array(
					'enabled' => true,
					'label' => $width_label,
					'default' => $monawp_customizer_defaults['monawp_right_sidebar_width'],
				),
			),
		);
		
		foreach ($width_style_items as $item => $array) {
			foreach ($array as $spacing_item => $settings) {
				if (is_array($settings) && $settings['enabled']) {
					// Add setting for spacing
					$wp_customize->add_setting('monawp_' . $array['panel'] . '_panel_' . $item . $spacing_item, array(
						'default' => $settings['default'], // Set default padding or margin
						'sanitize_callback' => 'absint',
					));

					// Add control for spacing
					$wp_customize->add_control('monawp_' . $array['panel'] . '_panel_' . $item . $spacing_item, array(
						'type' => 'range',
						'label' => $settings['label'],
						'section' => 'monawp_' . $array['panel'] . '_panel_' . $array['section'],
						'input_attrs' => array(
							'min' => 20,
							'max' => 100,
							'step' => 1,
						),
						'priority' => 30, // Adjust the priority as needed
					));
				}
			}
		}
		
		$grid_preset_label = __('Grid Preset', 'monawp');

		$main_content_settings = array(
			'main_content' => array(
				'panel' => 'blog',
				'section' => 'layout',
				'grid_preset' => array(
					'enabled' => true,
					'label' => $grid_preset_label,
					'default' => $monawp_customizer_defaults['monawp_main_content_grid_preset'], // Default value for grid preset
				),
			),
		);

		foreach ($main_content_settings as $item => $array) {
			foreach ($array as $setting_item => $settings) {
				if (is_array($settings) && $settings['enabled']) {
					// Add setting for grid preset
					$wp_customize->add_setting('monawp_' . $array['panel'] . '_panel_' . $item . '_' . $setting_item, array(
						'default' => $settings['default'], // Set default grid preset
						'sanitize_callback' => 'sanitize_text_field',
					));

					// Add control for grid preset
					$wp_customize->add_control('monawp_' . $array['panel'] . '_panel_' . $item . '_' . $setting_item, array(
						'type' => 'select',
						'label' => $settings['label'],
						'section' => 'monawp_' . $array['panel'] . '_panel_' . $array['section'],
						'choices' => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
							'8' => '8',
							'9' => '9',
							'10' => '10',
							'11' => '11',
						),
						'priority' => 30, // Adjust the priority as needed
					));
				}
			}
		}
		
		global $monawp_predefined_query_layouts;
		
		$article_layout_label = __('Article Layout', 'monawp');

		$main_content_settings = array(
			'main_content' => array(
				'panel' => 'blog',
				'section' => 'layout',
				'article_layout' => array(
					'enabled' => true,
					'label' => $article_layout_label,
					'default' => $monawp_customizer_defaults['monawp_main_content_article_layout'], // Default value for grid preset
				),
			),
		);

		foreach ($main_content_settings as $item => $array) {
			foreach ($array as $setting_item => $settings) {
				if (is_array($settings) && $settings['enabled']) {
					// Add setting for grid preset
					$wp_customize->add_setting('monawp_' . $array['panel'] . '_panel_' . $item . '_' . $setting_item, array(
						'default' => $settings['default'], // Set default grid preset
						'sanitize_callback' => 'sanitize_text_field',
					));

					// Add control for grid preset
					$wp_customize->add_control('monawp_' . $array['panel'] . '_panel_' . $item . '_' . $setting_item, array(
						'type' => 'select',
						'label' => $settings['label'],
						'section' => 'monawp_' . $array['panel'] . '_panel_' . $array['section'],
						'choices' => $monawp_predefined_query_layouts,
						'priority' => 30, // Adjust the priority as needed
					));
				}
			}
		}
		
		$wp_customize->add_setting('monawp_topbar_panel_layout_enable', array(
			'default' => $monawp_customizer_defaults['monawp_topbar_enable'],
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));

		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'monawp_topbar_panel_layout_enable', array(
			'label' => sprintf(__('Enable Topbar', 'monawp'), $label),
			'section' => 'monawp_topbar_panel_layout',
			'type' => 'checkbox',
		)));


		$wp_customize->add_setting('monawp_header_panel_layout_sticky_header_global', array(
			'default' => $monawp_customizer_defaults['monawp_sticky_header'],
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));

		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'monawp_header_panel_layout_sticky_header_global', array(
			'label' => sprintf(__('Sticky header', 'monawp'), $label),
			'section' => 'monawp_header_panel_layout',
			'type' => 'checkbox',
		)));
		
		global $monawp_item_titles;

		$wp_customize->add_setting('monawp_search_panel_layout_page_title', array(
			'default' => $monawp_item_titles['search_page'],
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control('monawp_search_panel_layout_page_title', array(
			'type' => 'text',
			'label' => __('Search Page Title', 'monawp'),
			'section' => 'monawp_search_panel_layout',
			'priority' => 30,
		));
		
		// Customizer setting for comment title
		$wp_customize->add_setting('monawp_global_panel_comments_title', array(
			'default' => $monawp_item_titles['comments_title'],
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control('monawp_global_panel_comments_title', array(
			'type' => 'text',
			'label' => __('Comments Title', 'monawp'),
			'section' => 'monawp_global_panel_comments', // Adjust section as necessary
			'priority' => 35, // Adjust priority as necessary
		));

		$wp_customize->add_setting('monawp_elements_panel_related_posts_count', array(
			'default' => $monawp_customizer_defaults['monawp_related_posts_count'],
			'sanitize_callback' => 'absint',
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_count', array(
			'type' => 'range',
			'label' => __('Related Posts Count', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'input_attrs' => array(
				'min' => 0,
				'max' => 10,
				'step' => 1,
			),
			'priority' => 30,
		));
		
		// Similar Posts Title setting
		$wp_customize->add_setting('monawp_elements_panel_related_posts_title', array(
			'default' => __('You May Also Like:', 'monawp'),
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_title', array(
			'type' => 'text',
			'label' => __('Similar Posts Title', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'priority' => 30,
		));

		// Sorting option setting
		$wp_customize->add_setting('monawp_elements_panel_related_posts_sort_by', array(
			'default' => 'rand',
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_sort_by', array(
			'type' => 'select',
			'label' => __('Sort Related Posts By', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'choices' => array(
				'rand' => __('Random', 'monawp'),
				'date' => __('Date', 'monawp'),
				'comment_count' => __('Comment Count', 'monawp'),
				'title' => __('Title', 'monawp'),
			),
			'priority' => 31,
		));

		// Taxonomy option setting
		$wp_customize->add_setting('monawp_elements_panel_related_posts_taxonomy', array(
			'default' => 'both',
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_taxonomy', array(
			'type' => 'select',
			'label' => __('Related Posts Taxonomy', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'choices' => array(
				'category' => __('Categories', 'monawp'),
				'post_tag' => __('Tags', 'monawp'),
				'both' => __('Categories and Tags', 'monawp'),
			),
			'priority' => 32,
		));

		// Checkbox options for displaying meta information
		$wp_customize->add_setting('monawp_elements_panel_related_posts_display_date', array(
			'default' => true,
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_display_date', array(
			'type' => 'checkbox',
			'label' => __('Display Date', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'priority' => 33,
		));

		$wp_customize->add_setting('monawp_elements_panel_related_posts_display_excerpt', array(
			'default' => false,
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_display_excerpt', array(
			'type' => 'checkbox',
			'label' => __('Display Excerpt', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'priority' => 34,
		));

		$wp_customize->add_setting('monawp_elements_panel_related_posts_display_author', array(
			'default' => true,
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_display_author', array(
			'type' => 'checkbox',
			'label' => __('Display Author', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'priority' => 35,
		));
		
		$wp_customize->add_setting('monawp_elements_panel_related_posts_display_category', array(
			'default' => true,
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_display_category', array(
			'type' => 'checkbox',
			'label' => __('Display Category', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'priority' => 36,
		));

		$wp_customize->add_setting('monawp_elements_panel_related_posts_display_tags', array(
			'default' => false,
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_display_tags', array(
			'type' => 'checkbox',
			'label' => __('Display Tags', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'priority' => 37,
		));

		$wp_customize->add_setting('monawp_elements_panel_related_posts_display_comments_count', array(
			'default' => false,
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_display_comments_count', array(
			'type' => 'checkbox',
			'label' => __('Display Comments Count', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'priority' => 38,
		));
		
		$wp_customize->add_setting('monawp_elements_panel_related_posts_thumbnail_size', array(
			'default' => 'monawp_medium_thumbnail',
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control('monawp_elements_panel_related_posts_thumbnail_size', array(
			'type' => 'select',
			'label' => __('Thumbnail Size', 'monawp'),
			'section' => 'monawp_elements_panel_related_posts',
			'choices' => array(
				'monawp_small_thumbnail' => __('Thumbnail (300x200)', 'monawp'),
				'monawp_medium_thumbnail' => __('Medium (720x480)', 'monawp'),
				'monawp_large_thumbnail' => __('Large (1280x720)', 'monawp'),
				// Add other sizes here
			),
			'priority' => 38,
		));
		
		global $monawp_thumbnail_choices;
		global $monawp_pages_with_excerpt;
		
		// Loop through each page and create a setting and control for the thumbnail size
		foreach ($monawp_pages_with_excerpt as $page_slug => $page_name) {
			// Define setting ID and section name
			$setting_id = 'monawp_' . $page_slug . '_panel_layout_featured_thumbnail_size';
			$section_name = 'monawp_' . $page_slug . '_panel_layout';

			// Add setting
			$wp_customize->add_setting($setting_id, array(
				'default' => $monawp_customizer_defaults['monawp_layout_featured_thumbnail_size'],
				'sanitize_callback' => 'sanitize_text_field',
			));

			// Add control
			$wp_customize->add_control($setting_id, array(
				'type' => 'select',
				'label' => __('Thumbnail', 'monawp'),
				'section' => $section_name,
				'choices' => $monawp_thumbnail_choices,
				'priority' => 38,
			));
		}
		
		global $monawp_custom_plugin_default_css;
		
		foreach ($monawp_custom_plugin_default_css as $plugin_id => $plugin_data) {
			if (isset($plugin_data['condition']) && call_user_func($plugin_data['condition'])) {

				$wp_customize->add_section("monawp_plugins_panel_{$plugin_id}", array(
					'title' => $plugin_data['label'],
					'panel' => 'monawp_plugins_panel',
				));

				$setting_id = "monawp_plugins_panel_{$plugin_id}_custom_css"; // Setting ID for actual CSS
				$wp_customize->add_setting($setting_id, array(
					'default' => $plugin_data['custom_css'],
					'sanitize_callback' => array( 'MonaWP\Resources\Sanitize', 'css' ),
				));

				$wp_customize->add_control($setting_id, array(
					'label' => 'Custom CSS',
					'section' => "monawp_plugins_panel_{$plugin_id}",
					'type' => 'textarea',
					'active_callback' => function ($control) use ($plugin_id) {
						$enabled_setting = "monawp_plugins_panel_{$plugin_id}_custom_css_enabled";
						return get_theme_mod($enabled_setting, true); // Check if "Use custom CSS" is enabled
					}, // Only show textarea if checkbox is checked
				));
			}
		}
		
		$setting_id = "monawp_page_panel_custom_css_custom_css"; // Setting ID for actual CSS
		$wp_customize->add_setting($setting_id, array(
			'default' => '',
			'sanitize_callback' => array( 'MonaWP\Resources\Sanitize', 'css' ),
		));

		$wp_customize->add_control($setting_id, array(
			'label' => 'Custom CSS',
			'section' => "monawp_page_panel_custom_css",
			'type' => 'textarea',
		));
		
		// Add checkbox control to show or hide scroll-to-top
		$wp_customize->add_setting( 'monawp_global_panel_scroll_to_top_show', array(
			'default' => $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_show'],
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		) );

		$wp_customize->add_control( 'monawp_global_panel_scroll_to_top_show', array(
			'label'    => esc_html__( 'Show Scroll to Top', 'monawp' ),
			'section'  => 'monawp_global_panel_scroll_to_top',
			'type'     => 'checkbox',
		) );

		// Add position control
		$wp_customize->add_setting( 'monawp_global_panel_scroll_to_top_position', array(
			'default' => $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_position'],
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'monawp_global_panel_scroll_to_top_position', array(
			'label'    => esc_html__( 'Position', 'monawp' ),
			'section'  => 'monawp_global_panel_scroll_to_top',
			'type'     => 'radio',
			'choices'  => array(
				'left'  => esc_html__( 'Left', 'monawp' ),
				'right' => esc_html__( 'Right', 'monawp' ),
			),
		) );

		// Add range slider for offset from bottom
		$wp_customize->add_setting( 'monawp_global_panel_scroll_to_top_offset_bottom', array(
			'default' => $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_offset_bottom'],
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'monawp_global_panel_scroll_to_top_offset_bottom', array(
			'label'    => esc_html__( 'Offset from Bottom (px)', 'monawp' ),
			'section'  => 'monawp_global_panel_scroll_to_top',
			'type'     => 'range',
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 100,
				'step'  => 1,
			),
		) );

		// Add range slider for offset from side
		$wp_customize->add_setting( 'monawp_global_panel_scroll_to_top_offset_side', array(
			'default' => $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_offset_side'],
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'monawp_global_panel_scroll_to_top_offset_side', array(
			'label'    => esc_html__( 'Offset from Side (px)', 'monawp' ),
			'section'  => 'monawp_global_panel_scroll_to_top',
			'type'     => 'range',
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 100,
				'step'  => 1,
			),
		) );
		
		// Add checkbox control to hide on mobile
		$wp_customize->add_setting( 'monawp_global_panel_scroll_to_top_hide_mobile', array(
			'default' => $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_hide_mobile'],
			'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
		) );

		$wp_customize->add_control( 'monawp_global_panel_scroll_to_top_hide_mobile', array(
			'label'    => esc_html__( 'Hide on Mobile', 'monawp' ),
			'section'  => 'monawp_global_panel_scroll_to_top',
			'type'     => 'checkbox',
		) );
			
		global $monawp_singular_pages;
		global $monawp_singular_pages_items;

		foreach ( $monawp_singular_pages as $panel => $name ) {
			// Add a new section for each panel
			$section_id = 'monawp_' . $panel . '_panel_layout';

			// Add settings and controls for each item
			foreach ( $monawp_singular_pages_items as $item => $details ) {
				$setting_id = 'monawp_' . $panel . '_panel_layout_show_' . $item;

				if ($panel == 'page' and $item == 'similar_posts') {
					continue;
				}
				
				if ($panel == 'page' and $item == 'author_box') {
					continue;
				}
				
				if ($panel == 'single_post') {
					$default_value = $details['default'];
				}
				
				if ($panel == 'page') {
					$default_value = $details['default_page'];
				}
				
				$wp_customize->add_setting( $setting_id, array(
					'default'           => $default_value,
					'sanitize_callback' => array('MonaWP\Resources\Sanitize', 'checkbox'),
				) );

				// Add control
				$wp_customize->add_control( $setting_id, array(
					'type'     => 'checkbox',
					'label'    => $details['label'],
					'section'  => $section_id,
					'settings' => $setting_id,
				) );
			}
		}
		
		
		
	}

	add_action('customize_register', 'monawp_customize_register');
}

?>