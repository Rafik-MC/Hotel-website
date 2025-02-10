<?php 

namespace MonaWP;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MonaWP\Builder\Elements as Elements;
use MonaWP\Resources\Helpers as Helpers;

class cssConstructor {
	
	public static function parse_css($css_string) {
		$parsed_css = array();

		// Split the CSS string into individual rules
		$rules = explode('}', $css_string);

		foreach ($rules as $rule) {
			// Split each rule into selector and properties
			$parts = explode('{', $rule);

			if (count($parts) === 2) {
				// Trim selector and properties
				$selector = trim($parts[0]);
				$properties = trim($parts[1]);

				// Add the rule to the parsed CSS array
				if (!empty($selector) && !empty($properties)) {
					// Modify to parse properties into an inner array
					$parsed_properties = self::parse_properties($properties);
					$parsed_css[$selector] = $parsed_properties;
				}
			}
		}

		return $parsed_css;
	}

	private static function parse_properties($properties_string) {
		$parsed_properties = array();

		// Split properties string by semicolon
		$properties = explode(';', $properties_string);

		foreach ($properties as $property) {
			// Split each property by colon
			$parts = explode(':', $property);

			if (count($parts) === 2) {
				// Trim property name and value
				$property_name = trim($parts[0]);
				$property_value = trim($parts[1]);

				// Add the property to the parsed properties array
				if ($property_name !== '' && $property_value !== '') {
					$parsed_properties[$property_name] = $property_name.':'.$property_value;
				}
			}
		}

		return $parsed_properties;
	}
	
	/**
	 * Convert the updated CSS array back into a CSS string.
	 *
	 * @param array $css_array The updated CSS array.
	 * @return string The CSS string.
	 */
	private static function convert_to_css_string($css_array) {
		$css_string = '';

		foreach ($css_array as $selector => $properties) {
			// Ensure $properties is a string
			if (is_array($properties)) {
				// Convert array of properties to string
				$properties = implode(';', $properties);
			}

			// Append each rule in the format: selector { properties }
			$css_string .= $selector . '{' . $properties . '}';
		}

		return $css_string;
	}
	
    // Function to minimize CSS code
    public static function minimizeCss($css) {
        // Remove whitespace and line breaks
        $minimized_css = preg_replace('/\s+/', ' ', $css);
        // Remove unnecessary whitespace around characters
        $minimized_css = preg_replace('/\s*([{}:;,])\s*/', '$1', $minimized_css);
        return $minimized_css;
    }

    // Function to remove comments from CSS code
    private static function removeComments($css) {
        // Remove comments (multi-line and single-line)
        $css_no_comments = preg_replace('!/\*.*?\*/!s', '', $css);
        $css_no_comments = preg_replace('/\n\s*\n/', "\n", $css_no_comments);
        return $css_no_comments;
    }
	
	public static function partialIdBoolean($structure_partial_id) {
		
		if ($structure_partial_id == '') {
			return true;
		}
		global $monawp_structure_prefixes_array;
		$theme_mods = get_theme_mods();
		
		foreach ($monawp_structure_prefixes_array as $hook) {
			if ($theme_mods['monawp_theme_builds_current'][$hook . $structure_partial_id] == 'enable') {
				return true;
			}
		}
		
		return false;
	}

    private static function getConstructedCss($breakpoint) {
		global $monawp_ConstructedCssGlobal;
		global $monawp_ConstructedCssDesktop;
		global $monawp_ConstructedCssLaptop;
		global $monawp_ConstructedCssTablet;
		global $monawp_ConstructedCssMobile;
		
		switch ($breakpoint) {
			case 'global':
				return $monawp_ConstructedCssGlobal;
			case 'desktop':
				return $monawp_ConstructedCssDesktop;
			case 'laptop':
				return $monawp_ConstructedCssLaptop;
			case 'tablet':
				return $monawp_ConstructedCssTablet;
			case 'mobile':
				return $monawp_ConstructedCssMobile;
		}
	}
	
	public static function returnAllExtendedCss() {
		global $monawp_random_presets;
		foreach ($monawp_random_presets as $presetName => $value) {
			$randomValue = Helpers::generateRandomValue($presetName);
			$monawp_random_presets[$presetName] = $randomValue;
		}
		
		global $monawp_theme_viewports;
		$extended_css_combined = '';
		// Extend default CSS for the global viewport
		$extended_css_combined .= self::extendDefaultCss('global') . " ";

		foreach ($monawp_theme_viewports as $viewport => $viewport_data) {
			// Skip the global viewport, as it's already handled
			if ($viewport === 'global') {
				continue;
			}

			// Determine the breakpoint based on viewport data
			if (isset($viewport_data['min_width'])) {
				$breakpoint = "(min-width: {$viewport_data['min_width']})";
			} elseif (isset($viewport_data['max_width'])) {
				$breakpoint = "(max-width: {$viewport_data['max_width']})";
			} else {
				// Skip this viewport if neither min_width nor max_width is defined
				continue;
			}

			// Extend default CSS for the current viewport/breakpoint
			$extended_css = self::extendDefaultCss($viewport);

			if ($extended_css != '') {
				$media_query = "@media screen and {$breakpoint} { {$extended_css} }";
			} else {
				$media_query = '';
			}
			
			// Combine the extended CSS for all viewports
			$extended_css_combined .= $media_query . " ";
		}

		return $extended_css_combined;
	}

	public static function combineConstructedCss() {
		global $monawp_theme_viewports;

		$default_css_combined = '';

		$minimized_global_css = self::minimizeCss(self::getConstructedCss('global'));
		$global_css_no_comments = self::removeComments($minimized_global_css);
		$default_css_combined .= $global_css_no_comments;

		// Iterate over viewports and add media queries accordingly
		foreach ($monawp_theme_viewports as $viewport => $viewport_data) {
			if ($viewport !== 'global') {
				$min_width = isset($viewport_data['min_width']) ? "(min-width: {$viewport_data['min_width']})" : '';
				$max_width = isset($viewport_data['max_width']) ? "(max-width: {$viewport_data['max_width']})" : '';

				// Check for different combinations of min_width and max_width
				if ($min_width !== '' && $max_width !== '') {
					// If both min_width and max_width are defined
					$breakpoint = "({$min_width}) and ({$max_width})";
				} elseif ($min_width !== '') {
					// If only min_width is defined
					$breakpoint = $min_width;
				} elseif ($max_width !== '') {
					// If only max_width is defined
					$breakpoint = $max_width;
				} else {
					// If neither min_width nor max_width is defined, skip this viewport
					continue;
				}

				// Retrieve the corresponding default CSS variable
				$default_css_variable = self::getConstructedCss($viewport);

				if ($default_css_variable != '') {
					$minimized_css = self::minimizeCss($default_css_variable);
					$css_no_comments = self::removeComments($minimized_css);

					// Add media query and default CSS for this viewport
					$default_css_combined .= "@media screen and {$breakpoint} { {$css_no_comments} }";
				} else {
					$default_css_combined .= "";
				}
			}
		}

		return $default_css_combined;
	}

}
?>