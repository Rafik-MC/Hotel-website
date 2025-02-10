<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MonaWP\Builder\Elements as Elements;

class Mona_Element_Widget extends WP_Widget {

    // Constructor
    public function __construct() {
        parent::__construct(
            'monawp_element_widget', // Base ID
            __('Mona Element Widget', 'monawp'), // Widget name
            array( 'description' => __( 'Display various Mona elements.', 'monawp' ), ) // Widget description
        );
    }

    // Widget output
    public function widget( $args, $instance ) {
        $selected_option = isset( $instance['selected_option'] ) ? $instance['selected_option'] : 'monawp_socials_element';
        echo $args['before_widget'];
        echo $this->get_element_html( $selected_option );
        echo $args['after_widget'];
    }

    // Widget form
    public function form( $instance ) {
        $selected_option = isset( $instance['selected_option'] ) ? $instance['selected_option'] : 'monawp_socials_element';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'selected_option' ); ?>"><?php _e( 'Select Element:', 'monawp' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'selected_option' ); ?>" name="<?php echo $this->get_field_name( 'selected_option' ); ?>">
                <option value="monawp_socials_element" <?php selected( $selected_option, 'monawp_socials_element' ); ?>><?php _e( 'Mona Socials Element', 'monawp' ); ?></option>
                <option value="monawp_search_element" <?php selected( $selected_option, 'monawp_search_element' ); ?>><?php _e( 'Mona Search Element', 'monawp' ); ?></option>
                <option value="monawp_entry_breadcrumbs_element" <?php selected( $selected_option, 'monawp_entry_breadcrumbs_element' ); ?>><?php _e( 'Mona Breadcrumbs Element', 'monawp' ); ?></option>
                <option value="monawp_similar_posts_element" <?php selected( $selected_option, 'monawp_similar_posts_element' ); ?>><?php _e( 'Mona Similar Posts Element', 'monawp' ); ?></option>
                <option value="monawp_sharebox_element" <?php selected( $selected_option, 'monawp_sharebox_element' ); ?>><?php _e( 'Mona Sharebox Element', 'monawp' ); ?></option>
                <!-- Add more options as needed -->
            </select>
        </p>
        <?php
    }

    // Widget update
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['selected_option'] = ( ! empty( $new_instance['selected_option'] ) ) ? strip_tags( $new_instance['selected_option'] ) : 'monawp_socials_element';
        return $instance;
    }

    // Function to get element HTML based on selected option
    private function get_element_html( $selected_option ) {
        switch ( $selected_option ) {
            case 'monawp_socials_element':
                return $this->get_monawp_socials_element_html();
            case 'monawp_search_element':
                return $this->get_monawp_search_element_html();
            case 'monawp_entry_breadcrumbs_element':
                return $this->get_monawp_entry_breadcrumbs_element_html();
            case 'monawp_similar_posts_element':
                return $this->get_monawp_similar_posts_element_html();
            case 'monawp_sharebox_element':
                return $this->get_monawp_sharebox_element_html();
            // Add more cases for additional elements
            default:
                return '';
        }
    }

    // Function to get Mona Socials Element HTML
    private function get_monawp_socials_element_html() {
        return Elements::html_wrapper( Elements::monawp_socials_element( 'icons' )['html'], 'monawp_socials_element flex-row-vc' );
    }

    // Function to get Mona Search Element HTML
    private function get_monawp_search_element_html() {
        return Elements::html_wrapper( Elements::monawp_search_element()['html'], 'monawp_search_element' );
    }

    // Function to get Mona Breadcrumbs Element HTML
    private function get_monawp_entry_breadcrumbs_element_html() {
        return Elements::html_wrapper( Elements::monawp_entry_breadcrumbs_element()['html'], 'monawp_breadcrumbs_element' );
    }

    // Function to get Mona Similar Posts Element HTML
    private function get_monawp_similar_posts_element_html() {
        return Elements::html_wrapper( Elements::monawp_similar_posts_element()['html'], 'monawp_similar_posts_element' );
    }

    // Function to get Mona Sharebox Element HTML
    private function get_monawp_sharebox_element_html() {
        return Elements::html_wrapper( Elements::monawp_sharebox_element()['html'], 'monawp_sharebox_element' );
    }
}

// Register the custom widget
if ( ! function_exists( 'monawp_register_element_widget' ) ) {
	function monawp_register_element_widget() {
		register_widget( 'Mona_Element_Widget' );
	}
	add_action( 'widgets_init', 'monawp_register_element_widget' );
}
?>