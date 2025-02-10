<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mona
 */
use MonaWP\Resources\Schema as Schema;
?>

<article <?php echo Schema::getPart('article'); ?> id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php MonaWP\Hooks::monaMainContentSingular();?>
</article><!-- #post-<?php the_ID(); ?> -->