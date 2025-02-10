<?php 

namespace MonaWP;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Hooks {

    public static function monaTopbar() {
        do_action('monawp_topbar');
    }

    public static function monaHeader() {
        do_action('monawp_header');
    }
	
    public static function monaAfterWpHead() {
        do_action('monawp_after_wp_head');
    }
	
    public static function monaAfterHeader() {
        do_action('monawp_after_header');
    }
	
    public static function monaMainContent() {
        do_action('monawp_main_content');
    }
	
    public static function monaSinglePostBeforeEntryHeader() {
        do_action('monawp_single_post_before_entry_header');
    }
	
    public static function monaSinglePostAfterEntryHeader() {
        do_action('monawp_single_post_after_entry_header');
    }
	
    public static function monaMainContentSingular() {
        do_action('monawp_main_content_singular');
    }
	
    public static function monaFooter() {
        do_action('monawp_footer');
    }
	
    public static function monaAfterFooter() {
        do_action('monawp_after_footer');
    }
}
?>