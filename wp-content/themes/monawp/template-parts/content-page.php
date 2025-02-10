<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mona
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php MonaWP\Hooks::monaMainContentSingular();?>
</article><!-- #post-<?php the_ID(); ?> -->