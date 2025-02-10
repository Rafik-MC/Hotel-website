<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mona
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MonaWP\Resources\Schema as Schema;
?>

<?php echo MonaWP\Builder\Elements::monawp_scroll_to_top_element()['html']; 
	$post_id = get_the_ID();
	$disable_footer = get_post_meta( $post_id, '_monawp_disable_footer', true );
	if ( isset($disable_footer) and $disable_footer != '1' ) :
?>

	<footer role="contentinfo" <?php echo Schema::getPart('footer'); ?> id="colophon" class="site-footer monawp-site-footer">
		<div class="monawp-footer-inner-wrapper">
			<?php MonaWP\Hooks::monaFooter(); ?>
		</div>
	</footer><!-- #colophon -->
	
<?php endif; ?>
	
	<div class="copyright">
		<div class="site-info">
			<?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?> &copy; <?php echo date( 'Y' ); ?>. <?php _e( 'All Rights Reserved.', 'monawp' ); ?>
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'monawp' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'monawp' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<a href="<?php echo esc_url( __( 'https://monawp.com', 'monawp' ) ); ?>">
					<?php
					echo __('MonaWP Theme', 'monawp' );
					?>
				</a>
		</div><!-- .site-info -->
	</div>
	
</div><!-- #page -->

<?php wp_footer(); ?>
<?php MonaWP\Hooks::monaAfterFooter();?>
</body>
</html>
