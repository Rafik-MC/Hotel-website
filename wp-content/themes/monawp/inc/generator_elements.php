<?php

namespace MonaWP\Builder;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MonaWP\Resources\Icons as Icons;
use MonaWP\Resources\Helpers as Helpers; 
use MonaWP\Resources\Schema as Schema;

class Elements {
	
	public static function html_wrapper($html, $class) {

		// Check if the HTML is not empty
		if (!empty($html)) {
			// Wrap the HTML with monawp-element-wrapper div
			$html = '<div class="monawp-element-wrapper ' . strtolower($class) . '">' . $html . '</div>';
			return $html;
		} else {
			// Return empty if HTML is empty
			return '';
		}
	}
    
	public static function monawp_site_logo_element() {
		global $monawp_random_presets;
		
		$html = '';
		if (function_exists('has_custom_logo') && has_custom_logo() && get_custom_logo()) {
			$html = get_custom_logo();
			// Get the custom logo link
			preg_match('/<a(.*?)>/', $html, $matches);
			$logo_link = isset($matches[0]) ? $matches[0] : '';

			// Add aria-label attribute to the logo link
			$aria_label = __('Site Logo', 'monawp');
			// Insert aria-label attribute inside the opening <a> tag
			$html = preg_replace('/<a(.*?)>/', '<a$1 aria-label="' . esc_attr($aria_label) . '">', $html);
		}
		
		$html = apply_filters('monawp_site_logo_html_filter', $html);

		return array(
			'html' => $html,
		);
	}

	public static function monawp_site_title_element() {
		$title = get_bloginfo('name');
		$aria_label = __('Site Title', 'monawp');

		$html = '';
		if (!empty($title)) {
			if (is_front_page() && is_home()) :
				$html = '<h1 class="monawp-site-title"><a href="' . esc_url(home_url('/')) . '" rel="home" aria-label="' . esc_attr($aria_label) . '">' . esc_html($title) . '</a></h1>';
			else :
				$html = '<h2 class="monawp-site-title"><a href="' . esc_url(home_url('/')) . '" rel="home" aria-label="' . esc_attr($aria_label) . '">' . esc_html($title) . '</a></h2>';
			endif;
		}
		
		$html = apply_filters('monawp_site_title_html_filter', $html);

		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_site_description_element() {
		$description = get_bloginfo('description');
		$aria_label = __('Site Description', 'monawp');

		$html = '';
		if (!empty($description)) {
			$html = '<p class="monawp-site-description" aria-label="' . esc_attr($aria_label) . '">' . esc_html($description) . '</p>';
		}
		
		$html = apply_filters('monawp_site_description_html_filter', $html);

		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_similar_posts_element() {
		global $post;
		global $monawp_customizer_defaults;

		// Initialize HTML variable
		$html = '';
		
		if (!get_theme_mod('monawp_elements_panel_related_posts_count', $monawp_customizer_defaults['monawp_related_posts_count'])) {
			return array(
				'html' => $html,
			);
		}

		// Get the current post ID
		$current_post_id = $post->ID;

		// Get categories and tags of the current post
		$categories = wp_get_post_categories($current_post_id);
		$tags = wp_get_post_tags($current_post_id);
		$tag_ids = array();
		foreach ($tags as $tag) {
			$tag_ids[] = $tag->term_id;
		}
		$first_category = !empty($categories) ? get_the_category($current_post_id)[0] : null;
		$first_tag = !empty($tag_ids) ? get_term($tag_ids[0], 'post_tag') : null;

		// Define query arguments for fetching similar posts
		$taxonomy = get_theme_mod('monawp_elements_panel_related_posts_taxonomy', 'both');
		$tax_query = array();

		if ($taxonomy === 'category' || $taxonomy === 'both') {
			$tax_query[] = array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => $categories,
			);
		}

		if ($taxonomy === 'post_tag' || $taxonomy === 'both') {
			$tax_query[] = array(
				'taxonomy' => 'post_tag',
				'field' => 'term_id',
				'terms' => $tag_ids,
			);
		}
		
		// If both tags and categories are queried, set relation to 'OR'
		if ($taxonomy === 'both') {
			$tax_query['relation'] = 'OR';
		}

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => get_theme_mod('monawp_elements_panel_related_posts_count', $monawp_customizer_defaults['monawp_related_posts_count']),
			'post__not_in' => array($current_post_id),
			'orderby' => get_theme_mod('monawp_elements_panel_related_posts_sort_by', 'rand'),
			'tax_query' => $tax_query,
		);

		// Query similar posts
		$similar_posts_query = new \WP_Query($args);

		// Check if there are similar posts
		if ($similar_posts_query->have_posts()) {
			ob_start();
			?>
			<?php if (get_theme_mod('monawp_elements_panel_related_posts_title', __('You May Also Like:', 'monawp'))) {
				$similar_posts_title = '<h2>'.esc_html(get_theme_mod('monawp_elements_panel_related_posts_title', __('You May Also Like:', 'monawp'))).'</h2>';
				$similar_posts_title = apply_filters('monawp_similar_posts_title_html_filter', $similar_posts_title);
				echo $similar_posts_title;
			}
			?>
			<div class="similar-posts-wrapper">
				<?php
				// Loop through similar posts
				while ($similar_posts_query->have_posts()) {
					$similar_posts_query->the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('similar-post'); ?>>
						<h3 class="similar-post-title"><a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
						<?php if (has_post_thumbnail()) : ?>
							<?php echo self::html_wrapper(self::monawp_similar_post_thumbnail_element(get_theme_mod('monawp_elements_panel_related_posts_thumbnail_size', 'monawp_medium_thumbnail'), true)['html'], 'monawp_post_thumbnail_element'); ?>
						<?php endif; ?>
						
						<?php if (get_theme_mod('monawp_elements_panel_related_posts_display_date', true)) : ?>
							<div class="similar-post-date">
								
								<a href="<?php the_permalink(); ?>" aria-label="<?php 
								// translators: %d is the date
								printf(__('View post published on %s', 'monawp'), get_the_date()); ?>">
									<?php echo get_the_date(); ?>
								</a>
							</div>
						<?php endif; ?>

						<?php if (get_theme_mod('monawp_elements_panel_related_posts_display_excerpt', false)) : ?>
							<div class="similar-post-excerpt">
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>

						<?php if (get_theme_mod('monawp_elements_panel_related_posts_display_author', true)) : ?>
							<div class="similar-post-author">
								<?php
								printf(
									// translators: %1$s is the URL to the author's posts, %2$s is the author's name
									__('<span>By:</span> <a href="%1$s">%2$s</a>', 'monawp'),
									esc_url(get_author_posts_url(get_the_author_meta('ID'))),
									get_the_author()
								);
								?>
							</div>
						<?php endif; ?>

						<?php if (get_theme_mod('monawp_elements_panel_related_posts_display_category', true) && !empty($first_category)) : ?>
							<div class="similar-post-category">
								<?php
								printf(
									// translators: %1$s is the URL to the category, %2$s is the category name
									__('<span>Category:</span> <a href="%1$s">%2$s</a>', 'monawp'),
									esc_url(get_category_link($first_category->term_id)),
									esc_html($first_category->name)
								);
								?>
							</div>
						<?php endif; ?>

						<?php if (get_theme_mod('monawp_elements_panel_related_posts_display_tags', false) && !empty($first_tag)) : ?>
							<div class="similar-post-tags">
								<?php
								printf(
									// translators: %1$s is the URL to the tag, %2$s is the tag name
									__('<span>Tag:</span> <a href="%1$s">%2$s</a>', 'monawp'),
									esc_url(get_tag_link($first_tag->term_id)),
									esc_html($first_tag->name)
								);
								?>
							</div>
						<?php endif; ?>

						<?php if (get_theme_mod('monawp_elements_panel_related_posts_display_comments_count', false)) : ?>
							<div class="similar-post-comments-count">
								
								<a href="<?php comments_link(); ?>" aria-label="<?php 
								// translators: %d is the number of comments
								printf(_n('View %d comment', 'View %d comments', get_comments_number(), 'monawp'), get_comments_number()); ?>">
									<?php echo get_comments_number_text(); ?>
								</a>
							</div>
						<?php endif; ?>
					</article>
					<?php
				}
				?>
			</div>
			<?php
			// Get the buffered content and clean the output buffer
			$html = ob_get_clean();
		}

		// Restore original post data
		wp_reset_postdata();

		// Return the HTML
		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_topbar_horizontal_menu_element() {
		$html = ''; // Initialize HTML variable

		// Check if menu-horizontal is registered
		if (has_nav_menu('menu-horizontal-topbar')) {
			ob_start();

			// Output the navigation menu HTML
			wp_nav_menu(
				array(
					'theme_location' => 'menu-horizontal-topbar',
					'menu_class' => 'horizontal-navigation-desktop vertical-navigation-tablet',
					// You can add more parameters here as needed
				)
			);

			// Get the buffered content and clean the output buffer
			$html = ob_get_clean();
			
			$html = '
				<nav '.Schema::getPart('nav').' aria-label="' . esc_attr__('Horizontal Menu', 'monawp') . '" class="horizontal-navigation-desktop vertical-navigation-tablet" role="navigation">
					<button class="menu-toggle" aria-controls="horizontal-menu-topbar" aria-expanded="false">☰</button>
					' . $html . '
				</nav><!-- #site-navigation -->
			';
		}
		
		$html = apply_filters('monawp_topbar_horizontal_menu_html_filter', $html);
		
		return array(
			'html' => $html,
		);

    }

    public static function monawp_header_horizontal_menu_element() {
		$html = ''; // Initialize HTML variable

		// Check if menu-horizontal is registered
		if (has_nav_menu('menu-horizontal-header')) {
			ob_start();

			// Output the navigation menu HTML
			wp_nav_menu(
				array(
					'theme_location' => 'menu-horizontal-header',
					'menu_class' => 'horizontal-navigation-desktop vertical-navigation-tablet',
					// You can add more parameters here as needed
				)
			);

			// Get the buffered content and clean the output buffer
			$html = ob_get_clean();
			
			$html = '
				<nav '.Schema::getPart('nav').' aria-label="' . esc_attr__('Horizontal Menu', 'monawp') . '" class="horizontal-navigation-desktop vertical-navigation-tablet" role="navigation">
					<button class="menu-toggle" aria-controls="horizontal-menu-header" aria-expanded="false">☰</button>
					' . $html . '
				</nav><!-- #site-navigation -->
			';
		}
		
		$html = apply_filters('monawp_header_horizontal_menu_html_filter', $html);
		
		return array(
			'html' => $html,
		);

    }
	
	public static function monawp_search_element() {
		global $monawp_generated_animation_profiles;
		ob_start();
		?>
			<div class="search-button-wrapper">
				<button class="search-element-button" aria-label="<?php esc_attr_e( 'Search', 'monawp' ); ?>" aria-expanded="false">
					<?php echo Icons::getSVGContents('/fa/solid/magnifying-glass.svg'); ?>
				</button>
			</div>

			<div aria-label="<?php esc_attr_e( 'Search', 'monawp' ); ?>" class="search-wrapper">
				<button class="search-close-button" aria-label="<?php esc_attr_e( 'Search Close', 'monawp' ); ?>" aria-expanded="false">
					<?php echo Icons::getSVGContents('/fa/solid/xmark.svg'); ?>
				</button>
				<?php get_search_form(); ?>
			</div>
			<?php
		$html = ob_get_clean();
		
		$html = apply_filters('monawp_search_element_html_filter', $html);

		return array(
			'html' => $html,
		);
	}

	public static function monawp_generic_info_element($style='icons') {
		global $monawp_customizer_defaults;
		// Initialize HTML variable
		$html = '';

		// Fetch the email and phone values from theme mod or use default values
		$email = get_theme_mod('monawp_generic_info_email', $monawp_customizer_defaults["monawp_generic_info_email"]);
		$phone = get_theme_mod('monawp_generic_info_phone', $monawp_customizer_defaults["monawp_generic_info_phone"]);

		// If there are non-empty theme mods for generic info, add the outer div
		if (Helpers::isGenericInfoAdded()) {
			if ($style === 'icons') {
				if (!empty($email)) {
					// Get schema attributes for email
					$email_schema = Schema::getPart('email');
					// Encode email to prevent spam bots
					$encoded_email = antispambot($email);
					// Add email with schema attributes
					$html .= '<div>';
					$html .= '<a href="mailto:' . esc_attr($encoded_email) . '" aria-label="' . esc_attr(__('Email', 'monawp')) . '">' . Icons::getSVGContents('/fa/regular/envelope.svg') . '</a>';
					$html .= '<div ' . $email_schema . ' >' . esc_html($encoded_email) . '</div>';
					$html .= '</div>';
				}
				if (!empty($phone)) {
					// Get schema attributes for phone
					$phone_schema = Schema::getPart('phone');
					// Add phone with schema attributes
					$html .= '<div>';
					$html .= '<a href="tel:' . esc_attr($phone) . '" aria-label="' . esc_attr(__('Phone', 'monawp')) . '">' . Icons::getSVGContents('/fa/solid/mobile-screen.svg') . '</a>';
					$html .= '<div ' . $phone_schema . ' >' . esc_html($phone) . '</div>';
					$html .= '</div>';
				}
			}
		}

		$html = apply_filters('monawp_generic_info_element_html_filter', $html);

		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_socials_element($style = 'icons') {
		
		// Initialize HTML variable
		$html = '';

		// If there are non-empty theme mods, add the outer div
		if (Helpers::areSocialProfilesAdded()) {
			
			if ($style === 'icons') {
				// Get the social media icons array
				$social_icons = Icons::getIconArray('generic_social');

				// Loop through the social media icons array and add the icons if the theme mod is not empty
				foreach ($social_icons as $social_name => $social_icon) {
					$social_url = esc_url(get_theme_mod('monawp_social_profile_url_' . strtolower($social_name), ''));
					if (!empty($social_url)) {
						//echo $social_url;
						// Get the SVG content for the icon
						$svg_content = Icons::getSVGContents($social_icon);

						// If SVG content exists, add it to the HTML, wrapping it with the theme mod URL
						if ($svg_content !== null) {
							// Wrap the SVG content with the URL inside the social-icon div
							$html .= '<div class="social-icon" ><a target="_blank" href="' . $social_url . '" aria-label="'.$social_name.'">' . $svg_content . '</a></div>';
						}
					}
				}
			
			}

		}
		
		$html = apply_filters('monawp_socials_element_html_filter', $html);

		return array(
			'html' => $html,
		);
	}
	
    public static function monawp_footer_horizontal_menu_element() {
		$html = ''; // Initialize HTML variable

		// Check if menu-horizontal is registered
		if (has_nav_menu('menu-horizontal-footer')) {
			ob_start();

			// Output the navigation menu HTML
			wp_nav_menu(
				array(
					'theme_location' => 'menu-horizontal-footer',
					'menu_class' => 'horizontal-navigation-desktop vertical-navigation-tablet',
					// You can add more parameters here as needed
				)
			);

			// Get the buffered content and clean the output buffer
			$html = ob_get_clean();
			$html = '
				<nav class="horizontal-navigation-desktop vertical-navigation-tablet" role="navigation">
					<button class="menu-toggle" aria-controls="horizontal-menu-footer" aria-expanded="false">☰</button>
					' . $html . '
				</nav><!-- #site-navigation -->
			';
		
			$html = apply_filters('monawp_footer_horizontal_menu__html_filter', $html);
		}
		
		return array(
			'html' => $html,
		);

    }
	
	public static function monawp_topbar_widget_element($number) {
		$html = ''; // Initialize HTML variable
		// Construct the widget ID dynamically based on the number
		$widget_id = 'topbar_widget_' . $number;
		if ( is_active_sidebar( $widget_id ) && is_dynamic_sidebar( $widget_id ) ) {
			ob_start();
			dynamic_sidebar( $widget_id );
			$html = ob_get_clean();
		
			$html = apply_filters('monawp__'.$widget_id.'_topbar_widget__html_filter', $html);
		}
		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_header_widget_element($number) {
		$html = ''; // Initialize HTML variable
		// Construct the widget ID dynamically based on the number
		$widget_id = 'header_widget_' . $number;
		if ( is_active_sidebar( $widget_id ) && is_dynamic_sidebar( $widget_id ) ) {
			ob_start();
			dynamic_sidebar( $widget_id );
			$html = ob_get_clean();
		
			$html = apply_filters('monawp__'.$widget_id.'_header_widget__html_filter', $html);
		}
		return array(
			'html' => $html,
		);
	}

	public static function monawp_footer_widget_element($number) {
		$html = ''; // Initialize HTML variable
		// Construct the widget ID dynamically based on the number
		$widget_id = 'footer_widget_' . $number;
		if ( is_active_sidebar( $widget_id ) && is_dynamic_sidebar( $widget_id ) ) {
			ob_start();
			dynamic_sidebar( $widget_id );
			$html = ob_get_clean();
		
			$html = apply_filters('monawp__'.$widget_id.'_footer_widget__html_filter', $html);
		}
		return array(
			'html' => $html,
		);
	}
	
	public static function monawp__sidebar_widget__element($direction) {
		$html = ''; // Initialize HTML variable
		// Check if menu-horizontal is registered
		
		global $monawp_sidebar_ids;
		$override_sidebar = false;

		foreach ($monawp_sidebar_ids[$direction] as $name => $sidebar_id) {
			if ($name == 'global') {
				continue;
			}
			if (Helpers::checkPageCondition($name) and Helpers::showSidebar($sidebar_id) ) {
				$override_sidebar = true;
				ob_start();
				dynamic_sidebar( $sidebar_id );
				$html = ob_get_clean();
			}
		}
		
		if ( Helpers::showSidebar($direction.'_sidebar_widget_one') and !$override_sidebar) {
			ob_start();

			dynamic_sidebar( $direction.'_sidebar_widget_one' );
			$html = ob_get_clean();
		
			$html = apply_filters('monawp__'.$direction.'_sidebar_widget__html_filter', $html);
		}
		
		return array(
			'html' => $html,
			);
	}
		
	public static function monawp_post_thumbnail_element($size='monawp_medium_thumbnail', $lazy=false) {
		global $post;
		
		// Initialize HTML variable
		$html = '';

		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return array(
				'html' => $html,
			);
		}

		ob_start();
		
		if (is_singular()) {
			?>
			<div class="post-thumbnail">
				<?php monawp_custom_post_thumbnail_html($size, $lazy); ?>
			</div><!-- .post-thumbnail -->
			<?php
		} else {
			if (has_post_thumbnail()) {
				
				$thumbnail_aria_label = sprintf(
					/* translators: %s: Post title. */
					esc_attr__('Thumbnail for %s', 'monawp'),
					the_title_attribute(array('echo' => false))
				);
				?>
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr($thumbnail_aria_label); ?>">
					<?php monawp_custom_post_thumbnail_html($size, $lazy); ?>
				</a>
				<?php
			}
		}

			$html = ob_get_clean();
		
			$html = apply_filters('monawp_post_thumbnail_html_filter', $html);

		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_similar_post_thumbnail_element($size='monawp_medium_thumbnail', $lazy=true) {
		global $post;
		
		// Initialize HTML variable
		$html = '';

		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return array(
				'html' => $html,
			);
		}

		ob_start();
			if (has_post_thumbnail()) {
				
				$thumbnail_aria_label = sprintf(
					/* translators: %s: Post title. */
					esc_attr__('Thumbnail for %s', 'monawp'),
					the_title_attribute(array('echo' => false))
				);
				?>
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr($thumbnail_aria_label); ?>">
					<?php monawp_custom_post_thumbnail_html($size, $lazy); ?>
				</a>
				<?php
			}
			$html = ob_get_clean();
		
			$html = apply_filters('monawp_similar_post_thumbnail_html_filter', $html);

		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_entry_breadcrumbs_element() {
		ob_start();
		?>
		<div class="breadcrumbs" <?php echo Schema::getPart('breadcrumbs'); ?> >
			<span <?php echo Schema::getPart('breadcrumb_list_element'); ?>>
				<a href="<?php echo esc_url(home_url()); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html__( 'Home', 'monawp' ); ?></span>
				</a>
				<span class="separator">></span>
				<meta itemprop="position" content="1" />
			</span>

			<?php
			if (is_404()) {
				?>
				<span <?php echo Schema::getPart('breadcrumb_list_element'); ?>>
					<span itemprop="name"><?php echo esc_html__( '404 Page Not Found', 'monawp' ); ?></span>
					<meta itemprop="position" content="2" />
				</span>
				<?php
			} elseif (is_single()) {
				if (Helpers::isWooCommerceSingleProduct()) {
					?>
					<span <?php echo Schema::getPart('breadcrumb_list_element'); ?>>
						<a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" itemprop="item">
							<span itemprop="name"><?php echo esc_html__( 'Shop', 'monawp' ); ?></span>
						</a>
						<span class="separator">></span>
						<meta itemprop="position" content="2" />
					</span>
					<?php
					$terms = get_the_terms(get_the_ID(), 'product_cat');
					if ($terms && !is_wp_error($terms)) {
						$category = $terms[0]; // Assuming the product belongs to one category
						?>
						<span <?php echo Schema::getPart('breadcrumb_list_element'); ?>>
							<a href="<?php echo esc_url(get_term_link($category)); ?>" itemprop="item">
								<span itemprop="name"><?php echo esc_html($category->name); ?></span>
							</a>
							<span class="separator">></span>
							<meta itemprop="position" content="3" />
						</span>
						<?php
					}
					?>
					<span <?php echo Schema::getPart('breadcrumb_list_element'); ?>>
						<span itemprop="name"><?php echo esc_html(get_the_title()); ?></span>
						<meta itemprop="position" content="4" />
					</span>
					<?php
					
			} else if (Helpers::isWooCommerceArchive()) {
				?>
				<span <?php echo Schema::getPart('breadcrumb_list_element'); ?>>
					<a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" itemprop="item">
						<span itemprop="name"><?php echo esc_html__( 'Shop', 'monawp' ); ?></span>
					</a>
					
					<span class="separator">></span>
					<meta itemprop="position" content="2" />
				</span>
				<span <?php echo Schema::getPart('breadcrumb_list_element'); ?>>
					<span itemprop="name">
						<?php
						if (is_product_category()) {
							single_cat_title();
						} elseif (is_product_tag()) {
							single_tag_title();
						}
						?>
					</span>
					<meta itemprop="position" content="3" />
				</span>
				<?php
			} else {
					$categories = get_the_category();
					if (!empty($categories)) {
						$category = $categories[0]; // Assuming the post belongs to one category
						?>
						<span <?php echo Schema::getPart('breadcrumb_list_element'); ?>>
							<a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" itemprop="item">
								<span itemprop="name"><?php echo esc_html($category->name); ?></span>
							</a>
							<span class="separator">></span>
							<meta itemprop="position" content="2" />
						</span>
						<?php
					}
					?>
					<span <?php echo Schema::getPart('breadcrumb_list_element'); ?>>
						<span itemprop="name"><?php echo esc_html(get_the_title()); ?></span>
						<meta itemprop="position" content="3" />
					</span>
					<?php
				} 
				
			} elseif (is_page() || is_category() || is_tag() || is_day() || is_month() || is_year() || is_author() || (isset($_GET['paged']) && !empty($_GET['paged'])) || is_search()) {
				?>
				<span <?php echo Schema::getPart('breadcrumb_list_element'); ?>>
					<span itemprop="name">
						<?php
						if (is_page()) {
							echo esc_html(get_the_title());
						} elseif (is_category()) {
							single_cat_title();
						} elseif (is_tag()) {
							single_tag_title();
						} elseif (is_day()) {
							echo esc_html__( 'Archive for', 'monawp' ) . ' ' . get_the_time('F jS, Y');
						} elseif (is_month()) {
							echo esc_html__( 'Archive for', 'monawp' ) . ' ' . get_the_time('F, Y');
						} elseif (is_year()) {
							echo esc_html__( 'Archive for', 'monawp' ) . ' ' . get_the_time('Y');
						} elseif (is_author()) {
							echo esc_html__( 'Author Archive', 'monawp' );
						} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
							echo esc_html__( 'Blog Archives', 'monawp' );
						} elseif (is_search()) {
							echo esc_html__( 'Search Results', 'monawp' );
						}
						?>
					</span>
					<meta itemprop="position" content="2" />
				</span>
				<?php
			}
			?>
		</div>
		<?php
		$html = ob_get_clean();

		$html = apply_filters('monawp_entry_breadcrumbs_html_filter', $html);

		return array(
			'html' => $html,
		);
	}

	public static function monawp_custom_pagination_element() {
		global $wp_query;

		// Check if Jetpack is active and Infinite Scroll is enabled
		if ( class_exists( 'Jetpack' ) && \Jetpack::is_module_active( 'infinite-scroll' ) ) {
			// Enqueue Jetpack's Infinite Scroll script
			add_action( 'wp_enqueue_scripts', function() {
				wp_enqueue_script( 'jetpack-infinite-scroll', plugins_url( '/modules/infinite-scroll/infinity.js', __DIR__ ), array( ), false, true );
			});

			// Return an empty string as Infinite Scroll will handle pagination
			return array(
				'html' => '',
			);
		} else {
			// Fallback to custom pagination

			// Get the total number of pages
			$total_pages = $wp_query->max_num_pages;

			// If there's more than one page, display pagination
			if ($total_pages > 1) {
				ob_start();
				?>
				<nav <?php echo Schema::getPart('nav'); ?> class="pagination" aria-label="<?php echo esc_attr__( 'Pagination', 'monawp' ); ?>">
					<ul>
						<?php
						// Define pagination arguments
						$pagination_args = array(
							'current' => max(1, get_query_var('paged')),
							'total' => $total_pages,
							'prev_next' => false,
							'type' => 'array',
							'mid_size' => 2,
							'show_all' => false,
							'end_size' => 1,
							'add_args' => false
						);

						// Get the pagination links
						$pagination_links = paginate_links($pagination_args);

						foreach ($pagination_links as $link) {
							echo '<li>' . $link . '</li>';
						}
						?>
					</ul>
				</nav>
				<?php
			$html = ob_get_clean();
		
			$html = apply_filters('monawp_custom_pagination_html_filter', $html);
				return array(
					'html' => $html,
				);
			} else {
				return array(
					'html' => '',
				);
			}
		}
	}
	
	public static function monawp_entry_title_element() {
		ob_start();
		if ( is_singular() ) :
			?>
			<h1 class="entry-title">
				<?php the_title(); ?>
			</h1>
			<?php
		else :
			?>
			<h2 class="entry-title">
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" aria-label="<?php echo __('Post link/title', 'monawp'); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			<?php
		endif;
			$html = ob_get_clean();
		
			$html = apply_filters('monawp_entry_title_html_filter', $html);

		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_entry_content_element() {
		return array(
			'html' => the_content(),
		);
	}
	
	public static function monawp_comments_form_element() {
		// Check if comments are open or if there are comments
		if ( comments_open() || get_comments_number() ) {
			// Start output buffering to capture the comments form HTML
			ob_start();
			// Include the comments template
			comments_template();
			// Get the captured HTML
			$html = ob_get_clean();
			
			$html = apply_filters('monawp_comments_form_element_html_filter', $html);
			// Return the HTML in the required format
			return array(
				'html' => $html,
			);
		} else {
			// If comments are closed and there are no comments, return an empty array
			return array(
				'html' => '',
			);
		}
	}

	
	public static function monawp_scroll_to_top_element() {
		global $monawp_customizer_defaults;

		// Get customizer values or fallback to defaults
		$show_scroll_to_top = get_theme_mod( 'monawp_global_panel_scroll_to_top_show', $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_show'] );
		$hide_on_mobile = get_theme_mod( 'monawp_global_panel_scroll_to_top_hide_mobile', $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_hide_mobile'] );

		// Check if scroll-to-top is enabled
		if ( $show_scroll_to_top ) {
			// Check if hide on mobile option is enabled
			if ( $hide_on_mobile && wp_is_mobile() ) {
				return array(
					'html' => '', // Don't display anything on mobile if hide on mobile option is enabled
				);
			}

			// Get other customizer values or fallback to defaults
			$position = get_theme_mod( 'monawp_global_panel_scroll_to_top_position', $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_position'] );
			$offset_bottom = get_theme_mod( 'monawp_global_panel_scroll_to_top_offset_bottom', $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_offset_bottom'] );
			$offset_side = get_theme_mod( 'monawp_global_panel_scroll_to_top_offset_side', $monawp_customizer_defaults['monawp_global_panel_scroll_to_top_offset_side'] );

			// Get SVG icon
			$icon_svg = Icons::getSVGContents( '/fa/solid/arrow-up.svg' ); // Assuming icons are stored in lowercase

			// Define inline styles
			$styles = 'style="';
			if ( $position === 'left' ) {
				$styles .= 'left: ' . $offset_side . 'px;';
			} else {
				$styles .= 'right: ' . $offset_side . 'px;';
			}
			$styles .= 'bottom: ' . $offset_bottom . 'px;"';

			// Output scroll-to-top element
			ob_start();
			?>
			<div class="scroll-to-top monawp-fade-in" <?php echo $styles; ?>>
				<a href="#page" aria-label="<?php echo esc_attr__( 'Scroll to top', 'monawp' ); ?>">
					<?php echo $icon_svg; ?>
				</a>
			</div>
			<?php
			$html = ob_get_clean();
		
			$html = apply_filters('monawp_scroll_to_top_element_html_filter', $html);
			return array(
				'html' => $html,
				
			);
		} else {
			return array(
				'html' => '',
			);
		}
	}

	public static function monawp_post_navigation_element() {
		// Get the previous and next post navigation
		ob_start();
		the_post_navigation(
			array(
				'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'monawp' ) . '</span> <span class="nav-title">%title</span>',
				'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'monawp' ) . '</span> <span class="nav-title">%title</span>',
			)
		);
		$html = ob_get_clean();
		
		$html = preg_replace('/<nav(.*?)>/', '<nav$1 ' . Schema::getPart('nav') . '>', $html);

		// Add aria-label attributes to the anchor tags
		$html = preg_replace_callback('/<a\s(.*?)>(.*?)<\/a>/', function($matches) {
			$attributes = $matches[1];
			$content = $matches[2];
			$aria_label = '';
			// Check if this is the previous or next link and set the aria-label accordingly
			if (strpos($attributes, 'rel="prev"') !== false) {
				$aria_label = esc_html__('Previous Post', 'monawp');
			} elseif (strpos($attributes, 'rel="next"') !== false) {
				$aria_label = esc_html__('Next Post', 'monawp');
			}
			// Add the aria-label attribute to the anchor tag
			$attributes .= ' aria-label="' . $aria_label . '"';
			return '<a ' . $attributes . '>' . $content . '</a>';
		}, $html);

		// Remove the <h2> tag
		$html = preg_replace('/<h2.*?>.*?<\/h2>/', '', $html);
		
		$html = apply_filters('monawp_post_navigation_html_filter', $html);

		// Return the HTML in the required format
		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_sharebox_element() {
		global $monawp_sharebox_defaults;

		// If no share box icon is enabled, don't display share box at all
		if (!Helpers::isShareBoxEnabled()) {
			return array('html' => ''); // Return empty HTML
		}
		
		// Get post title and URL
		$post_title = get_the_title();
		if (!is_singular()) {
			$post_title = '';
		}
		$current_url = Helpers::getCurrentUrl();
		$post_url = urlencode( $current_url );

		// Create share box
		ob_start();
		?>
		<div class="share-box-title flex-row-vc">
			<span><?php echo Icons::getSVGContents('/fa/solid/share.svg'); ?></span>
		</div>
		<div class="share-box flex-row-vc">
			<?php foreach ($monawp_sharebox_defaults as $label => $default) {
				$theme_mod_value = get_theme_mod('monawp_elements_panel_share_box_' . strtolower($label), $default);
				if ($theme_mod_value) {
					// Get icon URL for social media/network
					$icon_svg = Icons::getSVGContents('/fa/brands/' . strtolower($label) . '.svg'); // Assuming icons are stored in lowercase
					if ($label == 'Twitter') {
						$icon_svg = Icons::getSVGContents('/fa/brands/x-twitter.svg');
					}
					// Implement share URL for each social media/network
					$share_url = ''; // Initialize share URL

					// Set share URL based on the social media/network
					switch (strtolower($label)) {
						case 'facebook':
							$share_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
							break;
						case 'twitter':
							$share_url = 'https://twitter.com/intent/tweet?url=' . $post_url . '&text=' . urlencode($post_title);
							break;
						case 'linkedin':
							$share_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . $post_url;
							break;
						case 'pinterest':
							$share_url = 'https://pinterest.com/pin/create/button/?url=' . $post_url . '&description=' . urlencode($post_title);
							break;
						case 'reddit':
							$share_url = 'https://www.reddit.com/submit?url=' . $post_url . '&title=' . urlencode($post_title);
							break;
						case 'whatsapp':
							$share_url = 'https://api.whatsapp.com/send/?text=' . $post_url . '&type=custom_url&app_absent=0';
							break;
						case 'telegram':
							$share_url = 'https://telegram.me/share/url?url=' . $post_url . '&text=' . urlencode($post_title);
							break;
						case 'tumblr':
							$share_url = 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . $post_url . '&title=' . urlencode($post_title);
							break;
						case 'vk':
							$share_url = 'https://vk.com/share.php?url=' . $post_url;
							break;
						case 'medium':
							$share_url = 'https://medium.com/p/import?url=' . $post_url . '&title=' . urlencode($post_title);
							break;
						// Add cases for other social media/networks here
					}

					// Output share icon with link
					?>
					<a target="_blank" href="<?php echo esc_url($share_url); ?>" aria-label="<?php
					// translators: %d is the social media brand name
					echo esc_attr(sprintf(__('Share on %s', 'monawp'), $label)); ?>">
						<?php echo $icon_svg; ?>
					</a>
					<?php
				}
			} ?>
		</div>
		<?php

		$html = ob_get_clean();
		
		$html = apply_filters('monawp_share_box_element_html_filter', $html);

		return array('html' => $html);
	}

	public static function monawp_entry_comments_number_element() {
		$comment_count = get_comments_number();
		
		$svg_no_comments = Icons::getSVGContents('/fa/solid/comment-slash.svg');
		$svg_comment = Icons::getSVGContents('/fa/solid/comment.svg');
		$svg_comments = Icons::getSVGContents('/fa/solid/comments.svg');

		ob_start();
		if ( comments_open() ) {
			?>
			<div class="comments-link" itemprop="interactionCount">
			
				<?php
					echo ($comment_count == 0) ? $svg_no_comments : (($comment_count == 1) ? $svg_comment : $svg_comments);
				?>
				
				<a href="<?php echo esc_url( get_permalink() ); ?>#comments" aria-label="<?php echo esc_attr( sprintf( _n( '%d Comment', '%d Comments', $comment_count, 'monawp' ), $comment_count ) ); ?>">
					<?php
					// translators: Number of comments displayed in the comments link
					printf( _n( '%d Comment', '%d Comments', $comment_count, 'monawp' ), $comment_count );
					?>
				</a>
			</div>
			<?php
		}
		$html = ob_get_clean();
		$html = apply_filters('monawp_entry_comments_number_element_html_filter', $html);
		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_entry_read_time_element() {
		// Read time
		$words_per_minute = 238; // Adjust this value according to your preference
		$content = get_post_field( 'post_content', get_the_ID() );
		$word_count = str_word_count( strip_tags( $content ) );
		$read_time = ceil( $word_count / $words_per_minute );

		ob_start();
		?>
		<div class="read-time" >
			<?php
			// translators: Label for estimated read time
			echo '<span>';
			echo esc_html__('Read Time ~ ', 'monawp' );
			echo '</span>';
			echo ' <span '.Schema::getPart('read_time').'> ';
			printf(
				// translators: Number of minutes for estimated read time
				_n(
					'%d minute',
					'%d minutes',
					$read_time,
					'monawp'
				),
				$read_time
			);
			echo '</span>';
			?>
		</div>
		<?php

		$html = ob_get_clean();
		
		$html = apply_filters('monawp_entry_read_time_html_filter', $html);

		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_entry_author_box_element() {
		ob_start();
		?>
		<div class="flex-col author-box" <?php echo Schema::getPart('person'); ?>>
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
			</div>
			<div class="author-info">
				<h2 class="author-name">
					<?php echo get_the_author(); ?>
				</h2>
				<p class="author-bio">
					<?php the_author_meta( 'description' ); ?>
				</p>
				<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php
					/* translators: %s: author name */
					printf( esc_html__( 'More posts by %s', 'monawp' ), get_the_author() );
					?>
				</a>
			</div>
		</div>
		<?php

		$html = ob_get_clean();
		
		$html = apply_filters('monawp_entry_author_box_html_filter', $html);

		return array(
			'html' => $html,
		);
	}

	
	public static function monawp_entry_author_element() {
		ob_start();
		?>
		<div class="byline flex-row-vc" <?php echo Schema::getPart('person'); ?> >
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
				<path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/>
			</svg>
			<a aria-label="<?php echo esc_attr_x( 'Author', 'Used before post author name.', 'monawp' ); ?>" class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" itemprop="url"><?php echo get_the_author(); ?></a>
		</div>
		<?php

		$html = ob_get_clean();
		
		$html = apply_filters('monawp_entry_author_html_filter', $html);

		return array(
			'html' => $html,
		);
	}

	
	public static function monawp_entry_date_element() {
		// Initialize the time string based on whether the post has been updated or not
		if (get_the_time('U') !== get_the_modified_time('U')) {
			// Use the modified date if the post has been updated
			$time_string = '<time class="entry-date updated" datetime="%1$s">%2$s</time>';
			$time_string = sprintf($time_string,
				esc_attr(get_the_modified_date('c')),
				get_the_modified_date()
			);
		} else {
			// Use the published date if the post has not been updated
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			$time_string = sprintf($time_string,
				esc_attr(get_the_date('c')),
				get_the_date()
			);
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		ob_start();
		?>
		<div class="posted-on flex-row-vc" <?php echo Schema::getPart('date_published'); ?> >
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
				<path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/>
			</svg> 
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo $time_string; ?></a>
		</div>
		<?php

		$html = ob_get_clean();
		
		// Apply a filter to the HTML output
		$html = apply_filters('monawp_entry_date_html_filter', $html);

		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_entry_tags_element($numtags = null) {
		if (!function_exists('get_the_tags')) {
			return array(
				'html' => '',
			);
		}

		ob_start();

		// Hide category and tag text for pages.
		if (!is_page()) {
			// Tags
			$tags_list = get_the_tags();
			if ($tags_list) {
				?>
				<div class="tags-links flex-row-vc" >
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
						<path d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5V80C0 53.5 21.5 32 48 32H197.5c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
					</svg>
					<?php
					$tags_count = count($tags_list);
					$tags_to_display = $tags_list;
					if (!empty($numtags) && is_numeric($numtags) && $numtags < $tags_count) {
						$tags_to_display = array_slice($tags_list, 0, $numtags);
					}
					foreach ($tags_to_display as $tag) {
						printf(
							// translators: %1$s is url , %2$s is aria label, %3$s is tag name
							'<a href="%1$s" aria-label="%2$s">%3$s</a>',
							esc_url(get_tag_link($tag)),
							// translators: %s is tag name
							esc_attr(sprintf(__('Tag: %s', 'monawp'), $tag->name)),
							esc_html($tag->name)
						);
					}
					?>
				</div> <!-- Close tags-links -->
				<?php
			}
		}

		$html = ob_get_clean();
		
		$html = apply_filters('monawp_entry_tags_html_filter', $html);

		return array(
			'html' => $html,
		);
	}
	
	public static function monawp_entry_categories_element($numcategories = null) {
		if (!function_exists('get_the_category')) {
			return array(
				'html' => '',
			);
		}

		ob_start();

		// Categories
		$categories_list = get_the_category();
		if ($categories_list) {
			?>
			<div class="cat-links flex-row-vc" >
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
					<path d="M88.7 223.8L0 375.8V96C0 60.7 28.7 32 64 32H181.5c17 0 33.3 6.7 45.3 18.7l26.5 26.5c12 12 28.3 18.7 45.3 18.7H416c35.3 0 64 28.7 64 64v32H144c-22.8 0-43.8 12.1-55.3 31.8zm27.6 16.1C122.1 230 132.6 224 144 224H544c11.5 0 22 6.1 27.7 16.1s5.7 22.2-.1 32.1l-112 192C453.9 474 443.4 480 432 480H32c-11.5 0-22-6.1-27.7-16.1s-5.7-22.2 .1-32.1l112-192z"/>
				</svg>
				<?php
				$categories_count = count($categories_list);
				$categories_to_display = $categories_list;
				if (!empty($numcategories) && is_numeric($numcategories) && $numcategories < $categories_count) {
					$categories_to_display = array_slice($categories_list, 0, $numcategories);
				}
				foreach ($categories_to_display as $category) {
					printf(
						// translators: %1$s is url , %2$s is aria label, %3$s is category name
						'<a href="%1$s" aria-label="%2$s">%3$s</a>',
						esc_url(get_category_link($category)),
						// translators: %s is category name
						esc_attr(sprintf(__('Category: %s', 'monawp'), $category->name)),
						esc_html($category->name)
					);
				}
				?>
			</div> <!-- Close cat-links -->
			<?php
		}

		$html = ob_get_clean();
		
		$html = apply_filters('monawp_entry_categories_html_filter', $html);

		return array(
			'html' => $html,
		);
	}


	
	public static function monawp_entry_edit_button_element() {
		if ( !function_exists( 'edit_post_link' ) ) {
			return array(
				'html' => '',
			);
		}

		ob_start();

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <button class="screen-reader-text">%s</button>', 'monawp' ),
					array(
						'button' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<button class="edit-link">',
			'</button>'
		);

		$html = ob_get_clean();

		return array(
			'html' => $html,
		);
	}

	
}
?>