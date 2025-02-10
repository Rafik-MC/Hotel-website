<?php 

namespace MonaWP\Resources;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sanitize {
    // Custom sanitize function for floating point numbers
    public static function float( $value ) {
        return floatval( $value );
    }
	
	
	public static function checkbox($checked) {
		return ((isset($checked) && true === $checked) ? true : false);
	}
	
	public static function css($css) {
		// Sanitize JavaScript XSS payloads
		$patterns = array(
			'/(java|vb)script:/i',
			'/data:/i',
			'/eval\((.*)\)/i',
			'/expression\((.*)\)/i',
			'/(\<|\>|&lt;|&gt;)script/i',
			'/(\%3C|\%3E|\<|\>)script/i'
		);

		$css = preg_replace($patterns, '', $css);

		// Ensure URLs within CSS properties are properly formatted
		$css = preg_replace_callback('/url\s*\((.*?)\)/i', function($matches) {
			$url = str_replace(array('"', "'"), '', $matches[1]); // Remove surrounding quotes
			$url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); // Escape URL
			return "url('$url')";
		}, $css);

		// Escape special characters outside of CSS property values
		$css = preg_replace_callback('/(^|[^\\\\])\'[^\']*\'/', function($matches) {
			return $matches[1] . htmlspecialchars($matches[0], ENT_QUOTES, 'UTF-8');
		}, $css);

		$css = preg_replace_callback('/(^|[^\\\\])"[^"]*"/', function($matches) {
			return $matches[1] . htmlspecialchars($matches[0], ENT_QUOTES, 'UTF-8');
		}, $css);

		// Return sanitized CSS
		return $css;
	}

	
}

class Schema {
    public static function getPart($schema_part) {
        // Initialize schema part attribute string
        $schema_attribute = '';

        // Get theme mod value
        $theme_mod_enabled = get_theme_mod('monawp_performance_section_enable_schema', false);

        // Check if theme mod is enabled
        if ($theme_mod_enabled) {
            // Set schema parts if enabled
            switch ($schema_part) {
                case 'nav':
                    $schema_attribute .= 'itemtype="https://schema.org/SiteNavigationElement" itemscope="itemscope"';
                    break;
                case 'header':
                    $schema_attribute .= 'itemtype="https://schema.org/WPHeader" itemscope="itemscope"';
                    break;
                case 'footer':
                    $schema_attribute .= 'itemtype="https://schema.org/WPFooter" itemscope="itemscope"';
                    break;
                case 'body':
                    if (is_search()) {
                        // For search results pages
                        $schema_attribute .= 'itemtype="https://schema.org/SearchResultsPage" itemscope="itemscope"';
                    } elseif (is_page()) {
                        // For single pages
                        $schema_attribute .= 'itemtype="https://schema.org/WebPage" itemscope="itemscope"';
                    } elseif (Helpers::isSchemaBlog()) {
                        // For blog pages
                        $schema_attribute .= 'itemtype="https://schema.org/Blog" itemscope="itemscope"';
                    } else {
                        // Default to WebPage schema
                        $schema_attribute .= 'itemtype="https://schema.org/WebPage" itemscope="itemscope"';
                    }
                    break;
                case 'article':
                    $schema_attribute .= 'itemtype="https://schema.org/Article" itemscope="itemscope"';
                    break;
                case 'sidebar':
                    $schema_attribute .= 'itemtype="https://schema.org/WPSideBar" itemscope="itemscope"';
                    break;
                case 'organization':
                    $schema_attribute .= 'itemtype="https://schema.org/Organization" itemscope="itemscope"';
                    break;
                case 'person':
                    $schema_attribute .= 'itemtype="https://schema.org/Person" itemscope="itemscope"';
                    break;
                case 'article_body':
                    $schema_attribute .= 'itemprop="articleBody"';
                    break;
                case 'excerpt':
                    $schema_attribute .= 'itemprop="description"';
                    break;
                case 'breadcrumbs':
                    $schema_attribute .= ' itemscope itemtype="https://schema.org/BreadcrumbList"';
                    break;
                case 'breadcrumb_list_element':
                    $schema_attribute .= 'itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"';
                    break;
                case 'article_category':
                    $schema_attribute .= 'itemprop="keywords"';
                    break;
                case 'article_tags':
                    $schema_attribute .= 'itemprop="keywords"';
                    break;
                case 'read_time':
                    $schema_attribute .= 'itemprop="timeRequired"';
                    break;
                case 'date_published':
                    $schema_attribute .= 'itemprop="datePublished"';
                    break;
                case 'address':
                    $schema_attribute .= 'itemprop="address" itemscope itemtype="https://schema.org/PostalAddress"';
                    break;
                case 'street_address':
                    $schema_attribute .= 'itemprop="streetAddress"';
                    break;
                case 'email':
                    $schema_attribute .= 'itemprop="email"';
                    break;
                case 'phone':
                    $schema_attribute .= 'itemprop="telephone"';
                    break;
                default:
                    // Handle default case
                    break;
            }
        }

        // Return the schema attribute string
        return $schema_attribute;
    }
}




global $monawp_customizer_defaults;

global $monawp_color_visited_profiles;
$monawp_color_visited_profiles = array(
	'0' => array(
		'color' => 'var(--monawp-main-color)',
		'visited' => 'var(--monawp-special-color)',
	),		
	'1' => array(
		'color' => 'var(--monawp-special-color)',
		'visited' => 'var(--monawp-main-color)',
	),	
	'2' => array(
		'color' => 'var(--monawp-special-color)',
		'visited' => 'var(--monawp-special-secondary-color)',
	),
	'3' => array(
		'color' => 'var(--monawp-special-secondary-color)',
		'visited' => 'var(--monawp-special-color)',
	),	
);

// Define the class
class Icons {
    // Function to open a folder and retrieve the SVG content
    public static function getSVGContents($svgPath) {
        // Define the folder path where SVG files are located
        $folderPath = get_template_directory() . '/icons';

        // Construct the file path for the requested SVG
        $filePath = $folderPath . $svgPath;

        // Check if the file exists
        if (file_exists($filePath)) {
            // Read the contents of the file
            $svgContent = file_get_contents($filePath);

            // Return the SVG content
            return $svgContent;
        } else {
            // File does not exist, return null
            return null;
        }
    }
	
	public static function getIconArray($name) {
		switch ($name) {
			case 'generic_social':
				return [
					'Facebook' => '/fa/brands/facebook.svg',
					'Twitter' => '/fa/brands/x-twitter.svg',
					'YouTube' => '/fa/brands/youtube.svg',
					'Instagram' => '/fa/brands/instagram.svg',
					'TikTok' => '/fa/brands/tiktok.svg',
					'Twitch' => '/fa/brands/twitch.svg',
					'LinkedIn' => '/fa/brands/linkedin.svg',
					'Pinterest' => '/fa/brands/pinterest.svg',
					'Snapchat' => '/fa/brands/snapchat.svg',
					'Reddit' => '/fa/brands/reddit.svg',
					'WhatsApp' => '/fa/brands/whatsapp.svg',
					'Telegram' => '/fa/brands/telegram.svg',
					'Discord' => '/fa/brands/discord.svg',
					'Tumblr' => '/fa/brands/tumblr.svg',
					'VK' => '/fa/brands/vk.svg',
					'Line' => '/fa/brands/line.svg',
					'Medium' => '/fa/brands/medium.svg',
					'Viber' => '/fa/brands/viber.svg',
				];
				break;
			case 'generic_info':
				return [
					__('Address', 'monawp') => '/fa/regular/map.svg',
					__('Email', 'monawp') => '/fa/regular/envelope.svg',
					__('Phone', 'monawp') => '/fa/regular/mobile-screen.svg',
				];
			break;
			default:
				return []; // Return empty array if name is not recognized
		}
	}

}

global $monawp_sharebox_defaults;

$monawp_sharebox_defaults = array(
	'Facebook' => true,
	'Twitter' => true,
	'LinkedIn' => true,
	'Pinterest' => true,
	'Reddit' => true,
	'WhatsApp' => true,
	'Telegram' => true,
	'Tumblr' => true,
	'VK' => true,
	'Medium' => true,
);

$monawp_structure_prefixes_array = ['header', 'footer', 'topbar'];

global $monawp_structure_defaults;
$monawp_structure_defaults = array(
    'monawp_site_logo_header' => array (
        'state' => true,
        'title' => __('Site Logo', 'monawp'),
        'panel' => 'header',
    ),
    'monawp_site_logo_footer' => array (
        'state' => false,
        'title' => __('Site Logo', 'monawp'),
        'panel' => 'footer',
    ),
    'monawp_site_title_header' => array (
        'state' => true,
        'title' => __('Site Title', 'monawp'),
        'panel' => 'header',
    ),
    'monawp_site_title_footer' => array (
        'state' => false,
        'title' => __('Site Title', 'monawp'),
        'panel' => 'footer',
    ),
    'monawp_site_description_header' => array (
        'state' => true,
        'title' => __('Site Description', 'monawp'),
        'panel' => 'header',
    ),
    'monawp_site_description_footer' => array (
        'state' => false,
        'title' => __('Site Description', 'monawp'),
        'panel' => 'footer',
    ),
    'monawp_horizontal_menu_header' => array (
        'state' => true,
        'title' => __('Horizontal Menu', 'monawp'),
        'panel' => 'header',
    ),
    'monawp_horizontal_menu_footer' => array (
        'state' => true,
        'title' => __('Horizontal Menu', 'monawp'),
        'panel' => 'footer',
    ),
    'monawp_widget_1_header' => array (
        'state' => true,
        'title' => __('Widget 1', 'monawp'),
        'panel' => 'header',
    ),
    'monawp_widget_2_header' => array (
        'state' => true,
        'title' => __('Widget 2', 'monawp'),
        'panel' => 'header',
    ),
    'monawp_widget_1_footer' => array (
        'state' => true,
        'title' => __('Widget 1', 'monawp'),
        'panel' => 'footer',
    ),
    'monawp_widget_2_footer' => array (
        'state' => true,
        'title' => __('Widget 2', 'monawp'),
        'panel' => 'footer',
    ),
    'monawp_widget_3_footer' => array (
        'state' => true,
        'title' => __('Widget 3', 'monawp'),
        'panel' => 'footer',
    ),
    'monawp_widget_4_footer' => array (
        'state' => true,
        'title' => __('Widget 4', 'monawp'),
        'panel' => 'footer',
    ),
    'monawp_search_header' => array (
        'state' => true,
        'title' => __('Search', 'monawp'),
        'panel' => 'header',
    ),
    'monawp_search_footer' => array (
        'state' => true,
        'title' => __('Search', 'monawp'),
        'panel' => 'footer',
    ),
    'monawp_generic_info_header' => array (
        'state' => true,
        'title' => __('Generic Info', 'monawp'),
        'panel' => 'header',
    ),
    'monawp_generic_info_footer' => array (
        'state' => false,
        'title' => __('Generic Info', 'monawp'),
        'panel' => 'footer',
    ),
    'monawp_socials_header' => array (
        'state' => true,
        'title' => __('Social Icons', 'monawp'),
        'panel' => 'header',
    ),
    'monawp_socials_footer' => array (
        'state' => true,
        'title' => __('Social Icons', 'monawp'),
        'panel' => 'footer',
    ),
);

// Extend monawp_structure_defaults with topbar entries
foreach ($monawp_structure_defaults as $key => $value) {
    if ($value['panel'] === 'header') {
        $topbar_key = str_replace('_header', '_topbar', $key);
        $monawp_structure_defaults[$topbar_key] = array(
            'state' => $value['state'],
            'title' => $value['title'],
            'panel' => 'topbar',
        );
    }
}

global $monawp_empty_header_build_matrix;
$monawp_empty_header_build_matrix = [];

// Initialize an array to store the count of items for each panel
$panel_counts = [];

// Count items for each panel
foreach ($monawp_structure_defaults as $key => $item) {
    $panel = $item['panel'];

    // Increment the count for the panel
    $panel_counts[$panel] = isset($panel_counts[$panel]) ? $panel_counts[$panel] + 1 : 1;
}

// Loop through panel counts and create the empty header build matrix
foreach ($panel_counts as $panel => $count) {
    // Determine the prefix
    $prefix = in_array($panel, $monawp_structure_prefixes_array) ? $panel : '';

    // Create subarray if not exists
    if (!isset($monawp_empty_header_build_matrix[$panel])) {
        $monawp_empty_header_build_matrix[$panel] = [];
    }

    // Add empty strings to the subarray
    for ($i = 0; $i < $count * 2; $i++) {
        $monawp_empty_header_build_matrix[$panel]['monawp_' . $prefix . '_panel_builder_' . $i] = '';
    }
}

global $monawp_default_layouts_array;
$monawp_default_layouts_array = [
	'topbar' => [
		'row-start',
		'monawp_socials_topbar',
		'monawp_generic_info_topbar',
		'wrapper-end',
		'row-start',
		'monawp_horizontal_menu_topbar',
		'monawp_widget_1_topbar',
		'wrapper-end'
	],
	'header' => [
		'row-start',
		'monawp_site_logo_header',
		'monawp_site_title_header',
		'monawp_site_description_header',
		'wrapper-end',
		'row-start',
		'monawp_horizontal_menu_header',
		'monawp_search_header',
		'monawp_widget_1_header',
		'wrapper-end'
	],
	'footer' => [
		'col-start',
		'row-start',
		'monawp_horizontal_menu_footer',
		'wrapper-end',
		'row-start',
		'monawp_widget_1_footer',
		'monawp_widget_2_footer',
		'monawp_widget_3_footer',
		'monawp_widget_4_footer',
		'wrapper-end',
		'wrapper-end',
	],
];

global $monawp_singular_pages;
$monawp_singular_pages = array(
	'single_post' => __( 'Single Post', 'monawp' ), //1st - panel id 2nd - name
	'page' => __( 'Page', 'monawp' ),
);

global $monawp_item_titles;

$monawp_item_titles = array(
	'search_page' => esc_html__( 'Search Results for:', 'monawp' ),
	'comments_title' => esc_html__('Comments', 'monawp'),
);

global $monawp_singular_pages_items;

$monawp_singular_pages_items = array(
	'breadcrumbs' => array(
		'label' => __( 'Breadcrumbs', 'monawp' ),
		'default' => true,
		'default_page' => false,
	),
	'content_start_sharebox' => array(
		'label' => __( 'Content Start Sharebox', 'monawp' ),
		'default' => false,
		'default_page' => false,
	),
	'content_end_sharebox' => array(
		'label' => __( 'Content End Sharebox', 'monawp' ),
		'default' => false,
		'default_page' => false,
	),
	'author_box' => array(
		'label' => __( 'Author Box', 'monawp' ),
		'default' => true,
	),
	'similar_posts' => array(
		'label' => __( 'Similar Posts', 'monawp' ),
		'default' => true,
	),
);

global $monawp_predefined_query_layouts_simple;
$monawp_predefined_query_layouts_simple = array(
	'main_content_1',
	'main_content_2',
	'main_content_3',
	'main_content_4',
);

global $monawp_predefined_query_layouts;
$monawp_predefined_query_layouts = array(
	'main_content_1' => '0',
	'main_content_2' => '1',
	'main_content_3' => '2',
	'main_content_4' => '3',
);

global $monawp_pages_with_sidebars;

$monawp_pages_with_sidebars = array(
	'global' => __('Global', 'monawp'),
	'single_post' => __( 'Single Post', 'monawp' ), //1st - panel id 2nd - name
	'page' => __( 'Page', 'monawp' ),
	'blog' => __( 'Blog', 'monawp' ),
	'archive' => __( 'Archive', 'monawp' ),
	'404' => __( '404 Page', 'monawp' ),
	'search' => __( 'Search', 'monawp' ),
);

global $monawp_pages_with_excerpt;

$monawp_pages_with_excerpt = array(
	'blog' => __( 'Blog', 'monawp' ),
	'archive' => __( 'Archive', 'monawp' ),
	'search' => __( 'Search', 'monawp' ),
);

global $monawp_thumbnail_choices;

$monawp_thumbnail_choices = array(
	'' => __('None', 'monawp'),
	'monawp_small_thumbnail' => __('Thumbnail (300x200)', 'monawp'),
	'monawp_medium_thumbnail' => __('Medium (720x480)', 'monawp'),
	'monawp_large_thumbnail' => __('Large (1280x720)', 'monawp'),
	'original' => __('Original Size', 'monawp'),
);

global $monawp_header_positions;

$monawp_header_positions = array(
	'Inherit' => __( 'Inherit', 'monawp' ),
	'Sticky' => __( 'Sticky', 'monawp' ),
	'Relative' => __( 'Relative', 'monawp' ),
);
	
global $monawp_sidebar_layout_options;

$monawp_sidebar_layout_options = array(
	'Inherit' => __( 'Inherit', 'monawp' ),
	'1 Column' => __( '1 Column', 'monawp' ),
	'2 Columns - Left Sidebar' => __( '2 Columns - Left Sidebar', 'monawp' ),
	'2 Columns - Right Sidebar' => __( '2 Columns - Right Sidebar', 'monawp' ),
	'3 Columns' => __( '3 Columns', 'monawp' ),
);

global $monawp_page_slugs;

$monawp_page_slugs = array(
	'single_post' => __('Single Post', 'monawp'),
	'page' => __('Page', 'monawp'),
	'home' => __('Home', 'monawp'),
	'blog' => __('Blog', 'monawp'),
	'front_page' => __('Front Page', 'monawp'),
	'archive' => __('Archive', 'monawp'),
	'404' => __('404', 'monawp'),
	'search' => __('Search', 'monawp'),
);

global $monawp_sidebar_ids;

$monawp_sidebar_ids = array(
	'left' => array(
		'single_post' => 'left_sidebar_widget_single_post',
		'archive' => 'left_sidebar_widget_archive',
		'search' => 'left_sidebar_widget_search',
		'global' => 'left_sidebar_widget_one',
	),
	'right' => array(
		'single_post' => 'right_sidebar_widget_single_post',
		'archive' => 'right_sidebar_widget_archive',
		'search' => 'right_sidebar_widget_search',
		'global' => 'right_sidebar_widget_one',
	),
);


class Helpers {
	
    public static function replaceExactString($mainString, $delimiter, $searchString, $replaceString) {
        // Split the main string by the delimiter
        $parts = explode($delimiter, $mainString);
        
        // Iterate over the parts and replace the exact match
        foreach ($parts as &$part) {
            if ($part === $searchString) {
                $part = $replaceString;
            }
        }
        
        // Join the parts back together with the delimiter
        return implode($delimiter, $parts);
    }
	
	public static function isSchemaBlog() {
		if ( !is_page() ) {
			return true;
		}
	}
	
	public static function isWooCommerce() {
		if (self::isPluginEnabled('woocommerce/woocommerce.php')) {
			if (is_woocommerce() or is_cart() or is_checkout() or is_account_page()) {
				return true;
			}
		}
		return false;
	}
	
	public static function isWooCommercePage() {
		if (self::isPluginEnabled('woocommerce/woocommerce.php')) {
			if (is_product() or is_product_category() or is_product_tag()) {
				return true;
			}
		}
		return false;
	}
	
	public static function isWooCommerceMiscPage() {
		if (self::isPluginEnabled('woocommerce/woocommerce.php')) {
			if (is_cart() or is_checkout() or is_account_page()) {
				return true;
			}
		}
		return false;
	}
	
	public static function isWooCommerceArchive() {
		if (self::isPluginEnabled('woocommerce/woocommerce.php')) {
			if (is_product_category() or is_product_tag()) {
				return true;
			}
		}
		return false;
	}
	
	public static function isWooCommerceSingleProduct() {
		if (self::isPluginEnabled('woocommerce/woocommerce.php')) {
			if (is_product()) {
				return true;
			}
		}
		return false;
	}
	
	public static function isWidgetActive($widget_id) {
		// Check if the widget is active
		if (!is_active_widget(false, false, $widget_id, true)) {
			return false;
		}

		// Get all sidebars and their widgets
		$sidebars_widgets = wp_get_sidebars_widgets();

		print_r($sidebars_widgets);
		foreach ($sidebars_widgets as $sidebar => $widgets) {
			// Print the sidebar name
			echo  $sidebar . '<br>';

			// Check each widget ID in the sidebar for a substring match
			foreach ($widgets as $widget) {
				echo  $widget . '<br>';
				if (strpos($widget, $widget_id) !== false) {
					// Check if the sidebar is active and being displayed on the current page
					if (is_active_sidebar($sidebar)) {
						return true;
					}
				}
			}
		}

		return false;
	}
	
	public static function isWidgetBySubstringActive($substring) {
		// Check if the substring is empty
		if (empty($substring)) {
			return false;
		}

		// Get all sidebars and their widgets
		$sidebars_widgets = wp_get_sidebars_widgets();

		foreach ($sidebars_widgets as $sidebar => $widgets) {
			// Check each widget ID in the sidebar for a substring match
			foreach ($widgets as $widget) {
				// Check if the widget ID contains the specified substring
				if (strpos($widget, $substring) !== false) {
					// Check if the sidebar is active and being displayed on the current page
					if (is_active_sidebar($sidebar)) {
						return true;
					}
				}
			}
		}

		return false;
	}

	public static function isShareBoxEnabled() {
		global $monawp_sharebox_defaults;

		// Check if any share box icon is enabled
		foreach ($monawp_sharebox_defaults as $label => $default) {
			$theme_mod_value = get_theme_mod('monawp_elements_panel_share_box_' . strtolower($label), $default);
			if ($theme_mod_value) {
				return true;
			}
		}

		return false;
	}
	
	public static function commentsAvailable() {
		if (is_singular()) {
			if (comments_open() || get_comments_number()) {
				return true;
			}
		}
		return false;
	}
	
	public static function getCurrentUrl() {
		$protocol = 'http://';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
			$protocol = 'https://';
		}
		$current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		return $current_url;
	}
	
	public static function getSidebarLayout() {
		global $monawp_pages_with_sidebars, $monawp_sidebar_layout_options, $monawp_customizer_defaults;

		// Get global layout option
		$global_layout_option = get_theme_mod('monawp_global_panel_layout_sidebar_layout', $monawp_customizer_defaults['monawp_default_sidebar_layout']);

		// Iterate through panels and check for specific page layout options
		foreach ($monawp_pages_with_sidebars as $current_page => $panel_title) {
			if ($current_page === 'global') {
				continue;
			}
			// Get specific page layout option
			$specific_page_layout_option = get_theme_mod('monawp_'.$current_page.'_panel_layout_sidebar_layout', 'Inherit');

			// If the specific page layout option is not 'Inherit' and matches the current page condition
			if ($specific_page_layout_option != "Inherit" && self::checkPageCondition($current_page)) {
				return $specific_page_layout_option;
			}
		}

		// Return global layout option if no specific page layout option is found
		return $global_layout_option;
	}
	
	// Function to check page condition based on slug
	public static function checkPageCondition($panel_slug) {
		switch ($panel_slug) {
			case 'single_post':
				return is_single();
			case 'page':
				return is_page();
			case 'home':
				return (is_front_page() && is_home());
			case 'blog':
				return is_home();
			case 'front_page':
				return is_front_page();
			case 'archive':
				return is_archive();
			case '404':
				return is_404();
			case 'search':
				return is_search();
			default:
				return true; // Default to true for other panels
		}
	}
	
	public static function hasPagination() {
		global $wp_query;

		// Check if it's a paged page or if there are more than one page
		if ( is_paged() || $wp_query->max_num_pages > 1 ) {
			return true;
		} else {
			return false;
		}
	}
		
	public static function hasGallery() {
		global $post;

		// Ensure the global $post variable is set and is a valid WP_Post object
		if (!isset($post)) {
			return false; // No valid post object found
		}

		// Check if the post type is either 'post' or 'page'
		if ($post->post_type !== 'post' && $post->post_type !== 'page') {
			return false; // Not a post or page
		}

		// Get the post content
		$content = $post->post_content;

		// Ensure the post content is not empty
		if (empty($content)) {
			return false; // No content found
		}

		// Check if the content contains HTML elements typically associated with galleries
		if (strpos($content, 'wp-block-gallery') !== false || strpos($content, '<figure class="gallery-item">') !== false) {
			return true; // Gallery found
			echo "1";
		}

		return false; // No gallery found
	}

	
	//Plugin bools

    public static function isJetpackEnabled() {
        // Include the plugin.php file if it is not already included
        if (!function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        // Check if Jetpack is active
        return is_plugin_active('jetpack/jetpack.php');
    }
	
    public static function isFluentFormsEnabled() {
        // Include the plugin.php file if it is not already included
        if (!function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        // Check if Fluent Forms is active
        return is_plugin_active('fluentform/fluentform.php');
    }
		
	public static function isWPFormsEnabled() {
	  // Include the plugin.php file if it is not already included
	  if (!function_exists('is_plugin_active')) {
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
	  }

	  // Check if WPForms is active
	  return is_plugin_active('wpforms-lite/wpforms.php'); // Replace with the correct plugin file name
	}
	
    public static function isPluginEnabled($plugin) {
        // Include the plugin.php file if it is not already included
        if (!function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        // Check if Jetpack is active
        return is_plugin_active($plugin);
    }
	
	public static function arePluginsEnabled($plugins) {
		// Include the plugin.php file if it is not already included
		if (!function_exists('is_plugin_active')) {
			include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		}

		// Iterate through the plugins array and check if any of them are active
		foreach ($plugins as $plugin) {
			if (is_plugin_active($plugin)) {
				return true; // Return true if any plugin is active
			}
		}

		return false; // Return false if none of the plugins are active
	}
	
	public static function hasTitleOrDesc() {
		$has_title_or_desc = get_bloginfo('name') || get_bloginfo('description');
		if ($has_title_or_desc) {
			return true;
		}
		return false;
	}
	
    public static function areSocialProfilesAdded() {
		
		$social_icons = Icons::getIconArray('generic_social');

		// Check if any share box icon is enabled
		foreach ($social_icons as $social_name => $social_icon) {
			$theme_mod_value = get_theme_mod('monawp_social_profile_url_' . strtolower($social_name), '');
			if ($theme_mod_value) {
				return true;
			}
		}

		return false;

    }
	
	public static function isGenericInfoAdded() {
		global $monawp_customizer_defaults;
		$email = get_theme_mod('monawp_generic_info_email', $monawp_customizer_defaults["monawp_generic_info_email"]);
		$phone = get_theme_mod('monawp_generic_info_phone', $monawp_customizer_defaults["monawp_generic_info_phone"]);

		if (!empty($email) || !empty($phone)) {
			return true; // Generic info theme mods found
		}

		return false; // No generic info theme mods found
	}
	
	public static function stringContainsNumbers($string) {
		return (bool) preg_match('/\d/', $string);
	}
	
	public static function showSidebar($sidebar_id) {
		if (is_active_sidebar( $sidebar_id ) && is_dynamic_sidebar( $sidebar_id ) ) {
			return true;
		}
		return false;
	}
		
	
	public static function showLeftSidebar() {
		if (is_active_sidebar( 'left_sidebar_widget_one' ) && is_dynamic_sidebar( 'left_sidebar_widget_one' ) ) {
			return true;
		}
		return false;
	}
	
	public static function showRightSidebar() {
		if (is_active_sidebar( 'right_sidebar_widget_one' ) && is_dynamic_sidebar( 'right_sidebar_widget_one' ) ) {
			return true;
		}
		return false;
	}
	
	public static function isWordPressBlocksEnabled() {
		// Check if the function register_block_type() exists
		return function_exists('register_block_type');
	}
	
	public static function appendSubstringsToString($string, ...$substrings) {
		// Explode the string into an array of selectors
		$selectors = explode(',', $string);
		$appended_selectors = [];

		// Iterate over each selector and append the substrings
		foreach ($selectors as $selector) {
			$appended_selector = $selector;
			foreach ($substrings as $substring) {
				$appended_selectors[] = $appended_selector . trim($substring);
			}
		}

		// Reconstruct the string with appended substrings
		return implode(',', $appended_selectors);
	}
	
    // Function to generate random value between min and max
    public static function getRandomValue($min, $max) {
        return mt_rand($min, $max);
    }
	
	public static function getRandomFloat($min, $max) {
		$randomFloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
		return number_format($randomFloat, 1);
	}
	
	public static function constructStylePresets() {
		global $monawp_social_icons_element_css_selectors;
		global $monawp_border_style_presets;
		global $monawp_border_radius_presets;
		global $monawp_random_presets;
		global $monawp_border_style_options_random;
		global $monawp_color_css_variables;
		global $monawp_transition_duration_presets;
		global $monawp_generated_styles_array;
		global $monawp_transition_duration_presets;
		global $monawp_generated_styles_array;
		global $monawp_border_options_random;
		global $monawp_color_background_profiles;
		global $monawp_horizontal_menu_css_selectors;
		global $monawp_vertical_menu_css_selectors;
		global $monawp_element_specific_color_profiles;
		global $monawp_generated_animation_profiles;
		global $monawp_generated_border_profiles;
		global $monawp_generated_border_style_profiles;
		global $monawp_generated_border_radius_profiles;
		global $monawp_box_shadow_presets;
		global $monawp_generated_box_shadow_style_profiles;
		global $monawp_align_content_options;
		global $monawp_u_list_style_options;
		global $monawp_o_list_style_options;
		global $monawp_border_style_profiles;
		global $monawp_border_bottom_style_profiles;
		global $monawp_box_shadow_style_profiles;
		global $monawp_only_background_profiles;
		
		global $monawp_main_spacing;
		
		$monawp_color_css_variables = [
			'var(--monawp-main-color)', //dark
			'var(--monawp-secondary-color)', //dark
			'var(--monawp-special-color)', //dark
			'var(--monawp-special-secondary-color)', //dark
			'var(--monawp-special-contrast-color)', //light
			'var(--monawp-main-contrast-color)', //light
			'var(--monawp-secondary-contrast-color)', //light
			'var(--monawp-tertiary-contrast-color)' //light
		];
		
		$monawp_o_list_style_options = [
		  'none', 
		  'decimal', 
		  'lower-roman', 
		  'upper-roman', 
		  'lower-alpha', 
		  'upper-alpha',  
		];
		
		$monawp_u_list_style_options = [
		  'none', 
		  'disc',  
		  'circle', 
		  'square',   
		];
		
		$monawp_align_content_options = [
			'flex-start',
			'flex-end',
			'center',
			'space-between',
			'space-around',
			'stretch',
		];
		
		$monawp_element_specific_color_profiles = array (
			'button' => null,
			'inputs' => null,
			'blockquote' => null,
			'pre' => null,
			'horizontal-menu' => null,
			'vertical-menu' => null,
			'mark' => null
		);
		
		// Define dark and light color arrays
		$dark_colors = array(
			'var(--monawp-main-color)',
			'var(--monawp-secondary-color)',
			'var(--monawp-special-color)',
		);
		$light_colors = array(
			'var(--monawp-special-contrast-color)',
			'var(--monawp-main-contrast-color)',
			'var(--monawp-secondary-contrast-color)',
			'var(--monawp-tertiary-contrast-color)',
		);

		// Initialize monawp_color_profiles array
		$monawp_color_background_profiles = array();

		// Generate combinations
		$index = 0; // Start index from 1
		foreach ($dark_colors as $dark) {
			foreach ($light_colors as $light) {
				if ($dark === 'var(--monawp-special-color)' && $light === 'var(--monawp-special-contrast-color)') {
					continue;
				}
				$monawp_color_background_profiles[$index]['color'] = $dark;
				$monawp_color_background_profiles[$index]['background'] = $light;
				$index++;
			}
		}
		
		foreach ($dark_colors as $dark) {
			foreach ($light_colors as $light) {
				if ($dark === 'var(--monawp-special-color)' && $light === 'var(--monawp-special-contrast-color)') {
					continue;
				}
				$monawp_color_background_profiles[$index]['background'] = $dark;
				$monawp_color_background_profiles[$index]['color'] = $light;
				$index++;
			}
		}

		// Remove duplicate entries
		$monawp_color_background_profiles = array_unique($monawp_color_background_profiles, SORT_REGULAR);
		
		$monawp_only_background_profiles = [
			'transparent' => '0',
			'var(--monawp-main-color)' => '1', //dark
			'var(--monawp-secondary-color)' => '2', //dark
			'var(--monawp-special-color)' => '3', //dark
			'var(--monawp-special-secondary-color)' => '4', //dark
			'var(--monawp-special-contrast-color)' => '5', //light
			'var(--monawp-main-contrast-color)' => '6', //light
			'var(--monawp-secondary-contrast-color)' => '7', //light
			'var(--monawp-tertiary-contrast-color)' => '8' //light
		];

		//print_r($monawp_color_background_profiles);
			
		$monawp_border_style_profiles = array();
		$monawp_border_bottom_style_profiles = array();
		
		// Define the border widths
		$border_widths = range(1, 7);

		// Define the border styles
		$border_styles = ['solid'];

		// Generate combinations
		$index = 1; // Start index from 1
		foreach ($monawp_color_css_variables as $variable) {
			foreach ($border_styles as $style) {
				foreach ($border_widths as $width) {
					$monawp_border_style_profiles[$index]['border'] = $width . 'px ' . $style . ' ' . $variable;
					$monawp_border_bottom_style_profiles[$index]['border-bottom'] = $width . 'px ' . $style . ' ' . $variable;
					$index++;
				}
			}
		}
		
		// Add the 'none' border style as the first item
		array_unshift($monawp_border_style_profiles, ['border' => 'none']);
		array_unshift($monawp_border_bottom_style_profiles, ['border-bottom' => 'none']);

		// Remove duplicate entries
		$monawp_border_style_profiles = array_unique($monawp_border_style_profiles, SORT_REGULAR);
		$monawp_border_bottom_style_profiles = array_unique($monawp_border_bottom_style_profiles, SORT_REGULAR);
		
		
		$monawp_box_shadow_style_profiles = array();

		// Define the horizontal range
		$horizontal_range = range(-4, 4);

		// Define the vertical range
		$vertical_range = range(1, 5);

		// Define the blur/spread range
		$blur_spread_range = range(1, 2);

		// Define the color
		$color = 'rgba(0,0,0,0.08)';
		
		// Add 'none' as the first item
		$monawp_box_shadow_style_profiles[] = ['box-shadow' => 'none'];

		// Generate combinations
		$index = 1;
		foreach ($horizontal_range as $horizontal) {
				foreach ($blur_spread_range as $blur_spread) {
					$monawp_box_shadow_style_profiles[$index]['box-shadow'] = $horizontal . 'px ' . $horizontal . 'px ' . $blur_spread . 'px ' . $blur_spread . 'px ' . $color;
					$index++;
				}
		}
		
		foreach ($monawp_color_css_variables as $color) {
			foreach ($horizontal_range as $horizontal) {
					$monawp_box_shadow_style_profiles[$index]['box-shadow'] = $horizontal . 'px ' . $horizontal . 'px 0 0 ' . $color;
					$index++;
				}
		}

		// Remove duplicate entries
		$monawp_box_shadow_style_profiles = array_unique($monawp_box_shadow_style_profiles, SORT_REGULAR);

	}
	
}

Helpers::constructStylePresets();

global $monawp_color_background_profiles;

global $monawp_theme_viewports;
$monawp_theme_viewports = array(
    'global' => array(
        'name' => __('Global', 'monawp'),
		'icon' => 'globe',
		'dashicon' => 'dashicons-admin-site'
    ),
    'desktop' => array(
        'name' => __('Desktop', 'monawp'),
        'min_width' => '992px',
		'icon' => 'desktop',
		'dashicon' => 'dashicons-desktop'
    ),
    'laptop' => array(
        'name' => __('Laptop', 'monawp'),
        'max_width' => '1279px',
		'icon' => 'laptop',
		'dashicon' => 'dashicons-laptop'
    ),
    'tablet' => array(
        'name' => __('Tablet', 'monawp'),
        'max_width' => '991px',
		'icon' => 'tablet-screen-button',
		'dashicon' => 'dashicons-tablet'
    ),
    'mobile' => array(
        'name' => __('Mobile', 'monawp'),
        'max_width' => '479px',
		'icon' => 'mobile-screen',
		'dashicon' => 'dashicons-smartphone'
    ),
);

$monawp_border_style_options_random = [
    'solid',
    'dashed',
    'double',
];

$monawp_border_options_random = [
    'border',
	'border-bottom',
	'border-left'
];

$monawp_display_options = [
    __('Default', 'monawp') => '',
	__('None', 'monawp') => 'none',
    __('Block', 'monawp') => 'block',
    __('Inline', 'monawp') => 'inline',
    __('Inline Block', 'monawp') => 'inline-block',
    __('Flex', 'monawp') => 'flex',
    __('Grid', 'monawp') => 'grid',
    __('Table', 'monawp') => 'table',
    __('Table Cell', 'monawp') => 'table-cell',
    __('Table Row', 'monawp') => 'table-row',
];

$monawp_flex_direction_options = [
    '' => __('None', 'monawp'),
    'row' => __('Row', 'monawp'),
    'row-reverse' => __('Row Reverse', 'monawp'),
    'column' => __('Column', 'monawp'),
    'column-reverse' => __('Column Reverse', 'monawp'),
];

$monawp_flex_wrap_options = [
    __('None', 'monawp') => '',
    __('No Wrap', 'monawp') => 'nowrap',
    __('Wrap', 'monawp') => 'wrap',
    __('Wrap Reverse', 'monawp') => 'wrap-reverse',
];

global $monawp_main_bg_colors;

$monawp_main_bg_colors = array(
	'var(--monawp-main-contrast-color)',
	'var(--monawp-secondary-contrast-color)',
	'var(--monawp-tertiary-contrast-color)',
);

$monawp_justify_content_options_simple = [
    '',
    'flex-start',
    'center',
    'space-between',
    'space-around',
    'space-evenly',
];

$monawp_justify_content_options = [
    '' => __('None', 'monawp'),
    'flex-start' => __('Start', 'monawp'),
    'flex-end' => __('End', 'monawp'),
    'center' => __('Center', 'monawp'),
    'space-between' => __('Space Between', 'monawp'),
    'space-around' => __('Space Around', 'monawp'),
    'space-evenly' => __('Space Evenly', 'monawp'),
];

$monawp_align_items_options = [
    __('None', 'monawp') => '',
    __('Start', 'monawp') => 'flex-start',
    __('End', 'monawp') => 'flex-end',
    __('Center', 'monawp') => 'center',
    __('Baseline', 'monawp') => 'baseline',
    __('Stretch', 'monawp') => 'stretch',
];

$monawp_system_fonts = [
    'Inherit' => __('Inherit', 'monawp'),
    'Arial' => 'Arial, sans-serif',
    'Verdana, sans-serif' => 'Verdana',
    'Helvetica, sans-serif' => 'Helvetica', // Might not be available on all systems
    'Tahoma, sans-serif' => 'Tahoma',
    'Georgia, serif' => 'Georgia',
    'Times New Roman, serif' => 'Times New Roman',
    'Courier New, monospace' => 'Courier New',
    '"Courier 10 Pitch", courier, monospace' => 'Courier 10 Pitch',
    'Calibri, sans-serif' => 'Calibri', // Windows font
    'Trebuchet MS, sans-serif' => 'Trebuchet MS', // Windows font
    'Impact, sans-serif' => 'Impact', // Windows font
    'Arial Black, sans-serif' => 'Arial Black', // Windows font
    'Lucida Console, monospace' => 'Lucida Console',
    'Lucida Sans Unicode, sans-serif' => 'Lucida Sans Unicode',
    'MS Gothic, sans-serif' => 'MS Gothic', // Japanese font (example)

    // Additional Commonly Available Fonts
    'Open Sans, sans-serif' => 'Open Sans', // Often pre-installed on some systems
    'Roboto, sans-serif' => 'Roboto', // Often pre-installed on some systems
    'DejaVu Sans, sans-serif' => 'DejaVu Sans', // Linux
    'Noto Sans, sans-serif' => 'Noto Sans', // Linux

    // Sans-Serif (safer options)
    'Franklin Gothic FS, sans-serif' => 'Franklin Gothic FS', // Windows
    'Frutiger, serif' => 'Frutiger', // May not be widely available
    'Fira Sans, sans-serif' => 'Fira Sans', // Open-source font, often pre-installed

    // Serif (safer options)
    'Palatino Linotype, serif' => 'Palatino Linotype', // May not be widely available
    'Book Antiqua, serif' => 'Book Antiqua', // May not be widely available
    'Merriweather, serif' => 'Merriweather', // Open-source font, often pre-installed

    // Monospace (safer options)
    'Consolas, monospace' => 'Consolas', // Windows
    'Monaco, monospace' => 'Monaco', // Mac

    // Fallback web fonts (consider licensing)
    'Source Sans Pro, sans-serif' => 'Source Sans Pro', // Open-source font, widely available for web use
    'Lato, sans-serif' => 'Lato', // Open-source font, widely available for web use
];


$monawp_font_weights = [
    __('None', 'monawp') => '',
  '200' => '200',
  '300' => '300',
  '400' => '400', // Most common default weight
  '500' => '500',
  '600' => '600',
  '700' => '700',
  '800' => '800',
  '900' => '900',
];

$monawp_font_stretch_options = [
    __('None', 'monawp') => '',
    __('Ultra Condensed', 'monawp') => 'ultra-condensed',
    __('Extra Condensed', 'monawp') => 'extra-condensed',
    __('Condensed', 'monawp') => 'condensed',
    __('Semi Condensed', 'monawp') => 'semi-condensed',
    __('Normal', 'monawp') => 'normal', // Default value
    __('Semi Expanded', 'monawp') => 'semi-expanded',
    __('Expanded', 'monawp') => 'expanded',
    __('Extra Expanded', 'monawp') => 'extra-expanded',
    __('Ultra Expanded', 'monawp') => 'ultra-expanded',
];


$monawp_text_decoration_options = [
  __('None', 'monawp') => '',
  __('Underline', 'monawp') => 'underline',
  __('Overline', 'monawp') => 'overline',
  __('Line Through', 'monawp') => 'line-through',
  __('Initial Value', 'monawp') => 'initial',
  __('Inherit', 'monawp') => 'inherit',
];

$monawp_background_repeat_options = [
  __('None', 'monawp') => '',
  __('Repeat X', 'monawp') => 'repeat-x', 
  __('Repeat Y', 'monawp') => 'repeat-y',  
  __('Repeat', 'monawp') => 'repeat',  
  __('Space', 'monawp') => 'space',  
  __('Round', 'monawp') => 'round', 
];

$monawp_background_size_options = [
  __('None', 'monawp') => '',
  __('Auto', 'monawp') => 'auto',  // Default value, adjusts to fit content
  __('Cover', 'monawp') => 'cover',   // Scales image to cover container
  __('Contain', 'monawp') => 'contain',  // Scales image to fit container while maintaining aspect ratio 
  __('100%', 'monawp') => '100%',      // Stretches image to 100% width/height of container
  __('50%', 'monawp') => '50%',        // Sets image to 50% width/height of container
  __('200px', 'monawp') => '200px',    // Sets fixed width of 200px (adjust units as needed)
  __('200px 100px', 'monawp') => '200px 100px',  // Sets specific width and height
  __('calc(50vw - 100px)', 'monawp') => 'calc(50vw - 100px)',  // Uses calculations for dynamic sizing
  __('inherit', 'monawp') => 'inherit', // Inherits size from parent element
  __('initial', 'monawp') => 'initial', // Sets to browser's default size
];

$monawp_clear_options = [
  __('None', 'monawp') => '',  // Default value, allows elements to float beside
  __('Left', 'monawp') => 'left',   // Clears any left-floated elements before the element
  __('Right', 'monawp') => 'right',  // Clears any right-floated elements before the element
  __('Both', 'monawp') => 'both',    // Clears both left and right-floated elements before the element
  __('Inline Start', 'monawp') => 'inline-start', // Clears floats on the start side of the containing block (left for LTR, right for RTL)
  __('Inline End', 'monawp') => 'inline-end',   // Clears floats on the end side of the containing block (right for LTR, left for RTL)
];

$monawp_cursor_options = [
  __('Default', 'monawp') => '', 
  __('Pointer', 'monawp') => 'pointer', 
  __('Wait', 'monawp') => 'wait', 
  __('Help', 'monawp') => 'help', 
  __('Crosshair', 'monawp') => 'crosshair', 
  __('Move', 'monawp') => 'move',    
  __('Text', 'monawp') => 'text',    
  __('None', 'monawp') => 'none',    
  __('Not-allowed', 'monawp') => 'not-allowed', 
];

$monawp_overflow_options = [
  __('Default', 'monawp') => '', 
  __('Visible', 'monawp') => 'visible', 
  __('Hidden', 'monawp') => 'hidden',   
  __('Scroll', 'monawp') => 'scroll',    
  __('Auto', 'monawp') => 'auto',        
];

$monawp_customizer_defaults = array(
	'monawp-main-color' => 'rgba(17, 17, 17, 1)', //dark
	'monawp-secondary-color' => 'rgba(7, 7, 7, 1)', //dark
	'monawp-special-color' => 'rgba(11, 27, 65, 1)', //dark
	'monawp-special-secondary-color' => 'rgba(13, 26, 32, 1)', //dark
	'monawp-special-contrast-color' => 'rgba(235, 243, 15, 1)', //light
	'monawp-main-contrast-color' => 'rgba(255, 246, 255, 1)', //light
	'monawp-secondary-contrast-color' => 'rgba(255, 247, 255, 1)', //light
	'monawp-tertiary-contrast-color' => 'rgba(247, 238, 245, 1)', //light
	'monawp-html-font-family' => 'Palatino Linotype, serif',
	'monawp-html-font-size' => 17.8,
	'monawp-html-line-height' => 1.45,
	'monawp-headers-line-height' => 1.15,
	'monawp_color_visited_profiles' => '0',
	'monawp_color_background_profiles' => '15',
	'monawp_color_background_profiles_2' => '9',
	'monawp_color_background_profiles_hover_focus' => '0',
	'monawp_color_background_profiles_hover_focus_2' => '1',
	'monawp_global_panel_horizontal_menu_hover_effect' => true,
	'monawp_global_panel_buttons_hover_effect' => true,
	'monawp_global_panel_inputs_hover_effect' => true,
	'monawp_socials_panel_socials_hover_effect' => true,
	'monawp_global_panel_blockquote_hover_effect' => true,
	'monawp_global_panel_table_hover_effect' => true,
	'monawp_border_style_profiles' => '2',
	'monawp_body_border_style_profiles' => '0',
	'monawp_buttons_border_radius' => 0,
	'monawp_inputs_border_radius' => 0,
	'monawp_socials_border_radius' => 0,
	'monawp_border_bottom_style_profiles' => '0',
	'monawp_buttons_box_shadow_style_profiles' => '28',
	'monawp_table_box_shadow_style_profiles' => '3',
	'monawp_inputs_box_shadow_style_profiles' => '28',
	'monawp_socials_box_shadow_style_profiles' => '0',
	'monawp_horizontal_menu_padding' => 0.8,
	'monawp_buttons_padding' => 0.6,
	'monawp_inputs_padding' => 0.6,
	'monawp_element_wrapper_spacing' => 0.2,
	'monawp_socials_padding' => 0.6,
	'monawp_topbar_padding' => 0.8,
	'monawp_header_padding' => 0.8,
	'monawp_footer_padding' => 0.8,
	'monawp_sidebar_content_spacing' => 0.2,
	'monawp_main_site_wrapper_padding' => 0.4,
	'monawp_main_site_wrapper_padding_v' => 2,
	'monawp_socials_gap' => 0.6,
	'monawp-headers-font-family' => 'Inherit',
	'monawp_generic_info_phone' => '(+5) 555 567 890',
	'monawp_generic_info_email' => 'example@gmail.com',
	'monawp_logo_max_width' => 100,
	'monawp_inner_items__margin' => 0.8,
	'monawp_topbar_max_width' => 1999,
	'monawp_header_max_width' => 1999,
	'monawp_left_sidebar_width' => 25,
	'monawp_main_content_width' => 70,
	'monawp_right_sidebar_width' => 25,
	'monawp_main_site_wrapper_max_width' => 1590,
	'monawp_footer_max_width' => 1999,
	'monawp_article_spacing_horizontal' => 0.8,
	'monawp_article_spacing_vertical' => 1.2,
	'monawp_widget_spacing_horizontal' => 0.4,
	'monawp_widget_spacing_vertical' => 1.2,
	'monawp_default_sidebar_layout' => '2 Columns - Right Sidebar',
	'monawp_topbar_enable' => false,
	'monawp_sticky_header' => true,
	'monawp_header_defaults' => array(
		'h1' => array(
			'font-size' => '3',
			'letter-spacing' => '0.04',
			'label' => __('Heading 1', 'monawp'),
		),
		'h2' => array(
			'font-size' => '2.5',
			'letter-spacing' => '0.04',
			'label' => __('Heading 2', 'monawp'),
		),
		'h3' => array(
			'font-size' => '2.25',
			'letter-spacing' => '0.04',
			'label' => __('Heading 3', 'monawp'),
		),
		'h4' => array(
			'font-size' => '2',
			'letter-spacing' => '0.04',
			'label' => __('Heading 4', 'monawp'),
		),
		'h5' => array(
			'font-size' => '1.75',
			'letter-spacing' => '0.04',
			'label' => __('Heading 5', 'monawp'),
		),
		'h6' => array(
			'font-size' => '1.5',
			'letter-spacing' => '0.04',
			'label' => __('Heading 6', 'monawp'),
		),
	),
	'monawp_related_posts_count' => 4,
	'monawp_topbar_flex_direction' => 'row',
	'monawp_header_flex_direction' => 'row',
	'monawp_footer_flex_direction' => 'row',
	'monawp_topbar_justify_content' => 'space-between',
	'monawp_header_justify_content' => 'space-between',
	'monawp_footer_justify_content' => 'center',
	'monawp_layout_featured_thumbnail_size' => 'monawp_large_thumbnail',
	'monawp_topbar_background_color_profile' => 'var(--monawp-secondary-contrast-color)',
	'monawp_header_background_color_profile' => 'var(--monawp-main-contrast-color)',
	'monawp_footer_background_color_profile' => 'var(--monawp-main-contrast-color)',
	'monawp_body_background_color_profile' => 'var(--monawp-tertiary-contrast-color)',
	'monawp_left_sidebar_background_color_profile' => 'var(--monawp-main-contrast-color)',
	'monawp_main_content_background_color_profile' => 'var(--monawp-main-contrast-color)',
	'monawp_right_sidebar_background_color_profile' => 'var(--monawp-secondary-contrast-color)',
	'monawp_global_panel_scroll_to_top_show' => true,
	'monawp_global_panel_scroll_to_top_position' => 'right',
	'monawp_global_panel_scroll_to_top_offset_bottom' => 60,
	'monawp_global_panel_scroll_to_top_offset_side' => 30,
	'monawp_global_panel_scroll_to_top_hide_mobile' => true,
	'monawp_main_content_grid_preset' => '1',
	'monawp_main_content_article_layout' => 'main_content_3',
	'monawp_global_panel_preloader_enable' => true
);

global $monawp_custom_plugin_default_css;

$monawp_custom_plugin_default_css = array(
    'jetPack' => array(
        'custom_css' => '#infinite-footer {
			z-index:77
		}
		
		#infinite-footer .container {
	background:var(--monawp-main-contrast-color);
	padding:0.8rem 1.2rem;
	border:1px solid var(--monawp-main-color);;
	color:var(--monawp-main-color);
}

#infinite-footer .blog-credits a,#infinite-footer .blog-info a {
	color: inherit;
	font-size: inherit;
}

#infinite-footer .blog-credits a:hover,#infinite-footer .blog-credits a:focus,#infinite-footer .blog-info a:hover,#infinite-footer .blog-info a:focus {
	color: '.$monawp_color_visited_profiles[get_theme_mod("monawp_global_panel_a_tag_color_profile", $monawp_customizer_defaults["monawp_color_visited_profiles"])]["visited"].';
}

.wp-block-jetpack-contact-form {
    padding: 0 !important;
}

.sd-social-icon-text .sd-content ul li a.sd-button {
	background:var(--monawp-secondary-contrast-color);
	color:var(--monawp-main-color) !important;
	font-family:inherit;
	font-size:inherit;
	padding:0.6rem 0.9rem;
}

div.sharedaddy h3.sd-title {
	font-family:inherit;
	font-size:inherit;
	margin:0 0 0.6rem 0;
}

.sd-content .share-customize-link a {
	font-size:inherit;
	font-family:inherit;
}

#infinite-footer .blog-credits {
    color: inherit;
    font-size: inherit;
}

.wp-block-jetpack-slideshow .wp-block-jetpack-slideshow_caption.gallery-caption {
	background:var(--monawp-secondary-contrast-color);
	color:var(--monawp-main-color);
}

.jetpack-sharing-button__button {
	background:var(--monawp-secondary-contrast-color);
	color:var(--monawp-main-color);
}

.jetpack-sharing-button__button svg {
	fill:var(--monawp-main-color);
}

.jetpack-upgrade-plan-banner .jetpack-upgrade-plan-banner__wrapper {
	padding:0.6rem;
	background:var(--monawp-secondary-contrast-color);
	color:var(--monawp-main-color);
	font-size: inherit;
}

.jetpack-upgrade-plan-banner .jetpack-upgrade-plan-banner__wrapper .banner-description, .jetpack-upgrade-plan-banner .jetpack-upgrade-plan-banner__wrapper .banner-title {
	color:var(--monawp-main-color);
}

.jetpack-upgrade-plan-banner .jetpack-upgrade-plan-banner__wrapper .components-button.is-primary {
	background:var(--monawp-secondary-contrast-color);
	color:var(--monawp-main-color);
	font-size: inherit;
}

.jetpack-upgrade-plan-banner .jetpack-upgrade-plan-banner__wrapper > * {
	padding:0.4rem;
}

',
        'label' => 'JetPack',
        'condition' => function () {
            return Helpers::isJetpackEnabled();
        },
    ),
    'fluentForms' => array(
        'custom_css' => '.fluentform .ff-el-tooltip svg {
	fill:var(--monawp-special-secondary-color)
}

.fluentform .ff-el-tooltip {
	margin-left:0.4rem;
}

			#page.site .fluentform label, #page.site .fluentform input, #page.site .fluentform textarea  {
				margin:0.3rem 0;
			}


        ',
        'label' => 'Fluent Forms',
        'condition' => function () {
            return Helpers::isFluentFormsEnabled();
        },
    ),
	
  'wpforms' => array(
    'custom_css' => '

	',
    'label' => 'WPForms',
    'condition' => function () {
      return Helpers::isWPFormsEnabled(); // Assuming a helper function for WPForms check
    },
  ),
  
  'easy_toc' => array(
    'custom_css' => '
#ez-toc-container {
	background:var(--monawp-main-color);
	color:var(--monawp-main-contrast-color);
	border-radius:0;
	border:2px solid var(--monawp-secondary-color);
	padding:1rem 1.5rem 1rem 1rem;
}

#page.site form #ez-toc-container {
	color:var(--monawp-main-contrast-color) !important;
}

#ez-toc-container a, #page.site form #ez-toc-container a {
	color:var(--monawp-special-contrast-color) !important;
}

#ez-toc-container svg, #page.site form #ez-toc-container svg {
	fill:var(--monawp-special-contrast-color) !important;
	color:var(--monawp-special-contrast-color) !important;
}

#ez-toc-container .ez-toc-js-icon-con, #ez-toc-container .ez-toc-toggle label, .ez-toc-cssicon {
	border:none;
}
	',
    'label' => 'Easy Table of Contents',
    'condition' => function () {
      return Helpers::isPluginEnabled('easy-table-of-contents/easy-table-of-contents.php'); 
    },
  ),
  
  'forminator' => array(
    'custom_css' => '
	#page.site .forminator-input-with-suffix span {
	color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_inputs_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).' !important;
	}
	.et-db #et-boc .et_pb_module .forminator-ui .forminator-icon-calendar:before, .forminator-ui .forminator-icon-calendar:before {display:none}

	.et-db #et-boc .et_pb_module .forminator-ui.forminator-custom-form[data-design=default] .forminator-checkbox__wrapper, .forminator-ui.forminator-custom-form[data-design=default] .forminator-checkbox__wrapper {
		align-items: center;
	}
	@media (min-width: 783px) {
		.et-db #et-boc .et_pb_module .forminator-ui.forminator-custom-form[data-design=default]:not(.forminator-size--small) .forminator-timepicker .forminator-row, .forminator-ui.forminator-custom-form[data-design=default]:not(.forminator-size--small) .forminator-timepicker .forminator-row {
			align-items: center;
		}
	}
	',
    'label' => 'Forminator',
    'condition' => function () {
      return Helpers::isPluginEnabled('forminator/forminator.php'); 
    },
  ),
  'mailchimp_for_wp' => array(
    'custom_css' => '
	',
    'label' => 'Mailchimp for WP',
    'condition' => function () {
      return Helpers::isPluginEnabled('mailchimp-for-wp/mailchimp-for-wp.php'); 
    },
  ),
  'tablepress' => array(
    'custom_css' => '
.tablepress img {
    max-width: 100%;
}
	',
    'label' => 'TablePress',
    'condition' => function () {
      return Helpers::isPluginEnabled('tablepress/tablepress.php'); 
    },
  ),
  
  'yith_wishlist' => array(
    'custom_css' => '.wishlist_table tr td.product-thumbnail a {
    display: flex;
}
.yith-wcwl-add-to-wishlist {
    margin: 0.6rem 0;
}
#yith-wcwl-popup-message {
	background:var(--monawp-main-contrast-color);
}
.wishlist_table .product-add-to-cart a {
    margin: 0.4rem auto !important;
}
.wishlist-title.wishlist-title-with-form h2:hover {
    background-color:transparent;
}
.wishlist-title:hover a.show-title-form i {
    display:none;
}
	',
    'label' => 'Yith WooCommerce wishlist',
    'condition' => function () {
      return Helpers::isPluginEnabled('yith-woocommerce-wishlist/init.php'); 
    },
  ),
  
  'woocommerce' => array(
    'custom_css' => '
	
.wc-block-components-combobox .wc-block-components-combobox-control .components-form-token-field__suggestions-list .components-form-token-field__suggestion, .wc-block-components-form .wc-block-components-combobox .wc-block-components-combobox-control .components-form-token-field__suggestions-list .components-form-token-field__suggestion {
    background:var(--monawp-main-contrast-color);
}
.woocommerce div.product form.cart .group_table td:first-child {
    width: auto;
}
.woocommerce-error, .woocommerce-info, .woocommerce-message {
	background-color:transparent;
	color: var(--monawp-main-color);
}
.woocommerce div.product .woocommerce-tabs ul.tabs li a,.woocommerce div.product .woocommerce-tabs ul.tabs li.active a {
    background-color:transparent;
    color: var(--monawp-main-color);
}
.woocommerce div.product .woocommerce-tabs ul.tabs li,.woocommerce div.product .woocommerce-tabs ul.tabs li.active {
    background-color:transparent;
}

.woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) #respond input#submit, .woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) a.button, .woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) button.button, .woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) input.button, :where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce #respond input#submit, :where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce a.button, :where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce button.button, :where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce input.button {
				color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).';
				background-color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_buttons_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["background"]).';
}
#page.site .wc-block-components-notice-banner {
    background-color: transparent;
	color:inherit;
	align-items: center;
}

.woocommerce a.remove {
    display: contents;
}

	.wc-block-components-chip .wc-block-components-chip__text {
		font-size:1.5rem;
	}
	.wc-block-components-chip.wc-block-components-chip--radius-large {
		border-radius: 0.6rem;
		padding: 0.6rem;
	}
	.wc-block-components-chip.is-removable .wc-block-components-chip__text {
		padding-right: 0.9rem;
	}
	.wc-block-components-totals-discount__coupon-list {
		gap: 0.6rem;
		display: flex;
		flex-flow: column;
		margin-top: 0.6rem;
	}
.wc-block-components-chip {
    margin: 0;
}
	.wc-block-components-quantity-selector {
		width: auto;
		gap: 0.6rem;
	}
	#page.site .wc-block-components-main .wc-block-cart-items th {
		padding: 0.6rem;
		background:transparent !important;
	}
	#page.site .wc-block-components-main .wc-block-cart-items th span {
		color:var(--monawp-main-color) !important;
	}
	.wc-block-components-product-metadata {
		font-size:inherit;
	}
	
.wc-block-components-form .wc-block-components-text-input label, .wc-block-components-text-input label,.wc-block-components-combobox .wc-block-components-combobox-control label.components-base-control__label, .wc-block-components-form .wc-block-components-combobox .wc-block-components-combobox-control label.components-base-control__label {
	position:inherit;
	display:block;
	transform: translateY(-15px);
}

.wc-block-components-form .wc-block-components-text-input input:-webkit-autofill+label, .wc-block-components-form .wc-block-components-text-input.is-active label, .wc-block-components-text-input input:-webkit-autofill+label, .wc-block-components-text-input.is-active label {
	transform:none;
}

.is-medium table.wc-block-cart-items .wc-block-cart-items__row, .is-mobile table.wc-block-cart-items .wc-block-cart-items__row, .is-small table.wc-block-cart-items .wc-block-cart-items__row {
	padding: 0.6rem;
}

.wc-block-components-panel__button>.wc-block-components-panel__button-icon {
    position: relative;
    top: 10px;
    transform: translateY(-50%);
}

.wc-block-components-order-summary .wc-block-components-order-summary-item:first-child {
    padding-top: 16px;
}

.is-mobile table.wc-block-cart-items .wc-block-cart-items__row {
	display:flex;
	flex-flow:column wrap;
	gap:0.6rem;
}

#page.site .is-mobile .wc-block-components-address-card > * {
	width:100%;
	display:block
}

#page.site .is-mobile .wc-block-components-checkbox .wc-block-components-checkbox__label, .wc-block-components-checkbox>span {
	width:85%;
	display:block;
}

#page.site .is-mobile .wc-block-components-address-card, #page.site .is-mobile .wc-block-components-checkout-step__description, #page.site .is-mobile .wc-block-components-form .wc-block-components-text-input, #page.site .is-mobile .wc-block-components-text-input, #page.site .is-mobile .wc-block-components-combobox .wc-block-components-combobox-control input.components-combobox-control__input, #page.site .is-mobile .wc-block-components-form .wc-block-components-combobox .wc-block-components-combobox-control input.components-combobox-control__input {
    width:80%;
}

.woocommerce .woocommerce-customer-details .woocommerce-column__title {
    margin-top: 0.6rem;
}

.is-mobile table.wc-block-cart-items .wc-block-cart-items__row .wc-block-cart-item__image, .is-mobile table.wc-block-cart-items .wc-block-cart-items__row .wc-block-cart-item__quantity {
	padding:0;
}

.is-mobile table.wc-block-cart-items .wc-block-cart-items__row .wc-block-cart-item__total-price-and-sale-badge-wrapper {
	align-items: center;
}

.is-mobile table.wc-block-cart-items .wc-block-cart-items__row > td {
	width:100%
}

.woocommerce span.onsale {
	border-radius:0;
	padding:0 0.4rem;
}

.woocommerce .woocommerce-ordering select {
    width: 100%;
	padding-right:1.2rem !important;
}

.woocommerce:where(body:not(.woocommerce-uses-block-theme)) ul.products li.product .price,.woocommerce:where(body:not(.woocommerce-uses-block-theme)) div.product .stock {
    color: var(--monawp-special-color);
}
#page.site .woocommerce .quantity .qty {
    width: auto;
	margin-right:0.6rem;
}
#page.site .wc-block-components-radio-control__option input {
	margin-top:0;
}
.woocommerce-cart #page.site .wc-block-components-radio-control__option input {
	margin-left: -0.6rem;
}
.woocommerce ul.order_details li {
	margin-top: 1em;
}

.woocommerce form .show-password-input, .woocommerce-page form .show-password-input {
	top:1.2rem;
}

.woocommerce form .show-password-input::after, .woocommerce-page form .show-password-input::after {
	color:'.esc_attr($monawp_color_background_profiles[get_theme_mod("monawp_global_panel_inputs_color_background_profile", $monawp_customizer_defaults["monawp_color_background_profiles"])]["color"]).';
}
.woocommerce .woocommerce-customer-details address {
    padding: 1.2rem;
}
.wc-block-components-review-sort-select {
    text-align: inherit; 
	display:flex;
	flex-flow:row wrap;
	gap:1.2rem;
	align-items: center;
	margin:0.6rem 0;
}

.wc-block-components-review-list-item__info {
    margin-bottom: 0.6rem;
}

.editor-styles-wrapper .wc-block-components-review-list-item__item, .wc-block-components-review-list-item__item {
    margin: 0 0 1.2rem;
}
.woocommerce span.onsale {
    background-color: var(--monawp-special-secondary-color);
    color: var(--monawp-main-contrast-color);
}

.woocommerce .single_variation_wrap .single_add_to_cart_button {
	margin-top: 0.6rem;
}

	',
    'label' => 'Woocommerce',
    'condition' => function () {
      return Helpers::isPluginEnabled('woocommerce/woocommerce.php'); 
    },
  ),
	
);

$monawp_random_presets = array (
	'0-20:px' => null,
	'1-5:px' => null,
	'm5-5:px' => null,
	'1-3:px' => null,
	'17-25:px' => null,
	'17-20:px' => null,
	'0.5-1.0:rem' => null,
	'5-8:rem' => null,
	'0.3-0.7:s' => null,
	'1.2-1.7:' => null,
	'3-15:int' => null,
	'0.8-1.5:' => null,
	'75-100:vw' => null
);

global $monawp_transition_duration_presets;
global $monawp_random_presets;
global $monawp__root_values;
global $monawp_customizer_defaults;
global $monawp_text_align_dashicons_array;
global $monawp_backdrop_filter_options;
global $monawp_border_style_options;
global $monawp_position_options;
global $monawp_display_options;
global $monawp_flex_direction_options;
global $monawp_flex_wrap_options;
global $monawp_justify_content_options;
global $monawp_align_items_options;
global $monawp_system_fonts;
global $monawp_font_weights;
global $monawp_font_stretch_options;
global $monawp_text_decoration_options;
global $monawp_float_dashicons_array;
global $monawp_background_repeat_options;
global $monawp_background_size_options;
global $monawp_blend_mode_options;
global $monawp_clear_options;
global $monawp_cursor_options;
global $monawp_overflow_options;
global $monawp_builder_elements;
global $monawp_transform_options;
global $monawp_buttons_css_selector;
global $monawp_buttons_hover_focus_css_selector;
global $monawp_inputs_css_selector;
global $monawp_inputs_focus_css_selector;
global $monawp_border_style_presets;
global $monawp_border_style_options_random;
global $monawp_color_css_variables;
global $monawp_border_options_random;
global $monawp_structure_prefixes_array;
?>