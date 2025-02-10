<?php

namespace MonaWP;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MonaWP\Builder\Elements as Elements;
use MonaWP\Resources\Schema as Schema;
use MonaWP\Resources\Helpers as Helpers; 

class HookConstructor {
    
    public static function constructWithSequence($prefix) {
		
		global $monawp_default_layouts_array;
		
        // Loop through each setting
        $theme_mods = get_theme_mods();
		global $monawp_structure_defaults;
		
        $array_items = array_filter($monawp_structure_defaults, function($item) use ($prefix) {
            return $item['panel'] === $prefix;
        });
		
		//echo count($array_items);
		$count_2x = count($array_items) * 2;

        for ($i = 0; $i <= $count_2x - 1; $i++) {
			if (isset($monawp_default_layouts_array[$prefix][$i])) {
				$default_value = $monawp_default_layouts_array[$prefix][$i];
				//echo $default_value;
			} else {
				$default_value = '';
				//echo $default_value;
			}
            $selected_element = get_theme_mod('monawp_' . $prefix . '_panel_builder_'.$i, $default_value);
			//echo $selected_element2;
			if ($selected_element === 'row-start' and ($prefix != 'header' and $prefix != 'topbar')) {
                echo "<div class='flex-row flex-col-tablet'>";
            } else if ($selected_element === 'row-start' and ($prefix == 'header' || $prefix == 'topbar')) {
                echo "<div class='flex-row-vc flex-col-tablet'>";
            } 

			if ($selected_element === 'col-start') {
                echo "<div class='flex-col'>";
            }
            
            // Handle selected element's HTML
            if (!empty($selected_element)) {
                switch ($prefix) {
                case 'topbar':
                    switch ($selected_element) {
                        case 'monawp_site_logo_topbar':
                            echo Elements::html_wrapper(Elements::monawp_site_logo_element()['html'], 'monawp_site_logo_element');
                            break;
                        case 'monawp_site_title_topbar':
                            echo Elements::html_wrapper(Elements::monawp_site_title_element()['html'], 'monawp_site_title_element');
                            break;
                        case 'monawp_site_description_topbar':
                            echo Elements::html_wrapper(Elements::monawp_site_description_element()['html'], 'monawp_site_description_element');
                            break;
                        case 'monawp_horizontal_menu_topbar':
                            echo Elements::html_wrapper(Elements::monawp_topbar_horizontal_menu_element()['html'], 'monawp_header_horizontal_menu_element');
                            break;
                        case 'monawp_generic_info_topbar':
                            echo Elements::html_wrapper(Elements::monawp_generic_info_element("icons")['html'], 'monawp_generic_info_element flex-row-vc" '.Schema::getPart('organization').' ');
                            break;
                        case 'monawp_socials_topbar':
                            echo Elements::html_wrapper(Elements::monawp_socials_element("icons")['html'], 'monawp_socials_element flex-row-vc');
                            break;
                        case 'monawp_search_topbar':
                            echo Elements::html_wrapper(Elements::monawp_search_element()['html'], 'monawp_search_element');
                            break;
                        case (preg_match('/monawp_widget_(\d+)_topbar/', $selected_element, $matches) ? true : false):
                            $widget_number = $matches[1];
                            echo Elements::html_wrapper(Elements::monawp_topbar_widget_element($widget_number)['html'], 'widget__element');
                            break;
                        default:
                            break;
                    }
                    break;
                    case 'header':
                        switch ($selected_element) {
                            case 'monawp_site_logo_header':
                                echo Elements::html_wrapper(Elements::monawp_site_logo_element()['html'], 'monawp_site_logo_element');
                                break;
                            case 'monawp_site_title_header':
                                echo Elements::html_wrapper(Elements::monawp_site_title_element()['html'], 'monawp_site_title_element');
                                break;
                            case 'monawp_site_description_header':
                                echo Elements::html_wrapper(Elements::monawp_site_description_element()['html'], 'monawp_site_description_element');
                                break;
                            case 'monawp_horizontal_menu_header':
                                echo Elements::html_wrapper(Elements::monawp_header_horizontal_menu_element()['html'], 'monawp_header_horizontal_menu_element');
                                break;
                            case 'monawp_generic_info_header':
                                echo Elements::html_wrapper(Elements::monawp_generic_info_element("icons")['html'], 'monawp_generic_info_element flex-row-vc" '.Schema::getPart('organization').' ');
                                break;
                            case 'monawp_socials_header':
                                echo Elements::html_wrapper(Elements::monawp_socials_element("icons")['html'], 'monawp_socials_element flex-row-vc');
                                break;
                            case 'monawp_search_header':
                                echo Elements::html_wrapper(Elements::monawp_search_element()['html'], 'monawp_search_element');
                                break;
							case (preg_match('/monawp_widget_(\d+)_header/', $selected_element, $matches) ? true : false):
								$widget_number = $matches[1];
								echo Elements::html_wrapper(Elements::monawp_header_widget_element($widget_number)['html'], 'widget__element');
								break;
                            default:
                                break;
                        }
                        break;
                    case 'footer':
                        switch ($selected_element) {
                            case 'monawp_site_logo_footer':
                                echo Elements::html_wrapper(Elements::monawp_site_logo_element()['html'], 'monawp_site_logo_element');
                                break;
                            case 'monawp_site_title_footer':
                                echo Elements::html_wrapper(Elements::monawp_site_title_element()['html'], 'monawp_site_title_element');
                                break;
                            case 'monawp_site_description_footer':
                                echo Elements::html_wrapper(Elements::monawp_site_description_element()['html'], 'monawp_site_description_element');
                                break;
                            case 'monawp_horizontal_menu_footer':
                                echo Elements::html_wrapper(Elements::monawp_footer_horizontal_menu_element()['html'], 'monawp_footer_horizontal_menu_element');
                                break;
                            case 'monawp_search_footer':
                                echo Elements::html_wrapper(Elements::monawp_search_element()['html'], 'monawp_search_element');
                                break;
                            case 'monawp_generic_info_footer':
                                echo Elements::html_wrapper(Elements::monawp_generic_info_element("icons")['html'], 'monawp_generic_info_element flex-row-vc');
                                break;
                            case 'monawp_socials_footer':
                                echo Elements::html_wrapper(Elements::monawp_socials_element("icons")['html'], 'monawp_socials_element flex-row-vc');
                                break;
							case (preg_match('/monawp_widget_(\d+)_footer/', $selected_element, $matches) ? true : false):
								$widget_number = $matches[1];
								echo Elements::html_wrapper(Elements::monawp_footer_widget_element($widget_number)['html'], 'widget__element');
								break;
                            default:
                                // Handle default case if necessary
                                break;
                        }
                        break;
                    default:
                        // Handle default case if necessary
                        break;
                }
            }

            // Handle wrapper end if necessary
            if ($selected_element === 'wrapper-end') {
                echo "</div>";
            }
        }
    }
	
	public static function constructPredefined($layout_id='',$lazy=false) {
		global $monawp_singular_pages;
		global $monawp_singular_pages_items;
		global $monawp_thumbnail_choices;
		global $monawp_customizer_defaults;
		global $monawp_pages_with_excerpt;
		
		foreach ($monawp_pages_with_excerpt as $page_slug => $page_name) {
			if (Helpers::checkPageCondition($page_slug) and get_theme_mod('monawp_' . $page_slug . '_panel_layout_featured_thumbnail_size', $monawp_customizer_defaults['monawp_layout_featured_thumbnail_size']) != '') {
				//echo get_theme_mod('monawp_' . $page_slug . '_panel_layout_featured_thumbnail_size', $monawp_customizer_defaults['monawp_layout_featured_thumbnail_size']);
				$entry_post_thumbnail = Elements::html_wrapper(Elements::monawp_post_thumbnail_element(get_theme_mod('monawp_' . $page_slug . '_panel_layout_featured_thumbnail_size', $monawp_customizer_defaults['monawp_layout_featured_thumbnail_size']), $lazy)['html'], 'monawp_post_thumbnail_element');
				break;
			} else {
				$entry_post_thumbnail = '';
			}
		}

		$entry_post_thumbnail_single = Elements::html_wrapper(Elements::monawp_post_thumbnail_element('monawp_large_thumbnail', $lazy)['html'], 'monawp_post_thumbnail_element');
		$entry_title = Elements::html_wrapper(Elements::monawp_entry_title_element()['html'], 'monawp_entry_title_element');
		$entry_comments_count = Elements::html_wrapper(Elements::monawp_entry_comments_number_element()['html'], 'monawp_entry_comments_number_element');
		$entry_read_time = Elements::html_wrapper(Elements::monawp_entry_read_time_element()['html'], 'monawp_entry_read_time_element');
		$entry_author = Elements::html_wrapper(Elements::monawp_entry_author_element()['html'], 'monawp_entry_author_element');
		$entry_tags = Elements::html_wrapper(Elements::monawp_entry_tags_element()['html'], 'monawp_entry_tags_element');
		$entry_tag = Elements::html_wrapper(Elements::monawp_entry_tags_element(2)['html'], 'monawp_entry_tags_element');
		$entry_categories = Elements::html_wrapper(Elements::monawp_entry_categories_element()['html'], 'monawp_entry_categories_element');
		$entry_category = Elements::html_wrapper(Elements::monawp_entry_categories_element(2)['html'], 'monawp_entry_categories_element');
		$entry_date = Elements::html_wrapper(Elements::monawp_entry_date_element()['html'], 'monawp_entry_date_element');
		$entry_breadcrumbs = Elements::html_wrapper(Elements::monawp_entry_breadcrumbs_element()['html'], 'monawp_breadcrumbs_element');
		$entry_post_navigation = Elements::html_wrapper(Elements::monawp_post_navigation_element()['html'], 'monawp_post_navigation_element');
		$entry_similar_posts = Elements::html_wrapper(Elements::monawp_similar_posts_element()['html'], 'monawp_similar_posts_element');
		$entry_sharebox = Elements::html_wrapper(Elements::monawp_sharebox_element()['html'], 'monawp_sharebox_element');
		$entry_comments = Elements::html_wrapper(Elements::monawp_comments_form_element()['html'], 'monawp_comments_form_element');
		$entry_author_box = Elements::html_wrapper(Elements::monawp_entry_author_box_element()['html'], 'monawp_entry_author_box_element');

		switch ($layout_id) {
			
			case 'main_content_1':
				ob_start();
				?>
				
				<header class="entry-header">
				
					<?php if ($entry_category) : ?>
						<div class="flex-row-vc">
							<?php echo $entry_category; ?>
						</div>
					<?php endif;?>
					
					<?php echo $entry_title; ?> 
					
					<div class="flex-row-vc">
						<?php 
							echo $entry_date;
							echo $entry_comments_count; 
						?>
						<!-- Add other elements here -->
					</div>
				</header><!-- .entry-header -->
				
				<?php
					echo $entry_post_thumbnail;
				?>
				
				<div class="monawp-element-wrapper">
					<div class="entry-content" <?php echo Schema::getPart('excerpt'); ?>>
						<?php
						the_excerpt(); // Display the excerpt instead of the full content

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'monawp' ),
								'after'  => '</div>',
							)
						);
						?>
					</div><!-- .entry-content -->	
				</div>
				
				<footer class="entry-footer">
					<div class="flex-row-vc">
						<?php 
							echo $entry_author;
							echo $entry_tag; 
							echo $entry_read_time;
						?>
					</div>
				</footer><!-- .entry-footer -->
				
				<?php
				$layout = ob_get_clean();
				echo $layout;
				break;
			case 'main_content_2':
				ob_start();
				?>
				
				<?php
					echo $entry_post_thumbnail;
				?>
				
				<header class="entry-header">
					
					<?php echo $entry_title; ?> 
					
					<div class="flex-row-vc">
						<?php 
							echo $entry_date;
							echo $entry_comments_count; 
						?>
						<!-- Add other elements here -->
					</div>
				</header><!-- .entry-header -->
				
				<div class="monawp-element-wrapper">
					<div class="entry-content" <?php echo Schema::getPart('excerpt'); ?>>
						<?php
						the_excerpt(); // Display the excerpt instead of the full content

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'monawp' ),
								'after'  => '</div>',
							)
						);
						?>
					</div><!-- .entry-content -->	
				</div>
				
				<footer class="entry-footer">
					<div class="flex-row-vc">
						<?php 
							echo $entry_category;
							echo $entry_author;
							echo $entry_tag; 
							echo $entry_read_time;
						?>
					</div>
				</footer><!-- .entry-footer -->
				
				<?php
				$layout = ob_get_clean();
				echo $layout;
				break;
			case 'main_content_3':
				ob_start();
				?>
				
				<?php
					echo $entry_post_thumbnail;
				?>
	
				<header class="entry-header">
					
					<?php echo $entry_title; ?> 
					<div class="flex-row">
						<div class="flex-col">
							<?php 
								echo $entry_date;
								echo $entry_author;
							?>
							<!-- Add other elements here -->
						</div>
						<div class="flex-col">
							<?php 
								echo $entry_category;
								echo $entry_comments_count; 
							?>
						</div>
					</div>
				</header><!-- .entry-header -->

				<footer class="entry-footer">
					<div class="flex-col">
						<?php 
							echo $entry_tag; 
							echo $entry_read_time;
						?>
					</div>
				</footer><!-- .entry-footer -->
				
				<div class="monawp-element-wrapper">
					<div class="entry-content" <?php echo Schema::getPart('excerpt'); ?>>
						<?php
						the_excerpt(); // Display the excerpt instead of the full content

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'monawp' ),
								'after'  => '</div>',
							)
						);
						?>
					</div><!-- .entry-content -->	
				</div>
				
				<?php
				$layout = ob_get_clean();
				echo $layout;
				break;
			case 'main_content_4':
				ob_start();
				?>
				
				<?php echo $entry_title; ?> 
				
				<div class="monawp-element-wrapper">
					<div class="entry-content" <?php echo Schema::getPart('excerpt'); ?>>
						<?php
						the_excerpt(); // Display the excerpt instead of the full content

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'monawp' ),
								'after'  => '</div>',
							)
						);
						?>
					</div><!-- .entry-content -->	
				</div>
				
				<?php
					echo $entry_post_thumbnail;
				?>
				
				<header class="entry-header">
					
					<div class="flex-row-vc">
						<?php 
							echo $entry_date;
							echo $entry_comments_count; 
							echo $entry_read_time;
						?>
						<!-- Add other elements here -->
					</div>
				</header><!-- .entry-header -->

				<footer class="entry-footer">
					<div class="flex-row-vc">
						<?php 
							echo $entry_category;
							echo $entry_author;
							echo $entry_tag; 
						?>
					</div>
				</footer><!-- .entry-footer -->
				
				<?php
				$layout = ob_get_clean();
				echo $layout;
				break;
			case 'main_content_singular_1':
				ob_start();
				if (is_single() and get_theme_mod('monawp_single_post_panel_layout_show_breadcrumbs', $monawp_singular_pages_items['breadcrumbs']['default'])) {
					echo $entry_breadcrumbs; 
				}
				if (is_page() and get_theme_mod('monawp_page_panel_layout_show_breadcrumbs', $monawp_singular_pages_items['breadcrumbs']['default_page']) and !Helpers::isWooCommercePage()) {
					echo $entry_breadcrumbs; 
				}
				if (is_single()) {
					\MonaWP\Hooks::monaSinglePostBeforeEntryHeader();
				}
				?>
				<header class="entry-header">
					<?php echo $entry_title; 
					if (is_single()) :
					?> 
						<div class="flex-row-vc">
							<?php 
								echo $entry_author;
								echo $entry_date;
								echo $entry_comments_count; 
								if (!Helpers::isWooCommercePage()) {
									echo $entry_read_time;
								}
							?>
							<!-- Add other elements here -->
						</div>
					<?php endif; ?>
				</header><!-- .entry-header -->
				
				<?php
				
				if (is_single()) {
					\MonaWP\Hooks::monaSinglePostAfterEntryHeader();
				}
				
				if (!Helpers::isWooCommercePage()) {
					echo $entry_post_thumbnail_single;
				}
				
				if (is_single() and get_theme_mod('monawp_single_post_panel_layout_show_content_start_sharebox', $monawp_singular_pages_items['content_start_sharebox']['default'])) {
					echo $entry_sharebox;
				} else if (is_page() and get_theme_mod('monawp_page_panel_layout_show_content_start_sharebox', $monawp_singular_pages_items['content_start_sharebox']['default_page']) and !Helpers::isWooCommerceMiscPage()) {
					echo $entry_sharebox;
				}
				?>
				
				<div class="monawp-element-wrapper">
					<div <?php echo Schema::getPart('article_body'); ?> class="entry-content">
						<?php
						the_content(); // Display the excerpt instead of the full content

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'monawp' ),
								'after'  => '</div>',
							)
						);
						?>
					</div><!-- .entry-content -->	
				</div>
				
				
				
				<?php
				
					
				
					if (is_single() and get_theme_mod('monawp_single_post_panel_layout_show_content_end_sharebox', $monawp_singular_pages_items['content_end_sharebox']['default'])) {
						echo $entry_sharebox;
					} else if (is_page() and get_theme_mod('monawp_page_panel_layout_show_content_end_sharebox', $monawp_singular_pages_items['content_end_sharebox']['default_page']) and !Helpers::isWooCommerceMiscPage()) {
						echo $entry_sharebox;
					}
					
					if (is_single() and get_theme_mod('monawp_single_post_panel_layout_show_author_box', $monawp_singular_pages_items['author_box']['default']) and !Helpers::isWooCommercePage()) {
						echo $entry_author_box;
					}
					if (is_single()) :
						if ($entry_tags or $entry_categories) :
					?>
					
					<footer class="entry-footer">
						<div class="flex-row-vc">
							<?php 
								echo $entry_tags; 
								echo $entry_categories; 
							?>
						</div>
					</footer><!-- .entry-footer -->
					
					<?php 
					endif;
					endif;
					if ((is_single() or Helpers::isWooCommerceSingleProduct()) and !Helpers::isWooCommerceArchive()) {
						echo $entry_post_navigation; 
					}
					if (is_single() and get_theme_mod('monawp_single_post_panel_layout_show_similar_posts', $monawp_singular_pages_items['similar_posts']['default'])) {
						echo $entry_similar_posts;
					}
					echo $entry_comments;
				?>
				<?php
				$layout = ob_get_clean();
				echo $layout;
				break;
			default:
				// Default case if layout ID doesn't match any predefined layouts
				break;
		}
	}
}
?>