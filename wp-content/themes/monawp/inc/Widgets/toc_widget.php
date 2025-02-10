<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Mona_TOC_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'monawp_toc_widget', // Base ID
            esc_html__('Mona Table of Contents', 'monawp'), // Name
            array('description' => esc_html__('A custom lightweight table of contents widget.', 'monawp'))
        );
    }

    public function widget($args, $instance) {
		
		wp_enqueue_script('monawp-toc-js', get_template_directory_uri() . '/js/monawp-toc.min.js', array(), null, false);

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo '<h4>' . apply_filters('widget_title', $instance['title']) . '</h4>';
        }
        echo '<div class="monawp-toc-container"></div>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Table of Contents', 'monawp');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'monawp'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}


if ( ! function_exists( 'monawp_register_toc_widget' ) ) {
    function monawp_register_toc_widget() {
        register_widget('Mona_TOC_Widget');
    }
    add_action('widgets_init', 'monawp_register_toc_widget');
}


?>