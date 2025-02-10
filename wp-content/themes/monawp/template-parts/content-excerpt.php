<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php MonaWP\Hooks::monaMainContent();?>
</article><!-- #post-<?php the_ID(); ?> -->