<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MonaWP\Resources\Helpers as Helpers; 
use MonaWP\cssConstructor as cssConstructor;

function monawp_enqueue_theme_mod_constructed_css() {
	
	global $monawp_ConstructedCssGlobal;
	global $monawp_ConstructedCssDesktop;
	global $monawp_ConstructedCssLaptop;
	global $monawp_ConstructedCssTablet;
	global $monawp_ConstructedCssMobile;
	global $monawp_customizer_defaults;
	global $monawp_color_visited_profiles;
	global $monawp_color_background_profiles;
	global $monawp_border_style_profiles;
	global $monawp_border_bottom_style_profiles;
	global $monawp_box_shadow_style_profiles;
	
	$monawp_buttons_css_selector = '#page.site button,#page.site input[type="button"],#page.site input[type="reset"],#page.site input[type="submit"],#page.site .wp-block-button__link';
	$monawp_buttons_inner_css_selector = '#page.site button svg,#page.site button a';

	$monawp_buttons_hover_focus_css_selector = Helpers::appendSubstringsToString($monawp_buttons_css_selector, ':hover', ':focus', ':active');
	$monawp_buttons__focus_css_selector = Helpers::appendSubstringsToString($monawp_buttons_css_selector, ':focus');
	$monawp_buttons_inner_hover_focus_css_selector = '#page.site button:hover svg,#page.site button:focus svg,#page.site button:active svg,#page.site button:hover a,#page.site button:focus a,#page.site button:active a,#page.site button:hover span,#page.site button:focus span';
	$monawp_inputs_css_selector = '#page.site select,#page.site select option,#page.site input[type="text"],#page.site input[type="email"],#page.site input[type="url"],#page.site input[type="password"],#page.site input[type="search"],#page.site input[type="number"],#page.site input[type="tel"],#page.site input[type="range"],#page.site input[type="date"],#page.site input[type="month"],#page.site input[type="week"],#page.site input[type="time"],#page.site input[type="datetime"],#page.site input[type="datetime-local"],#page.site input[type="color"],#page.site textarea';
	$monawp_inputs_focus_css_selector = Helpers::appendSubstringsToString($monawp_inputs_css_selector, ':focus');
	
	$monawp_buttons_css_selector = Helpers::replaceExactString($monawp_buttons_css_selector,',','#page.site button','#page.site button:not(.mejs-button button,.wp-story-pagination-bullet)');
	$monawp_buttons_hover_focus_css_selector = Helpers::replaceExactString($monawp_buttons_hover_focus_css_selector,',','#page.site button:hover','#page.site button:hover:not(.mejs-button button,.wp-story-pagination-bullet)');
	$monawp_buttons_hover_focus_css_selector = Helpers::replaceExactString($monawp_buttons_hover_focus_css_selector,',','#page.site button:focus','#page.site button:focus:not(.mejs-button button,.wp-story-pagination-bullet)');
	$html_font_size = get_theme_mod("monawp-html-font-size", $monawp_customizer_defaults["monawp-html-font-size"]);
	$html_line_height = get_theme_mod("monawp-html-line-height", $monawp_customizer_defaults["monawp-html-line-height"]);
	
	$monawp_ConstructedCssGlobal .= '

			/* Normalize
			--------------------------------------------- */

			/*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */

			/* Reset all standard HTML elements */
			* {
				margin:0;
				padding:0;
				border:0;
				background: transparent;
				font: inherit;
				vertical-align: baseline;
				text-decoration: none;
				outline: none;
				box-sizing: border-box;
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
				-webkit-tap-highlight-color: transparent;
				word-break: break-word; /* Add word-break property */
				scroll-behavior: smooth;
			}
			
			ul,ol {
				list-style:none;
			}
			
			*::before, *::after {
				box-sizing: border-box;
			}
			
			html {
				font-size:'.esc_attr((string)$html_font_size).'px;
				font-family:'.esc_attr(get_theme_mod('monawp-html-font-family', $monawp_customizer_defaults["monawp-html-font-family"])).';
				line-height:'.esc_attr((string)$html_line_height).';
				-webkit-text-size-adjust: 100%;
				color: var(--monawp-secondary-color);
				height: auto;
				';
				
				if (is_rtl()) {
					$monawp_ConstructedCssGlobal .= '
				direction: rtl;
				text-align: right;
				';
				} else {
					$monawp_ConstructedCssGlobal .= '
					text-align: left;
					';
				}
				$monawp_ConstructedCssGlobal .= '
			}

			/* Global settings */

			body {
				background:'.esc_attr(get_theme_mod("monawp_global_panel_body_color_background_profile", $monawp_customizer_defaults["monawp_body_background_color_profile"])).' !important;
				overflow-x:hidden;
				min-height: 100vh;
				';
				if ($monawp_border_style_profiles[get_theme_mod("monawp_global_panel_body_border_style_profile", $monawp_customizer_defaults["monawp_body_border_style_profiles"])]["border"] !== 'none') {
					$monawp_ConstructedCssGlobal .= '
					border:'.esc_attr($monawp_border_style_profiles[get_theme_mod("monawp_global_panel_body_border_style_profile", $monawp_customizer_defaults["monawp_body_border_style_profiles"])]["border"]).';
					';
				}
				$monawp_ConstructedCssGlobal .= '
			}
			
			/* Links
			--------------------------------------------- */

			a:focus {
				outline:2px dashed;
			}

			a:hover,
			a:active {
				outline: 0;
			}

			a, a:visited {
				color:'.esc_attr($monawp_color_visited_profiles[get_theme_mod("monawp_global_panel_a_tag_color_profile", $monawp_customizer_defaults["monawp_color_visited_profiles"])]["color"]).';
				text-decoration:underline;
				cursor:pointer;
			}

			a:hover,
			a:focus,
			a:active {
				color:'.esc_attr($monawp_color_visited_profiles[get_theme_mod("monawp_global_panel_a_tag_color_profile", $monawp_customizer_defaults["monawp_color_visited_profiles"])]["visited"]).';
			}
			';
			
			if (get_theme_mod('monawp_global_panel_horizontal_menu_hover_effect', $monawp_customizer_defaults['monawp_global_panel_horizontal_menu_hover_effect'])) {
				
				$monawp_ConstructedCssGlobal .= '
				
				.horizontal-navigation-desktop ul li a:hover,.horizontal-navigation-desktop ul li a:focus
				 {
					color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_horizontal_menu_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus"])]["color"]).';
					background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_horizontal_menu_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus"])]["background"]).';
				}
				';
				
			}
			
			$monawp_ConstructedCssGlobal .= '
			.horizontal-navigation-desktop ul li a {
				color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_horizontal_menu_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles_2"])]["color"]).';
				background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_horizontal_menu_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles_2"])]["background"]).';
				padding:'.esc_attr(get_theme_mod("monawp_global_panel_horizontal_menu_vertical_padding", $monawp_customizer_defaults["monawp_horizontal_menu_padding"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_horizontal_menu_horizontal_padding", $monawp_customizer_defaults["monawp_horizontal_menu_padding"])).'rem;
				line-height:1.2;
			}

			h1,h2,h3,h4,h5,h6,h1 *,h2 *,h3 *,h4 *,h5 *,h6 *, h1 > a:visited, h2 > a:visited, h3 > a:visited, h4 > a:visited, h5 > a:visited,  h6 > a:visited {
				color: var(--monawp-main-color);
				text-decoration:none
			}
			
			hr {
				background-color:var(--monawp-main-color);
			}
			
			/* Sections
				 ========================================================================== */

			/**
			 * Render the `main` element consistently in IE.
			 */
			main {
				display: block;
			}

			/* Grouping content
				 ========================================================================== */

			/* Text-level semantics
				 ========================================================================== */

			/**
			 * Add the correct font weight in Chrome, Edge, and Safari.
			 */
			b,
			strong {
				font-weight: bolder;
			}

			/**
			 * 1. Correct the inheritance and scaling of font size in all browsers.
			 * 2. Correct the odd `em` font sizing in all browsers.
			 */
			code,
			kbd,
			samp {
				font-family: "Courier 10 Pitch", courier, monospace;
				margin:1.2rem 0.6rem;
				max-width: 100%;
				display:block;
				padding:0.6rem;
				background: var(--monawp-secondary-contrast-color);
				color:var(--monawp-main-color);
				width:calc(100% - 1.2rem);
				cursor:pointer;
			}

			/**
			 * Add the correct font size in all browsers.
			 */
			small {
				font-size: 0.75rem;
				padding: 0 0.2rem;
			}

			/**
			 * Prevent `sub` and `sup` elements from affecting the line height in
			 * all browsers.
			 */
			sub,
			sup {
				font-size: 0.75rem;
				line-height: 0;
				position: relative;
				vertical-align: baseline;
				padding: 0 0.2rem;
			}

			sub {
				bottom: -0.25rem;
			}

			sup {
				top: -0.5rem;
			}

			/* Embedded content
				 ========================================================================== */

			/* Forms
				 ========================================================================== */
			
			#page.site form {
				display:flex;
				flex-flow:column;
				
			}

			/**
			 * Show the overflow in IE.
			 * 1. Show the overflow in Edge.
			 */
			button,
			input {
				overflow: visible;
			}

			/**
			 * Remove the inheritance of text transform in Edge, Firefox, and IE.
			 * 1. Remove the inheritance of text transform in Firefox.
			 */
			button,
			select {
				text-transform: none;
			}
			
			select {
				-webkit-appearance: none; /* Remove default arrow in WebKit browsers */
				-moz-appearance: none;    /* Remove default arrow in Firefox */
				appearance: none; 
			}

			/**
			 * Remove the inner border and padding in Firefox.
			 */
			button::-moz-focus-inner,
			[type="button"]::-moz-focus-inner,
			[type="reset"]::-moz-focus-inner,
			[type="submit"]::-moz-focus-inner {
				border-style: none;
				padding: 0;
			}

			/**
			 * Restore the focus styles unset by the previous rule.
			 */
			button:-moz-focusring,
			[type="button"]:-moz-focusring,
			[type="reset"]:-moz-focusring,
			[type="submit"]:-moz-focusring {
				outline: 1px dotted ButtonText;
			}

			/**
			 * 1. Correct the text wrapping in Edge and IE.
			 * 2. Correct the color inheritance from `fieldset` elements in IE.
			 * 3. Remove the padding so developers are not caught out when they zero out
			 *		`fieldset` elements in all browsers.
			 */
			legend {
				box-sizing: border-box;
				color: inherit;
				display: table;
				max-width: 100%;
				white-space: normal;
				margin-bottom:0
			}

			/**
			 * Add the correct vertical alignment in Chrome, Firefox, and Opera.
			 */
			progress {
				vertical-align: baseline;
			}

			/**
			 * 1. Add the correct box sizing in IE 10.
			 * 2. Remove the padding in IE 10.
			 */
			[type="checkbox"],
			[type="radio"] {
				box-sizing: border-box;
				padding: 0;
			}

			/**
			 * Correct the cursor style of increment and decrement buttons in Chrome.
			 */
			[type="number"]::-webkit-inner-spin-button,
			[type="number"]::-webkit-outer-spin-button {
				height: auto;
			}

			/**
			 * 1. Correct the odd appearance in Chrome and Safari.
			 * 2. Correct the outline style in Safari.
			 */
			[type="search"] {
				-webkit-appearance: textfield;
				outline-offset: -2px;
			}

			/**
			 * Remove the inner padding in Chrome and Safari on macOS.
			 */
			[type="search"]::-webkit-search-decoration {
				-webkit-appearance: none;
			}

			/**
			 * 1. Correct the inability to style clickable types in iOS and Safari.
			 * 2. Change font properties to `inherit` in Safari.
			 */
			::-webkit-file-upload-button {
				-webkit-appearance: button;
				font: inherit;
			}

			/* Interactive
				 ========================================================================== */

			/*
			 * Add the correct display in Edge, IE 10+, and Firefox.
			 */
			details {
				display: block;
			}

			/*
			 * Add the correct display in all browsers.
			 */
			summary {
				display: list-item;
			}

			/* Misc
				 ========================================================================== */

			/**
			 * Add the correct display in IE 10+.
			 */
			template {
				display: none;
			}

			/**
			 * Add the correct display in IE 10.
			 */
			[hidden] {
				display: none;
			}
			
			.m_clearfix::after {
				content: "";
				display: table;
				clear: both;
			}


			/*--------------------------------------------------------------
			# Base
			--------------------------------------------------------------*/

			/* Typography
			--------------------------------------------- */

			h1,h2,h3,h4,h5,h6,h1 > :first-child,h2 > :first-child,h3 > :first-child,h4 > :first-child,h5 > :first-child,h6 > :first-child {
				clear: both;
				font-weight:700;
				margin:0.6rem 0;
				font-family: var(--monawp-headers-font-family);
				line-height:'.esc_attr(get_theme_mod("monawp-headers-line-height", $monawp_customizer_defaults["monawp-headers-line-height"])).';
			}

			h1 {
				font-size:'.esc_attr(get_theme_mod('monawp_global_h1_font_size', $monawp_customizer_defaults['monawp_header_defaults']['h1']['font-size'])).'rem;
				letter-spacing:'.esc_attr(get_theme_mod('monawp_global_h1_letter_spacing', $monawp_customizer_defaults['monawp_header_defaults']['h1']['letter-spacing'])).'rem;
			}

			h2 {
				font-size:'.esc_attr(get_theme_mod('monawp_global_h2_font_size', $monawp_customizer_defaults['monawp_header_defaults']['h2']['font-size'])).'rem;
				letter-spacing:'.esc_attr(get_theme_mod('monawp_global_h2_letter_spacing', $monawp_customizer_defaults['monawp_header_defaults']['h2']['letter-spacing'])).'rem;
			}

			h3 {
				font-size:'.esc_attr(get_theme_mod('monawp_global_h3_font_size', $monawp_customizer_defaults['monawp_header_defaults']['h3']['font-size'])).'rem;
				letter-spacing:'.esc_attr(get_theme_mod('monawp_global_h3_letter_spacing', $monawp_customizer_defaults['monawp_header_defaults']['h3']['letter-spacing'])).'rem;
			}

			h4 {
				font-size:'.esc_attr(get_theme_mod('monawp_global_h4_font_size', $monawp_customizer_defaults['monawp_header_defaults']['h4']['font-size'])).'rem;
				letter-spacing:'.esc_attr(get_theme_mod('monawp_global_h4_letter_spacing', $monawp_customizer_defaults['monawp_header_defaults']['h4']['letter-spacing'])).'rem;
			}

			h5 {
				font-size:'.esc_attr(get_theme_mod('monawp_global_h5_font_size', $monawp_customizer_defaults['monawp_header_defaults']['h5']['font-size'])).'rem;
				letter-spacing:'.esc_attr(get_theme_mod('monawp_global_h5_letter_spacing', $monawp_customizer_defaults['monawp_header_defaults']['h5']['letter-spacing'])).'rem;
			}

			h6 {
				font-size:'.esc_attr(get_theme_mod('monawp_global_h6_font_size', $monawp_customizer_defaults['monawp_header_defaults']['h6']['font-size'])).'rem;
				letter-spacing:'.esc_attr(get_theme_mod('monawp_global_h6_letter_spacing', $monawp_customizer_defaults['monawp_header_defaults']['h6']['letter-spacing'])).'rem;
			}


			p {
				margin: 0 0 0.6rem 0;
			}
			
			';
			
			if (Helpers::hasTitleOrDesc()) {
				$monawp_ConstructedCssGlobal .= '
					#masthead p,
					.monawp-site-title {
						margin:0;
					}
					';
			}
			
			$monawp_ConstructedCssGlobal .= '

			dfn,
			cite,
			em,
			i,
			address{
				font-style: italic;
			}

			blockquote {
				margin:0.6rem;
				padding:0.6rem;
				clear:both;
				';
				if (is_rtl()) {
					$monawp_ConstructedCssGlobal .= '
					border-right:4px solid var(--monawp-special-secondary-color);
				';
				} else {
					$monawp_ConstructedCssGlobal .= '
					border-left:4px solid var(--monawp-special-secondary-color);
					';
				}
				$monawp_ConstructedCssGlobal .= '
				background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_blockquote_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["background"]).';
			}
			
			blockquote > *,blockquote > p a {
				color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_blockquote_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).';
			}
			
			blockquote p {
				margin:0rem;
			}

			address {
				';
				if (is_rtl()) {
					$monawp_ConstructedCssGlobal .= '
					margin: 0 0.6rem 0.6rem 0;
				';
				} else {
					$monawp_ConstructedCssGlobal .= '
					margin: 0 0 0.6rem 0.6rem;
					';
				}
				$monawp_ConstructedCssGlobal .= '
			}

			pre {
				font-family: "Courier 10 Pitch", courier, monospace;
				margin:0.6rem;
				max-width: 100%;
				overflow: auto;
				padding:0.6rem;
				background: var(--monawp-secondary-contrast-color);
				border:2px solid var(--monawp-main-color);
			}

			tt,
			var {
				font-family: monaco, consolas, "Andale Mono", "DejaVu Sans Mono", monospace;
			}

			abbr,acronym {
				border-bottom: 1px dotted;
				cursor: help;
			}

			mark,ins {
				padding: 0.2rem;
				text-decoration: none;
			}
			
			mark, bdi{
				background: var(--monawp-secondary-contrast-color);
				color:var(--monawp-main-color);
			}
			
			ins {
				background: var(--monawp-special-contrast-color);
				color:var(--monawp-main-color);
			}

			big {
				font-size: 1.25rem;
				padding: 0 0.2rem;
			}
			
			/* Display
			--------------------------------------------- */
			
			.flex-row {
				display:flex;
				flex-direction:row;
			}
			
			.flex-row-vc {
				display:flex;
				flex-direction:row;
				flex-wrap: wrap;
				align-items:center;
			}
			
			.flex-col {
				display:flex;
				flex-direction:column;
				flex-wrap: wrap
			}


			/* Elements
			--------------------------------------------- */
			
			* svg {
				vertical-align: middle;
			}

			hr {
				border: 0;
				height: 2px;
				box-sizing: content-box;
				height: 0;
				overflow: visible;
				margin:0.6rem 0;
			}

			ul {
				list-style: disc;
				';
				if (is_rtl()) {
					$monawp_ConstructedCssGlobal .= '
						margin: 0 1.2rem 0.6rem 0;
					';
				} else {
					$monawp_ConstructedCssGlobal .= '
						margin: 0 0 0.6rem 1.2rem;
					';
				}
				$monawp_ConstructedCssGlobal .= '
			}

			ol {
				list-style: decimal;
				';
				if (is_rtl()) {
					$monawp_ConstructedCssGlobal .= '
						margin: 0 1.2rem 0.6rem 0;
					';
				} else {
					$monawp_ConstructedCssGlobal .= '
						margin: 0 0 0.6rem 1.2rem;
					';
				}
				$monawp_ConstructedCssGlobal .= '
			}
			
			ol li::marker {
				font-weight: bold;
			}

			li > ul,li > ol {
				';
				if (is_rtl()) {
					$monawp_ConstructedCssGlobal .= '
						margin: 0 1.2rem 0 0;
					';
				} else {
					$monawp_ConstructedCssGlobal .= '
						margin: 0 0 0 1.2rem;
					';
				}
				$monawp_ConstructedCssGlobal .= '
			}

			dt {
				font-weight: 700;
			}
			
			br {
				height:0.6rem;
				display:block
			}

			dd {
				margin: 0 0.6rem 0.6rem 0.6rem;
			}

			/* Make sure embeds and iframes fit their containers. */
			embed,
			iframe,
			object {
				max-width: 100%;
			}

			img {
				height: auto;
				max-width: 100%;
				border-style: none;
			}
			
			#page.site video {
				width: -webkit-fill-available;
				max-width: 100%;
			}

			#page.site figure {
				margin:0.6rem 0;
				max-width: 100%;
			}

			#page.site table {
				width: 100%;
				margin: 0 0 0.6rem 0;
				max-width: 100%; 
				table-layout: fixed; 
				';
				if ($monawp_border_style_profiles[get_theme_mod("monawp_global_panel_table_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"] !== 'none') {
					$monawp_ConstructedCssGlobal .= '
					border:'.esc_attr($monawp_border_style_profiles[get_theme_mod("monawp_global_panel_table_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"]).' !important;
					';
				} else {
					$monawp_ConstructedCssGlobal .= '
					border:none !important;
					';
				}

				$monawp_ConstructedCssGlobal .= '
			}
			
			#page.site table thead th {
				color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_table_head_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
				background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_table_head_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["background"]).' !important;
				font-weight:bold;
				border-bottom:3px solid var(--monawp-main-color);
			}
			
			#page.site table thead th * {
				color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_table_head_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
				fill:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_table_head_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
			}
			
			table th,table td {
				padding:0.6rem;
				border-bottom:1px solid var(--monawp-main-color);
				background:var(--monawp-secondary-contrast-color);
			}
			
			table tbody tr:last-child td,table tbody tr:last-child th {
				border-bottom:0;
			}
			
			';
			$html_font_size = get_theme_mod("monawp-html-font-size", $monawp_customizer_defaults["monawp-html-font-size"]);

			// Define the default dimensions
			$default_width = 1.65; // Default width in rem
			$default_height = 1.65; // Default height in rem

			// Calculate the dimensions based on the font size
			$width = $default_width - ($html_font_size - 16) * 0.005;
			$height = $default_height - ($html_font_size - 16) * 0.005;

			// Append the CSS rules to $monawp_ConstructedCssGlobal
			$monawp_ConstructedCssGlobal .= '
			
				body svg {
					width: ' . esc_attr($width)/1.2 . 'rem;
					height: ' . esc_attr($height)/1.2 . 'rem;
					overflow: visible; /* Ensure SVG is not clipped */
					fill:var(--monawp-main-color);
				}
				svg.half {
					width: ' . esc_attr($width)/2 . 'rem;
					height: ' . esc_attr($height)/2 . 'rem;
				}
				svg.full {
					width: ' . esc_attr($width) . 'rem;
					height: ' . esc_attr($height) . 'rem;
				}
				svg.2x {
					width: ' . esc_attr($width) * 2 . 'rem;
					height: ' . esc_attr($height) * 2 . 'rem;
				}
			';
			
			$monawp_ConstructedCssGlobal .= '
			
			#page.site form * {
				color:inherit !important;
				font-size:inherit !important;
				font-weight:inherit !important;
				font-family:inherit !important;
				line-height:inherit !important;
			}
			
			#page.site form a.button {
				background:var(--monawp-main-contrast-color)
			}
			
			#page.site form p {
				clear: both;
				width: 100%;
				display: flex;
				flex-flow: column wrap;
			}
			
			#page.site form label,#page.site form input,#page.site form textarea {
				margin:0.6rem 0;
			}
			
			#page.site form input[type=checkbox] {
				';
				if (is_rtl()) {
					$monawp_ConstructedCssGlobal .= '
						margin:0 0 0 0.6rem;
					';
				} else {
					$monawp_ConstructedCssGlobal .= '
						margin:0 0.6rem 0 0;
					';
				}
				$monawp_ConstructedCssGlobal .= '
			}
			
			#page.site form ul li {
				align-items:center;
			}
			
			#page.site form .comment-form-cookies-consent {
				flex-flow: row wrap;
			}

			#page.site form > *:last-child {
				margin-bottom:0
			}
			
			';
			
			$inputs_border_radius_css = '';

			if (get_theme_mod('monawp_global_panel_inputs_border_radius_top-left', $monawp_customizer_defaults["monawp_inputs_border_radius"]) != 0) {
				$inputs_border_radius_css .= 'border-top-left-radius:' . esc_attr(get_theme_mod('monawp_global_panel_inputs_border_radius_top-left', $monawp_customizer_defaults["monawp_inputs_border_radius"])) . 'rem !important;';
			}
			if (get_theme_mod('monawp_global_panel_inputs_border_radius_top-right', $monawp_customizer_defaults["monawp_inputs_border_radius"]) != 0) {
				$inputs_border_radius_css .= 'border-top-right-radius:' . esc_attr(get_theme_mod('monawp_global_panel_inputs_border_radius_top-right', $monawp_customizer_defaults["monawp_inputs_border_radius"])) . 'rem !important;';
			}
			if (get_theme_mod('monawp_global_panel_inputs_border_radius_bottom-left', $monawp_customizer_defaults["monawp_inputs_border_radius"]) != 0) {
				$inputs_border_radius_css .= 'border-bottom-left-radius:' . esc_attr(get_theme_mod('monawp_global_panel_inputs_border_radius_bottom-left', $monawp_customizer_defaults["monawp_inputs_border_radius"])) . 'rem !important;';
			}
			if (get_theme_mod('monawp_global_panel_inputs_border_radius_bottom-right', $monawp_customizer_defaults["monawp_inputs_border_radius"]) != 0) {
				$inputs_border_radius_css .= 'border-bottom-right-radius:' . esc_attr(get_theme_mod('monawp_global_panel_inputs_border_radius_bottom-right', $monawp_customizer_defaults["monawp_inputs_border_radius"])) . 'rem !important;';
			}
			
			$monawp_ConstructedCssGlobal .= '
			'.$monawp_inputs_css_selector.' {
				border-radius:0 !important;
				max-width: 100% !important;
				height:auto !important;
				'.$inputs_border_radius_css.'
				';
				if ($monawp_border_style_profiles[get_theme_mod("monawp_global_panel_inputs_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"] !== 'none') {
					$monawp_ConstructedCssGlobal .= '
					border:'.esc_attr($monawp_border_style_profiles[get_theme_mod("monawp_global_panel_inputs_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"]).' !important;
					';
				} else {
					$monawp_ConstructedCssGlobal .= '
					border:none !important;
					';
				}
				if ($monawp_border_bottom_style_profiles[get_theme_mod("monawp_global_panel_inputs_border_bottom_style_profile", $monawp_customizer_defaults["monawp_border_bottom_style_profiles"])]["border-bottom"] !== 'none') {
					$monawp_ConstructedCssGlobal .= '
					border-bottom:'.esc_attr($monawp_border_bottom_style_profiles[get_theme_mod("monawp_global_panel_inputs_border_bottom_style_profile", $monawp_customizer_defaults["monawp_border_bottom_style_profiles"])]["border-bottom"]).' !important;
					';
				}
				if ($monawp_box_shadow_style_profiles[get_theme_mod("monawp_global_panel_inputs_box_shadow_style_profile", $monawp_customizer_defaults["monawp_inputs_box_shadow_style_profiles"])]["box-shadow"] !== 'none') {
					$monawp_ConstructedCssGlobal .= '
					box-shadow:'.esc_attr($monawp_box_shadow_style_profiles[get_theme_mod("monawp_global_panel_inputs_box_shadow_style_profile", $monawp_customizer_defaults["monawp_inputs_box_shadow_style_profiles"])]["box-shadow"]).' !important;
					';
				} else {
					$monawp_ConstructedCssGlobal .= '
					box-shadow:none !important;
					';
				}
				
				$monawp_ConstructedCssGlobal .= '
				line-height:inherit !important;
				padding:'.esc_attr(get_theme_mod("monawp_global_panel_inputs_vertical_padding", $monawp_customizer_defaults["monawp_inputs_padding"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_inputs_horizontal_padding", $monawp_customizer_defaults["monawp_inputs_padding"])).'rem !important;
				transition: all 0.5s ease !important;
				font-size: inherit !important;
				color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_inputs_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
				background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_inputs_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["background"]).' !important;
			}
			
			#page.site input::placeholder,#page.site textarea::placeholder {
				color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_inputs_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
			}
			
			';

			
			if (get_theme_mod('monawp_global_panel_inputs_hover_effect', $monawp_customizer_defaults['monawp_global_panel_inputs_hover_effect'])) {
				
				$monawp_ConstructedCssGlobal .= 
				$monawp_inputs_focus_css_selector.' {
					color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_inputs_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus"])]["color"]).' !important;
					background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_inputs_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus"])]["background"]).' !important;
					';
					
					if ($monawp_box_shadow_style_profiles[get_theme_mod("monawp_global_panel_inputs_box_shadow_hover_focus_style_profile", $monawp_customizer_defaults["monawp_inputs_box_shadow_style_profiles"])]["box-shadow"] !== 'none') {
						$monawp_ConstructedCssGlobal .= '
						box-shadow:'.esc_attr($monawp_box_shadow_style_profiles[get_theme_mod("monawp_global_panel_inputs_box_shadow_hover_focus_style_profile", $monawp_customizer_defaults["monawp_inputs_box_shadow_style_profiles"])]["box-shadow"]).' !important;
						';
					} else {
						$monawp_ConstructedCssGlobal .= '
						box-shadow:none !important;
						';
					}
					
					if ($monawp_border_style_profiles[get_theme_mod("monawp_global_panel_inputs_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"] !== 'none') {
						$monawp_ConstructedCssGlobal .= '
						border:'.esc_attr($monawp_border_style_profiles[get_theme_mod("monawp_global_panel_inputs_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"]).' !important;
						';
					} else {
						$monawp_ConstructedCssGlobal .= '
						border:none !important;
						';
					}
					
					$monawp_ConstructedCssGlobal .= '

				}
				
				#page.site input:focus::placeholder,#page.site textarea:focus::placeholder {
					color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_inputs_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus"])]["color"]).' !important;
				}
				
				';
				
			} else {
				
				$monawp_ConstructedCssGlobal .= 
				$monawp_inputs_focus_css_selector.' {
				color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_inputs_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
				background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_inputs_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["background"]).' !important;
				}
				
				';
				
			}
			
			$monawp_ConstructedCssGlobal .= '
			
			#page.site select {
				height:auto !important;
			}
			
			';
			
			$button_border_radius_css = '';

			if (get_theme_mod('monawp_global_panel_buttons_border_radius_top-left', $monawp_customizer_defaults["monawp_buttons_border_radius"]) != 0) {
				$button_border_radius_css .= 'border-top-left-radius:' . esc_attr(get_theme_mod('monawp_global_panel_buttons_border_radius_top-left', $monawp_customizer_defaults["monawp_buttons_border_radius"])) . 'rem !important;';
			}
			if (get_theme_mod('monawp_global_panel_buttons_border_radius_top-right', $monawp_customizer_defaults["monawp_buttons_border_radius"]) != 0) {
				$button_border_radius_css .= 'border-top-right-radius:' . esc_attr(get_theme_mod('monawp_global_panel_buttons_border_radius_top-right', $monawp_customizer_defaults["monawp_buttons_border_radius"])) . 'rem !important;';
			}
			if (get_theme_mod('monawp_global_panel_buttons_border_radius_bottom-left', $monawp_customizer_defaults["monawp_buttons_border_radius"]) != 0) {
				$button_border_radius_css .= 'border-bottom-left-radius:' . esc_attr(get_theme_mod('monawp_global_panel_buttons_border_radius_bottom-left', $monawp_customizer_defaults["monawp_buttons_border_radius"])) . 'rem !important;';
			}
			if (get_theme_mod('monawp_global_panel_buttons_border_radius_bottom-right', $monawp_customizer_defaults["monawp_buttons_border_radius"]) != 0) {
				$button_border_radius_css .= 'border-bottom-right-radius:' . esc_attr(get_theme_mod('monawp_global_panel_buttons_border_radius_bottom-right', $monawp_customizer_defaults["monawp_buttons_border_radius"])) . 'rem !important;';
			}
			
			$monawp_ConstructedCssGlobal .= '
			'.$monawp_buttons_css_selector.' {
				border-radius:0 !important;
				height:auto !important;
				width: auto !important;
				'.$button_border_radius_css.'
				';
				if ($monawp_border_style_profiles[get_theme_mod("monawp_global_panel_buttons_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"] !== 'none') {
					$monawp_ConstructedCssGlobal .= '
					border:'.esc_attr($monawp_border_style_profiles[get_theme_mod("monawp_global_panel_buttons_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"]).' !important;
					';
				}
				if ($monawp_border_bottom_style_profiles[get_theme_mod("monawp_global_panel_buttons_border_bottom_style_profile", $monawp_customizer_defaults["monawp_border_bottom_style_profiles"])]["border-bottom"] !== 'none') {
					$monawp_ConstructedCssGlobal .= '
					border-bottom:'.esc_attr($monawp_border_bottom_style_profiles[get_theme_mod("monawp_global_panel_buttons_border_bottom_style_profile", $monawp_customizer_defaults["monawp_border_bottom_style_profiles"])]["border-bottom"]).' !important;
					';
				}
				if ($monawp_box_shadow_style_profiles[get_theme_mod("monawp_global_panel_buttons_box_shadow_style_profile", $monawp_customizer_defaults["monawp_buttons_box_shadow_style_profiles"])]["box-shadow"] !== 'none') {
					$monawp_ConstructedCssGlobal .= '
					box-shadow:'.esc_attr($monawp_box_shadow_style_profiles[get_theme_mod("monawp_global_panel_buttons_box_shadow_style_profile", $monawp_customizer_defaults["monawp_buttons_box_shadow_style_profiles"])]["box-shadow"]).' !important;
					';
				}
				
				$monawp_ConstructedCssGlobal .= '
				line-height: 1 !important;
				padding:'.esc_attr(get_theme_mod("monawp_global_panel_buttons_vertical_padding", $monawp_customizer_defaults["monawp_buttons_padding"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_buttons_horizontal_padding", $monawp_customizer_defaults["monawp_buttons_padding"])).'rem !important;
				cursor:pointer;
				transition: all 0.5s ease !important;
				font-size: inherit !important;
				-webkit-appearance: button !important;
				color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
				background-color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["background"]).' !important;
			}
			
			'.$monawp_buttons_inner_css_selector.' {
				color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
				fill:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
				transition: all 0.25s ease;
			}
			
			';

			if (get_theme_mod('monawp_global_panel_buttons_hover_effect', $monawp_customizer_defaults['monawp_global_panel_buttons_hover_effect'])) {
				
				$monawp_ConstructedCssGlobal .= 
				$monawp_buttons_hover_focus_css_selector.' {
					
					color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus"])]["color"]).' !important;
					background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus"])]["background"]).' !important;
					';
					
					if ($monawp_box_shadow_style_profiles[get_theme_mod("monawp_global_panel_buttons_box_shadow_hover_focus_style_profile", $monawp_customizer_defaults["monawp_buttons_box_shadow_style_profiles"])]["box-shadow"] !== 'none') {
						$monawp_ConstructedCssGlobal .= '
						box-shadow:'.esc_attr($monawp_box_shadow_style_profiles[get_theme_mod("monawp_global_panel_buttons_box_shadow_hover_focus_style_profile", $monawp_customizer_defaults["monawp_buttons_box_shadow_style_profiles"])]["box-shadow"]).' !important;
						';
					}
					
					$monawp_ConstructedCssGlobal .= '
					
				}
				
				'.$monawp_buttons_inner_hover_focus_css_selector.' {
					color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus"])]["color"]).' !important;
					fill:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus"])]["color"]).' !important;
					transition: all 0.25s ease;
				}
				
				';
				
			} else {
				
				$monawp_ConstructedCssGlobal .= 
				$monawp_buttons_hover_focus_css_selector.' {
					color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
					background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["background"]).' !important;
				}
				
				'.$monawp_buttons_inner_hover_focus_css_selector.' {
					color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
					fill:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
					transition: all 0.25s ease;
				}
				
				';
				
			}
			
			
			$monawp_ConstructedCssGlobal .= '
			
			#page.site .horizontal-navigation-desktop button.menu-toggle,#page.site .main-site-wrapper button.left-sidebar-wrapper-toggle {
				font-size:1.6rem !important;
			}
			
			'.$monawp_buttons__focus_css_selector.' {
				outline:2px dashed;
			}

			textarea {
				overflow: auto;
			}
			
			.monawp-element-wrapper {
				padding:'.esc_attr(get_theme_mod("monawp_global_panel_element_wrapper_vertical_padding", $monawp_customizer_defaults["monawp_element_wrapper_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_element_wrapper_horizontal_padding", $monawp_customizer_defaults["monawp_element_wrapper_spacing"])).'rem;
				margin:'.esc_attr(get_theme_mod("monawp_global_panel_element_wrapper_vertical_margin", $monawp_customizer_defaults["monawp_element_wrapper_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_element_wrapper_horizontal_margin", $monawp_customizer_defaults["monawp_element_wrapper_spacing"])).'rem;
						
			}
			
			section.widget .monawp-element-wrapper {
				padding:0;
				margin:0
			}
			
			';
			
			// Get the column count from the theme mod, defaulting to 1 if not set
			$main_content_column_count_blog = esc_attr(get_theme_mod('monawp_blog_panel_main_content_grid_preset', $monawp_customizer_defaults['monawp_main_content_grid_preset']));
			
			// Get the article spacing settings
			$article_vertical_padding = esc_attr(get_theme_mod('monawp_global_panel_article_vertical_padding', $monawp_customizer_defaults['monawp_article_spacing_vertical']));
			$article_horizontal_padding = esc_attr(get_theme_mod('monawp_global_panel_article_horizontal_padding', $monawp_customizer_defaults['monawp_article_spacing_horizontal']));
			$article_column_gap = esc_attr(get_theme_mod('monawp_global_panel_article_column_gap', $monawp_customizer_defaults['monawp_article_spacing_vertical']));
			$article_row_gap = esc_attr(get_theme_mod('monawp_global_panel_article_row_gap', $monawp_customizer_defaults['monawp_article_spacing_horizontal']));
			
			$monawp_ConstructedCssGlobal .= '
			
			main#primary.site-main {
				row-gap: '.$article_row_gap.'rem;
				column-gap: '.$article_column_gap.'rem;
			}

			main#primary.site-main > article.hentry {
				padding: '.$article_vertical_padding.'rem '.$article_horizontal_padding.'rem;
			}
			
			aside section.widget,footer#colophon section.widget {
				padding:'.esc_attr(get_theme_mod("monawp_global_panel_widget_vertical_padding", $monawp_customizer_defaults["monawp_widget_spacing_vertical"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_widget_horizontal_padding", $monawp_customizer_defaults["monawp_widget_spacing_horizontal"])).'rem;
				margin:'.esc_attr(get_theme_mod("monawp_global_panel_widget_vertical_margin", $monawp_customizer_defaults["monawp_widget_spacing_vertical"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_widget_horizontal_margin", $monawp_customizer_defaults["monawp_widget_spacing_horizontal"])).'rem;
			}
			
			footer#colophon section.widget {
				min-width: 220px;
			}
			
			section.widget .wp-block-heading {
				padding-bottom:0.4rem;
			}
			
			header.entry-header,.entry-content,footer.entry-footer,article .post-thumbnail {
				padding:0.3rem 0;
			}
			
			article .post-thumbnail {
				margin:0.6rem 0;
			}
			
			.entry-content::after {
				content: "";
				display: table;
				clear: both;
			}
			
			.wp-block-latest-posts,.wp-block-archives,.wp-block-categories {
				margin-left:0;
				list-style: square;
				list-style-position: inside;
			}
			
			.wp-block-latest-posts li,.wp-block-archives li,.wp-block-categories li{
				padding: 0.6rem;
				margin: 0.6rem 0;
			}
			
			.wp-block-latest-posts li,.wp-block-archives li,.wp-block-categories li {
				background: var(--monawp-special-contrast-color);
				color: var(--monawp-main-color);
			}
			
			.wp-block-latest-posts li a, .wp-block-latest-posts li a:hover, .wp-block-latest-posts li a:focus, .wp-block-latest-posts li a:visited, .wp-block-archives li a, .wp-block-archives li a:hover, .wp-block-archives li a:focus, .wp-block-archives li a:visited,.wp-block-categories li a, .wp-block-categories li a:hover, .wp-block-categories li a:focus, .wp-block-categories li a:visited {
				color: var(--monawp-main-color);
			}
			
			';
			
			$monawp_ConstructedCssGlobal .= '
			
			#primary.site-main article.hentry.sticky {
				border:5px double var(--monawp-special-secondary-color);
			}
			
			.entry-content > *:last-child,section.widget > *:last-child { 
				margin-bottom:0;
			}
			
			.cat-links,.tags-links,div.byline,div.posted-on,div.comments-link {
				display:flex;
				flex-flow:row wrap;
				align-items: center;
			}
			
			.cat-links > *,.tags-links > *,div.byline > *,div.posted-on > *,div.comments-link > * {
				margin:0.3rem;
			}
			
			.cat-links > a,.tags-links > a,div.byline > a,div.comments-link > a,div.posted-on > a {
				padding:0.6rem;
				background:var(--monawp-secondary-contrast-color);
			}
			
			';
			
			$monawp_ConstructedCssGlobal .= '

			.search-wrapper {
				display:none;
			}
			
			.search-wrapper.show form input,.search-wrapper.show form label{
				margin:0 !important;
				width:100%
			}
			
			.search-wrapper.show form {
				gap:0.8rem;
			}
			
			.search-wrapper.show {
				display: flex;
				position: fixed;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				padding: 1.5rem;
				background: var(--monawp-main-contrast-color);
				border: 10px solid var(--monawp-main-color);
				box-shadow: 10px 10px 0px 0px var(--monawp-special-contrast-color);
				z-index: 99999;
				transition: all 0.5s ease;
				width: 75%;
				gap: 0.8rem;
				flex-flow: column;
			}
			
			.search-wrapper.show:hover {
				box-shadow: none;
				transition: all 0.5s ease;
			}
			
			.search-wrapper.show form  {
				display: flex;
				flex-direction:column;
			}
			
			.monawp_search_element {
				display:flex;
				flex-direction:row;
				align-items:center;
				justify-content: center;
			}
			
			';
			
			if (function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
				$monawp_ConstructedCssGlobal .= '
					img.custom-logo {
						max-width:'.esc_attr(get_theme_mod("monawp_logo_max_width", $monawp_customizer_defaults["monawp_logo_max_width"])).'px;
						vertical-align: middle;
					}
					';
			}
			
			$monawp_ConstructedCssGlobal .= '
			
			#masthead.site-header,footer#colophon,.main-site-wrapper {
				clear:both;
				width:100%;
			}
			';
			
			if ( get_theme_mod('monawp_topbar_panel_layout_enable', $monawp_customizer_defaults['monawp_topbar_enable']) ) {
				$monawp_ConstructedCssGlobal .= '
			
					.header-topbar {
						padding:'.esc_attr(get_theme_mod("monawp_topbar_panel_topbar_vertical_padding", $monawp_customizer_defaults["monawp_topbar_padding"])).'rem '.esc_attr(get_theme_mod("monawp_topbar_panel_topbar_horizontal_padding", $monawp_customizer_defaults["monawp_topbar_padding"])).'rem;
						background:'.esc_attr(get_theme_mod("monawp_topbar_panel_topbar_color_background_profile", $monawp_customizer_defaults["monawp_topbar_background_color_profile"])).';
						border-bottom:1px solid var(--monawp-tertiary-contrast-color)
					}
					';
			}
			
			$monawp_ConstructedCssGlobal .= '
			
			#masthead.site-header {
				padding:'.esc_attr(get_theme_mod("monawp_header_panel_header_vertical_padding", $monawp_customizer_defaults["monawp_header_padding"])).'rem '.esc_attr(get_theme_mod("monawp_header_panel_header_horizontal_padding", $monawp_customizer_defaults["monawp_header_padding"])).'rem;
				background:'.esc_attr(get_theme_mod("monawp_header_panel_header_color_background_profile", $monawp_customizer_defaults["monawp_header_background_color_profile"])).';
				box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px;
			}
			
			#masthead.site-header.transparent {
				background:transparent;
			}
			
			footer#colophon {
				padding:'.esc_attr(get_theme_mod("monawp_footer_panel_footer_vertical_padding", $monawp_customizer_defaults["monawp_footer_padding"])).'rem '.esc_attr(get_theme_mod("monawp_footer_panel_footer_horizontal_padding", $monawp_customizer_defaults["monawp_footer_padding"])).'rem;
				background:'.esc_attr(get_theme_mod("monawp_footer_panel_footer_color_background_profile", $monawp_customizer_defaults["monawp_footer_background_color_profile"])).';
				
			}
			
			';

			$socials_border_radius_css = '';

			if (get_theme_mod('monawp_socials_panel_socials_border_radius_top-left', $monawp_customizer_defaults["monawp_socials_border_radius"]) != 0) {
				$socials_border_radius_css .= 'border-top-left-radius:' . esc_attr(get_theme_mod('monawp_socials_panel_socials_border_radius_top-left', $monawp_customizer_defaults["monawp_socials_border_radius"])) . 'rem;';
			}
			if (get_theme_mod('monawp_socials_panel_socials_border_radius_top-right', $monawp_customizer_defaults["monawp_socials_border_radius"]) != 0) {
				$socials_border_radius_css .= 'border-top-right-radius:' . esc_attr(get_theme_mod('monawp_socials_panel_socials_border_radius_top-right', $monawp_customizer_defaults["monawp_socials_border_radius"])) . 'rem;';
			}
			if (get_theme_mod('monawp_socials_panel_socials_border_radius_bottom-left', $monawp_customizer_defaults["monawp_socials_border_radius"]) != 0) {
				$socials_border_radius_css .= 'border-bottom-left-radius:' . esc_attr(get_theme_mod('monawp_socials_panel_socials_border_radius_bottom-left', $monawp_customizer_defaults["monawp_socials_border_radius"])) . 'rem;';
			}
			if (get_theme_mod('monawp_socials_panel_socials_border_radius_bottom-right', $monawp_customizer_defaults["monawp_socials_border_radius"]) != 0) {
				$socials_border_radius_css .= 'border-bottom-right-radius:' . esc_attr(get_theme_mod('monawp_socials_panel_socials_border_radius_bottom-right', $monawp_customizer_defaults["monawp_socials_border_radius"])) . 'rem;';
			}

			if (Helpers::areSocialProfilesAdded()) {
				
				$monawp_ConstructedCssGlobal .= '
				
					.monawp_socials_element {
						gap:'.esc_attr(get_theme_mod("monawp_socials_panel_socials_gap", $monawp_customizer_defaults["monawp_socials_gap"])).'rem;
					}
				
					.monawp_socials_element > div a {
						display: block;
						'.$socials_border_radius_css.'
						';
						
						if ($monawp_border_style_profiles[get_theme_mod("monawp_socials_panel_socials_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"] !== 'none') {
							$monawp_ConstructedCssGlobal .= '
							border:'.esc_attr($monawp_border_style_profiles[get_theme_mod("monawp_socials_panel_socials_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"]).';
							';
						}
						if ($monawp_border_bottom_style_profiles[get_theme_mod("monawp_socials_panel_socials_border_bottom_style_profile", $monawp_customizer_defaults["monawp_border_bottom_style_profiles"])]["border-bottom"] !== 'none') {
							$monawp_ConstructedCssGlobal .= '
							border-bottom:'.esc_attr($monawp_border_bottom_style_profiles[get_theme_mod("monawp_socials_panel_socials_border_bottom_style_profile", $monawp_customizer_defaults["monawp_border_bottom_style_profiles"])]["border-bottom"]).';
							';
						}
						$monawp_ConstructedCssGlobal .= '
						padding:'.esc_attr(get_theme_mod("monawp_socials_panel_socials_vertical_padding", $monawp_customizer_defaults["monawp_socials_padding"])*0.99).'rem '.esc_attr(get_theme_mod("monawp_socials_panel_socials_horizontal_padding", $monawp_customizer_defaults["monawp_socials_padding"])*0.99).'rem;
						';
						if ($monawp_box_shadow_style_profiles[get_theme_mod("monawp_socials_panel_socials_box_shadow_style_profile", $monawp_customizer_defaults["monawp_socials_box_shadow_style_profiles"])]["box-shadow"] !== 'none') {
							$monawp_ConstructedCssGlobal .= '
							box-shadow:'.esc_attr($monawp_box_shadow_style_profiles[get_theme_mod("monawp_socials_panel_socials_box_shadow_style_profile", $monawp_customizer_defaults["monawp_socials_box_shadow_style_profiles"])]["box-shadow"]).';
							';
						}
						$monawp_ConstructedCssGlobal .= '
						background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_socials_panel_socials_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles_2"])]["background"]).';
						transition: all 0.5s ease;
					}
					
					.monawp_socials_element > div a svg {
						fill:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_socials_panel_socials_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles_2"])]["color"]).';
						transition: all 0.5s ease;
					}
				';
					
				if (get_theme_mod('monawp_socials_panel_socials_hover_effect', $monawp_customizer_defaults['monawp_socials_panel_socials_hover_effect'])) {
					
					$monawp_ConstructedCssGlobal .= '
					.monawp_socials_element > div a:hover,.monawp_socials_element > div a:focus {
						background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_socials_panel_socials_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus_2"])]["background"]).';
						transition: all 0.5s ease;
						';
						
						if ($monawp_box_shadow_style_profiles[get_theme_mod("monawp_socials_panel_socials_box_shadow_hover_focus_style_profile", $monawp_customizer_defaults["monawp_socials_box_shadow_style_profiles"])]["box-shadow"] !== 'none') {
							$monawp_ConstructedCssGlobal .= '
							box-shadow:'.esc_attr($monawp_box_shadow_style_profiles[get_theme_mod("monawp_socials_panel_socials_box_shadow_hover_focus_style_profile", $monawp_customizer_defaults["monawp_buttons_box_shadow_style_profiles"])]["box-shadow"]).';
							';
						}

						$monawp_ConstructedCssGlobal .= '
						
					}
					.monawp_socials_element > div a:hover svg,.monawp_socials_element > div a:focus svg {
						transition: all 0.5s ease;
						fill:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_socials_panel_socials_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus_2"])]["color"]).';
					}

					';
					
				}
				
			}
			
			if (Helpers::isGenericInfoAdded()) {

				$monawp_ConstructedCssGlobal .= '

					.monawp_generic_info_element {
						display:flex;
						flex-direction:row;
						gap:'.esc_attr(get_theme_mod("monawp_socials_panel_socials_gap", $monawp_customizer_defaults["monawp_socials_gap"])).'rem;
						justify-content: center;
					}
				
					.monawp_generic_info_element > * {
						display:flex;
						flex-direction:row;
						vertical-align:middle;
						align-items: center;
						gap:'.esc_attr(get_theme_mod("monawp_socials_panel_socials_gap", $monawp_customizer_defaults["monawp_socials_gap"])).'rem;
					}
				
					.monawp_generic_info_element > div a {
						display: block;
						border-radius:0;
						'.$socials_border_radius_css.'
						';
						if ($monawp_border_style_profiles[get_theme_mod("monawp_socials_panel_socials_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"] !== 'none') {
							$monawp_ConstructedCssGlobal .= '
							border:'.esc_attr($monawp_border_style_profiles[get_theme_mod("monawp_socials_panel_socials_border_style_profile", $monawp_customizer_defaults["monawp_border_style_profiles"])]["border"]).';
							';
						}
						if ($monawp_border_bottom_style_profiles[get_theme_mod("monawp_socials_panel_socials_border_bottom_style_profile", $monawp_customizer_defaults["monawp_border_bottom_style_profiles"])]["border-bottom"] !== 'none') {
							$monawp_ConstructedCssGlobal .= '
							border-bottom:'.esc_attr($monawp_border_bottom_style_profiles[get_theme_mod("monawp_socials_panel_socials_border_bottom_style_profile", $monawp_customizer_defaults["monawp_border_bottom_style_profiles"])]["border-bottom"]).';
							';
						}
						$monawp_ConstructedCssGlobal .= '
						padding:'.esc_attr(get_theme_mod("monawp_socials_panel_socials_vertical_padding", $monawp_customizer_defaults["monawp_socials_padding"])).'rem '.esc_attr(get_theme_mod("monawp_socials_panel_socials_horizontal_padding", $monawp_customizer_defaults["monawp_socials_padding"])).'rem;
						';
						if ($monawp_box_shadow_style_profiles[get_theme_mod("monawp_socials_panel_socials_box_shadow_style_profile", $monawp_customizer_defaults["monawp_socials_box_shadow_style_profiles"])]["box-shadow"] !== 'none') {
							$monawp_ConstructedCssGlobal .= '
							box-shadow:'.esc_attr($monawp_box_shadow_style_profiles[get_theme_mod("monawp_socials_panel_socials_box_shadow_style_profile", $monawp_customizer_defaults["monawp_socials_box_shadow_style_profiles"])]["box-shadow"]).';
							';
						}
						$monawp_ConstructedCssGlobal .= '
						background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_socials_panel_socials_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles_2"])]["background"]).';
						transition: all 0.5s ease;
					}
					
					.monawp_generic_info_element > div a svg {
						fill:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_socials_panel_socials_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles_2"])]["color"]).';
						transition: all 0.5s ease;
					}
				';
					
				if (get_theme_mod('monawp_socials_panel_socials_hover_effect', $monawp_customizer_defaults['monawp_socials_panel_socials_hover_effect'])) {
					
					$monawp_ConstructedCssGlobal .= '
					.monawp_generic_info_element > div a:hover,.monawp_generic_info_element > div a:focus {
						background:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_socials_panel_socials_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus_2"])]["background"]).';
						transition: all 0.5s ease;
						';
						
						if ($monawp_box_shadow_style_profiles[get_theme_mod("monawp_socials_panel_socials_box_shadow_hover_focus_style_profile", $monawp_customizer_defaults["monawp_socials_box_shadow_style_profiles"])]["box-shadow"] !== 'none') {
							$monawp_ConstructedCssGlobal .= '
							box-shadow:'.esc_attr($monawp_box_shadow_style_profiles[get_theme_mod("monawp_socials_panel_socials_box_shadow_hover_focus_style_profile", $monawp_customizer_defaults["monawp_buttons_box_shadow_style_profiles"])]["box-shadow"]).';
							';
						}

						$monawp_ConstructedCssGlobal .= '
						
					}
					.monawp_generic_info_element > div a:hover svg,.monawp_generic_info_element > div a:focus svg {
						transition: all 0.5s ease;
						fill:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_socials_panel_socials_color_background_profile_hover_focus", $monawp_customizer_defaults["monawp_color_background_profiles_hover_focus_2"])]["color"]).';
					}

					';
					
				}
				
			}
			
			
			$monawp_ConstructedCssGlobal .= '
			
			.main-site-wrapper {
				padding:'.esc_attr(get_theme_mod("monawp_global_panel_main_site_wrapper_vertical_padding", $monawp_customizer_defaults["monawp_main_site_wrapper_padding_v"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_main_site_wrapper_horizontal_padding", $monawp_customizer_defaults["monawp_main_site_wrapper_padding"])).'rem;
				margin:0 auto;
				max-width:'.esc_attr(get_theme_mod("monawp_global_panel_main_site_wrapper_max_width", $monawp_customizer_defaults["monawp_main_site_wrapper_max_width"])).'px;
				display:flex;
				flex-direction:row;
				flex-wrap: wrap;
				justify-content:center;
			}
			
			.left-sidebar-wrapper {
				min-width:230px;
				width:'.esc_attr(get_theme_mod("monawp_left_sidebar_panel_left_sidebar_width", $monawp_customizer_defaults["monawp_left_sidebar_width"])).'%;
				padding:'.esc_attr(get_theme_mod("monawp_left_sidebar_panel_left_sidebar_vertical_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_left_sidebar_panel_left_sidebar_horizontal_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem;
				margin:'.esc_attr(get_theme_mod("monawp_left_sidebar_panel_left_sidebar_vertical_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_left_sidebar_panel_left_sidebar_horizontal_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem;
				background:'.esc_attr(get_theme_mod("monawp_left_sidebar_panel_left_sidebar_color_background_profile", $monawp_customizer_defaults["monawp_left_sidebar_background_color_profile"])).';
			}
			
			.main-content-wrapper {
				min-width:430px;
				width:'.esc_attr(get_theme_mod("monawp_main_content_panel_main_content_width", $monawp_customizer_defaults["monawp_main_content_width"])).'%;
				padding:'.esc_attr(get_theme_mod("monawp_main_content_panel_main_content_vertical_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_main_content_panel_main_content_horizontal_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem;
				margin:'.esc_attr(get_theme_mod("monawp_main_content_panel_main_content_vertical_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_main_content_panel_main_content_horizontal_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem;
				background:'.esc_attr(get_theme_mod("monawp_main_content_panel_main_content_color_background_profile", $monawp_customizer_defaults["monawp_main_content_background_color_profile"])).';
			}
			
			';
			
			if (get_theme_mod("monawp_blog_panel_blog_main_content_width", $monawp_customizer_defaults["monawp_main_content_width"]) != get_theme_mod("monawp_main_content_panel_main_content_width", $monawp_customizer_defaults["monawp_main_content_width"])) {
				$monawp_ConstructedCssGlobal .= '
				body.blog .main-content-wrapper {
					width:'.esc_attr(get_theme_mod("monawp_blog_panel_blog_main_content_width", $monawp_customizer_defaults["monawp_main_content_width"])).'%;
				}
				';
			}
			
			if (get_theme_mod("monawp_page_panel_page_main_content_width", $monawp_customizer_defaults["monawp_main_content_width"]) != get_theme_mod("monawp_main_content_panel_main_content_width", $monawp_customizer_defaults["monawp_main_content_width"])) {
				$monawp_ConstructedCssGlobal .= '
				body.page-template-default .main-content-wrapper {
					width:'.esc_attr(get_theme_mod("monawp_page_panel_page_main_content_width", $monawp_customizer_defaults["monawp_main_content_width"])).'%;
				}
				';
			}
			
			$monawp_ConstructedCssGlobal .= '
			
			.right-sidebar-wrapper {
				min-width:230px;
				width:'.esc_attr(get_theme_mod("monawp_right_sidebar_panel_right_sidebar_width", $monawp_customizer_defaults["monawp_right_sidebar_width"])).'%;
				padding:'.esc_attr(get_theme_mod("monawp_right_sidebar_panel_right_sidebar_vertical_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_right_sidebar_panel_right_sidebar_horizontal_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem;
				margin:'.esc_attr(get_theme_mod("monawp_right_sidebar_panel_right_sidebar_vertical_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_right_sidebar_panel_right_sidebar_horizontal_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem;
				background:'.esc_attr(get_theme_mod("monawp_right_sidebar_panel_right_sidebar_color_background_profile", $monawp_customizer_defaults["monawp_right_sidebar_background_color_profile"])).';
			}
			
			.copyright {
				text-align:center;
				padding:0.8rem;
				display:flex;
				flex-flow:row wrap;
				justify-content:center;
				background:var(--monawp-main-color)
			}
			
			.copyright *,.copyright *:hover,.copyright *:focus,.copyright *:visited {
				color: var(--monawp-main-contrast-color)
			}
			
			';
			
			if ( get_theme_mod('monawp_topbar_panel_layout_enable', $monawp_customizer_defaults['monawp_topbar_enable']) ) {
				$monawp_ConstructedCssGlobal .= '
					.monawp-topbar-inner-wrapper {
						display:flex;
					';
				
					if (get_theme_mod("monawp_topbar_panel_layout_flex_direction", $monawp_customizer_defaults["monawp_topbar_flex_direction"]) != '') {
						$monawp_ConstructedCssGlobal .= '
						flex-direction:'.esc_attr(get_theme_mod("monawp_topbar_panel_layout_flex_direction", $monawp_customizer_defaults["monawp_topbar_flex_direction"])).';
						';
					}
					
					$monawp_ConstructedCssGlobal .= '
					align-items: center;
					flex-wrap:wrap;
					row-gap:'.esc_attr(get_theme_mod("monawp_topbar_panel_topbar_vertical_padding", $monawp_customizer_defaults["monawp_topbar_padding"])*100/2/100).'rem;
					column-gap:'.esc_attr(get_theme_mod("monawp_topbar_panel_topbar_horizontal_padding", $monawp_customizer_defaults["monawp_topbar_padding"])*100/2/100).'rem;
					';
					
					if (get_theme_mod("monawp_topbar_panel_layout_justify_content", $monawp_customizer_defaults["monawp_topbar_justify_content"]) != '') {
						$monawp_ConstructedCssGlobal .= '
						justify-content:'.esc_attr(get_theme_mod("monawp_topbar_panel_layout_justify_content", $monawp_customizer_defaults["monawp_topbar_justify_content"])).';
						';
					}
					
					$monawp_ConstructedCssGlobal .= '
					
					max-width:'.esc_attr(get_theme_mod("monawp_topbar_panel_topbar_max_width", $monawp_customizer_defaults["monawp_topbar_max_width"])).'px;
				}
				
				';
			}
			
			$monawp_ConstructedCssGlobal .= '
	
			.monawp-header-inner-wrapper {
				display:flex;
				';
				
				if (get_theme_mod("monawp_header_panel_layout_flex_direction", $monawp_customizer_defaults["monawp_header_flex_direction"]) != '') {
					$monawp_ConstructedCssGlobal .= '
					flex-direction:'.esc_attr(get_theme_mod("monawp_header_panel_layout_flex_direction", $monawp_customizer_defaults["monawp_header_flex_direction"])).';
					';
				}
				
				$monawp_ConstructedCssGlobal .= '
				align-items: center;
				flex-wrap:wrap;
				row-gap:'.esc_attr(get_theme_mod("monawp_header_panel_header_vertical_padding", $monawp_customizer_defaults["monawp_header_padding"])*100/2/100).'rem;
				column-gap:'.esc_attr(get_theme_mod("monawp_header_panel_header_horizontal_padding", $monawp_customizer_defaults["monawp_header_padding"])*100/2/100).'rem;
				';
				
				if (get_theme_mod("monawp_header_panel_layout_justify_content", $monawp_customizer_defaults["monawp_header_justify_content"]) != '') {
					$monawp_ConstructedCssGlobal .= '
					justify-content:'.esc_attr(get_theme_mod("monawp_header_panel_layout_justify_content", $monawp_customizer_defaults["monawp_header_justify_content"])).';
					';
				}
				
				$monawp_ConstructedCssGlobal .= '
				
				max-width:'.esc_attr(get_theme_mod("monawp_header_panel_header_max_width", $monawp_customizer_defaults["monawp_header_max_width"])).'px;
			}
			
			.monawp-header-inner-wrapper > div {
				row-gap:'.esc_attr(get_theme_mod("monawp_header_panel_header_vertical_padding", $monawp_customizer_defaults["monawp_header_padding"])*100/2/100).'rem;
				column-gap:'.esc_attr(get_theme_mod("monawp_header_panel_header_horizontal_padding", $monawp_customizer_defaults["monawp_header_padding"])*100/2/100).'rem;
			}
			
			/* Text meant only for screen readers. */
			.screen-reader-text {
				border: 0;
				clip: rect(1px, 1px, 1px, 1px);
				clip-path: inset(50%);
				height: 1px;
				margin: -1px;
				overflow: hidden;
				padding: 0;
				position: absolute !important;
				width: 1px;
				word-wrap: normal !important;
			}

			.screen-reader-text:focus {
				background-color: var(--monawp-main-color);
				border-radius: 3px;
				box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.6);
				clip: auto !important;
				clip-path: none;
				color: var(--monawp-main-contrast-color);
				display: block;
				height: auto;
				left: 5px;
				padding: 1rem;
				text-decoration: none;
				top: 5px;
				width: auto;
				z-index: 100000;
			}
			
			
			.monawp-footer-inner-wrapper {
				margin:0 auto;
				display:flex;
					';
				
					if (get_theme_mod("monawp_footer_panel_layout_flex_direction", $monawp_customizer_defaults["monawp_footer_flex_direction"]) != '') {
						$monawp_ConstructedCssGlobal .= '
						flex-direction:'.esc_attr(get_theme_mod("monawp_footer_panel_layout_flex_direction", $monawp_customizer_defaults["monawp_footer_flex_direction"])).';
						';
					}
					
					$monawp_ConstructedCssGlobal .= '
				align-items: center;
				flex-wrap:wrap;
				row-gap:'.esc_attr(get_theme_mod("monawp_footer_panel_footer_vertical_padding", $monawp_customizer_defaults["monawp_footer_padding"])*100/2/100).'rem;
				column-gap:'.esc_attr(get_theme_mod("monawp_footer_panel_footer_horizontal_padding", $monawp_customizer_defaults["monawp_footer_padding"])*100/2/100).'rem;
				';
				
				if (get_theme_mod("monawp_footer_panel_layout_justify_content", $monawp_customizer_defaults["monawp_footer_justify_content"]) != '') {
					$monawp_ConstructedCssGlobal .= '
					justify-content:'.esc_attr(get_theme_mod("monawp_footer_panel_layout_justify_content", $monawp_customizer_defaults["monawp_footer_justify_content"])).';
					';
				}
				
				$monawp_ConstructedCssGlobal .= '
				max-width:'.esc_attr(get_theme_mod("monawp_footer_panel_footer_max_width", $monawp_customizer_defaults["monawp_footer_max_width"])).'px;
			}
			
			.monawp-footer-inner-wrapper > div {
				row-gap:'.esc_attr(get_theme_mod("monawp_footer_panel_footer_vertical_padding", $monawp_customizer_defaults["monawp_footer_padding"])*100/2/100).'rem;
				column-gap:'.esc_attr(get_theme_mod("monawp_footer_panel_footer_horizontal_padding", $monawp_customizer_defaults["monawp_footer_padding"])*100/2/100).'rem;
			}
			
			.widget::after {
				content: "";
				display: table;
				clear: both;
			}
			
			';
			
			$monawp_ConstructedCssGlobal .= '	
			.monawp_post_thumbnail_element a, .monawp_post_thumbnail_element .post-thumbnail {
				height: 100%;
				width: 100%;
				display: block;
				position: relative;
				overflow: hidden;
			}
			
			.monawp_post_thumbnail_element img {
				width: 100%;
				height: 100%;
				object-fit: cover;
				transform: scale(1.1); /* Slightly scale up to ensure it covers the container */
				transition: all 1s ease;
			}
			
			.monawp_post_thumbnail_element:hover img,.monawp_post_thumbnail_element a:focus img {
				transform: scale(1.13); /* Slightly scale up to ensure it covers the container */
				transition: all 1s ease;
			}
			
			/* Alignments
			--------------------------------------------- */
			.alignleft {

				/*rtl:ignore*/
				float: left;

				/*rtl:ignore*/
				margin: 0 0.6rem 0.6rem 0;
			}

			.alignright {

				/*rtl:ignore*/
				float: right;

				/*rtl:ignore*/
				margin: 0 0 0.6rem 0.6rem;
			}

			.aligncenter {
				clear: both;
				display: block;
				margin-left: auto;
				margin-right: auto;
				text-align:center;
				justify-content:center;
			}
			
			.wp-block-search__inside-wrapper {
				display: flex;
				flex-wrap: wrap;
				grid-gap: 0.8rem;
			}
			
			/* Breadcrumbs */
			
			.monawp_breadcrumbs_element .breadcrumbs {
				background: var(--monawp-secondary-contrast-color);
				display:flex;
				flex-flow:row wrap;
				padding:1.2rem;
			}
			
			.monawp_breadcrumbs_element .breadcrumbs * {
				display:flex;
				flex-flow:row wrap;
			}
			
			.monawp_breadcrumbs_element .breadcrumbs a {
				display:flex;
				flex-flow:row wrap;
			}
			
			.monawp_breadcrumbs_element .breadcrumbs .separator {
				padding:0 0.3rem;
			}

			';
			
			if (is_singular() ) {
				
				$monawp_ConstructedCssGlobal .= '

					/* Galleries
					--------------------------------------------- */
					.gallery {
						margin: 0 0 0.6rem 0;
						display: grid;
						grid-gap:0.6rem;
					}

					.gallery-item {
						display: inline-block;
						text-align: center;
						width: 100%;
					}

					.gallery-columns-2 {
						grid-template-columns: repeat(2, 1fr);
					}

					.gallery-columns-3 {
						grid-template-columns: repeat(3, 1fr);
					}

					.gallery-columns-4 {
						grid-template-columns: repeat(4, 1fr);
					}

					.gallery-columns-5 {
						grid-template-columns: repeat(5, 1fr);
					}

					.gallery-columns-6 {
						grid-template-columns: repeat(6, 1fr);
					}

					.gallery-columns-7 {
						grid-template-columns: repeat(7, 1fr);
					}

					.gallery-columns-8 {
						grid-template-columns: repeat(8, 1fr);
					}

					.gallery-columns-9 {
						grid-template-columns: repeat(9, 1fr);
					}

					.gallery-caption {
						display: block;
						margin-top:0.3rem;
					}
					';
			}
	
		$monawp_ConstructedCssGlobal .= '
		
		/* Page */
		
		.page-header-wrapper {
			padding:'.esc_attr(get_theme_mod("monawp_global_panel_article_vertical_padding", $monawp_customizer_defaults["monawp_article_spacing_vertical"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_article_horizontal_padding", $monawp_customizer_defaults["monawp_article_spacing_horizontal"])).'rem;
			margin:'.esc_attr(get_theme_mod("monawp_global_panel_article_vertical_margin", $monawp_customizer_defaults["monawp_article_spacing_vertical"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_article_horizontal_margin", $monawp_customizer_defaults["monawp_article_spacing_horizontal"])).'rem;
		}
		
		header.page-header,.page-content {
			padding:'.esc_attr(get_theme_mod("monawp_global_panel_article_vertical_padding", $monawp_customizer_defaults["monawp_article_spacing_vertical"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_article_horizontal_padding", $monawp_customizer_defaults["monawp_article_spacing_horizontal"])).'rem;
			margin:'.esc_attr(get_theme_mod("monawp_global_panel_article_vertical_margin", $monawp_customizer_defaults["monawp_article_spacing_vertical"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_article_horizontal_margin", $monawp_customizer_defaults["monawp_article_spacing_horizontal"])).'rem;
			border-bottom: 10px solid var(--monawp-main-color);
		}
		
		';
			
		if (Helpers::commentsAvailable() ) {
				
			$monawp_ConstructedCssGlobal .= '
				
			/* Comments
			--------------------------------------------- */
			
			footer.comment-meta {
				display:flex;
				flex-flow:row wrap;
				justify-content:space-between;
				align-items:center
			}

			.comments-area,.comment-respond {
				padding-top:1.2rem;
			}

			
			footer.comment-meta {
				gap: 0.6rem;
			}
			
			article.comment-body {
				padding:1.2rem 0;
				border-bottom:1px solid var(--monawp-main-color);
				gap: 0.6rem;
			}
			
			.comment-content {
				padding:1.2rem 0 0 0;
			}
			
			.comment-body .reply {
				padding:0.6rem 0 0 0;
			}
			
			.comment-content *:last-child {
				margin-bottom:0;
			}
			
			.comment-list {
				border-top:1px solid var(--monawp-main-color);
				list-style:none;
				margin:0 0 1.2rem 0;
			}
			
			.comment-list .trackback,.comment-list .pingback {
				margin:0.6rem 0;
			}
			
			.comment-list ol.children {
				list-style:none;
			}
			
			.comment-author.vcard, .comment-metadata {
				display: flex;
				align-items: center;
				gap: 0.6rem;
			}
			
			.comment-form-cookies-consent {
				margin-left:0.4rem;
				margin-right:0.4rem;
			}
			
			.comment-respond p {
				width:100%;
				margin:0
			}
			
			.comment-list li.comment.byuser article {
				border-left:3px solid var(--monawp-special-color);
				border-right:3px solid var(--monawp-special-color);
				padding:1.2rem;
			}
			
			';
		
		}
			
		if (Helpers::hasPagination() ) {
				
			$monawp_ConstructedCssGlobal .= '

			/* Pagination */
			
			.monawp-element-wrapper .pagination {
				display: flex;
				justify-content: center;
				align-items: center;
				background: var(--monawp-main-color);
				margin:'.esc_attr(get_theme_mod("monawp_global_panel_article_vertical_margin", $monawp_customizer_defaults["monawp_article_spacing_vertical"])).'rem '.get_theme_mod("monawp_global_panel_article_horizontal_margin", $monawp_customizer_defaults["monawp_article_spacing_horizontal"]).'rem;
					
			}

			.monawp-element-wrapper .pagination ul {
			  list-style: none;
			  display: flex;
			  flex-flow:row wrap;
			  padding: 0;
			  margin: 0;
			}

			.monawp-element-wrapper .pagination .page-numbers {
			  color: var(--monawp-main-contrast-color);
			  text-decoration: none;
			  padding:0.6rem 1.2rem;
			  height:100%;
			  display:block
			}

			.monawp-element-wrapper .pagination .page-numbers:hover,.monawp-element-wrapper .pagination .page-numbers:focus {
			  background: var(--monawp-special-contrast-color);
			  color: var(--monawp-main-color);
			}

			.monawp-element-wrapper .pagination .current {
			  background: var(--monawp-main-contrast-color);
			  color: var(--monawp-main-color);
			  font-weight: bold;
			}
			
			';
		
		}
			
		if (is_singular() or Helpers::isWooCommerceSingleProduct()) {
				
			$monawp_ConstructedCssGlobal .= '
			
			/* Post Navigation */
			
			.navigation.post-navigation .nav-links {
				display:flex;
				flex-flow: row wrap;
				justify-content:space-between
			}
			
			.navigation.post-navigation .nav-links a {
			  color: var(--monawp-main-color);
			  text-decoration: none;
			  padding:0.6rem;
			  height:100%;
			  display:block;
			  background: var(--monawp-special-contrast-color);
			}
			
			.navigation.post-navigation .nav-links a {
			  color: var(--monawp-main-color);
			  text-decoration: none;
			  padding:0.6rem;
			  height:100%;
			  display:block;
			  background: var(--monawp-special-contrast-color);
			  font-weight:bold;
			  transition: all 0.25s ease;
			}
			
			.navigation.post-navigation .nav-links a:hover,.navigation.post-navigation .nav-links a:focus {
			  color: var(--monawp-main-contrast-color);
			  background: var(--monawp-special-secondary-color);
			  transition: all 0.25s ease;
			}
			
		';
		
		}

	$monawp_ConstructedCssDesktop = '

		';
		
		if (!is_admin_bar_showing()) {
			$monawp_ConstructedCssDesktop .= '
				.sticky-header {
					position:sticky;
					z-index: 10002;
					top: 0px;
				}
			';
		} else {
			$monawp_ConstructedCssDesktop .= '
				.sticky-header {
					position:sticky;
					z-index: 10002;
					top: 32px;
				}
			';
		}
		
		$monawp_ConstructedCssDesktop .= '
		
			#monawp-right-sidebar,#left_sidebar_widget_one,#monawp-right-sidebar .widget__element,#left_sidebar_widget_one .widget__element {
				height:100%;
			}
		
		
		body.blog main#primary.site-main {
			display: grid;
			';

		// CSS grid-template-columns based on grid preset using a switch statement
		switch ($main_content_column_count_blog) {
			case '1':
		$monawp_ConstructedCssDesktop .= 'grid-template-columns: 1fr;}';
				break;
			case '2':
		$monawp_ConstructedCssDesktop .= 'grid-template-columns: 1fr 1fr;}';
				break;
			case '3':
$monawp_ConstructedCssDesktop .= 'grid-template-columns: 1fr 1fr 1fr;}';
				break;
			case '4':
				$monawp_ConstructedCssDesktop .= 'grid-template-columns: 1fr 1fr 1fr 1fr;}';
				break;
			case '5':
				$monawp_ConstructedCssDesktop .= 'grid-template-columns: 1fr 1fr;';
				$monawp_ConstructedCssDesktop .= '
				}
				body.blog main#primary.site-main > article.hentry:nth-child(1) {
					grid-column: span 2; 
				}
				body.blog main#primary.site-main > article.hentry:not(:nth-child(1)) {
					grid-column: span 1;
				}
				';
				break;
			case '6':
				$monawp_ConstructedCssDesktop .= 'grid-template-columns: 2fr 1fr 1fr;}';
				break;
			case '7':
				$monawp_ConstructedCssDesktop .= 'grid-template-columns: 5fr 3fr;}';
				break;
			case '8':
				$monawp_ConstructedCssDesktop .= 'grid-template-columns: 2fr 3fr;}';
				break;
			case '9':
				$monawp_ConstructedCssDesktop .= 'grid-template-columns: 3fr 2fr;}';
				break;
			case '10':
				$monawp_ConstructedCssDesktop .= 'grid-template-columns: 1fr 1fr 1fr;';
				$monawp_ConstructedCssDesktop .= '
				}
				body.blog main#primary.site-main > article.hentry:nth-child(1n) {
					grid-column: span 3; 
				}
				body.blog main#primary.site-main > article.hentry:nth-child(2n) {
					grid-column: span 2; 
				}
				body.blog main#primary.site-main > article.hentry:nth-child(3n) {
					grid-column: span 1;
				}
				body.blog main#primary.site-main > article.hentry:nth-child(4n) {
					grid-column: span 3; 
				}
				body.blog main#primary.site-main > article.hentry:nth-child(6n) {
					grid-column: span 3; 
				}
				';
				
				break;
			case '11':
				$monawp_ConstructedCssDesktop .= 'grid-template-columns: 7fr 5fr;}';
				break;
			default:
				$monawp_ConstructedCssDesktop .= 'grid-template-columns: 1fr;}';
				break;
		}

		$monawp_ConstructedCssDesktop .= '

		#monawp-right-sidebar .widget__element > *:last-child,#left_sidebar_widget_one .widget__element > *:last-child {
			position:sticky;
		}
		
		#page.site .widget_search form input {
			margin: 0.3rem 0; 
		}

		/* Navigation
		--------------------------------------------- */
		.horizontal-navigation-desktop {
			display: block;
			width: 100%;
		}

		.horizontal-navigation-desktop ul {
			display: flex;
			flex-direction:row;
			flex-wrap:wrap;
			list-style: none;
			margin: 0;
			padding: 0;
		}

		.horizontal-navigation-desktop ul ul {
			float: left;
			position: absolute;
			top: -9999em;
			z-index: 99999;
			width:100%;
			min-width:8rem;
		}

		.horizontal-navigation-desktop ul li:hover > ul,.horizontal-navigation-desktop ul li.focus > ul {
			top: 100%;
			display: block;
		}
		
		.horizontal-navigation-desktop ul ul li:hover > ul,.horizontal-navigation-desktop ul ul li.focus > ul {
			display: block;
			top: 0;
		}

		.horizontal-navigation-desktop ul ul li.open-left:hover > ul,.horizontal-navigation-desktop ul ul li.open-left.focus > ul {
			left:100%;
		}

		.horizontal-navigation-desktop ul li.open-left:hover > ul,.horizontal-navigation-desktop ul li.open-left.focus > ul {
			left: 0;
		}

		.horizontal-navigation-desktop ul ul li.open-right:hover > ul,.horizontal-navigation-desktop ul ul li.open-right.focus > ul {
			right:100%;
		}

		.horizontal-navigation-desktop ul li.open-right:hover > ul,.horizontal-navigation-desktop ul li.open-right.focus > ul {
			right: 0;
		}

		.horizontal-navigation-desktop ul ul a {
			width: 100%;
		}

		.horizontal-navigation-desktop li {
			position: relative;
		}

		.horizontal-navigation-desktop a {
			display: block;
			text-decoration: none;
		}

		/* Small menu. */
		.menu-toggle,.left-sidebar-wrapper-toggle {
			display: none;
		}

	';
	
	$calculated_font_size_laptop = $html_font_size*(1-(($html_font_size-16)*0.015));
	
	$monawp_ConstructedCssLaptop = '
		html {
			font-size:'.esc_attr((string)$calculated_font_size_laptop).'px;
		}
	';
	
	$calculated_font_size_tablet = $html_font_size*(1-(($html_font_size-16)*0.025));
	
	$monawp_ConstructedCssTablet = '
		
		html {
			font-size:'.esc_attr((string)$calculated_font_size_tablet).'px;
			line-height:'.esc_attr((string)get_theme_mod("monawp-html-line-height", $monawp_customizer_defaults["monawp-html-line-height"])*0.9).';
		}
		
		.monawp-header-inner-wrapper {
			justify-content:space-between;
		}
		
		
		';
		
		
		$all_header_tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

		foreach ($all_header_tags as $tag) {
			$font_size = get_theme_mod("monawp_global_".$tag."_font_size", $monawp_customizer_defaults["monawp_header_defaults"][$tag]["font-size"]);
			if ((float)$font_size > 2 and (float)$font_size <= 3) {
				$monawp_ConstructedCssTablet .= '
				'.$tag.' {
					font-size:'.esc_attr($font_size * 0.93).'rem;
				}
				';
			} else if ((float)$font_size >= 3 and (float)$font_size <= 3.5) {
				$monawp_ConstructedCssTablet .= '
				'.$tag.' {
					font-size:'.esc_attr($font_size * 0.87).'rem;
				}
				';
			} else if ((float)$font_size >= 3.5 and (float)$font_size <= 4) {
				$monawp_ConstructedCssTablet .= '
				'.$tag.' {
					font-size:'.esc_attr($font_size * 0.82).'rem;
				}
				';
			} else if ((float)$font_size >= 4 and (float)$font_size <= 4.5) {
				$monawp_ConstructedCssTablet .= '
				'.$tag.' {
					font-size:'.esc_attr($font_size * 0.77).'rem;
				}
				';
			} else if ((float)$font_size > 4.5) {
				$monawp_ConstructedCssTablet .= '
				'.$tag.' {
					font-size:'.esc_attr($font_size * 0.73).'rem;
				}
				';
			}
		}

		$monawp_ConstructedCssTablet .= '
		
		.flex-col-tablet {
			display:flex;
			flex-direction:column;
		}
		
		.widget__element {
			display:flex;
			flex-direction:column;
		}
		
		aside .widget__element {
			display:block;
		}

		.monawp-element-wrapper {
			padding:'.esc_attr(get_theme_mod("monawp_global_panel_element_wrapper_vertical_padding", $monawp_customizer_defaults["monawp_element_wrapper_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_element_wrapper_horizontal_padding", $monawp_customizer_defaults["monawp_element_wrapper_spacing"])*100/2/100).'rem;
			margin:'.esc_attr(get_theme_mod("monawp_global_panel_element_wrapper_vertical_margin", $monawp_customizer_defaults["monawp_element_wrapper_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_element_wrapper_horizontal_margin", $monawp_customizer_defaults["monawp_element_wrapper_spacing"])*100/2/100).'rem;			
		}

		.main-site-wrapper > div:not(.left-sidebar-wrapper) {
			display:block;
		}

		.left-sidebar-wrapper, .right-sidebar-wrapper,.main-content-wrapper,body.blog .main-content-wrapper,body.page-template-default .main-content-wrapper {
			width: 100%;
			min-width:100px;
		}
			
		.vertical-navigation-tablet,.monawp_search_element {
			display: block;
		}
		
		.gallery {
			grid-template-columns: repeat(1, 1fr);
		}
		
		body.blog main#primary.site-main {
			grid-template-columns: repeat('.max(round($main_content_column_count_blog/3), 1) .', 1fr);
		}

		.vertical-navigation-tablet ul {
			display: none;
			list-style: none;
			margin: 0 0 0 0;
			padding: 0 0 0 0;
			width:100%;
		}

		ul.vertical-navigation-tablet:first-of-type {
			padding:'.esc_attr(get_theme_mod("monawp_global_panel_horizontal_menu_vertical_padding", $monawp_customizer_defaults["monawp_horizontal_menu_padding"])).'rem 0;
			margin:'.esc_attr(get_theme_mod("monawp_global_panel_horizontal_menu_vertical_padding", $monawp_customizer_defaults["monawp_horizontal_menu_padding"])).'rem 0 0 0;
		}

		.vertical-navigation-tablet ul li {
			width:100%;
			display: block;
			clear: both;
		}

		.vertical-navigation-tablet ul li a {
			display: block;
		}
				
		.vertical-navigation-tablet ul li ul {
			width:auto;
			';
			if (is_rtl()) {
				$monawp_ConstructedCssTablet .= '
					margin: 0 '.esc_attr(get_theme_mod("monawp_global_panel_horizontal_menu_vertical_padding", $monawp_customizer_defaults["monawp_horizontal_menu_padding"])).'rem 0 0;
				';
			} else {
				$monawp_ConstructedCssTablet .= '
					margin: 0 0 0 '.esc_attr(get_theme_mod("monawp_global_panel_horizontal_menu_vertical_padding", $monawp_customizer_defaults["monawp_horizontal_menu_padding"])).'rem;
				';
			}
			$monawp_ConstructedCssTablet .= '
		}

		/* Small menu. */
		.menu-toggle,.left-sidebar-wrapper-toggle{
			display: block;
		}
		
		.vertical-navigation-tablet.toggled ul {
			display: block;
		}
		
		.main-site-wrapper {
			padding:'.esc_attr(get_theme_mod("monawp_global_panel_main_site_wrapper_vertical_padding", $monawp_customizer_defaults["monawp_main_site_wrapper_padding_v"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_main_site_wrapper_horizontal_padding", $monawp_customizer_defaults["monawp_main_site_wrapper_padding"])*100/2/100).'rem;
		}
		
		.left-sidebar-wrapper {
			padding:'.esc_attr(get_theme_mod("monawp_left_sidebar_panel_left_sidebar_vertical_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_left_sidebar_panel_left_sidebar_horizontal_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])*100/2/100).'rem;
			margin:'.esc_attr(get_theme_mod("monawp_left_sidebar_panel_left_sidebar_vertical_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_left_sidebar_panel_left_sidebar_horizontal_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])*100/2/100).'rem;
			display:none;
		}
		
			
		.left-sidebar-wrapper.show {
			display:block;
		}
		
		.main-content-wrapper {
			padding:'.esc_attr(get_theme_mod("monawp_main_content_panel_main_content_vertical_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_main_content_panel_main_content_horizontal_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])*100/2/100).'rem;
			margin:'.esc_attr(get_theme_mod("monawp_main_content_panel_main_content_vertical_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_main_content_panel_main_content_horizontal_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])*100/2/100).'rem;
		}
		
		.right-sidebar-wrapper {
			padding:'.esc_attr(get_theme_mod("monawp_right_sidebar_panel_right_sidebar_vertical_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_right_sidebar_panel_right_sidebar_horizontal_padding", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])*100/2/100).'rem;
			margin:'.esc_attr(get_theme_mod("monawp_right_sidebar_panel_right_sidebar_vertical_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])).'rem '.esc_attr(get_theme_mod("monawp_right_sidebar_panel_right_sidebar_horizontal_margin", $monawp_customizer_defaults["monawp_sidebar_content_spacing"])*100/2/100).'rem;
		}
		
		article.hentry {
			padding:'.esc_attr(get_theme_mod("monawp_global_panel_article_vertical_padding", $monawp_customizer_defaults["monawp_article_spacing_vertical"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_article_horizontal_padding", $monawp_customizer_defaults["monawp_article_spacing_horizontal"])*100/2/100).'rem;
			margin:'.esc_attr(get_theme_mod("monawp_global_panel_article_vertical_margin", $monawp_customizer_defaults["monawp_article_spacing_vertical"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_article_horizontal_margin", $monawp_customizer_defaults["monawp_article_spacing_horizontal"])*100/2/100).'rem;
		}
		
		aside section.widget,footer#colophon section.widget,footer#colophon .horizontal-navigation-desktop {
			padding:'.esc_attr(get_theme_mod("monawp_global_panel_widget_vertical_padding", $monawp_customizer_defaults["monawp_widget_spacing_vertical"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_widget_horizontal_padding", $monawp_customizer_defaults["monawp_widget_spacing_horizontal"])*100/2/100).'rem;
			margin:'.esc_attr(get_theme_mod("monawp_global_panel_widget_vertical_margin", $monawp_customizer_defaults["monawp_widget_spacing_vertical"])).'rem '.esc_attr(get_theme_mod("monawp_global_panel_widget_horizontal_margin", $monawp_customizer_defaults["monawp_widget_spacing_horizontal"])*100/2/100).'rem;
		}
		
		.monawp-topbar-inner-wrapper {
			justify-content: space-between;
		}
		
		aside section.widget,footer#colophon section.widget {
			width:fit-content;
			margin:0 auto;
		}
		
		.vertical-navigation-tablet button {
			margin:0 auto;
		}
		
		
	';
	
	$calculated_font_size_mobile = $html_font_size*(1-(($html_font_size-16)*0.03));
	
	$monawp_ConstructedCssMobile = '
		html {
			font-size:'.esc_attr((string)$calculated_font_size_mobile).'px;
			line-height:'.esc_attr((string)get_theme_mod("monawp-html-line-height", $monawp_customizer_defaults["monawp-html-line-height"])*0.85).';
		}
		
		
		';

		foreach ($all_header_tags as $tag) {
			$font_size = get_theme_mod("monawp_global_".$tag."_font_size", $monawp_customizer_defaults["monawp_header_defaults"][$tag]["font-size"]);
			if ((float)$font_size > 2 and (float)$font_size <= 3) {
				$monawp_ConstructedCssMobile .= '
				'.$tag.' {
					font-size:'.esc_attr($font_size * 0.85).'rem;
				}
				';
			} else if ((float)$font_size >= 3 and (float)$font_size <= 3.5) {
				$monawp_ConstructedCssMobile .= '
				'.$tag.' {
					font-size:'.esc_attr($font_size * 0.77).'rem;
				}
				';
			} else if ((float)$font_size >= 3.5 and (float)$font_size <= 4) {
				$monawp_ConstructedCssMobile .= '
				'.$tag.' {
					font-size:'.esc_attr($font_size * 0.72).'rem;
				}
				';
			} else if ((float)$font_size >= 4 and (float)$font_size <= 4.5) {
				$monawp_ConstructedCssMobile .= '
				'.$tag.' {
					font-size:'.esc_attr($font_size * 0.67).'rem;
				}
				';
			} else if ((float)$font_size > 4.5) {
				$monawp_ConstructedCssMobile .= '
				'.$tag.' {
					font-size:'.esc_attr($font_size * 0.62).'rem;
				}
				';
			}
		}

		$monawp_ConstructedCssMobile .= '
		
		
	';
	
	$monawp__root_values = ':root {
			--monawp-main-color:'.esc_attr(get_theme_mod('monawp-main-color', $monawp_customizer_defaults["monawp-main-color"])).';
			--monawp-secondary-color:'.esc_attr(get_theme_mod('monawp-secondary-color', $monawp_customizer_defaults["monawp-secondary-color"])).';
			--monawp-special-color:'.esc_attr(get_theme_mod('monawp-special-color', $monawp_customizer_defaults["monawp-special-color"])).';
			--monawp-special-secondary-color:'.esc_attr(get_theme_mod('monawp-special-secondary-color', $monawp_customizer_defaults["monawp-special-secondary-color"])).';
			--monawp-special-contrast-color:'.esc_attr(get_theme_mod('monawp-special-contrast-color', $monawp_customizer_defaults["monawp-special-contrast-color"])).';
			--monawp-main-contrast-color:'.esc_attr(get_theme_mod('monawp-main-contrast-color', $monawp_customizer_defaults["monawp-main-contrast-color"])).';
			--monawp-secondary-contrast-color:'.esc_attr(get_theme_mod('monawp-secondary-contrast-color', $monawp_customizer_defaults["monawp-secondary-contrast-color"])).';
			--monawp-tertiary-contrast-color:'.esc_attr(get_theme_mod('monawp-tertiary-contrast-color', $monawp_customizer_defaults["monawp-tertiary-contrast-color"])).';
			--monawp-headers-font-family:'.esc_attr(get_theme_mod('monawp-headers-font-family', $monawp_customizer_defaults["monawp-headers-font-family"])).';
	}';
	
	$monawp__root_values = cssConstructor::minimizeCss($monawp__root_values);
	
	$page_custom_css = cssConstructor::minimizeCss(get_theme_mod('monawp_page_panel_custom_css_custom_css', ''));

	if (!is_page()) {
		$page_custom_css = '';
	}
	
		// If the nested keys don't exist, use default CSS
	$constructed_css = MonaWP\cssConstructor::combineConstructedCss();

	//echo get_theme_mod('monawp-html-font-family', $monawp_customizer_defaults["monawp-html-font-family"]);
	// Output the CSS inline in the footer
	echo '<style id="monawp_current_constructed_css">' . $constructed_css . $page_custom_css . ' ' . $monawp__root_values.'</style>';

}

add_action('monawp_after_wp_head', 'monawp_enqueue_theme_mod_constructed_css');

function monawp_enqueue_plugin_misc_constructed_css() {

    global $monawp_custom_plugin_default_css, $monawp_customizer_defaults, $monawp_ConstructedCssGlobal;
	global $monawp_ConstructedCssDesktop;
	global $monawp_ConstructedCssLaptop;
	global $monawp_ConstructedCssTablet;
	global $monawp_ConstructedCssMobile;
	global $monawp_singular_pages_items;

    $monawp_ConstructedCssGlobal = '';
	$monawp_ConstructedCssDesktop = '';
	$monawp_ConstructedCssLaptop = '';
	$monawp_ConstructedCssTablet = '';
	$monawp_ConstructedCssMobile = '';
	
	if (is_rtl() and Helpers::isPluginEnabled('easy-table-of-contents/easy-table-of-contents.php')) {
		$monawp_custom_plugin_default_css['easy_toc']['custom_css'] .= '
		#ez-toc-container ul ul, .ez-toc div.ez-toc-widget-container ul ul {
			margin-left: 0;
			margin-right: 0.6rem;
		}
		';
	} else {
		$monawp_custom_plugin_default_css['easy_toc']['custom_css'] .= '
		#ez-toc-container ul ul, .ez-toc div.ez-toc-widget-container ul ul {
			margin-left: 0.6rem;
		}
		';
	}
	

    // Loop through plugins and add CSS based on conditions and theme mods
    foreach ($monawp_custom_plugin_default_css as $plugin_id => $plugin_data) {
        if (isset($plugin_data['condition']) && call_user_func($plugin_data['condition'])) {

			$theme_mod_key = "monawp_plugins_panel_{$plugin_id}_custom_css"; // Use a theme mod key for each plugin's CSS

			// Use theme mod if set, otherwise use default CSS
			$plugin_css = get_theme_mod($theme_mod_key, $plugin_data['custom_css']);
			$monawp_ConstructedCssGlobal .= $plugin_css;
			
        }
    }
	
	$article_vertical_padding = esc_attr(get_theme_mod('monawp_global_panel_article_vertical_padding', $monawp_customizer_defaults['monawp_article_spacing_vertical']));
	$article_horizontal_padding = esc_attr(get_theme_mod('monawp_global_panel_article_horizontal_padding', $monawp_customizer_defaults['monawp_article_spacing_horizontal']));
	
	$monawp_ConstructedCssGlobal .= '
	
			/* Safari 10.1+ (alternate method) */

			@media not all and (min-resolution:.001dpcm)
			{ @supports (-webkit-appearance:none) {

				#page.site form input[type=checkbox] {
					';
					if (is_rtl()) {
						$monawp_ConstructedCssGlobal .= '
							margin:0.95rem 0 0 0.6rem;
						';
					} else {
						$monawp_ConstructedCssGlobal .= '
							margin:0.95rem 0.6rem 0 0;
						';
					}
					$monawp_ConstructedCssGlobal .= '
				}
			}}
			
		.monawp-fade-in {
		  view-timeline: --subjectReveal block;
		  animation-timeline: view(450px);

		  animation-name: appear;
		  animation-fill-mode: both;
		  animation-duration: 1ms; /* Firefox requires this to apply the animation */
		}

		@keyframes appear {
		  from {
			opacity: 0;
			transform: scale(0.9);
		  }

		  to {
			opacity: 1;
			transform: scale(1);
		  }
		}
		
				.wp-block-tag-cloud {
					display:flex;
					flex-flow:row wrap;
					gap:0.6rem;
					align-items:center;
				}
				
				.wp-block-tag-cloud a {
					padding:0.6rem;
					clear:both;
					background:var(--monawp-special-color);
					color:var(--monawp-main-contrast-color);
					
				}
				
				
				
		
	';
	
	if (Helpers::isJetpackEnabled() and \Jetpack::is_module_active( 'infinite-scroll' )) {
		$monawp_ConstructedCssGlobal .= '
		.infinite-wrap {
			width:100%;
			display:flex;
			flex-flow:column wrap;
			grid-column: 1 / -1; /* Span across all available columns */
		}
		
		.infinite-wrap article {
			padding: '.$article_vertical_padding.'rem '.$article_horizontal_padding.'rem;
			
		}
		
		.infinite-wrap .monawp_post_thumbnail_element img {
			width: auto;
			height: 100%;
			transform: none;
		}
		.infinite-wrap .monawp_post_thumbnail_element img:hover {
			transform: none;
			
		}
		';
		
	}
	
	$show_scroll_to_top = get_theme_mod( 'monawp_global_panel_scroll_to_top_show', $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_show'] );
	
	if ($show_scroll_to_top) {
		
		$monawp_ConstructedCssGlobal .= '
			.scroll-to-top {
				position:fixed;
				background:var(--monawp-main-contrast-color);
				z-index:999;
				border:1px solid var(--monawp-main-color);
			}
			
			.scroll-to-top a {
				padding:0.6rem;
				display:block
			}
		';
	}
	
	
	$monawp_ConstructedCssDesktop .= '
		
		footer#colophon .horizontal-navigation-desktop ul li:hover > ul,footer#colophon .horizontal-navigation-desktop ul li.focus > ul {
			display: none;
		}
		
		footer#colophon .horizontal-navigation-desktop ul ul li:hover > ul,footer#colophon .horizontal-navigation-desktop ul ul li.focus > ul {
			display: none;
		}
	';
	
	$hide_scroll_to_top_on_mobile = get_theme_mod( 'monawp_global_panel_scroll_to_top_hide_mobile', $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_hide_mobile'] );
	
	if ($hide_scroll_to_top_on_mobile) {
		$monawp_ConstructedCssMobile .= '
		
			.scroll-to-top {
				display:none;
				
			}
		';
	
	}
	
	if (get_theme_mod('monawp_elements_panel_related_posts_count', $monawp_customizer_defaults['monawp_related_posts_count'])) {
		
		$monawp_ConstructedCssGlobal .= '
		
			.similar-posts-wrapper {
				display:inline-grid;
			}
		
			.similar-posts-wrapper > article {
				padding:0.6rem;
				margin:0;
			}
		
			article.similar-post {
				display:flex;
				flex-flow:column wrap;
				row-gap:0.8rem;
			}
			
			article.similar-post .post-thumbnail {
				margin:0
			}
			
			article.similar-post > div {
				display:flex;
				flex-flow:row wrap;
				gap:0.4rem;
				align-items: center;
			}
			article.similar-post > div:not(.monawp_post_thumbnail_element) > a {
				padding:0.8rem;
				background:var(--monawp-special-contrast-color);
				color:var(--monawp-main-color);
			}
			.similar-post-thumbnail {
				display: flex; /* Ensure the div takes only the necessary width */
			}
			.similar-post-excerpt p {
				margin:0
			}
			.similar-post-excerpt {
				margin: 0.4rem 0;
			}
		';
	}
	
	if (Helpers::isShareBoxEnabled()) {
		
		$monawp_ConstructedCssGlobal .= '
		
		/* Sharebox element */
		
		.monawp_sharebox_element {
			display:flex;
			flex-flow:row wrap;
			align-items: center;
		}
		
		.share-box-title {
			padding:0.6rem;
			background:var(--monawp-special-contrast-color);
			color:var(--monawp-main-color);
			align-items: center;
			font-weight:bold;
		}
		
		.monawp_sharebox_element a {
			text-decoration:none;
			padding:0.6rem;
			background:var(--monawp-secondary-contrast-color);
		}
		
		.monawp_sharebox_element svg {
			fill: var(--monawp-special-secondary-color);
		}
		
		.monawp_sharebox_element .share-box-title svg {
			fill: var(--monawp-main-color);
				';
				
				if (is_rtl()) {
					$monawp_ConstructedCssGlobal .= '
				transform: rotate(180deg);
				';
				}
				$monawp_ConstructedCssGlobal .= '
		}
		
		.monawp_sharebox_element a:hover svg,.monawp_sharebox_element a:focus svg {
			fill: var(--monawp-special-color);
		}
		
		';
		
	}
	
			if (is_single() and get_theme_mod('monawp_single_post_panel_layout_show_author_box', $monawp_singular_pages_items['author_box']['default'])) {
				
				$monawp_ConstructedCssGlobal .= '
					.monawp_entry_author_box_element {
						width:auto;
						display:flex;
					}
					.author-box {
						border:2px solid var(--monawp-secondary-color);
						padding: 1.2rem;
						margin: 1.2rem 0;
						width:auto;
					}
					
					.author-avatar {
						display:flex;
						vertical-align:center;
					}
					
					';
			}

    // Combine constructed CSS from other functions (if applicable)
    $constructed_css = MonaWP\cssConstructor::combineConstructedCss();

    if ($constructed_css) {
		echo '<style id="monawp_plugin_constructed_css">' . MonaWP\Resources\Sanitize::css($constructed_css) . '</style>';
	}

}

add_action('monawp_after_footer', 'monawp_enqueue_plugin_misc_constructed_css');


?>