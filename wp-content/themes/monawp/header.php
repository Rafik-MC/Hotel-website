<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mona
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MonaWP\Resources\Schema as Schema;
global $monawp_customizer_defaults; 
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php 
	wp_head();  
	MonaWP\Hooks::monaAfterWpHead(); 
	?>
</head>

<body <?php echo Schema::getPart('body'); ?> <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'monawp' ); ?></a>
	<?php 
		$post_id = get_the_ID();
		$disable_header = get_post_meta( $post_id, '_monawp_disable_header', true );
		$enable_transparent_header = get_post_meta( $post_id, '_monawp_enable_transparent_header', true );
        $header_position = get_post_meta( $post_id, '_monawp_header_position', true );

        if ( isset($disable_header) and $disable_header != '1' ) :
            $header_classes = 'site-header monawp-header';
            if ( isset($enable_transparent_header) and $enable_transparent_header ) {
                $header_classes .= ' transparent';
            }
            if ( ! $header_position || $header_position == 'Inherit' ) {
                if ( get_theme_mod('monawp_header_panel_layout_sticky_header_global', $monawp_customizer_defaults['monawp_sticky_header']) ) {
                    $header_classes .= ' sticky-header';
                }
            } elseif ( $header_position == 'Sticky' ) {
                $header_classes .= ' sticky-header';
            }

			if ( get_theme_mod('monawp_topbar_panel_layout_enable', $monawp_customizer_defaults['monawp_topbar_enable']) ) :
        ?>
		
		<div class="header-topbar">
            <div class="monawp-topbar-inner-wrapper">
                <?php MonaWP\Hooks::monaTopbar(); ?>
            </div>
		</div>
        <?php endif; ?>
        <header role="banner" <?php echo Schema::getPart('header'); ?> id="masthead" class="<?php echo esc_attr($header_classes); ?>">
            <div class="monawp-header-inner-wrapper">
                <?php MonaWP\Hooks::monaHeader(); ?>
            </div>
        </header><!-- #masthead -->
        
<?php endif; MonaWP\Hooks::monaAfterHeader(); ?>