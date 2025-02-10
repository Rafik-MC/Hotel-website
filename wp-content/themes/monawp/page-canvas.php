<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
Template Name:Canvas
*/
get_header();
?>
<main id="primary" class="site-main" role="main">
<?php
the_content();
?>
</main><!-- #main -->
<?php
get_footer();
?>